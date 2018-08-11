<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Seller extends CI_Controller {

	public function __construct(){
        parent::__construct();
        clear_cache();
        $this->load->model('superadmin_model');
    }

	public function index(){
		redirect('seller/login');
	}

	private function _check_login(){
	    if(seller_logged_in()===FALSE){
	      redirect('seller/login');
	    }else{
	      $info = $this->common_model->get_row('users',array('user_id'=>seller_id()));
	      if(empty($info)){
	        $this->session->unset_userdata('seller_info');
	        redirect('seller/login');
	      }
	    }
	}

	private function _check_stepForm(){    
	    $id = seller_id();
	    $encrypted_id = base64_encode(seller_id());

	    $sellerInfo = $this->common_model->get_row('users', array('user_id' => $id, 'user_role'=>1), array('user_name','confirmation_code','business_name','skipped'));
	    if(empty($sellerInfo)) 
	        redirect('seller/login');

	    if($sellerInfo->confirmation_code!='verified') 
	        redirect('seller/phone_verification/'.$encrypted_id);

	    if(!empty($sellerInfo->skipped)){
	      $skipped = json_decode($sellerInfo->skipped);
	      $status = $skipped->status;
	      if($status==0){
	      	$lastPage = end($skipped->skipped_pages);
	      	redirect(base_url('seller/'.$lastPage.'/'.$encrypted_id));
	      }
	    }       
	}

	public function _remap($method, $params = array())
	{
        if (method_exists($this, $method))
        {
       	   return call_user_func_array(array($this, $method), $params);
        }else{
        	$this->page($method);
        }
        redirect(base_url('page/_404'));
	}

	public function page($slug='')
	{
		$data['pageDetails']=$pageDetails=$this->common_model->get_row('pages',array('slug'=>$slug, 'type_of_section'=>2, 'status'=>1));
		if(!empty($pageDetails)){
			$data['title']= ucfirst($pageDetails->title);
		}else{
			$data['title']='Page';
		}
		
	    $data['template']='seller/page';
	    $this->load->view('templates/seller/template',$data);
	}

    public function login(){
		if(seller_logged_in()===TRUE) redirect('seller/dashboard');
		$data['title']='Selling on '.SITE_NAME;

		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');

		if ($this->form_validation->run() == TRUE){
			$this->load->model('user_model');
			$email = $this->input->post('email');
       		$password = $this->input->post('password');
			if($this->user_model->login($email,$password,'seller')){
				$selleradmin_name = selleradmin_name();
				$this->session->set_flashdata('msg_success', 'Welcome '.$selleradmin_name.', You have logged in successfully');
				redirect('seller/dashboard');
			}else{
				redirect('seller/login');
			}
		}
		
		$data['template']='seller/login';
	    $this->load->view('templates/seller/template',$data);
	}
	

	public function register()
	{
		if(seller_logged_in()===TRUE) redirect('seller/dashboard');
		$data['title']='Selling on '.SITE_NAME;

		$this->form_validation->set_rules('name', 'Full Name', 'trim|required');
    	$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
    	$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]'); 
    	$this->form_validation->set_rules('re_password', 'Confirm Password', 'trim|required|matches[password]');
    	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    	if ($this->form_validation->run() == TRUE){ 
    		$salt = $this->salt();
    		$insert = [
	    		'user_name' => $this->input->post('name'),
	    		'salt' => $salt,
	    		'user_role' => 1,
	    		'status' => 1,
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
		    				'site_name'  	  => SITE_NAME,
		    				'user_role'       => "Seller",
		                    'name'            => ucwords($this->input->post('name')),
		                    'user_email'      => $this->input->post('email'),
		                    'user_mobile'     => "-",
		                    'password'        => $this->input->post('password'),
		                    'login_link'      => '<a target="_blank" href="'.base_url('seller/login').'">Click here to Login</a>',
		                    'contactus_link'  => base_url('page/contact')
		                );
		    			$sendEmail = sendEmail($email_template, $to, $param, $userRole);


		    			$userRole  = 0; //for Admin
		    			$adminEMAIl= get_option_url('EMAIl');
		    			$to 	   = (!empty($adminEMAIl)) ? $adminEMAIl : SUPPORT_EMAIL;
		    			$param 	   = array(
		    				'site_name'  	  => SITE_NAME,
		    				'user_role'       => "Seller",
		                    'name'            => ucwords($this->input->post('name')),
		                    'user_email'      => $this->input->post('email'),
		                    'user_mobile'     => "-",
		                    'password'        => $this->input->post('password'),
		                    'profile_view'    => '<a target="_blank" href="'.base_url('backend/user/view/1/'.$id).'">Click here to View Profile details</a>',
		                    'contactus_link'  => base_url('page/contact')
		                );
		    			$sendEmailAdmin = sendEmail($email_template, $to, $param, $userRole);
		    		}

		    	}
                //-------------**For Send email AND SMS-----------
    			
    			$encrypted_id = base64_encode($id);
    			if($insert['status']==2){
    				$this->session->set_flashdata('msg_success', 'Thanks to be registered! A confirmation email has been sent on your registered email address & account will be activated within 2-3 business days'); 
        			redirect('seller/login'); 
    			}else{
    				$this->load->model('user_model');
    				if($this->user_model->login($this->input->post('email'), $this->input->post('password'), 'seller')){
						$selleradmin_name = selleradmin_name();
						$this->session->set_flashdata('msg_success', 'Thanks to be registered! A confirmation email has been sent on your registered email address');
						redirect('seller/dashboard');
					}else{
						redirect('seller/login');
					}
    			}
    			
    		}else{
    			$this->session->set_flashdata('msg_error', 'Something went wrong. please try again'); 
        		redirect('seller/register'); 
    		}
    	}
        $data['template']='seller/signup';
	    $this->load->view('templates/seller/template',$data);
	}


	public function skip($page='', $encrypted_id=''){
		if(seller_logged_in()===FALSE) redirect('seller/login');
		$data['encrypted_id']=$encrypted_id;
		$id = base64_decode($encrypted_id);

		$data['sellerInfo'] = $sellerInfo = $this->common_model->get_row('users', array('user_id' => $id, 'user_role'=>1), array('skipped'));

		if(empty($sellerInfo->skipped)){
			if($page=='phone_verification'){
				$skippedArr = array('status'=>0, 'skipped_pages'=>array('agreement_step','phone_verification'));
			}else if($page=='seller_information'){
				$skippedArr = array('status'=>0, 'skipped_pages'=>array('agreement_step','phone_verification','seller_information'));
			}else if($page=='seller_interview'){
				$skippedArr = array('status'=>0, 'skipped_pages'=>array('agreement_step','phone_verification','seller_information','seller_interview'));
			}else if($page=='shipment_option'){
				$skippedArr = array('status'=>0, 'skipped_pages'=>array('agreement_step','phone_verification','seller_information','seller_interview','shipment_option'));
			}else if($page=='signature_or_licence'){
				$skippedArr = array('status'=>0, 'skipped_pages'=>array('agreement_step','phone_verification','seller_information','seller_interview','shipment_option','signature_or_licence'));
			}else if($page=='seller_dashboard'){
				$skippedArr = array('status'=>1, 'skipped_pages'=>array('agreement_step','phone_verification','seller_information','seller_interview','shipment_option','signature_or_licence','seller_dashboard'));
			}
			$data = array('skipped'=>json_encode($skippedArr));
			$this->common_model->update('users', $data, array('user_id'=>$id));
		}else{
			$skipped = json_decode($sellerInfo->skipped);
			if($skipped->status==0){
				if($page=='phone_verification'){
					$skippedArr = array('status'=>0, 'skipped_pages'=>array('agreement_step','phone_verification'));
				}else if($page=='seller_information'){
					$skippedArr = array('status'=>0, 'skipped_pages'=>array('agreement_step','phone_verification','seller_information'));
				}else if($page=='seller_interview'){
					$skippedArr = array('status'=>0, 'skipped_pages'=>array('agreement_step','phone_verification','seller_information','seller_interview'));
				}else if($page=='shipment_option'){
					$skippedArr = array('status'=>0, 'skipped_pages'=>array('agreement_step','phone_verification','seller_information','seller_interview','shipment_option'));
				}else if($page=='signature_or_licence'){
					$skippedArr = array('status'=>0, 'skipped_pages'=>array('agreement_step','phone_verification','seller_information','seller_interview','shipment_option','signature_or_licence'));
				}else if($page=='seller_dashboard'){
					$skippedArr = array('status'=>1, 'skipped_pages'=>array('agreement_step','phone_verification','seller_information','seller_interview','shipment_option','signature_or_licence','seller_dashboard'));
				}
				$data = array('skipped'=>json_encode($skippedArr));
				$this->common_model->update('users', $data, array('user_id'=>$id));
			}
		}
		redirect('seller/'.$page.'/'.$encrypted_id);
	}


	public function agreement_step($encrypted_id=''){
		if(seller_logged_in()===FALSE) redirect('seller/login');
		$data['title']='Selling on '.SITE_NAME;
		$data['encrypted_id']=$encrypted_id;
		$id = base64_decode($encrypted_id);
		if(empty($id)) redirect('seller/login');

		$data['sellerInfo'] = $sellerInfo = $this->common_model->get_row('users', array('user_id' => $id, 'user_role'=>1), array('confirmation_code','user_name','skipped'));

		if(empty($sellerInfo)) 
			redirect('seller/login');

    	$this->form_validation->set_rules('business_name', 'Business Legal Name', 'trim|required');
    	$this->form_validation->set_rules('accept_TAC', 'Terms & Condition checkbox', 'trim|required');
    	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    	if ($this->form_validation->run() == TRUE){

    		$user_data = [
	    		'business_name' => 	$this->input->post('business_name')
    		];

    		if(!empty($sellerInfo->skipped)){
		      $skipped = json_decode($sellerInfo->skipped);
		      $countPage = count($skipped->skipped_pages);
		      if($countPage < 7){
		      	$user_data['skipped'] =	json_encode(array('status'=>0, 'skipped_pages'=>array('agreement_step')));
		      }
		    }

    		if($this->common_model->update('users', $user_data, array('user_id'=>$id))){
    			$this->session->set_flashdata('msg_success', 'Your Business name added successfully'); 
        		redirect('seller/phone_verification/'.$encrypted_id); 
    		}else{
    			$this->session->set_flashdata('msg_error', 'Something went wrong. please try again'); 
        		redirect('seller/agreement_step/'.$encrypted_id); 
    		}
    	}

		$data['template']='seller/agreement_step';
	    $this->load->view('templates/seller/template',$data);
	}


	public function phone_verification($encrypted_id=''){
		//echo $encrypted_id; die;
		if(seller_logged_in()===FALSE) redirect('seller/login');
		$data['title'] = 'Verify your Phoneno.';
		$data['encrypted_id'] = $encrypted_id;
    	$id = base64_decode($encrypted_id);
		if(empty($id)) redirect('seller/login');

		$data['sellerInfo'] = $sellerInfo = $this->common_model->get_row('users', array('user_id' => $id, 'user_role'=>1), array('confirmation_code','user_name','skipped'));
		if(empty($sellerInfo)) 
			redirect('seller/login');

		$data['business_info'] = $business_info = $this->common_model->get_row('business_info', array('seller_id' => $id));
		$data['seller_interview'] = $seller_interview = $this->common_model->get_row('seller_interview', array('seller_id' => $id));
		$data['seller_signature_and_licence'] = $seller_signature_and_licence = $this->common_model->get_row('seller_signature_and_licence', array('seller_id' => $id));
		$data['phnCode']=$this->common_model->get_result('countries',array(),array('sortname','phonecode'),array('name','asc'));

		$data['menus'] = 'seller/steps/menus'; 
		$data['template']='seller/steps/phone_verification';
	    $this->load->view('templates/seller/template',$data);
	}


	public function confirmPhoneCheck($encrypted_id=''){
		$id = base64_decode($this->input->post('id'));
    	$verify_no = $this->input->post('verify_no');

        $phoneUser = $this->common_model->get_row('users',array('user_id'=>$id),array('confirmation_code'));
        if($phoneUser){
        	if($phoneUser->confirmation_code==$verify_no){

        		$confirmation_code = "verified";
        		$skippedArr = array('status'=>0, 'skipped_pages'=>array('agreement_step', 'phone_verification','seller_information'));

	        	$user_data = array('confirmation_code' => $confirmation_code, 'skipped'		=>	json_encode($skippedArr));
	            if($this->superadmin_model->update('users', $user_data, array('user_id'=>$id))){
	               echo json_encode(array('status' => 'success', 'msg'=>'Your Phone No. has been Verified successfully'));
				}else{
				   echo json_encode(array('status' => 'failed', 'msg'=>'You have entered the wrong OTP'));
				}
        	}else{
        		echo json_encode(array('status' => 'failed', 'msg'=>'You have entered the wrong OTP'));
        	}
        }else{
        	echo json_encode(array('status' => 'failed', 'msg'=>'You have entered the wrong OTP'));
        }
	}

	public function seller_information($encrypted_id=''){
		if(seller_logged_in()===FALSE) redirect('seller/login');
		$data['title'] = 'Seller Information';
		$data['encrypted_id'] = $encrypted_id;
		$id = base64_decode($encrypted_id);
    	
		$data['sellerInfo'] = $sellerInfo = $this->common_model->get_row('users', array('user_id' => $id, 'user_role'=>1), array('confirmation_code','user_name','skipped','country_code','mobile'));
		if(empty($sellerInfo)) 
			redirect('seller/login');
		if($sellerInfo->confirmation_code!='verified') 
			redirect('seller/phone_verification/'.$encrypted_id);

		$data['business_info']    = $business_info    = $this->common_model->get_row('business_info', array('seller_id' => $id));
	
		$data['seller_interview'] = $seller_interview = $this->common_model->get_row('seller_interview', array('seller_id' => $id));
		$data['seller_signature_and_licence'] = $seller_signature_and_licence = $this->common_model->get_row('seller_signature_and_licence', array('seller_id' => $id));


		$this->form_validation->set_rules('store_name', 'Store Name', 'trim');
		$this->form_validation->set_rules('category[]', 'category', 'required');
		$this->form_validation->set_rules('owner_name', 'Owner Name', 'trim');
		$this->form_validation->set_rules('contact_email', 'Email Address', 'trim');
		$this->form_validation->set_rules('country_code', 'Country Code', 'trim');
		$this->form_validation->set_rules('mobile', 'Mobile No.', 'trim|numeric|min_length[9]|max_length[13]');
		$this->form_validation->set_rules('alternate_no', 'Alternate No.', 'trim|numeric|min_length[9]|max_length[13]');
		$this->form_validation->set_rules('address', 'Address', 'trim');
		$this->form_validation->set_rules('country', 'Country', 'trim');
		$this->form_validation->set_rules('state', 'State', 'trim');
		$this->form_validation->set_rules('city', 'City', 'trim');
		$this->form_validation->set_rules('zip', 'Postal Code', 'trim|min_length[4]|max_length[8]');
    	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    	if ($this->form_validation->run() == TRUE){

    		$insert = [
	    		'seller_id' => $id,
	    		'store_name' => $this->input->post('store_name'),
	    		'category' => json_encode($this->input->post('category')),
	    		'owner_name' => $this->input->post('owner_name'),
	    		'contact_email' => $this->input->post('contact_email'),
	    		'country_code' => $this->input->post('country_code'),
	    		'mobile' => $this->input->post('mobile'),
	    		'alternate_no' => $this->input->post('alternate_no'),
	    		'address' => $this->input->post('address'),
	    		'country' => $this->input->post('country'),
	    		'state' => $this->input->post('state'),
	    		'city' => $this->input->post('city'),
	    		'zip' => $this->input->post('zip')
    		];

    		$insertUser = [
	    		'address' => $this->input->post('address'),
	    		'country' => $this->input->post('country'),
	    		'province' => $this->input->post('state'),
	    		'city' => $this->input->post('city'),
	    		'zip' => $this->input->post('zip')
    		];

    		if(!empty($sellerInfo->skipped)){
		      $skipped = json_decode($sellerInfo->skipped);
		      $countPage = count($skipped->skipped_pages);
		      if($countPage < 7){
		      	$insertUser['skipped'] = json_encode(array('status'=>0, 'skipped_pages'=>array('agreement_step','phone_verification','seller_information','seller_interview')));
		      }
		    }

    		if(empty($business_info)){
    			$insert['created_at'] = date('Y-m-d H:i:s A');
    			$insert['updated_at'] = date('Y-m-d H:i:s A');
    			$resUser = $this->common_model->update('users', $insertUser, array('user_id'=>$id));
    			$res = $this->common_model->insert('business_info', $insert);
    			$this->session->set_flashdata('msg_success', 'Your Store Information added successfully');
    		}else{
    			$insert['updated_at'] = date('Y-m-d H:i:s A');
    			$resUser = $this->common_model->update('users', $insertUser, array('user_id'=>$id));
    			$res = $this->common_model->update('business_info', $insert, array('seller_id'=>$id));
    			$this->session->set_flashdata('msg_success', 'Your Store Information updated successfully');
    		}
    		if($res){
        		redirect('seller/seller_interview/'.$encrypted_id); 
    		}else{
    			$this->session->set_flashdata('msg_error', 'Something went wrong. please try again'); 
        		redirect('seller/seller_information/'.$encrypted_id); 
    		}
    	}
    	$this->load->model('seller_model');
		$data['country'] = $this->common_model->get_result('countries', '', array('name,id'), array('name','asc'));
		$data['category'] = $this->seller_model->get_Categories();
		$data['phnCode']=$this->common_model->get_result('countries',array(),array('sortname','phonecode'),array('name','asc'));
		$data['template']='seller/steps/seller_information';
	    $this->load->view('templates/seller/template',$data);
	}

	public function seller_interview($encrypted_id=''){
		if(seller_logged_in()===FALSE) redirect('seller/login');
		$data['title'] = 'Seller Interview';
		$data['encrypted_id'] = $encrypted_id;
    	$id = base64_decode($encrypted_id);
    	$subcategory = '';

    	$data['sellerInfo'] = $sellerInfo = $this->common_model->get_row('users', array('user_id' => $id, 'user_role'=>1), array('confirmation_code','user_name','skipped'));
		if(empty($sellerInfo)) 
			redirect('seller/login');
		if($sellerInfo->confirmation_code!='verified') 
			redirect('seller/phone_verification/'.$encrypted_id);

		$data['business_info']    = $business_info    = $this->common_model->get_row('business_info', array('seller_id' => $id));
		$data['seller_interview'] = $seller_interview = $this->common_model->get_row('seller_interview', array('seller_id' => $id));
		$data['seller_signature_and_licence'] = $seller_signature_and_licence = $this->common_model->get_row('seller_signature_and_licence', array('seller_id' => $id));

		$this->form_validation->set_rules('annual_turnover', '', 'trim');
		$this->form_validation->set_rules('how_much_sell', '', 'trim');
		$this->form_validation->set_rules('sell_in_otherwebsite', '', 'trim');
    	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    	if ($this->form_validation->run() == TRUE){

    		$sell_in_otherwebsite_url = "";
    		if($this->input->post('sell_in_otherwebsite')=='Yes'){
    			$sell_in_otherwebsite_url = $this->input->post('sell_in_otherwebsite_url');
    		}

    		$insert = [
	    		'seller_id' => $id,
	    		'get_product_from' => json_encode($this->input->post('get_product_from')),
	    		'annual_turnover' => $this->input->post('annual_turnover'),
	    		'how_much_sell' => $this->input->post('how_much_sell'),
	    		'sell_in_otherwebsite' => $this->input->post('sell_in_otherwebsite'),
	    		'sell_in_otherwebsite_url' => $sell_in_otherwebsite_url
    		];

    		if(empty($seller_interview)){
    			$insert['created_at'] = date('Y-m-d H:i:s A');
    			$insert['updated_at'] = date('Y-m-d H:i:s A');
    			$res = $this->common_model->insert('seller_interview', $insert);
    			$this->session->set_flashdata('msg_success', 'Seller interview information added successfully');
    		}else{
    			$insert['updated_at'] = date('Y-m-d H:i:s A');
    			$res = $this->common_model->update('seller_interview', $insert, array('seller_id'=>$id));
    			$this->session->set_flashdata('msg_success', 'Seller interview information updated successfully');
    		}
    		if($res){
    			if(!empty($sellerInfo->skipped)){
			      $skipped = json_decode($sellerInfo->skipped);
			      $countPage = count($skipped->skipped_pages);
			      if($countPage < 7){
			      	$this->common_model->update('users', array('skipped' => json_encode(array('status'=>0, 'skipped_pages'=>array('agreement_step','phone_verification','seller_information','seller_interview','shipment_option')))), array('user_id'=>$id));
			      }
			    }
        		redirect('seller/shipment_option/'.$encrypted_id); 
    		}else{
    			$this->session->set_flashdata('msg_error', 'Something went wrong. please try again'); 
        		redirect('seller/seller_interview/'.$encrypted_id); 
    		}
    	}
    	
    	$this->load->model('seller_model');
    	$category = (!empty($business_info->category)) ? json_decode($business_info->category) : "";
    	$data['categories'] = $this->seller_model->get_Categories($category);
		$data['subcategories'] = $subcategory = $this->seller_model->get_subCatUsingCategory($category);
		//p($data['categories']); die;

		$data['template']='seller/steps/seller_interview';
	    $this->load->view('templates/seller/template',$data);
	}


	public function shipment_option($encrypted_id=''){

		if(seller_logged_in()===FALSE) redirect('seller/login');
		$data['title'] = 'Shipment Option';
		$data['encrypted_id'] = $encrypted_id;
    	$id = base64_decode($encrypted_id);

    	$data['sellerInfo'] = $sellerInfo = $this->common_model->get_row('users', array('user_id' => $id, 'user_role'=>1), array('confirmation_code','user_name','skipped'));
		if(empty($sellerInfo)) 
			redirect('seller/login');
		if($sellerInfo->confirmation_code!='verified') 
			redirect('seller/phone_verification/'.$encrypted_id);

		$data['business_info']    = $business_info    = $this->common_model->get_row('business_info', array('seller_id' => $id));
		$data['seller_interview'] = $seller_interview = $this->common_model->get_row('seller_interview', array('seller_id' => $id));
		$data['choose_shippingOption'] = $choose_shippingOption = $this->common_model->get_result('shipping_option', array());
		$data['seller_signature_and_licence'] = $seller_signature_and_licence = $this->common_model->get_row('seller_signature_and_licence', array('seller_id' => $id));

		$this->form_validation->set_rules('shipment_option', 'Shipment Option', 'trim');
    	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    	if ($this->form_validation->run() == TRUE){ 
    		$shipping_country = ($this->input->post('shipment_option')==1) ? $this->input->post('shipping_country') : 0;
    		$insert = [
	    		'shipment_option' => $this->input->post('shipment_option'),
	    		'shippping_type'  => json_encode($this->input->post('shippping_type')),
	    		'shipping_country' => $shipping_country
    		];

    		if($res = $this->common_model->update('business_info', $insert, array('seller_id'=>$id))){
    			if(!empty($business_info->shippping_type) && !empty($business_info->shipment_option)) 
    				$msgContent = "updated"; 
    			else 
    				$msgContent = "added";

    			if(!empty($sellerInfo->skipped)){
			      $skipped = json_decode($sellerInfo->skipped);
			      $countPage = count($skipped->skipped_pages);
			      if($countPage < 7){
			      	$this->common_model->update('users', array('skipped' => json_encode(array('status'=>0, 'skipped_pages'=>array('agreement_step','phone_verification','seller_information','seller_interview','shipment_option','signature_or_licence')))), array('user_id'=>$id));
			      }
			    }
    			$this->session->set_flashdata('msg_success', 'Shipment option information '.$msgContent.' successfully');
        		redirect('seller/signature_or_licence/'.$encrypted_id); 
    		}else{
    			$this->session->set_flashdata('msg_error', 'Something went wrong. please try again'); 
        		redirect('seller/shipment_option/'.$encrypted_id); 
    		}
    	}

    	$data['country'] = $this->common_model->get_result('countries', '', array('name,id'), array('name','asc'));
		$data['template']='seller/steps/shipment_option';
	    $this->load->view('templates/seller/template',$data);
	}


	public function signature_or_licence($encrypted_id=''){
        if(seller_logged_in()===FALSE) redirect('seller/login');
		$data['title'] = 'Signature/Licence Information';
		$data['encrypted_id'] = $encrypted_id;
    	$id = base64_decode($encrypted_id);


    	$data['sellerInfo'] = $sellerInfo = $this->common_model->get_row('users', array('user_id' => $id, 'user_role'=>1), array('confirmation_code','user_name','email','country_code','mobile','skipped'));
		if(empty($sellerInfo)) 
			redirect('seller/login');
		if($sellerInfo->confirmation_code!='verified') 
			redirect('seller/phone_verification/'.$encrypted_id);

		$data['business_info']    = $business_info    = $this->common_model->get_row('business_info', array('seller_id' => $id));
		$data['seller_interview'] = $seller_interview = $this->common_model->get_row('seller_interview', array('seller_id' => $id));
		$data['seller_signature_and_licence'] = $seller_signature_and_licence = $this->common_model->get_row('seller_signature_and_licence', array('seller_id' => $id));

		$this->form_validation->set_rules('proof_of_name', 'Proof Of Name and DOB', 'trim');
		$this->form_validation->set_rules('proof_of_address', 'Proof Of Address', 'trim');

		if(empty($seller_signature_and_licence->proof_of_name_attachment)){
			if (isset($_POST['proof_of_name']) && !empty($_POST['proof_of_name'])){
				$this->form_validation->set_rules('proof_of_name_attachment', 'Attachment (Proof of name and DOB)', 'callback_NameDOB_Attachment_Check');
			}
		}else{
			if (isset($_POST['proof_of_name']) && !empty($_FILES['proof_of_name_attachment']['name'])){
				$this->form_validation->set_rules('proof_of_name_attachment', 'Attachment (Proof of name and DOB)', 'callback_NameDOB_Attachment_Check');
			}
		}
		

		if(empty($seller_signature_and_licence->proof_of_address_attachment)){
			if (isset($_POST['proof_of_address']) && !empty($_POST['proof_of_address'])){
	        	$this->form_validation->set_rules('proof_of_address_attachment', 'Attachment (Proof of Address)', 'callback_Address_Attachment_Check');
	        }
		}else{
			if (isset($_POST['proof_of_address']) && !empty($_FILES['proof_of_address_attachment']['name'])){
	        	$this->form_validation->set_rules('proof_of_address_attachment', 'Attachment (Proof of Address)', 'callback_Address_Attachment_Check');
	        }
		}
		

        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE){ 

			$insert = [
				'seller_id'            => $id,
				'proof_of_name'        => $this->input->post('proof_of_name'),
				'proof_of_address'     => $this->input->post('proof_of_address'),
				'verification_status'  => 2,
				'created_at'           => date('Y-m-d H:i:s A'),
				'updated_at'           => date('Y-m-d H:i:s A')
			];
			 
			$businessCurrency = [
	    		'bitcoin_address' 	   => $this->input->post('bitcoin_address'),
	    		'ethereum_address'	   => $this->input->post('ethereum_address'),
	    		'litecoin_address'	   => $this->input->post('litecoin_address'),
	    		'cazcoin_address'	   => $this->input->post('cazcoin_address'),
	    		'paypal_primary_email' => $this->input->post('paypal_primary_email')
    		];

			if ($this->session->userdata('NameDOB_Attachment_Check') != '') {
				$NameDOB_Attachment_Check         = $this->session->userdata('NameDOB_Attachment_Check');
				$insert['proof_of_name_attachment']  = $NameDOB_Attachment_Check['proof_of_name_attachment'];
				$this->session->unset_userdata('NameDOB_Attachment_Check'); 
			}
			if ($this->session->userdata('proof_of_address_attachment') != '') {
				$Address_Attachment_Check         = $this->session->userdata('proof_of_address_attachment');
				$insert['proof_of_address_attachment']  = $Address_Attachment_Check['proof_of_address_attachment'];
				$this->session->unset_userdata('Address_Attachment_Check'); 
			}

			$this->common_model->update('business_info', $businessCurrency, array('seller_id'=>$id));
			if(empty($seller_signature_and_licence)){
				$result = $this->common_model->insert('seller_signature_and_licence', $insert);
				if($result){

					//-------------For Send email AND SMS-----------

	    			$email_template = $this->common_model->get_row('email_templates', array('id'=>4));
	    			if(!empty($email_template)){
	        			
	        			//==-----------===Send Email==-----------
	        			if($email_template->template_email_enable==1){

			    			$userRole  = 1; //for Seller
			    			$to 	   = $sellerInfo->email;
			    			$param 	   = array(
			    				'name'       => ucwords($sellerInfo->user_name),
			    				'site_name'  => SITE_NAME
			                );
			    			$sendEmail = sendEmail($email_template, $to, $param, $userRole);


			    			$userRole  = 0; //for Admin
			    			$adminEMAIl= get_option_url('EMAIl');
			    			$to 	   = (!empty($adminEMAIl)) ? $adminEMAIl : SUPPORT_EMAIL;
			    			$param 	   = array(
			    				'site_name'  	  => SITE_NAME,
			                    'name'            => ucwords($sellerInfo->user_name),
			                    'email'      	  => $sellerInfo->email,
			                    'link'      	  => '<a target="_blank" href="'.base_url('backend/user/view/1/'.$sellerInfo->user_id).'">Click here to view the profile details</a>',
			                );
			    			$sendEmailAdmin = sendEmail($email_template, $to, $param, $userRole);
			    		}

			    		//==-----------===Send SMS==-----------===
			    		if($email_template->template_sms_enable==1){

			    			$userRole  = 2; //for Customer
			    			$to 	   = ($seller_info->country_code) ? '+'.$seller_info->country_code.''.$seller_info->mobile : $seller_info->mobile;
			    			$param 	   = array(
			    				'name'       => ucwords($sellerInfo->user_name),
			    				'site_name'  => SITE_NAME
			                );
			    			$sendSMS = sendSMS($email_template, $to, $param, $userRole);


			    			$userRole  = 0; //for Admin
			    			$to 	   = get_option_url('PHONE');
			    			$param 	   = array(
			    				'site_name'       => SITE_NAME,
			                    'name'            => ucwords($sellerInfo->user_name),
			                    'email'           => $sellerInfo->email,
			                    'link'      	  => '<a target="_blank" href="'.base_url('backend/user/view/1/'.$sellerInfo->user_id).'">Click here to view the profile details</a>',
			                );
			    			$sendSMSAdmin = sendSMS($email_template, $to, $param, $userRole);
			    		}

			    	}
	                //-------------**For Send email AND SMS-----------

				}
				$this->session->set_flashdata('msg_success', 'Congratulations, you have successfully completed all the steps. Your account is now awaiting verification approval. This will be completed within 3 business days.');
			}else{
				$result = $this->common_model->update('seller_signature_and_licence', $insert, array('seller_id'=>$id));
				$this->session->set_flashdata('msg_success', 'Your account information updated successfully. Account is now awaiting verification approval. This will be completed within 3 business days.');
			}

			if($result){
				if(!empty($sellerInfo->skipped)){
			      $skipped = json_decode($sellerInfo->skipped);
			      $countPage = count($skipped->skipped_pages);
			      if($countPage < 7){
			      	$this->common_model->update('users', array('skipped' => json_encode(array('status'=>1, 'skipped_pages'=>array('agreement_step','phone_verification','seller_information','seller_interview','shipment_option','signature_or_licence','seller_dashboard')))), array('user_id'=>$id));
			      }
			    }
        		redirect('seller/seller_dashboard/'.$encrypted_id); 
    		}else{
    			$this->session->set_flashdata('msg_error', 'Something went wrong. please try again'); 
        		redirect('seller/signature_or_licence/'.$encrypted_id); 
    		}
		}

		$data['template']='seller/steps/signature_or_licence';
	    $this->load->view('templates/seller/template',$data);
	}


	public function seller_dashboard($encrypted_id=''){		

		if(seller_logged_in()===FALSE) redirect('seller/login');
		$data['title'] = 'Seller Dashboard';
		$data['encrypted_id'] = $encrypted_id;
    	$id = base64_decode($encrypted_id);


		$data['sellerInfo'] = $sellerInfo = $this->common_model->get_row('users', array('user_id' => $id, 'user_role'=>1), array('user_name','confirmation_code','skipped'));
		if(empty($sellerInfo)) 
			redirect('seller/login');
		if($sellerInfo->confirmation_code!='verified') 
			redirect('seller/phone_verification/'.$encrypted_id);

		$data['business_info']    = $business_info    = $this->common_model->get_row('business_info', array('seller_id' => $id));
		$data['seller_interview'] = $seller_interview = $this->common_model->get_row('seller_interview', array('seller_id' => $id));
		$data['seller_signature_and_licence'] = $seller_signature_and_licence = $this->common_model->get_row('seller_signature_and_licence', array('seller_id' => $id));


		$data['template']='seller/steps/seller_dashboard';
	    $this->load->view('templates/seller/template',$data);
	}


	public function login_though_sellerDashboard($encrypted_id=''){

		if(seller_logged_in()===TRUE) redirect('seller/dashboard');
		$data['encrypted_id'] = $encrypted_id;
    	$id = base64_decode($encrypted_id);

    	$data['sellerInfo'] = $sellerInfo = $this->common_model->get_row('users', array('user_id' => $id, 'user_role'=>1), array('user_name','confirmation_code','email','password'));

    	if(seller_id()){
    		$this->load->model('user_model');
	    	$res = $this->user_model->login_though_sellerDashboard($sellerInfo->email,$sellerInfo->password);
			if($res){
				$selleradmin_name = selleradmin_name();
				$this->session->set_flashdata('msg_success', 'Welcome '.$selleradmin_name.', You have logged in successfully');
				redirect('seller/dashboard');
			}else{
				redirect('seller/login');
			}
    	}else{
    		redirect('seller/login');
    	}
	}


	public function forgot_password()
	{
		if(seller_logged_in()===TRUE) redirect('seller/dashboard');
		$data['title']='Forgot Password';

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
    	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    	if ($this->form_validation->run() == TRUE){ 
    		
    		if($user=$this->common_model->get_row('users',array('email'=>trim($_POST['email']), 'user_role'=>1))){

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
			    				  'site_name'  	    => SITE_NAME,
								  'name'            => ucwords($user->user_name),
		                          'user_email'      => $user->email,
								  'activation_key'  =>'<a href="'.base_url().'seller/reset_password/'.$new_password_key.'"><strong>'.base_url().'seller/reset_password/'.$new_password_key.'</strong></a>',
								  'contactus_link'  => base_url('page/contact')
							);
			    			$sendEmail = sendEmail($email_template, $to, $param, $userRole);
	    				}

	    				if($email_template->template_sms_enable==1){
		                	$userRole  = 2; //for Customer
			    			$to 	   = ($user->country_code) ? '+'.$user->country_code.''.$user->mobile : $user->mobile;
			    			$param 	   = array(
			    				  'site_name'  	    => SITE_NAME,
								  'name'            => ucwords($user->user_name),
		                          'user_email'      => $user->email,
								  'activation_key'  =>'<a href="'.base_url().'seller/reset_password/'.$new_password_key.'"><strong>'.base_url().'seller/reset_password/'.$new_password_key.'</strong></a>',
								  'contactus_link'  => base_url('page/contact')
							);
			    			$sendSMS = sendSMS($email_template, $to, $param, $userRole);
	    				}

	            	}

	            	//-------------For Send email AND SMS-----------

	                $msg_success='<p>Password reset instructions have been sent to <strong>'.$user->email.'</strong>. Don\'t forget to check your spam and junk folders if it didn\'t show up.</p>';
	                $this->session->set_flashdata('msg_success',$msg_success);
	                redirect('seller/forgot_password');

                }
            }else{              
                $this->session->set_flashdata('msg_error', 'Your email address is not in our records');
                redirect('seller/forgot_password');
            }

    	}

	    $data['template']='seller/forgot_password';
	    $this->load->view('templates/seller/template',$data);
	}



    public function reset_password($activation_key=''){ 

        $data['title']= "Reset Password";  
        if(empty($activation_key)){ 
        	redirect('seller/forgot_password'); 
        }

        $this->form_validation->set_rules('password', "Password", 'trim|required|min_length[6]|matches[confpassword]');
        $this->form_validation->set_rules('confpassword', "Confirm Password", 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() == TRUE){
          $user=$this->common_model->get_row('users',array('new_password_key'=>trim($activation_key)));
          if($user==FALSE){
            $this->session->set_flashdata('msg_error', "Your activation key has been expired.");
            redirect('seller/forgot_password');
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
		    				  'site_name'  	    => SITE_NAME,
							  'name'            => ucwords($user->user_name),
	                          'user_role'       => "Seller",
	                          'password'        => $this->input->post('password'),
	                          'login_link'      => '<a target="_blank" href="'.base_url('seller/login').'">Click here to Login</a>',
							  'contactus_link'  => base_url('page/contact')
						);

		    			$sendEmail = sendEmail($email_template, $to, $param, $userRole);
					}

					if($email_template->template_sms_enable==1){
	                	$userRole  = 2; //for Customer
		    			$to 	   = ($user->country_code) ? '+'.$user->country_code.''.$user->mobile : $user->mobile;
		    			$param 	   = array(
		    				  'site_name'  	    => SITE_NAME,
							  'name'            => ucwords($user->user_name),
	                          'user_role'       => "Seller",
	                          'password'        => $this->input->post('password'),
	                          'login_link'      => '<a target="_blank" href="'.base_url('seller/login').'">Click here to Login</a>',
							  'contactus_link'  => base_url('page/contact')
						);
		    			$sendSMS = sendSMS($email_template, $to, $param, $userRole);
					}

	        	}

	        	//-------------For Send email AND SMS-----------

				$this->session->set_flashdata('msg_success', "Your password has been changed successfully, Now you can Login with your new password.");
				redirect('seller/login');
            }
          }else {
            $user_data  = array('new_password_key'=>'');            
            if($this->common_model->update('users',$user_data,array('user_id'=>$user->user_id))){   
              $this->session->set_flashdata('msg_error', "Your activation key has been expired.");
            }
            redirect('seller/forgot_password');
          }
        }

        $data['template']="seller/reset_password";
        $this->load->view('templates/seller/template',$data);
    }


	public function logout(){
		$this->_check_login(); //check  login authentication
		$this->session->unset_userdata('seller_info');
		redirect('seller/login');
	}
    

    public function dashboard(){   
        $this->_check_login(); //check login authentication
	    $this->_check_stepForm(); //check registration step authentication

	    $data['title']='Dashboard';
	    $data['stat_today_orders'] = $this->superadmin_model->getOrder_countAndTotal(seller_id(), 1);
	    $data['stat_sevenDays_orders'] = $this->superadmin_model->getOrder_countAndTotal(seller_id(), 7);
	    $data['stat_fifteenDays_orders'] = $this->superadmin_model->getOrder_countAndTotal(seller_id(), 15);
		$data['stat_thirtyDays_orders'] = $this->superadmin_model->getOrder_countAndTotal(seller_id(), 30);
		$data['stat_all_orders'] = $this->superadmin_model->getOrder_countAndTotal(seller_id(), '');
		$data['stat_sevenDays_salesData'] = array();
		$stat_sevenDays_salesData = $this->superadmin_model->getOrder_salesData(seller_id(), 7);
		if(!empty($stat_sevenDays_salesData)){
			$data['stat_sevenDays_salesData'] = json_encode($stat_sevenDays_salesData, JSON_NUMERIC_CHECK);
		}

		$data['support'] = $this->common_model->get_result('support',array('user_id'=>seller_id(),'parent_id'=>0,'mark_complete'=>0),array(),array('support_id','DESC'));
	    $data['template']='seller/account/dashboard';
	    $this->load->view('templates/seller/template',$data);
    }


    public function country_rates($productBased='', $product_variation_id='', $shipment_rate_id=''){
	    $this->_check_login(); //check login authentication
	    $this->_check_stepForm(); //check registration step authentication
	    if(!empty($productBased)){
	    	if($productBased!='product_based'){
		    	redirect('seller/products/index');
		    }
	    }
	    if(!empty($product_variation_id)){
	    	$data['product_variations']    = $product_variations    = $this->common_model->get_row('product_variations', array('seller_id' => seller_id(), 'product_variation_id' => $product_variation_id));
	    	if(empty($product_variations)) redirect('seller/products/index');
	    }
	    if(!empty($shipment_rate_id)){
	    	$data['shipmentrate_setting']    = $shipmentrate_setting    = $this->common_model->get_row('shipmentrate_setting', array('seller_id' => seller_id(), 'shipment_rate_id' => $shipment_rate_id, 'type' => 1));
	    }else{
	    	if($productBased!='product_based'){
	    		$data['shipmentrate_setting']    = $shipmentrate_setting    = $this->common_model->get_row('shipmentrate_setting', array('seller_id' => seller_id(), 'type' => 0));
	    	}
	    }

	    $data['title']='Rates Of Countries';
	    $data['pagination']='';
 	    if(isset($_POST['subCountryData'])){
	    	$countryTempData=array();

	    	$type = ($productBased!='' || !empty($shipment_rate_id)) ? '1' : '0';
	    	$countryData = $this->input->post('country');

	    	$data  = array(
				'seller_id'	 =>	seller_id(),
				'country'    =>	json_encode($countryData),
				'type'    	 =>	$type,
				'created_at' => date('Y-m-d H:i:s A')
			);

	    	$tempURL = "";
			if(!empty($productBased) && !empty($shipment_rate_id) && !empty($product_variation_id)){
				$tempURL = $productBased.'/'.$product_variation_id.'/'.$shipment_rate_id;
			}elseif (!empty($productBased) && !empty($product_variation_id)) {
				$tempURL = $productBased.'/'.$product_variation_id;
			}elseif (!empty($productBased)) {
				$tempURL = $productBased;
			}

	    	if(empty($shipmentrate_setting)){
	    		$data['created_at'] = date('Y-m-d H:i:s A');
	    		$res = $this->superadmin_model->insert('shipmentrate_setting', $data);
	    		if(!empty($res) && !empty($product_variation_id)){
	    			$this->superadmin_model->update('product_variations', array('shipment_rate_type'=>2, 'shipment_rate_id'=>$res),array('seller_id'=>seller_id(), 'product_variation_id'=>$product_variation_id));
	    		}
	    		if (!empty($productBased) && !empty($product_variation_id)  && !empty($res)) {
					$tempURL = $productBased.'/'.$product_variation_id.'/'.$res;
				}
				$this->session->set_flashdata('msg_success','Shipment rates for the country added successfully');
	    	}else{
	    		if(!empty($shipment_rate_id)){
	    			$res = $this->superadmin_model->update('shipmentrate_setting', $data,array('seller_id'=>seller_id(), 'shipment_rate_id'=>$shipment_rate_id));
	    		}else{
	    			$res = $this->superadmin_model->update('shipmentrate_setting', $data,array('seller_id'=>seller_id()));
	    		}
	    		$this->session->set_flashdata('msg_success','Shipment rates for the country updated successfully');
	    	}

			if($res){
				redirect('seller/country_rates/'.$tempURL);
			}else{
				$this->session->set_flashdata('msg_error','Something went wrong. Please try again');
				redirect('seller/country_rates/'.$tempURL);
			}

	    }


	    $segment2 = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : $this->session->userdata('previous');
	    if(!empty($segment2)){
	    	$segment2 = array_reverse(explode('/', $segment2));
		    if(!empty($segment2) && !empty($segment2[0]) && !empty($segment2[1])){
		    	if($segment2[1]!='country_rates' && $segment2[1]!='province_rates' && $segment2[1]!='cities_rates'){
			    	$this->session->set_userdata('previous', $_SERVER['HTTP_REFERER']);
			    }
		    }
	    }

	    $data['product_variation_id']=$product_variation_id;
	    $data['productBased']=$productBased;
	    $data['shipment_rate_id']=$shipment_rate_id;
	    
	    $data['business_info'] = $this->common_model->get_row('business_info', array('seller_id' => seller_id()),array('shipment_option','shipping_country','shippping_type'));
	    $data['country'] = $this->common_model->get_result('countries', '', array('name,id'), array('name','asc'));
	    $data['template']='seller/shipping_rates/country_rates';
	    $this->load->view('templates/seller/template',$data);
    }

    public function province_rates($country='', $productBased='', $shipment_rate_id=''){ 

	    $this->_check_login(); //check login authentication
	    $this->_check_stepForm(); //check registration step authentication

	    $data['title']='Rates Of Provinces';

	    if(!empty($productBased)){
	    	if($productBased!='product_based'){
		    	redirect('seller/products/index');
		    }
	    }

	    if(!empty($shipment_rate_id)){
	    	$data['shipmentrate_setting']    = $shipmentrate_setting    = $this->common_model->get_row('shipmentrate_setting', array('seller_id' => seller_id(), 'shipment_rate_id' => $shipment_rate_id, 'type' => 1));
	    	if(empty($shipmentrate_setting)) redirect('seller/products/index');
	    }else{
	    	if($productBased!='product_based'){
	    		$data['shipmentrate_setting']    = $shipmentrate_setting    = $this->common_model->get_row('shipmentrate_setting', array('seller_id' => seller_id(), 'type' => 0));
	    	}
	    }


	    if(isset($_POST['subStateData'])){

	    	$stateTempData=array();
	    	$cityTempData=array();
	    	$array = array();

	    	$stateData = (array) $this->input->post('state');
	    	$stateTempData = (array) json_decode($shipmentrate_setting->state);
	    	/* for state data*/
	    	foreach ($stateData as $key => $value){
	    		$count=0;
	    		foreach($value as $k=> $v){
	    			if($v!='')
	    				$count++;
	    		}
	    		if($count && !empty($stateTempData[$key])){
	    			$stateTempData[$key]=$value;
	    			//$stateTempData[$key]=$value;
	    		}else if($count && empty($stateTempData[$key])){
	    			$stateTempData[$key]=$value;
	    		}else if($count==0 && !empty($stateTempData[$key])){
	    			unset($stateTempData[$key]);
	    		}
	    	}
	    	

	    	$data  = array(
				'state'    	 =>	json_encode($stateData)
			);

	    	$tempURL = "";
			if(!empty($productBased) && !empty($shipment_rate_id)){
				$tempURL = '/'.$productBased.'/'.$shipment_rate_id;
			}elseif (!empty($productBased)) {
				$tempURL = '/'.$productBased;
			}

			if(!empty($shipment_rate_id)){
    			$res = $this->superadmin_model->update('shipmentrate_setting', $data,array('seller_id'=>seller_id(), 'shipment_rate_id'=>$shipment_rate_id));
    		}else{
    			$res = $this->superadmin_model->update('shipmentrate_setting', $data,array('seller_id'=>seller_id()));
    		}

			if($res){
				$this->session->set_flashdata('msg_success','Shipment rates for the province updated successfully');
				redirect('seller/province_rates/'.$country.$tempURL);
			}else{
				$this->session->set_flashdata('msg_error','Something went wrong. Please try again');
				redirect('seller/province_rates/'.$country.$tempURL);
			}

	    }

	    $data['country']=$country;
	    $data['productBased']=$productBased;
	    $data['shipment_rate_id']=$shipment_rate_id;
	    $data['business_info']    = $business_info    = $this->common_model->get_row('business_info', array('seller_id' => seller_id()),array('shipment_option','shipping_country','shippping_type'));
	    $data['state'] = $this->common_model->get_result('states', array('country_id'=>$country),'', array('name','asc'));
	    $data['template']='seller/shipping_rates/province_rates';
	    $this->load->view('templates/seller/template',$data);
    }

    public function cities_rates($province='', $productBased='', $shipment_rate_id=''){   

	    $this->_check_login(); //check login authentication
	    $this->_check_stepForm(); //check registration step authentication

	    $data['title']='Rates Of Cities';


	    if(!empty($productBased)){
	    	if($productBased!='product_based'){
		    	redirect('seller/products/index');
		    }
	    }

	    if(!empty($shipment_rate_id)){
	    	$data['shipmentrate_setting']    = $shipmentrate_setting    = $this->common_model->get_row('shipmentrate_setting', array('seller_id' => seller_id(), 'shipment_rate_id' => $shipment_rate_id, 'type' => 1));
	    	if(empty($shipmentrate_setting)) redirect('seller/products/index');
	    }else{
	    	if($productBased!='product_based'){
	    		$data['shipmentrate_setting']    = $shipmentrate_setting    = $this->common_model->get_row('shipmentrate_setting', array('seller_id' => seller_id(), 'type' => 0));
	    	}
	    }

	    if(isset($_POST['subCityData'])){

	    	$cityTempData=array();


	    	$cityData = (array) $this->input->post('city');
	    	$cityTempData = (array) json_decode($shipmentrate_setting->city);
	    	/* for city data*/
	    	foreach ($cityData as $key => $value){
	    		$count=0;
	    		foreach($value as $k=> $v){
	    			if($v!='')
	    				$count++;
	    		}
	    		if($count && !empty($cityTempData[$key])){
	    			$cityTempData[$key]=$value;
	    		}else if($count && empty($cityTempData[$key])){
	    			$cityTempData[$key]=$value;
	    		}else if($count==0 && !empty($cityTempData[$key])){
	    			unset($cityTempData[$key]);
	    		}
	    	}


	    	$data  = array(
				'city'    	 =>	json_encode($cityTempData)
			);

	    	$tempURL = "";
			if(!empty($productBased) && !empty($shipment_rate_id)){
				$tempURL = '/'.$productBased.'/'.$shipment_rate_id;
			}elseif (!empty($productBased)) {
				$tempURL = '/'.$productBased;
			}

			if(!empty($shipment_rate_id)){
    			$res = $this->superadmin_model->update('shipmentrate_setting', $data,array('seller_id'=>seller_id(), 'shipment_rate_id'=>$shipment_rate_id));
    			if($res){
					$this->session->set_flashdata('msg_success','Shipment cities rates updated successfully');
					redirect('seller/products/index');
				}else{
					$this->session->set_flashdata('msg_error','Something went wrong. Please try again');
					redirect('seller/cities_rates/'.$province.$tempURL);
				}
    		}else{
    			$res = $this->superadmin_model->update('shipmentrate_setting', $data,array('seller_id'=>seller_id()));
    			if($res){
					$this->session->set_flashdata('msg_success','Shipment rates for the city updated successfully');
					redirect('seller/cities_rates/'.$province.$tempURL);
				}else{
					$this->session->set_flashdata('msg_error','Something went wrong. Please try again');
					redirect('seller/cities_rates/'.$province.$tempURL);
				}
    		}
	    }

	    $data['province']=$province;
	    $data['productBased']=$productBased;
	    $data['shipment_rate_id']=$shipment_rate_id;
	    $data['business_info']    = $business_info    = $this->common_model->get_row('business_info', array('seller_id' => seller_id()),array('shipment_option','shipping_country','shippping_type'));
	    $data['city'] = $this->common_model->get_result('cities', array('state_id'=>$province),'', array('name','asc'));
	    $data['template']='seller/shipping_rates/city_rates';
	    $this->load->view('templates/seller/template',$data);
    }

	public function profile(){
		$this->_check_login(); //check login authentication
		$data['title']='Account Details';
		$this->form_validation->set_rules('user_name', 'Full Name', 'required');
		$this->form_validation->set_rules('country_code', 'Country Code', 'trim|required');
		$this->form_validation->set_rules('business_name', 'Business Name', 'trim|required');
    	$this->form_validation->set_rules('mobile', 'Mobile No.', 'trim|required|numeric|min_length[9]|max_length[13]');
		$this->form_validation->set_rules('country', 'Country', 'trim|required');
		$this->form_validation->set_rules('province', 'Province', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('zip', 'Postal Code', 'trim|min_length[4]|max_length[8]');
		$this->form_validation->set_rules('address', 'Address', 'trim');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE)	{

			$user_data  = array(
				'user_name'	=>	$this->input->post('user_name'),
				'gender'	=>	$this->input->post('gender'),
				'business_name'	=>	$this->input->post('business_name'),
				'country_code'		=>	$this->input->post('country_code'),
				'mobile'		=>	$this->input->post('mobile'),
				'country'		=>	$this->input->post('country'),
				'province'		=>	$this->input->post('province'),
				'city'		=>	$this->input->post('city'),
				'zip'		=>	$this->input->post('zip'),
				'address'		=>	$this->input->post('address'),
				'modified' => date('Y-m-d H:i:s A')
			);
			if($this->superadmin_model->update('users', $user_data,array('user_id'=>seller_id()))){
				 $this->session->set_flashdata('msg_success','Your account details updated successfully');
				redirect('seller/profile');
			}else{
				$this->session->set_flashdata('msg_error','Sorry! Updation process has been failed, Please try again');
				redirect('seller/profile');
			}
		}

		$data['country'] = $this->common_model->get_result('countries', '', array('name,id'), array('name','asc'));
		$data['phnCode']=$this->common_model->get_result('countries',array(),array('sortname','phonecode'),array('name','asc'));
		$data['user'] = $this->superadmin_model->get_row('users', array('user_id'=>seller_id()));
		$data['template']='seller/account/profile';
		$this->load->view('templates/seller/template',$data);
	}

	public function change_password(){

		$this->_check_login(); //check login authentication
		$this->_check_stepForm(); //check registration step authentication

		$data['title']='Change Password';
		$this->form_validation->set_rules('oldpassword', 'Old Password', 'trim|required|callback_password_check');
		$this->form_validation->set_rules('newpassword', 'New Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('confpassword','Confirm Password', 'trim|required|matches[newpassword]');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE){
			$salt = $this->salt();
			$user_data  = array('salt'=>$salt,'password' => sha1($salt.sha1($salt.sha1($this->input->post('newpassword')))));
			if($this->superadmin_model->update('users',$user_data,array('user_id'=>seller_id()))){
				$this->session->set_flashdata('msg_success','Your password has been updated successfully');
				redirect('seller/change_password');
			}else{
				$this->session->set_flashdata('msg_error','Sorry! updation process has been failed, Please try again');
				redirect('seller/change_password');
			}
		}
		$data['template']='seller/account/change_password';
		$this->load->view('templates/seller/template',$data);
	}

	public function create_category(){   
   
		$data['title']='Create category';
		$this->form_validation->set_rules('category_name',"Category Name", 'required|trim');
		$this->form_validation->set_rules('short_description', "Short description", 'required|trim|max_length[165]');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE)  {
			$seller_id = seller_id();
			$insert = [
				  'user_id'			  => $seller_id,
		          'category_name'     => trim($this->input->post('category_name')),
		          'category_slug'     => url_title(trim($this->input->post('category_name')), 'dash', true),
		          'short_description' => $this->input->post('short_description'),
		          'meta_title'        => trim($this->input->post('category_name')),
		          'meta_keyword'      => trim($this->input->post('category_name')),
		          'meta_description'  => $this->input->post('short_description'),
		          'status'            => 1,
		          'adminstatus'       => 2,
		          'parent_id'         => 0,
		          'commision'         => get_option_url('COMMISION_FEE'),
		          'created_at'        => date('Y-m-d H:i:s A')
	      	];

			if($user_id=$this->common_model->insert('category', $insert)){
				$this->session->set_flashdata('msg_success', 'Category added successfully');
				redirect('seller/seller_information/'.base64_encode($seller_id));
			}else{
				$this->session->set_flashdata('theme_danger', "Sorry! Category added process has been failed. please try again");
				redirect('seller/seller_information/'.base64_encode($seller_id));
			} 
		}       
    }


    public function create_subcategory(){   
   
		$data['title']='Create subcategory';
		$this->form_validation->set_rules('category_name',"Category Name", 'required|trim');
		$this->form_validation->set_rules('short_description', "Short description", 'required|trim|max_length[165]');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE)  {
			$seller_id = seller_id();
			$insert = [
				  'user_id'			  => $seller_id,
		          'category_name'     => trim($this->input->post('category_name')),
		          'category_slug'     => url_title(trim($this->input->post('category_name')), 'dash', true),
		          'short_description' => $this->input->post('short_description'),
		          'meta_title'        => trim($this->input->post('category_name')),
		          'meta_keyword'      => trim($this->input->post('category_name')),
		          'meta_description'  => $this->input->post('short_description'),
		          'status'            => 1,
		          'adminstatus'       => 2,
		          'parent_id'         => $this->input->post('parent_id'),
		          'commision'         => get_option_url('COMMISION_FEE'),
		          'created_at'        => date('Y-m-d H:i:s A')
	      	];

			if($user_id=$this->common_model->insert('category', $insert)){
				$this->session->set_flashdata('msg_success', 'Subcategory added successfully');
				redirect('seller/seller_interview/'.base64_encode($seller_id));
			}else{
				$this->session->set_flashdata('theme_danger', "Sorry! Category added process has been failed. please try again");
				redirect('seller/seller_interview/'.base64_encode($seller_id));
			}
		}        
    }

	public function password_check($oldpassword){

		$this->_check_login(); //check login authentication
		$this->_check_stepForm(); //check registration step authentication

		$this->load->model('user_model');
		$user_info = $this->user_model->get_row('users',array('user_id'=>seller_id()));
        $salt = $user_info->salt;
		if($this->common_model->password_check(array('password'=>sha1($salt.sha1($salt.sha1($oldpassword)))),seller_id())){
			return TRUE;
		}else{
			$this->form_validation->set_message('password_check', 'The %s does not match');
			return FALSE;
		}

	}
	
  	function salt() {
		return substr(md5(uniqid(rand(), true)), 0, 10);
	}

	function confirmation_code() {
		$output=str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
		return $output;
	}
 	
    public function error_404(){
    	$this->_check_login(); //check login authentication
		$data['template']='seller/error_404';		
		$this->load->view('templates/seller/template',$data);
	}

    public function generateConfirmation($id='')
    {
    	$id = $this->input->post('id');
    	$phone = $this->input->post('phone');
    	$country_code = $this->input->post('country_code');
    	$strlenphone = strlen($this->input->post('phone'));

    	if(!empty($phone) && $phone!='' && $strlenphone<=13 && $strlenphone>=9){
    		$id = base64_decode($id);
	        $users = $this->common_model->get_row('users',array('user_id!='=>$id, 'mobile'=>$phone));
	        if(empty($users)){
	        	$confirmation_code = $this->confirmation_code();

	        	$user_data = array('confirmation_code' => $confirmation_code, 'mobile' => $phone, 'country_code' => $country_code);
	        	$this->superadmin_model->update('users', $user_data,array('user_id'=>$id));
	        	$senderID = senderID;
				$mobile   = '+'.$country_code.''.$phone;
				$authkey  = authkeyForSMS;
				$message  = 'Your One time passcode is '.$confirmation_code;

				$apiLink = "http://api.msg91.com/api/sendotp.php?authkey=".$authkey."&mobile=".$mobile."&message=".$message."&sender=".$senderID."&otp=".$confirmation_code;

	        	$response = file_get_contents($apiLink);
	        	if(!empty($response)){

		        	$user_data = array('confirmation_code' => $confirmation_code, 'mobile' => $phone, 'country_code' => $country_code);
		            if($this->superadmin_model->update('users', $user_data,array('user_id'=>$id))){
		               echo json_encode(array('status' => 'success', 'code'=>$confirmation_code));
					}else{
					   echo json_encode(array('status' => 'failed', 'code'=>''));
					}
				}else{
					echo json_encode(array('status' => 'failed', 'code'=>'', 'msg'=>'Message not sent! Please check your Phone No.'));
				}
	        }else{
	        	echo json_encode(array('status' => 'failed', 'code'=>'', 'msg'=>'This Phone Number is already exist'));
	        }  
    	}else{
    		echo json_encode(array('status' => 'failed', 'code'=>'', 'msg'=>'Please enter a valid Phone Number'));
    	}  
    }


    public function checkBusinessEmail($email='')
    {
    	$id = base64_decode($this->input->post('id'));
    	$email = $this->input->post('email');
    	$id = base64_decode($id);

        $users = $this->common_model->get_row('business_info',array('seller_id'=>$id, 'contact_email'=>$email));
        if(empty($users)){
        	echo json_encode(array('status' => 'success'));
        }else{
        	echo json_encode(array('status' => 'failed'));
        }    
    }


    public function checkBusinessPhoneNo($phone='')
    {
    	$id = base64_decode($this->input->post('id'));
    	$phone = $this->input->post('phone');
    	$id = base64_decode($id);

        $users = $this->common_model->get_row('business_info',array('seller_id'=>$id, 'mobile'=>$phone));
        if(empty($users)){
        	echo json_encode(array('status' => 'success'));
        }else{
        	echo json_encode(array('status' => 'failed'));
        }    
    }

	public function NameDOB_Attachment_Check($file=''){

		if(empty($_FILES['proof_of_name_attachment']['name'])){
			$this->form_validation->set_message('NameDOB_Attachment_Check', 'Please choose the attachment of Name/DOB'); 
			return FALSE;
		}else{
			$config['upload_path'] = 'assets/uploads/seller/signature_or_licence_copy/proof_of_name_and_DOB/'; 
			$config['allowed_types'] = 'jpg|png|jpeg|pdf|doc'; 
			$config['max_size'] = '5024'; 
			$config['max_width'] = '5024'; 
			$config['max_height'] = '5024'; 
			$this->load->library('upload', $config); 
			$this->upload->initialize($config); 
			if (!$this->upload->do_upload('proof_of_name_attachment')){ 
				$this->form_validation->set_message('NameDOB_Attachment_Check', $this->upload->display_errors()); 
				return FALSE; 
			}else{ 
				$data = $this->upload->data(); // upload image 
				$this->session->set_userdata('NameDOB_Attachment_Check', array('proof_of_name_attachment' => $data['file_name'])); 
				return TRUE; 
			}
		} 
	}


	public function Address_Attachment_Check($file=''){
		if(empty($_FILES['proof_of_address_attachment']['name'])){
			$this->form_validation->set_message('Address_Attachment_Check', 'Please choose the attachment of Address');
			return FALSE;
		}else{

			$config['upload_path'] = 'assets/uploads/seller/signature_or_licence_copy/proof_of_address/'; 
			$config['allowed_types'] = 'jpg|png|jpeg|pdf|doc'; 
			$config['max_size'] = '5024'; 
			$config['max_width'] = '5024'; 
			$config['max_height'] = '5024'; 
			$this->load->library('upload', $config); 
			$this->upload->initialize($config); 
			if (!$this->upload->do_upload('proof_of_address_attachment')){ 
				$this->form_validation->set_message('Address_Attachment_Check', $this->upload->display_errors()); 
				return FALSE; 
			}else{ 
				$data = $this->upload->data(); // upload image 
				$this->session->set_userdata('proof_of_address_attachment', array('proof_of_address_attachment' => $data['file_name'])); 
				return TRUE; 
			}
		} 
	}

	/*public function phn(){
		$confirmation_code = $this->confirmation_code();
    	$senderID = senderID;
		$mobile   = '+8871499523';
		$authkey  = authkeyForSMS;
		$message  = 'Your One time passcode is '.$confirmation_code;

    	//$apiLink = "http://api.msg91.com/api/sendhttp.php?sender=".$senderID."&route=4&mobiles=".$mobile."&authkey=".$authkey."&encrypt=&country=0&message=".$message;

    	$apiLink = "http://api.msg91.com/api/sendotp.php?authkey=".$authkey."&mobile=".$mobile."&message=".$message."&sender=".$senderID."&otp=".$confirmation_code;

    	$response = file_get_contents($apiLink);
    	if(!empty($response)){
        	print_r($response);
        }else{
        	echo "failed";
        }die;
	}*/
}