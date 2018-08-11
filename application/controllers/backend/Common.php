<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Common extends CI_Controller {
	public function __construct(){ 
		parent::__construct(); 
		$this->load->model('superadmin_model');
		//if (superadmin_logged_in() === FALSE) redirect('behindthescreen'); //check login authentication
	} 
	public function change_status($table='',$col='',$value='',$status='') {
        if($table=='' || $col=='' || $value=='' || $status=='') redirect($_SERVER['HTTP_REFERER']);
        $update_status= array('status'=>$status);
        if($this->superadmin_model->update($table,$update_status,array($col=>$value))){
            if($table=='users'){
               $getUserRole = $this->common_model->get_row($table, array($col=>$value), array('user_role'));
                if(!empty($getUserRole)){
                    if($table=='users' && $col=='user_id' && $getUserRole->user_role==1){
                        $msg = ($status==1) ? "Seller activated successfully" : "Seller deactivated successfully";
                    }else if($table=='users' && $col=='user_id' && $getUserRole->user_role==2){
                        $msg = ($status==1) ? "Customer activated successfully" : "Customer deactivated successfully";
                    }else{
                        $msg = "Status updated successfully";
                    }
                }else{
                    $msg = "Status updated successfully";
                } 
            }else{
                $msg = "Status updated successfully";
            }
            $this->session->set_flashdata('msg_success', $msg);
        }else {
            $this->session->set_flashdata('msg_warning','Something went wrong! Please try again');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function change_adminstatus($table='',$col='',$value='',$statuscol='',$status='') {
        if($table=='' || $col=='' || $value=='' || $status=='') redirect($_SERVER['HTTP_REFERER']);
        $update_status= array($statuscol=>$status);
		if($this->superadmin_model->update($table,$update_status,array($col=>$value))) {
            $this->session->set_flashdata('msg_success','Status updated successfully');
        }else {
            $this->session->set_flashdata('msg_warning','Something went wrong! Please try again');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }

	public function delete($table='',$col='',$value=''){ 
		if($table=='' || $col=='' || $value=='') redirect($_SERVER['HTTP_REFERER']);
		$data = $this->common_model->get_row($table, array($col => $value));
		if (!$data) redirect($_SERVER['HTTP_REFERER']); 
		if ($this->common_model->delete($table, array($col => $value))){ 
			$this->session->set_flashdata('msg_success', 'Data deleted successfully'); 
		}else{ 
			$this->session->set_flashdata('msg_error', 'Something went wrong! Please try again'); 
		} 
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function autocomplete()
	{
		if(!empty($_GET) && !empty($_GET['attribute_code']) &&  $data=$this->common_model->get_row('attributes',array('attribute_code'=>$_GET['attribute_code']),array('attribute_value'))){
			$data=json_decode($data->attribute_value);
			$input=$_GET['query'];
			$result = array_filter($data, function ($item) use ($input) {
			    if (stripos($item, $input) !== false) {
			        return true;
			    }
			    return false;
			});
			echo json_encode(array_values($result));
		}
	}


    public function getCountryData() {
        $country_code = $this->input->post('country_code');

        if (!$country_code) {
            $optionData = "";
            echo json_encode(array('status' => 'failed', 'optionData' => $optionData));
            die();
        } else {
            $data = $this->common_model->get_row('countries', array('phonecode' => $country_code));
            if($data) {
                $optionData = $data->id;
                echo json_encode(array('status' => 'success', 'optionData' => $optionData));
                die();
            } else {
                $optionData = "";
                echo json_encode(array('status' => 'failed', 'optionData' => $optionData));
                die();
            }
        }
    }

	public function getStateData() {
        $country = $this->input->post('country');
        $selected = '';
        $state = '';
        $country_code = '';

        if (!$country) {
            $optionData = "<option value=''>--Select State--</option>";
            echo json_encode(array('status' => 'failed', 'optionData' => $optionData));
            die();
        } else {
            $countryData = $this->common_model->get_row('countries', array('id' => $country), array('phonecode'));
            $data = $this->common_model->get_result('states', array('country_id' => $country), '', array('name', 'asc'));
            if ($data){
                if(!empty($countryData)){
                    $country_code = $countryData->phonecode;
                }
                $optionData = "<option value=''>--Select State--</option>";
                foreach ($data as $row) {
                    $optionData .= "<option value='".$row->id."'>" . $row->name ."</option>";
                    $selected = '';
                }
                echo json_encode(array('status' => 'success', 'optionData' => $optionData, 'country_code'=>$country_code));
                die();
            } else {
                $optionData = "<option value=''>--Select State--</option>";
                echo json_encode(array('status' => 'failed', 'optionData' => $optionData, 'country_code'=>$country_code));
                die();
            }
        }
    }

    
    public function getCityData()
    {
        $country = $this->input->post('country');
        $state = $this->input->post('state');
        $selected = "";

        if(!$state){
            $optionData = "<option value=''>--Select City--</option>";
            echo json_encode(array('status'=>'failed','optionData'=>$optionData));
            die(); 
        }else{
            $data = $this->common_model->get_result('cities',array('state_id'=>$state), '', array('name','asc'));
            //echo $this->db->last_query(); die;
            if($data){
                $optionData = "<option value=''>--Select City--</option>";
                foreach ($data as $row) {
                    $optionData .= "<option value='" . $row->id . "'>" . $row->name ."</option>";
                }
                echo json_encode(array('status'=>'success','optionData'=>$optionData));
                die();
            }else{
                $optionData = "<option value=''>--Select City--</option>";
                echo json_encode(array('status'=>'failed','optionData'=>$optionData));
                die();
            }
        }
    }
	
    public function updateQuantity() {
        $variationID = $this->input->post('variationID');
        $value       = $this->input->post('value');
        if(!$variationID && !$value){
            echo json_encode(array('status'=>'failed','msg'=>'The quantity field is required'));
            die(); 
        }else{
            $data = $this->common_model->update('product_variations',array('quantity'=>$value),array('product_variation_id'=>$variationID));
            //echo $this->db->last_query(); die;
            if($data){
                echo json_encode(array('status'=>'success','msg'=>'The quantity updated successfully'));
                die();
            }else{
                echo json_encode(array('status'=>'failed','msg'=>'The quantity not updated. please try again'));
                die();
            }
        }
    }
    public function updateSellPrice() {
        $variationID = $this->input->post('variationID');
        $value       = $this->input->post('value');
        if(!$variationID && !$value){
            echo json_encode(array('status'=>'failed','msg'=>'The Retail Price(MRP) field is required'));
            die(); 
        }else{
            $data = $this->common_model->update('product_variations',array('sell_price'=>$value),array('product_variation_id'=>$variationID));
            //echo $this->db->last_query(); die;
            if($data){
                echo json_encode(array('status'=>'success','msg'=>'The Retail Price(MRP) updated successfully'));
                die();
            }else{
                echo json_encode(array('status'=>'failed','msg'=>'Sorry! Updation process has been failed. Please try again'));
                die();
            }
        }
    }
    public function updateBasePrice() {
        $variationID = $this->input->post('variationID');
        $value       = $this->input->post('value');
        if(!$variationID && !$value){
            echo json_encode(array('status'=>'failed','msg'=>'The Sell Price field is required'));
            die(); 
        }else{
            $data = $this->common_model->update('product_variations',array('base_price'=>$value),array('product_variation_id'=>$variationID));
            //echo $this->db->last_query(); die;
            if($data){
                echo json_encode(array('status'=>'success','msg'=>'The Sell price updated successfully'));
                die();
            }else{
                echo json_encode(array('status'=>'failed','msg'=>'Sorry! Updation process has been failed. Please try again'));
                die();
            }
        }
    }

    public function getShippingTypeOption($shippingType='', $shippingTitle='')
    {
        $shippingType = $this->input->post('shippingType');
        $shippingTitle = $this->input->post('shippingTitle');
        $result = "";

        $dataRow = $this->common_model->get_row('shipping_option',array('parent_id'=>$shippingType));
        $data = $this->common_model->get_result('shipping_option',array('parent_id'=>$shippingType));

        if(!empty($data)){
            $result .= "<div id='optionTag".$shippingType."'> <div class='col-md-4'>fill the ".$shippingTitle." values - </div>";
            foreach ($data as $row) {
                $result .= "<div class='col-md-3'><input data-bvalidator='required' data-bvalidator-msg='please enter ".$row->title."' class='form-control' type='text' name='shippping_type[".$shippingType."][".$row->shipping_option_id."]' placeholder='".$row->title."'></div>";
            }
            $result .= "<br></div>";
            echo json_encode(array('status' => 'success', 'data'=>$result));
        }else{
            echo json_encode(array('status' => 'failed', 'data'=>$result));
        }    
    }

}
	