<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Seller_model extends CI_Model {	

	public function get_productresult($offset='',$per_page='',$search='',$pagetype=''){
		$this->db->select('(select count(product_variations.product_variation_id) from product_variations join product_images on product_images.`product_variation_id`=product_variations.`product_variation_id` where product_variations.product_info_id=pi.product_info_id and product_images.`featured_image`=1 group by product_images.`product_info_id`) as totalVariationCount, pi.product_info_id, pi.title, pi.slug, pi.category_id, pi.created_at, pv.product_variation_id, pv.status, pv.seller_SKU, pv.product_ID, pv.base_price, pv.sell_price, pv.quantity, pv.type_of_product, pv.commision_fee, pv.admin_approvel, pv.shipment_rate_type, pv.shipment_rate_id, pv.seller_id');

	    if(!empty($search)):
			$all_columns = implode(" and ", $search);
			$this->db->where($all_columns);
		endif;

		$this->db->join('products_info as pi', 'pi.product_info_id = pv.product_info_id','left');
		$this->db->join('product_images as p_img', 'p_img.product_variation_id = pv.product_variation_id');
		$this->db->where('p_img.product_img_id is not null');
		$this->db->where('p_img.featured_image',1);
		$this->db->where('pv.seller_id',seller_id());
		$this->db->from('product_variations as pv');
		$this->db->group_by('pv.product_info_id');
		$this->db->order_by("product_info_id","desc");
		//$this->db->order_by('p_img.featured_image','desc');
	
		if($pagetype=='inventoryExport'){
			if(isset($_POST) && !empty($_POST)){
				$checkstatus = $_POST['checkstatus'];
				if($checkstatus){
					$this->db->where_in('pi.product_info_id',$checkstatus);
				}
			}
		}		

		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			$query = $this->db->get();
			//echo $this->db->last_query(); 
			//die;
			if($query->num_rows()>0)
				if($pagetype=='inventoryExport')
				{
                 return $query->result_array();
				}else
				{
				return $query->result();					
				}
			else
				return FALSE;
		}else{
			return $this->db->count_all_results();
		}
	}
	public function get_productresult_draft($offset='',$per_page='',$search=''){
		$this->db->select('(select count(product_variations.product_variation_id) from product_variations left join product_images on product_images.`product_variation_id`=product_variations.`product_variation_id` where (product_variations.product_info_id=pv.product_info_id)  group by product_images.product_info_id  limit 1) as totalVariationCount, pi.product_info_id, pi.title, pi.slug, pi.category_id, pi.created_at, pv.product_variation_id, pv.status, pv.seller_SKU, pv.product_ID, pv.base_price, pv.sell_price, pv.quantity, pv.type_of_product, pv.commision_fee, pv.admin_approvel, pv.shipment_rate_type, pv.shipment_rate_id, pv.seller_id');

	    if(!empty($search)):
			$all_columns = implode(" and ", $search);
			$this->db->where($all_columns);
		endif;
		$this->db->from('products_info as pi');
		$this->db->join('product_variations as pv', 'pi.product_info_id = pv.product_info_id','left');
		$this->db->join('product_images as p_img', 'p_img.product_variation_id = pv.product_variation_id','left');
		$this->db->group_start();
		$this->db->or_where('p_img.product_variation_id is null');
		$this->db->or_where('pv.product_info_id is null');
		$this->db->group_end();
		$this->db->where('pi.seller_id',seller_id());
		//$this->db->from('product_variations as pv');
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

	public function getVariationProducts($product_info_id='', $statusProduct=0,$pagetype=''){
		$this->db->select('pi.product_info_id, pi.title, pi.slug, pi.category_id, pi.created_at, pv.product_variation_id, pv.product_variation_info, pv.status, pv.seller_SKU, pv.product_ID, pv.base_price, pv.sell_price, pv.quantity, pv.type_of_product, pv.commision_fee, pv.admin_approvel, pv.shipment_rate_type, pv.shipment_rate_id, pv.seller_id');

		$this->db->join('product_variations as pv', 'pi.product_info_id = pv.product_info_id','left');
		if($statusProduct==1){
			$this->db->join('product_images as p_img', 'p_img.product_variation_id = pv.product_variation_id');
		}else{
			$this->db->join('product_images as p_img', 'p_img.product_variation_id = pv.product_variation_id', 'left');
			$this->db->where('p_img.product_variation_id is null');
			//$this->db->or_where('pv.product_info_id is null');
		}

		$this->db->from('products_info as pi');
		$this->db->where('pi.seller_id',seller_id());
		$this->db->where('pi.product_info_id',$product_info_id);
		$this->db->group_by('pv.product_variation_id');
		$this->db->order_by("product_info_id","desc");
		//$this->db->order_by('p_img.featured_image','desc');

		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		if($query->num_rows()>0)
			if($pagetype=='exportInventory')
			{
              return $query->result_array();
			}
			else
			{
		      return $query->result();
			}			
		else
			return FALSE;
	}

	public function getVariationProductsExport($product_info_id='', $statusProduct=0,$pagetype=''){
		$this->db->select('pi.product_info_id, pi.title, pi.slug, pi.category_id, pi.created_at, pv.product_variation_id, pv.product_variation_info, pv.status, pv.seller_SKU, pv.product_ID, pv.base_price, pv.sell_price, pv.quantity, pv.type_of_product, pv.commision_fee, pv.admin_approvel, pv.shipment_rate_type, pv.shipment_rate_id, pv.seller_id');

		$this->db->join('product_variations as pv', 'pi.product_info_id = pv.product_info_id','left');
		if($statusProduct==1){
			$this->db->join('product_images as p_img', 'p_img.product_variation_id = pv.product_variation_id');
		}else{
			$this->db->join('product_images as p_img', 'p_img.product_variation_id = pv.product_variation_id', 'left');
			$this->db->where('p_img.product_variation_id is null');
			//$this->db->or_where('pv.product_info_id is null');
		}
		$this->db->from('products_info as pi');
		$this->db->where('pi.seller_id',seller_id());
		$this->db->where('pi.product_info_id',$product_info_id);
		$this->db->group_by('pv.product_variation_id');
		$this->db->order_by("product_info_id","desc");
		//$this->db->order_by('p_img.featured_image','desc');

		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		if($query->num_rows()>0)
			if($pagetype=='exportInventory')
			{
              return $query->result_array();
			}
			else
			{
		      return $query->result();
			}			
		else
			return FALSE;
	}

	public function get_Categories($category=''){

		$this->db->group_start();
			$this->db->where('user_id', 0);
			$this->db->or_where('user_id', seller_id());
		$this->db->group_end();

		if(!empty($category)){
			$this->db->group_start();
			foreach ($category as $key => $value) {
				$this->db->or_where('category_id', $value);
			}
			$this->db->group_end();
		}

		$this->db->where('status', 1);
		$this->db->where('parent_id', 0);
		$this->db->order_by("category_name","asc");
		$query = $this->db->get('category');
		//echo $this->db->last_query(); die;
		if($query->num_rows()>0)
			return $query->result();
		else
			return FALSE;
	}

	public function get_subCatUsingCategory($cats=''){
		if(!empty($cats)){
			$this->db->group_start();
			foreach ($cats as $key => $value) {
				$this->db->or_where('parent_id', $value);
			}
			$this->db->group_end();
		}

		$this->db->group_start();
			$this->db->where('user_id', 0);
			$this->db->or_where('user_id', seller_id());
		$this->db->group_end();

		$this->db->where('status', 1);
		$this->db->order_by("category_name","asc");
		$query = $this->db->get('category');
		//echo $this->db->last_query(); die;
		if($query->num_rows()>0)
			return $query->result();
		else
			return FALSE;

	}


	public function get_hirarchicalSubCatUsingCategory($catID=''){
		$query = $this->db->query("select category_id, category_name from (select * from category order by `parent_id`, category_id) as products_sorted, (select @pv := ".$catID.") as initialisation where find_in_set(`parent_id`, @pv) and length(@pv := concat(@pv, ',', category_id)) and status=1 and (user_id=0 or user_id=".seller_id().")");
		//echo $this->db->last_query(); die;
		if($query->num_rows()>0)
			return $query->result();
		else
			return FALSE;
	}


	public function get_productFAQs($product_variation_id='', $offset='',$per_page='',$search=''){
		$this->db->select('pf.*');

	    if(!empty($search)):
			$all_columns = implode(" and ", $search);
			$this->db->where($all_columns);
		endif;

		$this->db->from('product_faq as pf');
		$this->db->where('pf.product_variation_id', $product_variation_id);
		$this->db->where('pf.seller_id', seller_id());
		$this->db->order_by("pf.product_faq_id","desc");

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

}
