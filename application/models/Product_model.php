<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Product_model extends CI_Model {
	public function product_list($category_id='',$qty=1,$offset='',$per_page='')
	{
		$this->db->query('SET SESSION group_concat_max_len = 1000000000');
		$this->db->select('pv.commision_fee,pi.brand_name,pi.product_info_id,pv.product_variation_id,pi.title,pi.slug,pi.short_description,pimg.image,pv.product_ID,pv.product_ID_type,pv.sell_price,pv.quantity,pv.seller_id,(select image from product_images as img where img.product_variation_id=pv.product_variation_id and img.product_img_id!=pimg.product_img_id limit 1) as second_image,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=1 group by product_variation_id) as rating1,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=2 group by product_variation_id) as rating2,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=3 group by product_variation_id) as rating3,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=4 group by product_variation_id) as rating4,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=5 group by product_variation_id) as rating5,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id group by product_variation_id) as total_rating,(select sum(rating)/count(product_review_id) from product_review where product_variation_id=pv.product_variation_id group by product_variation_id) as sum_rating,(case WHEN((select product_offers.sale_price from product_offers where product_offers.sale_end_date>=CURRENT_DATE() and CURRENT_DATE()>=product_offers.`sale_start_date` and product_offers.product_variation_id=pv.product_variation_id order by product_offers.product_offer_id desc limit 1)>0) then (select product_offers.sale_price from product_offers where product_offers.sale_end_date>=CURRENT_DATE() and CURRENT_DATE()>=product_offers.`sale_start_date` and product_offers.product_variation_id=pv.product_variation_id order by product_offers.product_offer_id desc limit 1) else `pv`.`base_price` end) as base_price');
		$this->db->from('products_info as pi');
		$this->db->join('product_variations as pv','pv.product_info_id=pi.product_info_id','inner');
		$this->db->join('product_images as pimg','pimg.product_variation_id=pv.product_variation_id');
		$this->db->join('product_review as pr','pv.product_variation_id=pr.product_variation_id','left');
		if(!empty($_GET) && !empty($_GET['pr']))
		{
			$this->db->where('pr.rating >=',$_GET['pr']);
		}
		if(!empty($_GET) && !empty($_GET['o']))
		{
			$this->db->where('round((((pv.sell_price-base_price)/pv.sell_price)*100)) >=',$_GET['o']);
		}
		if(!empty($_GET) && !empty($_GET['s']))
		{
			if($_GET['s']==1)
				$this->db->order_by('pi.product_info_id','desc');
			else if($_GET['s']==2)
				$this->db->order_by('pv.base_price','asc');
			else if($_GET['s']==3)
				$this->db->order_by('pv.base_price','desc');
			else if($_GET['s']==4)
				$this->db->order_by('pi.product_info_id','asc');
			else if($_GET['s']==5)	
				$this->db->order_by('pi.product_info_id','desc');
		}else{
			$this->db->order_by('pi.product_info_id','desc');
		}	
		if(!empty($_GET) && !empty($_GET['brand']))
			$this->db->where_in('pi.brand_name',explode(',',trim($_GET['brand'])));

		if(!empty($_GET) && !empty($_GET['min']))
			$this->db->where('pv.base_price >=',$_GET['min']);
		
		if(!empty($_GET) && !empty($_GET['max']))
			$this->db->where('pv.base_price <=',$_GET['max']);
		if(!empty($_GET) && !empty($_GET['na']))
		{
			$na=explode(',', $_GET['na']);
			if(!empty($na))
			{
				//$this->db->group_start();
					foreach ($na as $key => $value) {
						if($value)
							$this->db->where('pv.created_at >=',date('Y-m-d', strtotime(date('Y-m-d') .' -'.$value.' day')));
					}
				//$this->db->group_end();
			}
		}
		if(!empty($_GET) && !empty($_GET['key'])){
			$this->db->group_start();
				$this->db->or_like('pi.title',$_GET['key']);
				$this->db->or_like('pi.short_description',$_GET['key']);
				$this->db->or_like('pi.description',$_GET['key']);
				$this->db->or_like('pi.key_product_feature',$_GET['key']);
				$this->db->or_like('pi.keywords',$_GET['key']);
				$this->db->or_like('pv.product_variation_info',$_GET['key']);
			$this->db->group_end(); 
		}
		if(!empty($_GET) && !empty($_GET['attribute'])){
			$this->db->where('('.implode(' or ',$_GET['attribute']).')'); 
		}
		
		$this->db->where('pimg.featured_image',1);
		$this->db->where('pv.status',1);
		$this->db->where('pv.admin_approvel',1);
		
		if($qty)
			$this->db->where('pv.quantity >',0);
		if($category_id)
			$this->db->where("FIND_IN_SET('".$category_id."',pi.category_id) !=", 0);
		$this->db->group_by('pi.product_info_id');
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
	function getAttributeCondition($key,$value)
	{
		$data=array();
		$this->db->select('`attribute_code`, `type`, `file_type`');
		$this->db->where_in('attribute_code',$key);
		$query=$this->db->get('attributes');	
		if($query->num_rows()>0){
			$result=$query->result();

			foreach($result as $row)
			{
				
				$temp_value=explode(',',$value[$row->attribute_code]);
				if(in_array($row->file_type, array(4,5)))
				{
					if($row->type==2)
					{
						$data[]=$this->getQueryLike('pi.product_other_info','',$temp_value);	
					}
					else{
						$data[]=$this->getQueryLike('pi.product_basic_info','pv.product_variation_info',$temp_value);
						//$data[]=$this->getQueryLike('pi.product_variation_info'$temp_value);
					}
				}else{
					if($row->type==2)
					{
						$data[]=$this->getQuerycontains('pi.product_other_info','',$temp_value,$row->attribute_code);	
					}
					else{
						$data[]=$this->getQuerycontains('pi.product_basic_info','pv.product_variation_info',$temp_value,$row->attribute_code);
						//$data[]=$this->getQueryLike('pi.product_variation_info'$temp_value);
					}
				}
			}
		}
		return $data;
	}
	function getQueryLike($col,$col1,$temp_value)
	{
		$data=array();
		foreach($temp_value as $key=>$value)
		{
			$data[]=' '.$col.'  like "%'.$value.'%"';
			if($col1)
				$data[]=' '.$col1.'  like "%'.$value.'%"';
		}
		return implode(' or ',$data);
	}
	function getQuerycontains($col,$col1,$temp_value,$attribute)
	{
		$data=array();
		foreach($temp_value as $key=>$value)
		{
			$data[]=' json_contains('.$col.',\'{"'.$attribute.'" : "'.$value.'"}\')';
			if($col1)
				$data[]=' json_contains('.$col1.',\'{"'.$attribute.'" : "'.$value.'"}\')';
		}
		return implode(' or ',$data);
	}

	public function product_featured($category_id='', $qty=1, $offset='', $per_page='', $product_info_id='', $seller_id='', $orderBy='')
	{
		$this->db->query('SET SESSION group_concat_max_len = 1000000000');
		$this->db->select('pv.commision_fee,pi.accepted_returnpolicy, pi.return_policydays, pi.returnpolicy_description, pv.shipment_rate_type,pv.shipment_rate_id,pi.brand_name,pi.product_info_id,pv.product_variation_id,pi.title,pi.slug,pi.short_description,pimg.image,pv.product_ID,pv.product_ID_type,pv.sell_price,pv.quantity,pv.seller_id,(select image from product_images as img where img.product_variation_id=pv.product_variation_id and img.product_img_id!=pimg.product_img_id and img.status=1 limit 1) as second_image,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=1 group by product_variation_id) as rating1,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=2 group by product_variation_id) as rating2,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=3 group by product_variation_id) as rating3,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=4 group by product_variation_id) as rating4,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=5 group by product_variation_id) as rating5,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id group by product_variation_id) as total_rating,(select sum(rating)/count(product_review_id) from product_review where product_variation_id=pv.product_variation_id group by product_variation_id) as sum_rating,(case WHEN((select product_offers.sale_price from product_offers where product_offers.sale_end_date>=CURRENT_DATE() and CURRENT_DATE()>=product_offers.`sale_start_date` and product_offers.product_variation_id=pv.product_variation_id order by product_offers.product_offer_id desc limit 1)>0) then (select product_offers.sale_price from product_offers where product_offers.sale_end_date>=CURRENT_DATE() and CURRENT_DATE()>=product_offers.`sale_start_date` and product_offers.product_variation_id=pv.product_variation_id order by product_offers.product_offer_id desc limit 1) else `pv`.`base_price` end) as base_price');
		$this->db->from('products_info as pi');
		$this->db->join('product_variations as pv','pv.product_info_id=pi.product_info_id','inner');

		if(!empty($orderBy)){
			if($orderBy[0]=='total_rating'){
				$this->db->join('product_review as pr','pv.product_variation_id=pr.product_variation_id', 'inner');
				$this->db->order_by('total_rating','RANDOM');
			}else if($orderBy[0]=='most_discounted'){
				$this->db->order_by('round((((pv.sell_price-base_price)/pv.sell_price)*100))', 'desc');
			}else if($orderBy[0]=='recently_viewed'){
				$this->db->join('product_viewed as p_viewed','p_viewed.product_variation_id=pv.product_variation_id');
				$this->db->order_by('p_viewed.time', 'desc');
			}else if($orderBy[0]=='latest'){
				$this->db->order_by('pi.product_info_id','desc');
			}
		}else{
			$this->db->join('product_review as pr','pv.product_variation_id=pr.product_variation_id', 'left');
		}

		$this->db->join('product_images as pimg','pimg.product_variation_id=pv.product_variation_id');
		$this->db->where('pimg.featured_image',1);
		$this->db->where('pv.status',1);
		$this->db->where('pv.admin_approvel',1);

		if($qty)
			$this->db->where('pv.quantity >',0);

		if($category_id!='')
		{

			$category=explode(',', $category_id);
			if(!empty($category)){
				$this->db->group_start();
				foreach ($category as $key => $value) {
					$this->db->or_where("FIND_IN_SET('".$value."',pi.category_id) !=", 0);
				}
				$this->db->group_end();
			}
		}
		
		if($seller_id!='')
		{
			$this->db->where('pv.seller_id',$seller_id);
		}

		if($product_info_id!='')
		{
			$this->db->where('pi.product_info_id !=',$product_info_id);
		}

		$this->db->group_by('pi.product_info_id');

		if(empty($orderBy)){
			$this->db->order_by('pi.product_info_id','desc');
		}

		if($offset>=0 && $per_page>0){
			$this->db->limit($per_page,$offset);
			$query = $this->db->get();
		//	echo $this->db->last_query(); die;
			if($query->num_rows()>0)
				return $query->result();
			else
				return FALSE;
		}else{
			return $this->db->count_all_results();
		}
	}


	function product_details($product_variation_id='')
	{
		$this->db->query('SET SESSION group_concat_max_len = 1000000000');
		$this->db->select('pv.commision_fee,pi.accepted_returnpolicy, pi.return_policydays, pi.returnpolicy_description, pv.shipment_rate_type,pv.shipment_rate_id,pv.created_at,pi.category_id,pi.description,pi.brand_name,pi.product_info_id,pv.product_variation_id,pi.title,pi.slug,pi.short_description,pv.product_ID,pv.product_ID_type,pv.base_price,pv.sell_price,pv.quantity,pv.seller_id,(SELECT GROUP_CONCAT(pro_img.`image` ORDER BY pro_img.`status`) FROM `product_images` as pro_img where pro_img.product_variation_id=pv.product_variation_id order by pro_img.featured_image desc ) as image,(SELECT GROUP_CONCAT(pro_img.`link` ORDER BY pro_img.`status`) FROM `product_images` as pro_img where pro_img.product_variation_id=pv.product_variation_id order by pro_img.featured_image desc ) as link,(SELECT GROUP_CONCAT(pro_img.`status` ORDER BY pro_img.`status`) FROM `product_images` as pro_img where pro_img.product_variation_id=pv.product_variation_id order by pro_img.featured_image desc ) as pimg_status, u.first_name,u.last_name,u.user_name as user_name,pv.product_variation_info,pv.seller_SKU,pv.product_ID,pv.product_ID_type,pv.quantity,pi.manufacturer_part_number,pi.product_basic_info,pi.product_other_info,pv.type_of_product,pa.maximum_retail_price,pa.sale_price,pa.is_gift_wrap_available,pa.sale_start_date,pa.sale_end_date,pv.seller_description,pv.warranty_description,ps.meta_title,ps.meta_keywords,ps.meta_description,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=1 group by product_variation_id) as rating1,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=2 group by product_variation_id) as rating2,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=3 group by product_variation_id) as rating3,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=4 group by product_variation_id) as rating4,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=5 group by product_variation_id) as rating5,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id group by product_variation_id) as total_rating,(select sum(rating)/count(product_review_id) from product_review where product_variation_id=pv.product_variation_id group by product_variation_id) as sum_rating,(select sum(rating)/count(product_review_id) from product_review where product_variation_id=pv.product_variation_id group by product_variation_id) as sum_rating,(SELECT CONCAT(count(pro_r.`product_review_id`),",",sum(pro_r.`rating`)) as seller_rating FROM product_review as pro_r join product_variations as pro_v on pro_v.product_variation_id=pro_r.product_variation_id join users on users.user_id=pro_v.seller_id  where pv.seller_id=users.user_id and pro_r.status=1 group by pro_v.seller_id) as seller_rating,(select count(product_variation_id) from product_variations where product_variations.product_info_id=pv.product_info_id group by product_info_id) as variation_count,(SELECT GROUP_CONCAT(product_variation_info separator "==:==") as seller_rating FROM product_variations where product_variations.product_info_id=pv.product_info_id and product_variations.status=1 and product_variations.admin_approvel=1 and product_variations.quantity>0) as product_variations_multiple');
		$this->db->from('products_info as pi');
		//$this->db->join('product_images as pimg','pimg.product_info_id=pi.product_info_id');
		$this->db->join('product_variations as pv','pv.product_info_id=pi.product_info_id','inner');
		$this->db->join('users as u','u.user_id=pv.seller_id');	
		$this->db->join('product_offers as pa','pa.product_variation_id=pv.product_variation_id','left');
		$this->db->join('product_review as pr','pv.product_variation_id=pr.product_variation_id','left');	
		$this->db->join('product_seo as ps','ps.product_info_id=pi.product_info_id','left');
		$this->db->where('pv.status',1);
		$this->db->where('pv.admin_approvel',1);
		$this->db->where('pv.product_variation_id',$product_variation_id);
		$this->db->group_by('pi.product_info_id');
		$query = $this->db->get();


		//echo $this->db->last_query();die;
		if($query->num_rows()>0)
				return $query->row();
		else
				return FALSE;
	}
	function get_product_price_ajax($product_info_id='',$attribute='')
	{
		$condition=implode(' and ', $attribute);
		$this->db->query('SET SESSION group_concat_max_len = 1000000000');
		$this->db->select('pv.commision_fee,pi.accepted_returnpolicy, pi.return_policydays, pi.returnpolicy_description, pv.shipment_rate_type,pv.shipment_rate_id,pv.created_at,pi.category_id,pi.product_info_id,pv.product_variation_id,pi.title,pi.slug,pv.product_ID,pv.product_ID_type,pv.base_price,pv.sell_price,pv.quantity,pv.seller_id,(SELECT GROUP_CONCAT(pro_img.`image`) FROM `product_images` as pro_img where pro_img.product_variation_id=pv.product_variation_id order by pro_img.featured_image desc ) as image,pv.product_variation_info,pv.seller_SKU,pv.product_ID,pv.product_ID_type,pv.quantity,pa.maximum_retail_price,pa.sale_price,pa.is_gift_wrap_available,pa.sale_start_date,pa.sale_end_date,pv.seller_description,pv.warranty_description,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=1 group by product_variation_id) as rating1,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=2 group by product_variation_id) as rating2,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=3 group by product_variation_id) as rating3,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=4 group by product_variation_id) as rating4,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=5 group by product_variation_id) as rating5,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id group by product_variation_id) as total_rating,(select sum(rating)/count(product_review_id) from product_review where product_variation_id=pv.product_variation_id group by product_variation_id) as sum_rating,(select sum(rating)/count(product_review_id) from product_review where product_variation_id=pv.product_variation_id group by product_variation_id) as sum_rating,(SELECT CONCAT(count(pro_r.`product_review_id`),",",sum(pro_r.`rating`)) as seller_rating FROM product_review as pro_r join product_variations as pro_v on pro_v.product_variation_id=pro_r.product_variation_id join users on users.user_id=pro_v.seller_id  where pv.seller_id=users.user_id and pro_r.status=1 group by pro_v.seller_id) as seller_rating,(select count(product_variation_id) from product_variations where product_variations.product_info_id=pv.product_info_id group by product_info_id) as variation_count,(SELECT GROUP_CONCAT(product_variation_info separator "==:==") as seller_rating FROM product_variations where product_variations.product_info_id=pv.product_info_id and product_variations.status=1 and product_variations.admin_approvel=1 and product_variations.quantity>0 and '.$condition.') as product_variations_multiple');
		$this->db->from('products_info as pi');
		//$this->db->join('product_images as pimg','pimg.product_info_id=pi.product_info_id');
		$this->db->join('product_variations as pv','pv.product_info_id=pi.product_info_id','inner');
		$this->db->join('users as u','u.user_id=pv.seller_id');	
		$this->db->join('product_offers as pa','pa.product_variation_id=pv.product_variation_id','left');
		$this->db->join('product_review as pr','pv.product_variation_id=pr.product_variation_id','left');	
		$this->db->join('product_seo as ps','ps.product_info_id=pi.product_info_id','left');
		$this->db->where('pv.status',1);
		$this->db->where('pv.admin_approvel',1);
		$this->db->where(str_replace('product_variations.product_variation_info','pv.product_variation_info',$condition));
		$this->db->where('pv.product_info_id',$product_info_id);
		$this->db->group_by('pi.product_info_id');
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows()>0)
				return $query->row();
		else
				return FALSE;
	}
	function product_details_ajax($product_variation_id='',$colour='')
	{
		$this->db->query('SET SESSION group_concat_max_len = 1000000000');
		$this->db->select('pv.commision_fee,pi.accepted_returnpolicy, pi.return_policydays, pi.returnpolicy_description, pv.shipment_rate_type,pv.shipment_rate_id,pv.created_at,pi.category_id,pi.product_info_id,pv.product_variation_id,pi.title,pi.slug,pv.product_ID,pv.product_ID_type,pv.base_price,pv.sell_price,pv.quantity,pv.seller_id,(SELECT GROUP_CONCAT(pro_img.`image`) FROM `product_images` as pro_img where pro_img.product_variation_id=pv.product_variation_id order by pro_img.featured_image desc ) as image,pv.product_variation_info,pv.seller_SKU,pv.product_ID,pv.product_ID_type,pv.quantity,pa.maximum_retail_price,pa.sale_price,pa.is_gift_wrap_available,pa.sale_start_date,pa.sale_end_date,pv.seller_description,pv.warranty_description,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=1 group by product_variation_id) as rating1,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=2 group by product_variation_id) as rating2,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=3 group by product_variation_id) as rating3,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=4 group by product_variation_id) as rating4,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id and rating=5 group by product_variation_id) as rating5,(select count(product_review_id) from product_review where product_variation_id=pv.product_variation_id group by product_variation_id) as total_rating,(select sum(rating)/count(product_review_id) from product_review where product_variation_id=pv.product_variation_id group by product_variation_id) as sum_rating,(select sum(rating)/count(product_review_id) from product_review where product_variation_id=pv.product_variation_id group by product_variation_id) as sum_rating,(SELECT CONCAT(count(pro_r.`product_review_id`),",",sum(pro_r.`rating`)) as seller_rating FROM product_review as pro_r join product_variations as pro_v on pro_v.product_variation_id=pro_r.product_variation_id join users on users.user_id=pro_v.seller_id  where pv.seller_id=users.user_id and pro_r.status=1 group by pro_v.seller_id) as seller_rating,(select count(product_variation_id) from product_variations where product_variations.product_info_id=pv.product_info_id group by product_info_id) as variation_count,(SELECT GROUP_CONCAT(product_variation_info separator "==:==") as seller_rating FROM product_variations where product_variations.product_info_id=pv.product_info_id and product_variations.status=1 and product_variations.admin_approvel=1 and product_variations.quantity>0 and json_contains(product_variations.product_variation_info,\'{"colour" : "'.$colour.'"}\')) as product_variations_multiple');
		$this->db->from('products_info as pi');
		//$this->db->join('product_images as pimg','pimg.product_info_id=pi.product_info_id');
		$this->db->join('product_variations as pv','pv.product_info_id=pi.product_info_id','inner');
		$this->db->join('users as u','u.user_id=pv.seller_id');	
		$this->db->join('product_offers as pa','pa.product_variation_id=pv.product_variation_id','left');
		$this->db->join('product_review as pr','pv.product_variation_id=pr.product_variation_id','left');	
		$this->db->join('product_seo as ps','ps.product_info_id=pi.product_info_id','left');
		$this->db->where('pv.status',1);
		$this->db->where('pv.admin_approvel',1);
		$this->db->where('pv.product_variation_id',$product_variation_id);
		$this->db->group_by('pi.product_info_id');
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows()>0)
				return $query->row();
		else
				return FALSE;
	}
	function getOfferavailable($product_variation_id)
	{
		$this->db->select('pv.product_variation_id,pv.product_ID,pv.product_ID_type,pv.base_price,pv.sell_price,pv.quantity,pv.seller_id,u.first_name,u.last_name,u.user_name,pv.seller_SKU,pv.quantity,pv.type_of_product');
		$this->db->from('product_variations as pv');
		$this->db->join('users as u','u.user_id=pv.seller_id');	
		$this->db->where('pv.status',1);
		$this->db->where('pv.admin_approvel',1);
		$this->db->where('pv.parent_id',$product_variation_id);
		$query = $this->db->get();
		if($query->num_rows()>0)
				return $query->result();
		else
				return array();			
	}
	function get_attributes($attribute_code)
	{
		$this->db->select('attribute_code');
		$this->db->where('attribute_map',0);
		$this->db->where_in('attribute_code',$attribute_code);
		$query = $this->db->get('attributes');
		if($query->num_rows()>0)
			return $query->result();
		else
			return FALSE;
	}
	function get_product_image($product_info_id,$colour)
	{
		$this->db->select('pi.image,pi.product_variation_id');
		$this->db->where('pv.status',1);
		$this->db->where('json_contains(pv.product_variation_info,\'{"colour" : "'.$colour.'"}\')');
		$this->db->where('pv.admin_approvel',1);
		$this->db->where('pi.featured_image',1);
		$this->db->where('pi.product_info_id',$product_info_id);
		$this->db->join('product_variations as pv','pv.product_variation_id=pi.product_variation_id');
		$query = $this->db->get('product_images as pi');
		//echo $this->db->last_query();
		if($query->num_rows()>0)
			return $query->row();
		else
			return FALSE;
	}

	function product_viewed($product_variation_id='')
	{
		$user_id = user_id();
		if(!empty($product_variation_id)){
			if(!empty($user_id)){
				$this->db->select('pv.product_viewed_id');
				$this->db->where('product_variation_id', $product_variation_id);
				$this->db->where('user_id', $user_id);
				$query = $this->db->get('product_viewed as pv');
				if($query->num_rows()>0){
					$this->db->where('product_variation_id', $product_variation_id);
					$data = array(
						'time' => date('Y-m-d H:i:s A')
					);
					$query = $this->db->update('product_viewed', $data);
				}else{
					$data = array(
						'user_id' => $user_id, 
						'product_variation_id' => $product_variation_id,
						'user_ip' => $this->input->ip_address(),
						'time' => date('Y-m-d H:i:s A')
					);
					$query=$this->db->insert('product_viewed', $data);
				}
				return true;
			}else{
				$this->db->select('pv.product_viewed_id');
				$this->db->where('product_variation_id', $product_variation_id);
				$this->db->where('user_ip', $this->input->ip_address());
				$query = $this->db->get('product_viewed as pv');
				if($query->num_rows()>0){
					$this->db->where('product_variation_id', $product_variation_id);
					$data = array(
						'time' => date('Y-m-d H:i:s A')
					);
					$query = $this->db->update('product_viewed', $data);
				}else{
					$data = array( 
						'product_variation_id' => $product_variation_id,
						'user_ip' => $this->input->ip_address(),
						'time' => date('Y-m-d H:i:s A')
					);
					$query=$this->db->insert('product_viewed', $data);
				}
				return true;
			}
		}
	}

}
