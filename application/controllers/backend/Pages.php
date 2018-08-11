<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Pages extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        clear_cache();
        $this->load->model('superadmin_model');
        if(superadmin_logged_in()===FALSE) redirect('behindthescreen');
    }

    public function index($offset=0){
        $data['title']='Pages';

        $search=array();
        if(!empty($_GET))
        {
            if(!empty($_GET['title']))
            $search[]=' title like "%'.trim($_GET['title']).'%"';
            if(!empty($_GET['type_of_section']))
            $search[]=' type_of_section = "'.trim($_GET['type_of_section']).'"';
            if(!empty($_GET['status']))
            $search[]=' status = "'.trim($_GET['status']).'"';
        }
       $data['templates'] = $this->common_model->get_result_pagination('pages', '', '', array('page_id','desc'), '', $offset, PER_PAGE, $search);
        $config=backend_pagination();
        $config['base_url'] = base_url().'backend/pages/index/';
        $config['total_rows'] = $this->common_model->get_result_pagination('pages', '', '', array('page_id','desc'), '', 0, 0, $search);
        
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
        $data['template']='backend/pages/index';
        $data['offset']=$offset;
        $this->load->view('templates/superadmin_template',$data);
    }

    public function add(){
        $data['title']='Add Page';

        $segments = $this->input->post('type_of_section').', 0';
        $this->form_validation->set_rules('title', 'Page Title', 'trim|required');
        $this->form_validation->set_rules('slug', 'Page Slug', 'trim|required|callback_check_id['.$segments.']');
        $this->form_validation->set_rules('description', 'Page Description', 'trim|required');
        $this->form_validation->set_rules('type_of_section', 'Section Type', 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() == TRUE){
            $template_data  = array(
                'title'     =>  $this->input->post('title'),
                'slug'      =>  $this->input->post('slug'),
                'meta_description' => $this->input->post('meta_description'),
                'meta_content' => $this->input->post('meta_content'),
                'meta_keyword' => $this->input->post('meta_keyword'),
                'description' =>  $this->input->post('description'),
                'type_of_section' =>  $this->input->post('type_of_section'),
                'created_at'    =>  date('Y-m-d H:i:s A')
            );
            if($this->superadmin_model->insert('pages',$template_data)){
                $this->session->set_flashdata('msg_success','Page added successfully');
                redirect('backend/pages/index');
            }else{
                $this->session->set_flashdata('msg_error','Sorry! Adding process has been failed. Please try again');
                redirect('backend/pages/index');
            }
        }
        $data['template']='backend/pages/add';
        $this->load->view('templates/superadmin_template',$data);
    }

    public function edit($id=''){
        $data['title']='Edit Page';
        if(empty($id)) redirect('backend/pages/index');

        $segments = $this->input->post('type_of_section').', '.$id;
        $this->form_validation->set_rules('title', 'Page Title', 'trim|required');
        $this->form_validation->set_rules('slug', 'Page Slug', 'trim|required|callback_check_id['.$segments.']');
        $this->form_validation->set_rules('description', 'Page Description', 'trim|required');
        $this->form_validation->set_rules('type_of_section', 'Section Type', 'trim|required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() == TRUE){
            $template_data  = array(
                'title'     =>  $this->input->post('title'),
                'description' =>  $this->input->post('description'),
                'meta_description' => $this->input->post('meta_description'),
                'meta_content' => $this->input->post('meta_content'),
                'meta_keyword' => $this->input->post('meta_keyword'),
                'type_of_section' =>  $this->input->post('type_of_section'),
                'updated_at'    =>  date('Y-m-d H:i:s A')
            );
            if($this->superadmin_model->update('pages',$template_data,array('page_id'=>$id))){
                $this->session->set_flashdata('msg_success','Page updated successfully');
                redirect('backend/pages/index');
            }else{
                $this->session->set_flashdata('msg_error','Sorry! Updation process has been failed. Please try again');
                redirect('backend/pages/index');
            }
        }
        $data['page'] = $this->superadmin_model->get_row('pages',array('page_id'=>$id));
        $data['template']='backend/pages/edit';
        $this->load->view('templates/superadmin_template',$data);
    }

    public function view($id='')    {
        $data['title']='View Page Details';
        if(empty($id)) redirect('backend/pages/index');
        $data['pages'] = $this->superadmin_model->get_row('pages',array('id'=>$id));
        $data['template']='backend/pages/view';
        $this->load->view('templates/superadmin_template',$data);
    }

    public function delete($id ='') {
        $data['title']='';
        if(empty($id)) redirect('backend/pages/index');
        if($this->superadmin_model->delete('pages',array('id'=>$id))){
                $this->session->set_flashdata('msg_success','Page deleted successfully');
                redirect('backend/pages/index');
        }else{
            $this->session->set_flashdata('msg_error','Sorry! Deletion process has been failed. Please try again');
            redirect('backend/pages/index');
        }
    }

    public function check_id($str='',$segments=''){
        $res = explode(",", $segments);

        if($res[1]==0){
            if($this->common_model->get_row('pages',array('slug'=>$str, 'type_of_section'=>$res[0]))):
              $this->form_validation->set_message('check_id', 'The %s already exists');
              return FALSE;
            else:
              return TRUE;
            endif;
        }else{
            if($this->common_model->get_row('pages',array('slug'=>$str, 'page_id !='=>$res[1], 'type_of_section'=>$res[0]))):
              $this->form_validation->set_message('check_id', 'The %s already exists');
              return FALSE;
            else:
              return TRUE;
            endif;
        }
    }


    public function faq_add(){ 
        $this->_check_login(); //check login authentication
        $data['title']='Add FAQs';
        $this->form_validation->set_rules('category_id', 'Category Name', 'required');
        $this->form_validation->set_rules('sub_category_id', 'Subcategory Name', 'required');        
        $this->form_validation->set_rules('question', 'Question', 'required');      
        $this->form_validation->set_rules('answer', 'Answer', 'required'); 
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run() == TRUE){   
            $category_data = array(
                'category_id'    =>    ucfirst($this->input->post('category_id')),     
                'question'    => $this->input->post('question'),'answer'    =>    $this->input->post('answer'),
                'sub_category_id'    =>    $this->input->post('sub_category_id'),
                'meta_description' => $this->input->post('meta_description'),
                'meta_content' => $this->input->post('meta_content'),
                'meta_keyword' => $this->input->post('meta_keyword'),   
                'created'        =>  date('Y-m-d H:i:s A')
                );

                if($this->input->post('sub_category_id')){
                    $category_data['sub_category_id'] = $this->input->post('sub_category_id');
                }else{
                    $category_data['sub_category_id'] = null; 
                }
            if($category_id=$this->superadmin_model->insert('faq',$category_data)){
                $this->session->set_flashdata('msg_success','FAQs inforamtion added successfully');
                redirect('backend/pages/faq');
            }else{
                $this->session->set_flashdata('msg_error','Sorry! Adding process has been failed. Please try again');
                redirect('backend/pages/faq_add');
            }
        }
        $data['category'] = $this->superadmin_model->get_result('faq_category',array(),array(),array('category_name','asc'));
        $data['sub_category'] = $this->superadmin_model->get_result('faq_sub_category',array(),array(),array('sub_category_name','asc'));
        $data['template'] ='backend/pages/faq_add';
        $this->load->view('templates/superadmin_template',$data);
    }

    public function faq_category($offset=0) {
        $this->_check_login(); //check login authentication
        $data['title']='FAQs Categories';
        $data['page_category'] = $this->superadmin_model->faq_category($offset,PER_PAGE);
        $config=backend_pagination(); 
        $config['base_url'] = base_url().'backend/page/faq_category/';
        $config['total_rows'] = $this->superadmin_model->faq_category(0,0);
        
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
        $data['offset'] = $offset;
        $data['template']='backend/pages/faq_category';
        $this->load->view('templates/superadmin_template',$data);
    }


    public function category_add(){ 
       $this->_check_login(); //check login authentication
        $data['title']='Add Category Page';
        $this->form_validation->set_rules('category_name', 'Category Name', 'required');   
        $this->form_validation->set_rules('description', 'Description', 'required');       
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run() == TRUE){   
        $store_cat_count=0;
            if($info = $this->common_model->get_row('faq_category',array('category_name'=>$_POST['category_name']))){
                $store_cat_count++;
            }  
        
            $category_data = array(
                'category_name'    =>    ucfirst($this->input->post('category_name')),     
                'category_slug'    =>    url_title(trim(strtolower($this->input->post('category_name')))),        
                'description'      =>    $this->input->post('description'),
                'created'          =>    date('Y-m-d H:i:s A')
                );
            
           

            if($category_id=$this->superadmin_model->insert('faq_category',$category_data)){
             
                if($store_cat_count){
                    $slug =url_title(trim(strtolower($this->input->post('category_name').'_'.$category_id)));
                    $sub_slug= array('category_slug'=>$slug);
                    $this->superadmin_model->update('faq_category', $sub_slug,array('id'=>$category_id));
                }
                $this->session->set_flashdata('msg_success','FAQs Category information added successfully');
                redirect('backend/pages/faq_sub_category'.'/'.$category_id); 
                    
            }else{
                $this->session->set_flashdata('msg_error','Sorry! Adding process has been failed. Please try again');
                redirect('backend/pages/faq_category');
            }
        }
        $data['template'] ='backend/pages/faq_category_add';
        $this->load->view('templates/superadmin_template',$data);
    }


    /*==================Page CATEGORY END================*/
    public function faq_sub_category($cat_id='')
     {       
        $this->_check_login(); //check login authentication
        $data['title']='FAQs Subcategories';
        if(empty($cat_id))  redirect('backend/superadmin/error_404');
        $data['cat_id'] = $cat_id;
        $this->form_validation->set_rules('category_name', 'Subcategory Name', 'required'); 
        $this->form_validation->set_rules('description', 'Description', 'required');       
         $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run() == TRUE){

            $page_sub_count=0;
            if($info = $this->common_model->get_row('faq_sub_category',array('sub_category_name'=>$_POST['category_name']))){
                $page_sub_count++;
            }  
            $category_data = array(
                'category_id'=>$cat_id,
                'sub_category_name'  =>  $this->input->post('category_name'), 
                'description'  =>  $this->input->post('description'),                 
                'faq_sub_category_slug'=>url_title(trim(strtolower($this->input->post('category_name'))), '-', TRUE),  
                'created'       =>  date('Y-m-d H:i:s A')
                );
           
            if($sub_category_id=$this->superadmin_model->insert('faq_sub_category',$category_data)){
                if($page_sub_count){
                    $slug =url_title(trim(strtolower($this->input->post('category_name').'_'.$sub_category_id)));
                    $sub_slug= array('store_sub_category_slug'=>$slug);
                    $this->superadmin_model->update('faq_sub_category_slug', $sub_slug,array('faq_sub_category_id'=>$sub_category_id));
                }
                 $this->session->set_flashdata('msg_success','FAQs subcategory information added successfully');
            }
            redirect('backend/pages/faq_sub_category'.'/'.$cat_id);
        }
        $data['page_category'] = $this->superadmin_model->get_row('faq_category',array('faq_category_id'=>$cat_id));
        if(empty($data['page_category']))  redirect('backend/superadmin/error_404');

        $data['page_sub_category'] = $this->superadmin_model->get_result('faq_sub_category',array('category_id'=>$cat_id),array(),array('sub_category_name','asc'));
        $data['template'] ='backend/pages/faq_sub_category';
        $this->load->view('templates/superadmin_template',$data);
      }


    public function faq_category_edit($cat_id='')    {
        $this->_check_login(); //check login authentication
        $data['title']='Edit FAQs Categories';
        if(empty($cat_id)) redirect('backend/superadmin/error_404');
        $data['page_category'] = $this->superadmin_model->get_row('faq_category',array('faq_category_id'=>$cat_id));
        if(empty($data['page_category'])) redirect('backend/superadmin/error_404');
        $this->form_validation->set_rules('category_name', 'Category name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() == TRUE){         
            $category_data = array(
                'category_name'             =>  ucfirst($this->input->post('category_name')),
                'category_slug'             =>  url_title(trim(strtolower($this->input->post('category_name')))),
                'description'               =>  $this->input->post('description'),
                'updated'                   =>  date('Y-m-d H:i:s A')
                );
       
        if($this->superadmin_model->update('faq_category',$category_data,array('faq_category_id'=>$cat_id))){
            $this->session->set_flashdata('msg_success','FAQs category information updated successfully');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('msg_error','Sorry! Updation process has been failed. Please try again');
            redirect($_SERVER['HTTP_REFERER']);
        }
        }
       
        if(empty($data['page_category']))
        {
            redirect('backend/superadmin/error_404');
        }  
        $data['template']='backend/pages/faq_category_edit';
        $this->load->view('templates/superadmin_template',$data);
    }


    //Question and Ans
    public function faq($offset=0)
    {
       $this->_check_login(); //check login authentication
        $data['title']='FAQs';
        $data['question_answer'] = $this->superadmin_model->faq($offset,PER_PAGE);
        $config=backend_pagination();
        $config['base_url'] = base_url().'backend/pages/faq/';
        $config['total_rows'] = $this->superadmin_model->faq(0,0);
        
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
        $data['offset'] = $offset;
        $data['template']='backend/pages/faq';
        $this->load->view('templates/superadmin_template',$data);
    }


    public function faq_edit($id){ 
        $this->_check_login(); //check login authentication
        $data['title']='Edit FAQs Details';
        if(empty($id)) redirect('backend/superadmin/error_404');
        $data['question_answer'] = $this->superadmin_model->get_row('faq',array('faq_id'=>$id));  
      // p($data['question_answer']) ;

        if(empty($data['question_answer'])) redirect('backend/superadmin/error_404');
        $this->form_validation->set_rules('category_id', 'Category Name', 'required');
        $this->form_validation->set_rules('sub_category_id', 'Subcategory Name', 'required');     
        $this->form_validation->set_rules('question', 'Question', 'required');      
        $this->form_validation->set_rules('answer', 'Answer', 'required'); 
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run() == TRUE){   
          
            $category_data = array(
                'category_id'    =>    ucfirst($this->input->post('category_id')),     
                'question'    => $this->input->post('question'),'answer'    =>    $this->input->post('answer'),            
                'meta_description' => $this->input->post('meta_description'),
                'meta_content' => $this->input->post('meta_content'),
                'meta_keyword' => $this->input->post('meta_keyword'),  
                'created'        =>  date('Y-m-d H:i:s A')
                );

             if($this->input->post('sub_category_id')){
                $category_data['sub_category_id'] = $this->input->post('sub_category_id');
            }else{
                $category_data['sub_category_id'] = null; 
            }

            if($category_id=$this->superadmin_model->update('faq',$category_data,array('faq_id'=>$id))){
             
              
                $this->session->set_flashdata('msg_success','FAQs information updated successfully');
                
                redirect('backend/pages/faq'); 
                    
            }else{
                $this->session->set_flashdata('msg_error','Sorry! Adding process has been failed. Please try again');
                redirect('backend/pages/faq_edit'.'/'.$id);
            }
        }
        $data['category'] = $this->superadmin_model->get_result('faq_category',array(),array(),array('category_name','asc'));
        $data['sub_category'] = $this->superadmin_model->get_result('faq_sub_category',array(),array(),array('sub_category_name','asc'));
        $data['template'] ='backend/pages/faq_edit';
        $this->load->view('templates/superadmin_template',$data);
    }


    public function changeuserstatus_t($id="",$status="",$offset="",$table_name="", $fild) {
          $this->_check_login(); //check login authentication
         $data['title']='';
        if($status==2) $status=1;
        else $status=2;
        $data=array('status'=>$status);
        if($this->superadmin_model->update($table_name,$data,array($fild =>$id)))
        $this->session->set_flashdata('msg_success','Status Updated successfully');
        redirect($_SERVER['HTTP_REFERER']);
    }

    private function _check_login(){

        if(superadmin_logged_in()===FALSE)
            redirect('behindthescreen');
    }


    public function faq_sub_category_edit($sub_category_search_id)
    {
         $this->_check_login(); //check login authentication
         $data['title']='Edit FAQs Subcategory';

        if(empty($sub_category_search_id)) { redirect('backend/superadmin/error_404'); }

         $data['page_sub_category'] = $this->superadmin_model->get_row('faq_sub_category',array('faq_sub_category_id'=>$sub_category_search_id));

        $this->form_validation->set_rules('category_name', 'FAQ Sub Category Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
       
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        if ($this->form_validation->run() == TRUE){
            $category_data = array(
                'sub_category_name'  =>  $this->input->post('category_name'),   
                'description'   =>     $this->input->post('description'),      
                'updated'       =>  date('Y-m-d H:i:s A')
                );
           
            if($sub_category_id=$this->superadmin_model->update('faq_sub_category',$category_data,array('faq_sub_category_id'=>$sub_category_search_id))){
                $this->session->set_flashdata('msg_success','FAQ subcategory updated successfully');
            } 
            redirect('backend/pages/faq_sub_category'.'/'.$data['page_sub_category']->category_id);
        }
       
        $data['page_category'] = $this->superadmin_model->get_row('faq_category',array('faq_category_id'=>$data['page_sub_category']->category_id));
        
           if(empty($data['page_category']))  redirect('backend/superadmin/error_404');
        $data['template'] ='backend/pages/faq_sub_category_edit';
        $this->load->view('templates/superadmin_template',$data);
      }



    public function getSubcategory()
    {   
        $sub_category = $this->superadmin_model->get_result('faq_sub_category',array('category_id'=>$_POST['cat_id']),array(),array('sub_category_name','asc'));
        echo json_encode($sub_category);  
    }


    public function change_all_status($tablename='')
    {     
        $this->_check_login(); //check login authentication   
        $data['title']='Change Status';
        $tablename = base64_decode($_POST['table_name']);
        $col_name  = base64_decode($_POST['col_name']);
            $default_arr=array('status'=>FALSE); 
            $status='';            
            $count= count($_POST['row_id']);
            
            for ($i=0; $i < $count ; $i++){
                if($_POST['status']==1 || $_POST['status']==2){
                    if($_POST['status']==1){
                        $update_status= array('status'=>1);
                    }elseif($_POST['status']==2){
                        $update_status= array('status'=>2);
                    }
                    $this->superadmin_model->update($tablename,$update_status,array($col_name=>$_POST['row_id'][$i]));
                    $default_arr=array('status'=>TRUE);
                }else{
                    $this->common_model->delete($tablename,array($col_name=>$_POST['row_id'][$i]));
                    $default_arr=array('status'=>TRUE);
                } 
            }
            header('Content-Type: application/json');
            echo json_encode($default_arr);        
       
    }

}