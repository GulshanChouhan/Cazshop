<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Category extends CI_Controller{ 
	public function __construct(){ 
  		parent::__construct(); 
  		if (superadmin_logged_in() === FALSE) redirect('behindthescreen'); 
	} 
	private function _check_login(){ 
		  if (superadmin_logged_in() === FALSE) redirect('behindthescreen'); 
	} 
	public function index($parent_id=0)
	{
    $this->_check_login(); //check login authentication 

      $data['title']='Categories';
  		$this->load->model('category_model');
  		//$data['category'] =$this->category_model->fetchCategoryTree();
      $search=array();
      if(!empty($_GET))
      {
        if(!empty($_GET['category_name']))
        $search[]=' c.category_name like "%'.trim($_GET['category_name']).'%"';
        if(!empty($_GET['category_id']))
        $search[]=' c.category_id='.trim($_GET['category_id']);
        if(!empty($_GET['status']))
        $search[]=' c.status='.trim($_GET['status']);
        
      }
      $sort='desc';
      if(!empty($_GET['order'])) $sort=$_GET['order'];
      $data['parent_id']=$parent_id;
      $data['category']=$this->common_model->get_result('category as c',array('parent_id'=>$parent_id),array('(SELECT GROUP_CONCAT(ca.`category_name`) FROM `category` as ca where ca.parent_id=c.category_id ) as sub_category_name','c.category_id','c.category_name','c.category_slug','c.logo_image','c.is_menu','c.is_home','c.status','c.order_by','c.created_at'),array('category_id',$sort),'','',$search);
      $data['template'] = 'backend/category/index'; 
      $this->load->view('templates/superadmin_template', $data);

	}
	public function add_category(){ 
	
      $this->_check_login(); //check login authentication 
      $data['title']='Add Category';
      $this->form_validation->set_rules('category_name', 'Category Name', 'required|trim|max_length[80]'); 
      //$this->form_validation->set_rules('short_description', 'Short Description', 'required|trim|max_length[100]'); 
      $this->form_validation->set_rules('category_slug', 'Category Slug', 'required|trim|alpha_numeric|is_unique[category.category_slug]');
     // $this->form_validation->set_rules('description', 'Description', 'required|trim'); 
      $this->form_validation->set_rules('banner_image', 'Banner Image', 'callback_bannerImg_check');
      $this->form_validation->set_rules('logo_image', 'Tile Image', 'callback_logoImg_check');
      $this->form_validation->set_rules('menu_icon', 'Menu Icon', 'callback_menuIcon_check');
      $this->form_validation->set_rules('menu_image', 'Mega Menu Image', 'callback_menuImage_check');
      $this->form_validation->set_rules('order_by', 'Order By', 'numeric');
      if ($this->form_validation->run() == TRUE){ 
      $insert = [
          'category_name'     => trim($this->input->post('category_name')),
          'category_slug'     => url_title(trim($this->input->post('category_name')), 'dash', true),
          'meta_title'        => $this->input->post('meta_title'),
          'meta_keyword'      => $this->input->post('meta_keyword'),
          'meta_description'  => $this->input->post('meta_description'),
          'status'            => $this->input->post('category_status'),
          /*'description'       => $this->input->post('description'),*/
          'short_description' => $this->input->post('short_description'),
          'is_menu'           => $this->input->post('is_menu'),
          'is_home'           => $this->input->post('is_home'),
          'order_by'       	  => $this->input->post('order_by'),
          'user_id'           => 0,
          'parent_id'         => 0,
          'adminstatus'       => 1,
          'commision'         => get_option_url('COMMISION_FEE'),
          'created_at'        => date('Y-m-d H:i:s A')
      ];
      if ($this->session->userdata('bannerImg_check') != '') {
          $bannerImg_check         = $this->session->userdata('bannerImg_check');
          $insert['banner_image']  = $bannerImg_check['banner_image'];
           $this->session->unset_userdata('bannerImg_check'); 
      }
      if ($this->session->userdata('logoImg_check') != '') {
          $logoImg_check         = $this->session->userdata('logoImg_check');
          $insert['logo_image']  = $logoImg_check['logo_image'];
           $this->session->unset_userdata('logoImg_check'); 
      }
      if ($this->session->userdata('menuIcon_check') != '') {
          $menuIcon_check         = $this->session->userdata('menuIcon_check');
          $insert['menu_icon']  = $menuIcon_check['menu_icon'];
          $this->session->unset_userdata('menuIcon_check'); 
      }
      if ($this->session->userdata('menuImage_check') != '') {
          $menuImage_check         = $this->session->userdata('menuImage_check');
          $insert['menu_image']  = $menuImage_check['menu_image'];
          $this->session->unset_userdata('menuImage_check');
      }
      if ($this->common_model->insert('category', $insert)){ 
        $this->session->set_flashdata('msg_success', 'Category information added successfully'); 
        redirect('backend/category/add_category'); 
      }else{
        $this->session->set_flashdata('msg_error', 'Sorry! Adding process has been failed. Please try again'); 
        redirect('backend/category/add_category');
      } 
    } 
    $data['template'] = 'backend/category/add_category'; 
    $this->load->view('templates/superadmin_template', $data); 
  } 

  public function add_subcategory($id = ''){ 
    $this->_check_login(); //check login authentication 

    $data['title']='Add Subcategory';
    if($id){
      $data['parentRow'] = $parentRow = $this->common_model->get_row('category', array('category_id' => $id));
      if(!$parentRow) redirect(base_url('backend/category/add_category')); 
    }
    $this->form_validation->set_rules('category_name', 'Category Name', 'required|trim|max_length[80]'); 
   // $this->form_validation->set_rules('short_description', 'Short Description', 'required|trim|max_length[100]');
    $this->form_validation->set_rules('category_slug', 'Category Slug', 'required|trim|alpha_numeric|is_unique[category.category_slug]');
   // $this->form_validation->set_rules('description', 'Description', 'required|trim'); 
    $this->form_validation->set_rules('banner_image', 'Banner Image', 'callback_bannerImg_check');
    $this->form_validation->set_rules('logo_image', 'Tile Image', 'callback_logoImg_check');
    $this->form_validation->set_rules('order_by', 'Order By', 'numeric');
    if ($this->form_validation->run() == TRUE){ 
      ini_set('memory_limit', '-1'); 
      $insert = [
        'category_name'     => trim($this->input->post('category_name')),
        'category_slug'     => url_title(trim($this->input->post('category_slug')), 'dash', true),
        'meta_title'        => $this->input->post('meta_title'),
		    'meta_keyword'      => $this->input->post('meta_keyword'),
        'meta_description'  => $this->input->post('meta_description'),
        'status'            => 1,
       /* 'description'       => $this->input->post('description'),*/
        'short_description' => $this->input->post('short_description'),
        'is_menu'           => $this->input->post('is_menu'),
        'is_home'           => $this->input->post('is_home'),
		    'order_by'       	  => $this->input->post('order_by'),
        'user_id'           => 0,
        'parent_id'         => $id,
        'adminstatus'       => 1,
        'commision'         => get_option_url('COMMISION_FEE'),
        'created_at'        => date('Y-m-d H:i:s A')
      ];
      if ($this->session->userdata('bannerImg_check') != '') {
          $bannerImg_check         = $this->session->userdata('bannerImg_check');
          $insert['banner_image']  = $bannerImg_check['banner_image'];
      }
      if ($this->session->userdata('logoImg_check') != '') {
          $logoImg_check         = $this->session->userdata('logoImg_check');
          $insert['logo_image']  = $logoImg_check['logo_image'];
      }

      if ($this->common_model->insert('category', $insert)){ 
        $this->session->unset_userdata('bannerImg_check'); 
        $this->session->unset_userdata('logoImg_check'); 
        $this->session->set_flashdata('msg_success', 'Category information added successfully'); 
        redirect('backend/category/add_category/'.$id); 
      }else{
        $this->session->set_flashdata('msg_error', 'Sorry! Adding process has been failed. Please try again'); 
        redirect('backend/category/add_category/'.$id);
      } 
    } 
    $data['template'] = 'backend/category/add_subcategory'; 
    $this->load->view('templates/superadmin_template', $data); 
  }
  public function edit($id = ''){ 
    $this->_check_login(); //check login authentication 

    $data['title']='Edit category Details';
    if($id){
      $data['parentRow'] = $parentRow = $this->common_model->get_row('category', array('category_id' => $id));
      if(!$parentRow) redirect(base_url('backend/category/add_category')); 
    }
    $this->form_validation->set_rules('category_name', 'Subcategory Name', 'required|trim|max_length[80]'); 
      /*$this->form_validation->set_rules('short_description', 'Short Description', 'required|trim|max_length[100]');
    $this->form_validation->set_rules('description', 'Description', 'required|trim'); */
  	if(!empty($_FILES) && !empty($_FILES['banner_image']) && $_FILES['banner_image']['name']!='')
		$this->form_validation->set_rules('banner_image', 'Banner Image', 'callback_bannerImg_check');
    if(!empty($_FILES) && !empty($_FILES['logo_image'])  && $_FILES['logo_image']['name']!='')
		$this->form_validation->set_rules('logo_image', 'Tile Image', 'callback_logoImg_check');
    if($data['parentRow']->parent_id==0){
      if(!empty($_FILES) && !empty($_FILES['menu_icon'])  && $_FILES['menu_icon']['name']!='')
        $this->form_validation->set_rules('menu_icon', 'Menu Icon', 'callback_menuIcon_check');
      if(!empty($_FILES) && !empty($_FILES['menu_image'])  && $_FILES['menu_image']['name']!='')
        $this->form_validation->set_rules('menu_image', 'Mega Menu Image', 'callback_menuImage_check');
	  }
    $this->form_validation->set_rules('order_by', 'Order By', 'numeric');
    if ($this->form_validation->run() == TRUE){ 
      $insert = [
        'category_name'     => trim($this->input->post('category_name')),
        'meta_title'        => $this->input->post('meta_title'),
		    'meta_keyword'      => $this->input->post('meta_keyword'),
        'meta_description'  => $this->input->post('meta_description'),
        'status'            => $this->input->post('category_status'),
        //'description'       => $this->input->post('description'),
		    'order_by'       	  => $this->input->post('order_by'),
        'short_description' => $this->input->post('short_description'),
        'is_menu'           => $this->input->post('is_menu'),
        'is_home'           => $this->input->post('is_home'),
        'created_at'        => date('Y-m-d H:i:s A')
      ];
      if ($this->session->userdata('bannerImg_check') != '') {
          $bannerImg_check         = $this->session->userdata('bannerImg_check');
          $insert['banner_image']  = $bannerImg_check['banner_image'];
          $this->session->unset_userdata('bannerImg_check'); 
      }
      if ($this->session->userdata('logoImg_check') != '') {
          $logoImg_check         = $this->session->userdata('logoImg_check');
          $insert['logo_image']  = $logoImg_check['logo_image'];
          $this->session->unset_userdata('logoImg_check'); 
      }
      if ($this->session->userdata('menuIcon_check') != '') {
          $menuIcon_check         = $this->session->userdata('menuIcon_check');
          $insert['menu_icon']  = $menuIcon_check['menu_icon'];
           $this->session->unset_userdata('menuIcon_check'); 
      }
      if ($this->session->userdata('menuImage_check') != '') {
          $menuImage_check         = $this->session->userdata('menuImage_check');
          $insert['menu_image']  = $menuImage_check['menu_image'];
          $this->session->unset_userdata('menuImage_check'); 
      }
      if ($this->common_model->update('category', $insert,array('category_id'=>$id))){ 
        $this->session->set_flashdata('msg_success', 'Category information updated successfully'); 
        redirect('backend/category/edit/'.$id); 
      }else{
        $this->session->set_flashdata('msg_error', 'Sorry! Updation process has been failed. Please try again'); 
        redirect('backend/category/edit/'.$id);
      } 
    } 
    $data['template'] = 'backend/category/edit'; 
    $this->load->view('templates/superadmin_template', $data); 
  }

	public function delete($id = '', $table = 'category'){ 
		$this->_check_login(); //check login authentication 
		$data = $this->common_model->get_row($table, array('category_id' => $id));
		if (!$data) redirect('backend/category/index'); 
		if ($this->common_model->delete($table, array('category_id' => $id))){ 
        $this->load->model('category_model');
        $this->category_model->deleteCategory($id);
			  $this->session->set_flashdata('msg_success', 'Category information deleted successfully'); 
			
		}else{ 
			$this->session->set_flashdata('msg_error', 'Sorry! Deletion process has been failed. Please try again'); 
			 
		} 
		 redirect($_SERVER['HTTP_REFERER']); 
	} 
  public function menuImage_check(){  
    if (!empty($_FILES['menu_image']['name'])){
      $image = getimagesize($_FILES['menu_image']['tmp_name']); 

    if (($image[0] <300 || $image[1] <300) || ($image[0] >500 || $image[1] >500)){ 
        $this->form_validation->set_message('menuImage_check', 'Oops! Your menu image needs to be atleast 300 x 300 pixels and at max 500 x 500'); 
        return FALSE; 
    } 
      $config['upload_path'] = 'assets/uploads/backend/category_img/menu/'; 
      $config['allowed_types'] = 'jpg|png|jpeg|svg'; 
      $config['max_size'] = '5024'; 
      $config['max_width'] = '5024'; 
      $config['max_height'] = '5024'; 
      $this->load->library('upload', $config); 
      $this->upload->initialize($config); 
      if (!$this->upload->do_upload('menu_image')){ 
        $this->form_validation->set_message('menuImage_check', $this->upload->display_errors()); 
        return FALSE; 
      }else{ 
        $data = $this->upload->data(); // upload image 
        $this->session->set_userdata('menuImage_check', array('menu_image' => $data['file_name'])); 
        return TRUE; 
      }
    }else{ 
      $this->form_validation->set_message('menuImage_check', 'Choose the menu Image'); 
      return FALSE; 
    } 
  }
  public function menuIcon_check(){  
    if (!empty($_FILES['menu_icon']['name'])){
      $image = getimagesize($_FILES['menu_icon']['tmp_name']); 

    if (($image[0] <10 || $image[1] <10) || ($image[0] >100 || $image[1] >100)){ 
        $this->form_validation->set_message('menuIcon_check', 'Oops! Your menu icon needs to be atleast 10 x 10 pixels and at max 100 x 100'); 
        return FALSE; 
    } 
      $config['upload_path'] = 'assets/uploads/backend/category_img/icon/'; 
      $config['allowed_types'] = 'jpg|png|jpeg|svg'; 
      $config['max_size'] = '5024'; 
      $config['max_width'] = '5024'; 
      $config['max_height'] = '5024'; 
      $this->load->library('upload', $config); 
      $this->upload->initialize($config); 
      if (!$this->upload->do_upload('menu_icon')){ 
        $this->form_validation->set_message('menuIcon_check', $this->upload->display_errors()); 
        return FALSE; 
      }else{ 
        $data = $this->upload->data(); // upload image 
        $this->session->set_userdata('menuIcon_check', array('menu_icon' => $data['file_name'])); 
        return TRUE; 
      }
    }else{ 
      $this->form_validation->set_message('menuIcon_check', 'Choose the menu icon'); 
      return FALSE; 
    } 
  }




  public function bannerImg_check(){  
    if (!empty($_FILES['banner_image']['name'])){
      $image = getimagesize($_FILES['banner_image']['tmp_name']); 

    if (($image[0] <1400 || $image[1] <350) || ($image[0] >1600 || $image[1] >500)){ 
        $this->form_validation->set_message('bannerImg_check', 'Oops! Your Banner image needs to be atleast 1400 x 350 pixels and at max 1600 x 500'); 
        return FALSE; 
    } 
      $config['upload_path'] = 'assets/uploads/backend/category_img/banner/'; 
      $config['allowed_types'] = 'jpg|png|jpeg|svg'; 
      $config['max_size'] = '5024'; 
      $config['max_width'] = '5024'; 
      $config['max_height'] = '5024'; 
      $this->load->library('upload', $config); 
      $this->upload->initialize($config); 
      if (!$this->upload->do_upload('banner_image')){ 
        $this->form_validation->set_message('bannerImg_check', $this->upload->display_errors()); 
        return FALSE; 
      }else{ 
        $data = $this->upload->data(); // upload image 
        $this->session->set_userdata('bannerImg_check', array('banner_image' => $data['file_name'])); 
        return TRUE; 
      }
    }else{ 
      $this->form_validation->set_message('bannerImg_check', 'Choose the banner image'); 
      return FALSE; 
    } 
  }

  public function logoImg_check(){  
    if (!empty($_FILES['logo_image']['name'])){
      $image = getimagesize($_FILES['logo_image']['tmp_name']); 
    if (($image[0] <100  || $image[1] <100) || ($image[0] >500 || $image[1] >500)){ 
        $this->form_validation->set_message('logoImg_check', 'Oops! Your Tile Image needs to be atleast 100 x 100 pixels and at max 500 x 500'); 
        return FALSE; 
    } 
      $config['upload_path'] = 'assets/uploads/backend/category_img/logo/'; 
      $config['allowed_types'] = 'jpg|png|jpeg|svg'; 
      $config['max_size'] = '5024'; 
      $config['max_width'] = '5024'; 
      $config['max_height'] = '5024'; 
      $this->load->library('upload', $config); 
      $this->upload->initialize($config); 
      if (!$this->upload->do_upload('logo_image')){ 
        $this->form_validation->set_message('logoImg_check', $this->upload->display_errors()); 
        return FALSE; 
      }else{ 
        $data = $this->upload->data(); // upload image 
        $this->session->set_userdata('logoImg_check', array('logo_image' => $data['file_name'])); 
        return TRUE; 
      }
    }else{ 
      $this->form_validation->set_message('logoImg_check', 'Choose the tile image'); 
      return FALSE; 
    } 
  } 

  public function change_status($table='',$col='',$value='',$status=''){ 
    if($table=='' || $col=='' || $value=='' || $status=='') redirect($_SERVER['HTTP_REFERER']);
        $update_status= array('status'=>$status);
    if($this->common_model->update($table,$update_status,array($col=>$value))) {
            $this->common_model->update($table,$update_status,array('adminstatus'=>$value));
            $this->load->model('category_model');
            $this->category_model->changeStatus($value, $spacing = '', $user_tree_array = '',$status);
            $this->session->set_flashdata('msg_success','Status updated successfully');
        }else {
            $this->session->set_flashdata('msg_warning','Sorry! Updation process has been failed. Please try again');
        }
        redirect($_SERVER['HTTP_REFERER']);
  }
   public function promotion_image($category_id='')
  {
      if($category_id){
        $data['parentRow'] = $parentRow = $this->common_model->get_row('category', array('category_id' => $category_id));
        if(!$parentRow)  redirect($_SERVER['HTTP_REFERER']); 
      }
      $data['title']='Promotional Image';
      if($this->input->post('type_action') == 1){       
          $this->form_validation->set_rules('page_to_redirect','page_to_redirect','trim');
          $this->form_validation->set_rules('order', 'sequence No.', 'required');
          $this->form_validation->set_rules('promotion_image','','callback_check_promotion_image'); 
      }
      if($this->input->post('type_action') == 3){       
        $this->form_validation->set_rules('page_to_redirect_edit','page_to_redirect_edit','trim'); 
      }
      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
      if ($this->form_validation->run() == TRUE){
            if($this->input->post('type_action') == 1){ 
            if($this->session->userdata('check_promotion_image')!=''){
               $promotion_image=$this->session->userdata('check_promotion_image');
               $data_img['promotion_image'] = $promotion_image['promotion_image'];
            }  
            if($this->input->post('type_action') == 1){
              $data_img['link'] = $this->input->post('page_to_redirect');
              $data_img['created'] = date('Y-m-d,H:i:s A');
              $data_img['order'] = $this->input->post('order');
              $data_img['category_id'] = $category_id;
              
              if($this->common_model->insert('promotion_image',$data_img)){
                $this->session->unset_userdata('check_promotion_image');   
                $this->session->set_flashdata('msg_success','Online promotion image added successfully');
              }else{
                $this->session->set_flashdata('msg_error','Sorry! Adding process has been failed. Please try again');
              }               
            }       
            if($this->input->post('type_action') == 3){
              $data_img['link'] = $this->input->post('page_to_redirect_edit');
              $data_img['order'] = $this->input->post('order_edit');
              if($this->common_model->update('promotion_image',$data_img,array('id'=>$this->input->post('row_id')))){
                $this->session->unset_userdata('check_promotion_image');   
                $this->session->set_flashdata('msg_success','Online promotion image updated successfully');
              }else{
                $this->session->set_flashdata('msg_error','Sorry! Updation process has been failed. Please try again');
              }
            } 
             redirect($_SERVER['HTTP_REFERER']);     
          }
      }
      $data['promotion'] = $this->common_model->get_result('promotion_image',array('category_id'=>$category_id),array(''),array('order','ASC')); 
      $data['template']='backend/category/promotion_image';
      $this->load->view('templates/superadmin_template',$data);
    }
    function check_promotion_image($str){ 
        $this->_check_login(); //check login authentication
        $data['title']='';
        if(empty($_FILES['promotion_image']['name'])){     
                $this->form_validation->set_message('check_promotion_image', 'Choose the promotion image');
               return FALSE;
            } 
        if(!empty($_FILES['promotion_image']['name'])):
          $image = getimagesize($_FILES['promotion_image']['tmp_name']);

            if (($image[0] < 500 || $image[1]<500) || ($image[0] > 1000 || $image[1] > 1000)) {
               $this->form_validation->set_message('check_promotion_image', 'Oops! Your promotion image needs to be atleast of 500 X 500 pixels and at most of 1000 X 1000 pixels');
               return FALSE;
             }
          
            $config['upload_path'] = './assets/uploads/backend/category_img/promotion/';
            $config['allowed_types'] = 'jpeg|jpg|png|svg';
            $config['max_size']  = '5024';
            $config['max_width']  = '5024';
            $config['max_height']  = '5024';
            $this->load->library('upload', $config);
          if (!$this->upload->do_upload('promotion_image')){
            $this->form_validation->set_message('check_promotion_image', $this->upload->display_errors());
            return FALSE;
          }else{
            $data = $this->upload->data(); // upload image                    
            $this->session->set_userdata('check_promotion_image',array('promotion_image'=>$data['file_name']));
            return TRUE;
          }
        else:     
            $this->form_validation->set_message('check_promotion_image', 'The %s field required');
            return FALSE;
        endif;
    }


    public function brands($offset=0)
    {


      $data['title']='Brand Image';
      $search=array();
      if(!empty($_GET))
      {
        if(!empty($_GET['brand_name']))
        $search[]=' brand_name like "%'.trim($_GET['brand_name']).'%"';
        if(!empty($_GET['status']))
        $search[]=' status = "'.trim($_GET['status']).'"';
      }

      $data['brand'] = $this->common_model->get_result_pagination('brand', '', array('brand.*','users.user_name as seller_name'), '', array(array('table'=>'users','condition'=>'users.user_id=brand.seller_id','type'=>'left')), $offset, PER_PAGE, $search);

      // p($data['brand']);
      // exit;
      $config=backend_pagination();

      $config['base_url'] = base_url().'backend/category/brands';
      $config['total_rows'] = $this->common_model->get_result_pagination('brand', '', '', '', '', 0, 0, $search);
      $config['per_page'] = PER_PAGE;
      $config['uri_segment'] = 4;
      if(!empty($_SERVER['QUERY_STRING'])){
         $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
      }else{
          $config['suffix'] ='';
      }
      $config['first_url'] = $config['base_url'].$config['suffix'];
      if($config['total_rows'] < $offset){
         $this->session->set_flashdata('msg_warning','Something went wrong! Please try again');    
         redirect($_SERVER['HTTP_REFERER']);
      }
      $this->pagination->initialize($config);
      $data['pagination']=$this->pagination->create_links();
      $data['template']='backend/category/brand_image';
      $data['offset']=$offset;


      if($this->input->post('type_action') == 1){       
          $this->form_validation->set_rules('brand_name','Brand Name','trim|required');
          
          $this->form_validation->set_rules('category_id[]', 'Category Id', 'required');
          $this->form_validation->set_rules('brand_image', 'Brand Image','callback_check_brand_image'); 
      }else if($this->input->post('type_action') == 3){       
        $this->form_validation->set_rules('brand_name_edit','Brand Name','trim');
       
        $this->form_validation->set_rules('category_edit_id[]', 'Category Id', 'required');
      }

      $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

      if ($this->form_validation->run() == TRUE){
        if($this->input->post('type_action') == 1){

          if($this->session->userdata('check_brand_image')!=''){
             $brand_image=$this->session->userdata('check_brand_image');
             $data_img['brand_image'] = $brand_image['brand_image'];
          }  

          $data_img['brand_name'] = $this->input->post('brand_name');
          $data_img['created'] = date('Y-m-d,H:i:s A');
          $data_img['order'] = $this->input->post('order');
          $data_img['category_id'] = implode(',', $this->input->post('category_id'));
          
          if($this->common_model->insert('brand',$data_img)){
            $this->session->unset_userdata('check_brand_image');   
            $this->session->set_flashdata('msg_success','Brand information added successfully');
          }else{
            $this->session->set_flashdata('msg_error','Sorry! Adding process has been failed. Please try again');
          } 

        }else if($this->input->post('type_action') == 3){
          $data_img['brand_name'] = $this->input->post('brand_name_edit');
          $data_img['category_id'] = implode(',', $this->input->post('category_edit_id'));
          $data_img['order'] = $this->input->post('order_edit');
        
          if($this->common_model->update('brand',$data_img,array('brand_id'=>$this->input->post('row_id')))){
            $this->session->unset_userdata('check_brand_image');   
            $this->session->set_flashdata('msg_success','Brand information updated successfully');
          }else{
            $this->session->set_flashdata('msg_error','Sorry! Updation process has been failed. Please try again');
          }
        } 
        redirect($_SERVER['HTTP_REFERER']);
      }
    $this->load->view('templates/superadmin_template',$data);
    } 
    function check_brand_image($str){ 
        $this->_check_login(); //check login authentication
        $data['title']='';
        if(empty($_FILES['brand_image']['name'])){     
            $this->form_validation->set_message('check_brand_image', 'Choose the brand image');
           return FALSE;
        } 
        if(!empty($_FILES['brand_image']['name'])):
          $image = getimagesize($_FILES['brand_image']['tmp_name']);

            if (($image[0] < 100 || $image[1]<50) || ($image[0] > 300 || $image[1] > 100)) {
               $this->form_validation->set_message('check_brand_image', 'Oops! Your brand image needs to be atleast of 100 X 50 pixels and at most of 300 X 100 pixels');
               return FALSE;
             }
          
            $config['upload_path'] = './assets/uploads/backend/category_img/brand/';
            $config['allowed_types'] = 'jpeg|jpg|png|svg';
            $config['max_size']  = '5024';
            $config['max_width']  = '5024';
            $config['max_height']  = '5024';
            $this->load->library('upload', $config);
          if (!$this->upload->do_upload('brand_image')){
            $this->form_validation->set_message('check_brand_image', $this->upload->display_errors());
            return FALSE;
          }else{
            $data = $this->upload->data(); // upload image                    
            $this->session->set_userdata('check_brand_image',array('brand_image'=>$data['file_name']));
            return TRUE;
          }
        else:     
            $this->form_validation->set_message('check_brand_image', 'The %s field required');
            return FALSE;
        endif;
    }
    
}