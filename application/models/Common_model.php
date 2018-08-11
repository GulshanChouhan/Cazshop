<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Common_model extends CI_Model {	
	public function insert($table_name='',  $data=''){
		$query=$this->db->insert($table_name, $data);
		
		if($query)
			return $this->db->insert_id();
		else
			return FALSE;		
	}
	public function get_result_using_findInSet($table_name='', $id_array='',$columns=array(),$order_by=array(),$limit='',$findInSet = array(),$groupBy=''){
		if(!empty($columns)):
			$all_columns = implode(",", $columns);
			$this->db->select($all_columns);
		endif;
		if(!empty($order_by)):
			$this->db->order_by($order_by[0], $order_by[1]);
		endif;
		if(!empty($id_array)):
			foreach ($id_array as $key => $value){
				$this->db->where($key, $value);
			}
		endif;
		if(!empty($limit)):
			$this->db->limit($limit);
		endif;
		if(!empty($findInSet)):
			$where = "FIND_IN_SET('".$findInSet[0]."', ".$findInSet[1].")";  
			$this->db->where($where); 
		endif;
		if(!empty($groupBy)):
			$this->db->group_by($groupBy);
		endif;
		$query=$this->db->get($table_name);
		if($query->num_rows()>0)
			return $query->result();
		else
			return FALSE;
	}
	public function get_result_pagination($table_name='', $id_array='',$columns=array(),$order_by=array(),$join=array(),$offset='',$per_page='',$search=''){
		// print_r($id_array);
		// die;
		if(!empty($columns)):
			$all_columns = implode(",", $columns);
			$this->db->select($all_columns);
		endif;
		if(!empty($order_by)):			
			$this->db->order_by($order_by[0], $order_by[1]);
		endif; 
		if(!empty($id_array)):		
			foreach ($id_array as $key => $value){
				$this->db->where($key, $value);
			}
		endif;	
		if(!empty($join)):		
			foreach ($join as $value){
				$this->db->join($value['table'],$value['condition'],$value['type']);
			}
		endif;	
		if(!empty($search)):
			$all_columns = implode(" and ", $search);
			$this->db->where($all_columns);
		endif;	
		$this->db->from($table_name);
		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			 $query = $this->db->get();
			 if($query->num_rows()>0)
				return $query->result();
			else
				return FALSE;
		}else{
			return $this->db->count_all_results();
		}
	}
	public function get_result($table_name='', $id_array='',$columns=array(),$order_by=array(),$limit='',$custom='',$search=array()){
		if(!empty($columns)):
			$all_columns = implode(",", $columns);
			$this->db->select($all_columns);
		endif;
		if(!empty($order_by)):	
			if(sizeof($order_by)==1)
					$this->db->order_by($order_by[0]);
			else	
				$this->db->order_by($order_by[0], $order_by[1]);
		endif; 
		if(!empty($id_array)):		
			foreach ($id_array as $key => $value){
				$this->db->where($key, $value);
			}
		endif;	
		if(!empty($limit)):	
			$this->db->limit($limit);
		endif;	
		if(!empty($custom)):	
			$this->db->where($custom);
		endif;
		if(!empty($search)):
			$all_columns = implode(" and ", $search);
			$this->db->where($all_columns);
		endif;	
		$query=$this->db->get($table_name);
		if($query->num_rows()>0)
			return $query->result();
		else
			return FALSE;
	}
	public function get_row($table_name='', $id_array='',$columns=array(),$order_by=array()){
		
		if(!empty($columns)):
			$all_columns = implode(",", $columns);
			$this->db->select($all_columns);
		endif; 
		if(!empty($id_array)):		
			foreach ($id_array as $key => $value){
				$this->db->where($key, $value);
			}
		endif;
		if(!empty($order_by)):			
			$this->db->order_by($order_by[0], $order_by[1]);
		endif; 
		$query=$this->db->get($table_name);
		//echo $this->db->last_query();

		if($query->num_rows()>0)
			return $query->row();
		else
			return 0;
			return FALSE;
	}

	public function update($table_name='', $data='', $id_array=''){
		if(!empty($id_array)):
			foreach ($id_array as $key => $value){
				$this->db->where($key, $value);
			}
		endif;
		return $this->db->update($table_name, $data);	
			
	}

	public function delete($table_name='', $id_array=''){		
	 return $this->db->delete($table_name, $id_array);
	}


	public function getCatgoryNames($cats=''){

		$this->db->select('cat.category_name');
		$this->db->where_in('cat.category_id',$cats);
		$this->db->from('category as cat');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$reg = $query->result_array();
			$resultdata = $this->implode_all(',', $reg);
			return $resultdata;
		}else{
			return FALSE;
		}
	}

	function implode_all($glue, $arr){            
	    for ($i=0; $i<count($arr); $i++) {
	        if (@is_array($arr[$i])) 
	            $arr[$i] = $this->implode_all ($glue, $arr[$i]);
	    }            
	    return implode($glue, $arr);
	}

	public function users($role='',$offset='', $per_page=''){
	
		$this->db->select('u.*');
		$this->db->from('users as u');
		if(!empty($_GET)){
			if(!isset($_GET['user_id']) || !isset($_GET['name']) || !isset($_GET['email']) || !isset($_GET['contact']) || !isset($_GET['order'])){
			 		redirect('user');
			}
			if($_GET['user_id']){
			 $this->db->where('u.id', $this->input->get('user_id'));	
			}
			if($_GET['name']){			              
			     $this->db->like('u.user_name',trim($this->input->get('name')),'both');	
			}
		
			if($_GET['email']){
			 $this->db->like('u.email', trim($this->input->get('email')));	
			}

			if($_GET['contact']){
			 $this->db->where('u.mobile', trim($this->input->get('contact')));	
			}
			if($_GET['order']){
			if($this->input->get('order')==2 || $this->input->get('order')==3){
			$order = 'ASC';	
			   }else{
			   	$order = 'DESC';
			   }
			   if($this->input->get('order')==1 || $this->input->get('order')==2){
					$column_name = 'u.id';	
			   }else{
					$column_name = 'u.name';
			   }
			  	 $this->db->order_by($column_name,$order);
			}
		}
		$this->db->where('u.user_role',$role);
		if($offset>=0 && $per_page>0){

			$this->db->limit($per_page,$offset);
			$this->db->order_by('u.id','desc');
			$query = $this->db->get();
			if($query->num_rows()>0)
			return $query->result();
			else
			return FALSE;
		}else{
		
			return $this->db->count_all_results();
		}
	}

	public function password_check($data=''){  
		$query = $this->db->get_where('users',$data);
 		if($query->num_rows()>0)
			return TRUE;
		else{
			//$this->form_validation->set_message('password_check', 'The %s field can not match');
			return FALSE;
		}
	}

	public function get_message_thread($message_id = '', $user_id = '') {
        $this->db->where('user_id', $user_id);
        $this->db->where('support_id', $message_id);
        $this->db->or_where('parent_id', $message_id);
        $this->db->order_by('support_id', 'asc');
        $query = $this->db->get('support');
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return FALSE;
    }

    public function get_unread_msg($message_id = '', $user_id = '') {
        $this->db->where('user_id', $user_id);
        $this->db->where('status', 0);
        $this->db->where('user_role', 2);
        $this->db->where("(`support_id`=" . $message_id . " OR `parent_id`=" . $message_id . ")");

        $query = $this->db->get('support');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return FALSE;
    }
	

    public function get_message_user($message_id = '') {
        $this->db->where('support_id', $message_id);
        $this->db->or_where('parent_id', $message_id);
        $query = $this->db->get('support');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return FALSE;
    }

	public function email_templates($offset='', $per_page='', $search){

		if(!empty($search)):
			$all_columns = implode(" and ", $search);
			$this->db->where($all_columns);
		endif;

		$this->db->from('email_templates');
		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			$this->db->order_by('id','asc');
			$query = $this->db->get();
			if($query->num_rows()>0)
				return $query->result();
			else
				return FALSE;
		}else{
			return $this->db->count_all_results();
		}
	}

	public function get_productresult($offset='',$per_page='',$search=''){
		$this->db->select('(select count(product_variation_id) from product_variations where product_info_id=pi.product_info_id) as totalVariationCount, pi.product_info_id, pi.title, pi.slug, pi.created_at, pv.product_variation_id, pv.status, pv.seller_SKU, pv.product_ID, pv.base_price, pv.sell_price, pv.quantity, pv.type_of_product, pv.seller_id, pv.admin_approvel, pv.commision_fee, pv.shipment_rate_type, pv.shipment_rate_id');

	    if(!empty($search)):
			$all_columns = implode(" and ", $search);
			$this->db->where($all_columns);
		endif;

		$this->db->join('products_info as pi', 'pi.product_info_id = pv.product_info_id','left');
		//$this->db->join('product_images as p_img', 'p_img.product_info_id = pv.product_info_id');
		$this->db->from('product_variations as pv');
		$this->db->group_by('pv.product_info_id');
		$this->db->order_by("product_info_id","desc");
		//$this->db->order_by('p_img.featured_image','desc');

		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			$query = $this->db->get();
			//echo $this->db->last_query(); die;
			if($query->num_rows()>0)
				return $query->result();
			else
				return FALSE;
		}else{
			return $this->db->count_all_results();
		}
	}
	public function get_productresult_export($offset='',$per_page='',$search='', $pageType=""){
		$this->db->select('(select count(product_variation_id) from product_variations where product_info_id=pi.product_info_id) as totalVariationCount, pi.product_info_id, pi.title, pi.slug, pi.created_at, pv.product_variation_id, pv.status, pv.seller_SKU, pv.product_ID, pv.base_price, pv.sell_price, pv.quantity, pv.type_of_product, pv.seller_id, pv.admin_approvel, pv.commision_fee');

	    if(!empty($search)):
			$all_columns = implode(" and ", $search);
			$this->db->where($all_columns);
		endif;

		if($pageType=='inventoryExport'){
			if(isset($_POST) && !empty($_POST)){
				$checkstatus = $_POST['checkstatus'];
				if($checkstatus){
					$this->db->where_in('pi.product_info_id',$checkstatus);
				}
			}
		}	

		$this->db->join('products_info as pi', 'pi.product_info_id = pv.product_info_id','left');
		//$this->db->join('product_images as p_img', 'p_img.product_info_id = pv.product_info_id');
		$this->db->from('product_variations as pv');
		$this->db->group_by('pv.product_info_id');
		$this->db->order_by("product_info_id","desc");
		//$this->db->order_by('p_img.featured_image','desc');

		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			$query = $this->db->get();
			//echo $this->db->last_query(); die;
			if($query->num_rows()>0)
				return $query->result_array();
			else
				return FALSE;
		}else{
			return $this->db->count_all_results();
		}
	}


	public function getSellersFeeStructure($offset='',$per_page='',$search=''){
		$this->db->select('us.user_name, us.user_id, count(od.order_detail_id) as total_orders, IFNULL(sum(od.subtotal), 0.00) as total_amount, ROUND(sum(od.subtotal*od.commision_percentage/100), 2) as fee_preview, ROUND((sum(od.subtotal)-sum(od.subtotal*od.commision_percentage/100)), 2) as pay_to_seller ,IFNULL(sum(ph.paid_amount), 0.00) as paid_amount, ROUND(((sum(od.subtotal)-sum(od.subtotal*od.commision_percentage/100))- IFNULL(sum(ph.paid_amount), 0.00)), 2) as remaining_amount, od.product_details, avg(o.currency_amount_in_bitcoin) as currency_amount_in_bitcoin, avg(o.currency_amount_in_ethereum) as currency_amount_in_ethereum, avg(o.currency_amount_in_dollor) as currency_amount_in_dollor, o.currency_type');

	    if(!empty($search)):
			$all_columns = implode(" and ", $search);
			$this->db->where($all_columns);
		endif;

		$this->db->from('users as us');
		$this->db->join('order_details as od', 'od.seller_id = us.user_id');
		$this->db->join('payout_history as ph', 'ph.order_detail_id = od.order_detail_id','left');
		$this->db->join('orders as o', 'o.o_id = od.order_table_id');
		$this->db->order_by("us.user_name","asc");
		$this->db->where("us.user_role", 1);

		$ignore = array(5, 6);
		$this->db->where_not_in('od.order_status', $ignore);

		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			$query = $this->db->get();
			//echo $this->db->last_query(); die;
			if($query->num_rows()>0)
				return $query->result();
			else
				return FALSE;
		}else{
			return $this->db->count_all_results();
		}
	}

	public function getUsersInfo($userRole='', $offset='',$per_page='',$search=''){
		$this->db->select('us.*');

	    if(!empty($search)):
			$all_columns = implode(" and ", $search);
			$this->db->where($all_columns);
		endif;

		$this->db->from('users as us');
		$this->db->order_by("us.user_id","desc");
		$this->db->where("us.user_role", $userRole);

		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			$query = $this->db->get();
			//echo $this->db->last_query(); die;
			if($query->num_rows()>0)
				return $query->result();
			else
				return FALSE;
		}else{
			return $this->db->count_all_results();
		}
	}


	public function getCats($cats=''){
		$reg = array();
		$this->db->select('cat.category_id');
		$this->db->from('category as cat');
		$this->db->where_not_in("cat.category_id", $cats);
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		if($query->num_rows()>0){
			$result = $query->result();
			foreach ($result as $row) {
				$reg[] = $row->category_id;
			}
			return $reg;
		}else{
			return array();
		}
	}

	public function getCategories($categories='', $type='', $parent=''){
		//echo $parent;
		$this->db->select('cat.*');
		if(!empty($categories) && $type==1){
			$query = $this->db->query('select categories from seller_interview where seller_id='.seller_id());
			if($query->num_rows()>0){
				$chooseCategoriesInfo = $query->row();
				if(!empty($chooseCategoriesInfo->categories)){
					$chooseCategories = json_decode($chooseCategoriesInfo->categories);
					$this->db->where_in('cat.category_id',$chooseCategories);
				}
			}
			$this->db->where("cat.parent_id", $categories);
		}else{
			$query1 = $this->db->query('select category from business_info where seller_id=?',array(seller_id()));
			if($query1->num_rows()>0){
				$chooseCatInfo = $query1->row();
				if(!empty($chooseCatInfo->category)){
					$chooseCat = json_decode($chooseCatInfo->category);
					$this->db->where_in('cat.category_id',$chooseCat);
				}
			}
			$this->db->where("cat.parent_id", 0);
		}

		$this->db->where("cat.status", 1);
		$this->db->from('category as cat');
		$this->db->order_by("cat.category_name","ASC");
		$query = $this->db->get();
		//echo $this->db->last_query(); //die;
		if($query->num_rows()>0)
			return $query->result();
		else
			return FALSE;
	}


	public function getCategoryTreeStructure($choose=""){ 

		$arrayCategories = array();
		$categoryData = $this->get_result('category','',array('category_id','category_name','parent_id'),array('category_name','asc'));
		if($categoryData){
			foreach ($categoryData as $row) {
				$arrayCategories[$row->category_id] = array("category_id" => $row->category_id, "parent_id" => $row->parent_id, "category_name" =>$row->category_name); 
			}
			if($choose!="choose"){
				$resultData = $this->createTreeView($arrayCategories, 0);
				return true;	
			}else{
				$resultData = $this->createTreeViewWithCheckbox($arrayCategories, 0);
				return true;
			}
		}else{
			return false;
		}
	}

	private function createTreeView($array, $currentParent, $currLevel = 0, $prevLevel = -1) {

		$catId = $this->uri->segment(4);
		foreach ($array as $categoryId => $category) {
			if ($currentParent == $category['parent_id']){   

			    if ($currLevel > $prevLevel) 
			    	echo " <ol class='tree'> "; 

			    if ($currLevel == $prevLevel) 
			    	echo " </li> ";

			 	if($catId==$category['category_id']){
			 		$selected = "selected";
			 	}else{
			 		$selected = "";
			 	}

			    echo "<a class='".$selected."' href='".base_url("backend/category/edit/").$category['category_id']."''> <li> <label for='subfolder2'>".ucwords($category['category_name'])."</label> </a>";
			 
			    if ($currLevel > $prevLevel) { 
			    	$prevLevel = $currLevel; 
			    }
			    $currLevel++; 
			    $this->createTreeView($array, $categoryId, $currLevel, $prevLevel);
			    $currLevel--;               
			}   
			 
		}
		
		if ($currLevel == $prevLevel) 
			echo " </li>  </ol> ";

	}


	private function createTreeViewWithCheckbox($array, $currentParent, $currLevel = 0, $prevLevel = -1) {
		$product_cat_ids = $this->session->userdata('productcat_info')['product_cat_ids'];
		$product_cat = explode(",",$product_cat_ids);

		foreach ($array as $categoryId => $category) {
			if ($currentParent == $category['parent_id']){   
			    if ($currLevel > $prevLevel) 
			    	echo " <ol class='tree'> "; 

			    if ($currLevel == $prevLevel) 
			    	echo " </li> ";

			    foreach ($product_cat as $row) {
			    	if($row==$category['category_id']){
				 		$checked = "checked";
				 	}else{
				 		$checked = "";
				 	}
			    }

			    echo "<input type='checkbox' class='product_cat_checkbox' name='productcategory[]' value='".$category['category_id']."' ".$checked."> <label for='subfolder2'>".ucwords($category['category_name'])."</label> <br>";
			 
			    if ($currLevel > $prevLevel) { 
			    	$prevLevel = $currLevel; 
			    }
			    $currLevel++; 
			    $this->createTreeViewWithCheckbox($array, $categoryId, $currLevel, $prevLevel);
			    $currLevel--;               
			}    
		}

		if ($currLevel == $prevLevel) 
			echo " </li>  </ol> ";

	}


	public function getCategoryTree($selected='',$col='')
    {
		
		$arrayCategories = array();
		$categoryData = $this->get_result('category','',array('category_id','category_name','parent_id','category_slug'),array('category_name','asc'));
		if($categoryData){
			foreach ($categoryData as $row) {
				$arrayCategories[$row->category_id] = array("category_id" => $row->category_id, "parent_id" => $row->parent_id, "category_name" =>$row->category_name,'category_slug'=>$row->category_slug); 
			}
			echo  $resultData = $this->createTreeViewSelect($arrayCategories, 0,0,-1,trim($selected),'',0,$col);
			
		}else{
			echo '';
		}
    }


	public function numbertodash($number='')
    {
       $hash='';
       for ($i=0; $i < $number; $i++)
       {
           $hash=$hash."&ensp;&ensp;";
       }
       return $hash;
    }


	public function createTreeViewSelect($array, $currentParent, $currLevel = 0, $prevLevel = -1,$catId='',$result='',$count=0,$col='') {
		$selected = "";
		
		foreach ($array as $categoryId => $category) {
		
			if ($currentParent == $category['parent_id']){   
				
				if(!empty($col))
					echo "<option value='".$category['category_slug']."' ";
				else	
				    echo "<option value='".$category['category_id']."' ";
				if(in_array($category['category_id'],explode(',',$catId)))
			 		echo "selected";	
			 	else if(in_array($category['category_slug'],explode(',',$catId)))
			 		echo "selected";
			 	
				echo " >".$this->numbertodash($currLevel).ucwords($category['category_name'])."</option>";
			 
			    if ($currLevel > $prevLevel) { 
				$count++;
			    	$prevLevel = $currLevel; 
			    }
			    $currLevel++; 
			    $this->createTreeViewSelect($array, $categoryId, $currLevel, $prevLevel,$catId,$result,$count,$col);
			    $currLevel--;               
			}   
			 
		}
	}

	public function getAttributeInfoUsingCat($category='', $attributes='') {
		$optionData = "";
		$checked = "";
		$attributes = json_decode($attributes);
		$data = $this->getAttrDataUsingCategory('attributes',array($category,'category_id'),'attribute_code');
		if(!empty($attributes) && !empty($data)){
          foreach ($data as $row) {
          	if (in_array($row->attribute_code, $attributes)){
          		$checked = "checked='checked'";
          	}
          	$optionData .= "<input type='checkbox' name='attributes[]' value='".$row->attribute_code."' ".$checked."> ".ucfirst($row->name)."<br>";
          	$checked = "";
          }
        }
        return $optionData;
	} 
	 
	public function getVariationProducts($product_info_id=''){
		$this->db->select('pi.product_info_id, pi.title, pi.slug, pi.created_at, pi.category_id, pv.product_variation_id, pv.product_variation_info, pv.status, pv.seller_SKU, pv.product_ID, pv.base_price, pv.sell_price, pv.quantity, pv.type_of_product, pv.admin_approvel, pv.seller_id, pv.commision_fee');

		$this->db->join('products_info as pi', 'pi.product_info_id = pv.product_info_id','left');
		//$this->db->join('product_images as p_img', 'p_img.product_info_id = pv.product_info_id');
		$this->db->from('product_variations as pv');
		$this->db->where('pv.product_info_id',$product_info_id);
		$this->db->group_by('pv.product_variation_id');
		$this->db->order_by("product_info_id","desc");
		//$this->db->order_by('p_img.featured_image','desc');

		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		if($query->num_rows()>0)
			return $query->result();
		else
			return FALSE;
	}

	public function get_attributes($attribute_code)
	{
		$this->db->select('name,attribute_code,attribute_value,type,file_type,is_required_only,is_readonly,default_value,tooltip_content,placeholder_content');
		$this->db->where('status',1);
		$this->db->where_in('attribute_code',$attribute_code);
		$query = $this->db->get('attributes');
		if($query->num_rows()>0)
			return $query->result();
		else
			return array();
	}

	/*public function getAccessToken($user_id='')
	{
		if(!empty($user_id)){
			$resultUser = $this->get_row('users',array('user_id'=>$user_id));
			if(!empty($resultUser) && $resultUser->confirmation_code=='verified'){
				$resultBusiness = $this->get_row('business_info',array('seller_id'=>$user_id));
				if(!empty($resultBusiness)){
					$resultInterview = $this->get_row('seller_interview',array('seller_id'=>$user_id));
					if(!empty($resultInterview)){
						$resultSign = $this->get_row('seller_signature_and_licence',array('seller_id'=>$user_id));
						if(!empty($resultSign)){
							return TRUE;
						}else{
							return FALSE;
						}
					}else{
						return FALSE;
					}
				}else{
					return FALSE;
				}
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}*/


	public function getAccessToken($user_id='')
	{
		if(!empty($user_id)){
			$resultUser = $this->get_row('users',array('user_id'=>$user_id),array('skipped','confirmation_code'));
			if(!empty($resultUser) && $resultUser->confirmation_code=='verified'){
				if(!empty($resultUser->skipped) && $resultUser->skipped!='null' && $resultUser->skipped!=null){
					$skipped = json_decode($resultUser->skipped);
					if($skipped->status==1){
						return TRUE;
					}else{
						return FALSE;
					}
				}else{
					return FALSE;
				}	
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	public function shipping_charges($productVariationID ='', $country='', $state='', $city='', $shipping_method=''){
		$result = $this->get_row('product_variations',array('product_variation_id'=>$productVariationID),array('shipment_rate_type','shipment_rate_id'));
		if(!empty($result)){

			if($result->shipment_rate_type==2 || $result->shipment_rate_type==3){
				$resultShipmentRate = $this->get_row('shipmentrate_setting',array('shipment_rate_id'=>$result->shipment_rate_id));
				if(!empty($resultShipmentRate)){

					$cityRates = json_decode($resultShipmentRate->city);
					$stateRates = json_decode($resultShipmentRate->state);
					$countryRates = json_decode($resultShipmentRate->country);

					if(!empty($cityRates) && isset($cityRates->$city)) {
						$cityrateData = (array) $cityRates->$city;

						if(!empty($shipping_method)){
							if($cityrateData[$shipping_method]->price!='' && $cityrateData[$shipping_method]->price!=0.00){
								return $cityrateData[$shipping_method]->price;
							}else{
								return false;
							}
						}else{
							return $cityrateData;
						}
					}else if(!empty($stateRates) && isset($stateRates->$state)) {
						$staterateData = (array) $stateRates->$state;

						if(!empty($shipping_method)){
							if($staterateData[$shipping_method]->price!='' && $staterateData[$shipping_method]->price!=0.00){
								return $staterateData[$shipping_method]->price;
							}else{
								return false;
							}
						}else{
							return $staterateData;
						}
					}else if(!empty($countryRates) && isset($countryRates->$country)) {
						$countryrateData = (array) $countryRates->$country;

						if(!empty($shipping_method)){
							if($countryrateData[$shipping_method]->price!='' && $countryrateData[$shipping_method]->price!=0.00){
								return $countryrateData[$shipping_method]->price;
							}else{
								return false;
							}
						}else{
							return $countryrateData;
						}
					}else{
						return false;
					}
				}else{
					return false;
				}
			}else if($result->shipment_rate_type==1){
				return array('method'=>'Free_Shipping');
			}else{
				return false;
			}
		}else{
			return false;
		}
	}


	public function get_orderInfo($offset='', $per_page='', $search='', $order_status=array(), $user_id="", $userRole="", $pageType=""){   
      	$tempOrderStatusData = "";
		$tempSellerIdCon     = "";
		if(!empty($order_status)):
			$i=0;
			foreach ($order_status as $key) {
				if($i==0) $con = " AND ("; else $con = " OR ";
				$tempOrderStatusData .= $con." order_status=".$key;
				$i++;
			}
			$tempOrderStatusData .= ")";
		endif;

		/*Check the user is seller*/
		if($userRole==1 && !empty($user_id)){
			$tempSellerIdCon = 'AND json_contains(product_details,\'{"seller_id" : "'.$user_id.'"}\')';
		}

        $this->db->select('od.admin_delivered_confirmation,od.order_detail_id, od.subtotal, od.product_details, od.order_status, o.o_id, o.currency_type, o.currency_amount_in_bitcoin, o.currency_amount_in_ethereum, o.currency_amount_in_dollor, o.order_id, o.user_id,o.shipping_charges as totalShippingCharges, o.total_amount, o.gross_amount, o.payment_method, o.shipping_address, o.shipping_addressId, o.created, (select GROUP_CONCAT(order_detail_id) from order_details where order_table_id = o.o_id '.$tempOrderStatusData.$tempSellerIdCon.') as orderDetailIDs, (select COUNT(order_detail_id) from order_details where order_table_id = o.o_id '.$tempOrderStatusData.$tempSellerIdCon.') as total_items');
		
        /*searching variable condition*/
	    if(!empty($search)):
			$all_columns = implode(" and ", $search);
			$this->db->where($all_columns);
		endif;

		/*check order status*/
		if(!empty($order_status)):
			$this->db->group_start();
			foreach ($order_status as $key) {
				$this->db->or_where('od.order_status',$key);
			}
			$this->db->group_end();
		endif;

		/*for checking which page are going to be executed*/
		if($pageType=='front_orderhistory'){
			$this->db->where('od.admin_delivered_confirmation', 1);
		}else if($pageType=='front_openorders'){
			$this->db->where('od.admin_delivered_confirmation', 0);
		}

		/*Check the userrole seller or customer*/
		if(!empty($user_id) && $userRole==2){
			$this->db->where('o.user_id', $user_id);
			$this->db->group_by('od.order_table_id');
		}else if(!empty($user_id) && $userRole==1){
			if($pageType=='export'){
				if(isset($_POST) && !empty($_POST)){
					$checkstatus = $_POST['checkstatus'];
					if($checkstatus){
						$this->db->where_in('od.order_detail_id',$checkstatus);
					}
				}
			}
			$this->db->where('json_contains(od.product_details,\'{"seller_id" : "'.$user_id.'"}\')');
		}else if($userRole==0){
			if($pageType=='export'){
				if(isset($_POST) && !empty($_POST)){
					$checkstatus = $_POST['checkstatus'];
					if($checkstatus){
						$this->db->where_in('od.order_detail_id',$checkstatus);
					}
				}
			}
		}

		$this->db->join('order_details as od', 'o.o_id = od.order_table_id');
        $this->db->from('orders as o');
		$this->db->order_by('o.o_id','desc');
		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			$query = $this->db->get();
			//echo $this->db->last_query(); 
			if($query->num_rows()>0){
				if($pageType=="export"){
					return $query->result_array();
				}else{
					return $query->result();
				}
			}
			else{
				return FALSE;
			}
		}else{
			return $this->db->count_all_results();
		}
	}
	public function get_orderdetails($order_detail_id='', $user_role='', $user_id=''){		
		$this->db->select('od.*, o.o_id, o.order_id, o.shipping_charges, o.total_amount, o.gross_amount, o.currency_type, o.total_items, o.payment_status, o.order_status, od.order_status as par_order_status, o.shipping_address, o.shipping_addressId, o.created, o.currency_amount_in_bitcoin, o.currency_amount_in_ethereum, o.currency_amount_in_dollor');
		
		if(!empty($user_id) && $user_role==1){
			$this->db->where('od.seller_id', $user_id);
		}else if(!empty($user_id) && $user_role==2){
			$this->db->where('o.user_id', $user_id);
		}
		$this->db->where('od.order_detail_id', $order_detail_id);
		$this->db->join('orders as o', 'o.o_id = od.order_table_id');
		$this->db->from('order_details as od');
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		if($query->num_rows()>0)
			return $query->row();
		else
			return FALSE;
	}


	public function get_parorderdetails($order_detail_id='', $user_role='', $user_id=''){

		$this->db->select('od.*, o.o_id, o.order_id, o.currency_type, o.currency_amount_in_bitcoin, o.currency_amount_in_ethereum, o.currency_amount_in_dollor, o.payment_status, o.shipping_address, o.shipping_addressId, o.created');
		
		if(!empty($user_id) && $user_role==1){
			$this->db->where('od.seller_id', $user_id);
			$this->db->where('od.order_detail_id', $order_detail_id);
		}
		
		$this->db->join('orders as o', 'o.o_id = od.order_table_id','left');
		$this->db->from('order_details as od');
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		if($query->num_rows()>0)
			return $query->row();
		else
			return FALSE;
	}


	public function checkCalcellationProduct($order_detail_id='', $user_role='', $user_id=''){

		$this->db->select('od.order_detail_id');
		
		if(!empty($user_id) && $user_role==1){
			$this->db->where('od.seller_id', $user_id);
		}else if(!empty($user_id) && $user_role==2){
			$this->db->where('o.user_id', $user_id);
		}
		
		$this->db->where('od.order_status <', 3);
		$this->db->join('orders as o', 'o.o_id = od.order_table_id');
		$this->db->from('order_details as od');
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		if($query->num_rows()>0)
			return $query->row();
		else
			return FALSE;
	}


	public function checkReturnProduct($order_detail_id='', $user_role='', $user_id=''){

		$this->db->select('od.order_detail_id');
		
		if(!empty($user_id) && $user_role==1){
			$this->db->where('od.seller_id', $user_id);
		}else if(!empty($user_id) && $user_role==2){
			$this->db->where('o.user_id', $user_id);
		}
		
		$this->db->where('od.order_status', 4);
		$this->db->join('orders as o', 'o.o_id = od.order_table_id');
		$this->db->from('order_details as od');
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		if($query->num_rows()>0)
			return $query->row();
		else
			return FALSE;
	}

	public function get_wishListInfo($offset='',$per_page='',$search=''){

		$this->db->select('wl.*');

	    if(!empty($search)):
			$all_columns = implode(" and ", $search);
			$this->db->where($all_columns);
		endif;

		$this->db->where('wl.user_id',user_id());
		$this->db->from('wish_list as wl');
		$this->db->order_by('wl.wish_list_id','desc');

		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			$query = $this->db->get();
			//echo $this->db->last_query(); die;
			if($query->num_rows()>0)
				return $query->result();
			else
				return FALSE;
		}else{
			return $this->db->count_all_results();
		}
	}


	public function getOrderNamePrice($orderDetailsIDs=''){
		$searchString = ',';
		$itemTitle 	  = '';
		$totalPrice   = 0.00;
		$shippingprice= 0.00;
		$grossprice   = 0.00;

		if(strpos($orderDetailsIDs, $searchString) !== false) {				
		    $orderDetailsIDs = explode(",", $orderDetailsIDs);
		    $numItems = count($orderDetailsIDs);
			$i = 0;
		    foreach ($orderDetailsIDs as $key => $value) {
		    	$result = $this->get_row('order_details', array('order_detail_id' => $value),array('product_details','shipping_charges','price','subtotal'));
		    	if(!empty($result)){
		    		$total  	 = $result->price + $result->shipping_charges;
		    		$totalPrice += $total;
		    		$shippingprice += $result->shipping_charges;
		    		$grossprice    += $result->price;
		    		$itemTitle  .= ucfirst(json_decode($result->product_details)->title);

		    		if(++$i === $numItems) {
					    $itemTitle .= "";
					}else{
						$itemTitle .= ", ";
					}
		    	}
		    }
		}else{
				
			$result = $this->get_row('order_details', array('order_detail_id' => $orderDetailsIDs),array('product_details','shipping_charges','price','subtotal'));

			if(!empty($result)){
	    		$total  	 = $result->price + $result->shipping_charges;
	    		$totalPrice  = $total;
	    		$shippingprice = $result->shipping_charges;
		    	$grossprice    = $result->price;
	    		$itemTitle   = json_decode($result->product_details)->title;
	    	}
		}
      
		return array("title"=>$itemTitle, "price"=>$totalPrice, "shippingprice"=>$shippingprice, "grossprice"=>$grossprice);
	}


	function getShippingUsingIP($product_variation_id='', $shipping_address_id='', $shipping_method='')
   	{
   		$shippingCharges = array();
   		$yourAddress = "";
   		$product_variation_id = base64_decode($product_variation_id);


   		if(empty(user_id()) || $shipping_address_id==''){

			/*Get user ip address details with geoplugin.net*/
			$ip = "111.118.248.118"; 
			$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
			if(!empty($query)){

				$city = $query['city'];
				$state = $query['regionName'];
				$country = $query ['country'];
				$ip_address = $query['query'];
				$yourAddress = ' <b>'.$city.'</b>, '.$state.', '.$country;

				$countryID = "";
				$stateID = "";
				$cityID = "";

				$countryData = $this->get_row('countries', array('name'=>$country), array('name','id'));
				if(!empty($countryData)){
					$countryID = $countryData->id;
					$stateData = $this->get_row('states', array('name'=>$state, 'country_id'=>$countryData->id), array('name','id'));
					if(!empty($stateData)){
						$stateID = $stateData->id;
						$cityData = $this->get_row('cities', array('name'=>$city, 'state_id'=>$stateData->id), array('name','id'));
						if(!empty($cityData)){
							$cityID = $cityData->id;
						}
					}
				}
				
				
				$product_variationsData = $this->get_row('product_variations', array('product_variation_id'=>$product_variation_id), array('shipment_rate_type','shipment_rate_id'));
				if(!empty($product_variationsData)){
					if($product_variationsData->shipment_rate_type==1 || $product_variationsData->shipment_rate_type==2 || $product_variationsData->shipment_rate_type==3){
						$shippingCharges = shipping_charges($product_variation_id, $countryID, $stateID, $cityID, $shipping_method);
						return array('status'=> 'success', 'type'=>$product_variationsData->shipment_rate_type, 'data'=>$shippingCharges, 'yourAddress'=>$yourAddress);

					}else{
						return array('status'=> 'success', 'type'=>1, 'data'=>$shippingCharges, 'yourAddress'=>$yourAddress);
					}
				}else{
					return array('status'=> 'failed', 'type'=>'', 'data'=>$shippingCharges, 'yourAddress'=>"We are not able to get your address");
				}

			}else{
				return array('status'=> 'failed', 'type'=>'', 'data'=>$shippingCharges, 'yourAddress'=>$yourAddress);
			}
		}else{

			$shipping_addresessData = $this->get_row('shipping_addresess', array('user_id'=>user_id(), 'shipping_address_id'=>$shipping_address_id));
			if(!empty($shipping_addresessData)){

				$country = getData('countries',array('id',$shipping_addresessData->country))->name;
                $state = getData('states',array('id',$shipping_addresessData->state))->name;
                $city = getData('cities',array('id',$shipping_addresessData->city))->name;
                $yourAddress = $shipping_addresessData->address.', <b>'.$city.'</b>, '.$state.', '.$country;

                $product_variationsData = $this->get_row('product_variations', array('product_variation_id'=>$product_variation_id), array('shipment_rate_type','shipment_rate_id'));
                
				if(!empty($product_variationsData)){
					if($product_variationsData->shipment_rate_type==1 || $product_variationsData->shipment_rate_type==2 || $product_variationsData->shipment_rate_type==3){
						$shippingCharges = shipping_charges($product_variation_id, $shipping_addresessData->country, $shipping_addresessData->state, $shipping_addresessData->city, $shipping_method);

						return array('status'=> 'success', 'type'=>$product_variationsData->shipment_rate_type, 'data'=>$shippingCharges, 'yourAddress'=>$yourAddress);

					}else{
						return array('status'=> 'success', 'type'=>1, 'data'=>$shippingCharges, 'yourAddress'=>$yourAddress);
					}
				}else{
					return array('status'=> 'failed', 'type'=>'', 'data'=>$shippingCharges, 'yourAddress'=>$yourAddress);
				}
			}else{
				return array('status'=> 'failed', 'type'=>'', 'data'=>$shippingCharges, 'yourAddress'=>$yourAddress);
			}
		}

   	}

   	public function typeOfProducts($seller_id='', $type_of_product='', $product_page=''){

		$this->db->select('(select count(product_variations.product_variation_id) from product_variations join product_images on product_images.`product_variation_id`=product_variations.`product_variation_id` where product_variations.product_info_id=pi.product_info_id and product_images.`featured_image`=1 group by product_images.`product_info_id`) as totalVariationCount, pi.product_info_id');

		if($product_page=='inventory'){
			$this->db->join('products_info as pi', 'pi.product_info_id = pv.product_info_id','left');
			$this->db->join('product_images as p_img', 'p_img.product_variation_id = pv.product_variation_id');
			$this->db->where('p_img.product_img_id is not null');
			$this->db->where('p_img.featured_image',1);
			if(!empty($seller_id))
			{
				$this->db->where('pv.seller_id',$seller_id);
			}			
			$this->db->from('product_variations as pv');
			$this->db->group_by('pv.product_info_id');
			$this->db->order_by("product_info_id","desc");
			//$this->db->order_by('p_img.featured_image','desc');
		}else if($product_page=='draft'){
			$this->db->from('products_info as pi');
			$this->db->join('product_variations as pv', 'pi.product_info_id = pv.product_info_id','left');
			$this->db->join('product_images as p_img', 'p_img.product_variation_id = pv.product_variation_id','left');
			$this->db->group_start();
			$this->db->or_where('p_img.product_variation_id is null');
			$this->db->or_where('pv.product_info_id is null');
			$this->db->group_end();
			$this->db->where('pi.seller_id',$seller_id);
			//$this->db->from('product_variations as pv');
			$this->db->group_by('pv.product_info_id');
			$this->db->order_by("product_info_id","desc");
		}

		$this->db->where('pv.type_of_product',$type_of_product);
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		if($query->num_rows()>0)
			return $query->result();
		else
			return FALSE;

	}


	public function shippingRate_Cols($data=array()){

		$shipping_type = json_decode($data);
		$this->db->select('so.title, so.shipping_option_id');

		foreach ($shipping_type as $key => $value) {
			$this->db->or_where('so.shipping_option_id', $key);
		}

		$this->db->from('shipping_option as so');
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		if($query->num_rows()>0)
			return $query->result();
		else
			return FALSE;

	}


	public function getAutoSearchKeywords($keyword=''){

		$query = $this->db->query('(SELECT DISTINCT(cat.category_name) from category as cat where cat.category_name like "%'.$keyword.'%" order by cat.category_name ASC) UNION (SELECT DISTINCT(TRIM(TRAILING "]" FROM TRIM(LEADING "[" FROM pi.keywords))) FROM products_info as pi where (pi.keywords!="" AND pi.keywords like "%'.$keyword.'%") order by pi.keywords ASC)');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return FALSE;
		}
	}


	public function getFeePreviewDetails($seller_id='', $user_role='', $order_detail_id=""){
		$this->db->select('count(od.order_detail_id) as total_orders, IFNULL(sum(od.subtotal), 0.00) as total_amount, ROUND(sum(od.subtotal*od.commision_percentage/100), 2) as fee_preview, ROUND((sum(od.subtotal)-sum(od.subtotal*od.commision_percentage/100)), 2) as pay_to_seller ,IFNULL(sum(ph.paid_amount), 0.00) as paid_amount, ROUND(((sum(od.subtotal)-sum(od.subtotal*od.commision_percentage/100))- IFNULL(sum(ph.paid_amount), 0.00)), 2) as remaining_amount, od.product_details, avg(o.currency_amount_in_bitcoin) as currency_amount_in_bitcoin, avg(o.currency_amount_in_ethereum) as currency_amount_in_ethereum, avg(o.currency_amount_in_dollor) as currency_amount_in_dollor, o.currency_type');
		$this->db->from('order_details as od');
		$this->db->join('payout_history as ph', 'ph.order_detail_id = od.order_detail_id','left');
		$this->db->join('orders as o', 'o.o_id = od.order_table_id');
		$this->db->where("od.seller_id", $seller_id);

		$ignore = array(5, 6);
		$this->db->where_not_in('od.order_status', $ignore);

		if(!empty($order_detail_id))
			$this->db->where("od.order_detail_id", $order_detail_id);

		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return FALSE;
		}
	}


	public function getTransactionDetails($seller_id='', $offset='', $per_page=''){
		$this->db->select('ROUND((od.subtotal*od.commision_percentage/100), 2) as fee_preview, ROUND((od.subtotal-od.subtotal*od.commision_percentage/100), 2) as pay_to_seller, od.subtotal, od.commision_percentage, od.order_status, od.created, od.order_detail_id, od.order_table_id, od.product_details, ph.paid_amount, ROUND(((od.subtotal-od.subtotal*od.commision_percentage/100)- IFNULL(ph.paid_amount, 0.00)), 2) as remaining_amount, od.order_status, o.currency_type, o.currency_amount_in_bitcoin, o.currency_amount_in_ethereum, o.currency_amount_in_dollor, o.order_id');
		$this->db->join('payout_history as ph', 'ph.order_detail_id = od.order_detail_id','left');
		$this->db->join('orders as o', 'o.o_id = od.order_table_id','inner');
		$this->db->where("od.seller_id", $seller_id);

		$ignore = array(5, 6);
		$this->db->where_not_in('od.order_status', $ignore);

		if(!empty($_GET))
	    {
	      if(!empty($_GET['order_status']))
	      	$this->db->where('od.order_status', $_GET['order_status']);

	      if(!empty($_GET['paid_status'])){
	      	if($_GET['paid_status']==1){
	      		$this->db->where('paid_amount IS NOT NULL');
	      	}else if($_GET['paid_status']==2){
	      		$this->db->where('paid_amount IS NULL');
	      	}
	      }
	    }	

		$this->db->from('order_details as od');
		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			$query = $this->db->get();
			//echo $this->db->last_query(); die;
			if($query->num_rows()>0)
				return $query->result();
			else
				return FALSE;
		}else{
			return $this->db->count_all_results();
		}

	}

	public function getPaymentInfo($id='', $order_id=''){
		$query = $this->db->query('select * from tempary_paymentinfo where json_contains(alfacoin_info,\'{"order_id" : "'.$order_id.'"}\')');
		//echo $this->db->last_query(); die;
		if($query->num_rows()>0)
			return $query->row();
		else
			return FALSE;

	}

	public function getAttrDataUsingCategory($table_name='', $findInSet = array(), $groupBy=''){
		
		$this->db->group_start();
			$this->db->or_where('type', 1);
			$this->db->or_where('type', 3);
		$this->db->group_end();

		$ignoreFieldType = array(9, 10);
		$this->db->where_not_in('file_type', $ignoreFieldType);

		if(!empty($findInSet)):
			$where = "FIND_IN_SET('".$findInSet[0]."', ".$findInSet[1].")";  
			$this->db->where($where); 
		endif;
		if(!empty($groupBy)):
			$this->db->group_by($groupBy);
		endif;
		$this->db->where('status',1);
		$query=$this->db->get('attributes');
		if($query->num_rows()>0)
			return $query->result();
		else
			return FALSE;
	}

	public function get_brands($table_name='', $findInSet = array(), $seller_id=''){

		$this->db->group_start();
			$this->db->where('seller_id', $seller_id);
    		$this->db->or_where('seller_id', 0);
    		$this->db->or_where('status', 1);
    		$this->db->or_where('status', 3);
		$this->db->group_end();

		if(!empty($findInSet)):
			$where = "FIND_IN_SET('".$findInSet[0]."', ".$findInSet[1].")";  
			$this->db->where($where); 
		endif;

		$this->db->group_by('brand_name');
		$this->db->order_by("brand_name","ASC");
		$query=$this->db->get($table_name);
		//echo $this->db->last_query(); die;
		if($query->num_rows()>0)
			return $query->result();
		else
			return FALSE;
	}

	public function get_brands_category($table_name='',$columns=array(),$category_id = array()){

       if(!empty($columns)):
	     $all_columns = implode(",", $columns);
	     $this->db->select($all_columns);
		endif;

		$this->db->group_start();
		if(!empty($category_id)){
		foreach ($category_id as  $cat_value) {
			if(count($category_id)>1){
	          $this->db->or_where('category_id',$cat_value);
	        }
	        else{
	        	 $this->db->or_where('parent_id',$cat_value);
	        	 $this->db->or_where('category_id',$cat_value);
	        }
		 }
		}
		 $this->db->group_end();
        $this->db->where('status',1);
		$this->db->order_by("parent_id","ASC");
		$query=$this->db->get($table_name);
		// echo $this->db->last_query(); die;
		if($query->num_rows()>0)
			return $query->result();
		else
			return FALSE;
	}

}
