<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Slider extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        clear_cache();
        $this->load->model('superadmin_model');
    }
    public function index(){
		redirect('backend/slider/sliders');
	}
	private function _check_login(){
		if(superadmin_logged_in()===FALSE)
			redirect('behindthescreen');
	}

	public function sliders($offset=0) {
		$this->_check_login(); //check login authentication
		 $data['title']='Homepage Sliders'; 
		  if(isset($_POST['update'])){
			    		   
				$order = $this->input->post('order');
				foreach ($order as $key => $value) { 
				$this->common_model->update('slider_images',array('order'=>$value),array('slider_images_id'=>$key));
				}            
				$this->session->set_flashdata('msg_success','Slider image order sequence updated successfully');
				redirect('backend/slider/sliders');
	    	}	
        $data['offset']=$offset;
		$data['sliders'] = $this->superadmin_model->slider_images($offset,PER_PAGE);
 		$config=backend_pagination();
		$config['base_url'] = base_url().'backend/slider/sliders/';
		$config['total_rows'] = $this->superadmin_model->slider_images(0,0);
		
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
 		$data['template']='backend/slider/sliders';
		$this->load->view('templates/superadmin_template',$data);
	}
	public function slider_add(){
		$this->_check_login(); //check login authentication
		$data['title']='Add Slider Details'; 			
  		$this->form_validation->set_rules('order', 'order', 'required');
		$this->form_validation->set_rules('main_img_link', 'link', 'trim');
		$this->form_validation->set_rules('slider_file', '', 'callback_slider_file_check');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			if ($this->form_validation->run() == TRUE){
			 if($this->session->userdata('slider_file_check')!=''){
                $slider_file_check=$this->session->userdata('slider_file_check');               
                  $slider_data['slider_img'] ='assets/uploads/backend/slider_img/'.$slider_file_check['slider_file'];
             }
			$slider_data['slider_img_link'] =$this->input->post('main_img_link');
			$slider_data['order'] =$this->input->post('order');					 
			$slider_data['created'] =date('Y-m-d H:i:s A');
			if($this->common_model->insert('slider_images',$slider_data)){
					$this->session->unset_userdata('slider_file_check');
					$this->session->set_flashdata('msg_success','Slider image added successfully');
					redirect('backend/slider/sliders');
			}else{
					$this->session->set_flashdata('msg_error','Sorry! Slider image adding process has been failed. Please try again');
					redirect('backend/slider/sliders');
				}
			}
		$data['template'] ='backend/slider/slider_add';
		$this->load->view('templates/superadmin_template',$data);
	}
	public function slider_edit($slider_id=''){
		$this->_check_login(); //check login authentication
		$data['title']='Edit Slider Details'; 	
		if(empty($slider_id)){ redirect('backend/slider/sliders'); }
		$this->form_validation->set_rules('main_img_link', 'link', 'trim');
		if(!empty($_FILES['slider_file']['name'])):
				$this->form_validation->set_rules('slider_file', '', 'callback_slider_file_check');
		endif;
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		if ($this->form_validation->run() == TRUE){

			if(!empty($_FILES['slider_file']['name']) || !empty($_FILES['slider_file1']['name']))
			{
				$data['img']=$this->superadmin_model->checkimg('slider_images',$slider_id);
				if(!empty($_FILES['slider_file']['name'])){
						$filepath=$data['img']->slider_img;
						if(!empty($filepath)) @unlink($filepath);						
						$slider_file_check=$this->session->userdata('slider_file_check');
                 		$slider_data['slider_img'] ='assets/uploads/backend/slider_img/'.$slider_file_check['slider_file'];
			    }
			}
			  $slider_data['slider_img_link'] =$this->input->post('main_img_link');
			  $slider_data['updated'] =date('Y-m-d H:i:s A');
			if($this->common_model->update('slider_images',$slider_data,array('slider_images_id'=>$slider_id))){
				$this->session->unset_userdata('slider_file_check');
				$this->session->set_flashdata('msg_success','Slider image updated successfully');
				redirect('backend/slider/sliders');
			}else{
				$this->session->set_flashdata('msg_error','Sorry! Slider image updation process has been failed. Please try again');
				redirect('backend/slider/sliders');
			}
		}
		if(!$data['sliders'] = $this->common_model->get_row('slider_images',array('slider_images_id'=>$slider_id))){
			redirect('backend/slider/sliders');
		}
		$data['template'] ='backend/slider/slider_edit';
		$this->load->view('templates/superadmin_template',$data);
	}
	public function slider_delete($slider_id=''){
		$this->_check_login(); //check login authentication
		$data['title']='Delete'; 
		$data['img']=$this->superadmin_model->checkimg('slider_images',$slider_id);
		$filepath=$data['img']->slider_img;
		if(!empty($filepath)) @unlink($filepath);
		$filepath1=$data['img']->slider_img1;
		if(!empty($filepath1)) @unlink($filepath1);
		
		if($this->common_model->delete('slider_images',array('slider_images_id'=>$slider_id))){
		   $this->session->set_flashdata('msg_success','Slider image deleted successfully');
			redirect('backend/slider/sliders');
		}else{
			$this->session->set_flashdata('msg_error','Sorry! Deletion process has been failed. Please try again');
			redirect('backend/slider/sliders');
		}
	}

	public function overlay_image_delete($id=''){    

        $this->_check_login(); //check login authentication
        $data['title']='';
       
        if(empty($id)) redirect('backend/superadmin/error_404');
        
        $data1['img']=$this->superadmin_model->checkimg('slider_images',$id);
        $filepath=$data1['img']->slider_img1;
        //if(!empty($filepath)) unlink($filepath);
  
        $slider_img1 = array(
			'slider_img1'=>'',
			'position_from_top'=>0,
			'position_from_left'=>0,
			'overlay_description'=>''
		);
        if($this->common_model->update('slider_images',$slider_img1,array('slider_images_id'=>$id))){
				if(!empty($filepath)) unlink($filepath);
                $this->session->set_flashdata('msg_success','Slider overlay image deleted successfully');
                redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('msg_error','Sorry! Deletion process has been failed. Please try again');
            redirect($_SERVER['HTTP_REFERER']);
        }
    } 

 public function slider_file_check($str)
   {
   	$this->_check_login(); //check login authentication
   	$data['title']='';

   	  if(empty($_FILES['slider_file']['name'])){
            $this->form_validation->set_message('slider_file_check', 'Choose the main slider Image');
           return FALSE;
     }       
    if(!empty($_FILES['slider_file']['name'])):
    	$image = getimagesize($_FILES['slider_file']['tmp_name']);
          if($image[0]  != 1300 || $image[1] != 400 ) {
             $this->form_validation->set_message('slider_file_check', 'Oops! Your Slider image needs to be  1300 x 400 pixels');
             return FALSE;
         }

        $config['upload_path'] = './assets/uploads/backend/slider_img/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size']  = '5024';
        $config['max_width']  = '5024';
        $config['max_height']  = '5024';

        $this->load->library('upload', $config);
         $this->upload->initialize($config);
        if ( ! $this->upload->do_upload('slider_file')){
            $this->form_validation->set_message('slider_file_check', $this->upload->display_errors());
            return FALSE;
        }else{
            $data = $this->upload->data(); // upload image                    
            $this->session->set_userdata('slider_file_check',array('slider_file'=>$data['file_name']));
            return TRUE;
        }
    else:
        $this->form_validation->set_message('slider_file_check', 'The %s field required');
        return FALSE;
    endif;
   
   }

   public function slider_file1_check($str)
   {
   	$this->_check_login(); //check login authentication
   	$data['title']='';
   	  if(empty($_FILES['slider_file1']['name'])){
            $this->form_validation->set_message('slider_file1_check', 'Choose the overlay Image');
           return FALSE;
     }       
    if(!empty($_FILES['slider_file1']['name'])):
    	$image = getimagesize($_FILES['slider_file1']['tmp_name']);
          if(($image[0] < 100 || $image[0] > 300) || ($image[1] < 50 || $image[1] > 240)) {
             $this->form_validation->set_message('slider_file1_check', 'Oops! Your overlay image needs to be atleast 100 x 50 pixels. And at max 300 x 240 pixels');
             return FALSE;
         }

        $config['upload_path'] = './assets/uploads/backend/slider_img/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size']  = '5024';
        $config['max_width']  = '5024';
        $config['max_height']  = '5024';

        $this->load->library('upload', $config);
         $this->upload->initialize($config);
        if ( ! $this->upload->do_upload('slider_file1')){
            $this->form_validation->set_message('slider_file1_check', $this->upload->display_errors());
            return FALSE;
        }else{
            $data = $this->upload->data(); // upload image                    
            $this->session->set_userdata('slider_file1_check',array('slider_file1'=>$data['file_name']));
            return TRUE;
        }
    else:
        $this->form_validation->set_message('slider_file1_check', 'The %s field required');
        return FALSE;
    endif;
   
   }

    public function changesliderstatus($id="",$status="")	{
		$this->_check_login(); //check login authentication
		 $data['title']='';
		if($status==0) $status=1;
		else $status=0;
		$data=array('status'=>$status);
		if($this->common_model->update('slider_images',$data,array('slider_images_id'=>$id)))
		$this->session->set_flashdata('msg_success','Status Updated successfully');
		redirect($_SERVER['HTTP_REFERER']);
		}

	
	function do_upload($param=''){
		$this->_check_login(); //check login authentication
		$config['upload_path'] = './assets/uploads/backend/slider_img/';
		$config['allowed_types'] = 'jpeg|jpg|png';
		$config['max_size']	= '2048';
		$config['max_width']  = '2400';
		$config['max_height']  = '1600';
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload($param)){
			return array('status'=>FALSE,'error' => $this->upload->display_errors());
		}else{
			return  array('status'=>TRUE,'upload_data' => $this->upload->data());
		}
	}
	function thumb_create($filename=''){
		$this->_check_login(); //check login authentication
		$config['image_library'] = 'gd2';
		$config['source_image']	= './assets/uploads/backend/slider_img/'.$filename;
    	$config['new_image']	= './assets/uploads/backend/slider_img/';
		//$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width']	 = 100;
		$config['height']	= 100;
		$this->load->library('image_lib', $config);
		if ( ! $this->image_lib->resize()){
			echo $this->image_lib->display_errors();
			exit();
		}
	}
}