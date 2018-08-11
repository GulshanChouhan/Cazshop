<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Page extends CI_Controller {

	public function __construct(){
        parent::__construct();
        clear_cache();
        $this->load->model('user_model');
        $this->load->model('Common_model');
    }
    
    public function _remap($method, $params = array())
	{
	        if (method_exists($this, $method))
	        {
	       	   return call_user_func_array(array($this, $method), $params);
	        }else{
	        	$this->page($method);
	        }
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

	public function index()
	{
		if(empty(site_access())){

			$data['phnCode']=$this->common_model->get_result('countries',array(),array('sortname','phonecode'),array('name','asc'));
			$data['title']='CazShop : Online Shopping site';
	    	$this->load->view('frontend/default',$data);

		}else{
			$data['title']='Online Shopping site : Shop Online for Mobiles, Books, Watches, Shoes and More';  
		    $data['slider']=$this->common_model->get_result('slider_images',array('status'=>1),array(),array('order','asc'));	    
		    $data['popular_category']=$this->common_model->get_result('category',array('is_home'=>1,'status'=>1),array('category_id','category_name','category_slug','logo_image','short_description'),array('RAND()'),12); 
		    $this->load->model('product_model');
		    
		    /*For Most rated or most discounted products*/
		    
		    $most_rated = $this->product_model->product_featured('', 1, 0, 20, '', '', array('total_rating'));


		    if(!empty($most_rated) && count($most_rated)>=5){
		    	$data['most_rated_or_discounted'] = $most_rated;
		    	$data['most_ratedDiscounted_heading'] = "Most Rated Products";
		    }else{
		    	$most_discounted = $this->product_model->product_featured('', 1, 0, 20, '', '', array('most_discounted'));
		    	$data['most_rated_or_discounted'] = $most_discounted;
		    	$data['most_ratedDiscounted_heading'] = "Most Discounted Products";
		    }

		    /*For Recent or latest added products*/
		    
		    $recentview = $this->product_model->product_featured('', 1, 0, 20, '', '' ,array('recently_viewed'));
		    if(!empty($recentview)  && count($recentview)>=5){
		    	$data['recentview_or_latest'] = $recentview;
		    	$data['recentview_or_latest_heading'] = "Recently View";
		    }else{
		    	$latest_products = $this->product_model->product_featured('', 1, 0, 20, '', '', array('latest'));
		    	$data['recentview_or_latest'] = $latest_products;
		    	$data['recentview_or_latest_heading'] = "Latest/New Products";
		    }
           

       
		    $data['brand']=$this->common_model->get_result('brand',array('status'=>1),array(),array('brand_id','rand()'),'');
		    $data['template']='frontend/index';
		    $this->load->view('templates/frontend/front_template',$data);
		}
	}


	public function registration_request(){

		if(isset($_POST['type']) && $_POST['type']==2){
					
	    	$this->form_validation->set_rules('name', 'Full Name', 'trim|required');
	    	$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[merchant_users.email]');
	    	$this->form_validation->set_rules('mobile', 'Mobile No.', 'trim|required|numeric|min_length[9]|max_length[13]');
	    	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	    	if ($this->form_validation->run() == TRUE){ 
	    		$insert = [
		    		'user_name' => $this->input->post('name'),
		    		'email' => $this->input->post('email'),
	    			'country_code' => $this->input->post('country_code'),
	    			'mobile' => $this->input->post('mobile'),
	    			'created' => date('Y-m-d H:i:s A'),
	        		'modified' => date('Y-m-d H:i:s A')
	    		];
	    		if($id = $this->common_model->insert('merchant_users', $insert)){

	    			//-------------For Send email AND SMS-----------

	    			$email_template = $this->common_model->get_row('email_templates', array('id'=>22));
	    			if(!empty($email_template)){
	        			
	        			//==-----------===Send Email==-----------
	        			if($email_template->template_email_enable==1){


			    			$userRole  = 0; //for Admin
			    			$adminEMAIl= get_option_url('EMAIl');
			    			$to 	   = (!empty($adminEMAIl)) ? $adminEMAIl : SUPPORT_EMAIL;
			    			$to1 	   = 'sourabh@chapter247.com';
			    			$param 	   = array(
			    				'site_name'  	  => SITE_NAME,
			    				'user_role'       => "Merchant",
			                    'name'            => ucwords($this->input->post('name')),
			                    'user_email'      => $this->input->post('email'),
			                    'user_mobile'     => '+'.$this->input->post('country_code')." ".$this->input->post('mobile'),
			                    'profile_view'    => '<a target="_blank" href="'.base_url('backend/user/view/1/'.$id).'">Click here to View Profile details</a>',
			                    'contactus_link'  => base_url('page/contact')
			                );
			    			$sendEmailAdmin = sendEmail($email_template, $to, $param, $userRole);
			    			$sendEmailAdmin = sendEmail($email_template, $to1, $param, $userRole);
			    		}

			    	}
	                //-------------**For Send email AND SMS-----------
	    			
	    			echo json_encode(array('status'=>'success', 'msg'=>'Thanks to be registered! A confirmation email has been sent on your registered email address', 'validation'=>0));
					die;
	    			
	    		}else{
	    			echo json_encode(array('status'=>'failed', 'msg'=>'Sorry! Registration process has been failed. please try again', 'validation'=>0));
					die;
	    		}
	    	}
		}

	}


	public function page($slug='')
	{
		$data['pageDetails']=$pageDetails=$this->common_model->get_row('pages',array('slug'=>$slug, 'type_of_section'=>1, 'status'=>1));
		if(!empty($pageDetails)){
			$data['title']= $pageDetails->title;
			$data['template']='frontend/page';
		}else{
			$data['title']='Page';
			$data['template']='frontend/404';
		}
	    $this->load->view('templates/frontend/front_template',$data);
	}

	public function category()
	{
		$data['title']='Categories';
	    $data['template']='frontend/category';
	    $this->load->view('templates/frontend/front_template',$data);
	}


	public function product_list()
	{
		$data['title']='List Of Products';
	    $data['template']='frontend/product_list';
	    $this->load->view('templates/frontend/front_template',$data);
	}

	public function faq()
	{
		$data['title']='FAQs';

		$data['category'] = $this->common_model->get_row('faq_category',array('faq_category_id'=>1,'status'=>1),array(),array('category_name','asc'));	
		if(empty($data['category']))
		{
			$data['title']='404 Not Found';
		    $data['template']='frontend/404.php';
		}else{
			$data['question_ans'] = $this->common_model->get_result('faq',array('category_id'=>1,'sub_category_id'=>0,'status'=>1),array(),array());
			
			$data['sub_category'] = $this->common_model->get_result('faq_sub_category',array('category_id'=>1,'status'=>1),array(),array());
			
			$data['sub_question_ans']=array();
			if(!empty($data['sub_category']))
			{
				foreach($data['sub_category'] as $row)
				{
					$data['sub_question_ans'][$row->faq_sub_category_id] = $this->common_model->get_result('faq',array('category_id'=>1,'sub_category_id'=>$row->faq_sub_category_id,'status'=>1),array(),array());
				}
			}
		}

	    $data['template']='frontend/faq';
	    $this->load->view('templates/frontend/front_template',$data);
	}

	public function contact()
	{
		$data['title']='Contact Us';
        $this->form_validation->set_rules('name', 'Full Name', 'trim|required');
        $this->form_validation->set_rules('country_code', 'Country Code', 'trim|required');
        $this->form_validation->set_rules('mobile', 'Mobile No.', 'trim|required|numeric|min_length[9]|max_length[13]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('subject', 'Subject', 'trim|required');
        $this->form_validation->set_rules('message', 'Message', 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $userID = (user_id()) ? user_id() : null;
        $user_role = (user_id()) ? 0 : 3;
        if ($this->form_validation->run() == TRUE){     

        	$ticket_no = $this->getTicket_No();

     		$insert = [
	    		'firstname' => $this->input->post('name'),
	    		'user_id' => $userID,
	    		'user_role' => $user_role,
	    		'ticket_no' => $ticket_no,
	    		'status' => 1,
	    		'country_code' => $this->input->post('country_code'),
	    		'mobile' => $this->input->post('mobile'),
	    		'email' => $this->input->post('email'),
    			'reason' => $this->input->post('subject'),
    			'message' => $this->input->post('message'),
			];

    		if($id = $this->common_model->insert('support',$insert)){


    			//-------------For Send email AND SMS-----------

    			$email_template = $this->common_model->get_row('email_templates', array('id'=>13));
    			if(!empty($email_template)){
        			
        			//==-----------===Send Email==-----------
        			if($email_template->template_email_enable==1){

		    			$userRole  = $user_role; //for Customer
		    			$to 	   = $this->input->post('email');
		    			$param 	   = array(
		    				'site_name'  	  => SITE_NAME,
		    				'user_role'       => "Customer",
		                    'ticket_no'       => $ticket_no,
		                    'name'            => ucwords($this->input->post('name')),
		                    'email'           => $this->input->post('email'),
		                    'mobile_no'       => '+'.$this->input->post('country_code').' '.$this->input->post('mobile'),
		                    'subject'         => feedback_subject_status($this->input->post('subject')),
		                    'msg'             => $this->input->post('message'),
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
		                    'name'            => ucwords($this->input->post('name')),
		                    'email'           => $this->input->post('email'),
		                    'mobile_no'       => '+'.$this->input->post('country_code').' '.$this->input->post('mobile'),
		                    'subject'         => feedback_subject_status($this->input->post('subject')),
		                    'msg'             => $this->input->post('message'),
		                    'contactus_link'  => base_url('page/contact')
		                );
		    			$sendEmailAdmin = sendEmail($email_template, $to, $param, $userRole);
		    		}

		    		//==-----------===Send SMS==-----------===
		    		if($email_template->template_sms_enable==1){

		    			$userRole  = $user_role; //for Customer
		    			$to 	   = ($this->input->post('country_code')) ? '+'.$this->input->post('country_code').''.$this->input->post('mobile') : $this->input->post('mobile');
		    			$param 	   = array(
		    				'site_name'  	  => SITE_NAME,
		    				'user_role'       => "Customer",
		                    'ticket_no'       => $ticket_no,
		                    'name'            => ucwords($this->input->post('name')),
		                    'email'           => $this->input->post('email'),
		                    'mobile_no'       => '+'.$this->input->post('country_code').' '.$this->input->post('mobile'),
		                    'subject'         => feedback_subject_status($this->input->post('subject')),
		                    'msg'             => $this->input->post('message'),
		                    'contactus_link'  => base_url('page/contact')
		                );
		    			$sendSMS = sendSMS($email_template, $to, $param, $userRole);


		    			$userRole  = 0; //for Admin
		    			$to 	   = get_option_url('PHONE');
		    			$param 	   = array(
		    				'site_name'  	  => SITE_NAME,
		    				'user_role'       => "Customer",
		                    'ticket_no'       => $ticket_no,
		                    'name'            => ucwords($this->input->post('name')),
		                    'email'           => $this->input->post('email'),
		                    'mobile_no'       => '+'.$this->input->post('country_code').' '.$this->input->post('mobile'),
		                    'subject'         => feedback_subject_status($this->input->post('subject')),
		                    'msg'             => $this->input->post('message'),
		                    'contactus_link'  => base_url('page/contact')
		                );
		    			$sendSMSAdmin = sendSMS($email_template, $to, $param, $userRole);
		    		}

		    	}
                //-------------**For Send email AND SMS-----------

    			$this->session->set_flashdata('msg_success', 'Thank you for contacting us! Your inquiry is submitted and will respond to you as soon as possible');    
    			redirect('page/contact'); 

    		}else{
    			$this->session->set_flashdata('msg_error', 'Sorry! Inquiry request process has been failed. please try again');
    			redirect('page/contact');          		
    		}
    		
    	}
		$data['countries'] = $this->Common_model->get_result('countries');
		$data['template']='frontend/contact';
	    $this->load->view('templates/frontend/front_template',$data);
	}

	public function order_status()
	{
		$this->_check_login(); //Customer authentication
		$data['title']='Order Status';
	    $data['template']='frontend/order_status';
	    $this->load->view('templates/frontend/front_template',$data);
	}

	public function aboutus()
	{
		$data['title']='About Us';
	    $data['template']='frontend/aboutus';
	    $this->load->view('templates/frontend/front_template',$data);
	}

	public function how_it_work()
	{
		$data['title']='How It Works';
	    $data['template']='frontend/how_it_work';
	    $this->load->view('templates/frontend/front_template',$data);
	}

	public function invoice()
	{
		$this->_check_login(); //Customer authentication
		$data['title']='Invoice';
	    $this->load->view('frontend/order/order-invoices');
	}


	public function product_detail()
	{
		$data['title']='Product Details';
	    $data['template']='frontend/product_detail';
	    $this->load->view('templates/frontend/front_template',$data);
	}

	public function cartpage()
	{
		$data['title']='Cart Details';
	    $data['template']='frontend/cart/cartpage';
	    $this->load->view('templates/frontend/front_template',$data);
	}


	public function shoppingbilling()
	{
		$data['title']='Shopping Billing';
	    $data['template']='frontend/cart/shoppingbilling';
	    $this->load->view('templates/frontend/front_template',$data);
	}

	public function order_review()
	{
		$this->_check_login(); //Customer authentication
		$data['title']='Order Review';
	    $data['template']='frontend/cart/order_review';
	    $this->load->view('templates/frontend/front_template',$data);
	}

	public function payment_successful()
	{
		$this->_check_login(); //Customer authentication
		$data['title']='Payment successfull';
	    $data['template']='frontend/cart/payment_successful';
	    $this->load->view('templates/frontend/front_template',$data);
	}

	public function payment_cancel()
	{
		$this->_check_login(); //Customer authentication
		$data['title']='Payment Cancel';
	    $data['template']='frontend/cart/payment_cancel';
	    $this->load->view('templates/frontend/front_template',$data);
	}

	public function login()
	{
		if(user_logged_in()===TRUE) redirect('account/dashboard');
		$data['title']='Customer Signin';

		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		
		if ($this->form_validation->run() == TRUE){
			$email = $this->input->post('email');
       		$password = $this->input->post('password');
			if($this->user_model->login($email,$password,'customers')){
				redirect(base_url('account/dashboard'));
			}else{
				redirect('page/login');
			}
		}
		
	    $this->load->view('frontend/login',$data);
	    /*$data['template']='frontend/login';
	    $this->load->view('templates/frontend/front_template',$data);*/
	}


	public function signup()
	{
		if(user_logged_in()===TRUE) redirect('account/dashboard');
		$data['title']='Customer Signup';

		$this->form_validation->set_rules('name', 'Full Name', 'trim|required');
    	$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
    	$this->form_validation->set_rules('country_code', 'Country Code', 'trim|required');
    	$this->form_validation->set_rules('mobile', 'Mobile No.', 'trim|required|numeric|min_length[9]|max_length[13]');
    	$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]'); 
    	$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
    	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    	if ($this->form_validation->run() == TRUE){

    		$salt = $this->salt();
    		$insert = [
	    		'user_name' => $this->input->post('name'),
	    		'salt' => $salt,
	    		'user_role' => 2,
	    		'status' => 1,
	    		'country_code' => $this->input->post('country_code'),
	    		'mobile' => $this->input->post('mobile'),
	    		'email' => $this->input->post('email'),
    			'password' => sha1($salt.sha1($salt.sha1($this->input->post('password')))),
    			'created' => date('Y-m-d H:i:s A'),
        		'modified' => date('Y-m-d H:i:s A')
    		];

    		if($id = $this->common_model->insert('users', $insert)){

    			//-------------For Send email AND SMS-----------

    			$email_template = $this->common_model->get_row('email_templates', array('id'=>1));
    			if(!empty($email_template)){
        			
        			//==-----------===Send Email==-----------
        			if($email_template->template_email_enable==1){

		    			$userRole  = 2; //for Customer
		    			$to 	   = $this->input->post('email');
		    			$param 	   = array(
		    				'site_name'       => SITE_NAME,
		    				'user_role'       => "Customer",
		                    'name'            => ucwords($this->input->post('name')),
		                    'user_email'      => $this->input->post('email'),
		                    'user_mobile'     => $this->input->post('country_code').' '.$this->input->post('mobile'),
		                    'password'        => $this->input->post('password'),
		                    'login_link'      => '<a target="_blank" href="'.base_url('page/login').'">Click here to Login</a>',
		                    'contactus_link'  => base_url('page/contact')
		                );
		    			$sendEmail = sendEmail($email_template, $to, $param, $userRole);


		    			$userRole  = 0; //for Admin
		    			$adminEMAIl= get_option_url('EMAIl');
		    			$to 	   = (!empty($adminEMAIl)) ? $adminEMAIl : SUPPORT_EMAIL;
		    			$param 	   = array(
		    				'site_name'       => SITE_NAME,
		                    'user_role'       => "Customer",
		                    'name'            => ucwords($this->input->post('name')),
		                    'user_email'      => $this->input->post('email'),
		                    'user_mobile'     => $this->input->post('country_code').' '.$this->input->post('mobile'),
		                    'password'        => $this->input->post('password'),
		                    'profile_view'    => '<a target="_blank" href="'.base_url('backend/user/view/2/'.$id).'">Click here to View Profile details</a>',
		                    'contactus_link'  => base_url('page/contact')
		                );
		    			$sendEmailAdmin = sendEmail($email_template, $to, $param, $userRole);
		    		}

		    		//==-----------===Send SMS==-----------===
		    		if($email_template->template_sms_enable==1){

		    			$userRole  = 2; //for Customer
		    			$to 	   = ($this->input->post('country_code')) ? '+'.$this->input->post('country_code').''.$this->input->post('mobile') : $this->input->post('mobile');
		    			$param 	   = array(
		    				'site_name'       => SITE_NAME,
		    				'user_role'       => "Customer",
		                    'name'            => ucwords($this->input->post('name')),
		                    'user_email'      => $this->input->post('email'),
		                    'user_mobile'     => $this->input->post('country_code').' '.$this->input->post('mobile'),
		                    'password'        => $this->input->post('password'),
		                    'login_link'      => '<a target="_blank" href="'.base_url('page/login').'">Click here to Login</a>',
		                    'contactus_link'  => base_url('page/contact')
		                );
		    			$sendSMS = sendSMS($email_template, $to, $param, $userRole);


		    			$userRole  = 0; //for Admin
		    			$to 	   = get_option_url('PHONE');
		    			$param 	   = array(
		    				'site_name'       => SITE_NAME,
		    				'user_role'       => "Customer",
		                    'name'            => ucwords($this->input->post('name')),
		                    'user_email'      => $this->input->post('email'),
		                    'user_mobile'     => $this->input->post('country_code').' '.$this->input->post('mobile'),
		                    'password'        => $this->input->post('password'),
		                    'profile_view'    => '<a target="_blank" href="'.base_url('backend/user/view/2/'.$id).'">Click here to View Profile details</a>',
		                    'contactus_link'  => base_url('page/contact')
		                );
		    			$sendSMSAdmin = sendSMS($email_template, $to, $param, $userRole);
		    		}

		    	}
                //-------------**For Send email AND SMS-----------

    			$encrypted_id = base64_encode($id);
    			$this->session->set_flashdata('msg_success', 'Thanks to be registered! A confirmation email has been sent on your registered email address'); 
        		redirect('page/login'); 
    		}else{
    			$this->session->set_flashdata('msg_error', 'Sorry! Registration process has been failed. please try again'); 
        		redirect('page/signup'); 
    		}
    	}

    	$data['phnCode']=$this->common_model->get_result('countries',array(),array('sortname','phonecode'),array('name','asc'));
	    $this->load->view('frontend/signup',$data);

	}


	public function forgotpassword()
	{
		if(user_logged_in()===TRUE) redirect('account/dashboard');
		$data['title']='Forgot Password';

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    	if ($this->form_validation->run() == TRUE){ 
    		
    		if($user=$this->common_model->get_row('users',array('email'=>trim($_POST['email']), 'user_role'=>2))){

                $new_password_key=trim(md5($user->email));
                $updateResult = $this->common_model->update('users',array('new_password_key'=>$new_password_key,'new_password_requested'=>date('Y-m-d H:i:s')),array('user_id'=>$user->user_id));
                if($updateResult){

                	$email_template = $this->common_model->get_row('email_templates', array('id'=>2));
    				if(!empty($email_template)){

                	//-------------For Send email AND SMS-----------

    					if($email_template->template_email_enable==1){
		                	$userRole  = 2; //for Customer
			    			$to 	   = $user->email;
			    			$param 	   = array(
			    				  'site_name'       => SITE_NAME,
								  'name'            => ucwords($user->user_name),
		                          'user_email'      => $user->email,
								  'activation_key'  =>'<a href="'.base_url().'page/reset_password/'.$new_password_key.'"><strong>'.base_url().'page/reset_password/'.$new_password_key.'</strong></a>',
								  'contactus_link'  => base_url('page/contact')
							);
			    			$sendEmail = sendEmail($email_template, $to, $param, $userRole);
	    				}

	    				if($email_template->template_sms_enable==1){
		                	$userRole  = 2; //for Customer
			    			$to 	   = ($user->country_code) ? '+'.$user->country_code.''.$user->mobile : $user->mobile;
			    			$param 	   = array(
			    				  'site_name'       => SITE_NAME,
								  'name'            => ucwords($user->user_name),
		                          'user_email'      => $user->email,
								  'activation_key'  =>'<a href="'.base_url().'page/reset_password/'.$new_password_key.'"><strong>'.base_url().'page/reset_password/'.$new_password_key.'</strong></a>',
								  'contactus_link'  => base_url('page/contact')
							);
			    			$sendSMS = sendSMS($email_template, $to, $param, $userRole);
	    				}

	            	}

	            	//-------------For Send email AND SMS-----------

	                $msg_success='<p>Password reset instructions have been sent to <strong>'.$user->email.'</strong>. Don\'t forget to check your spam and junk folders if it didn\'t show up.</p>';
	                $this->session->set_flashdata('msg_success',$msg_success);
	                redirect('page/forgotpassword');

                }
            }else{              
                $this->session->set_flashdata('msg_error', 'Your email address isn\'t available in our records');
                redirect('page/forgotpassword');
            }
    	}

	    $this->load->view('frontend/forgotpassword',$data);

	}



    public function reset_password($activation_key=''){ 

        $data['title']= "Reset Password";  
        if(empty($activation_key)){ 
        	redirect('page/forgotpassword'); 
        }

        $this->form_validation->set_rules('password', "Password", 'trim|required|min_length[6]|matches[confpassword]');
        $this->form_validation->set_rules('confpassword', "Confirm Password", 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() == TRUE){
          $user=$this->common_model->get_row('users',array('new_password_key'=>trim($activation_key)));
          if($user==FALSE){
            $this->session->set_flashdata('msg_error', "Your activation key has been expired.");
            redirect('page/forgotpassword');
          }

          $now = date('Y-m-d H:i:s');
          $expire_time = date('Y-m-d H:i:s',strtotime($user->new_password_requested . "+24 hours"));
          $salt = $this->salt();
          if($now <= $expire_time) {
            $user_data  = array(
              'salt'    =>$salt, 
              'password' => sha1($salt.sha1($salt.sha1($this->input->post('password')))),
              'new_password_key'=>'');            
              
            if($this->common_model->update('users',$user_data,array('user_id'=>$user->user_id))){

                $email_template = $this->common_model->get_row('email_templates', array('id'=>3));
				if(!empty($email_template)){

	        	//-------------For Send email AND SMS-----------

					if($email_template->template_email_enable==1){
	                	$userRole  = 2; //for Customer
		    			$to 	   = $user->email;
		    			$param 	   = array(
		    				  'site_name'       => SITE_NAME,
							  'name'            => ucwords($user->first_name.' '.$user->last_name),
	                          'user_role'       => "Customer",
	                          'password'        => $this->input->post('password'),
	                          'login_link'      => '<a target="_blank" href="'.base_url('page/login').'">Click here to Login</a>',
							  'contactus_link'  => base_url('page/contact')
						);
		    			$sendEmail = sendEmail($email_template, $to, $param, $userRole);
					}

					if($email_template->template_sms_enable==1){
	                	$userRole  = 2; //for Customer
		    			$to 	   = ($user->country_code) ? '+'.$user->country_code.''.$user->mobile : $user->mobile;
		    			$param 	   = array(
		    				  'site_name'       => SITE_NAME,
							  'name'            => ucwords($user->first_name.' '.$user->last_name),
	                          'user_role'       => "Customer",
	                          'password'        => $this->input->post('password'),
	                          'login_link'      => '<a target="_blank" href="'.base_url('page/login').'">Click here to Login</a>',
							  'contactus_link'  => base_url('page/contact')
						);
		    			$sendSMS = sendSMS($email_template, $to, $param, $userRole);
					}

	        	}

	        	//-------------For Send email AND SMS-----------

				$this->session->set_flashdata('msg_success', "Your password has been changed successfully! Now you can Login with your new password.");
				redirect('page/login');
            }
          }else {

            $user_data  = array('new_password_key'=>'');            
            if($this->common_model->update('users',$user_data,array('user_id'=>$user->user_id))){   
              $this->session->set_flashdata('msg_error', "Your activation key has been expired.");
            }
            redirect('page/forgotpassword');
          }
        }

        $this->load->view('frontend/reset_password',$data);
        /*$data['template']='frontend/reset_password';
	    $this->load->view('templates/frontend/front_template',$data);*/
    }


	public function _404()
	{
		$data['title']='404 Not Found';
	    $data['template']='frontend/404.php';
	    $this->load->view('templates/frontend/front_template',$data);
	}


	function salt() {
		return substr(md5(uniqid(rand(), true)), 0, 10);
	}


	public  function add_email_subscription(){
				
		$this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[email_subscription.email_id]');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run() == TRUE){      	
            $user_id = (user_id()) ? user_id() : 0;    	
     		$insert = [
	    		'email_id' => $this->input->post('email'),
	    		'subscription_type' => $this->input->post('subscription_type'),
	    		'user_id' => $user_id,
	    	];
	    	$insertdata = $this->common_model->insert('email_subscription',$insert);
	    	if($insertdata){

	    		$user_info = $this->common_model->get_row('users',array('user_id'=>$user_id));

				//-------------For Send email AND SMS-----------
				$email_template = $this->common_model->get_row('email_templates', array('id'=>12));
				if(!empty($email_template)){
				  
					//==-----------===Send Email==-----------
					if($email_template->template_email_enable==1){

					  $userRole  = $user_info->user_role; //for Seller/Customer
					  $to        = $this->input->post('email');
					  $param     = array(
					      'site_name'           => SITE_NAME,
					      'name'         		=> ucwords($user_info->user_name),
					      'email'       	    => $this->input->post('email')
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
					      'email'       	    => $this->input->post('email')
					  );
					  $sendSMS = sendSMS($email_template, $to, $param, $userRole);

					}

				}
				//-------------**For Send email AND SMS-----------
	    		
				$data = json_encode(array('status'=>'success', 'msg'=>'Thanks for subscribing! Please check your email for further instructions'));
					echo $data;
			}else{
				$data = json_encode(array('status'=>'failed', 'msg'=>'Sorry! Something went to wrong!'));
					echo $data;
			}
		}else{   
			$errors = $this->form_validation->error_array();
			$data = json_encode(array('status'=>'validationfailed','msg'=>$errors));
			echo $data; 		   
    	}
    	
	}

	
	private function getTicket_No(){
		return $rnd_no = md5(uniqid(rand(100000, 999999), true));
	}

	function email_exists()
	{
	   $email = $this->input->post('email');
	   $emailexists = $this->common_model->get_row('email_subscription',array('email_id'=>$email,'status'=>1));
	   if(!empty($emailexists))
	   {
	   	 $count = count($emailexists);
	   	  if ($count==1) {
	       echo 1;
	     } else {
	         echo 0;
	    }
	   }   
	}

	public function slider()
	{
		/*For Most rated or most discounted products*/
	    $this->load->model('product_model');
	    $most_rated = $this->product_model->product_featured('', 1, 0, 20, '', '', array('total_rating'));
	    if(!empty($most_rated) && count($most_rated)>=5){
	    	$data['most_rated_or_discounted'] = $most_rated;
	    	$data['most_ratedDiscounted_heading'] = "Most Rated Products";
	    }else{
	    	$most_discounted = $this->product_model->product_featured('', 1, 0, 20, '', '', array('most_discounted'));
	    	$data['most_rated_or_discounted'] = $most_discounted;
	    	$data['most_ratedDiscounted_heading'] = "Most Discounted Products";
	    }

	    /*For Recent or latest added products*/
	    
		 $data['template']='frontend/404.php';
	    $this->load->view('slider',$data);
	}


	public function header_autocomplete(){

		// process posted form data
        $keyword = $this->input->post('term');
        $data['response'] = 'false'; //Set default response
        $query = $this->common_model->getAutoSearchKeywords($keyword); //Search DB

        if(!empty($query)){
            $data['response'] = 'true'; //Set response
            $data['message'] = array(); //Create array
            foreach($query as $row)
            {
            	if(substr($row->category_name, 0,1) == '"' && substr($row->category_name,-1) == '"'){
				    $category_name = explode("," , $row->category_name);
                    foreach ($category_name as $value){
                    	$data['message'][] = array(
		                	'id'=> trim(substr($value, 1, -1), '"'),
		                    'value' => trim(substr($value, 1, -1), '"'),
		                    '' 
		                );  //Add a row to array*/
                    }
				}else{
					$data['message'][] = array(
	                	'id'=>$row->category_name,
	                    'value' => $row->category_name,
	                    '' 
	                );  //Add a row to array
				}
            }
        }

        if('IS_AJAX'){
            echo json_encode($data); //echo json string if ajax request
        }
	}

}

