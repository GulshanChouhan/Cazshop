<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Attribute extends CI_Controller {
	public function __construct(){ 
		parent::__construct(); 
		$this->load->model('superadmin_model');
		if (superadmin_logged_in() === FALSE) redirect('behindthescreen'); //check login authentication
	} 
	private function _check_login(){
		if(superadmin_logged_in()===FALSE)
			redirect('behindthescreen');
	}
	public function index($offset=0){
		$data['title']='List Of Attributes';
		$search=array();
		if(!empty($_GET))
		{
			if(!empty($_GET['attribute_name']))
			$search[]=' a.name like "%'.trim($_GET['attribute_name']).'%"';
			if(!empty($_GET['attribute_code']))
			$search[]=' a.attribute_code like "%'.trim($_GET['attribute_code']).'%"';
			if(!empty($_GET['category_id']))
			$search[]=' FIND_IN_SET('.trim($_GET['category_id']).',a.category_id) !=0';
		}
		$sort='desc';
		if(!empty($_GET['order'])) $sort=$_GET['order'];
        $data['attribute'] = $this->common_model->get_result_pagination('attributes as a',array(),array('(SELECT GROUP_CONCAT(c.`category_name` SEPARATOR " , ") FROM `category` as c where FIND_IN_SET(c.`category_id`,a.`category_id`)) as category_name','a.*'),array('a.attribute_id',$sort),array(),$offset,PER_PAGE,$search);
        $config=backend_pagination(); 
        $config['base_url'] = base_url().'backend/attribute/index/';
        $config['total_rows'] = $this->common_model->get_result_pagination('attributes as a',array(), array('(SELECT GROUP_CONCAT(c.`category_name` SEPARATOR " , ") FROM `category` as c where FIND_IN_SET(c.`category_id`,a.`category_id`)) as category_name','a.*'),array('attribute_id','desc'),array(),0,0,$search);
        
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
        $data['template']='backend/attribute/attribute_list';
        $data['offset']=$offset;
        $this->load->view('templates/superadmin_template',$data);
	}


	public function add_attribute(){
		$data['title']='Add Attribute';
		$this->form_validation->set_rules('category_id[]', 'Category', 'required|trim'); 
		$this->form_validation->set_rules('attribute_name', 'Attribute Name', 'required|trim');
		$this->form_validation->set_rules('attribute_code', 'Attribute Code', 'required|trim|alpha_numeric|is_unique[attributes.attribute_code]');
		$this->form_validation->set_rules('status', 'Status', 'required|numeric|trim');
		$this->form_validation->set_rules('file_type', 'File Type', 'required|numeric|trim');
		$this->form_validation->set_rules('type', 'Type', 'required|numeric|trim');
		$this->form_validation->set_rules('tooltip_content', 'tooltip content', 'trim|max_length[250]');
		$this->form_validation->set_rules('placeholder_content', 'Placeholder Content', 'trim|max_length[500]');
		$this->form_validation->set_rules('used_in_filter', 'filter', 'required');
		
		if(!empty($_POST) && !empty($_POST['attribute_value']) && !empty($_POST['file_type']) && in_array($_POST['file_type'], array(3,4,5,7,9,10)))
			$this->form_validation->set_rules('attribute_value[]', 'Attribute Value', 'trim|callback_check_attribute_value');
		$this->form_validation->set_rules('required_status', 'Required Status', 'required|numeric|trim');
		$this->form_validation->set_rules('attribute_map', 'Attribute Mapping', 'required|numeric|trim');

		if ($this->form_validation->run() == TRUE){ 
			$default_value='';
			if($this->input->post('file_type')==1)
				$default_value=$_POST['default_value'];
			if($this->input->post('file_type')==2)
				$default_value=$_POST['default_textarea'];
			if($this->input->post('file_type')==8)
				$default_value=$_POST['default_date'];
			$insert = [
				'name' => trim($this->input->post('attribute_name')),
				'attribute_code' => trim(strtolower($this->input->post('attribute_code'))),
				'category_id' => implode(",",$this->input->post('category_id')),
				'file_type' => $this->input->post('file_type'),
				'type' => $this->input->post('type'),
				'used_in_filter' => $this->input->post('used_in_filter'),
				'default_value' =>  trim($default_value),
				'is_required_only' => $this->input->post('required_status'),
				'is_readonly' => $this->input->post('is_readonly'),
				'status' => $this->input->post('status'),
				'tooltip_content'=>$this->input->post('tooltip_content'),
				'placeholder_content'=>$this->input->post('placeholder_content'),
				'attribute_map'=>$this->input->post('attribute_map'),
				'attribute_value'=>json_encode($this->input->post('attribute_value'))
			];
			if($this->common_model->insert('attributes',$insert)){
				$this->session->set_flashdata('msg_success','Attribute information added successfully');
                redirect('backend/attribute');
			}else{
				$this->session->set_flashdata('msg_error','Sorry! Adding process has been failed. Please try again');
				redirect('backend/attribute/add_attribute');
			}
		}
		$data['template']='backend/attribute/add_attribute';
		$this->load->view('templates/superadmin_template',$data);
	}


	public function check_attribute_value($str){
		foreach($_POST['attribute_value'] as $key=>$value)
		{
			if($value=='')
			{
				$this->form_validation->set_message("check_attribute_value", "All option value field is required.");
				return FALSE;
			}
		}
		if(count(array_unique($_POST['attribute_value']))<count($_POST['attribute_value']))
		{
			$this->form_validation->set_message("check_attribute_value", "Please enter unique option value");
			return FALSE;
		}
		else
		{
			return TRUE;
		}
		
	}


	public function edit_attribute($id=''){
		if($id=='' || empty($data['attribute']=$this->common_model->get_row('attributes',array('attribute_id'=>$id))))
		{
			$this->session->set_flashdata('msg_error', 'Something Went Wrong. Please try again'); 
			redirect('backend/attribute/index');
		}	
		$data['title']='Edit Attribute';

		$this->form_validation->set_rules('category_id[]', 'Category', 'required|trim'); 
		$this->form_validation->set_rules('attribute_name', 'Attribute Name', 'required|trim');
		$this->form_validation->set_rules('status', 'Status', 'required|numeric|trim');
		$this->form_validation->set_rules('file_type', 'File Type', 'required|numeric|trim');
		$this->form_validation->set_rules('type', 'Type', 'required|numeric|trim');
		$this->form_validation->set_rules('tooltip_content', 'tooltip content', 'trim|max_length[250]');
		$this->form_validation->set_rules('placeholder_content', 'Placeholder Content', 'trim|max_length[500]');
		$this->form_validation->set_rules('used_in_filter', 'filter', 'required');
		
		if(!empty($_POST) && !empty($_POST['attribute_value']) && !empty($_POST['file_type']) && in_array($_POST['file_type'], array(3,4,5,7,9,10)))
			$this->form_validation->set_rules('attribute_value[]', 'Attribute Value', 'trim|callback_check_attribute_value');
		$this->form_validation->set_rules('required_status', 'Required Status', 'required|numeric|trim');
		$this->form_validation->set_rules('attribute_map', 'Attribute Mapping', 'required|numeric|trim');

		if ($this->form_validation->run() == TRUE){ 
			$default_value='';
			$attribute_value=json_encode($this->input->post('attribute_value'));
			if($this->input->post('file_type')==1){
			$default_value=$_POST['default_value']; $attribute_value=''; }
			if($this->input->post('file_type')==2){
			$default_value=$_POST['default_textarea']; $attribute_value='';}
			if($this->input->post('file_type')==8){
			$default_value=$_POST['default_date']; $attribute_value='';}
			$insert = [
				'name' => trim($this->input->post('attribute_name')),
				'category_id' => implode(",",$this->input->post('category_id')),
				'file_type' => $this->input->post('file_type'),
				'default_value' => trim($default_value),
				'type' => $this->input->post('type'),
				'used_in_filter' => $this->input->post('used_in_filter'),
				'is_required_only' => $this->input->post('required_status'),
				'is_readonly' => $this->input->post('is_readonly'),
				'status' => $this->input->post('status'),
				'tooltip_content'=>$this->input->post('tooltip_content'),
				'placeholder_content'=>$this->input->post('placeholder_content'),
				'attribute_map'=>$this->input->post('attribute_map'),
				'attribute_value'=>$attribute_value,
			];
			if($this->common_model->update('attributes',$insert,array('attribute_id'=>$id))){
				$this->session->set_flashdata('msg_success','Attribute information updated successfully');
                redirect('backend/attribute');
			}else{
				$this->session->set_flashdata('msg_error','Sorry! Updation process has been failed. Please try again');
				redirect('backend/attribute/edit_attribute/'.$id);
			}
		}
		$data['template']='backend/attribute/edit_attribute';
		$this->load->view('templates/superadmin_template',$data);
	}
	

}