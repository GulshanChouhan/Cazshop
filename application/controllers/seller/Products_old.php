<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Products extends CI_Controller
{
  public function __construct(){
      parent::__construct();
      $this->load->model("seller_model");
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

  public function index($offset=0){

    $this->_check_login(); //check login authentication
    $this->_check_stepForm(); //check registration step authentication

    $data['title']='Products List';
    $search=array();
    if(!empty($_GET))
    {
      if(!empty($_GET['title']))
      $search[]=' pi.title like "%'.$_GET['title'].'%"';
      if(!empty($_GET['category_id']))
      $search[]=' pi.category_id like "%'.$_GET['category_id'].'%"';
      if(!empty($_GET['product_type']))
      $search[]=' pv.type_of_product = "'.$_GET['product_type'].'"';
      if(!empty($_GET['status']))
      $search[]=' pv.status = "'.$_GET['status'].'"';
    }

    $data['products'] = $this->seller_model->get_productresult($offset, PER_PAGE, $search);
    $config=backend_pagination();
    $config['base_url'] = base_url().'seller/products/index/';
    $config['total_rows'] = $this->seller_model->get_productresult(0, 0, $search);
    
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
    $data['template']='seller/products/index';
    $data['offset']=$offset;
    $this->load->view('templates/seller/template',$data);

  }
  public function mydraft($offset=0){

      $this->_check_login(); //check login authentication
      $this->_check_stepForm(); //check registration step authentication

      $data['title']='Draft Products';
      $search=array();

      if(!empty($_GET))
      {
        if(!empty($_GET['title']))
        $search[]=' pi.title like "%'.$_GET['title'].'%"';
        if(!empty($_GET['category_id']))
        $search[]=' pi.category_id like "%'.$_GET['category_id'].'%"';
        if(!empty($_GET['product_type']))
        $search[]=' pv.type_of_product = "'.$_GET['product_type'].'"';
        if(!empty($_GET['status']))
        $search[]=' pv.status = "'.$_GET['status'].'"';
      }

      $data['products'] = $this->seller_model->get_productresult_draft($offset, PER_PAGE, $search);
      $config=backend_pagination();
      $config['base_url'] = base_url().'seller/products/mydraft/';
      $config['total_rows'] = $this->seller_model->get_productresult_draft(0, 0, $search);
      
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
      $data['template']='seller/products/mydraft';
      $data['offset']=$offset;
      $this->load->view('templates/seller/template',$data);

  }

  public function product_category(){

    $this->_check_login(); //check login authentication
    $this->_check_stepForm(); //check registration step authentication

    $data['title']='Add Product Category';

    $data['main_category'] = $main_category = $this->common_model->getCategories('', 0);

    if(isset($_POST['selectProductCat'])){
      $productCat = implode(",", $_POST['productcategory']);
        $productCatData = array(
            'status' => 1,
            'product_cat_id' => $productCat
        );
      $this->session->set_userdata('productCategory', $productCatData);
      $this->session->set_flashdata('msg_success', 'Product Categories added successfully');
      redirect('seller/products/product_basic_info');
    }

    $data['seller_businessInfo'] = $seller_businessInfo = $this->common_model->get_row('business_info', array('seller_id'=>seller_id()), array('category'));
    $data['template'] ='seller/products/product_category';
    $this->load->view('templates/seller/template',$data);
  }



  public function edit_product_category($product_info_id='', $product_variation_id='', $type=''){

    $this->_check_login(); //check login authentication
    $this->_check_stepForm(); //check registration step authentication

    $data['title']='Edit Product Category';

    if(!empty($product_info_id)){
      $data['product_info'] = $product_info = $this->common_model->get_row('products_info', array('product_info_id' => $product_info_id, 'seller_id'=>seller_id()));
      if(empty($product_info))
        redirect('seller/products/index');
    }

    if(!empty($product_info_id) && !empty($product_variation_id)){
      $data['product_variationsData'] = $product_variations = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id, 'seller_id'=>seller_id()));
      if(empty($product_variations))
        redirect('seller/products/index');
    }


    $data['main_category'] = $main_category = $this->common_model->getCategories('', 0);
    $data['product_info_id'] = $product_info_id;
    if(isset($_POST['selectProductCat'])){
      $productCat        = implode(",",$_POST['productcategory']);
      $productCategories = rtrim($productCat,',');

      $updateData = [
        'category_id'  => $productCategories
      ];

      if ($this->common_model->update('products_info', $updateData, array('product_info_id' => $product_info_id))){ 
        $this->session->set_flashdata('msg_success', 'Product Categories updated successfully'); 
        redirect('seller/products/edit_product_basic_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type); 
      }else{
        $this->session->set_flashdata('msg_error', 'Something went wrong. please try again'); 
        redirect('seller/products/edit_product_category/'.$product_info_id.'/'.$product_variation_id.'/'.$type);
      } 
    }

    $data['seller_businessInfo'] = $seller_businessInfo = $this->common_model->get_row('business_info', array('seller_id'=>seller_id()), array('category'));
    $data['product_info_id'] = $product_info_id;
    $data['product_variation_id'] = $product_variation_id;
    $data['type'] = $type;
    $data['template'] ='seller/products/edit_product_category';
    $this->load->view('templates/seller/template',$data);
  }



  public function product_basic_info(){

    $this->_check_login(); //check login authentication
    $this->_check_stepForm(); //check registration step authentication

    $data['title']='Add Product Basic Info';

    $product_cat_id = $this->session->userdata('productCategory')['product_cat_id'];

    $SubCats = explode(",", $product_cat_id);
    $sessionSubCat1 = array_filter($SubCats);
    $sessionSubCat  = end($sessionSubCat1); 

    $data['attribute_info'] = $attribute_info = $this->common_model->get_result_using_findInSet('attributes', array('type' => 1, 'status' => 1),'','','',array($sessionSubCat,'category_id'),'attribute_code');
    $data['brand_info'] = $brand_info = $this->common_model->get_result_using_findInSet('brand', array('status'=> 1),'','','',array($sessionSubCat,'category_id'),'brand_name');

    $this->form_validation->set_rules('title', 'Product Title', 'required|trim'); 
    $this->form_validation->set_rules('manufacturer_part_number', 'Manufacturer Part Number', 'required|trim');
    $this->form_validation->set_rules('short_description', 'Short Description', 'required|trim');
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

    if ($this->form_validation->run() == TRUE){ 

      $insert = [
        'seller_id'               => seller_id(),
        'title'                   => $this->input->post('title'),
        'slug'                    => url_title(trim($this->input->post('title')), 'dash', true),
        'short_description'       => $this->input->post('short_description'),
        'manufacturer_part_number'=> $this->input->post('manufacturer_part_number'),
        'category_id'             => rtrim($product_cat_id,','),
        'brand_name'              => $this->input->post('brand_name'),
        'product_basic_info'      => json_encode($this->input->post('basic_info')),
        'accepted_returnpolicy'   => 2,
        'return_policydays'       => 0,
        'returnpolicy_description'=> '',
        'status'                  => 1,
        'created_at'              => date('Y-m-d H:i:s A'),
        'updated_at'              => date('Y-m-d H:i:s A')
      ];

      if ($id = $this->common_model->insert('products_info', $insert)){ 
        /* auto completed data added */
        $this->session->set_userdata('chooseProductType', $this->input->post('chooseProductType'));  
        $this->add_attribute_value($this->input->post('basic_info'));
        $this->session->set_flashdata('msg_success', 'Product Basic Information added successfully'); 

        if($this->input->post('chooseProductType')==1){
          redirect('seller/products/product_offer/'.$id.'/0/3');
        }else if($this->input->post('chooseProductType')==2){
          redirect('seller/products/product_variations/'.$id.'/0/3');
        }else{
          redirect('seller/products/product_offer/'.$id.'/0/3');
        }
      }else{
        $this->session->set_flashdata('msg_error', 'Something went wrong. please try again'); 
        redirect($_SERVER['HTTP_REFERER']);
      } 
    } 

    $data['template'] ='seller/products/product_basic_info';
    $this->load->view('templates/seller/template',$data);
  }


  public function add_attribute_value($add_attribute)
  {
    $key=array_keys($add_attribute);
    if(!empty($key)){
    $custom=' attribute_code in ("'.implode('","', $key).'") and file_type=10 ';
    if($data=$this->common_model->get_result('attributes','',array('attribute_value','attribute_id','attribute_code'),array(),'',$custom))
      {
        foreach($data as $row)
        {
          $temp_data=json_decode($row->attribute_value);
          if($add_attribute[$row->attribute_code]!='' && !in_array($add_attribute[$row->attribute_code],$temp_data))
          {
              $temp_data[sizeof($temp_data)]=$add_attribute[$row->attribute_code];
              $this->common_model->update('attributes',array('attribute_value'=>json_encode($temp_data)),array('attribute_id'=>$row->attribute_id));  
          }

        }
      }     
    }
  }


  public function edit_product_basic_info($product_info_id='', $product_variation_id='', $type=''){

    $this->_check_login(); //check login authentication
    $this->_check_stepForm(); //check registration step authentication

    $data['title']='Edit Product Basic Info';


    if(!empty($product_info_id)){
      $data['product_info'] = $product_info = $this->common_model->get_row('products_info', array('product_info_id' => $product_info_id, 'seller_id'=>seller_id()));
      if(empty($product_info))
        redirect('seller/products/index');
    }

    if(!empty($product_info_id) && !empty($product_variation_id)){
      $data['product_variationsData'] = $product_variations = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id, 'seller_id'=>seller_id()));
      if(empty($product_variations))
        redirect('seller/products/index');
    }


    $SubCats = explode(",", $product_info->category_id);
    $sessionSubCat1 = array_filter($SubCats);
    $sessionSubCat  = end($sessionSubCat1);

    $data['attribute_info'] = $attribute_info = $this->common_model->get_result_using_findInSet('attributes', array('type' => 1, 'status'=> 1),'','','',array($sessionSubCat,'category_id'),'attribute_code');
    $data['brand_info'] = $brand_info = $this->common_model->get_result_using_findInSet('brand', array('status'=> 1),'','','',array($sessionSubCat,'category_id'),'brand_name');

    $this->form_validation->set_rules('title', 'Product Title', 'required|trim'); 
    $this->form_validation->set_rules('short_description', 'Short Description', 'required|trim');
    $this->form_validation->set_rules('manufacturer_part_number', 'Manufacturer Part Number', 'required|trim');
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

    if ($this->form_validation->run() == TRUE){ 
       $insert = [
        'title'             => $this->input->post('title'),
        'slug'              => url_title(trim($this->input->post('title')), 'dash', true),
        'short_description' => $this->input->post('short_description'),
        'manufacturer_part_number' => $this->input->post('manufacturer_part_number'),
        'brand_name'        => $this->input->post('brand_name'),
        'product_basic_info'=> json_encode($this->input->post('basic_info')),
        'status'            => 1,
        'updated_at'        => date('Y-m-d H:i:s A')
      ];

      if ($this->common_model->update('products_info', $insert, array('product_info_id' => $product_info_id))){ 
        /* auto completed data added */  
        $this->add_attribute_value($this->input->post('basic_info'));
        $this->session->set_flashdata('msg_success', 'Product Basic Information updated successfully'); 
        if($type==1){
          redirect('seller/products/product_offer/'.$product_info_id.'/'.$product_variation_id.'/'.$type); 
        }else if($type==2){
          redirect('seller/products/product_variations/'.$product_info_id.'/'.$product_variation_id.'/'.$type);
        }else if($type==3){
          $this->session->set_userdata('chooseProductType', $this->input->post('chooseProductType'));
          if($this->input->post('chooseProductType')==1){
            redirect('seller/products/product_offer/'.$product_info_id.'/0/3');
          }else if($this->input->post('chooseProductType')==2){
            redirect('seller/products/product_variations/'.$product_info_id.'/0/3');
          }else{
            redirect('seller/products/product_offer/'.$product_info_id.'/0/3');
          }
        }

      }else{
        $this->session->set_flashdata('msg_error', 'Something went wrong. please try again'); 
        redirect($_SERVER['HTTP_REFERER']);
      } 
    } 

    $data['product_info_id'] = $product_info_id;
    $data['product_variation_id'] = $product_variation_id;
    $data['type'] = $type;
    $data['template'] ='seller/products/edit_product_basic_info';
    $this->load->view('templates/seller/template',$data);
  }


  public function product_variations($product_info_id='', $product_variation_id='', $type=''){
    $this->_check_login(); //check login authentication
    $category_id =  "";
    $data['title']='Product Variations';

    if(!empty($product_info_id)){
      $data['product_info'] = $product_info = $this->common_model->get_row('products_info', array('product_info_id' => $product_info_id, 'seller_id'=>seller_id()));
      if(empty($product_info))
        redirect('seller/products/index');
    }

    if(!empty($product_info->category_id)){
      $category_id = explode(",",$product_info->category_id);
      $category_id = end($category_id);
    }

    if(!empty($product_info_id) && !empty($product_variation_id)){
      $data['product_variationsData'] = $product_variations = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id, 'seller_id'=>seller_id()));
      if(empty($product_variations))
        redirect('seller/products/index');

      $data['product_variation_details'] = $product_variation_details = $this->common_model->get_result('product_variations', array('seller_id'=>seller_id(), 'product_info_id'=> $product_info_id, 'product_variation_id'=> $product_variation_id));
    }else{
      $data['product_variation_details'] = $product_variation_details = $this->common_model->get_result('product_variations', array('seller_id'=>seller_id(), 'product_info_id'=> $product_info_id));
    }


    $this->form_validation->set_rules('variation_theme', 'Variation Theme', 'required|trim'); 
    if ($this->form_validation->run() == TRUE){ 

      if(!empty($_POST) && !empty($_POST['seller_sku']) && !empty($_POST['product_id']) && !empty($_POST['product_id_type']) && !empty($_POST['base_price']) && !empty($_POST['sell_price']) && !empty($_POST['quantity'])){
        $seller_id = seller_id();
        if($this->common_model->delete('product_variations',array('product_info_id'=>$product_info_id))){
          $created_date = date('Y-m-d H:i:s A');
          $key=array_keys($_POST['product_variation_info']);
          
          for($i=0;$i<sizeof($_POST['seller_sku']);$i++)
          {
            $temp=array();
            for($j=0;$j<sizeof($key);$j++)
            {
               $temp[$key[$j]]              = $_POST['product_variation_info'][$key[$j]][$i];
            }

            $insertData['seller_id']             = $seller_id;
            $insertData['product_theme_id']      = $_POST['variation_theme'];
            $insertData['product_info_id']       = $product_info_id;
            $insertData['product_variation_info']= json_encode($temp);
            $insertData['seller_SKU']            = $_POST['seller_sku'][$i];
            $insertData['product_ID']            = $_POST['product_id'][$i];
            $insertData['product_ID_type']       = $_POST['product_id_type'][$i];
            $insertData['base_price']            = $_POST['base_price'][$i];
            $insertData['sell_price']            = $_POST['sell_price'][$i];
            $insertData['quantity']              = $_POST['quantity'][$i];
            $insertData['admin_approvel']        = 2;
            $insertData['type_of_product']       = 2;
            $insertData['commision_fee']         = getCommisionFeeUsingCat($category_id);
            $insertData['created_at']            = $created_date;

            $insertID[] = $this->common_model->insert('product_variations',$insertData);
          }

          if (!empty($insertID)){

            $key=array_keys($_POST['product_variation_info']);
            $product_basic_info = json_decode($product_info->product_basic_info);

            foreach ($key as $row => $val) {
              if (array_key_exists($val,$product_basic_info)){
                unset($product_basic_info->$val);
              }
            }

            $this->common_model->update('products_info', array('product_basic_info'=>json_encode($product_basic_info)), array('product_info_id' => $product_info_id));

            $this->session->set_flashdata('msg_success', 'Product Variation Information updated successfully');
            redirect('seller/products/product_other_info/'.$product_info_id.'/0/2'); 
          }else{
            $this->session->set_flashdata('msg_error', 'Something went wrong. please try again'); 
            redirect($_SERVER['HTTP_REFERER']);
          }
        }
      }else{
        $this->session->set_flashdata('msg_error', 'All field must be required'); 
        redirect($_SERVER['HTTP_REFERER']);
      } 
    }


    $data['variation_themes'] = $variation_themes = $this->common_model->get_result('variation_themes', array('status' => 1),"", array('product_theme_title','ASC'));
    $data['product_offer'] = $product_offer = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'type_of_product' => 1));

    $data['product_info_id'] = $product_info_id;
    $data['product_variation_id'] = $product_variation_id;
    $data['type'] = $type;
    $data['template'] ='seller/products/product_variations';
    $this->load->view('templates/seller/template',$data);
  }


  public function product_offer($product_info_id='', $product_variation_id='', $type=''){

    $this->_check_login(); //check login authentication
    $this->_check_stepForm(); //check registration step authentication

    $category_id = "";

    $data['title']='Product Offers';
    if(!empty($product_info_id)){
      $data['product_info'] = $product_info = $this->common_model->get_row('products_info', array('product_info_id' => $product_info_id, 'seller_id'=>seller_id()));
      if(empty($product_info)){
        redirect('seller/products/index');
      }
    }

    if(!empty($product_info->category_id)){
      $category_id = explode(",",$product_info->category_id);
      $category_id = end($category_id);
    }

    if(!empty($product_info_id) && !empty($product_variation_id)){
      $data['product_variationsData'] = $product_variations = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id, 'seller_id'=>seller_id()));
      if(empty($product_variations)){
        redirect('seller/products/index');
      }
    }
    $data['product_offerBasicInfo'] = $product_offerBasicInfo = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'type_of_product' => 1, 'seller_id'=>seller_id()));
   
    $data['product_offerOtherInfo'] = $product_offerOtherInfo = $this->common_model->get_row('product_offers', array('product_info_id' => $product_info_id,'product_variation_id' => $product_variation_id,'sale_end_date >='=>date('Y-m-d')));
  
    if(isset($_POST['submitInfo'])){
      /*----------Uniqueness of Seller ID and Product ID------*/
      $uniquesku =  '';
      $seller_SKUData = (isset($_POST['seller_SKU'])) ? $_POST['seller_SKU'] : "";
      if(!empty($product_offerBasicInfo)){
        if($seller_SKUData != $product_offerBasicInfo->seller_SKU){
           $uniquesku =  '|is_unique[product_variations.seller_SKU]';
        }
      }
      $uniqueProductID =  '';
      $seller_ProductID = (isset($_POST['product_ID'])) ? $_POST['product_ID'] : "";
      if(!empty($product_offerBasicInfo)){
        if($seller_ProductID != $product_offerBasicInfo->product_ID){
           $uniqueProductID =  '|is_unique[product_variations.product_ID]';
        }
      }
      /*----------Uniqueness of Seller ID and Product ID------*/
    $this->form_validation->set_rules('seller_SKU', 'seller SKU', 'min_length[5]|max_length[20]|required|trim'.$uniquesku);
    $this->form_validation->set_rules('product_ID', 'product ID', 'min_length[8]|max_length[15]|required|trim'.$uniqueProductID);
    $this->form_validation->set_rules('product_ID_type', 'product ID Type', 'required|trim');
    $this->form_validation->set_rules('base_price', 'Base Price', 'required|trim|callback_check_equal_less['.$this->input->post('sell_price').']'); 
    $this->form_validation->set_rules('sell_price', 'Sell Price', 'required|trim'); 
    $this->form_validation->set_rules('quantity', 'quantity', 'required|trim'); 
    $this->form_validation->set_rules('warranty_description', 'Warranty Description', 'required|trim'); 
    $this->form_validation->set_rules('seller_description', 'Seller Description', 'required|trim'); 
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
      if ($this->form_validation->run() == TRUE){ 
        $seller_id = seller_id();
        $insert = [
          'seller_id'             => $seller_id,
          'product_info_id'       => $product_info_id,
          'product_ID_type'       => $this->input->post('product_ID_type'),
          'base_price'            => $this->input->post('base_price'),
          'sell_price'            => $this->input->post('sell_price'),
          'quantity'              => $this->input->post('quantity'),
          'seller_description'    => $this->input->post('seller_description'),
          'warranty_description'  => $this->input->post('warranty_description')
        ];
        $insert1 =array();
        if($this->input->post('sale_price')!='' && $this->input->post('sale_start_date')!='' && $this->input->post('sale_end_date')!=''){
            $insert1 = [
              'product_info_id'                 => $product_info_id,
              'maximum_retail_price'            => $this->input->post('maximum_retail_price'),
              'sale_price'                      => $this->input->post('sale_price'),
              'sale_start_date'                 => date("Y-m-d", strtotime($this->input->post('sale_start_date'))),
              'sale_end_date'                   => date("Y-m-d", strtotime($this->input->post('sale_end_date'))),
              'can_be_gift_messaged'            => $this->input->post('can_be_gift_messaged'),
              'is_gift_wrap_available'          => $this->input->post('is_gift_wrap_available'),
              'fulfillment_channel'             => $this->input->post('fulfillment_channel')
            ];
        }
        
        if($product_variation_id=='' || $product_variation_id==0)
        {
           $insert['seller_SKU']         = $this->input->post('seller_SKU');
           $insert['product_ID']         = $this->input->post('product_ID');
           $insert['commision_fee']      = getCommisionFeeUsingCat($category_id);
           $insert['type_of_product']    = 1;
           $insert['admin_approvel']     = 2;
           $insert['created_at']         = date('Y-m-d H:i:s A');
           $product_variation_id = $this->common_model->insert('product_variations', $insert);
           $this->session->set_flashdata('msg_success', 'Product Offer added successfully'); 
        }else{
           $insert['product_variation_info']  = json_encode($_POST['product_variation_info']);
           $insert['updated_at']              = date('Y-m-d H:i:s A');
           $this->common_model->update('product_variations', $insert, array('product_info_id' => $product_info_id,'product_variation_id'=>$product_variation_id));
           $this->session->set_flashdata('msg_success', 'Product Offer Information updated successfully');
        }
       
        if(!empty($insert1)  && empty($data['product_offerOtherInfo']))
        {
            $insert1['product_variation_id'] = $product_variation_id;
            $this->common_model->insert('product_offers', $insert1);
            $this->session->set_flashdata('msg_success', 'Product Offer Information added successfully');
        }else if(!empty($insert1)  && !empty($data['product_offerOtherInfo'])){
           $resultOfOffer = $this->common_model->update('product_offers', $insert1, array('product_info_id' => $product_info_id,'product_offer_id'=>$data['product_offerOtherInfo']->product_offer_id));
           $this->session->set_flashdata('msg_success', 'Product Offer Information updated successfully');          
        } 
        //echo $product_variation_id; die;
        $redirectionResult = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id,'product_variation_id' => $product_variation_id)); 
        
        if(!empty($redirectionResult)){
          if($redirectionResult->type_of_product==1){
            redirect('seller/products/product_other_info/'.$product_info_id.'/'.$product_variation_id.'/1');
          }elseif ($redirectionResult->type_of_product==2) {
            redirect('seller/products/product_images/'.$product_info_id.'/'.$product_variation_id.'/2');
          }
        }else{
            redirect('seller/products/product_other_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type);
        }
    }
  }
    $data['product_info_id'] = $product_info_id;
    $data['product_variation_id'] = $product_variation_id;
    $data['type'] = $type;
    $data['template'] ='seller/products/product_offer';
    $this->load->view('templates/seller/template',$data);
  }


  public function product_other_info($product_info_id='', $product_variation_id='', $type=''){

    $this->_check_login(); //check login authentication
    $this->_check_stepForm(); //check registration step authentication

    $data['title']='Product Other Info';

    if(!empty($product_info_id)){
      $data['product_info'] = $product_info = $this->common_model->get_row('products_info', array('product_info_id' => $product_info_id, 'seller_id'=>seller_id()));
      if(empty($product_info))
        redirect('seller/products/index');
    }

    if(!empty($product_info_id) && !empty($product_variation_id)){
      $data['product_variationsData'] = $product_variations = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id, 'seller_id'=>seller_id()));
      if(empty($product_variations))
        redirect('seller/products/index');
    }

    $SubCats = explode(",", $product_info->category_id);
    $sessionSubCat1 = array_filter($SubCats);
    $sessionSubCat  = end($sessionSubCat1);

    $data['attribute_info'] = $attribute_info = $this->common_model->get_result_using_findInSet('attributes', array('type' => 2, 'status'=> 1),'','','',array($sessionSubCat,'category_id'),'attribute_code');

    if (isset($_POST['submitProductOtherInfo'])){ 
      $updateData = [
        'product_other_info'=> json_encode($this->input->post('other_info'))
      ];

      if ($id = $this->common_model->update('products_info', $updateData, array('product_info_id' => $product_info_id))){ 
        /* auto completed data added */  
        $this->add_attribute_value($this->input->post('other_info'));
        $this->session->set_flashdata('msg_success', 'Product Other Information Updated successfully');
        $redirectionResult = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id,'product_variation_id' => $product_variation_id)); 
        if($product_variation_id==0){
            redirect('seller/products/product_descriptions/'.$product_info_id.'/'.$product_variation_id.'/'.$type);
        }else{
            redirect('seller/products/product_images/'.$product_info_id.'/'.$product_variation_id.'/'.$type);
        }
      }else{
        $this->session->set_flashdata('msg_error', 'Something went wrong. please try again'); 
        redirect($_SERVER['HTTP_REFERER']);
      } 
    } 

    $data['product_info_id'] = $product_info_id;
    $data['product_variation_id'] = $product_variation_id;
    $data['type'] = $type;
    $data['template'] ='seller/products/product_other_info';
    $this->load->view('templates/seller/template',$data);
  }


  public function product_images($product_info_id='', $product_variation_id='', $type=''){

    $this->_check_login(); //check login authentication
    $this->_check_stepForm(); //check registration step authentication

    $data['title']='Product Images';

    if(!empty($product_info_id)){
      $data['product_info'] = $product_info = $this->common_model->get_row('products_info', array('product_info_id' => $product_info_id, 'seller_id'=>seller_id()));
      if(empty($product_info))
        redirect('seller/products/index');
    }

    if(!empty($product_info_id) && !empty($product_variation_id)){
      $data['product_variationsData'] = $product_variations = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id, 'seller_id'=>seller_id()));
      if(empty($product_variations))
        redirect('seller/products/index');
    }


    $data['product_images'] = $product_images = $this->common_model->get_result('product_images', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id));

    $this->form_validation->set_rules('image', 'Product Image', 'callback_productImg_check');
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

    if ($this->form_validation->run() == TRUE){
      if (!empty($this->session->userdata('productImg_check')['image'])) {

        $featuredImg = $this->common_model->get_row('product_images', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id, 'featured_image'=>1));

        $i=0;
        foreach ($this->session->userdata('productImg_check')['image'] as $key=> $value) {
          if(!empty($featuredImg)){
            $featured_image = 0;
          }else{
            if($i==0){
              $featured_image = 1;
            }else{
              $featured_image = 0;
            }
          }

          $insert = [
            'featured_image'          => $featured_image,
            'image'                   => $value,
            'product_info_id'         => $product_info_id,
            'product_variation_id'    => $product_variation_id,
            'created_at'              => date('Y-m-d H:i:s A')
          ];
          $insertID[] = $this->common_model->insert('product_images', $insert);
          $i++;
        }

        if (!empty($insertID)){ 
          $this->session->unset_userdata('productImg_check');
          $this->session->set_flashdata('msg_success', 'Product Images added successfully');
          if($type!=2){
            redirect('seller/products/product_images/'.$product_info_id.'/'.$product_variation_id.'/'.$type);
          }else{
            redirect($_SERVER['HTTP_REFERER']);
          }
          
        }else{
          $this->session->set_flashdata('msg_error', 'Something went wrong. please try again'); 
          redirect($_SERVER['HTTP_REFERER']);
        }
      }
    }


    $data['product_info_id'] = $product_info_id;
    $data['product_variation_id'] = $product_variation_id;
    $data['type'] = $type;
    $data['template'] ='seller/products/product_images';
    $this->load->view('templates/seller/template',$data);
  }


  public function product_descriptions($product_info_id='', $product_variation_id='', $type=''){

    $this->_check_login(); //check login authentication
    $this->_check_stepForm(); //check registration step authentication

    $data['title']='Product Description';

    if(!empty($product_info_id)){
      $data['product_info'] = $product_info = $this->common_model->get_row('products_info', array('product_info_id' => $product_info_id, 'seller_id'=>seller_id()));
      if(empty($product_info))
        redirect('seller/products/index');
    }

    if(!empty($product_info_id) && !empty($product_variation_id)){
      $data['product_variationsData'] = $product_variations = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id, 'seller_id'=>seller_id()));
      if(empty($product_variations))
        redirect('seller/products/index');
    }

    $this->form_validation->set_rules('description', 'Description', 'required|trim'); 
    $this->form_validation->set_rules('key_product_feature', 'Key Product Feature', 'trim');
    $this->form_validation->set_rules('legal_disclaimer', 'Legal Disclaimer', 'trim'); 
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

    if ($this->form_validation->run() == TRUE){ 
      ini_set('memory_limit', '-1'); 

      $accepted_returnpolicy    = 2;
      $return_policydays        = "";
      $returnpolicy_description = "";
      
      if($this->input->post('accepted_returnpolicy')==1){
        $accepted_returnpolicy    = $this->input->post('accepted_returnpolicy');
        $return_policydays        = $this->input->post('return_policydays');
        $returnpolicy_description = $this->input->post('returnpolicy_description');
      }

      $insert = [
        'description'             => $this->input->post('description'),
        'key_product_feature'     => $this->input->post('key_product_feature'),
        'legal_disclaimer'        => $this->input->post('legal_disclaimer'),
        'accepted_returnpolicy'   => $accepted_returnpolicy,
        'return_policydays'       => $return_policydays,
        'returnpolicy_description'=> $returnpolicy_description
      ];

      if ($id = $this->common_model->update('products_info', $insert, array('product_info_id' => $product_info_id))){ 
        $this->session->set_flashdata('msg_success', 'Product Description updated successfully'); 
        redirect('seller/products/product_keywords/'.$product_info_id.'/'.$product_variation_id.'/'.$type);
      }else{
        $this->session->set_flashdata('msg_error', 'Something went wrong. please try again'); 
        redirect($_SERVER['HTTP_REFERER']);
      }
    }

    $data['product_info_id'] = $product_info_id;
    $data['product_variation_id'] = $product_variation_id;
    $data['type'] = $type;
    $data['template'] ='seller/products/product_descriptions';
    $this->load->view('templates/seller/template',$data);
  }


  public function product_keywords($product_info_id='', $product_variation_id='', $type=''){

    $this->_check_login(); //check login authentication
    $this->_check_stepForm(); //check registration step authentication

    $data['title']='Product Keywords';

    if(!empty($product_info_id)){
      $data['product_info'] = $product_info = $this->common_model->get_row('products_info', array('product_info_id' => $product_info_id, 'seller_id'=>seller_id()));
      if(empty($product_info))
        redirect('seller/products/index');
    }

    if(!empty($product_info_id) && !empty($product_variation_id)){
      $data['product_variationsData'] = $product_variations = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id, 'seller_id'=>seller_id()));
      if(empty($product_variations))
        redirect('seller/products/index');
    }

    $this->form_validation->set_rules('keywords[]', 'Search Terms', 'trim|required'); 
    if ($this->form_validation->run() == TRUE){ 
      $keywords = explode(', ', $this->input->post('keywords'));
      $insert = [
        'keywords'          => json_encode($keywords),
       ];
      if ($id = $this->common_model->update('products_info', $insert, array('product_info_id' => $product_info_id))){ 
        $this->session->set_flashdata('msg_success', 'Product Keywords updated successfully');
        redirect('seller/products/product_seo/'.$product_info_id.'/'.$product_variation_id.'/'.$type);
      }else{
        $this->session->set_flashdata('msg_error', 'Something went wrong. please try again'); 
        redirect($_SERVER['HTTP_REFERER']);
      }
    }

    $data['product_info_id'] = $product_info_id;
    $data['product_variation_id'] = $product_variation_id;
    $data['type'] = $type;
    $data['template'] ='seller/products/product_keywords';
    $this->load->view('templates/seller/template',$data);
  }


  public function product_seo($product_info_id='', $product_variation_id='', $type=''){

    $this->_check_login(); //check login authentication
    $this->_check_stepForm(); //check registration step authentication

    $data['title']='Product SEO';

    if(!empty($product_info_id)){
      $data['product_info'] = $product_info = $this->common_model->get_row('products_info', array('product_info_id' => $product_info_id, 'seller_id'=>seller_id()));
      if(empty($product_info))
        redirect('seller/products/index');
    }

    if(!empty($product_info_id) && !empty($product_variation_id)){
      $data['product_variationsData'] = $product_variations = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id, 'seller_id'=>seller_id()));
      if(empty($product_variations))
        redirect('seller/products/index');
    }

    $data['product_img'] = $product_img = $this->common_model->get_row('product_images', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id));

    $data['product_seo_info'] = $product_seo_info = $this->common_model->get_row('product_seo', array('product_info_id' => $product_info_id));

    $this->form_validation->set_rules('meta_title', 'Meta Title', 'max_length[60]|required|trim'); 
    $this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'max_length[100]|required|trim');
    $this->form_validation->set_rules('meta_description', 'Meta Description', 'max_length[170]|required|trim'); 
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    
    if ($this->form_validation->run() == TRUE){ 
      ini_set('memory_limit', '-1'); 
      $insert = [
        'meta_title'             => $this->input->post('meta_title'),
        'meta_keywords'          => $this->input->post('meta_keywords'),
        'meta_description'       => $this->input->post('meta_description')
      ];

      if(empty($product_seo_info)){
        $insert['product_info_id']   = $product_info_id;
        $insert['created_at']        = date('Y-m-d H:i:s A');
        if ($id = $this->common_model->insert('product_seo', $insert)){ 
          $this->session->set_flashdata('msg_success', 'Product Meta Information added successfully');
          if(!empty($product_info) && !empty($product_variations) && !empty($product_img)){
              redirect('seller/products/index');
          }else{
              redirect('seller/products/mydraft');
          }
        }else{
          $this->session->set_flashdata('msg_error', 'Something went wrong. please try again'); 
          redirect($_SERVER['HTTP_REFERER']); 
        } 
      }else{
        if ($id = $this->common_model->update('product_seo', $insert, array('product_info_id' => $product_info_id))){ 
          $this->session->set_flashdata('msg_success', 'Product Meta Information updated successfully'); 
          if(!empty($product_info) && !empty($product_variations) && !empty($product_img)){
              redirect('seller/products/index');
          }else{
              redirect('seller/products/mydraft');
          } 
        }else{
          $this->session->set_flashdata('msg_error', 'Something went wrong. please try again'); 
          redirect($_SERVER['HTTP_REFERER']); 
        }
      }
    }

    $data['product_info_id'] = $product_info_id;
    $data['product_variation_id'] = $product_variation_id;
    $data['type'] = $type;
    $data['template'] ='seller/products/product_seo';
    $this->load->view('templates/seller/template',$data);
  }


  public function shipment_rate($product_info_id='', $product_variation_id=''){

    $this->_check_login(); //check login authentication
    $this->_check_stepForm(); //check registration step authentication

    $data['title']='Shipment rate of Product';

    if(!empty($product_info_id)){
      $data['product_info'] = $product_info = $this->common_model->get_row('products_info', array('product_info_id' => $product_info_id, 'seller_id'=>seller_id()));
      if(empty($product_info))
        redirect('seller/products/index');
    }

    if(!empty($product_info_id) && !empty($product_variation_id)){
      $data['product_variationsData'] = $product_variations = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id, 'seller_id'=>seller_id()));
      if(empty($product_variations))
        redirect('seller/products/index');
    }

    $data['product_img'] = $product_img = $this->common_model->get_row('product_images', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id));

    $data['shipmentrate_setting'] = $shipmentrate_setting = $this->common_model->get_row('shipmentrate_setting', array('seller_id' => seller_id(), 'type'=>0));

    $this->form_validation->set_rules('shipment_rate_type', 'Shipment rate checkbox', 'required|trim'); 
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

    if ($this->form_validation->run() == TRUE){ 
      $shipment_rate_type = $this->input->post('shipment_rate_type');
      //p($shipment_rate_type); die;
      $insert = [];

      if($shipment_rate_type==1){
        $this->common_model->delete('shipmentrate_setting',array('shipment_rate_id'=>$product_variations->shipment_rate_id, 'type'=>1));
        $insert = [
          'shipment_rate_type' => $shipment_rate_type
        ];
      }elseif ($shipment_rate_type==2){
        if(!empty($product_variations) && !empty($product_variations->shipment_rate_id) && $product_variations->shipment_rate_id!=0){
          redirect('seller/country_rates/product_based/'.$product_variations->product_variation_id.'/'.$product_variations->shipment_rate_id);
        }else{
          redirect('seller/country_rates/product_based/'.$product_variations->product_variation_id);
        }
        
      }elseif ($shipment_rate_type==3 && !empty($shipmentrate_setting)){
        $this->common_model->delete('shipmentrate_setting',array('shipment_rate_id'=>$product_variations->shipment_rate_id, 'type'=>1));
        $insert = [
          'shipment_rate_type' => $shipment_rate_type,
          'shipment_rate_id' => $shipmentrate_setting->shipment_rate_id
        ];
        
      }


      $resultUpdate = $this->common_model->update('product_variations', $insert, array('product_info_id' => $product_info_id));
      //echo $this->db->last_query(); die;
      if ($resultUpdate){ 
        $this->session->set_flashdata('msg_success', 'Product shipment rate Info updated successfully'); 
        if(!empty($product_info) && !empty($product_variations) && !empty($product_img)){
            redirect('seller/products/index');
        }else{
            redirect('seller/products/mydraft');
        } 
      }else{
        $this->session->set_flashdata('msg_error', 'Something went wrong. please try again'); 
        redirect($_SERVER['HTTP_REFERER']); 
      }

    }

    $data['product_info_id'] = $product_info_id;
    $data['product_variation_id'] = $product_variation_id;
    $data['template'] ='seller/products/shipment_rate';
    $this->load->view('templates/seller/template',$data);
  }


  public function changestatus($id="",$status="",$offset="",$table_name="") {

    $this->_check_login(); //check login authentication
    $this->_check_stepForm(); //check registration step authentication

    $data['title']='';

    if($status==0) 
      $status=1;
    else $status=0;
      $data=array('status'=>$status);
      if($this->superadmin_model->update($table_name,$data,array('id'=>$id)))
        $this->session->set_flashdata('msg_success','Status Updated successfully');
        redirect($_SERVER['HTTP_REFERER']);
  }

  public function delete_image($product_img_id='', $product_info_id='')
  {
      $this->_check_login(); //check  login authentication
      $this->_check_stepForm(); //check registration step authentication

      $data= $this->common_model->get_row('product_images',array('product_img_id'=>$product_img_id, 'product_info_id'=>$product_info_id));
      if(!$data) redirect('seller/products/index');

      if($this->common_model->delete('product_images',array('product_img_id'=>$product_img_id)))
      {
          @unlink('assets/uploads/seller/products/'.$data->image);
          @unlink('assets/uploads/seller/products/thumbnail/'.$data->image);
          @unlink('assets/uploads/seller/products/small_thumbnail/'.$data->image);
          $this->session->set_flashdata('msg_success', 'Product Image deleted successfully');
          redirect($_SERVER['HTTP_REFERER']);
      }
      else
      {
          $this->session->set_flashdata('msg_error', 'Something Went Wrong. Please try again');
          redirect($_SERVER['HTTP_REFERER']);
      }

  }


  public function delete_product($product_info_id='', $product_variation_id='')
  {
      $this->_check_login(); //check  login authentication
      $this->_check_stepForm(); //check registration step authentication

      $data= $this->common_model->get_row('products_info',array('product_info_id'=>$product_info_id));
      if(!$data) redirect('seller/products/index');

      if($this->common_model->delete('products_info',array('product_info_id'=>$product_info_id)))
      {
          $dataImg= $this->common_model->get_row('product_images',array('product_info_id'=>$product_info_id));
          foreach ($dataImg as $row) {
            @unlink('assets/uploads/seller/products/'.$row->image);
            @unlink('assets/uploads/seller/products/thumbnail/'.$row->image);
          }
          $this->common_model->delete('product_images',array('product_info_id'=>$product_info_id));
          $this->common_model->delete('product_seo',array('product_info_id'=>$product_info_id));
          $this->common_model->delete('product_variations',array('product_info_id'=>$product_info_id));

          $this->session->set_flashdata('msg_success', 'Product deleted successfully');
          redirect($_SERVER['HTTP_REFERER']);
      }
      else
      {
          $this->session->set_flashdata('msg_error', 'Something Went Wrong. Please try again');
          redirect($_SERVER['HTTP_REFERER']);
      }

  }


  /*---=================================Get Product Subcategory New One=======================================---*/

  public function getProductSubcategoryNew() {
      $category   = $this->input->post('category');
      $parent     = $this->input->post('mainnew');
      $mainnew    = $this->input->post('mainnew')+1;
      $optionData = "";
      $subcategoryExist = "";


      if(!$category) {
          echo json_encode(array('status' => 'failed', 'optionData' => $optionData));
          die();
      }else{
          $data = $this->common_model->getCategories($category, 1, $parent);
          if($data) {
              $optionData .= "<div class='choose-product-block flex-block'><div class='choose-product-block-inner'><div class='choose-product-tile'><ul class='choose-product-list' id='scrollbar-design'>";
              foreach ($data as $row) {
                  $dataCats = $this->common_model->get_row('category',array('parent_id'=>$row->category_id));
                  if(!empty($dataCats)) $subcategoryExist = "<i style='float: right;margin-top: 5px;font-size: 10px;' class='fa fa-arrow-right' aria-hidden='true'></i>";

                  $optionData .= "<li mainnew='".$mainnew."' catval='".$row->category_id."' class='choose-product-name getsubcatnew'>".ucfirst($row->category_name).$subcategoryExist."</li>";
              }
              $optionData .= "</ul></div></div><div class='arrow-shadow'></div></div>";
              echo json_encode(array('status' => 'success', 'optionData' => $optionData, 'level'=>$mainnew));
              die();
          } else {
              echo json_encode(array('status' => 'failed', 'optionData' => $optionData, 'level'=>$mainnew));
              die();
          }
      }
  }

  /*---==============================***Get Product Subcategory New One=======================================---*/

  public function getProductSubcategory() {
      $category = $this->input->post('category');
      $parent = $this->input->post('main');
      $main = $this->input->post('main')+1;
      $optionData = "";

      if (!$category) {
          echo json_encode(array('status' => 'failed', 'optionData' => $optionData));
          die();
      } else {
          $data = $this->common_model->getCategories($category, 1, $parent);
          if ($data) {
              $optionData .= "<div class='form-group'><select class='form-control productcategory subcategory".$main."' name='productcategory[]' onchange='getsubcat(this);' main='".$main."'>";
              $optionData .= "<option value=''>--Select Subcategory--</option>";
              foreach ($data as $row) {
                  $optionData .= "<option value='".$row->category_id."'>" . ucfirst($row->category_name) ."</option>";
              }
              $optionData .= "</select></div><div class='subcat".$main."'></div>";
              echo json_encode(array('status' => 'success', 'optionData' => $optionData));
              die();
          } else {
              echo json_encode(array('status' => 'failed', 'optionData' => $optionData));
              die();
          }
      }
  }

  public function getProductSubcategoryInEdit() {
      $category = $this->input->post('category');
      $SubCats = explode(",", $category);
      $optionData = "";

      if (!$category) {
          echo json_encode(array('status' => 'failed', 'optionData' => $optionData));
          die();
      } else {
          $indexing = 1;
          foreach ($SubCats as $key) {
              $selected = "";

              if($indexing==1){

                $data = $this->common_model->get_result('category', array('parent_id' => 0, 'status' => 1), '', array('category_name', 'asc'));
                if ($data) {
                    $optionData .= "<div class='col-md-12 form-group'><div class='col-md-offset-1 col-md-10'><select class='form-control productcategory' name='productcategory[]' onchange='getsubcat(this);'>";
                    $optionData .= "<option value=''>--Select Category--</option>";
                    foreach ($data as $row) {
                      if($row->category_id==$key){
                        $selected = "selected";
                      }

                        $optionData .= "<option value='".$row->category_id."' ".$selected.">" . ucfirst($row->category_name) ."</option>";
                    }
                    $optionData .= "</select></div></div>";
                }

              }else{

                $getSubcatdata = $this->common_model->get_row('category', array('category_id' => $key, 'status' => 1), array('parent_id'));
                if(!empty($getSubcatdata)){
                  $data = $this->common_model->get_result('category', array('parent_id' => $getSubcatdata->parent_id, 'status' => 1), '', array('category_name', 'asc'));
                  if ($data) {
                      $optionData .= "<div class='col-md-12 form-group'><div class='col-md-offset-1 col-md-10'><select class='form-control productcategory' name='productcategory[]' onchange='getsubcat(this);'>";
                      $optionData .= "<option value=''>--Select Subcategory--</option>";
                      foreach ($data as $row) {
                        if($row->category_id==$key){
                          $selected = "selected";
                        }
                          $optionData .= "<option value='".$row->category_id."' ".$selected.">" . ucfirst($row->category_name) ."</option>";
                      }
                      $optionData .= "</select></div></div>";
                  }
                }
              }

            $indexing++;
          }

          if(!$optionData){
            echo json_encode(array('status' => 'failed', 'optionData' => $optionData));
            die();
          }else{
            echo json_encode(array('status' => 'success', 'optionData' => $optionData));
            die();
          }
      }
  }


  public function getAttrDataUsingCategory() {
      $category   = $this->input->post('catID');

      $optionData = "";

      if (!$category) {
          echo json_encode(array('status' => 'failed', 'optionData' => $optionData));
          die();
      } else {

          $data = $this->common_model->get_result_using_findInSet('attributes', array('type' => 1, 'status'=> 1),'','','',array($category,'category_id'),'attribute_code');
          if(!$data){
            echo json_encode(array('status' => 'failed', 'optionData' => $optionData));
            die();
          }else{
            foreach ($data as $row) {
              $optionData .= "<input type='checkbox' name='attributes[]' value='".$row->attribute_code."'> ".ucfirst($row->name)."<br>";
            }
            echo json_encode(array('status' => 'success', 'optionData' => $optionData));
            die();
          }
      }
  }


  public function getVariationThemeVariation() {
      $variation_themeVal   = $this->input->post('variation_themeVal');
      $attributesData = "";

      if (!$variation_themeVal) {
          echo json_encode(array('status' => 'failed', 'attributesData' => $attributesData));
          die();
      } else {
          $data = $this->common_model->get_row('variation_themes', array('product_theme_id' => $variation_themeVal));
          if(!$data){
            echo json_encode(array('status' => 'failed', 'attributesData' => $attributesData));
            die();
          }else{
            if(json_decode($data->attributes)){
                  $attributesData=$this->common_model->get_attributes(json_decode($data->attributes)); 
              echo json_encode(array('status' => 'success', 'attributesData' => $attributesData));
              die();
            }else{
              echo json_encode(array('status' => 'failed', 'attributesData' => $attributesData));
              die();
            }
          }
      }
  }

  function check_equal_less($base_price,$sell_price) 
  { 
    if ($base_price > $sell_price) { 
      $this->form_validation->set_message('check_equal_less', 'The Sell price should be greater than Base price'); 
      return false; 
    }else{ 
      return true; 
    } 
  }

  public function productImg_check() {
    $name_array = array();
    if(isset($_FILES['image'])){
      $count = count($_FILES['image']['size']);
      if($count > 0){
        foreach($_FILES as $key=>$value){
          if(!empty($value)){
            for($s=0; $s<$count; $s++) {

              $_FILES['image']['name']=$value['name'][$s];
              $_FILES['image']['type']    = $value['type'][$s];
              $_FILES['image']['tmp_name'] = $value['tmp_name'][$s];
              $_FILES['image']['error']       = $value['error'][$s];
              $_FILES['image']['size']    = $value['size'][$s];   
              $config['upload_path'] = 'assets/uploads/seller/products/'; 
              $config['allowed_types'] = 'jpg|png|jpeg|gif'; 
              $config['max_size'] = '5024'; 
              $config['max_width'] = '10000'; 
              $config['max_height'] = '10000';
              $config['min_width'] = '500'; 
              $config['min_height'] = '500'; 
              $this->load->library('upload', $config); 
              $this->upload->initialize($config); 
              if (!$this->upload->do_upload('image')){ 
                $this->form_validation->set_message('productImg_check', $this->upload->display_errors()); 
                return FALSE; 
              }else{ 
                $data = $this->upload->data(); // upload image
                $config_img_p['source_path'] = './assets/uploads/seller/products/';
                $config_img_p['destination_path'] = './assets/uploads/seller/products/thumbnail/';
                $config_img_p['width']  = '500';
                $config_img_p['height']  = '500';
                $config_img_p['file_name'] =$data['file_name'];
                $status=create_thumbnail($config_img_p);
                $config_img_pc['source_path'] = './assets/uploads/seller/products/';
                $config_img_pc['destination_path'] = './assets/uploads/seller/products/small_thumbnail/';
                $config_img_pc['width']  = '290';
                $config_img_pc['height']  = '360';
                $config_img_pc['file_name'] =$data['file_name'];
                $status=create_thumbnail($config_img_pc);
                $name_array[] = $data['file_name'];
              }
            }
          }
        }
        if($name_array){
          $this->session->set_userdata('productImg_check', array('image' => $name_array)); 
          return TRUE;
        }
      }else{
        $this->form_validation->set_message('productImg_check', 'Please select an image to upload'); 
        return FALSE; 
      }
    }else{

      $product_info_id = $this->uri->segment(4);
      $product_variation_id = $this->uri->segment(5);
      $product_img_id = $_POST['pfi'];

      if(isset($_POST['pfi']) && !empty($_POST['pfi']) && $_POST['pfi']!='0'){
        $reg = $this->common_model->update('product_images', array('featured_image'=>0), array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id));
        if($reg){
          $result1 = $this->common_model->update('product_images', array('featured_image'=>1), array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id, 'product_img_id' => $product_img_id));
          if($result1){
            $this->session->set_flashdata('msg_success', 'Your product featured image changed successfully');
            redirect($_SERVER['HTTP_REFERER']); 
          }else{
            $this->session->set_flashdata('msg_error', 'Featured image not changed. please try again');
            redirect($_SERVER['HTTP_REFERER']); 
          }
        }else{
          $this->session->set_flashdata('msg_error', 'Featured image not changed. please try again');
          redirect($_SERVER['HTTP_REFERER']); 
        }
      }else{
        $this->session->set_flashdata('msg_warning', 'This image is already your product featured image');
        redirect($_SERVER['HTTP_REFERER']);
      }
    }
  }

  public function checkSellerSKU() {
    $sku = $_POST['sku'];
    $data = $this->common_model->get_row('product_variations', array('seller_SKU' => $sku));
    if(!$data){
      echo json_encode(array('status' => 'success'));
      die();
    }else{
      echo json_encode(array('status' => 'failed'));
      die();
    }

  }


  public function checkProductID() {
    $product_id = $_POST['product_id'];
    $data = $this->common_model->get_row('product_variations', array('product_ID' => $product_id));
    if(!$data){
      echo json_encode(array('status' => 'success'));
      die();
    }else{
      echo json_encode(array('status' => 'failed'));
      die();
    }

  }

  public function getVariationProducts(){
    $resultdata = "";
    $product_info_id = $_POST['product_info_id'];
    $statusProduct = $_POST['statusProduct'];
    $s_no = $_POST['s_no'];
    $pageType = $_POST['pageType'];

    if(empty($product_info_id)){
      echo json_encode(array('status' => 'failed', 'data' => $resultdata));
      die();
    }else{
      $data = $this->seller_model->getVariationProducts($product_info_id, $statusProduct);
      if($data){
        $resultdata .= "<tr class='childVariationProducts'><td colspan='9'><table class='table-bordered responsive table table-striped table-hover'>";
        $i=0;
        foreach ($data as $row) {
          $i++;

          /*For Showing Image*/
          $image = getFeaturedImage($row->product_info_id, $row->product_variation_id);
          if(!empty($image) && file_exists("assets/uploads/seller/products/thumbnail/".$image)){
            $img = '<a href="'.base_url().'seller/products/product_images/'.$row->product_info_id.'/'.$row->product_variation_id.'/2"><div class="img-size-box"><img src="'.base_url('assets/uploads/seller/products/thumbnail/'.$image).'"></div></a>';
          }else{
            $img = '<a href="'.base_url().'seller/products/product_images/'.$row->product_info_id.'/'.$row->product_variation_id.'/2"><div class="img-size-box"><img src="'.base_url('assets/backend/image/product_default_image.png').'"></div></a>';
          }

          /*Showing Column according to condition*/
          $sellerSKU = ($row->seller_SKU) ? $row->seller_SKU : "-";
          $sellerbase_price     = ($row->base_price) ? number_format($row->base_price,2) : "0.00";
          $sellersell_price     = ($row->sell_price) ? number_format($row->sell_price,2) : "0.00";
          $sellerquantity       = ($row->quantity) ? $row->quantity : "0";
          $statusVal            = ($row->status==2) ? "1" : "2";
          $statusCls            = ($row->status==2) ? "danger" : "success";
          $statustooltipMsg     = ($row->status==2) ? "Active" : "Deactive";
          $statusMsg            = ($row->status==2) ? '<i class="fa fa-times" aria-hidden="true"></i>' : '<i class="fa fa-check" aria-hidden="true"></i>';
          $statustooltipFullMsg = ($row->status==2) ? "Do you want to enable this product for selling ?" : "Do you want to disable this product for selling ?";

          /*Showing Commision fee*/
          if(!empty($row->commision_fee) && !empty($row->sell_price)){
            $fee        = $row->commision_fee * $row->sell_price/100;
            $feePreview = '$'.number_format($fee, 2);
          }else{
            $feePreview = "-";
          }            
          /*For showing variation info*/ 
          $tempMore = ""; 
          $product_variation_info = $row->product_variation_info;
          if(!empty($product_variation_info) && $product_variation_info!=''){
            $tempMore = "";
            $product_variation_info = json_decode($product_variation_info);
            if(!empty($product_variation_info)){
               foreach ($product_variation_info as $key => $value) {
                  $tempMore .= "<span>".ucfirst($key).": &nbsp;".ucfirst($value)."</span><br>";
               }
            }
          }
          /*Admin Approvel condition*/
          if($row->admin_approvel==1){ 
            $adminApprovel = "<b style='color:green'>Approved by Admin</b><br>"; 
          }else{ 
            $adminApprovel = "<b style='color:#f45b69'>Not Approved by Admin</b><br>";  
          }
          /*Check which page we are executed for editing quantity, base and sell price*/
          if($pageType=='inventoryReport'){ 
            $pageAccess = '<td class="sellprice1 font-roboto">$ '.$sellersell_price.'</td><td class="bestprice1 font-roboto">$ '.$sellerbase_price.'</td><td class="quntity-no1">'.$row->quantity.'</td>';  
          }else if($pageType=='managePricing'){ 

            $pageAccess = '<td class="sellprice1 font-roboto">$ <input class="form-control input-update-form" type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="3" min="0" max="99999" id="sellprice'.$row->product_variation_id.'" name="sellprice" placeholder="15.00" disabled="disabled" class="quantityNo" value="'.$sellersell_price.'"><a href="javascript:void(0)" class="tooltips updateSellPrice" attrId="'.$row->product_variation_id.'" rel="tooltip" data-placement="top" data-original-title="Click to Edit Sell Price">&nbsp;<i class="fa fa-pencil" aria-hidden="true" id="iconSellPrice'.$row->product_variation_id.'"></i></a></td><td class="bestprice1 font-roboto">$ <input class="form-control input-update-form" type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="3" min="0" max="99999" id="base_price'.$row->product_variation_id.'" name="base_price" placeholder="10.00" disabled="disabled" class="quantityNo" value="'.$sellerbase_price.'"><a href="javascript:void(0)" class="tooltips updateBasePrice" attrId="'.$row->product_variation_id.'" rel="tooltip" data-placement="top" data-original-title="Click to Edit Base Price">&nbsp;<i class="fa fa-pencil" aria-hidden="true" id="iconBasePrice'.$row->product_variation_id.'"></i></a></td><td class="quntity-no1">'.$row->quantity.'</td>';  

          }else{ 
            $pageAccess = '<td class="sellprice1 font-roboto">'.$sellersell_price.'</td><td class="bestprice1 font-roboto">'.$sellerbase_price.'</td><td class="quntity-no1"><input class="form-control input-update-form" type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="3" min="0" max="999" id="quantity'.$row->product_variation_id.'" name="quantity" placeholder="01" disabled="disabled" class="quantityNo" value="'.$row->quantity.'"><a href="javascript:void(0)" class="tooltips updateQuantity" attrId="'.$row->product_variation_id.'" rel="tooltip" data-placement="top" data-original-title="Click to Edit Quantity">&nbsp;<i class="fa fa-pencil" aria-hidden="true" id="iconQuan'.$row->product_variation_id.'"></i></a></td>';  
          }
          $tempMore.= $adminApprovel.'<b>Created Date - </b><i class="fa fa-calendar-o" aria-hidden="true"></i> '.date('d M Y',strtotime($row->created_at));
          $resultdata .= '<tr class="child_'.$row->product_info_id.'"><td class="checkbox-status1">'.$s_no.'.'.$i.'</td><td class="productimg1">'.$img.'</td><td class="producttitle1">'.ucwords($row->title).' <b>('.$row->product_ID')</b><br>'.$tempMore.'</td><td class="sku-no1">'.$sellerSKU.'</td>'.$pageAccess.'<td class="freeprive1 font-roboto">'.$feePreview.'</td><td class="action1"><a onClick=\'javascript: return confirm("Are you sure want to change the status ?");\' href="'.base_url().'backend/common/change_status/product_variations/product_variation_id/'.$row->product_variation_id.'/'.$statusVal.'" class="btn btn-'.$statusCls.' btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Click to '.$statustooltipMsg.'">'.$statusMsg.'</a>&nbsp;<a href="'.base_url().'seller/products/product_faq/'.$row->product_variation_id.'" class="btn btn-warning btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="List of product FAQs"><i class="fa fa-question"></i></a>&nbsp;<a href="'.base_url().'seller/products/product_offer/'.$row->product_info_id.'/'.$row->product_variation_id.'/2" class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" Edit Product" target="_blank"><i class="icon-pencil"></i></a>&nbsp;<a href="'.base_url().'seller/products/delete_product/'.$row->product_info_id.'/'.$row->product_variation_id.'" onClick=\'javascript: return confirm("Are you sure want to delete ?");\' class="btn btn-danger btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Delete Product"><i class="icon-trash "></i></a></td></tr>';

        }
        $resultdata .= "</tr></td></table>";
        echo json_encode(array('status' => 'success', 'data' => $resultdata));
        die();
      }else{
        echo json_encode(array('status' => 'failed', 'data' => $resultdata));
        die();
      }
    }
  }

  /*---================================Product FAQs====================================---*/

  public function product_faq($product_variation_id='', $offset=0){
    
    $this->_check_login(); //check login authentication
    $this->_check_stepForm(); //check registration step authentication

    $data['title']='Products FAQs';

    $data['product_variationsData'] = $product_variations = $this->common_model->get_row('product_variations', array('product_variation_id' => $product_variation_id, 'seller_id'=>seller_id()));
      if(empty($product_variations))
        redirect('seller/products/index');
    
    $search=array();
    if(!empty($_GET))
    {
      if(!empty($_GET['question']))
      $search[]=' pf.question like "%'.$_GET['question'].'%"';
      if(!empty($_GET['answer']))
      $search[]=' pf.answer like "%'.$_GET['answer'].'%"';
    }

    $data['product_FAQs'] = $this->seller_model->get_productFAQs($product_variation_id, $offset, PER_PAGE, $search);
    $config=backend_pagination();
    $config['base_url'] = base_url().'seller/products/product_faq/'.$product_variation_id;
    $config['total_rows'] = $this->seller_model->get_productFAQs($product_variation_id, 0, 0, $search);
    
    $config['per_page'] = PER_PAGE;
    $config['uri_segment'] = 5;
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
    $data['offset']=$offset;

    $data['product_variation_id'] = $product_variation_id;
    $data['template']='seller/products/FAQs/index';
    $this->load->view('templates/seller/template',$data);

  }

  public function add_product_FAQs($product_variation_id=''){

    $this->_check_login(); //check login authentication
    $this->_check_stepForm(); //check registration step authentication

    $data['title']='Add Product FAQs';

    $data['product_variationsData'] = $product_variations = $this->common_model->get_row('product_variations', array('product_variation_id' => $product_variation_id, 'seller_id'=>seller_id()));
      if(empty($product_variations))
        redirect('seller/products/index');

    $this->form_validation->set_rules('question', 'Question', 'required|trim'); 
    $this->form_validation->set_rules('answer', 'Answer', 'required|trim'); 
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    
    if ($this->form_validation->run() == TRUE){ 
      $insert = [
        'product_variation_id'   => $product_variation_id,
        'seller_id'              => seller_id(),
        'question'               => $this->input->post('question'),
        'answer'                 => $this->input->post('answer'),
        'status'                 => 1,
        'created_at'             => date('Y-m-d H:i:s A')
      ];

      if ($id = $this->common_model->insert('product_faq', $insert)){ 
        $this->session->set_flashdata('msg_success', 'Product FAQs Info added successfully');
        redirect('seller/products/product_faq/'.$product_variation_id);
      }else{
        $this->session->set_flashdata('msg_error', 'Something went wrong. please try again'); 
        redirect($_SERVER['HTTP_REFERER']); 
      }
    }

    $data['product_variation_id'] = $product_variation_id;
    $data['template']='seller/products/FAQs/add_product_FAQs';
    $this->load->view('templates/seller/template',$data);
  }


  public function edit_product_FAQs($product_variation_id='', $product_faq_id=''){

    $this->_check_login(); //check login authentication
    $this->_check_stepForm(); //check registration step authentication

    $data['title']='Edit Product FAQs';

    $data['product_faq'] = $product_variations = $this->common_model->get_row('product_faq', array('product_variation_id' => $product_variation_id, 'product_faq_id' => $product_faq_id, 'seller_id'=>seller_id()));
      if(empty($product_variations))
        redirect('seller/products/index');

    $this->form_validation->set_rules('question', 'Question', 'required|trim'); 
    $this->form_validation->set_rules('answer', 'Answer', 'required|trim'); 
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    
    if ($this->form_validation->run() == TRUE){ 
      $insert = [
        'question'               => $this->input->post('question'),
        'answer'                 => $this->input->post('answer')
      ];

      if ($id = $this->common_model->update('product_faq', $insert, array('product_faq_id' => $product_faq_id))){ 
        $this->session->set_flashdata('msg_success', 'Product FAQs Info updated successfully');
        redirect('seller/products/product_faq/'.$product_variation_id);
      }else{
        $this->session->set_flashdata('msg_error', 'Something went wrong. please try again'); 
        redirect($_SERVER['HTTP_REFERER']); 
      }
    }

    $data['product_variation_id'] = $product_variation_id;
    $data['template']='seller/products/FAQs/edit_product_FAQs';
    $this->load->view('templates/seller/template',$data);
  }

  /*---=============================**** End Product FAQs===============================---*/
  public function managePricing($offset=0){
    $this->_check_login(); //check login authentication
    $this->_check_stepForm(); //check registration step authentication     
    $search=array();
    if(!empty($_GET))
    {
     if(!empty($_GET['title']))
     $search[]=' pi.title like "%'.$_GET['title'].'%"';
     if(!empty($_GET['category_id']))
     $search[]=' pi.category_id like "%'.$_GET['category_id'].'%"';
     if(!empty($_GET['product_type']))
     $search[]=' pv.type_of_product = "'.$_GET['product_type'].'"';
     if(!empty($_GET['status']))
     $search[]=' pv.status = "'.$_GET['status'].'"';
    }
    $data['products'] = $this->seller_model->get_productresult($offset, PER_PAGE, $search);
    $config=backend_pagination();
    $config['base_url'] = base_url().'seller/orders/inventory_report';
    $config['total_rows'] = $this->seller_model->get_productresult(0, 0, $search);    
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
    $data['template']='seller/products/managepricing';
    $data['offset']=$offset;
    $this->load->view('templates/seller/template',$data);
  }

}   