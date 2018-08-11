<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
	public function __construct(){ 
		parent::__construct(); 
		$this->load->model('category_model');
		
	} 
	public function index($slug='')
	{
		if($slug!='' && empty($data['category_info']=$this->common_model->get_row('category',array('category_slug'=>$slug,'status'=>1))))
			redirect('page/_404');
		$data['promotion_image']=$this->common_model->get_result('promotion_image',array('category_id'=>$data['category_info']->category_id,'status'=>1),array(),array('order','asc'));
		$data['brand']=$this->common_model->get_result('brand',array('status'=>1),array(),array(),'','FIND_IN_SET ('.$data['category_info']->category_id.', category_id)');
		$data['category']=$this->category_model->fetchCategoryTree($data['category_info']->category_id);
		$data['title']= ($data['category_info']->category_name) ? ucfirst($data['category_info']->category_name) : 'List Of Categories';
	    $data['template']='frontend/category';
	    $this->load->view('templates/frontend/front_template',$data);
	}

}
