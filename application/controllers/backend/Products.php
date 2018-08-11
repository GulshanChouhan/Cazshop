<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Products extends CI_Controller
{
  public function __construct(){
      parent::__construct();
      $this->load->model("seller_model");
  }
  private function _check_login(){
    if(superadmin_logged_in()===FALSE)
      redirect('behindthescreen');
  }
  public function index($offset=0){
    $this->_check_login(); //check login authentication

    $data['title']='Inventory Products';
    $search=array();

    if(!empty($_GET))
    {
      if(!empty($_GET['title']))
      $search[]=' pi.title like "%'.trim($_GET['title']).'%"';
      if(!empty($_GET['category_id']))
      $search[]=' FIND_IN_SET('.trim($_GET['category_id']).',pi.category_id)';
      if(!empty($_GET['product_type']))
      $search[]=' pv.type_of_product = "'.trim($_GET['product_type']).'"';
      if(!empty($_GET['seller_id']))
      $search[]=' pv.seller_id = "'.trim($_GET['seller_id']).'"';
      if(!empty($_GET['status']))
      $search[]=' pv.admin_approvel = "'.trim($_GET['status']).'"';
    }

    $data['products'] = $this->common_model->get_productresult($offset, PER_PAGE, $search);
    $config=backend_pagination(); 
    $config['base_url'] = base_url().'backend/products/index/';
    $config['total_rows'] = $this->common_model->get_productresult(0, 0, $search);
    
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
    $data['template']='backend/products/index';
    $data['offset']=$offset;
    $this->load->view('templates/superadmin_template',$data);

  }

  public function product_category(){
    $this->_check_login(); //check login authentication
    $data['title']='Product Category';

    $data['main_category'] = $main_category = $this->common_model->get_result('category', array('parent_id' => 0, 'status' => 1), '', array('category_name', 'asc'));

    if(isset($_POST['selectProductCat'])){
      $productCat = implode(",",$_POST['productcategory']);
        $productCatData = array(
            'status' => 1,
            'product_cat_id' => $productCat
        );
      $this->session->set_userdata('productCategory', $productCatData);
      redirect('backend/products/product_basic_info');
    }
    $data['template'] ='backend/products/product_category';
    $this->load->view('templates/superadmin_template',$data);
  }



  public function edit_product_category($product_info_id='', $product_variation_id='', $type=''){
    $this->_check_login(); //check login authentication
    $data['title']='Product Category';

    if(!empty($product_info_id)){
      $data['product_info'] = $product_info = $this->common_model->get_row('products_info', array('product_info_id' => $product_info_id));
      if(empty($product_info))
        redirect('backend/products/index');
    }

    if(!empty($product_info_id) && !empty($product_variation_id)){
      $data['product_variationsData'] = $product_variations = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id));
      if(empty($product_variations))
        redirect('backend/products/index');
    }


    $data['main_category'] = $main_category = $this->common_model->get_result('category', array('parent_id' => 0, 'status' => 1), '', array('category_name', 'asc'));
    $data['product_info_id'] = $product_info_id;
    if(isset($_POST['selectProductCat'])){
      $productCat        = implode(",",$_POST['productcategory']);
      $productCategories = rtrim($productCat,',');

      $updateData = [
        'category_id'  => $productCategories
      ];

      if ($this->common_model->update('products_info', $updateData, array('product_info_id' => $product_info_id))){ 
        $this->session->set_flashdata('msg_success', 'Product categories information updated successfully'); 
        redirect('backend/products/edit_product_basic_info/'.$product_info_id.'/'.$product_variation_id); 
      }else{
        $this->session->set_flashdata('msg_error', 'Something went wrong! Please try again'); 
        redirect('backend/products/edit_product_category/'.$product_info_id.'/'.$product_variation_id);
      } 
    }

    $data['product_info_id'] = $product_info_id;
    $data['product_variation_id'] = $product_variation_id;
    $data['type'] = $type;
    $data['template'] ='backend/products/edit_product_category';
    $this->load->view('templates/superadmin_template',$data);
  }



  public function product_basic_info(){
    $this->_check_login(); //check login authentication
    $data['title']='Product Vital Info';

    $product_cat_id = $this->session->userdata('productCategory')['product_cat_id'];

    $SubCats = explode(",", $product_cat_id);
    $sessionSubCat1 = array_filter($SubCats);
    $sessionSubCat  = end($sessionSubCat1); 

    $data['attribute_info'] = $attribute_info = $this->common_model->get_result_using_findInSet('attributes', array('type' => 1, 'status' => 1),'','','',array($sessionSubCat,'category_id'),'attribute_code');
    $data['brand_info'] = $brand_info = $this->common_model->get_result_using_findInSet('brand', array('status'=> 1),'','','',array($sessionSubCat,'category_id'),'brand_name');

    $this->form_validation->set_rules('title', 'Product Title', 'required|trim'); 
    $this->form_validation->set_rules('manufacturer_part_number', 'Manufacturer Part Number', 'required|trim');
    $this->form_validation->set_rules('short_description', 'Short Description', 'required|trim');
    $this->form_validation->set_rules('status', 'Status', 'required|trim'); 
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

    if ($this->form_validation->run() == TRUE){ 

      $insert = [
        'title'             => $this->input->post('title'),
        'slug'              => url_title(trim($this->input->post('title')), 'dash', true),
        'short_description' => $this->input->post('short_description'),
        'manufacturer_part_number' => $this->input->post('manufacturer_part_number'),
        'category_id'       => rtrim($product_cat_id,','),
        'brand_name'        => $this->input->post('brand_name'),
        'product_basic_info'=> json_encode($this->input->post('basic_info')),
        'status'            => $this->input->post('status'),
        'created_at'        => date('Y-m-d H:i:s A'),
        'updated_at'        => date('Y-m-d H:i:s A')
      ];

      if ($id = $this->common_model->insert('products_info', $insert)){ 
        /* auto completed data added */  
        $this->add_attribute_value($this->input->post('basic_info'));
        $this->session->set_flashdata('msg_success', 'Product basic information added successfully'); 
        redirect('backend/products/product_variations/'.$id.'/0/3'); 
      }else{
        $this->session->set_flashdata('msg_error', 'Something went wrong! Please try again'); 
        redirect($_SERVER['HTTP_REFERER']);
      } 
    } 

    $data['template'] ='backend/products/product_basic_info';
    $this->load->view('templates/superadmin_template',$data);
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
    $data['title']='Product Vital Info';


    if(!empty($product_info_id)){
      $data['product_info'] = $product_info = $this->common_model->get_row('products_info', array('product_info_id' => $product_info_id));
      if(empty($product_info))
        redirect('backend/products/index');
    }

    if(!empty($product_info_id) && !empty($product_variation_id)){
      $data['product_variationsData'] = $product_variations = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id));
      if(empty($product_variations))
        redirect('backend/products/index');
    }


    $SubCats = explode(",", $product_info->category_id);
    $sessionSubCat1 = array_filter($SubCats);
    $sessionSubCat  = end($sessionSubCat1);

    $data['attribute_info'] = $attribute_info = $this->common_model->get_result_using_findInSet('attributes', array('type' => 1, 'status'=> 1),'','','',array($sessionSubCat,'category_id'),'attribute_code');
    $data['brand_info'] = $brand_info = $this->common_model->get_result_using_findInSet('brand', array('status'=> 1),'','','',array($sessionSubCat,'category_id'),'brand_name');

    $this->form_validation->set_rules('title', 'Product Title', 'required|trim'); 
    $this->form_validation->set_rules('short_description', 'Short Description', 'required|trim');
    $this->form_validation->set_rules('manufacturer_part_number', 'Manufacturer Part Number', 'required|trim');
    $this->form_validation->set_rules('status', 'Status', 'required|trim'); 
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

    if ($this->form_validation->run() == TRUE){ 
       $insert = [
        'title'             => $this->input->post('title'),
        'slug'              => url_title(trim($this->input->post('title')), 'dash', true),
        'short_description' => $this->input->post('short_description'),
        'manufacturer_part_number' => $this->input->post('manufacturer_part_number'),
        'brand_name'        => $this->input->post('brand_name'),
        'product_basic_info'=> json_encode($this->input->post('basic_info')),
        'status'            => $this->input->post('status'),
        'updated_at'        => date('Y-m-d H:i:s A')
      ];

      if ($this->common_model->update('products_info', $insert, array('product_info_id' => $product_info_id))){ 
         /* auto completed data added */  
          $this->add_attribute_value($this->input->post('basic_info'));

        $this->session->set_flashdata('msg_success', 'Product basic information updated successfully'); 
        redirect('backend/products/product_variations/'.$product_info_id.'/'.$product_variation_id.'/'.$type); 
      }else{
        $this->session->set_flashdata('msg_error', 'Something went wrong! Please try again'); 
        redirect($_SERVER['HTTP_REFERER']);
      } 
    } 

    $data['product_info_id'] = $product_info_id;
    $data['product_variation_id'] = $product_variation_id;
    $data['type'] = $type;
    $data['template'] ='backend/products/edit_product_basic_info';
    $this->load->view('templates/superadmin_template',$data);
  }


  public function product_variations($product_info_id='', $product_variation_id='', $type=''){
    $this->_check_login(); //check login authentication
    $data['title']='Product Variations';

    if(!empty($product_info_id)){
      $data['product_info'] = $product_info = $this->common_model->get_row('products_info', array('product_info_id' => $product_info_id));
      if(empty($product_info))
        redirect('backend/products/index');
    }

    if(!empty($product_info_id) && !empty($product_variation_id)){
      $data['product_variationsData'] = $product_variations = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id));
      if(empty($product_variations))
        redirect('backend/products/index');

      $data['product_variation_details'] = $product_variation_details = $this->common_model->get_result('product_variations', array('product_info_id'=> $product_info_id, 'product_variation_id'=> $product_variation_id));
    }else{
      $data['product_variation_details'] = $product_variation_details = $this->common_model->get_result('product_variations', array('product_info_id'=> $product_info_id));
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

            $this->session->set_flashdata('msg_success', 'Product variation information updated successfully');
            redirect('backend/products/product_other_info/'.$product_info_id.'/0/2'); 
          }else{
            $this->session->set_flashdata('msg_error', 'Something went wrong! Please try again'); 
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
    $data['template'] ='backend/products/product_variations';
    $this->load->view('templates/superadmin_template',$data);
  }


  public function product_offer($product_info_id='', $product_variation_id='', $type=''){
    $this->_check_login(); //check login authentication
    $data['title']='Product Offers';
    if(!empty($product_info_id)){
      $data['product_info'] = $product_info = $this->common_model->get_row('products_info', array('product_info_id' => $product_info_id));
      if(empty($product_info)){
        redirect('backend/products/index');
      }
    }
    if(!empty($product_info_id) && !empty($product_variation_id)){
      $data['product_variationsData'] = $product_variations = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id));
      if(empty($product_variations)){
        redirect('backend/products/index');
      }
    }
    $data['product_offerBasicInfo'] = $product_offerBasicInfo = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'type_of_product' => 1));
   
    $data['product_offerOtherInfo'] = $product_offerOtherInfo = $this->common_model->get_row('product_offers', array('product_info_id' => $product_info_id,'product_variation_id' => $product_variation_id,'sale_end_date >='=>date('Y-m-d')));
  
    if(isset($_POST['submitInfo'])){
      /*----------Uniqueness of backend ID and Product ID------*/
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
           $insert['type_of_product']    = 1;
           $insert['admin_approvel']     = 2;
           $insert['created_at']         = date('Y-m-d H:i:s A');
           $product_variation_id = $this->common_model->insert('product_variations', $insert);
           $this->session->set_flashdata('msg_success', 'Product offer information added successfully'); 
        }else{

           $insert['product_variation_info']  = json_encode($_POST['product_variation_info']);
           $insert['updated_at']             = date('Y-m-d H:i:s A');
           $this->common_model->update('product_variations', $insert, array('product_info_id' => $product_info_id,'product_variation_id'=>$product_variation_id));
           $this->session->set_flashdata('msg_success', 'Product offer information updated successfully');
        }
       
        if(!empty($insert1)  && empty($data['product_offerOtherInfo']))
        {
            $insert1['product_variation_id'] = $product_variation_id;
            $this->common_model->insert('product_offers', $insert1);
            $this->session->set_flashdata('msg_success', 'Product offer information added successfully');
        }else if(!empty($insert1)  && !empty($data['product_offerOtherInfo'])){
           $resultOfOffer = $this->common_model->update('product_offers', $insert1, array('product_info_id' => $product_info_id,'product_offer_id'=>$data['product_offerOtherInfo']->product_offer_id));
           $this->session->set_flashdata('msg_success', 'Product offer information updated successfully');          
        } 
        //echo $product_variation_id; die;
        $redirectionResult = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id,'product_variation_id' => $product_variation_id)); 
        
        if(!empty($redirectionResult)){
          if($redirectionResult->type_of_product==1){
            redirect('backend/products/product_other_info/'.$product_info_id.'/'.$product_variation_id.'/1');
          }elseif ($redirectionResult->type_of_product==2) {
            redirect('backend/products/product_images/'.$product_info_id.'/'.$product_variation_id.'/2');
          }
        }else{
            redirect('backend/products/product_other_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type);
        }
    }
  }
    $data['product_info_id'] = $product_info_id;
    $data['product_variation_id'] = $product_variation_id;
    $data['type'] = $type;
    $data['template'] ='backend/products/product_offer';
    $this->load->view('templates/superadmin_template',$data);
  }


  public function product_other_info($product_info_id='', $product_variation_id='', $type=''){
    $this->_check_login(); //check login authentication
    $data['title']='Product Other Info';

    if(!empty($product_info_id)){
      $data['product_info'] = $product_info = $this->common_model->get_row('products_info', array('product_info_id' => $product_info_id));
      if(empty($product_info))
        redirect('backend/products/index');
    }

    if(!empty($product_info_id) && !empty($product_variation_id)){
      $data['product_variationsData'] = $product_variations = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id));
      if(empty($product_variations))
        redirect('backend/products/index');
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
        $this->session->set_flashdata('msg_success', 'Product other information Updated successfully');
        $redirectionResult = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id,'product_variation_id' => $product_variation_id)); 
        if($product_variation_id==0){
            redirect('backend/products/product_descriptions/'.$product_info_id.'/'.$product_variation_id.'/'.$type);
        }else{
            redirect('backend/products/product_images/'.$product_info_id.'/'.$product_variation_id.'/'.$type);
        }
      }else{
        $this->session->set_flashdata('msg_error', 'Something went wrong! Please try again'); 
        redirect($_SERVER['HTTP_REFERER']);
      } 
    } 

    $data['product_info_id'] = $product_info_id;
    $data['product_variation_id'] = $product_variation_id;
    $data['type'] = $type;
    $data['template'] ='backend/products/product_other_info';
    $this->load->view('templates/superadmin_template',$data);
  }


  public function product_images($product_info_id='', $product_variation_id='', $type=''){
    $this->_check_login(); //check login authentication
    $data['title']='Product Images';

    if(!empty($product_info_id)){
      $data['product_info'] = $product_info = $this->common_model->get_row('products_info', array('product_info_id' => $product_info_id));
      if(empty($product_info))
        redirect('backend/products/index');
    }

    if(!empty($product_info_id) && !empty($product_variation_id)){
      $data['product_variationsData'] = $product_variations = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id));
      if(empty($product_variations))
        redirect('backend/products/index');
    }
    

    $data['product_feature_img'] = $product_feature_img = $this->common_model->get_row('product_images', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id, 'featured_image'=>1), "", array('featured_image','desc'));

    $data['product_images'] = $product_images = $this->common_model->get_result('product_images', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id, 'featured_image'=>0), "", array('featured_image','desc'));

    $this->form_validation->set_rules('image', 'Product Image', 'callback_productImg_check');
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

    if ($this->form_validation->run() == TRUE){ 
      if (!empty($this->session->userdata('productImg_check')['image'])) {
        foreach ($this->session->userdata('productImg_check')['image'] as $value) {
          $product_feature_images = $this->common_model->get_row('product_images', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id, 'featured_image'=>1), "", array('featured_image','desc'));
          if(empty($product_feature_images)){
            $featured_image = 1;
          }else{
            $featured_image = 0;
          }

          $insert = [
            'featured_image'          => $featured_image,
            'image'                   => $value,
            'product_info_id'         => $product_info_id,
            'product_variation_id'    => $product_variation_id,
            'created_at'              => date('Y-m-d H:i:s A')
          ];
          $insertID[] = $this->common_model->insert('product_images', $insert);
          $indexing++;
        }
        if (!empty($insertID)){ 
          $this->session->set_flashdata('msg_success', 'Product images added successfully');
          redirect('backend/products/product_descriptions/'.$product_info_id.'/'.$product_variation_id.'/'.$type);
        }else{
          $this->session->set_flashdata('msg_error', 'Something went wrong! Please try again'); 
          redirect($_SERVER['HTTP_REFERER']);
        }
      }
    }
    $data['product_info_id'] = $product_info_id;
    $data['product_variation_id'] = $product_variation_id;
    $data['type'] = $type;
    $data['template'] ='backend/products/product_images';
    $this->load->view('templates/superadmin_template',$data);
  }


  public function product_descriptions($product_info_id='', $product_variation_id='', $type=''){
    $this->_check_login(); //check login authentication
    $data['title']='Product Description';

    if(!empty($product_info_id)){
      $data['product_info'] = $product_info = $this->common_model->get_row('products_info', array('product_info_id' => $product_info_id));
      if(empty($product_info))
        redirect('backend/products/index');
    }

    if(!empty($product_info_id) && !empty($product_variation_id)){
      $data['product_variationsData'] = $product_variations = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id));
      if(empty($product_variations))
        redirect('backend/products/index');
    }

    $this->form_validation->set_rules('description', 'Description', 'required|trim'); 
    $this->form_validation->set_rules('key_product_feature', 'Key Product Feature', 'trim');
    $this->form_validation->set_rules('legal_disclaimer', 'Legal Disclaimer', 'trim'); 
    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

    if ($this->form_validation->run() == TRUE){ 
      ini_set('memory_limit', '-1'); 
      $insert = [
        'description'          => $this->input->post('description'),
        'key_product_feature'  => $this->input->post('key_product_feature'),
        'legal_disclaimer'     => $this->input->post('legal_disclaimer')
      ];

      if ($id = $this->common_model->update('products_info', $insert, array('product_info_id' => $product_info_id))){ 
        $this->session->set_flashdata('msg_success', 'Product description updated successfully'); 
        redirect('backend/products/product_keywords/'.$product_info_id.'/'.$product_variation_id.'/'.$type);
      }else{
        $this->session->set_flashdata('msg_error', 'Something went wrong! Please try again'); 
        redirect($_SERVER['HTTP_REFERER']);
      }
    }

    $data['product_info_id'] = $product_info_id;
    $data['product_variation_id'] = $product_variation_id;
    $data['type'] = $type;
    $data['template'] ='backend/products/product_descriptions';
    $this->load->view('templates/superadmin_template',$data);
  }


  public function check_keyword_value($str){
      foreach($_POST['keywords'] as $key=>$value)
      {
        if($value=='')
        {
          $this->form_validation->set_message("check_keyword_value", "All keyword value is required.");
          return FALSE;
        }
      }
      if(count(array_unique($_POST['keywords']))<count($_POST['keywords']))
      {
        $this->form_validation->set_message("check_keyword_value", "All keywords value unique is required.");
        return FALSE;
      }
      else
      {
        return TRUE;
      }
    
  }

  public function product_keywords($product_info_id='', $product_variation_id='', $type=''){
    $this->_check_login(); //check login authentication
    $data['title']='Product Keywords';

    if(!empty($product_info_id)){
      $data['product_info'] = $product_info = $this->common_model->get_row('products_info', array('product_info_id' => $product_info_id));
      if(empty($product_info))
        redirect('backend/products/index');
    }

    if(!empty($product_info_id) && !empty($product_variation_id)){
      $data['product_variationsData'] = $product_variations = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id));
      if(empty($product_variations))
        redirect('backend/products/index');
    }

    $this->form_validation->set_rules('keywords[]', 'Search Terms', 'trim|callback_check_keyword_value'); 
    if ($this->form_validation->run() == TRUE){ 
      $insert = [
        'keywords'          => json_encode($this->input->post('keywords')),
       ];
      if ($id = $this->common_model->update('products_info', $insert, array('product_info_id' => $product_info_id))){ 
        $this->session->set_flashdata('msg_success', 'Product keywords updated successfully');
        redirect('backend/products/product_seo/'.$product_info_id.'/'.$product_variation_id.'/'.$type);
      }else{
        $this->session->set_flashdata('msg_error', 'Something went wrong! Please try again'); 
        redirect($_SERVER['HTTP_REFERER']);
      }
    }

    $data['product_info_id'] = $product_info_id;
    $data['product_variation_id'] = $product_variation_id;
    $data['type'] = $type;
    $data['template'] ='backend/products/product_keywords';
    $this->load->view('templates/superadmin_template',$data);
  }


  public function product_seo($product_info_id='', $product_variation_id='', $type=''){
    $this->_check_login(); //check login authentication
    $data['title']='Product SEO';

    if(!empty($product_info_id)){
      $data['product_info'] = $product_info = $this->common_model->get_row('products_info', array('product_info_id' => $product_info_id));
      if(empty($product_info))
        redirect('backend/products/index');
    }

    if(!empty($product_info_id) && !empty($product_variation_id)){
      $data['product_variationsData'] = $product_variations = $this->common_model->get_row('product_variations', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id));
      if(empty($product_variations))
        redirect('backend/products/index');
    }

    $data['product_seo_info'] = $product_seo_info = $this->common_model->get_row('product_seo', array('product_info_id' => $product_info_id));

    $this->form_validation->set_rules('meta_title', 'Meta Title', 'min_length[2]|max_length[150]|required|trim'); 
    $this->form_validation->set_rules('meta_keywords', 'Meta Keywords', 'min_length[2]|max_length[200]|required|trim');
    $this->form_validation->set_rules('meta_description', 'Meta Description', 'min_length[10]|max_length[255]|required|trim'); 
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
          $this->session->set_flashdata('msg_success', 'Product meta information added successfully'); 
          redirect('backend/products/index'); 
        }else{
          $this->session->set_flashdata('msg_error', 'Something went wrong! Please try again'); 
          redirect($_SERVER['HTTP_REFERER']); 
        } 
      }else{
        if ($id = $this->common_model->update('product_seo', $insert, array('product_info_id' => $product_info_id))){ 
          $this->session->set_flashdata('msg_success', 'Product meta information updated successfully'); 
          redirect('backend/products/index'); 
        }else{
          $this->session->set_flashdata('msg_error', 'Something went wrong! Please try again'); 
          redirect($_SERVER['HTTP_REFERER']); 
        }
      }
    }

    $data['product_info_id'] = $product_info_id;
    $data['product_variation_id'] = $product_variation_id;
    $data['type'] = $type;
    $data['template'] ='backend/products/product_seo';
    $this->load->view('templates/superadmin_template',$data);
  }


  public function changestatus($id="",$status="",$offset="",$table_name="") {
    $this->_check_login(); //check login authentication
    $data['title']='';

    if($status==2) 
      $status=1;
    else $status=2;
      $data=array('status'=>$status);
      if($this->common_model->update($table_name,$data,array('id'=>$id)))
        $this->session->set_flashdata('msg_success','Status Updated successfully');
        redirect($_SERVER['HTTP_REFERER']);
  }

  public function changeadminstatus($id="",$status="",$statuscol="",$table_name="") {
    $this->_check_login(); //check login authentication
    $data['title']='';
    if($status==2) 
      $status=1;
    else 
      $status=2;


    $data=array($statuscol=>$status);
    if($this->common_model->update($table_name,$data,array('product_variation_id'=>$id))){

        //-------------For Send email AND SMS-----------
        $email_template = $this->common_model->get_row('email_templates', array('id'=>10));
        if(!empty($email_template)){

          $product_variations = $this->common_model->get_row('product_variations', array('product_variation_id' => $id));
          if(!empty($product_variations)){
              $product_info = $this->common_model->get_row('products_info', array('product_info_id' => $product_variations->product_info_id));
              $seller_info = $this->common_model->get_row('users', array('user_id' => $product_variations->seller_id));
              if(!empty($product_info) && !empty($seller_info)){

                $productTypeName = ($product_variations->type_of_product==1) ? "Single Product" : "Variation Product"; 
                //==-----------===Send Email==-----------
                if($email_template->template_email_enable==1){

                    $userRole  = 1; //for Seller
                    $to        = $seller_info->email;
                    $param     = array(
                        'site_name'           => SITE_NAME,
                        'seller_name'         => ucfirst($seller_info->user_name),
                        'product_title'       => ucfirst($product_info->title),
                        'product_id'          => $product_variations->product_ID,
                        'product_type'        => $productTypeName,
                        'product_detail_link' => '<a target="_blank" href="'.base_url('seller/products/edit_product_basic_info/'.$product_variations->product_info_id.'/'.$product_variations->product_variation_id.'/'.$product_variations->type_of_product).'">Click here to view/edit the details of this product</a>',
                        'support_link'        => '<a target="_blank" href="'.base_url('seller/support/messages').'">Support</a>'
                    );
                    $sendEmail = sendEmail($email_template, $to, $param, $userRole);


                    $userRole  = 0; //for Admin
                    $adminEMAIl= get_option_url('EMAIl');
                    $to      = (!empty($adminEMAIl)) ? $adminEMAIl : SUPPORT_EMAIL;
                    $param     = array(
                        'site_name'           => SITE_NAME,
                        'seller_name'         => ucfirst($seller_info->user_name),
                        'product_title'       => ucfirst($product_info->title),
                        'product_id'          => $product_variations->product_ID,
                        'product_type'        => $productTypeName,
                        'product_detail_link' => '<a target="_blank" href="'.base_url('backend/products/edit_product_basic_info/'.$product_variations->product_info_id.'/'.$product_variations->product_variation_id.'/'.$product_variations->type_of_product).'">Click here to view the details of this product</a>'
                    );
                    $sendEmailAdmin = sendEmail($email_template, $to, $param, $userRole);
                }

                //==-----------===Send SMS==-----------===
                if($email_template->template_sms_enable==1){

                  $userRole  = 1; //for seller
                  $to      = ($seller_info->country_code) ? '+'.$seller_info->country_code.''.$seller_info->mobile : $seller_info->mobile;
                  $param     = array(
                      'site_name'           => SITE_NAME,
                      'seller_name'         => ucfirst($seller_info->user_name),
                      'product_title'       => ucfirst($product_info->title),
                      'product_id'          => $product_variations->product_ID,
                      'product_type'        => $productTypeName,
                      'product_detail_link' => '<a target="_blank" href="'.base_url('seller/products/edit_product_basic_info/'.$product_variations->product_info_id.'/'.$product_variations->product_variation_id.'/'.$product_variations->type_of_product).'">Click here to view/edit the details of this product</a>',
                      'support_link'        => '<a target="_blank" href="'.base_url('seller/support/messages').'">Support</a>'
                  );
                  $sendSMS = sendSMS($email_template, $to, $param, $userRole);


                  $userRole  = 0; //for Admin
                  $to      = get_option_url('PHONE');
                  $param     = array(
                      'site_name'           => SITE_NAME,
                      'seller_name'         => ucfirst($seller_info->user_name),
                      'product_title'       => ucfirst($product_info->title),
                      'product_id'          => $product_variations->product_ID,
                      'product_type'        => $productTypeName,
                      'product_detail_link' => '<a target="_blank" href="'.base_url('backend/products/edit_product_basic_info/'.$product_variations->product_info_id.'/'.$product_variations->product_variation_id.'/'.$product_variations->type_of_product).'">Click here to view the details of this product</a>'
                  );
                  $sendSMSAdmin = sendSMS($email_template, $to, $param, $userRole);
                }

              }
                //-------------**For Send email AND SMS-----------

          }
        }

        $this->session->set_flashdata('msg_success','Status updated successfully');
        redirect($_SERVER['HTTP_REFERER']);
    } 
  }

  public function delete_image($product_img_id='', $product_info_id='')
  {
      $this->_check_login(); //check  login authentication

      $data= $this->common_model->get_row('product_images',array('product_img_id'=>$product_img_id, 'product_info_id'=>$product_info_id));
      if(!$data) redirect('backend/products/index');

      if($this->common_model->delete('product_images',array('product_img_id'=>$product_img_id)))
      {
          $dataOfImg = $this->common_model->get_row('product_images',array('product_info_id'=>$product_info_id),'',array('product_img_id','asc'));
          if($dataOfImg){
              $this->common_model->update('product_images', array('featured_image' => 1),array('product_img_id'=>$dataOfImg->product_img_id));
          }
          @unlink('assets/uploads/seller/products/'.$data->image);
          @unlink('assets/uploads/seller/products/thumbnail/'.$data->image);
          @unlink('assets/uploads/seller/products/small_thumbnail/'.$data->image);
          $this->session->set_flashdata('msg_success', 'Product image deleted successfully');
          redirect($_SERVER['HTTP_REFERER']);
      }else{
          $this->session->set_flashdata('msg_error', 'Something went wrong! Please try again');
          redirect($_SERVER['HTTP_REFERER']);
      }

  }


  public function delete_product($product_info_id='', $product_variation_id='', $type='')
  {
      $this->_check_login(); //check  login authentication

      $data= $this->common_model->get_row('products_info',array('product_info_id'=>$product_info_id));
      if(!$data) redirect('backend/products/index');

      if($type==1){
        if($this->common_model->delete('products_info',array('product_info_id'=>$product_info_id)))
        {
            $dataImg= $this->common_model->get_row('product_images',array('product_info_id'=>$product_info_id));
            foreach ($dataImg as $row) {
              @unlink('assets/uploads/seller/products/'.$row->image);
              @unlink('assets/uploads/seller/products/thumbnail/'.$row->image);
            }
            $this->common_model->delete('product_images',array('product_info_id'=>$product_info_id));
            $this->common_model->delete('product_faq',array('product_variation_id'=>$product_variation_id));
            $this->common_model->delete('product_offers',array('product_info_id'=>$product_info_id));
            $this->common_model->delete('product_seo',array('product_info_id'=>$product_info_id));
            $this->common_model->delete('product_variations',array('product_info_id'=>$product_info_id));
            $this->common_model->delete('product_review',array('product_info_id'=>$product_info_id));
            $this->common_model->delete('product_viewed',array('product_variation_id'=>$product_variation_id));

            $this->session->set_flashdata('msg_success', 'Product deleted successfully');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('msg_error', 'Something went wrong! Please try again');
            redirect($_SERVER['HTTP_REFERER']);
        }
      }else if($type==2){
        if($this->common_model->delete('product_variations',array('product_variation_id'=>$product_variation_id)))
        {
            $dataImg= $this->common_model->get_row('product_images',array('product_variation_id'=>$product_variation_id));
            foreach ($dataImg as $row) {
              @unlink('assets/uploads/seller/products/'.$row->image);
              @unlink('assets/uploads/seller/products/thumbnail/'.$row->image);
            }
            $this->common_model->delete('product_images',array('product_variation_id'=>$product_variation_id));
            $this->common_model->delete('product_faq',array('product_variation_id'=>$product_variation_id));
            $this->common_model->delete('product_offers',array('product_variation_id'=>$product_variation_id));
            $this->common_model->delete('product_review',array('product_variation_id'=>$product_variation_id));
            $this->common_model->delete('product_viewed',array('product_variation_id'=>$product_variation_id));

            $this->session->set_flashdata('msg_success', 'Product deleted successfully');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('msg_error', 'Something went wrong! Please try again');
            redirect($_SERVER['HTTP_REFERER']);
        }
      }
  }


  public function getProductSubcategory() {
        $category = $this->input->post('category');
        $main = $this->input->post('main')+1;
        $optionData = "";

        if (!$category) {
            echo json_encode(array('status' => 'failed', 'optionData' => $optionData));
            die();
        } else {
            $data = $this->common_model->get_result('category', array('parent_id' => $category, 'status' => 1), '', array('category_name', 'asc'));
            if ($data) {
                $optionData .= "<div class='col-md-12 form-group'><div class='col-md-offset-1 col-md-10'><select class='form-control productcategory subcategory".$main."' name='productcategory[]' onchange='getsubcat(this);' main='".$main."'>";
                $optionData .= "<option value=''>--Select Subcategory--</option>";
                foreach ($data as $row) {
                    $optionData .= "<option value='".$row->category_id."'>" . ucfirst($row->category_name) ."</option>";
                }
                $optionData .= "</select></div></div><div class='subcat".$main."'></div>";
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

            $data = $this->common_model->getAttrDataUsingCategory('attributes', array($category,'category_id'), 'attribute_code');
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
        $this->form_validation->set_message('check_equal_less', 'The base price is not greater than sell price'); 
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
        $this->form_validation->set_message('productImg_check', 'Need to required to choose an image file'); 
        return FALSE;
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
      $s_no = $_POST['s_no'];
      $product_info_id = $_POST['product_info_id'];
      
      if(empty($product_info_id)){
        echo json_encode(array('status' => 'failed', 'data' => $resultdata));
        die();
      }else{
        $data = $this->common_model->getVariationProducts($product_info_id);
        if($data){
          $resultdata .= "";
          $i=0;
          foreach ($data as $row) {
            $i++;

            $sellerName = ucwords(get_NameUsingID($row->seller_id));
            $image = getFeaturedImage($row->product_info_id, $row->product_variation_id);
            if(!empty($image) && file_exists("assets/uploads/seller/products/thumbnail/".$image)){
              $img = '<img width="100" height="auto" src="'.base_url('assets/uploads/seller/products/thumbnail/'.$image).'">';
            }else{
              $img = '<img width="100" height="auto" src="'.base_url('assets/backend/image/default_image.png').'">';
            }

            $sellerSKU = ($row->seller_SKU) ? $row->seller_SKU : "-";
            $sellerbase_price     = ($row->base_price) ? '$'.number_format($row->base_price,2) : "$0.00";
            $sellersell_price     = ($row->sell_price) ? '$'.number_format($row->sell_price,2) : "$0.00";
            $sellerquantity       = ($row->quantity) ? $row->quantity : "0";
            $statusVal            = ($row->admin_approvel==2) ? "1" : "2";
            $statusCls            = ($row->admin_approvel==2) ? "danger" : "success";
            $statustooltipMsg     = ($row->admin_approvel==2) ? "Active" : "Deactive";
            $statusMsg            = ($row->admin_approvel==2) ? "Deactive" : "Active";
            $statustooltipFullMsg = ($row->admin_approvel==2) ? "Do you want to activate this product ?" : "Do you want to deactivate this product ?";

            if(!empty($row->commision_fee) && !empty($row->sell_price)){
              $fee        = $row->commision_fee * $row->sell_price/100;
              $feePreview = '$'.number_format($fee, 2);
            }else{
              $feePreview = "-";
            }

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
            
            $resultdata .= '<tr style="background-color:#eaeaea" class="child_'.$row->product_info_id.'"><td>'.$s_no.'.'.$i.'</td><td>'.$sellerName.'</td><td>'.$img.'</td><td>'.ucwords($row->title).' <b>('.$row->product_ID.')</b><br>'.$tempMore.'</td><td>'.$sellerbase_price.'</td><td>'.$sellersell_price.'</td><td>'.$sellerquantity.'</td><td>'.$feePreview.'</td><td>
              <a onClick=\'javascript: return confirm("Are you sure want to change the status ?");\' href="'.base_url().'backend/products/changeadminstatus/'.$row->product_variation_id.'/'.$row->admin_approvel.'/admin_approvel/product_variations"  class="btn btn-'.$statusCls.' btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Click to '.$statustooltipMsg.'">'.$statusMsg.'</a></td><td><a href="'.base_url().'backend/products/product_offer/'.$row->product_info_id.'/'.$row->product_variation_id.'/2" class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" Edit Product" target="_blank"><i class="fa fa-eye"></i></a><a href="javascript:void(0)" onClick=\'javascript: return confirmBox("Do you want to delete it ?" , "'.base_url().'seller/products/delete_product/'.$row->product_info_id.'/'.$row->product_variation_id.'/2");\' class="btn btn-danger btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Delete Product"><i class="icon-trash "></i></a></td></tr>';
          }
          echo json_encode(array('status' => 'success', 'data' => $resultdata));
          die();
        }else{
          echo json_encode(array('status' => 'failed', 'data' => $resultdata));
          die();
        }
      }
    }

    /*---==========================Product Variation Theme Section==========================----*/  

  public function variation_themes($offset=0){
    $this->_check_login(); //check login authentication
    $data['title']='List Of Variation Themes';
    $search=array();
    if(!empty($_GET))
    {
      if(!empty($_GET['product_theme_title']))
      $search[]=' vt.product_theme_title like "%'.trim($_GET['product_theme_title']).'%"';
      if(!empty($_GET['status']))
      $search[]=' vt.status = "'.trim($_GET['status']).'"';
    }

    $sort='desc';
    $data['variation_themes'] = $this->common_model->get_result_pagination('variation_themes as vt', array(), array(), array('vt.product_theme_id',$sort), array(), $offset, PER_PAGE, $search);
    $config=backend_pagination(); 
    $config['base_url'] = base_url().'backend/products/variation_themes/';
    $config['total_rows'] = $this->common_model->get_result_pagination('variation_themes as vt',array(), array(), array('vt.product_theme_id','desc'), array(), 0, 0, $search);
   
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
    $data['template']='backend/products/variation_themes';
    $data['offset']=$offset;
    $this->load->view('templates/superadmin_template',$data);

  }


  public function add_variation_theme(){
    $this->_check_login(); //check login authentication
    $data['title']='Add Product Variation Theme';

    $this->form_validation->set_rules('product_theme_title', 'Variation Theme Title', 'required|trim'); 
    $this->form_validation->set_rules('category', 'Category', 'required|trim'); 
    $this->form_validation->set_rules('status', 'Status', 'required|trim'); 

    if ($this->form_validation->run() == TRUE){ 

      $insert = [
        'product_theme_title' => $this->input->post('product_theme_title'),
        'product_theme_slug'  => url_title(trim($this->input->post('product_theme_title')), 'dash', true),
        'category'            => $this->input->post('category'),
        'attributes'          => json_encode($this->input->post('attributes')),
        'status'              => $this->input->post('status'),
        'created_at'          => date('Y-m-d H:i:s A'),
        'updated_at'          => date('Y-m-d H:i:s A')
      ];

      if ($id = $this->common_model->insert('variation_themes', $insert)){ 
        $this->session->set_flashdata('msg_success', 'Product variation theme information added successfully'); 
        redirect('backend/products/variation_themes'); 
      }else{
        $this->session->set_flashdata('msg_error', 'Something went wrong! Please try again'); 
        redirect('backend/products/variation_themes');
      } 
    } 

    $data['template'] ='backend/products/add_variation_theme';
    $this->load->view('templates/superadmin_template',$data);
  }


  public function edit_variation_theme($product_theme_id=''){
    $this->_check_login(); //check login authentication
    $data['title']='Edit Product Variation Theme';

    $data['variation_themes'] = $variation_themes = $this->common_model->get_row('variation_themes', array('product_theme_id' => $product_theme_id));
    if(empty($variation_themes))
      redirect('backend/products/variation_themes');

    $this->form_validation->set_rules('product_theme_title', 'Variation Theme Title', 'required|trim'); 
    $this->form_validation->set_rules('category', 'Category', 'required|trim'); 
    $this->form_validation->set_rules('status', 'Status', 'required|trim'); 

    if ($this->form_validation->run() == TRUE){ 
      $insert = [
        'product_theme_title' => $this->input->post('product_theme_title'),
        'product_theme_slug'  => url_title(trim($this->input->post('product_theme_title')), 'dash', true),
        'category'            => $this->input->post('category'),
        'attributes'          => json_encode($this->input->post('attributes')),
        'status'              => $this->input->post('status'),
        'updated_at'          => date('Y-m-d H:i:s A')
      ];

      if ($id = $this->common_model->update('variation_themes', $insert, array('product_theme_id' => $product_theme_id))){ 
        $this->session->set_flashdata('msg_success', 'Product variation theme information updated successfully'); 
        redirect('backend/products/variation_themes'); 
      }else{
        $this->session->set_flashdata('msg_error', 'Something went wrong! Please try again'); 
        redirect('backend/products/variation_themes');
      } 
    } 

    $data['template'] ='backend/products/edit_variation_theme';
    $this->load->view('templates/superadmin_template',$data);
  }

/*---==========================Product Variation Theme Section End==========================----*/  
  
  public function manage_product_status($tablename='')
  {     
      if(!empty($_POST['status'])){    

          $default_arr=array('status'=>FALSE); 
          $status='';            
          $count= count($_POST['row_id']);
          
          for ($i=0; $i < $count ; $i++){
              if($_POST['status']==1 || $_POST['status']==2){
                  if($_POST['type']==0){
                    if($_POST['status']==1){
                        $update_status= array('admin_approvel'=>1);
                    }elseif($_POST['status']==2){
                        $update_status= array('admin_approvel'=>2);
                    }

                    $this->common_model->update('product_variations',$update_status,array('product_info_id'=>$_POST['row_id'][$i]));
                    $default_arr=array('status'=>TRUE);

                  }else{
                    if($_POST['status']==1){
                        $update_status= array('status'=>1);
                    }elseif($_POST['status']==2){
                        $update_status= array('status'=>2);
                    }

                    $this->common_model->update('products_info',$update_status,array('product_info_id'=>$_POST['row_id'][$i]));
                    $this->common_model->update('product_variations',$update_status,array('product_info_id'=>$_POST['row_id'][$i]));
                    $default_arr=array('status'=>TRUE);

                  }
              }else{
                  $this->common_model->delete('products_info',array('product_info_id'=>$_POST['row_id'][$i]));
                  $this->common_model->delete('product_variations',array('product_info_id'=>$_POST['row_id'][$i]));
                  $this->common_model->delete('product_seo',array('product_info_id'=>$_POST['row_id'][$i]));
                  $this->common_model->delete('product_images',array('product_info_id'=>$_POST['row_id'][$i]));
                  $this->common_model->delete('product_review',array('product_info_id'=>$_POST['row_id'][$i]));
                  $this->common_model->delete('product_offers',array('product_info_id'=>$_POST['row_id'][$i]));
                  $default_arr=array('status'=>TRUE);
              } 
          }
          header('Content-Type: application/json');
          echo json_encode($default_arr);        
      }
  }

}   