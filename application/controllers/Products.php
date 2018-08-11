<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Products extends CI_Controller {
	public function __construct(){ 
		
		parent::__construct(); 
		$this->load->model('category_model');
		$this->load->model('product_model');
		$this->load->library('Ajax_pagination');
		$this->perPage = 20;
	} 
	public function index($slug='')
	{
		$category_id=0;
		$category_slug='';
		if(!empty($_GET) && isset($_GET['slug']))
			$slug=trim($_GET['slug']);
		if($slug!='' && !empty($data['category_info']=$this->common_model->get_row('category',array('category_slug'=>$slug,'status'=>1))))
		{
			$category_id=$data['category_info']->category_id;
			$category_slug=$data['category_info']->category_slug;	
		}	//redirect('page/_404');
		$data['category_id']=$category_id;
		$data['category_slug']=$category_slug;
		$data['search']=$_GET;
	    $offset = 0;
        if(!empty($_GET) && isset($_GET['page']))
            $offset = $_GET['page'];
        
        $data['gird']=0;
        if(!empty($_GET) && isset($_GET['g']))
            $data['gird'] = $_GET['g'];
		$data['title']='List Of Products';
		$category=array();
		if($category_id){
			$category=array_reverse($this->getParentCategoryId($category_id));
		}
		$data['category']=array();
		if(!empty($_GET) && !empty($_GET['ab']))
		{
			$_GET['attribute']=$this->getAttributeCondition($_GET['ab']);
		}

		if($offset==0 && empty($_GET)){
			$data['category']=$this->common_model->get_result('category',array('parent_id'=>$category_id,'status'=>1),array('category_id','category_name','category_slug','logo_image','short_description','(SELECT count(pi.`product_info_id`) as pcount FROM `products_info` as pi join product_variations as pv on pv.product_info_id=pi.product_info_id WHERE pv.admin_approvel=1 and pv.status=1 and FIND_IN_SET(category.category_id,pi.category_id) GROUP by pi.`category_id` order by pcount desc limit 1) as product_count'),array('category_name','asc'));
		}
		
		$data['category_list']='';
		if($category_id==0)
			$data['category_lists']=$this->common_model->get_result('category',array('status'=>1,'parent_id'=>0),array('category_slug','category_id','category_name','(SELECT count(pi.`product_info_id`) as pcount FROM `products_info` as pi join product_variations as pv on pv.product_info_id=pi.product_info_id WHERE pv.admin_approvel=1 and pv.status=1 and FIND_IN_SET(category.category_id,pi.category_id) GROUP by pi.`category_id` order by pcount desc limit 1) as product_count'));
		else
			$data['category_list']=	$this->category_model->getCategoryTree($category);
	
		$data['brands']= $this->common_model->get_result_using_findInSet('brand',array('status'=>1),array('brand_name','brand_id'),array('brand_name','asc'),'',array($category_id,'category_id'));
		$data['attributes']=$this->common_model->get_result_using_findInSet('attributes',array('used_in_filter'=>1,'status'=>1),array('name','attribute_code','attribute_value','type'),array('name','asc'),'',array($category_id,'category_id'));
		 //total rows count
        $totalRec = $this->product_model->product_list($category_id,1,0,0);
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'p/'.$category_slug;
        $config['total_rows']  = $totalRec;
        $config['cur_page_set']    = $offset;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        $data['products'] =$this->product_model->product_list($category_id,1,$offset,$this->perPage);

        /*For Most rated or most discounted products*/
	    $most_rated = $this->product_model->product_featured($category_id, 1, 0, 20, '', '', array('total_rating'));
	    if(!empty($most_rated) && count($most_rated)>=5){
	    	$data['most_rated_or_discounted'] = $most_rated;
	    	$data['most_ratedDiscounted_heading'] = "Most Rated Products";
	    }else{
	    	$most_discounted = $this->product_model->product_featured($category_id, 1, 0, 20, '', '', array('most_discounted'));
	    	$data['most_rated_or_discounted'] = $most_discounted;
	    	$data['most_ratedDiscounted_heading'] = "Most Discounted Products";
	    }

	    $data['template']='frontend/product/product_list';
	    $this->load->view('templates/frontend/front_template',$data);	
	}


	function getParentCategoryId($category_id=0,$category=array()){
		$query = $this->common_model->get_row('category',array('category_id'=>$category_id),array('category_id','parent_id','category_name'));		
		if($query)
		{
			$category[]=$query->category_id;
			$category=	$category= $this->getParentCategoryId($query->parent_id,$category);	
		}
		return $category;		
	}
	

	function ajaxPaginationData(){
		
        $conditions = array();
        $_GET=$_POST;
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        $data['search']=$_POST;
        $data['gird']=$this->input->post('grid');
        $data['category']=array();
        if(!empty($_GET) && !empty($_GET['ab']))
		{
			$_GET['attribute']=$this->getAttributeCondition($_GET['ab']);
		}
        if($offset==0 && empty($_GET))
        $data['category']=$this->common_model->get_result('category',array('parent_id'=>$_POST['category_id'],'status'=>1),array('category_id','category_name','category_slug','logo_image','short_description','(SELECT count(pi.`product_info_id`) as pcount FROM `products_info` as pi join product_variations as pv on pv.product_info_id=pi.product_info_id WHERE pv.admin_approvel=1 and pv.status=1 and FIND_IN_SET(category.category_id,pi.category_id) GROUP by pi.`category_id` order by pcount desc limit 1) as product_count'),array('category_name','asc'));

        //total rows count
        $data['category_id']=$_POST['category_id'];
        $data['category_slug']=$_POST['category_slug'];
        $totalRec =$this->product_model->product_list($_POST['category_id'],1,0,0);
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'p/'.$_POST['category_slug'];
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);

        if(!empty($_POST['category_slug']))
            $data['category_info'] = $this->common_model->get_row('category',array('category_slug'=>$_POST['category_slug']));

   		$data['products'] = $this->product_model->product_list($_POST['category_id'],1,$offset,$this->perPage);
        $this->load->view('frontend/product/ajax_product_list', $data, false);
    }

   	function getAttributeCondition($ab){
   		$attr_key=array();
		$attr_value=array();	
		if(!empty($ab) && !empty($ab))
		{
			$attribute=explode('__',$ab);
				for($i=0;$i<sizeof($attribute);$i++)
				{
					if(!empty($attribute[$i]))
					{
						$attr=explode('--A,',$attribute[$i]);
						if(sizeof($attr)==2){
							$attr_value[$attr[0]]=$attr[1];
							$attr_key[]=$attr[0];
						}
					}	
				}
			if(!empty($attr_key) && !empty($attr_value)){
				$condition=$this->product_model->getAttributeCondition($attr_key,$attr_value);
				if(!empty($condition))	
					return $condition;	 	
				else
					return '';	
			}
		}	
   	}

   	/* product details page */
   	function details($slug='',$product_variation_id='')
   	{
   		if($slug=='' && $product_variation_id=='')
			redirect('page/_404');

		$shipping_addresessDataID = "";
		$data['title']='Product Details';
   		$data['wishListProduct'] = $this->common_model->get_row('wish_list', array('user_id'=>user_id(), 'product_variation_id'=>base64_decode($product_variation_id)));
   		$data['product_faq'] = $this->common_model->get_result('product_faq', array('product_variation_id'=>base64_decode($product_variation_id), 'status'=>1), '', array('product_faq_id','desc'));
   		$data['product']=$this->product_model->product_details(base64_decode($product_variation_id));
   		//echo $this->db->last_query(); die;
   		//p($data['product']);die;
   		if(empty($data['product']))
			redirect('page/_404');

		/*For related products or related discounted products*/
	    $related_products = $this->product_model->product_featured($data['product']->category_id , 1, 0, 20, $data['product']->product_info_id);
	    if(!empty($related_products) && count($related_products)>=5){
	    	$data['related_or_discount_products'] = $related_products;
	    	$data['related_or_discount_products_heading'] = "Related/Similar Products";
	    }else{
	    	$most_relateddiscounted = $this->product_model->product_featured($data['product']->category_id, 1, 0, 20, $data['product']->product_info_id, '', array('most_discounted'));
	    	$data['related_or_discount_products'] = $most_relateddiscounted;
	    	$data['related_or_discount_products_heading'] = "Related/Similar Discounted Products";
	    }

		$category='';
		if(!empty($data['product']->category_id))
		{
			$category=explode(',',$data['product']->category_id);
			$category=$category[sizeof($category)-1];
		}
		$data['product_right'] =$this->product_model->product_featured($category,1,0,3,$data['product']->product_info_id);
		if(empty($data['product_right']))
		{
			$data['product_right'] =$this->product_model->product_featured('',1,0,3,$data['product']->product_info_id,$data['product']->seller_id);
		}
		$data['variations']=array();
		if($data['product']->type_of_product==2 && $data['product']->variation_count>1){
			//p($data['product']);die;
			$data['variations']=$this->get_product_variation($data['product']);
		}

		if(!empty(user_id())){
			$shipping_addresessData = $this->common_model->get_row('shipping_addresess', array('user_id'=>user_id()));
			if(!empty($shipping_addresessData)){
				$shipping_addresessDataID = $shipping_addresessData->shipping_address_id;
			}
		}
		
		$data['shippingCharge'] = getShippingUsingIP($product_variation_id, $shipping_addresessDataID, '');
		$this->product_model->product_viewed(base64_decode($product_variation_id));
		//p($data['shippingCharge']); die;
   		$data['template'] = 'frontend/product/product_detail';
	    $this->load->view('templates/frontend/front_template',$data);	
   	}

   	function get_product_variation($product_info)
   	{
   		$variation=array();
   		$product_variation=array_keys((array)json_decode($product_info->product_variation_info));
   	//	$product_variations_id=explode(',',$product_info->product_variations_id_multiple);
   		if($attribute=$this->product_model->get_attributes($product_variation))
   		{

   			$attribute=array_map('current', $attribute);
   			$variation_data=explode('==:==',$product_info->product_variations_multiple);
   			
   			foreach($variation_data as $key=>$value){
   				$value=(array) json_decode($value);
   				
   				foreach ($attribute as $k =>$val) {
   					if(empty($variation[$val]) || !in_array($value[$val], $variation[$val])){
   						$variation[$val][]=$value[$val];
   					}
   				}
   			}
   		}
   		//p($variation); die;
   		return $variation;
   	}


   	function ajaxProductVariation()
   	{
   		$status=false;
   		$available_attr=array();
   		if(!empty($_POST) && !empty($_POST['available_attr']))
   			$available_attr=explode(',',$_POST['available_attr']);
   		if (($key = array_search('colour', $available_attr)) !== false) {
    		unset($available_attr[$key]);
		}

		$shipmentAddressPost = $_POST['shipmentAddress'];
		$data['product']=$this->product_model->product_details_ajax($_POST['product_variation_id'],$_POST['colour']);
		$data['shippingCharge'] = getShippingUsingIP(base64_encode($data['product']->product_variation_id), $shipmentAddressPost, '');
		$wishlistData = $this->common_model->get_row("wish_list", array('product_variation_id'=>$data['product']->product_variation_id, 'user_id'=>user_id()));
		$ajax_data=array();
		if(!empty($data['product'])){
			
			$status=true;	
			if(!empty($wishlistData)){

				$ajax_data['wishList_div'] = '<button type="button" pRWID="" class="btn btn-default-white btn-block btn-wishlist wishListRemove"><span><img src="'.FRONTEND_THEME_URL.'img/icons/heart-full.svg" width="22"></span> Remove from Wishlist</button>';

				$ajax_data['wishList_divm'] = '<div class="mob-wishlist-icon" data-toggle="tooltip" data-placement="top"title="Remove from Wishlist"><a href="javascript:void(0)"><span class="heart-icon"><img class="removeFromWishlist wishListRemove" pRWID="" src="'.FRONTEND_THEME_URL.'img/icons/heart-full.svg" width="22"></span></a></div>';
			}else{

				$ajax_data['wishList_div'] = '<button type="button" pAWID="" class="btn btn-default-white btn-block btn-wishlist wishListAdd"><span><img src="'.FRONTEND_THEME_URL.'img/icons/heart-empty.svg" width="22"></span> Add to Wishlist</button>';

				$ajax_data['wishList_divm'] = '<div class="mob-wishlist-icon" data-toggle="tooltip" data-placement="top"title="Add to Wishlist"><a href="javascript:void(0)"><span class="mob-heart-icon"><img class="addToWishlist wishListAdd" pAWID="" src="'.FRONTEND_THEME_URL.'img/icons/heart-empty.svg" width="22"></span></a></div>';
			}

			$ajax_data['product_image'] = trim($this->load->view('frontend/product/product_ajax/product_image', $data, true));
			$ajax_data['product_price'] = trim($this->load->view('frontend/product/product_ajax/product_price', $data, true));
			$ajax_data['additional-information']=trim($this->load->view('frontend/product/product_ajax/product_rating', $data, true));
			$ajax_data['seller_description']=$data['product']->seller_description;
			$ajax_data['warranty_description']=$data['product']->warranty_description;
			$ajax_data['available_quantity']=$data['product']->quantity;
			$temp_data['variations']=$this->get_product_variation($data['product']);
			$ajax_data['image']='';
			$ajax_data['product_ID']=base64_encode($data['product']->product_variation_id);
			$ajax_data['product_number']='<td class="label-tittle">'.strtoupper($data['product']->product_ID_type).'</td><td class="value">'.$data['product']->product_ID.'</td>';
			$ajax_data['url']= base_url('pd/'.$data['product']->slug.'/'.base64_encode($data['product']->product_variation_id));
			if(isset($data['product']) && !empty($data['product']) && !empty($data['product']->image)){
      		   $images=explode(',',$data['product']->image);
        	    $ajax_data['image']=base_url('assets/uploads/seller/products/'.$images[0]);	
           	}
			$ajax_data['variations_section']=trim($this->load->view('frontend/product/product_ajax/variations_section',$temp_data, true));
		}
		echo json_encode(array('status'=>$status,'data'=>$ajax_data));	
   	}

   	function ajaxProductattribute()
   	{
   		$status=false;
   		$shipmentAddressPost = $_POST['shipmentAddress'];
   		$_POST['attribute']=explode('==,',rtrim($_POST['attribute'],'=='));
   		$_POST['select_attr']=explode(',', $_POST['select_attr']);
   		if(!empty($_POST['colour'])){
   			$_POST['attribute'][sizeof($_POST['attribute'])]='json_contains(product_variations.product_variation_info,\'{"colour" : "'.$_POST['colour'].'"}\')';	
   			$_POST['select_attr'][]='colour';	
   		}
   		$data['product'] = $this->product_model->get_product_price_ajax($_POST['product_info_id'],$_POST['attribute']);
   		$data['shippingCharge'] = getShippingUsingIP(base64_encode($data['product']->product_variation_id), $shipmentAddressPost, '');
   		$wishlistData = $this->common_model->get_row("wish_list", array('product_variation_id'=>$data['product']->product_variation_id, 'user_id'=>user_id()));
   		$ajax_data=array();
   		if(!empty($data['product'])){	
   			$status=true;
			if(!empty($wishlistData)){
				$ajax_data['wishList_div'] = '<button type="button" pRWID="" class="btn btn-default-white btn-block btn-wishlist wishListRemove"><span><img src="'.FRONTEND_THEME_URL.'img/icons/heart-full.svg" width="22"></span> Remove from Wishlist</button>';

				$ajax_data['wishList_divm'] = '<div class="mob-wishlist-icon" data-toggle="tooltip" data-placement="top"title="Remove from Wishlist"><a href="javascript:void(0)"><span class="heart-icon"><img class="removeFromWishlist wishListRemove" pRWID="" src="'.FRONTEND_THEME_URL.'img/icons/heart-full.svg" width="22"></span></a></div>';
			}else{
				$ajax_data['wishList_div'] = '<button type="button" pAWID="" class="btn btn-default-white btn-block btn-wishlist wishListAdd"><span><img src="'.FRONTEND_THEME_URL.'img/icons/heart-empty.svg" width="22"></span> Add to Wishlist</button>';

				$ajax_data['wishList_divm'] = '<div class="mob-wishlist-icon" data-toggle="tooltip" data-placement="top"title="Add to Wishlist"><a href="javascript:void(0)"><span class="mob-heart-icon"><img class="addToWishlist wishListAdd" pAWID="" src="'.FRONTEND_THEME_URL.'img/icons/heart-empty.svg" width="22"></span></a></div>';
			}

			$ajax_data['product_price']=trim($this->load->view('frontend/product/product_ajax/product_price', $data, true));
			$ajax_data['additional-information']=trim($this->load->view('frontend/product/product_ajax/product_rating', $data, true));
			$ajax_data['seller_description']=$data['product']->seller_description;
			$ajax_data['warranty_description']=$data['product']->warranty_description;
			$temp_data['variations']=$this->get_product_variation($data['product']);
			$ajax_data['url']= base_url('pd/'.$data['product']->slug.'/'.base64_encode($data['product']->product_variation_id));
			$ajax_data['product_ID']=base64_encode($data['product']->product_variation_id);
			$ajax_data['available_quantity']=$data['product']->quantity;
			$ajax_data['product_number']='<td class="label-tittle">'.strtoupper($data['product']->product_ID_type).'</td><td class="value">'.$data['product']->product_ID.'</td>';
			foreach($_POST['select_attr'] as $key => $row)
			{
				if(!empty($temp_data['variations'][$row]))
					unset($temp_data['variations'][$row]);
			}
			$ajax_data['remove_drop']=array_keys($temp_data['variations']);
			$ajax_data['variations_section']=trim($this->load->view('frontend/product/product_ajax/variations_section',$temp_data, true));
   		}	
   		echo json_encode(array('status'=>$status,'data'=>$ajax_data));	
   	}

   	function rating($product_variation_id='',$offset=0)
   	{
   		$shipping_addresessDataID = "";
   		if($product_variation_id=='')
			redirect('page/_404');
		$data['title']='Product Rating';
   		$data['product'] = $this->product_model->product_details(base64_decode($product_variation_id));
   		if(empty($data['product']))
			redirect('page/_404');

   		$join=array(
			array(
				'table'=>'users as u',
				'condition'=>'u.user_id=pr.user_id',
				'type'=>'inner',
			),
		);
		
		/*For related products or related discounted products*/
	    $related_products = $this->product_model->product_featured($data['product']->category_id , 1, 0, 20, $data['product']->product_info_id);
	    if(!empty($related_products) && count($related_products)>=5){
	    	$data['related_or_discount_products'] = $related_products;
	    	$data['related_or_discount_products_heading'] = "Related/Similar Products";
	    }else{
	    	$most_relateddiscounted = $this->product_model->product_featured($data['product']->category_id, 1, 0, 20, $data['product']->product_info_id, '', array('most_discounted'));
	    	$data['related_or_discount_products'] = $most_relateddiscounted;
	    	$data['related_or_discount_products_heading'] = "Related/Similar Discounted Products";
	    }

	    $category='';
		if(!empty($data['product']->category_id))
		{
			$category=explode(',',$data['product']->category_id);
			$category=$category[sizeof($category)-1];
		}
		$data['product_right'] =$this->product_model->product_featured($category,1,0,3,$data['product']->product_info_id);
		if(empty($data['product_right']))
		{
			$data['product_right'] =$this->product_model->product_featured('',1,0,3,$data['product']->product_info_id,$data['product']->seller_id);
		}
		$data['variations']=array();
		if($data['product']->type_of_product==2 && $data['product']->variation_count>1){
			$data['variations']=$this->get_product_variation($data['product']);
		}

		if(!empty(user_id())){
			$shipping_addresessData = $this->common_model->get_row('shipping_addresess', array('user_id'=>user_id()));
			if(!empty($shipping_addresessData)){
				$shipping_addresessDataID = $shipping_addresessData->shipping_address_id;
			}
		}
		
		$data['shippingCharge'] = getShippingUsingIP($product_variation_id, $shipping_addresessDataID, '');

		$data['ratings'] = $this->common_model->get_result_pagination('product_review as pr', array('pr.product_variation_id' =>base64_decode($product_variation_id), 'pr.status'=>1),array('pr.user_id','pr.rating','pr.description','pr.created_at','u.user_name'),array('pr.created_at','desc'),$join,$offset,10);
		$config=backend_pagination();
        $config['base_url'] = base_url().'rating/'.$product_variation_id;
        $config['total_rows'] = $this->common_model->get_result_pagination('product_review as pr', array('pr.product_variation_id' =>base64_decode($product_variation_id), 'pr.status'=>1),array('pr.user_id','pr.rating','pr.description','pr.created_at','u.user_name'),array('pr.created_at','desc'),$join);
        if(!empty($_SERVER['QUERY_STRING'])){
	       $config['suffix'] = "?".$_SERVER['QUERY_STRING'];
	    }
	    else{
	       	$config['suffix'] ='';
	    }
	    $config['first_url'] = $config['base_url'].$config['suffix'];
        $config['per_page'] = 10;
        $this->pagination->initialize($config);
        $data['pagination']=$this->pagination->create_links();
         $data['offset']=$offset;
		$data['template']='frontend/product/rating';
	    $this->load->view('templates/frontend/front_template',$data);
   	}

   	/* Get Product data using ajax */
   	function getParticularProductData($pID='')
   	{
   		$data = array();
   		if(isset($_POST)){
   			$pID = $_POST['pID'];
   			$result = $this->product_model->product_details(base64_decode($pID));
   			if(!empty($result)){

   				$Image = $result->image;
                $Image = explode(',', $Image);
                $Image = base_url().'/assets/uploads/seller/products/small_thumbnail/'.$Image[0];
                $slug  = base_url("pd/".$result->slug.'/'.$pID);
                $sum_rating  = floor($result->sum_rating);

   				$data = array('title'=>$result->title, 'slug'=>$slug, 'sum_rating'=>$sum_rating, 'total_rating'=>$result->total_rating, 'image'=>$Image, 'product_variation_id'=>$result->product_variation_id, 'product_variation_id_encode'=>$pID, 'product_info_id_encode'=>base64_encode($result->product_info_id));
   				$data = json_encode(array('status'=>'success', 'data'=>$data), JSON_NUMERIC_CHECK);
   				echo $data;
   			}else{
   				$data = json_encode(array('status'=>'failed', 'data'=>$data), JSON_NUMERIC_CHECK);
   				echo $data;
   			}
   		}else{
   			$data = json_encode(array('status'=>'failed', 'data'=>$data), JSON_NUMERIC_CHECK);
   			echo $data;	
   		}	
   	}

   	
   	function getShippingRateData($product_variation_id='', $shipmentAddress='', $shipping_method='')
   	{
   		$shipmentData = "";
   		$shippingCharges = array();
   		$yourAddress = "";
   		$product_variation_id = base64_decode($_POST['product_variation_id']);
   		$shipping_address_id = $_POST['shipmentAddress'];
   		$shipping_method = $_POST['shipping_method'];

   		$shipping_addresessData = $this->common_model->get_row('shipping_addresess', array('user_id'=>user_id(), 'shipping_address_id'=>$shipping_address_id));
		if(!empty($shipping_addresessData)){

			$country = getData('countries',array('id',$shipping_addresessData->country))->name;
            $state = getData('states',array('id',$shipping_addresessData->state))->name;
            $city = getData('cities',array('id',$shipping_addresessData->city))->name;
            $yourAddress = $shipping_addresessData->address.', <b>'.$city.'</b>, '.$state.', '.$country;

            $product_variationsData = $this->common_model->get_row('product_variations', array('product_variation_id'=>$product_variation_id), array('shipment_rate_type','shipment_rate_id'));
			if(!empty($product_variationsData)){
				if($product_variationsData->shipment_rate_type!='' && $product_variationsData->shipment_rate_type!=0){

					$shippingCharges = shipping_charges($product_variation_id, $shipping_addresessData->country, $shipping_addresessData->state, $shipping_addresessData->city, $shipping_method);

					$shipmentData .= "<span class='guaranteed-title'>Guaranteed</span><span class=''> Delivery to ".$yourAddress." <br><div class=''>";
						if($product_variationsData->shipment_rate_type==1){
	                      	$shipmentData .= "( FREE Delivery )";
	                   	}else if(($product_variationsData->shipment_rate_type==2 || $product_variationsData->shipment_rate_type==3) && !empty($shippingCharges)){
	                      	if(!empty($shippingCharges) && $shippingCharges!=0.00 && $shippingCharges!=0){
	                      		foreach ($shippingCharges as $key => $value) {
		                        	$shipmentData .= '<div class="shipping-method"><div class="title">'.str_replace("_"," ",$key).' - </div><div class="shipping-method-info">Will charge $'.number_format($value->price, 2).' and delivered within <strong>'.$value->min_day.' - '.$value->max_day.' business days.</strong></div></div>';
		                    	}
	                      	}else{
	                      		$shipmentData .= ' ( Not available for delivery at your location )';
	                      	}
	                   	}else{
	                      	$shipmentData .= ' ( Not available for delivery at your location )';
	                   	}
                   	$shipmentData .= "</div></span>";

					echo json_encode(array('status'=> 'success', 'type'=>$product_variationsData->shipment_rate_type, 'data'=>$shipmentData, 'yourAddress'=>$yourAddress), JSON_NUMERIC_CHECK);

				}else{
					$shipmentData .= "<span> Delivery to ".$yourAddress.". <br><b> ( Not available for delivery at your location )</b></span>";
					echo json_encode(array('status'=> 'success', 'type'=>1, 'data'=>$shipmentData, 'yourAddress'=>$yourAddress), JSON_NUMERIC_CHECK);
				}
			}else{
				$shipmentData .= "<span> Delivery to ".$yourAddress.". <br><b> ( Not available for delivery at your location )</b></span>";
				echo json_encode(array('status'=> 'failed', 'type'=>'', 'data'=>$shippingCharges, 'yourAddress'=>$yourAddress) ,JSON_NUMERIC_CHECK);
			}
		}else{
			echo json_encode(array('status'=> 'failed', 'type'=>'', 'data'=>$shippingCharges, 'yourAddress'=>$yourAddress) ,JSON_NUMERIC_CHECK);
		}
   	}


}
