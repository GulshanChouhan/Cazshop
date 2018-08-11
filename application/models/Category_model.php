<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Category_model extends CI_Model {
	function fetchCategoryTree($parent = 0, $spacing = '', $user_tree_array = '') {
		if (!is_array($user_tree_array))
			$user_tree_array = array();
		$sql = "SELECT c.category_id,c.category_name,c.order_by,c.status,c.logo_image,c.created_at,c.short_description,c.category_slug,c.parent_id,(SELECT GROUP_CONCAT(ca.`category_name`) FROM `category` as ca where ca.parent_id=c.category_id ) as sub_category_name,(SELECT count(pi.`product_info_id`) as pcount FROM `products_info` as pi join product_variations as pv on pv.product_info_id=pi.product_info_id WHERE pv.admin_approvel=1 and pv.status=1 and FIND_IN_SET(c.category_id,pi.category_id) GROUP by pi.`category_id` order by pcount desc limit 1) as product_count FROM `category` as c WHERE  `parent_id` = $parent ORDER BY category_name ASC";
		$query=$this->db->query($sql); 
		//$query=$this->db->get();
		
		if ($query->num_rows()> 0) {
			foreach($query->result() as $row) {
			  $row->category_name= $spacing.ucwords($row->category_name);
			  $user_tree_array[] = $row;
			  $user_tree_array = $this->fetchCategoryTree($row->category_id,$spacing .'', $user_tree_array);
			}
		  }
		  return $user_tree_array;
	}
	function changeStatus($parent = 0, $spacing = '', $user_tree_array = '',$status=0) {
		if (!is_array($user_tree_array))
			$user_tree_array = array();
		$sql = "SELECT category_id,category_name FROM `category` WHERE 1 AND `parent_id` = $parent ORDER BY category_name ASC";
		$query=$this->db->query($sql);
		//$query=$this->db->get();
		
		if ($query->num_rows()> 0) {
			foreach($query->result() as $row) {
			  $this->db->query('UPDATE `category` SET status='.$status.' where category_id='.$row->category_id);

			  $user_tree_array[] = $row;
			  $user_tree_array = $this->changeStatus($row->category_id,$spacing .'&nbsp;&nbsp;&nbsp;&nbsp;- ', $user_tree_array,$status);
			}
		  }
			return $user_tree_array;
	}
	function deleteCategory($parent = 0, $spacing = '', $user_tree_array = '') {
		if (!is_array($user_tree_array))
			$user_tree_array = array();
		$sql = "SELECT category_id,category_name FROM `category` WHERE 1 AND `parent_id` = $parent ORDER BY category_name ASC";
		$query=$this->db->query($sql);
		//$query=$this->db->get();
		
		if ($query->num_rows()> 0) {
			foreach($query->result() as $row) {
			  $this->db->query('DELETE FROM `category` WHERE category_id='.$row->category_id);

			  $user_tree_array[] = $row;
			  $user_tree_array = $this->deleteCategory($row->category_id,$spacing .'&nbsp;&nbsp;&nbsp;&nbsp;- ', $user_tree_array);
			}
		  }
			return $user_tree_array;
	}
	function getCategoryTree($categorys='')
	{
		$category_id='';
		if(!empty($categorys) && sizeof($categorys))
			$category_id=$categorys[0];
		$cat_query = "SELECT category_id, category_name, parent_id,category_slug,(SELECT count(pi.`product_info_id`) as pcount FROM `products_info` as pi join product_variations as pv on pv.product_info_id=pi.product_info_id WHERE pv.admin_approvel=1 and pv.status=1 and FIND_IN_SET(category.category_id,pi.category_id) GROUP by pi.`category_id` order by pcount desc limit 1) as product_count FROM category where status=1 ORDER BY parent_id, category_id";
		$query = $this->db->query($cat_query);
		$parent_id=0;
		$temp=array();
		foreach($query->result_array() as $result){
			if($result['category_id']==$category_id)
			{
				$temp[]=$result['category_id'];
				$category['categories'][$result['category_id']] = $result;
	   			$category['parent_cats'][$result['parent_id']][] = $result['category_id'];	
			}else if(in_array($result['parent_id'],$temp)){
				$temp[]=$result['category_id'];
				$category['categories'][$result['category_id']] = $result;
	   			$category['parent_cats'][$result['parent_id']][] = $result['category_id'];
			}
		}
		return $this->buildCategory(0,$category,$categorys);
		
	}
	function buildCategory($parent=0, $category,$category_active) {
	    $html = "";
	    if (isset($category['parent_cats'][$parent])) {
	        $html .= "<ul>";
	        foreach ($category['parent_cats'][$parent] as $cat_id) {

	            if (!isset($category['parent_cats'][$cat_id])) {
	            	if($category['categories'][$cat_id]['product_count']>=0)
	            	{
		                $html .= "<li class=";
		                if(in_array($category['categories'][$cat_id]['category_id'],$category_active)) $html.='active'; else $html.='';
		                $html .="> <a href='".base_url('p/'.$category['categories'][$cat_id]['category_slug'])."'>" . ucwords($category['categories'][$cat_id]['category_name']). "</a></li>";
		            }
				}
	            if (isset($category['parent_cats'][$cat_id])) {
	            	if($category['categories'][$cat_id]['product_count']>=0)
	            	{
		            	$html .= "<li class=";
		                if(in_array($category['categories'][$cat_id]['category_id'],$category_active)) $html.='active'; else $html.='category';
		                $html .="> <a href='".base_url('p/'.$category['categories'][$cat_id]['category_slug'])."'>" .ucwords($category['categories'][$cat_id]['category_name']). "</a> ";
		                $html .=$this-> buildCategory($cat_id,$category,$category_active);
		                $html .= "</li>";
			        }
	            }
	        }
	        $html .= "</ul> ";
	    }
	    return $html;
	}
	
}