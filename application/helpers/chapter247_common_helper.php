<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*	clear cache
*/
if ( ! function_exists('clear_cache')) {
	function clear_cache(){
		$CI =& get_instance();
		$CI->output->set_header('Expires: Wed, 11 Jan 1984 05:00:00 GMT' );
		$CI->output->set_header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . 'GMT');
		$CI->output->set_header("Cache-Control: no-cache, no-store, must-revalidate");
		$CI->output->set_header("Pragma: no-cache");			
	}
}



if ( ! function_exists('backend_pagination')) {
	function backend_pagination(){
		$data = array();		
		$data['full_tag_open'] = '<ul class="pagination">';		
		$data['full_tag_close'] = '</ul>';
		$data['first_tag_open'] = '<li>';
		$data['first_tag_close'] = '</li>';
		$data['num_tag_open'] = '<li>';
		$data['num_tag_close'] = '</li>';
		$data['last_tag_open'] = '<li>';
		$data['last_tag_close'] = '</li>';
		$data['next_tag_open'] = '<li>';
		$data['next_tag_close'] = '</li>';
		$data['prev_tag_open'] = '<li>';
		$data['prev_tag_close'] = '</li>';
		$data['cur_tag_open'] = '<li class="active"><a href="#">';
		$data['cur_tag_close'] = '</a></li>';
		return $data;
	}					
}

/**
*	thisis  back end helper 
*/
if ( ! function_exists('msg_alert')) {
	function msg_alert(){
	$CI =& get_instance(); ?>
<?php if($CI->session->flashdata('msg_success')): ?>	
	<script>
		$('.notifyjs-corner').empty();
		/*$.notify("<?php //echo $CI->session->flashdata('msg_success'); ?>", "success");*/
	
		$.notify({
			icon: "<?php echo base_url(); ?>/assets/backend/image/alert-icons/alert-checked.svg",
			title: "<strong>Success</strong> ",
			message: "<?php echo $CI->session->flashdata('msg_success'); ?>"			
		},{
			icon_type: 'image',
			type: 'success',
			allow_duplicates: false
		});

	</script>
 <?php endif; ?>
<?php if($CI->session->flashdata('msg_info')): ?>	
	<script>
		$('.notifyjs-corner').empty();
		/*$.notify("<?php //echo $CI->session->flashdata('msg_info'); ?>", "info");*/

		$.notify({
			icon: "<?php echo base_url(); ?>/assets/backend/image/alert-icons/alert-checked.svg",
			title: "<strong>Info</strong> ",
			message: "<?php echo $CI->session->flashdata('msg_info'); ?>"			
		},{
			icon_type: 'image',
			type: 'success',
			allow_duplicates: false
		});

	</script>
<?php endif; ?>
<?php if($CI->session->flashdata('msg_warning')): ?>	
	<script>
		$('.notifyjs-corner').empty();
		/*$.notify("<?php //echo $CI->session->flashdata('msg_warning'); ?>", "warn");*/

		$.notify({
			icon: "<?php echo base_url(); ?>/assets/backend/image/alert-icons/alert-danger.svg",
			title: "<strong>Warning</strong> ",
			message: "<?php echo $CI->session->flashdata('msg_warning'); ?>"

		},{
			icon_type: 'image',
			type: 'warning',
			allow_duplicates: false
		});


	</script>
<?php endif; ?>
<?php if($CI->session->flashdata('msg_error')): ?>	
	<script>
		$('.notifyjs-corner').empty();	
		$.notify({
			icon: "<?php echo base_url(); ?>/assets/backend/image/alert-icons/alert-disabled.svg",
			title: "<strong>Error</strong> ",
			message: "<?php echo $CI->session->flashdata('msg_error'); ?>"

		},{
			icon_type: 'image',
			type: 'danger',
			allow_duplicates: false
		});
	 </script>
<?php endif; ?>
	<?php }					
}

/**
*	check Customer logged in
*/

if ( ! function_exists('site_access')) {
	function site_access(){
		$CI =& get_instance();
		$site_access = $CI->session->userdata('site_access');
		if($site_access['logged_in']===TRUE)
			return TRUE;
		else
			return FALSE;
	}
}

if ( ! function_exists('user_logged_in')) {
	function user_logged_in(){
		$CI =& get_instance();
		$user_info = $CI->session->userdata('user_info');
		if($user_info['logged_in']===TRUE && $user_info['user_role'] == 2)
			return TRUE;
		else
			return FALSE;
	}
}
/**
*	check seller logged in
*/
if ( ! function_exists('seller_logged_in')) {
	function seller_logged_in(){
		$CI =& get_instance();
		$seller_info = $CI->session->userdata('seller_info');
		if($seller_info['logged_in']===TRUE && $seller_info['user_role'] == 1 )
			return TRUE;
		else
			return FALSE;
	}
}
/**
*	check superadmin logged in
*/
if ( ! function_exists('superadmin_logged_in')) {
	function superadmin_logged_in(){
		$CI =& get_instance();
		$superadmin_info = $CI->session->userdata('superadmin_info');
		if($superadmin_info['logged_in']===TRUE && $superadmin_info['user_role'] == 0 )
			return TRUE;
		else
			return FALSE;
	}
}
/**
*	get Customer id
*/
if ( ! function_exists('user_id')) {
	function user_id(){
		$CI =& get_instance();
		$user_info = $CI->session->userdata('user_info');		
			return $user_info['id'];		
	}
}
/**
*	get seller id
*/
if ( ! function_exists('seller_id')) {
	function seller_id(){
		$CI =& get_instance();
		$seller_info = $CI->session->userdata('seller_info');		
			return $seller_info['id'];		
	}
}
/**
*	get superadmin id
*/
if ( ! function_exists('superadmin_id')) {
	function superadmin_id(){
		$CI =& get_instance();
		$superadmin_info = $CI->session->userdata('superadmin_info');		
			return $superadmin_info['id'];		
	}
}
/**
*	get Customer Full Name
*/
if ( ! function_exists('user_name')) { 
	function user_name(){
		$CI =& get_instance();
		$user_info = $CI->session->userdata('user_info');
		if($user_info['logged_in']===TRUE)
		 	return $user_info['user_name'];
		else
			return FALSE;
	}					
}
/**
*	get Seller Full Name
*/
if ( ! function_exists('selleradmin_name')) { 
	function selleradmin_name(){
		$CI =& get_instance();
		$seller_info = $CI->session->userdata('seller_info');
		if($seller_info['logged_in']===TRUE )
		 	return $seller_info['user_name'];
		else
			return FALSE;
	}					
}
/**
*	get Superadmin Full Name
*/
if ( ! function_exists('superadmin_name')) { 
	function superadmin_name(){
		$CI =& get_instance();
		$superadmin_info = $CI->session->userdata('superadmin_info');
		if($superadmin_info['logged_in']===TRUE )
		 	return $superadmin_info['first_name']." ".$superadmin_info['last_name'];
		else
			return FALSE;
	}					
}

if ( ! function_exists('user_email')) { 
	function user_email(){
		$CI =& get_instance();
		$user_info = $CI->session->userdata('user_info');
		if($user_info['logged_in']===TRUE)
		 	return $user_info['email'];
		else
			return FALSE;
	}					
}


if ( ! function_exists('user_mobile')) { 
	function user_mobile(){
		$CI =& get_instance();
		$user_info = $CI->session->userdata('user_info');
		if($user_info['logged_in']===TRUE)
		 	return $user_info['mobile'];
		else
			return FALSE;
	}					
}

if ( ! function_exists('user_countrycode')) { 
	function user_countrycode(){
		$CI =& get_instance();
		$user_info = $CI->session->userdata('user_info');
		if($user_info['logged_in']===TRUE)
		 	return $user_info['country_code'];
		else
			return FALSE;
	}					
}

/*****================================================******/

if ( ! function_exists('seller_email')) { 
	function seller_email(){
		$CI =& get_instance();
		$seller_info = $CI->session->userdata('seller_info');
		if($seller_info['logged_in']===TRUE)
		 	return $seller_info['email'];
		else
			return FALSE;
	}					
}


if ( ! function_exists('seller_mobile')) { 
	function seller_mobile(){
		$CI =& get_instance();
		$seller_info = $CI->session->userdata('seller_info');
		if($seller_info['logged_in']===TRUE)
		 	return $seller_info['mobile'];
		else
			return FALSE;
	}					
}

if ( ! function_exists('seller_countrycode')) { 
	function seller_countrycode(){
		$CI =& get_instance();
		$seller_info = $CI->session->userdata('seller_info');
		if($seller_info['logged_in']===TRUE)
		 	return $seller_info['country_code'];
		else
			return FALSE;
	}					
}

/**
*	frontend pagination
*/
if ( ! function_exists('frontend_pagination')) {
	function frontend_pagination(){
		$data = array();
		$data['full_tag_open'] = '<ul class="pagination">';		
		$data['full_tag_close'] = '</ul>';
		$data['first_tag_open'] = '<li>';
		$data['first_tag_close'] = '</li>';
		$data['num_tag_open'] = '<li>';
		$data['num_tag_close'] = '</li>';
		$data['last_tag_open'] = '<li>';		
		$data['last_tag_close'] = '</li>';
		$data['next_tag_open'] = '<li>';
		$data['next_tag_close'] = '</li>';
		$data['prev_tag_open'] = '<li>';
		$data['prev_tag_close'] = '</li>';
		$data['cur_tag_open'] = '<li class="active"><a href="#">';
		$data['cur_tag_close'] = '</a></li>';
		$data['next_link'] = 'Next';
		$data['prev_link'] = 'Previous';
		return $data;
	}					
}

/**
*	thisis  back end helper 
*/
if ( ! function_exists('msg_alert_front')) {
	function msg_alert_front(){
	$CI =& get_instance(); ?>
	<?php if($CI->session->flashdata('theme_danger')): ?>	
	<div class="alert theme-alert-danger">
		 <button type="button" class="close" data-dismiss="alert">&times;</button>
	     <!-- <strong>Success :</strong> <br> --> <?php echo $CI->session->flashdata('theme_danger'); ?>
	</div>
 <?php endif; ?>
 <?php if($CI->session->flashdata('theme_success')): ?>	
	<div class="alert theme-success">
		 <button type="button" class="close" data-dismiss="alert">&times;</button>
	     <!-- <strong>Success :</strong> <br> --> <?php echo $CI->session->flashdata('theme_success'); ?>
	</div>
 <?php endif; ?>

<?php if($CI->session->flashdata('msg_success')): ?>	
	<div class="alert alert-success">
		 <button type="button" class="close" data-dismiss="alert">&times;</button>
	     <!-- <strong>Success :</strong> <br> --> <?php echo $CI->session->flashdata('msg_success'); ?>
	</div>
 <?php endif; ?>
<?php if($CI->session->flashdata('msg_info')): ?>	
	<div class="alert alert-info">
		<button type="button" class="close" data-dismiss="alert">&times;</button> 
	    <!-- <strong>Info :</strong> <br> --> <?php echo $CI->session->flashdata('msg_info'); ?>
	</div>
<?php endif; ?>
<?php if($CI->session->flashdata('msg_warning')): ?>	
	<div class="alert alert-warning">
		<!-- <button type="button" class="close" data-dismiss="alert">&times;</button> -->
	   <!--  <strong>Warning :</strong> <br> --> <?php echo $CI->session->flashdata('msg_warning'); ?>
	</div>
<?php endif; ?>
<?php if($CI->session->flashdata('msg_error')): ?>	
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">&times;</button> 
	    <!-- <strong>Error :</strong> <br> --> <?php echo $CI->session->flashdata('msg_error'); ?>
	</div>
<?php endif; ?>
	<?php }					
}
if(!function_exists('p')){
    function p($data){
        echo '<pre>'; print_r($data); echo '</pre>';
     }
}

if ( ! function_exists('get_image_type')) {	
	function get_image_type($status='') {
		$status_array = array(
                            '1' => 'Cover Image',
                            '2' => 'Slider Image',
                            '3' => 'Other',
                             ); 
		return $status_array;
	}
}
/**
*	thumbnail image
*/
if ( ! function_exists('create_thumbnail')) {
	function create_thumbnail($config_img='',$img_fix='') {
		$CI =& get_instance();
		$config_image['image_library'] = 'gd2';
		$config_image['source_image'] = $config_img['source_path'].$config_img['file_name'];	
		//$config_image['create_thumb'] = TRUE;
		$config_image['new_image'] = $config_img['destination_path'].$config_img['file_name'];
		$config_image['height']=$config_img['height'];
		$config_image['width']=$config_img['width'];
		if($img_fix){
		$config_image['maintain_ratio'] = FALSE;
		}
		else{
			$config_image['maintain_ratio'] = TRUE;
			list($width, $height, $type, $attr) = getimagesize($config_img['source_path'].$config_img['file_name']);

	        if ($width < $height) {
	        	$cal=$width/$height;
	        	$config_image['width']=$config_img['width']*$cal;
	        }
			if ($height < $width)
			{
				$cal=$height/$width;
		    	$config_image['height']=$config_img['height']*$cal;
			}
		}
		
		$CI->load->library('image_lib');
		$CI->image_lib->initialize($config_image);
		
		if(!$CI->image_lib->resize()) 
			return array('status'=>FALSE,'error_msg'=>$CI->image_lib->display_errors());
		else
			return array('status'=>TRUE,'file_name'=>$config_img['file_name']);
	}
}
if(!function_exists('user_status')){
	function user_status($status=''){
		$status_array= array(
			'1' => 'Active',
            '2' => 'Deactive',
            '3' => 'Banned',/*
            '4' => 'Pending' */            
			);
		return $status_array;
	 }
}
if(!function_exists('status')){
function status($status=''){
		$status_array= array(
			'1' => 'Active',
            '2' => 'Deactive',           
			);
		return $status_array;
	 }
}
if(!function_exists('getPagelayout')){
	function getPagelayout($status=''){
		$status_array= array(
			'1' => '1 Column',
            '2' => '2 Left-Column',
            '3' => '2 Right Column',
            '4' => '3 Left and Right Column'             
			);
		return $status_array;
	 }
}
if ( ! function_exists('menu_section')) {	
	function menu_section($status='') {
		$status_array = array(
                            '1' => 'POPULAR LINKS',
                            '2' => 'RESOURCES',
                            '3' => 'Short link Section',
                            '4' => 'TOP MENU',
                             ); 
		return $status_array;
	}
}

if ( ! function_exists('menu_section_class')) {	
	function menu_section_class($status='') {
		$status_array = array(
                           '1' => 'POPULAR LINKS',
                            '2' => 'RESOURCES',
                            '3' => 'ABOUT US',
							'4' => 'TOP MENU',
        ); 
		return element($status, $status_array);
	}
}
if ( ! function_exists('menu_section_class')) {	
	function menu_section_class($status='') {
		$status_array = array(
						'1' => 'POPULAR LINKS',
						'2' => 'RESOURCES',
						'3' => 'ABOUT US',
						'4' => 'TOP MENU',
            ); 
		return element($status, $status_array);
	}
}

if ( ! function_exists('menu_section_color')) {	
	function menu_section_color($status='') {
		$status_array = array(
						'1' => 'POPULAR LINKS',
						'2' => 'RESOURCES',
						'3' => 'Short link Section',
						'4' => 'TOP MENU',
                            
                             ); 
		return element($status, $status_array);
	}
}

if ( ! function_exists('getPageCategoryName')) {
    function getPageCategoryName($id,$table_name,$col, $condition_col){
        $CI =& get_instance();
        $data = $CI->common_model->get_row($table_name,array($condition_col=>$id), array($col));
        if($data)
            return $data->$col;
        else
        	return "";	

    }                    
}
if ( ! function_exists('get_product_variation_image')) {
    function get_product_variation_image($id,$colour){
        $CI =& get_instance();
        $CI->load->model('product_model');
        $data = $CI->product_model->get_product_image($id,$colour);
        if($data)
            return $data;
        else
        	return FALSE;	

    }                    
}


if ( ! function_exists('getcategoryDropdownMenu')) {
    function getcategoryDropdownMenu($selected=''){
        $CI =& get_instance();
		$CI->common_model->getCategoryTree($selected,'slug'); 
    }                    
}


if ( ! function_exists('getcategoryDropdown')) {
    function getcategoryDropdown($selected=''){
        $CI =& get_instance();
		$CI->common_model->getCategoryTree($selected); 
    }                    
}
if ( ! function_exists('getCategoryTreeStructure')) {
    function getCategoryTreeStructure($choose=""){
        $CI =& get_instance();
        $getCategoryTreeStructure = $CI->common_model->getCategoryTreeStructure($choose);
        if($getCategoryTreeStructure){
        	return $getCategoryTreeStructure;
        }else{
        	return "No Categories Found";
        }
             

    }                    
}

if ( ! function_exists('file_type')) {	
	function file_type($status='') {

		$status_array = array(
			'1' => 'Input Text Field',
			'2' => 'Text Area',
			'3' => 'Dropdown',
			'4' => 'Checkbox',
			'5' => 'Multiple Select',
			'7' => 'Radio',
			'8' => 'Input Date Field',
			'9' => 'Blank Text Field With Dropdown',
			'10' => 'Dropdown And Text Field With Autocomplete',
        ); 
        if($status)
			return element($status, $status_array);
		else
			return $status_array;
	}
}

if ( ! function_exists('type')) {	
	function type($status='') {

		$status_array = array(
			'1' => 'Product Basic Info',
			'2' => 'Product Other Info',
			'3' => 'Variations',
        ); 
        if($status)
			return element($status, $status_array);
		else
			return $status_array;
	}
}


if ( ! function_exists('product_ID_type')) {	
	function product_ID_type($val='') {

		$product_ID_type_array = array(
			'gtin' => 'GTIN',
			'ean'  => 'EAN',
			'gcid' => 'GCID',
			'upc'  => 'UPC',
			'asin' => 'ASIN',
        ); 
        if($val)
			return element($val, $product_ID_type_array);
		else
			return $product_ID_type_array;
	}
}

if ( ! function_exists('imageFeaturedProduct')) {
    function imageFeaturedProduct($product_info_id=''){
        $CI =& get_instance();
        $data = $CI->common_model->get_row('product_images',array('product_info_id'=>$product_info_id,'featured_image'=>1));
        if($data)
			return $data;
		else
			return "";

    }                    
}

if ( ! function_exists('getSimpleVariationProduct')) {
    function getSimpleVariationProduct($product_info_id=''){
        $CI =& get_instance();
        $data = $CI->common_model->get_row('product_variations',array('product_info_id'=>$product_info_id,'type_of_product'=>1), array());
        if($data)
			return $data;
		else
			return "";

    }                    
}

if ( ! function_exists('getVariationProduct')) {
    function getVariationProduct($product_info_id=''){
        $CI =& get_instance();
        $data = $CI->common_model->get_result('product_variations',array('product_info_id'=>$product_info_id,'type_of_product'=>2), array('product_variation_id'));
        if($data)
			return $data;
		else
			return "";

    }                    
}


if ( ! function_exists('getParVariationProduct')) {
    function getParVariationProduct($product_info_id='', $product_variation_id=''){
        $CI =& get_instance();
        $data = $CI->common_model->get_row('product_variations',array('product_info_id'=>$product_info_id,'product_variation_id'=>$product_variation_id,'type_of_product'=>2));
        if($data)
			return $data;
		else
			return "";

    }                    
}


if ( ! function_exists('productExist')) {
    function productExist($product_info_id=''){
        $CI =& get_instance();
        $data = $CI->common_model->get_row('product_variations',array('product_info_id'=>$product_info_id),array('product_variation_id'));
        if($data)
			return $data;
		else
			return "";

    }                    
}


if ( ! function_exists('product_variation_info')) {
	function product_variation_info($product_info_id){	
		$CI =& get_instance();		
		$data = $CI->common_model->get_row('product_variations',array('product_info_id'=>$product_info_id,'type_of_product'=>2));
		if($data)
		 	return $data;
		 else
		 	return false;
	}
}

/* header menu */
if ( ! function_exists('getHeaderMenu')) {
    function getHeaderMenu(){
        $CI =& get_instance();
        $data['category']=$CI->common_model->get_result('category',array('is_menu'=>1,'status'=>1),array('category_id','category_name','category_slug','parent_id'),array('order_by','asc'));
        return  $data;

    }                    
}
if ( ! function_exists('getMegamenu')) {
    function getMegamenu($parent_id=''){
        $CI =& get_instance();
        if($query = $CI->common_model->get_result('category',array('parent_id'=>$parent_id,'status'=>1),array('category_id','category_name','category_slug','menu_icon','menu_image','menu_image','(select count(category_id) from category as c where c.parent_id=category.category_id) as subCategory'),array('category_name','asc')))
        	return $query;
        else 
        	return false;
      

    }                    
}
if ( ! function_exists('get_page_content')) {
	function get_page_content($page_id){	
		$CI =& get_instance();		
		 if($query = $CI->common_model->get_row('pages', array('page_id'=>$page_id)))
		 	return $query;
		 else
		 	return false;
	}
}
if ( ! function_exists('get_option_url')) {
	function get_option_url($option_name){	
		$CI =& get_instance();		
		 if($query = $CI->common_model->get_row('options',array('option_name'=>$option_name)))
		 	return $query->option_value;
		 else
		 	return false;
	}
}
if ( ! function_exists('get_category_bread_crumb')) {
	function get_category_bread_crumb($category_id=0,$category=array()){
		$CI =& get_instance();
		$query = $CI->common_model->get_row('category',array('category_id'=>$category_id),array('category_id','parent_id','category_name'));		
		if($query)
		{
			$category[]='<li><a href="'.base_url('backend/category/index/'.$query->category_id).'"> '.$query->category_name.' </a></li>';
			$category= get_category_bread_crumb($query->parent_id,$category);	
		}
			return $category;		
	}
}
if ( ! function_exists('get_category_bread_crumb_front')) {
	function get_category_bread_crumb_front($category_id=0,$category=array()){
		$CI =& get_instance();
		$query = $CI->common_model->get_row('category',array('category_id'=>$category_id),array('category_id','parent_id','category_name','category_slug'));		
		if($query)
		{
			$category[]='<a href="'.base_url('p/'.$query->category_slug).'"> '.$query->category_name.' </a>';
			$category= get_category_bread_crumb_front($query->parent_id,$category);	
		}
			return $category;		
	}
}
if ( ! function_exists('get_category_bread_crumb_seller')) {
	function get_category_bread_crumb_seller($category_id=0,$category=array()){
		$CI =& get_instance();
		$query = $CI->common_model->get_row('category',array('category_id'=>$category_id),array('category_id','parent_id','category_name','category_slug'));		
		if($query)
		{
			$category[]=ucfirst($query->category_name);
			$category= get_category_bread_crumb_seller($query->parent_id,$category);	
		}
			return $category;		
	}
}

if ( ! function_exists('getAttributeInfoUsingCat')) {
	function getAttributeInfoUsingCat($category_id='',$attr=''){
		$CI =& get_instance();
		$query = $CI->common_model->getAttributeInfoUsingCat($category_id,$attr);		
		if($query)
			return $query;
		else		
			return "";
	}
}

if ( ! function_exists('getOfferavailable')) {
	function getOfferavailable($product_variation_id=''){
		$CI =& get_instance();
		$CI->load->model('product_model');
		$query = $CI->product_model->getOfferavailable($product_variation_id);		
		if($query)
			return $query;
		else		
			return array();
	}
}


if ( ! function_exists('users_list')) {
	function users_list($user_role=''){
		$CI =& get_instance();
		$query = $CI->common_model->get_result('users', array('user_role' => $user_role, 'status' => 1),'',array('user_name', 'ASC'));		
		if($query)
			return $query;
		else		
			return array();
	}
}


if ( ! function_exists('get_NameUsingID')) {
	function get_NameUsingID($user_id=''){
		$CI =& get_instance();
		$query = $CI->common_model->get_row('users', array('user_id' => $user_id));		
		if($query)
			return $query->user_name;
		else		
			return '';
	}
}


if ( ! function_exists('getFeaturedImage')) {
	function getFeaturedImage($product_info_id='', $product_variation_id=''){
		$CI =& get_instance();
		$query = $CI->common_model->get_row('product_images', array('product_info_id' => $product_info_id, 'product_variation_id' => $product_variation_id), array('image'), array('featured_image', 'desc'));		
		if($query)
			return $query->image;
		else		
			return '';
	}
}


if ( ! function_exists('getData')) {
	function getData($table='', $data=''){
		$CI =& get_instance();
		$query = $CI->common_model->get_row($table, array($data[0] => $data[1]));		
		if($query)
			return $query;
		else		
			return '';
	}
}


if ( ! function_exists('getRow')) {
	function getRow($table='', $data='', $col=''){
		$CI =& get_instance();
		$query = $CI->common_model->get_row($table, $data, $col);		
		if($query)
			return $query;
		else		
			return '';
	}
}


if ( ! function_exists('getDataResult')) {
	function getDataResult($table='', $data=''){
		$CI =& get_instance();
		$query = $CI->common_model->get_result($table, $data);		
		if($query)
			return $query;
		else		
			return '';
	}
}


/* get varication*/
if ( ! function_exists('get_attribute_variation')) {
	function get_attribute_variation($attribute_code=''){
		$CI =& get_instance();
		return $CI->common_model->get_attributes($attribute_code);		
	}
}

/* get Commision Fee Using Category*/
if ( ! function_exists('getCommisionFeeUsingCat')) {
	function getCommisionFeeUsingCat($cat=''){
		$CI =& get_instance();
		$res = $CI->common_model->get_row('category',array('category_id'=>$cat),array('commision'));	
		if(!empty($res->commision) && $res->commision!='' && $res->commision!='0')
			return $res->commision;
		else		
			return "";
	}
}

if ( ! function_exists('getsubcategory')) {
	function getsubcategory($id=''){
		$CI =& get_instance();
		$query = $CI->common_model->get_result('category', array('parent_id' => $id, 'status'=>1),'',array('category_name','ASC'));		
		if($query)
			return $query;
		else		
			return array();
	}
}


if ( ! function_exists('get_hirarchicalSubCatUsingCategory')) {
	function get_hirarchicalSubCatUsingCategory($id=''){
		$CI =& get_instance();
		$CI->load->model('seller_model');
		$query = $CI->seller_model->get_hirarchicalSubCatUsingCategory($id);		
		if($query)
			return $query;
		else		
			return array();
	}
}

if ( ! function_exists('getProductFrom')) {
	function getProductFrom($val=''){

		$getProductFrom = array(
			'1' => 'I manufacture them',
			'2'  => 'I sell products manufactured from me',
			'3' => 'I resell product that I buy',
			'4'  => 'I import them'
        ); 
        if($val)
			return element($val, $getProductFrom);
		else
			return $getProductFrom;
	}
}


if ( ! function_exists('annual_turnover')) {
	function annual_turnover($val=''){

		$annual_turnover = array(
			'Less than 1 Lakh' => 'Less than 1 Lakh',
			'Between 1 Lakh and 10 Lakh'  => 'Between 1 Lakh and 10 Lakh',
			'Between 1 Lakh and 1 Crore' => 'Between 1 Lakh and 1 Crore',
			'More than 1 Crore'  => 'More than 1 Crore',
			'I don\'t know'  => 'I don\'t know'
        ); 
        if($val)
			return element($val, $annual_turnover);
		else
			return $annual_turnover;
	}
}


if ( ! function_exists('how_much_do_you_sell')) {
	function how_much_do_you_sell($val=''){

		$how_much_do_you_sell = array(
			'1 to 10' => '1 to 10',
			'11 to 100'  => '11 to 100',
			'101 to 500' => '101 to 500',
			'More than 500'  => 'More than 500',
			'I don\'t know'  => 'I don\'t know'
        ); 
        if($val)
			return element($val, $how_much_do_you_sell);
		else
			return $how_much_do_you_sell;
	}
}

if ( ! function_exists('proof_of_name_and_dob')) {
	function proof_of_name_and_dob($val=''){

		$proof_of_name_and_dob = array(
			'1' => 'Passport',
			'2' => 'Driving Licence',
			'3' => 'Government Issued Identity Card'
        ); 
        if($val)
			return element($val, $proof_of_name_and_dob);
		else
			return $proof_of_name_and_dob;
	}
}


if ( ! function_exists('paymentMethod')) {
	function paymentMethod($val=''){

		$paymentMethod = array(
			'1' => 'Paypal',
			'2' => 'Stripe'
        ); 
        if($val)
			return '0';
		else
			return $paymentMethod;
	}
}


if ( ! function_exists('proof_of_address')) {
	function proof_of_address($val=''){

		$proof_of_address = array(
			'1' => 'Utility Bill e.g. Electricity, Gas, Water, Landline phone bill',
			'2' => 'Bank Statement',
			'3' => 'House/Health/Motor insurance policy document',
			'4' => 'Government stamped tax assessment notice',
			'5' => 'Council rates notice/ council tax bill (If account verification is successful than public user profile and all of the seller\'s listings will show our new Verified icon)'
        ); 
        if($val)
			return element($val, $proof_of_address);
		else
			return $proof_of_address;
	}
}
/* get rating list */
if (!function_exists('getratingList')) {
	function getratingList($id=''){
		$CI =& get_instance();
		$join=array(
			array(
				'table'=>'users as u',
				'condition'=>'u.user_id=pr.user_id',
				'type'=>'inner',
			),
		);
		$query = $CI->common_model->get_result_pagination('product_review as pr', array('pr.product_variation_id' =>$id, 'pr.status'=>1),array('pr.user_id','pr.rating','pr.description','pr.created_at','u.user_name'),array('pr.created_at','desc'),$join,0,10);		
		if($query)
			return $query;
		else		
			return array();
	}
}
/* end of rating list */

if ( ! function_exists('getAccessToken')) {
    function getAccessToken($id=''){
        $CI =& get_instance();
        $data = $CI->common_model->getAccessToken($id);
        return $data;	
    }                    
}


if ( ! function_exists('shippingRate_Cols')) {
	function shippingRate_Cols($data=''){
		$CI =& get_instance();
		$query = $CI->common_model->shippingRate_Cols($data);
        if($query)
			return $query;
		else
			return array();
	}
}


if ( ! function_exists('shipping_charges')) {
	function shipping_charges($productVariationID ='', $country='', $state='', $city=''){
		$CI =& get_instance();
		$query = $CI->common_model->shipping_charges($productVariationID, $country, $state, $city);		
		if($query)
			return $query;
		else		
			return '0.00';
	}
}

if ( ! function_exists('getOrderNamePrice')) {
	function getOrderNamePrice($orderDetailsIDs =''){
		$CI =& get_instance();
		$query = $CI->common_model->getOrderNamePrice($orderDetailsIDs);	
		if($query)
			return $query;
		else		
			return '-';
	}
}


if (!function_exists('feedback_subject_status')) {

    function feedback_subject_status($status = '') {
        $status_array = array(
            '1' => 'General Inquiries',
            '2' => 'Available any Advertisement options',
            '3' => 'Product Suggestion',
            '4' => 'Other'
        );
        if ($status == '')
            return $status_array;
        else
            return element($status, $status_array);
    }

}

if ( ! function_exists('get_unread_msg')) {
	function get_unread_msg($message_id='',$user_id=''){	
		$CI =& get_instance();		
		 if($query = $CI->common_model->get_unread_msg($message_id,$user_id))
		 	return $query;
		 else
		 	return false;
	} 
}

if ( ! function_exists('get_unread_msg_superadmin')) {
	function get_unread_msg_superadmin($message_id=''){	
		$CI =& get_instance();		
		 if($query = $CI->superadmin_model->get_unread_msg($message_id))
		 	return $query;
		 else
		 	return false;
	}
}


if ( ! function_exists('getShippingUsingIP')) {
	function getShippingUsingIP($product_variation_id='', $shippingAddressID=''){	
		$CI =& get_instance();		
		 if($result = $CI->common_model->getShippingUsingIP($product_variation_id, $shippingAddressID))
		 	return $result;
		 else
		 	return false;
	}
}


if ( ! function_exists('getCatgoryNames')) {
	function getCatgoryNames($cats=''){	
		$CI =& get_instance();		
		if($query = $CI->common_model->getCatgoryNames($cats)){
			return $query;
		}else{
		 	return "";
		}
	} 
}


if ( ! function_exists('orderStatusMsg')) {	
	function orderStatusMsg($status='') {

		$status_array = array(
			'1' => 'You have a new order',
			'2' => 'Order is in processed',
			'3' => 'Order\'s dispatch has been confirmed',
			'4' => 'Order has been delivered, Admin\'s approvel is pending',
			'5' => 'Order has been cancelled',
			'6' => 'Order has been returned',
			
        ); 
        if($status)
			return element($status, $status_array);
		else
			return $status_array;
	}
}


if ( ! function_exists('orderStatusMsg1')) {	
	function orderStatusMsg1($status='') {

		$status_array = array(
			'1' => 'You have a new order',
			'2' => 'Order is in processed',
			'3' => 'Order\'s dispatch has been confirmed',
			'4' => 'Order has been delivered',
			'5' => 'Order has been cancelled',
			'6' => 'Order has been returned',
			
        ); 
        if($status)
			return element($status, $status_array);
		else
			return $status_array;
	}
}


if ( ! function_exists('orderStatusPages')) {	
	function orderStatusPages($status='') {

		$status_array = array(
			'1' => 'Unshipped',
			'3' => 'Confirm Dispatch',
			'4' => 'Order Completed',
			'5' => 'Order Cancelled',
			'6' => 'Order Returned'
			
        ); 
        if($status)
			return element($status, $status_array);
		else
			return $status_array;
	}
}


if ( ! function_exists('orderStatus')) {	
	function orderStatus($status='') {

		$status_array = array(
			'1' => 'Unshipped',
			'3' => 'Confirm Dispatch',
			'4' => 'Order Completed',
			'5' => 'Order Cancelled',
			'6' => 'Order Returned'
        ); 
        if($status)
			return element($status, $status_array);
		else
			return $status_array;
	}
}
	

if ( ! function_exists('orderStatusName')) {	
	function orderStatusName($status='') {

		$status_array = array(
			'1' => 'Unshipped',
			'3' => 'Confirm Dispatch',
			'4' => 'Order Completed',
			'5' => 'Order Cancelled',
			'6' => 'Order Returned'
        ); 
        if($status)
			return element($status, $status_array);
		else
			return $status_array;
	}
}


if ( ! function_exists('orderStatusDD')) {	
	function orderStatusDD($status='') {

		$status_array = array(
			'1' => 'Unshipped Orders',
			'3' => 'ConfirmDispatch Orders',
			'4' => 'Completed Orders',
			'5' => 'Cancelled Orders',
			'6' => 'Returned Orders'
        ); 
        if($status)
			return element($status, $status_array);
		else
			return $status_array;
	}
}


if ( ! function_exists('orderStatuscls')) {	
	function orderStatuscls($status='') {

		$status_array = array(
			'1' => 'primary',
			'3' => 'warning',
			'4' => 'success',
			'5' => 'danger',
			'6' => 'default'
        ); 
        if($status)
			return element($status, $status_array);
		else
			return $status_array;
	}
}


if ( ! function_exists('orderCancellationReason')) {	
	function orderCancellationReason($reason='') {

		$reason_array = array(
			'1' => 'Order Created by Mistake',
			'2' => 'Item(s) Would Not Arrive on Time',
			'3' => 'Shipping Cost Too High',
			'4' => 'Item Price Too High',
			'5' => 'Other'
        ); 
        if($reason)
			return element($reason, $reason_array);
		else
			return $reason_array;
	}
}


if ( ! function_exists('orderReturnReason')) {	
	function orderReturnReason($reason='') {

		$reason_array = array(
			'1' => 'Product Didn’t Match the Website Or Catalog Description',
			'2' => 'Excessive Amount',
			'3' => 'Found Better Product Price Elsewhere',
			'4' => 'Buying A Product During Holiday Season',
			'4' => 'Product Did Not Meet Customer Expectations',
			'6' => 'Other'
        ); 
        if($reason)
			return element($reason, $reason_array);
		else
			return $reason_array;
	}
}


if ( ! function_exists('getCurrency')) {	
	function getCurrency($type='') {

		$array = array(
			'1' => 'ethereum',
			'2' => 'bitcoin',
			'3' => 'dollor'
        ); 
        if($type)
			return element($type, $array);
		else
			return $array;
	}
}


if ( ! function_exists('getCurrencyIcon')) {	
	function getCurrencyIcon($type='') {

		$array = array(
			'1' => '<i class="cf cf-eth"></i>',
			'2' => '<i class="cf cf-btc"></i>',
			'3' => '<i class="fa fa-dollar"></i>'
        ); 
        if($type)
			return element($type, $array);
		else
			return $array;
	}
}


if ( ! function_exists('orderCount_with_status')) {	
	function orderCount_with_status($seller_id='', $order_status='') {
		if($seller_id)  $seller_id_get=$seller_id;else $seller_id_get='';

		$CI =& get_instance();
		$query = $CI->common_model->get_row('order_details', array('seller_id' => $seller_id_get, 'order_status'=>$order_status),array('count(DISTINCT order_detail_id) as total_items'));		
		if($query)
			return $query->total_items;
		else		
			return "0";
	}
}

if ( ! function_exists('orderCount_with_status_admin')) {	
	function orderCount_with_status_admin($order_status='') {
		$CI =& get_instance();
		$query = $CI->common_model->get_row('order_details', array('order_status'=>$order_status),array('count(DISTINCT order_detail_id) as total_items'));		
		if($query)
			return $query->total_items;
		else		
			return "0";
	}
}


if ( ! function_exists('typeOfProducts')) {	
	function typeOfProducts($seller_id='', $type_of_product='', $product_page='') {

		$CI =& get_instance();		
		if($result = $CI->common_model->typeOfProducts($seller_id, $type_of_product, $product_page))
		 	return count($result);
		else
		 	return "0";
	}
}



if ( ! function_exists('getAutoSearchKeywords')) {	
	function getAutoSearchKeywords() {

		$CI =& get_instance();		
		if($result = $CI->common_model->getAutoSearchKeywords())
		 	return $result;
		else
		 	return array();
	}
}
if ( ! function_exists('getorderId')) {	
	function getorderId($user_id='') {
		$CI =& get_instance();		
		if($result = $CI->common_model->get_order_id($user_id))
		 	return $result;
		else
		 	return array();
	}
}

if ( ! function_exists('getFeePreviewDetails')) {	
	function getFeePreviewDetails($seller_id='', $user_role='', $order_detail_id='') {

		$CI =& get_instance();		
		if($result = $CI->common_model->getFeePreviewDetails($seller_id, $user_role, $order_detail_id))
		 	return $result;
		else
		 	return array();
	}
}


if ( ! function_exists('sendEmail')) {	
	function sendEmail($email_template='', $to='', $param='', $userRole='') {

		$CI =& get_instance();
		ini_set('smtp_port',25);
		if($userRole==0){
			$var_template_subject       = 'template_subject_admin';
        	$var_template_body          = 'template_body_admin';
		}else{
			$var_template_subject       = 'template_subject';
        	$var_template_body          = 'template_body';
		}		

        $CI->load->library('chapter247_email');
    	if(!empty($email_template->$var_template_subject) && !empty($email_template->$var_template_body) && !empty($to)){
    		
    		$html = array();
	        $html['email_message'] = $email_template->$var_template_body;
	        $html = $CI->load->view('templates/email/email_template', $html, true);
	        $param = array(
	                'template'  =>  array(
	                            'temp'      => $html,
	                            'var_name'  => $param, 
	                            ),            
	                'email' =>  array(
	                      'to'        =>    $to,
	                      'from'      =>    NO_REPLY_EMAIL,
	                      'from_name' =>    NO_REPLY_EMAIL_FROM_NAME,
	                      'subject'   =>    $email_template->$var_template_subject
	                )
	        );
	        $CI->chapter247_email->send_mail($param);
	        //echo $CI->email->print_debugger(); die;
    	}
        return true;
	}
}


if ( ! function_exists('sendSMS')) {	
	function sendSMS($email_template='', $to='', $param='', $userRole='') {
		if(!empty($email_template) && !empty($to) && !empty($param)){
			$CI =& get_instance();
			$senderID = senderID;
			$mobile = $to;
			$authkey = authkeyForSMS;

			if($userRole==0){
	        	$var_template_body          = 'template_sms_body_admin';
			}else{
	        	$var_template_body          = 'template_sms_body';
			}	

			$message = $var_template_body;

			$apiLink = "http://api.msg91.com/api/sendhttp.php?sender=".$senderID."&route=4&mobiles=".$mobile."&authkey=".$authkey."&encrypt=&country=0&message=".$message;

	        $response = file_get_contents($apiLink);
			if(!empty($response)){
			  return $response;
			}else{
			  return "";
			}
		}
	}
}


if ( ! function_exists('getCryptocurrencyRate')) {	
	function getCryptocurrencyRate($curreny='') {
		$curreny = (explode("-", $curreny));
		if(!empty($curreny)){
			$from = strtoupper($curreny[0]);
			$to   = strtoupper($curreny[1]);

			$rate = json_decode(file_get_contents('https://min-api.cryptocompare.com/data/pricemulti?fsyms='.$from.'&tsyms='.$to.''));
	        if(!empty($rate)){
				return $rate->$from->$to;
	        }else{
				return 1;
			}
		}
	}
}


