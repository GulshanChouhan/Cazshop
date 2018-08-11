<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Superadmin extends CI_Controller {
	public function __construct(){
        parent::__construct();
        clear_cache();
        $this->load->model('superadmin_model');
       
    }
	public function index(){
		redirect('behindthescreen');
	}
	private function _check_login(){
		
		if(superadmin_logged_in()===FALSE)
			redirect('behindthescreen');
	}


    public function login(){
		if(superadmin_logged_in()===TRUE) redirect('backend/superadmin/dashboard');
		 $data['title']='Admin login';
		  $this->form_validation->set_rules('password', 'Password', 'trim|required');
		  $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		if ($this->form_validation->run() == TRUE){
			$this->load->model('user_model');
			$email = $this->input->post('email');
       		$password = $this->input->post('password');
			if($this->user_model->login($email,$password,'superadmin')){
				redirect('backend/superadmin/dashboard');
			}else{
				redirect('behindthescreen');
			}
		}
		
		$this->load->view('backend/login');
	}

	
	public function logout(){
		$this->_check_login(); //check  login authentication
		$this->session->sess_destroy();
		redirect(base_url().'behindthescreen');
	}
    
   
    
    public function dashboard(){    
	    $this->_check_login(); //check login authentication
	    $data['title']='Dashborad';

	    $search=array();
	    $statusArr = (!empty($status)) ? array($status) : array(1,2,3,4,5,6);
	    $data['orders'] = $this->common_model->get_orderInfo(0, 5, $search, $statusArr, '', 0);
	    $data['contactus'] = $this->superadmin_model->get_contactus(1,3); 
	    $data['stat_today_orders'] = $this->superadmin_model->getOrder_countAndTotal('', 1);
	    $data['stat_sevenDays_orders'] = $this->superadmin_model->getOrder_countAndTotal('', 7);
		$data['stat_thirtyDays_orders'] = $this->superadmin_model->getOrder_countAndTotal('', 30);
		$data['stat_all_orders'] = $this->superadmin_model->getOrder_countAndTotal('', '');
		$data['active_customers'] = $this->superadmin_model->get_statistics('users', '2', '1');
	    $data['deactive_customers'] = $this->superadmin_model->get_statistics('users', '2', '2');
	    $data['active_sellers'] = $this->superadmin_model->get_statistics('users', '1', '1');
	    $data['deactive_sellers'] = $this->superadmin_model->get_statistics('users', '1', '2');
	    $data['all_order'] = $this->superadmin_model->get_result('order_details');
	    $data['total_order']=count($data['all_order']);

	    $data['template']='backend/dashboard';
	    $this->load->view('templates/superadmin_template',$data);
    }

	public function profile(){
		$this->_check_login(); //check login authentication
		$data['title']='Account Details';
		$this->form_validation->set_rules('firstname', 'First Name', 'required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE)	{
			$user_data  = array(
							'first_name'	=>	$this->input->post('firstname'),
							'last_name'	=>  $this->input->post('lastname'),
							'email'		=>	$this->input->post('email'),
							);
			if($this->superadmin_model->update('users', $user_data,array('user_id'=>superadmin_id()))){
				 $this->session->set_flashdata('msg_success','Profile details updated successfully');
				redirect('backend/superadmin/profile');
			}else{
				$this->session->set_flashdata('msg_error','Sorry! Profile Updation process has been failed. Please try again');
				redirect('backend/superadmin/profile');
			}
		}else{
			$data['user'] = $this->superadmin_model->get_row('users', array('user_id'=>superadmin_id()));
			$data['template']='backend/profile';
			$this->load->view('templates/superadmin_template',$data);
		}
	}
	public function change_password(){
		$this->_check_login(); //check login authentication
		$data['title']='Change Password';
		$this->form_validation->set_rules('oldpassword', 'Old Password', 'trim|required|callback_password_check');
		$this->form_validation->set_rules('newpassword', 'New Password', 'trim|required|matches[confpassword]');
		$this->form_validation->set_rules('confpassword','Confirm Password', 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE){
			$salt = $this->salt();
			$user_data  = array('salt'=>$salt,'password' => sha1($salt.sha1($salt.sha1($this->input->post('newpassword')))));
			if($this->superadmin_model->update('users',$user_data,array('user_id'=>superadmin_id()))){
				$this->session->set_flashdata('msg_success','Password has been updated successfully');
				redirect('backend/superadmin/change_password');
			}else{
				$this->session->set_flashdata('msg_error','Sorry! Password updation process has been failed. Please try again');
				redirect('backend/superadmin/change_password');
			}
		}
		$data['template']='backend/change_password';
		$this->load->view('templates/superadmin_template',$data);
	}
	public function password_check($oldpassword){
		$this->_check_login(); //check login authentication
		$this->load->model('user_model');
		$user_info = $this->user_model->get_row('users',array('user_id'=>superadmin_id()));
        $salt = $user_info->salt;
		if($this->common_model->password_check(array('password'=>sha1($salt.sha1($salt.sha1($oldpassword)))),superadmin_id())){
			return TRUE;
		}else{
			$this->form_validation->set_message('password_check', 'The %s does not match');
			return FALSE;
		}

	}
	
  	function salt() {
		return substr(md5(uniqid(rand(), true)), 0, 10);
	}

	public function change_status_users($id="",$status="",$offset=""){
	    $this->_check_login(); //check login authentication
	    $data['title']='';
	    $data=array('status'=>$status);
	    if($this->superadmin_model->update('users',$data,array('user_id'=>$id)))    {
	    $this->session->set_flashdata('msg_success','Status has been changed successfully');}
	    redirect($_SERVER['HTTP_REFERER']);
	}
 	
	
    function error_404(){
    	$this->_check_login(); //check login authentication
		$data['template']='backend/error_404';		
		$this->load->view('templates/superadmin_template',$data);
	} 
}