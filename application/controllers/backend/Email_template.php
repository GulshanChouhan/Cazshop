<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Email_template extends CI_Controller
{

    public function __construct(){
	      parent::__construct();
	      if (superadmin_logged_in() === FALSE) redirect('behindthescreen'); 
	}


	private function _check_login(){
	    if(superadmin_logged_in()===FALSE)
	      redirect('behindthescreen');
	}


    public function index(){
		redirect('backend/email_template/email_templates');
	}


	public function email_templates($offset=0){
		$this->_check_login(); //check login authentication
		$data['title']='Email Templates';
		$data['offset']= $offset;
		$search=array();
		if(!empty($_GET))
		{
			if(!empty($_GET['template_name']))
			$search[]='template_name like "%'.trim($_GET['template_name']).'%"';
		}
        $data['templates'] = $this->common_model->email_templates($offset, PER_PAGE, $search);
 		$config=backend_pagination();
		$config['base_url'] = base_url().'backend/email_template/email_templates/';
		$config['total_rows'] = $this->common_model->email_templates(0, 0, $search);
		
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
 		$data['template']='backend/email/email_templates';
		$this->load->view('templates/superadmin_template',$data);
	}

	
	public function email_template_add(){
		$this->_check_login(); //check login authentication
		$data['title']='Add Email Template';
        $this->form_validation->set_rules('template_name', 'Template Name', 'trim|required|max_length[150]');
		$this->form_validation->set_rules('template_subject', 'Subject', 'trim|required|max_length[255]');
		$this->form_validation->set_rules('template_subject_admin', 'Subject', 'trim|max_length[255]');
		$this->form_validation->set_rules('template_body', 'Template Body', 'trim|required');
		$this->form_validation->set_rules('template_sms_body', 'Template SMS Body', 'trim|max_length[160]');
		$this->form_validation->set_rules('template_sms_body_admin', 'Template SMS Body', 'trim|max_length[160]');

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE){
			$template_data  = array(
				'template_name'				=>	$this->input->post('template_name'),
				'template_subject'			=>	$this->input->post('template_subject'),
				'template_body' 			=>  $this->input->post('template_body'),
				'template_sms_body'			=>	$this->input->post('template_sms_body'),
				'template_subject_admin'	=>	$this->input->post('template_subject_admin'),
				'template_body_admin' 		=>  $this->input->post('template_body_admin'),
				'template_sms_body_admin'	=>	$this->input->post('template_sms_body_admin'),
				'template_sms_enable'		=>	$this->input->post('sms_status'),
				'template_email_enable'		=>	$this->input->post('email_status'),
				'template_created' 			=>	date('Y-m-d H:i:s'),
				'template_updated' 			=>	date('Y-m-d H:i:s')
			);
			if($this->common_model->insert('email_templates',$template_data)){
				$this->session->set_flashdata('msg_success','Email template information added successfully');
				redirect('backend/email_template/email_templates');
			}else{
				$this->session->set_flashdata('msg_error','Sorry! Adding process has been failed. Please try again');
				redirect('backend/email_template/email_templates');
			}
		}
		$data['template']='backend/email/email_template_add';
		$this->load->view('templates/superadmin_template',$data);
	}
	public function email_template_edit($template_id=''){
		$this->_check_login(); //check login authentication
		$data['title']='Edit Email Templates';
		if(empty($template_id)) redirect('backend/email_template/email_templates');
        
		$this->form_validation->set_rules('template_name', 'Template Name', 'trim|required|max_length[150]');
		$this->form_validation->set_rules('template_subject', 'Subject', 'trim|required|max_length[255]');
		$this->form_validation->set_rules('template_subject_admin', 'Subject', 'trim|max_length[255]');
		$this->form_validation->set_rules('template_body', 'Template Body', 'trim|required');
		$this->form_validation->set_rules('template_sms_body', 'Template SMS Body', 'trim|max_length[160]');
		$this->form_validation->set_rules('template_sms_body_admin', 'Template SMS Body', 'trim|max_length[160]');

		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE){
			$template_data  = array(
				'template_name'				=>	$this->input->post('template_name'),
				'template_subject'			=>	$this->input->post('template_subject'),
				'template_body' 			=>  $this->input->post('template_body'),
				'template_sms_body'			=>	$this->input->post('template_sms_body'),
				'template_subject_admin'	=>	$this->input->post('template_subject_admin'),
				'template_body_admin' 		=>  $this->input->post('template_body_admin'),
				'template_sms_body_admin'	=>	$this->input->post('template_sms_body_admin'),
				'template_sms_enable'		=>	$this->input->post('sms_status'),
				'template_email_enable'		=>	$this->input->post('email_status'),
				'template_updated' 			=>	date('Y-m-d H:i:s')
			);
			if($this->common_model->update('email_templates',$template_data,array('id'=>$template_id))){
				$this->session->set_flashdata('msg_success','Email template information updated successfully');
				redirect('backend/email_template/email_templates');
			}else{
				$this->session->set_flashdata('msg_error','Sorry! Updation process has been failed. Please try again');
				redirect('backend/email_template/email_templates');
			}
		}
		$data['email_template'] = $this->common_model->get_row('email_templates',array('id'=>$template_id));
		$data['template']='backend/email/email_template_edit';
		$this->load->view('templates/superadmin_template',$data);
	}
	public function email_template_view($template_id='')	{
		$this->_check_login(); //check login authentication
		$data['title']='View Email Template';
		if(empty($template_id)) redirect('backend/email_template/email_templates');
		$data['email_template'] = $this->common_model->get_row('email_templates',array('id'=>$template_id));
		$data['template']='backend/email/email_template_view';
		$this->load->view('templates/superadmin_template',$data);
	}
	public function templates_delete($template_id ='')	{
		$this->_check_login(); //check login authentication
		$data['title']='Delete Email Template';
		if(empty($template_id)) redirect('backend/email_template/email_templates');
		if($this->common_model->delete('email_templates',array('id'=>$template_id))){
				$this->session->set_flashdata('msg_success','Email template deleted successfully');
				redirect('backend/email_template/email_templates');
		}else{
			$this->session->set_flashdata('msg_error','Sorry! Deletion process has been failed. Please try again');
			redirect('backend/email_template/email_templates');
		}
	}	
}