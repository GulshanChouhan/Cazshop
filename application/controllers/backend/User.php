<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class User extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->model('common_model');
        $this->load->helper('url_helper');
    }
 
	private function _check_login(){
		if(superadmin_logged_in()===FALSE)
			redirect('behindthescreen');
	}
    public function index($user_role='', $offset=0){
	    $this->_check_login(); //check login authentication
	    if($user_role!=1 && $user_role!=2)
		{
			$this->session->set_flashdata('msg_warning','Something went wrong! Please try again');  	
            redirect('backend/user/index/1');
		}
        $data['title']= ($user_role==1) ? 'List Of Sellers' : 'List Of Customers';
	    $search=array();
	    if(!empty($_GET))
	    {
	      if(!empty($_GET['user_name']))
	      $search[]=' us.user_name like "%'.trim($_GET['user_name']).'%"';
	      if(!empty($_GET['email']))
	      $search[]=' us.email = "'.trim($_GET['email']).'"';
	  	  if(!empty($_GET['country_code']))
	      $search[]=' us.country_code = "'.trim($_GET['country_code']).'"';
	  	  if(!empty($_GET['mobile']))
	      $search[]=' us.mobile = "'.trim($_GET['mobile']).'"';
	      if(!empty($_GET['status']))
	      $search[]=' us.status = "'.trim($_GET['status']).'"';
	    }
	    $data['phnCode']=$this->common_model->get_result('countries',array(),array('sortname','phonecode'),array('name','asc'));
	    $data['users'] = $this->common_model->getUsersInfo($user_role, $offset, PER_PAGE, $search);
	    $config=backend_pagination();
	    $config['base_url'] = base_url().'backend/user/index/'.$user_role;
	    $config['total_rows'] = $this->common_model->getUsersInfo($user_role, 0, 0, $search);
	    
	    $config['per_page'] = PER_PAGE;
		$config['uri_segment'] = 5;
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
	    $data['template']='backend/user/index';
	    $data['offset']=$offset;
	    $data['user_role']=$user_role;
	    $this->load->view('templates/superadmin_template',$data);

	}
    public function create($role=1)
    { 
		$this->_check_login(); //check login authentication
		if($role!=1 && $role!=2)
		{
			$this->session->set_flashdata('msg_warning','Something went wrong! Please try again');  	
            redirect('backend/user/'.$role.'/0');
		}
        $data['title'] = 'Create a User';
		$data['role']=$role;
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'last Name', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
        $this->form_validation->set_rules('mobile', 'Contact Number', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');
		$this->form_validation->set_rules('image', '', 'callback_check_image');
        if ($this->form_validation->run() == TRUE) 
        {
			$image ='';
			if($this->session->userdata('check_image')!=''):
                $check_logo_img=$this->session->userdata('check_image');
                $image = 'assest/uploads/users/'.$check_logo_img['image'];               
                $this->session->unset_userdata('check_image');
            endif;
			$salt = $this->salt();
            $data=array(
				'user_name'=>$this->input->post('first_name').' '.$this->input->post('last_name'),
				'first_name'=>$this->input->post('first_name'),
                'last_name'=>$this->input->post('last_name'),
                'gender'=>$this->input->post('gender'),
                'email'=>$this->input->post('email'),
                'mobile'=>$this->input->post('mobile'),
                'country'=>$this->input->post('country'),
				'user_role'=>$role,
				'password'=>sha1($salt.sha1($salt.sha1($this->input->post('password')))),
				'salt'=>$salt,
				'last_login'=>date('Y-m-d H:i:s A'),
				'last_ip'=>$this->input->ip_address(),
				'image'=>$image,
				'status'=>1,
				'created'=>  date('Y-m-d H:i:s A')
            );
            if($this->common_model->insert('users',$data))
            {
                $this->session->set_flashdata('msg_success', 'User information added successfully');
                redirect('backend/user/index/'.$role);
            }
            else
            {
                $this->session->set_flashdata('msg_error', 'Something Went Wrong. Please try again');
                redirect('backend/user/index/'.$role);
            }
        }		
		$data['template']='backend/user/add_user';
		$this->load->view('templates/superadmin_template',$data);
    }


    public function view($user_role='', $user_id='')
    { 
		$this->_check_login(); //check login authentication
		if($user_role!=1 && $user_role!=2)
		{
			$this->session->set_flashdata('msg_warning','Something went wrong! Please try again');  	
            redirect('backend/user/index/'.$user_role);
		}
        $data['title'] = 'View details of User';
        $data['BasicInfo'] = $this->common_model->get_row('users',array('user_id'=>$user_id));
        
        if($user_role==1)
		{
			$data['sellerBusinessInfo'] = $this->common_model->get_row('business_info',array('seller_id'=>$user_id));
			$data['sellerInterviewInfo'] = $this->common_model->get_row('seller_interview',array('seller_id'=>$user_id));
			$data['signAndLicenceInfo'] = $this->common_model->get_row('seller_signature_and_licence',array('seller_id'=>$user_id));
		}

		$data['user_role'] = $user_role;
		$data['user_id'] = $user_id;
		$data['template']='backend/user/view';
		$this->load->view('templates/superadmin_template',$data);
    }


    public function edit($role=1,$id = '')
    {      
    	$this->_check_login(); //check login authentication
		if($role!=1 && $role!=2)
		{
			$this->session->set_flashdata('msg_warning','Something went wrong! Please try again');  	
            redirect('backend/user/'.$role.'/0');
		}
        if (empty($id))
        {
            redirect('backend/user/index');
        }
		$data['role']=$role;
        $data['title'] = 'Edit Details';        
        $data['user'] = $this->common_model->get_row('users',array('id'=>$id));
        if (empty($data['user']))
        {
            redirect('backend/user/index/'.$role);
        }
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'last Name', 'required');
		if(!empty($_POST) && $_POST['password']!='')
			$this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('mobile', 'Contact Number', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');
		if(!empty($_FILES) && $_FILES['image']['name']!='')
			$this->form_validation->set_rules('image', '', 'callback_check_image');
        if ($this->form_validation->run() == TRUE) 
        {
			if($this->input->post('password')=='')
			{	
				$password=$data['user']->password;
				$salt=$data['user']->salt;
            }else{
				$salt=$this->salt();
				$password=sha1($salt.sha1($salt.sha1($this->input->post('newpassword'))));
			}
			$image =$data['user']->images;
			if($this->session->userdata('check_image')!=''):
                $check_logo_img=$this->session->userdata('check_image');
                $image = 'assest/uploads/users/'.$check_logo_img['image'];               
                $this->session->unset_userdata('check_image');
            endif;
            $data=array(
                'user_name'=>$this->input->post('first_name').' '.$this->input->post('last_name'),
				'first_name'=>$this->input->post('first_name'),
                'last_name'=>$this->input->post('last_name'),
                'gender'=>$this->input->post('gender'),
                'email'=>$this->input->post('email'),
                'mobile'=>$this->input->post('mobile'),
                'country'=>$this->input->post('country'),
				'password'=>$password,
				'salt'=>$salt,
				'last_ip'=>$this->input->ip_address(),
				'image'=>$image,
            );
            if($this->common_model->update('users',$data,array('id'=>$id)))
            {
                $this->session->set_flashdata('msg_success', 'User information updated successfully');
                redirect('backend/user/index/'.$role);
            }
            else
            {
                $this->session->set_flashdata('msg_error', 'Something Went Wrong. Please try again');
                redirect('backend/user/index/'.$role);
            }
        }
		$data['template']='backend/user/edit_user';
		$this->load->view('templates/superadmin_template',$data);

    }


    public function changepassword()
    {
    	$this->_check_login(); //check login authentication
    	$data['title'] = 'Change Password'; 
        $salt = $this->salt();
        $password = $this->input->post('password');
        $user_id = $this->input->post('userID');
        if ($password=='' || $user_id=='') {
            $this->session->set_flashdata('msg_error', 'Something Went Wrong. Please try again');
            redirect($_SERVER['HTTP_REFERER']);
        }
        $data=array(                
            'password'          => sha1($salt.sha1($salt.sha1($password))),
            'salt'              => $salt               
        );
        if($this->common_model->update('users',$data,array('user_id'=>$user_id)))
        {

          $user_info = $this->common_model->get_row('users',array('user_id'=>$user_id));
          $user_role = ($user_info->user_role==1) ? "Seller" : "Customer";
          $login_link = ($user_info->user_role==1) ? '<a target="_blank" href="'.base_url('seller/login').'">Click here to Login</a>' : '<a target="_blank" href="'.base_url('page/login').'">Click here to Login</a>';

           //-------------For Send email AND SMS-----------
          $email_template = $this->common_model->get_row('email_templates', array('id'=>11));
          if(!empty($email_template)){
              
            //==-----------===Send Email==-----------
            if($email_template->template_email_enable==1){

              $userRole  = $user_info->user_role; //for Seller/Customer
              $to        = $user_info->email;
              $param     = array(
                  'site_name'           => SITE_NAME,
                  'name'         		=> ucwords($user_info->user_name),
                  'user_role'       	=> $user_role,
                  'password'          	=> $password,
                  'login_link'        	=> $login_link
              );
              $sendEmail = sendEmail($email_template, $to, $param, $userRole);

            }

            //==-----------===Send SMS==-----------===
            if($email_template->template_sms_enable==1){

              $userRole  = $user_info->user_role; //for Seller/Customer
              $to        = ($user_info->country_code) ? '+'.$user_info->country_code.''.$user_info->mobile : $user_info->mobile;
              $param     = array(
                  'site_name'           => SITE_NAME,
                  'name'         		=> ucwords($user_info->user_name),
                  'user_role'       	=> $user_role,
                  'password'          	=> $password,
                  'login_link'        	=> $login_link
              );
              $sendSMS = sendSMS($email_template, $to, $param, $userRole);

            }

          }
          //-------------**For Send email AND SMS-----------

           $this->session->set_flashdata('msg_success', 'Password has been updated successfully');
           redirect($_SERVER['HTTP_REFERER']);
        }
        else
        {
        	$this->session->set_flashdata('msg_error', 'Sorry! Password updation process has been failed. please try again');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }


    function check_image($str){
    	$this->_check_login(); //check login authentication
		if(empty($_FILES['image']['name'])){
				$this->form_validation->set_message('check_image', 'Choose Image');
			   return FALSE;
			}
		
		if(!empty($_FILES['image']['name'])):
			$config['upload_path'] = './assest/uploads/users';
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_size']  = '5024';
			$config['max_width']  = '5024';
			$config['max_height']  = '5024';
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('image')){
				$this->form_validation->set_message('check_image', $this->upload->display_errors());
				return FALSE;
			}else{
				$data = $this->upload->data(); // upload image          
				$this->session->set_userdata('check_image',array('image_url'=>$config['upload_path'].$data['file_name'],
					 'image'=>$data['file_name']));
				return TRUE;
			}
		else:
			$this->form_validation->set_message('check_image', 'The %s field required');
			return FALSE;
		endif;
    }


    public function proxy_login($userRole='', $user_id=''){
        $this->_check_login();
        $this->load->model('user_model');
        $data = array('user_role'=>$userRole, 'user_id'=>$user_id);
        $user_data = $this->user_model->proxy_login($data);
        if(!empty($user_data) || $user_data!=''){
        	
        	$this->user_model->update('users',array('last_ip' => $this->input->ip_address(),
					'last_login' => date('Y-m-d h:i:s')),array('user_id'=>$user_data['id']));

        	if($user_data['user_role']=='0'){

        		$this->session->unset_userdata('superadmin_info');
				$this->session->set_userdata('superadmin_info',$user_data);
				redirect('backend/superadmin/dashboard');
				
			}else if($user_data['user_role']=='1'){

				$this->session->unset_userdata('seller_info');
				$this->session->set_userdata('seller_info',$user_data);
				$this->session->set_flashdata('msg_success', 'You have logged in as a seller successfully');

				if($user_data['business_name']=='' || empty($user_data['business_name'])) 
					redirect(base_url('seller/agreement_step/'.base64_encode($user_data['id'])));

				if($user_data['confirmation_code']!='verified') 
					redirect(base_url('seller/phone_verification/'.base64_encode($user_data['id'])));

				$business_info    = $this->user_model->get_row('business_info', array('seller_id' => $user_data['id']));
				if(empty($business_info)) 
					redirect(base_url('seller/seller_information/'.base64_encode($user_data['id'])));
					
				$seller_interview = $this->user_model->get_row('seller_interview', array('seller_id' => $user_data['id']));
				if(empty($seller_interview)) 
					redirect(base_url('seller/seller_interview/'.base64_encode($user_data['id'])));
				
				if($business_info->bitcoin_address=='' && ($business_info->shipment_option=='' || $business_info->shipment_option==0))
					redirect(base_url('seller/shipment_option/'.base64_encode($user_data['id'])));

				$seller_signature_and_licence = $this->user_model->get_row('seller_signature_and_licence', array('seller_id' => $user_data['id']));
				if(empty($seller_signature_and_licence))
					redirect(base_url('seller/signature_or_licence/'.base64_encode($user_data['id'])));

				//p($user_data); die;
				redirect('seller/dashboard');

			}else if($user_data['user_role']=='2'){
				$this->session->unset_userdata('user_info');
				$this->session->set_userdata('user_info',$user_data);

                $this->setCartData($user_data['id']);
				$this->session->set_flashdata('msg_success', 'You have logged in as a customer successfully');
				redirect('account/dashboard');
			}

        }else{
         	$this->session->set_flashdata('msg_error','Invalid User ID or User status is not activated yet');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function delete($id='',$user_role='')
    {
    	$this->_check_login(); //check login authentication

        $data = $this->common_model->get_row('users',array('user_id'=>$id));
        if(!$data) redirect('backend/user/index/'.$user_role);

        if($this->common_model->delete('users',array('user_id'=>$id)))
        {
        	if($user_role==0){
        		$user = "Superadmin";
        	}elseif ($user_role==1){
        		$user = "Seller";
        	}elseif ($user_role==2){
        		$user = "Customer";
        	}

            $this->session->set_flashdata('msg_success', $user.' deleted successfully');
            redirect('backend/user/index/'.$user_role);
        }
        else
        {
            $this->session->set_flashdata('msg_error', 'Something Went Wrong. Please try again');
            redirect('backend/user/index/'.$user_role);
        }

    }


    public function change_status($table='',$col='',$value='',$status='') {
        if($table=='' || $col=='' || $value=='' || $status=='') redirect($_SERVER['HTTP_REFERER']);
        $update_status= array('status'=>$status);
        if($this->common_model->update($table,$update_status,array($col=>$value))){
            if($table=='users'){

               $statusmsg = ($status==1) ? "Activated" : "Deactivated";
               $getUserRole = $this->common_model->get_row($table, array($col=>$value), array('user_role','user_name','email','country_code','mobile'));
               $email_template = $this->common_model->get_row('email_templates', array('id'=>6));
			   if(!empty($email_template)){

               //-------------For Send email AND SMS-----------

					if($email_template->template_email_enable==1){
	                	$userRole  = $getUserRole->user_role; //for Customer
		    			$to 	   = $getUserRole->email;
		    			$param 	   = array(
		    				  'site_name'  	    => SITE_NAME,
							  'name'            => ucwords($getUserRole->user_name),
	                          'status'          => $statusmsg,
							  'contactus_link'  => base_url('page/contact')
						);

		    			$sendEmail = sendEmail($email_template, $to, $param, $userRole);
					}

					if($email_template->template_sms_enable==1){
	                	$userRole  = $getUserRole->user_role; //for Customer
		    			$to 	   = ($getUserRole->country_code) ? '+'.$getUserRole->country_code.''.$getUserRole->mobile : $getUserRole->mobile;
		    			$param 	   = array(
		    				  'site_name'  	    => SITE_NAME,
							  'name'            => ucwords($getUserRole->user_name),
	                          'status'          => $statusmsg,
							  'contactus_link'  => base_url('page/contact')
						);
		    			$sendSMS = sendSMS($email_template, $to, $param, $userRole);
					}

	        	}

	        	//-------------For Send email AND SMS-----------

                if(!empty($getUserRole)){
                    if($table=='users' && $col=='user_id' && $getUserRole->user_role==1){
                        $msg = ($status==1) ? "Seller activated successfully" : "Seller deactivated successfully";
                    }else if($table=='users' && $col=='user_id' && $getUserRole->user_role==2){
                        $msg = ($status==1) ? "Customer activated successfully" : "Customer deactivated successfully";
                    }else{
                        $msg = "Status updated successfully";
                    }
                }else{
                    $msg = "Status updated successfully";
                } 
            }else{
                $msg = "Status updated successfully";
            }
            $this->session->set_flashdata('msg_success', $msg);
        }else {
            $this->session->set_flashdata('msg_warning','Something went wrong! Please try again');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }


	public function change_status_users($id="",$status="",$offset=""){
	    $this->_check_login(); //check login authentication
	    $data['title']='';
	    $data=array('status'=>$status);
	    if($this->common_model->update('users',$data,array('id'=>$id)))    {
	    $this->session->set_flashdata('msg_success','Status changed successfully');}
	    redirect($_SERVER['HTTP_REFERER']);
	}


	public function change_all_status()
	{
		$this->_check_login(); //check login authentication
		$default_arr=array('status'=>false);
		for($i=0;$i<sizeof($_POST['row_id']);$i++)
		{
			if($_POST['row_id'][$i]!='on'){
				$this->common_model->update('users',array('status'=>$_POST['status']),array('id'=>$_POST['row_id'][$i]));
				$default_arr=array('status'=>TRUE);
			}
		}
		header('Content-Type: application/json');
		echo json_encode($default_arr); 
	}

	function salt() {
		return substr(md5(uniqid(rand(), true)), 0, 10);
	}
	
	function email_check($str=''){
		if($this->common_model->get_row('users',array('email'=>$str))):
		$this->form_validation->set_message('email_check', 'The %s address already exists');
		   return FALSE;
		else:
		   return TRUE;
		endif;
	}

	public function verify_account($user_role='', $user_id='')
    { 
		$this->_check_login(); //check login authentication
		$signAndLicenceInfo = $this->common_model->get_row('seller_signature_and_licence',array('seller_id'=>$user_id));
		if(!empty($signAndLicenceInfo)){

			if($signAndLicenceInfo->verification_status==1){
				$verification_status = 2;
				$msg = "You have unverified the seller account";
                $short_description = "Your account status has been unverified by ".SITE_NAME." administrator.";
                $login_or_support_link = "If you want to contact to ".SITE_NAME." administrator.<a href='".base_url('page/contact')."'>Click here</a>";
			}else{
				$msg = "You have verified the seller account successfully";
				$verification_status = 1;
                $short_description = "Your account has been verified by ".SITE_NAME." administrator. Now you can be able to sale your product on ".SITE_NAME;
                $login_or_support_link = "If you want to login.<a href='".base_url('seller/login')."'>Click here</a>";
			}

			$data = array(
				'verification_status' => $verification_status
			);
			if($this->common_model->update('seller_signature_and_licence',$data,array('seller_id'=>$user_id))){

                //-------------For Send email AND SMS-----------
                $getUserRole = $this->common_model->get_row('users', array('user_id'=>$user_id));
                $email_template = $this->common_model->get_row('email_templates', array('id'=>5));
                if(!empty($email_template)){

                    if($email_template->template_email_enable==1){
                        $userRole  = $getUserRole->user_role; //for seller
                        $to        = $getUserRole->email;
                        $param     = array(
                              'site_name'               => SITE_NAME,
                              'name'                    => ucwords($getUserRole->user_name),
                              'short_description'        => $short_description,
                              'login_or_support_link'   => $login_or_support_link
                        );

                        $sendEmail = sendEmail($email_template, $to, $param, $userRole);
                    }

                    if($email_template->template_sms_enable==1){
                        $userRole  = $getUserRole->user_role; //for seller
                        $to        = ($getUserRole->country_code) ? '+'.$getUserRole->country_code.''.$getUserRole->mobile : $getUserRole->mobile;
                        $param     = array(
                              'site_name'               => SITE_NAME,
                              'name'                    => ucwords($getUserRole->user_name),
                              'short_description'        => $short_description,
                              'login_or_support_link'   => $login_or_support_link
                        );
                        $sendSMS = sendSMS($email_template, $to, $param, $userRole);
                    }

                }

                //-------------For Send email AND SMS-----------

                $this->session->set_flashdata('msg_success', $msg);
                redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->session->set_flashdata('msg_error', 'Process has been failed. please try again');
                redirect($_SERVER['HTTP_REFERER']);
            }
		}else{
			$this->session->set_flashdata('msg_error', 'Something Went Wrong. Please try again');
            redirect($_SERVER['HTTP_REFERER']);
		}
    }

    private function setCartData($user_id=''){

        $cart_DB_info = $this->common_model->get_row('user_cartinfo',array('user_id'=>$user_id));
        if(!empty($cart_DB_info)){
            $cartSessionData = $this->cart->contents();
            if(empty($cartSessionData)){ /*--====Whwn the User is not select item's in their cart====--*/
                $insertArr = array();
                $cartDBData = json_decode($cart_DB_info->cart_data);
                foreach ($cartDBData as $key => $value){
                    if(!empty($value)){
                        $insertArr = (Array) $value;
                        $cartInfo = $this->cart->insert($insertArr);
                    }   
                }

                if(!empty($this->cart->contents())){
                    $this->common_model->update('user_cartinfo',array('cart_data'=>''),array('user_id'=>$user_id));
                }

            }else{ /*--====Whwn the User is select item's in their cart====--*/

            }

            
        }      
    }
    
}
