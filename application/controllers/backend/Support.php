<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Support extends CI_Controller {
	public function __construct(){
        parent::__construct();
        clear_cache();
        $this->load->model('superadmin_model');
       
    }

	private function _check_login(){
		if(superadmin_logged_in()===FALSE)
			redirect('behindthescreen');
	}
   	

   	/* support system */
	public function user_contactus($offset=0)	{
		$this->_check_login(); //check login authentication
		$data['title']='Support Messages';
		$data['offset']=$offset;
		$data['contactus'] = $this->superadmin_model->get_contactus($offset,PER_PAGE);
		$config=backend_pagination();
		$config['base_url'] = base_url().'backend/support/user_contactus/';
		$config['total_rows'] = $this->superadmin_model->get_contactus(0,0);
		
		$config['per_page'] = PER_PAGE;
		$config['uri_segment'] = 4;
		if(!empty($_SERVER['QUERY_STRING']))
			$config['suffix'] = "?".$_SERVER['QUERY_STRING'];
		else
		 	$config['suffix'] ='';

		$config['first_url'] = $config['base_url'].$config['suffix'];
		if((int) $offset < 0){
			$this->session->set_flashdata('msg_warning','Something went wrong! Please try again');    
			redirect($config['base_url']);
		}else if($config['total_rows'] < $offset){
			$this->session->set_flashdata('msg_warning','Something went wrong! Please try again');    
			redirect($config['base_url']);
		}

		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();
 		$data['template']='backend/support/user_contactus';
		$this->load->view('templates/superadmin_template',$data);
	}



	public function complete_tickets($offset=0)	{
		$this->_check_login(); //check login authentication
		$data['title']='Completed Tickets';
		$data['offset']=$offset;
		$data['contactus'] = $this->superadmin_model->get_complete_contact_us($offset,PER_PAGE);
 		$config=backend_pagination();
		$config['base_url'] = base_url().'backend/support/complete_tickets/';
		$config['total_rows'] = $this->superadmin_model->get_complete_contact_us(0,0);
		
		$config['per_page'] = PER_PAGE;
		$config['uri_segment'] = 4;
		if(!empty($_SERVER['QUERY_STRING']))
			$config['suffix'] = "?".$_SERVER['QUERY_STRING'];
		else
		 	$config['suffix'] ='';

		$config['first_url'] = $config['base_url'].$config['suffix'];
		if((int) $offset < 0){
			$this->session->set_flashdata('msg_warning','Something went wrong! Please try again');    
			redirect($config['base_url']);
		}else if($config['total_rows'] < $offset){
			$this->session->set_flashdata('msg_warning','Something went wrong! Please try again');    
			redirect($config['base_url']);
		}

		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();
 		$data['template']='backend/support/complete_tickets';
		$this->load->view('templates/superadmin_template',$data);
	}


	public function user_contactus_reply($message_id=''){
		$this->_check_login();
		$data['title']='Reply on Support Messages';
		if(empty($message_id)){
			redirect('backend/superadmin/error_404');
		}
		if(!$data['message'] = $this->superadmin_model->get_row('support',array('support_id'=>$message_id))){
			redirect('backend/superadmin/error_404');
		}

		$data['support_detail'] = $this->superadmin_model->get_message_thread($message_id);
		$this->superadmin_model->update_support_msg($message_id);	
		$this->form_validation->set_rules('reply_message', 'Reply Message', 'required');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE){

			$contactus_msg = array(
				'user_id'=>$data['message']->user_id,
				'parent_id'=>$message_id,
				'message'=>$this->input->post('reply_message'),
				'created'=>date('Y-m-d H:i:s'),
				'user_role'=>'2',
				'status'=>'0'
			);

			if($query = $this->superadmin_model->insert('support',$contactus_msg)){

				//-------------For Send email AND SMS-----------

    			$email_template = $this->common_model->get_row('email_templates', array('id'=>8));
    			if(!empty($email_template)){
        			
        			//==-----------===Send Email==-----------
        			if($email_template->template_email_enable==1){

		    			$userRole  = $data['support_detail'][0]->user_role; //for Customer
		    			$to = $data['support_detail'][0]->email;
		    			$param 	   = array(
		    				'site_name'  	  => SITE_NAME,
		    				'user_role'       => "Customer",
		                    'ticket_no'       => $data['support_detail'][0]->ticket_no,
		                    'name'            => ucwords($data['support_detail'][0]->firstname),
		                    'subject'         => feedback_subject_status($data['support_detail'][0]->reason),
		                    'msg'             => strip_tags($this->input->post('reply_message')),
		                    'contactus_link'  => base_url('page/contact')
		                );
		    			$sendEmailAdmin = sendEmail($email_template, $to, $param, $userRole);
		    		}

		    		//==-----------===Send SMS==-----------===
		    		if($email_template->template_sms_enable==1){

		    			$userRole  = $data['support_detail'][0]->user_role; //for Customer
		    			$to 	   = ($data['support_detail'][0]->country_code) ? '+'.$data['support_detail'][0]->country_code.''.$data['support_detail'][0]->mobile : $data['support_detail'][0]->mobile;
		    			$param 	   = array(
		    				'site_name'  	  => SITE_NAME,
		    				'user_role'       => "Customer",
		                    'ticket_no'       => $data['support_detail'][0]->ticket_no,
		                    'name'            => ucwords($data['support_detail'][0]->firstname),
		                    'subject'         => feedback_subject_status($data['support_detail'][0]->reason),
		                    'msg'             => strip_tags($this->input->post('reply_message')),
		                    'contactus_link'  => base_url('page/contact')
		                );
		    			$sendSMSAdmin = sendSMS($email_template, $to, $param, $userRole);
		    		}

		    	}
                //-------------**For Send email AND SMS-----------

				redirect('backend/support/user_contactus_reply/'.$message_id.'/0');
			}
			
		}		
		
		//echo "<pre>"; print_r($data); die;
		$data['template']='backend/support/user_contactus_reply';
		$this->load->view('templates/superadmin_template',$data);
	}



	public function delete_user_contactus($id=''){

		$this->_check_login(); //check login authentication
		$data['title']='Delete';

		if($this->superadmin_model->delete('support',array('support_id'=>$id))){
		   	$this->session->set_flashdata('msg_success', 'Inquiry deleted successfully');
		   	redirect('backend/support/user_contactus');
		}else{
			$this->session->set_flashdata('msg_error', 'Sorry! Support Inquiry deletion process has been failed. Please try again');
			redirect('backend/support/user_contactus');
		}

	}


	public function mark_complete($id="",$status=''){

	    $this->_check_login(); //check login authentication
	    $data['title']='';

		if($id) {
			if($status==0) {
				$data=array('mark_complete'=>1);
			}else{
				$data=array('mark_complete'=>0);
			}

			if($this->superadmin_model->update('support',$data,array('support_id'=>$id))) {
				$this->superadmin_model->update('support',$data,array('parent_id'=>$id));
				$this->session->set_flashdata('msg_success','Ticket completed mark successfully');
			}
		}else{
			$this->session->set_flashdata('msg_error','Sorry! Process has been failed. Please try again');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}


	public function important_notification($id='',$mark_status='',$table_name='')
	{
	   	$this->_check_login(); //check login authentication
	   	if(!empty($id)){
	     	if($mark_status==0){
	            $new_status = 1;
	     	}else{
	            $new_status = 0;
	    	}      
		    $update_data = array('mark_important' =>$new_status); 
		    $this->superadmin_model->update($table_name, $update_data,array('support_id'=>$id));
		    redirect($_SERVER['HTTP_REFERER']);
	   	}else{
	     	redirect('backend/superadmin/error_404');
	   	}
	}


	public function change_all_status($tablename='')
    {     
		$this->_check_login(); //check login authentication   
		$data['title']='Change Status';

		if(!empty($_POST['status'])){       
			$default_arr=array('status'=>FALSE); 
			$status='';            
			$count= count($_POST['row_id']);
			
			for ($i=0; $i < $count ; $i++) {
				if($_POST['status']==1){
					$update_status= array('mark_important'=>1);
				}elseif($_POST['status']==2){
					$update_status= array('mark_important'=>0);
				}elseif($_POST['status']==3){
					$update_status= array('notification_read'=>1,'read_datetime'=>date('Y-m-d H:i:s'));
				}elseif($_POST['status']==4){
					$update_status= array('notification_read'=>0,'read_datetime'=>'');
				}elseif($_POST['status']==6) {
					$update_status= array('mark_complete'=>1);
					$this->superadmin_model->update($tablename,$update_status,array('parent_id'=>$_POST['row_id'][$i]));
				}elseif($_POST['status']==7) {
					$update_status= array('mark_complete'=>0);
					$this->superadmin_model->update($tablename,$update_status,array('parent_id'=>$_POST['row_id'][$i]));
				}
				if($_POST['status']!=5){
					$this->superadmin_model->update($tablename,$update_status,array('support_id'=>$_POST['row_id'][$i]));
					$default_arr=array('status'=>TRUE);
				}else{
					$this->superadmin_model->delete($tablename,array('support_id'=>$_POST['row_id'][$i]));
					$default_arr=array('status'=>TRUE); 
				}
			}
	        header('Content-Type: application/json');
	        echo json_encode($default_arr);        
      	}
    }


    public function notification_status_msg($msg='')
    {
       $this->_check_login(); //check login authentication
       $data['title']='';
       $new_msg=ucfirst(urldecode($msg)) ;
       $this->session->set_flashdata('msg_success',$new_msg .' action performed successfully');
       redirect($_SERVER['HTTP_REFERER']);
    }
  
}