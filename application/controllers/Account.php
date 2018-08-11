<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Account extends CI_Controller {

	public function __construct(){
        parent::__construct();
        clear_cache();
        $this->load->model('superadmin_model');
    }

	public function index(){
		redirect('account/dashboard');
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

	public function logout(){

		$this->_check_login(); //check  login authentication

		/*store cart data in database*/
		$this->storeCartData();
        
        $this->cart->destroy();
		$this->session->unset_userdata('shipping_address_id');
		$this->session->unset_userdata('user_info');
		redirect('page/login');
	}
    
    public function dashboard(){
    	$this->_check_login(); //check login authentication
	    $data['title']='Dashboard';
	    $data['template']='frontend/account/dashboard';
	    $this->load->view('templates/frontend/front_template',$data);
    }

    public function orders($offset=0){
   
	    $this->_check_login(); //check login authentication
	    $data['title']='Orders History';
	    $search=array();
	    if(!empty($_GET))
	    {
	    }

	    $data['orders'] = $this->common_model->get_orderInfo($offset, PER_PAGE, $search, array(4), user_id(), 2, 'front_orderhistory');
	    //p($data['orders']); die;
	    $config=backend_pagination();
	    $config['base_url'] = base_url().'account/orders/';
	    $config['total_rows'] = $this->common_model->get_orderInfo(0, 0, $search, array(4), user_id(), 2, 'front_orderhistory');

        $config['per_page'] = PER_PAGE;
		$config['uri_segment'] = 3;
		if(!empty($_SERVER['QUERY_STRING']))
			$config['suffix'] = "?".$_SERVER['QUERY_STRING'];
		else
		 	$config['suffix'] ='';

		$config['first_url'] = $config['base_url'].$config['suffix'];
		if((int) $offset < 0){
			$this->session->set_flashdata('msg_warning','Something went wrong! please try again');    
			redirect($config['base_url']);
		}else if($config['total_rows'] < $offset){
			$this->session->set_flashdata('msg_warning','Something went wrong! please try again');    
			redirect($config['base_url']);
		}

	    $this->pagination->initialize($config);
	    $data['pagination']=$this->pagination->create_links();
	    $data['template']='frontend/account/orders';
	    $data['offset']=$offset;
	    $this->load->view('templates/frontend/front_template',$data);
    }

    public function open_orders($offset=0){    
	    $this->_check_login(); //check login authentication
	    $data['title']='Open Orders';
	    $search=array();
	    if(!empty($_GET))
	    {
	    }
	    $data['orders'] = $this->common_model->get_orderInfo($offset, PER_PAGE, $search, array(1,2,3), user_id(), 2, 'front_openorders');
	    $config=backend_pagination();
	    $config['base_url'] = base_url().'account/open_orders/';
	    $config['total_rows'] = $this->common_model->get_orderInfo(0, 0, $search, array(1,2,3), user_id(), 2, 'front_openorders');
	    
	    $config['per_page'] = PER_PAGE;
		$config['uri_segment'] = 3;
		if(!empty($_SERVER['QUERY_STRING']))
			$config['suffix'] = "?".$_SERVER['QUERY_STRING'];
		else
		 	$config['suffix'] ='';

		$config['first_url'] = $config['base_url'].$config['suffix'];
		if((int) $offset < 0){
			$this->session->set_flashdata('msg_warning','Something went wrong! please try again');    
			redirect($config['base_url']);
		}else if($config['total_rows'] < $offset){
			$this->session->set_flashdata('msg_warning','Something went wrong! please try again');    
			redirect($config['base_url']);
		}

	    $this->pagination->initialize($config);
	    $data['pagination']=$this->pagination->create_links();
	    $data['template']='frontend/account/open_orders';
	    $data['offset']=$offset;
	    $this->load->view('templates/frontend/front_template',$data);
    }

    public function cancel_orders($offset=0){
    //die;    
	    $this->_check_login(); //check login authentication
	    $data['title']='Cancelled Orders';
	    $search=array();
	    if(!empty($_GET))
	    {
	    }

	    $data['orders'] = $this->common_model->get_orderInfo($offset, PER_PAGE, $search, array(5), user_id(), 2, '');
	    $config=backend_pagination();
	    $config['base_url'] = base_url().'account/cancel_orders/';
	    $config['total_rows'] = $this->common_model->get_orderInfo(0, 0, $search, array(5), user_id(), 2, '');
	    
	    $config['per_page'] = PER_PAGE;
		$config['uri_segment'] = 3;
		if(!empty($_SERVER['QUERY_STRING']))
			$config['suffix'] = "?".$_SERVER['QUERY_STRING'];
		else
		 	$config['suffix'] ='';

		$config['first_url'] = $config['base_url'].$config['suffix'];
		if((int) $offset < 0){
			$this->session->set_flashdata('msg_warning','Something went wrong! please try again');    
			redirect($config['base_url']);
		}else if($config['total_rows'] < $offset){
			$this->session->set_flashdata('msg_warning','Something went wrong! please try again');    
			redirect($config['base_url']);
		}

	    $this->pagination->initialize($config);
	    $data['pagination']=$this->pagination->create_links();
	    $data['template']='frontend/account/cancel_orders';
	    $data['offset']=$offset;
	    $this->load->view('templates/frontend/front_template',$data);
    }


    public function return_orders($offset=0){
    //die;    
	    $this->_check_login(); //check login authentication
	    $data['title']='Return Orders';
	    $search=array();
	    if(!empty($_GET))
	    {
	    }

	    $data['orders'] = $this->common_model->get_orderInfo($offset, PER_PAGE, $search, array(6), user_id(), 2, '');
	    $config=backend_pagination();
	    $config['base_url'] = base_url().'account/return_orders/';
	    $config['total_rows'] = $this->common_model->get_orderInfo(0, 0, $search, array(6), user_id(), 2, '');
	    
	    $config['per_page'] = PER_PAGE;
		$config['uri_segment'] = 3;
		if(!empty($_SERVER['QUERY_STRING']))
			$config['suffix'] = "?".$_SERVER['QUERY_STRING'];
		else
		 	$config['suffix'] ='';

		$config['first_url'] = $config['base_url'].$config['suffix'];
		if((int) $offset < 0){
			$this->session->set_flashdata('msg_warning','Something went wrong! please try again');    
			redirect($config['base_url']);
		}else if($config['total_rows'] < $offset){
			$this->session->set_flashdata('msg_warning','Something went wrong! please try again');    
			redirect($config['base_url']);
		}

	    $this->pagination->initialize($config);
	    $data['pagination']=$this->pagination->create_links();
	    $data['template']='frontend/account/return_orders';
	    $data['offset']=$offset;
	    $this->load->view('templates/frontend/front_template',$data);
    }

    public function order_cancel($id=''){
    //die;    
	    $this->_check_login(); //check login authentication
	    $data['title']='Order Cancellation';
	    $id = base64_decode($id);
	    $order_details = $this->common_model->get_row('order_details',array('order_detail_id'=>$id));
	    if(empty($order_details)) redirect($_SERVER['HTTP_REFERER']);

	    if($this->common_model->update('order_details', array('order_status'=>5), array('order_detail_id'=>$id))){
			$this->session->set_flashdata('msg_success', 'You have cancelled the order successfully'); 
    		redirect(base_url('account/cancel_orders'));
		}else{
			$this->session->set_flashdata('msg_error', 'Something went wrong! please try again'); 
    		redirect($_SERVER['HTTP_REFERER']);
		}

    }

 	public function order_details($o_id='', $orderDetailIDs='', $pageType=1){
 		
 		if($pageType!=1 && $pageType!=2) redirect(base_url('account/open_orders'));
	    $this->_check_login(); //check login authentication
	    $data['title']='Order Details';

	    $o_id = base64_decode($o_id);
		$orderDetailIDs = base64_decode($orderDetailIDs);

		$data['order_info'] = $order_info = $this->common_model->get_row('orders',array('o_id'=>$o_id, 'user_id'=>user_id()));
		//p($order_info); die;
		if(empty($order_info)) redirect(base_url('account/open_orders'));

		$data['o_id']  			 = $o_id;
		$data['orderDetailIDs']  = $orderDetailIDs;
		$data['pageType']  		 = $pageType;
	    $data['template']='frontend/account/order_details';
	    $this->load->view('templates/frontend/front_template',$data);
    }

    public function wish_list($offset=0){
    //die;    
	    $this->_check_login(); //check login authentication
	    $data['title']='My Wishlist';
	    $search=array();
	    if(!empty($_GET))
	    {
	    }

	    $data['wishListInfo'] = $this->common_model->get_wishListInfo($offset, PER_PAGE, $search);
	   // p($data['wishListInfo']);
	   // die;
	    $config=backend_pagination();
	    $config['base_url'] = base_url().'account/wish_list/';
	    $config['total_rows'] = $this->common_model->get_wishListInfo(0, 0, $search);	    
	    $config['per_page'] = PER_PAGE;
		$config['uri_segment'] = 3;
		if(!empty($_SERVER['QUERY_STRING']))
			$config['suffix'] = "?".$_SERVER['QUERY_STRING'];
		else
		 	$config['suffix'] ='';

		$config['first_url'] = $config['base_url'].$config['suffix'];
		if((int) $offset < 0){
			$this->session->set_flashdata('msg_warning','Something went wrong! please try again');    
			redirect($config['base_url']);
		}else if($config['total_rows'] < $offset){
			$this->session->set_flashdata('msg_warning','Something went wrong! please try again');    
			redirect($config['base_url']);
		}
		$this->pagination->initialize($config);
	    $data['pagination']=$this->pagination->create_links();
	    $data['template']='frontend/account/wish_list';
	    $data['offset']=$offset;
	    $this->load->view('templates/frontend/front_template',$data);
	}

    public function transaction($offset=0){    
	    $this->_check_login(); //check login authentication
	    $data['title']='Transaction History';
	    $search=array();
	    if(!empty($_GET))
	    {
	    }

	    $data['orders'] = $this->common_model->get_orderInfo($offset, PER_PAGE, $search, array(1,2,3), user_id(), 2);
	    $config=backend_pagination(); 
	    $config['base_url'] = base_url().'account/transaction/';
	    $config['total_rows'] = $this->common_model->get_orderInfo(0, 0, $search, array(1,2,3), user_id(), 2);
	    
	    $config['per_page'] = PER_PAGE;
		$config['uri_segment'] = 3;
		if(!empty($_SERVER['QUERY_STRING']))
			$config['suffix'] = "?".$_SERVER['QUERY_STRING'];
		else
		 	$config['suffix'] ='';

		$config['first_url'] = $config['base_url'].$config['suffix'];
		if((int) $offset < 0){
			$this->session->set_flashdata('msg_warning','Something went wrong! please try again');    
			redirect($config['base_url']);
		}else if($config['total_rows'] < $offset){
			$this->session->set_flashdata('msg_warning','Something went wrong! please try again');    
			redirect($config['base_url']);
		}

	    $this->pagination->initialize($config);
	    $data['pagination']=$this->pagination->create_links();
	    $data['template']='frontend/account/transaction';
	    $data['offset']=$offset;
	    $this->load->view('templates/frontend/front_template',$data);
    }


   	public function subscription(){  
	    $this->_check_login(); //check login authentication
	    $data['title']='Subscription';
	    $this->form_validation->set_rules('email', 'Email', 'trim|required|is_unique[email_subscription.email_id]');
	     $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	     if ($this->form_validation->run() == TRUE){ 
        	$user_id = (user_id()) ? user_id() : 0;    	
     		$insert = [
	    		'email_id' => $this->input->post('email'),
	    		'subscription_type' => $this->input->post('subscription_type'),
	    		'user_id' => $user_id,
	    	];
    		if($id = $this->common_model->insert('email_subscription',$insert)){

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

    			$this->session->set_flashdata('msg_success', 'Thanks for subscribing! Please check your email for further instructions');   
    			redirect('page/index'); 
    		}else{
    			$this->session->set_flashdata('msg_error', 'Something went wrong! please try again');
    			redirect('page/index');         		
    		}
    	}else{
    		
    	}
    	$data['template']='frontend/account/subscription';
	    $this->load->view('templates/frontend/front_template',$data);
    }

	public function profile(){
		$this->_check_login(); //check login authentication
		$data['title']='Account Details';
		$this->form_validation->set_rules('name', 'Full Name', 'required');
		$this->form_validation->set_rules('country_code', 'Country Code', 'trim|required');
    	$this->form_validation->set_rules('mobile', 'Mobile No.', 'trim|required|numeric|min_length[9]|max_length[13]');
		$this->form_validation->set_rules('country', 'Country', 'trim|required');
		$this->form_validation->set_rules('province', 'Province', 'trim|required');
		$this->form_validation->set_rules('city', 'City', 'trim|required');
		$this->form_validation->set_rules('zip', 'Postal Code', 'trim|min_length[4]|max_length[8]');
		$this->form_validation->set_rules('address', 'Address', 'trim');

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE)	{
			$user_data  = array(
				'user_name'	=>	$this->input->post('name'),
				'gender'	=>	$this->input->post('gender'),
				'country_code'		=>	$this->input->post('country_code'),
				'mobile'		=>	$this->input->post('mobile'),
				'country'		=>	$this->input->post('country'),
				'province'		=>	$this->input->post('province'),
				'city'		=>	$this->input->post('city'),
				'zip'		=>	$this->input->post('zip'),
				'confirmation_code'		=>	'verified',
				'address'		=>	$this->input->post('address'),
				'modified' => date('Y-m-d H:i:s A')
			);
			if($this->superadmin_model->update('users', $user_data,array('user_id'=>user_id()))){
				 $this->session->set_flashdata('msg_success','Your account details has been updated successfully');
				redirect('account/profile');
			}else{
				$this->session->set_flashdata('msg_error','Sorry! Your account details updation process has been failed, Please try again');
				redirect('account/profile');
			}
		}

		$data['country'] = $this->common_model->get_result('countries', '', array('name,id'), array('name','asc'));
		$data['phnCode'] = $this->common_model->get_result('countries',array(),array('sortname','phonecode'),array('name','asc'));
		$data['user'] = $this->superadmin_model->get_row('users', array('user_id'=>user_id()));
		$data['template']='frontend/account/profile';
		$this->load->view('templates/frontend/front_template',$data);
	}

	public function change_password(){
		$this->_check_login(); //check login authentication
		$data['title']='Change Password';
		$this->form_validation->set_rules('oldpassword', 'Old Password', 'trim|required|callback_password_check');
		$this->form_validation->set_rules('newpassword', 'New Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('confpassword','Confirm Password', 'trim|required|matches[newpassword]');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE){
			$salt = $this->salt();
			$user_data  = array('salt'=>$salt,'password' => sha1($salt.sha1($salt.sha1($this->input->post('newpassword')))));
			if($this->superadmin_model->update('users',$user_data,array('user_id'=>user_id()))){
				$this->session->set_flashdata('msg_success','Your password has been updated successfully');
				redirect('account/change_password');
			}else{
				$this->session->set_flashdata('msg_error','Sorry! Your password updation process has been failed, Please try again');
				redirect('account/change_password');
			}
		}
		$data['template']='frontend/account/change_password';
		$this->load->view('templates/frontend/front_template',$data);
	}

	public function password_check($oldpassword){
		$this->_check_login(); //check login authentication
		$this->load->model('user_model');
		$user_info = $this->user_model->get_row('users',array('user_id'=>user_id()));
        $salt = $user_info->salt;
		if($this->common_model->password_check(array('password'=>sha1($salt.sha1($salt.sha1($oldpassword)))),seller_id())){
			return TRUE;
		}else{
			$this->form_validation->set_message('password_check', 'The %s does not match');
			return FALSE;
		}

	}

	public function insertProductRating()
	{
		$this->_check_login(); //check  login authentication
		$this->form_validation->set_rules('description', 'Description', 'trim|required');
		$this->form_validation->set_rules('rating', 'Rating', 'trim|required');
		$this->form_validation->set_rules('product_variation_id', 'Product Variation', 'trim|required');
		$this->form_validation->set_rules('product_info_id', 'Product Info', 'trim|required');
		$this->form_validation->set_error_delimiters('', '');
    	if ($this->form_validation->run() == TRUE){
    			
    		$insertData = array(
    			'user_id' 	 			=> user_id(),
    			'description'  			=> $_POST['description'],
    			'product_variation_id'  => base64_decode($_POST['product_variation_id']),
    			'product_info_id'    	=> base64_decode($_POST['product_info_id']),
    			'rating'      			=> $_POST['rating'],
    			'created_at' 			=> date('Y-m-d H:i:s A'),
    			'status' 	 			=> 1
    		);
    		if($id = $this->common_model->insert('product_review', $insertData)){
    			echo json_encode(array('status' => 'success', 'msg'=>'Thank you! Your rating has been received'));  
    		}else{
    			echo json_encode(array('status' => 'failed', 'msg'=>'Sorry! Rating process has been failed, Please try again'));
    		}
    	}else{
    		echo json_encode(array('status' => 'failed', 'msg'=>'Something went wrong. please try again.','validation_errors'=>validation_errors()));
    	}  

	}

  	function salt() {
		return substr(md5(uniqid(rand(), true)), 0, 10);
	}

	function confirmation_code() {
		$no = rand(0, 999999999);
		$no = str_pad($no, 12, "0", STR_PAD_LEFT);
		return $no;
	}

	private function storeCartData(){	
		$cartData = $this->cart->contents();
		if(!empty($cartData)){
			$user_id = user_id();
			$cart_info = $this->common_model->get_row('user_cartinfo',array('user_id'=>$user_id));
			$data = array(
    			'user_id' 	 			=> user_id(),
    			'cart_data'  			=> json_encode($cartData)
    		);
			if(!empty($cart_info)){
				$data['created'] = date('Y-m-d H:i:s A');
				$data['updated'] = date('Y-m-d H:i:s A');
				$this->common_model->update('user_cartinfo', $data, array('user_id'=>$user_id));
			}else{
				$data['created'] = date('Y-m-d H:i:s A');
				$this->common_model->insert('user_cartinfo', $data);
			}
		} 
		return true;		
	}

	public function email_test($o_id=''){
 		
 		$data['title'] = "Order";
 		$data['order_info'] =  $this->common_model->get_row('orders',array('o_id'=>$o_id));
    	if(!empty($data['order_info'])){
          	$data['orders_details'] =  $this->common_model->get_result('order_details',array('order_table_id'=>$data['order_info']->o_id));
        }
	    $this->load->view('templates/email/order_placed',$data);

    }


   

}