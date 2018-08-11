<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends CI_Controller {

  public function __construct(){
      parent::__construct();
      clear_cache();
      $this->load->model('user_model');
      $this->load->model('Common_model');
  }
    

  public function index()
  {
    if(!empty(site_access())) redirect(base_url());
    $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="error" style="color:red;">', '</div>');
        if ($this->form_validation->run() == TRUE){    
        if($this->input->post('password')=='admin.cazshop@#2018'){
          $site_access = array(
          'logged_in'   => TRUE
        );
          $this->session->set_userdata('site_access',$site_access);
          redirect(base_url());
        }else{
          $this->session->set_flashdata('msg_error', 'You have entered wrong password');
          redirect('auth/index');  
        }
      }
    $data['title']='Authentication';
      $this->load->view('frontend/authentication',$data);
  }

  
}

