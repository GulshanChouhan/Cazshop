<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Support extends CI_Controller {

	public function __construct(){
        parent::__construct();
    }

    private function _check_login(){
		if(user_logged_in()===FALSE){
			redirect('page/login');
		}else{
			$info = $this->common_model->get_row('users',array('user_id'=>user_id()));
	    	if(empty($info)){
	    		$this->cart->destroy();
				$this->session->unset_userdata('shipping_address_id');
				$this->session->unset_userdata('user_info');
				redirect('page/login');
	    	}
		}
	}

	public function messages($message_id='')
	{
		$this->_check_login(); //check  login authentication 
		$data['title']='Support Messages';
		if(user_logged_in()){
		  $data['user_info'] = $this->common_model->get_row('users',array('user_id'=>user_id()));
		} 
		$data['support'] = $this->common_model->get_result('support',array('user_id'=>user_id(),'parent_id'=>0,'mark_complete'=>0),array(),array('support_id','DESC'));
		$data['is_complete'] = 0;
		if($data['complete'] = $this->common_model->get_result('support',array('user_id'=>user_id(),'parent_id'=>0,'mark_complete'=>1)))
		{
			$data['is_complete'] = 1;
		}
		if($message_id){
			if(!$support_details = $this->common_model->get_row('support',array('user_id'=>user_id(),'parent_id'=>0,'mark_complete'=>0,'support_id'=>$message_id),array(),array('support_id','DESC'))){
				$this->session->set_flashdata('theme_danger','This ticket isn\'t available in our records');
				 redirect('support/messages/');
			}
		}
		if($data['support']){
		   if(!$message_id){
			  $message_id=$data['support'][0]->support_id;
		   }
		   $this->form_validation->set_rules('reply', 'Reply', 'required|trim');
		   $this->form_validation->set_error_delimiters('<div class="meditory-error">', '</div>');
		   if($this->form_validation->run() == TRUE){
			   $data_insert=
			   	array('user_id'=>user_id(),
					'parent_id'=>$message_id,
					'message'=>strip_tags($this->input->post('reply')),
					'user_role'=>'0',
					'status'=>'0',
					'created'=>  date('Y-m-d H:i:s')
				);
			  if($this->common_model->insert('support',$data_insert))
			  {

			  	//-------------For Send email AND SMS-----------

    			$email_template = $this->common_model->get_row('email_templates', array('id'=>8));
    			if(!empty($email_template)){
        			
        			//==-----------===Send Email==-----------
        			if($email_template->template_email_enable==1){

		    			$userRole  = 0; //for Admin
		    			$adminEMAIl= get_option_url('EMAIl');
		    			$to 	   = (!empty($adminEMAIl)) ? $adminEMAIl : SUPPORT_EMAIL;
		    			$param 	   = array(
		    				'site_name'  	  => SITE_NAME,
		    				'user_role'       => "Customer",
		                    'ticket_no'       => $support_details->ticket_no,
		                    'name'            => ucwords($support_details->firstname),
		                    'subject'         => feedback_subject_status($support_details->reason),
		                    'msg'             => strip_tags($this->input->post('reply')),
		                    'contactus_link'  => base_url('page/contact')
		                );
		    			$sendEmailAdmin = sendEmail($email_template, $to, $param, $userRole);
		    		}

		    		//==-----------===Send SMS==-----------===
		    		if($email_template->template_sms_enable==1){

		    			$userRole  = 0; //for Admin
		    			$to 	   = get_option_url('PHONE');
		    			$param 	   = array(
		    				'site_name'  	  => SITE_NAME,
		    				'user_role'       => "Customer",
		                    'ticket_no'       => $support_details->ticket_no,
		                    'name'            => ucwords($support_details->firstname),
		                    'subject'         => feedback_subject_status($support_details->reason),
		                    'msg'             => strip_tags($this->input->post('reply')),
		                    'contactus_link'  => base_url('page/contact')
		                );
		    			$sendSMSAdmin = sendSMS($email_template, $to, $param, $userRole);
		    		}

		    	}
                //-------------**For Send email AND SMS-----------

				 $this->session->set_flashdata('theme_success','Message has been sent successfully');
				 redirect('support/messages/'.$message_id);
			  }else{
				 $this->session->set_flashdata('theme_danger','Sorry! Message not sent. please try again');
				 redirect('support/messages/'.$message_id);
			  }
		   }
		   $msg_to_update_data=array(
				'user_id'=>user_id(),
				'user_role'=>2,
				'parent_id'=>$message_id,
				'status'=>0
			);
		   $this->common_model->update('support',array('status'=>1), $msg_to_update_data);
		   $data['support_detail'] = $this->common_model->get_message_thread($message_id,user_id());
		}
		$data['message_id']=$message_id;
		$data['template']='frontend/support/support_messages';
		$this->load->view('templates/frontend/front_template',$data); 
	}


	public function support($subject='')
    {   
		$data['title']='Support Messages';
		if(user_logged_in()){
			$data['user_info'] = $this->common_model->get_row('users',array('user_id'=>user_id()));
		} 
		$data['reason'] ='';
		//$data['title_top']='CONTACT US'; 
		if(!user_logged_in()){ 
			$this->form_validation->set_rules('firstname', 'First Name', 'required|alpha_numeric_spaces');
			$this->form_validation->set_rules('lastname', 'Last Name', 'required|alpha_numeric_spaces');
			$this->form_validation->set_rules('email','Email','required|valid_email|trim');
			$this->form_validation->set_rules('mobile','support','Contact Number', 'required|trim');
		}
		$this->form_validation->set_rules('reason','Reason', 'required|trim');
		$this->form_validation->set_rules('message', 'message', 'required|trim|max_length[2000]');

		$this->form_validation->set_error_delimiters('<div class="meditory-error">', '</div>');
		if ($this->form_validation->run() == TRUE)  {
		if(user_logged_in()){
			$user_data['user_id']= user_id();
			$user_data['firstname'] = $data['user_info']->user_name;
			$user_data['lastname'] = $data['user_info']->last_name;
			$user_data['email']= $data['user_info']->email;
			$user_data['mobile'] = $data['user_info']->mobile;
		}else {
			$user_data['firstname']=  $this->input->post('firstname');
			$user_data['lastname'] =  $this->input->post('lastname');
			$user_data['email']  =  $this->input->post('email');
			$user_data['mobile'] =  $this->input->post('mobile');
		}

		$ticket_no = $this->getTicket_No();
		$user_data['ticket_no'] = $ticket_no;
		$user_data['message']=  strip_tags($this->input->post('message'));
		$user_data['reason']=  $this->input->post('reason');
		$user_data['created']=  date('Y-m-d H:i:s');
		$user_data['user_ip']  =  $this->input->ip_address();
		$user_data['user_role']=0;

			if($user_id=$this->common_model->insert('support', $user_data)){

				//-------------For Send email AND SMS-----------

    			$email_template = $this->common_model->get_row('email_templates', array('id'=>7));
    			if(!empty($email_template)){
        			
        			//==-----------===Send Email==-----------
        			if($email_template->template_email_enable==1){

		    			$userRole  = 2; //for Customer
		    			$to 	   = $user_data['email'];
		    			$param 	   = array(
		    				'site_name'  	  => SITE_NAME,
		    				'user_role'       => "Customer",
		                    'ticket_no'       => $ticket_no,
		                    'name'            => ucwords($user_data['firstname']),
		                    'email'           => $user_data['email'],
		                    'mobile_no'       => $user_data['mobile'],
		                    'subject'         => feedback_subject_status($user_data['reason']),
		                    'msg'             => $user_data['message'],
		                    'contactus_link'  => base_url('page/contact')
		                );
		    			$sendEmail = sendEmail($email_template, $to, $param, $userRole);


		    			$userRole  = 0; //for Admin
		    			$adminEMAIl= get_option_url('EMAIl');
		    			$to 	   = (!empty($adminEMAIl)) ? $adminEMAIl : SUPPORT_EMAIL;
		    			$param 	   = array(
		    				'site_name'  	  => SITE_NAME,
		    				'user_role'       => "Customer",
		                    'ticket_no'       => $ticket_no,
		                    'name'            => ucwords($user_data['firstname']),
		                    'email'           => $user_data['email'],
		                    'mobile_no'       => $user_data['mobile'],
		                    'subject'         => feedback_subject_status($user_data['reason']),
		                    'msg'             => $user_data['message'],
		                    'contactus_link'  => base_url('page/contact')
		                );
		    			$sendEmailAdmin = sendEmail($email_template, $to, $param, $userRole);
		    		}

		    		//==-----------===Send SMS==-----------===
		    		if($email_template->template_sms_enable==1){

		    			$userRole  = 2; //for Customer
		    			$to 	   = $user_data['mobile'];
		    			$param 	   = array(
		    				'site_name'  	  => SITE_NAME,
		    				'user_role'       => "Customer",
		                    'ticket_no'       => $ticket_no,
		                    'name'            => ucwords($user_data['firstname']),
		                    'email'           => $user_data['email'],
		                    'mobile_no'       => $user_data['mobile'],
		                    'subject'         => feedback_subject_status($user_data['reason']),
		                    'msg'             => $user_data['message'],
		                    'contactus_link'  => base_url('page/contact')
		                );
		    			$sendSMS = sendSMS($email_template, $to, $param, $userRole);


		    			$userRole  = 0; //for Admin
		    			$to 	   = get_option_url('PHONE');
		    			$param 	   = array(
		    				'site_name'  	  => SITE_NAME,
		    				'user_role'       => "Customer",
		                    'ticket_no'       => $ticket_no,
		                    'name'            => ucwords($user_data['firstname']),
		                    'email'           => $user_data['email'],
		                    'mobile_no'       => $user_data['mobile'],
		                    'subject'         => feedback_subject_status($user_data['reason']),
		                    'msg'             => $user_data['message'],
		                    'contactus_link'  => base_url('page/contact')
		                );
		    			$sendSMSAdmin = sendSMS($email_template, $to, $param, $userRole);
		    		}

		    	}
                //-------------**For Send email AND SMS-----------

				$this->session->set_flashdata('theme_success','Thank you for contacting us! Your inquiry is submitted and will respond to you as soon as possible');
				if(user_logged_in())
				  redirect('support/messages/'.$user_id); 
				else 
				  redirect('support/support');
			}else{
				$this->session->set_flashdata('theme_danger','Sorry! Inquiry request process has been failed. please try again');
				redirect('support/support');
			}
		} 
		if($subject==7) {
			$data['reason'] = 7;
		}
		if($subject==12) {
			$data['reason'] = 12;
		}
		$data['template']='frontend/support/support';
		$this->load->view('templates/frontend/front_template',$data); 
   }



   public function support_account_popup($subject='')
   {   
		$data['title']='Support Messages';
		if(user_logged_in()){
			$data['user_info'] = $this->common_model->get_row('users',array('user_id'=>user_id()));
		} 
		$data['reason'] ='';
		//$data['title_top']='CONTACT US'; 
		if(!user_logged_in()){ 
			$this->form_validation->set_rules('firstname', 'First Name', 'required|alpha_numeric_spaces');
			$this->form_validation->set_rules('lastname', 'Last Name', 'required|alpha_numeric_spaces');
			$this->form_validation->set_rules('email','Email','required|valid_email|trim');
			$this->form_validation->set_rules('mobile','support', 'required|trim');
		}
		$this->form_validation->set_rules('reason','Reason', 'required|trim');
		$this->form_validation->set_rules('message', 'message', 'required|trim|max_length[2000]');
		$this->form_validation->set_error_delimiters('<div class="meditory-error">', '</div>');
		if ($this->form_validation->run() == TRUE)  {
			if(user_logged_in()){
				$user_data['user_id']= user_id();
				$user_data['firstname'] = $data['user_info']->user_name;
				$user_data['lastname'] = $data['user_info']->last_name;
				$user_data['email']= $data['user_info']->email;
				$user_data['mobile'] = $data['user_info']->mobile;
			}else {
				$user_data['firstname']=  $this->input->post('firstname');
				$user_data['lastname'] =  $this->input->post('lastname');
				$user_data['email']  =  $this->input->post('email');
				$user_data['mobile'] =  $this->input->post('mobile');
			}
			
			$ticket_no = $this->getTicket_No();
		    $user_data['ticket_no'] = $ticket_no;
			$user_data['message']= strip_tags($this->input->post('message'));   
			$user_data['reason']=  $this->input->post('reason');
			$user_data['created']=  date('Y-m-d H:i:s');
			$user_data['user_ip']  =  $this->input->ip_address();
			$user_data['user_role']=0;


			if($user_id=$this->common_model->insert('support', $user_data)) {

			//-------------For Send email AND SMS-----------

			$email_template = $this->common_model->get_row('email_templates', array('id'=>7));
			if(!empty($email_template)){
    			
    			//==-----------===Send Email==-----------
    			if($email_template->template_email_enable==1){

	    			$userRole  = 2; //for Customer
	    			$to 	   = $user_data['email'];
	    			$param 	   = array(
	    				'site_name'  	  => SITE_NAME,
	    				'user_role'       => "Customer",
	                    'ticket_no'       => $ticket_no,
	                    'name'            => ucwords($user_data['firstname']),
	                    'email'           => $user_data['email'],
	                    'mobile_no'       => $user_data['mobile'],
	                    'subject'         => feedback_subject_status($user_data['reason']),
	                    'msg'             => $user_data['message'],
	                    'contactus_link'  => base_url('page/contact')
	                );
	    			$sendEmail = sendEmail($email_template, $to, $param, $userRole);


	    			$userRole  = 0; //for Admin
	    			$adminEMAIl= get_option_url('EMAIl');
	    			$to 	   = (!empty($adminEMAIl)) ? $adminEMAIl : SUPPORT_EMAIL;
	    			$param 	   = array(
	    				'site_name'  	  => SITE_NAME,
	    				'user_role'       => "Customer",
	                    'ticket_no'       => $ticket_no,
	                    'name'            => ucwords($user_data['firstname']),
	                    'email'           => $user_data['email'],
	                    'mobile_no'       => $user_data['mobile'],
	                    'subject'         => feedback_subject_status($user_data['reason']),
	                    'msg'             => $user_data['message'],
	                    'contactus_link'  => base_url('page/contact')
	                );
	    			$sendEmailAdmin = sendEmail($email_template, $to, $param, $userRole);
	    		}

	    		//==-----------===Send SMS==-----------===
	    		if($email_template->template_sms_enable==1){

	    			$userRole  = 2; //for Customer
	    			$to 	   = $user_data['mobile'];
	    			$param 	   = array(
	    				'site_name'  	  => SITE_NAME,
	    				'user_role'       => "Customer",
	                    'ticket_no'       => $ticket_no,
	                    'name'            => ucwords($user_data['firstname']),
	                    'email'           => $user_data['email'],
	                    'mobile_no'       => $user_data['mobile'],
	                    'subject'         => feedback_subject_status($user_data['reason']),
	                    'msg'             => $user_data['message'],
	                    'contactus_link'  => base_url('page/contact')
	                );
	    			$sendSMS = sendSMS($email_template, $to, $param, $userRole);


	    			$userRole  = 0; //for Admin
	    			$to 	   = get_option_url('PHONE');
	    			$param 	   = array(
	    				'site_name'  	  => SITE_NAME,
	    				'user_role'       => "Customer",
	                    'ticket_no'       => $ticket_no,
	                    'name'            => ucwords($user_data['firstname']),
	                    'email'           => $user_data['email'],
	                    'mobile_no'       => $user_data['mobile'],
	                    'subject'         => feedback_subject_status($user_data['reason']),
	                    'msg'             => $user_data['message'],
	                    'contactus_link'  => base_url('page/contact')
	                );
	    			$sendSMSAdmin = sendSMS($email_template, $to, $param, $userRole);
	    		}

	    	}
            //-------------**For Send email AND SMS-----------

			$this->session->set_flashdata('theme_success','Thank you for contacting us! Your inquiry is submitted and will respond to you as soon as possible');
			if(user_logged_in())
				redirect('support/messages/'.$user_id); 
			else 
				redirect('support/messages');
			}else{
				$this->session->set_flashdata('theme_danger','Sorry! Inquiry request process has been failed. please try again');
				redirect('support/messages');
			}
		}else{
			$this->session->set_flashdata('theme_danger','Sorry! Inquiry request process has been failed. please try again');
			redirect('support/messages');
		}        
	}


	public function complete_tickets($message_id='')
	{
		$this->_check_login(); //check  login authentication 
		$data['title']='Completed Tickets';
		$data['support'] = $this->common_model->get_result('support',array('user_id'=>user_id(),'parent_id'=>0, 'mark_complete'=>1),array(),array('support_id','DESC'));
		if($message_id){
		  if(!$this->common_model->get_row('support',array('user_id'=>user_id(),'parent_id'=>0,'support_id'=>$message_id),array(),array('support_id','DESC'))){
				$this->session->set_flashdata('theme_danger','This ticket isn\'t available in our records');
			redirect('support/complete_tickets/');
		  }
		}

		if($data['support']){
		  if(!$message_id){
			$message_id=$data['support'][0]->support_id;
		  }
		  $data['support_detail'] = $this->common_model->get_message_user($message_id);
		}
		$data['message_id']=$message_id;
		$data['template']='frontend/support/complete_tickets';
		$this->load->view('templates/frontend/front_template',$data); 
	}


	private function getTicket_No(){
		return $rnd_no = md5(uniqid(rand(100000, 999999), true));
	}

}	