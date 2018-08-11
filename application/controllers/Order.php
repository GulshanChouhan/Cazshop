<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Order extends CI_Controller {
	public function __construct(){ 
		parent::__construct(); 
		$this->session->keep_flashdata('message');
		$this->load->library('cart');
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->library('Ajax_pagination');
		$this->perPage = 20;
	} 

	private function _check_login(){
		if(user_logged_in()===FALSE){
			redirect('page/login');
		}else{
			$info = $this->common_model->get_row('users',array('user_id'=>user_id()));
	    	if(empty($info)){
	    		$this->cart->destroy();
				$this->session->unset_userdata('shipping_address_id');
				$this->session->unset_userdata('user_info');
				redirect('page/login');
	    	}
		}
	}

	/* Get Frontend customer invoice */
	public function invoice($order_detail_id=''){ 
	    $this->_check_login(); //check login authentication
	    $data['title']='Customer Invoice';
	    $order_detail_id = base64_decode($order_detail_id);
	    $data['order_info'] = $order_info = $this->common_model->get_orderdetails($order_detail_id, 2, user_id());
	    if(empty($order_info)) redirect($_SERVER['HTTP_REFERER']);
	    $data['order_detail_id'] = $order_detail_id;
	    $this->load->view('order-invoices',$data);

	}

	/* Cancellation process */
   	public function cancellation_process($order_detail_id='', $subject_of_reason='', $msg_of_reason='')
   	{
   		if(user_logged_in()===FALSE){
   			$data = json_encode(array('status'=>'failed', 'msg'=>'Something went wrong! please try again'));
	   		echo $data;	
   		}else{
	   		$this->form_validation->set_rules('subject_of_reason', 'Reason', 'trim|required');
			$this->form_validation->set_rules('msg_of_reason', 'Message', 'trim|required');
			$this->form_validation->set_error_delimiters('', '');
	   	    if ($this->form_validation->run() == TRUE){
	   			$order_detail_id = base64_decode($_POST['order_detail_id']);
		   		$subject_of_reason = $_POST['subject_of_reason'];
		   		$msg_of_reason = $_POST['msg_of_reason'];
		   		$order_status = $_POST['order_status'];

	   			$data = $this->common_model->checkCalcellationProduct($order_detail_id, 2, user_id());
	   			if(!empty($data)){
	   				$data = array("order_status"=>$order_status);
	   				if($this->common_model->update('order_details', $data, array('order_detail_id'=>$order_detail_id))){
				        $orderStatusData = array(
							'user_role'   			=> 2,
							'user_id' 				=> user_id(),
							'order_detail_id' 	    => $order_detail_id,
							'subject_of_reason' 	=> $subject_of_reason,
							'msg_of_reason' 	    => $msg_of_reason,
							'status' 	    		=> $order_status,
							'created' 		   		=> date('Y-m-d H:i:s A')
						);

						$successStatusID = $this->common_model->insert('order_status', $orderStatusData);
						if($successStatusID){

							//-------------For Send email AND SMS to customer and Admin-----------
					        $email_template = $this->common_model->get_row('email_templates', array('id'=>17));
					        if(!empty($email_template)){

					        	$data['orders_details'] =  $this->common_model->get_result('order_details',array('order_detail_id'=>$order_detail_id));
					        	if(!empty($data['orders_details'])){
					              	$data['order_info'] =  $this->common_model->get_row('orders',array('o_id'=>$data['orders_details'][0]->order_table_id)); 
					              	if(!empty($data['order_info'])){
					              		
					              		$shipping_addresess = json_decode($data['order_info']->shipping_address);
										//==-----------===Send Email==-----------
							            if($email_template->template_email_enable==1){

							                $userRole  = 2; //for Customer
							                $to        = $shipping_addresess->email_id;
							                $param     = array(
							                    'site_name'           => SITE_NAME,
							                    'user_role'           => "Customer",
							                    'reason'              => orderCancellationReason($subject_of_reason),
							                    'description'         => $msg_of_reason,
							                    'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true))
							                );
							                $sendEmail = sendEmail($email_template, $to, $param, $userRole);


							                $userRole  = 0; //for Admin
							                $adminEMAIl= get_option_url('EMAIl');
							                $to      = (!empty($adminEMAIl)) ? $adminEMAIl : SUPPORT_EMAIL;
							                $param     = array(
							                    'site_name'           => SITE_NAME,
							                    'user_role'           => SITE_NAME." Administrator",
							                    'reason'              => orderCancellationReason($subject_of_reason),
							                    'description'         => $msg_of_reason,
							                    'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true))
							                );
							                $sendEmailAdmin = sendEmail($email_template, $to, $param, $userRole);
							            }

							            //==-----------===Send SMS==-----------===
							            if($email_template->template_sms_enable==1){

							              $userRole  = 2; //for Customer
							              $to      = ($shipping_addresess->country_code) ? '+'.$shipping_addresess->country_code.''.$shipping_addresess->phone_no : $shipping_addresess->phone_no;
							              $param     = array(
							                    'site_name'           => SITE_NAME,
							                    'user_role'           => "Customer",
							                    'reason'              => orderCancellationReason($subject_of_reason),
							                    'description'         => $msg_of_reason,
							                    'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true))
							              );
							              $sendSMS = sendSMS($email_template, $to, $param, $userRole);


							              $userRole  = 0; //for Admin
							              $to      = get_option_url('PHONE');
							              $param     = array(
							                    'site_name'           => SITE_NAME,
							                    'user_role'           => SITE_NAME." Administrator",
							                    'reason'              => orderCancellationReason($subject_of_reason),
							                    'description'         => $msg_of_reason,
							                    'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true))
							              );
							              $sendSMSAdmin = sendSMS($email_template, $to, $param, $userRole);
							            }
							        }
							    }
					        }

							$data = json_encode(array('status'=>'success', 'msg'=>'Product has been cancelled successfully'));
		   					echo $data;
						}else{
							$data = json_encode(array('status'=>'failed', 'msg'=>'Sorry! Your cancellation process has been failed. please try again'));
		   					echo $data;
						}
				    }else{
				        $data = json_encode(array('status'=>'failed', 'msg'=>'Sorry! Your cancellation process has been failed. please try again'));
		   				echo $data; 
				    }
	   			}else{
	   				$data = json_encode(array('status'=>'failed', 'msg'=>'Sorry! This Product isn\'t available in the stock'));
	   				echo $data;
	   			}
	   		}else{
	   			$data = json_encode(array('status'=>'failed', 'msg'=>'Something went wrong! please try again.','validation_errors'=>validation_errors()));
	   			echo $data;	
	   		}
   		}	
   	}


	/* Return process */
   	public function return_process($order_detail_id='', $subject_of_reason='', $msg_of_reason='')
   	{
   	    if(user_logged_in()===FALSE){
	   		$data = json_encode(array('status'=>'failed', 'msg'=>'Something went wrong! please try again.'));
		   	echo $data;	
   		}else{
   			$this->form_validation->set_rules('subject_of_reason', 'Reason', 'trim|required');
			$this->form_validation->set_rules('msg_of_reason', 'Message', 'trim|required');
			$this->form_validation->set_error_delimiters('', '');
   			if ($this->form_validation->run() == TRUE){
	   			$order_detail_id = base64_decode($_POST['order_detail_id']);
		   		$subject_of_reason = $_POST['subject_of_reason'];
		   		$msg_of_reason = $_POST['msg_of_reason'];
		   		$order_status = $_POST['order_status'];

	   			$data = $this->common_model->checkReturnProduct($order_detail_id, 2, user_id());
	   			if(!empty($data)){
	   				$data = array("order_status"=>$order_status);
	   				if($this->common_model->update('order_details', $data, array('order_detail_id'=>$order_detail_id))){
				        $orderStatusData = array(
							'user_role'   			=> 2,
							'user_id' 				=> user_id(),
							'order_detail_id' 	    => $order_detail_id,
							'subject_of_reason' 	=> $subject_of_reason,
							'msg_of_reason' 	    => $msg_of_reason,
							'status' 	    		=> $order_status,
							'created' 		   		=> date('Y-m-d H:i:s A')
						);

						$successStatusID = $this->common_model->insert('order_status', $orderStatusData);
						if($successStatusID){

							//-------------For Send email AND SMS to customer and Admin-----------
					        $email_template = $this->common_model->get_row('email_templates', array('id'=>18));
					        if(!empty($email_template)){

					        	$data['orders_details'] =  $this->common_model->get_result('order_details',array('order_detail_id'=>$order_detail_id));
					        	if(!empty($data['orders_details'])){
					              	$data['order_info'] =  $this->common_model->get_row('orders',array('o_id'=>$data['orders_details'][0]->order_table_id)); 
					              	if(!empty($data['order_info'])){
					              		$shipping_addresess = json_decode($data['order_info']->shipping_address);
										//==-----------===Send Email==-----------
							            if($email_template->template_email_enable==1){

							                $userRole  = 2; //for Customer
							                $to        = $shipping_addresess->email_id;
							                $param     = array(
							                    'site_name'           => SITE_NAME,
							                    'user_role'           => "Customer",
							                    'reason'              => orderReturnReason($subject_of_reason),
							                    'description'         => $msg_of_reason,
							                    'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true))
							                );
							                $sendEmail = sendEmail($email_template, $to, $param, $userRole);


							                $userRole  = 0; //for Admin
							                $adminEMAIl= get_option_url('EMAIl');
							                $to      = (!empty($adminEMAIl)) ? $adminEMAIl : SUPPORT_EMAIL;
							                $param     = array(
							                    'site_name'           => SITE_NAME,
							                    'user_role'           => SITE_NAME." Administrator",
							                    'reason'              => orderReturnReason($subject_of_reason),
							                    'description'         => $msg_of_reason,
							                    'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true))
							                );
							                $sendEmailAdmin = sendEmail($email_template, $to, $param, $userRole);
							            }

							            //==-----------===Send SMS==-----------===
							            if($email_template->template_sms_enable==1){

							              $userRole  = 2; //for Customer
							              $to      = ($shipping_addresess->country_code) ? '+'.$shipping_addresess->country_code.''.$shipping_addresess->phone_no : $shipping_addresess->phone_no;
							              $param     = array(
							                    'site_name'           => SITE_NAME,
							                    'user_role'           => "Customer",
							                    'reason'              => orderReturnReason($subject_of_reason),
							                    'description'         => $msg_of_reason,
							                    'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true))
							              );
							              $sendSMS = sendSMS($email_template, $to, $param, $userRole);


							              $userRole  = 0; //for Admin
							              $to      = get_option_url('PHONE');
							              $param     = array(
							                    'site_name'           => SITE_NAME,
							                    'user_role'           => SITE_NAME." Administrator",
							                    'reason'              => orderReturnReason($subject_of_reason),
							                    'description'         => $msg_of_reason,
							                    'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true))
							              );
							              $sendSMSAdmin = sendSMS($email_template, $to, $param, $userRole);
							            }
							        }
							    }
					        }

							$data = json_encode(array('status'=>'success', 'msg'=>'Your return request has been submitted successfully, We\'re processing your request and will respond to you as soon as possible'));
		   					echo $data;
						}else{
							$data = json_encode(array('status'=>'failed', 'msg'=>'Your return request process has been failed. please try again'));
		   					echo $data;
						}
				    }else{
				        $data = json_encode(array('status'=>'failed', 'msg'=>'Your return request process has been failed. please try again'));
		   				echo $data; 
				    }
	   			}else{
	   				$data = json_encode(array('status'=>'failed', 'msg'=>'This Product isn\'t available in the stock'));
	   				echo $data;
	   			}
	   		}else{
	   			$data = json_encode(array('status'=>'failed', 'msg'=>'Something went wrong! please try again..','validation_errors'=>validation_errors()));
	   			echo $data;	
	   		}
   		}	
   	}


	public function billing_info()
	{
		$this->_check_login(); //check  login authentication
		$data['title']='Billing Information';

		$data['ProductInfo'] = $ProductInfo = $this->session->userdata('buyProductInfo');
		$data['product_amountInfo'] = $product_amountInfo = $this->session->userdata('product_amountInfo');

		if(empty($ProductInfo) || empty($product_amountInfo)){
			$this->session->set_flashdata('msg_error', 'Before accessing this page, You have to choose atleast one item');
			redirect(base_url('p'));
		}

		$data['phnCode']=$this->common_model->get_result('countries',array(),'',array('name','asc'));
		$data['shipping_addresess']=$this->common_model->get_result('shipping_addresess',array('user_id'=>user_id(), 'status'=>1),'',array('shipping_address_id','desc'));
	    $data['template']='frontend/order/billing_info';
	    $this->load->view('templates/frontend/front_template',$data);
	}

	public function payment($shipping_addresessId = '')
	{
		$this->_check_login(); //check  login authentication
		$data['title']='Payment Information';
		$shipping_addresessId = base64_decode($shipping_addresessId);

		$productAndAmountInfo = $this->productAndAmountInfo($shipping_addresessId);
		$data['ProductInfo'] = $ProductInfo = $this->session->userdata('buyProductInfo');
		$data['product_amountInfo'] = $product_amountInfo = $this->session->userdata('product_amountInfo');
		/*p($data['ProductInfo']);
		p($data['product_amountInfo']); die;*/
		if(empty($ProductInfo) || empty($product_amountInfo)){
			$this->session->set_flashdata('msg_error', 'Before accessing this page, You have to choose atleast one item');
			redirect(base_url('p'));
		}

		$data['shipping_addresess'] = $shipping_addresess =  $this->common_model->get_row('shipping_addresess',array('shipping_address_id'=>$shipping_addresessId, 'user_id'=>user_id(), 'status'=>1));
		if(empty($shipping_addresess)){
			$this->session->set_flashdata('msg_error', 'The selected address isn\'t correct. You have to forwarded atleast one valid address'); 
			redirect(base_url('order/billing_info'));
		}

		$data['shipping_addresessId'] = $shipping_addresessId;
	    $data['template']='frontend/order/payment';
	    $this->load->view('templates/frontend/front_template',$data);
	}


	public function removeProduct($product_variation_id = '', $shipping_addresessId = '')
	{
		$this->_check_login(); //check  login authentication

		$shipping_addresessId = base64_decode($shipping_addresessId);
		$product_variation_id = base64_decode($product_variation_id);
		$ProductInfo = $this->session->userdata('buyProductInfo');
		$product_amountInfo = $this->session->userdata('product_amountInfo');

		$shippingTotalCharges = 0.00;
		if(!empty($ProductInfo)){
			$shipping_addresess =  $this->common_model->get_row('shipping_addresess',array('shipping_address_id'=>$shipping_addresessId, 'user_id'=>user_id(), 'status'=>1));

			foreach ($ProductInfo as $key => $item) {
				if($key==$product_variation_id){
					unset($ProductInfo[$key]);
				}else{
					if($item->sale_start_date!='' && $item->sale_start_date<=date('Y-m-d') && $item->sale_end_date!='' && $item->sale_end_date>=date('Y-m-d')){
						$item->base_price = $item->sale_price;
					}
					$total += $item->base_price;
					$shippingTotalCharges 	+= $item->shipping_charges;
				}
			}

			$product_amountInfo = array('type'=> $product_amountInfo['type'], 'grossAmount'=> $total, 'totalAmount'=> $total, 'shipping_charges'=>$shippingTotalCharges);
			$this->session->set_userdata("buyProductInfo", $ProductInfo);
			$this->session->set_userdata("product_amountInfo", $product_amountInfo);
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function directPayment($shipping_addresessId='')
	{
		//$this->_check_login(); //check  login authentication
		//$shipping_addresessId = base64_decode($shipping_addresessId);
		$shipping_addresess =  $this->common_model->get_row('shipping_addresess',array('shipping_address_id'=>$shipping_addresessId, 'user_id'=>user_id(), 'status'=>1));
		if(empty($shipping_addresess)){
			$this->session->set_flashdata('msg_error', 'The selected address isn\'t correct. You have to forwarded atleast one valid address'); 
			redirect(base_url('order/billing_info'));
		}

		$ProductInfo = $this->session->userdata('buyProductInfo');
		$product_amountInfo = $this->session->userdata('product_amountInfo');
		
		if(empty($ProductInfo) || empty($product_amountInfo)){
			$this->session->set_flashdata('msg_error', 'Before accessing this page, You have to choose atleast one item');
			redirect(base_url('p'));
		}else{

			$grossAmount = $product_amountInfo['totalAmount'];
			$shipping_charges = round($product_amountInfo['shipping_charges'], 2);
			$totalAmount = round($product_amountInfo['totalAmount'] + $product_amountInfo['shipping_charges'], 2);
			$order_id = $this->generateOrderNo();

			$total_items = count($ProductInfo);
			$orderData = array(
				'user_id' 			=> user_id(),
				'order_id' 			=> $order_id,
				'shipping_charges' 	=> $shipping_charges,
				'total_amount' 		=> $totalAmount,
				'gross_amount' 		=> $grossAmount,
				'currency_type' 	=> 3,
				'currency_amount' 	=> 0.00,
				'transaction_id' 	=> '',
				'total_items' 		=> $total_items,
				'payment_method' 	=> '',
				'payment_status' 	=> '',
				'other_payment_info'=> '',
				'order_status' 		=> 1,
				'cancelled_info' 	=> '',
				'discount_amount' 	=> '',
				'discount_code' 	=> '',
				'shipping_address' 	=> json_encode($shipping_addresess),
				'shipping_addressId'=> $shipping_addresessId,
				'created' 			=> date('Y-m-d H:i:s A')
			);

			if($id = $this->common_model->insert('orders', $orderData)){
    			foreach ($ProductInfo as $row) {

    				$sellerIdFor_product = $row->seller_id;
    				$subtotal =  round($row->base_price + $row->shipping_charges,2);

    				$orderDetailsData = array(
						'order_table_id'   => $id,
						'seller_id' 	   => $sellerIdFor_product,
						'user_id' 		   => user_id(),
						'product_id' 	   => $row->product_variation_id,
						'quantity' 		   => 1,
						'price' 		   => $row->base_price,
						'subtotal' 	       => $subtotal,
						'order_status' 	   => 1,
						'shipping_charges' => $row->shipping_charges,
						'product_details'  => json_encode($row),
						'created' 		   => date('Y-m-d H:i:s A')
					);
					$successID = $this->common_model->insert('order_details', $orderDetailsData);
					if($successID){
						$quantityDeducted = $this->db->query('update product_variations set quantity=quantity-1 where product_variation_id='.$row->product_variation_id);
						if($quantityDeducted){
							$product_variation_info = $this->common_model->get_row('product_variations',array('product_variation_id'=>$row->product_variation_id));
							if(!empty($product_variation_info) && $product_variation_info->quantity<=0){
								$this->sendOutOfStockEmail($row->product_variation_id);
							}
						}
					}
    			}

    			$this->sendOrderPlacedEmailToAdminOrCustomer($id);
    			if($product_amountInfo['type']==2){
    				$this->cart->destroy();
    			}

    			$this->session->unset_userdata('buyProductInfo');
    			$this->session->unset_userdata('product_amountInfo');

    			$this->session->set_flashdata('msg_error', 'Congratulations, Your order has been placed successfully');
    			redirect('order/payment_successful/'.$id); 
    		}else{
    			$this->session->set_flashdata('msg_error', 'Sorry! Your order placed process has been failed. please try again'); 
        		redirect('order/payment/'.$shipping_addresessId); 
    		}
		}

	}

    public function payment_successful($o_id='')
	{
		$this->_check_login(); //check  login authentication
		$data['title']='Payment Successful';
		$data['order_info'] =  $this->common_model->get_row('orders',array('o_id'=>$o_id, 'user_id'=>user_id()));	
		if(empty($data['order_info'])) redirect(base_url());

		$this->form_validation->set_rules('message', 'Message', 'trim|required|max_length[500]');
	    $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	    if($this->form_validation->run() == TRUE){

	    	$updateData = array(
    			'order_msg' 	 => $this->input->post('message')
    		);

			if($this->common_model->update('orders', $updateData, array('o_id'=>$o_id))){
				$this->session->set_flashdata('msg_success','Your feedback has been submitted successfully');
                redirect('order/payment_successful/'.$o_id);
			}else{
				$this->session->set_flashdata('msg_error','Sorry! Updation process has been failed. Please try again');
				redirect('order/payment_successful/'.$o_id);
			}
	    }

		$data['orders_details'] =  $this->common_model->get_result('order_details',array('order_table_id'=>$o_id));
	    $data['template']='frontend/order/payment_successful';
	    $this->load->view('templates/frontend/front_template',$data);
	}

	public function insertBillingdata()
	{
		$this->_check_login(); //check  login authentication

    	if(!empty($_POST)){
    		$shipping_address_id = base64_decode($_POST['shipping_address_id']);
    		
			$insertData = array(
    			'user_id' 	 => user_id(),
    			'first_name' => $_POST['first_name'],
    			'last_name'  => $_POST['last_name'],
    			'email_id'   => $_POST['email_id'],
    			'country_code'    => $_POST['country_code'],
    			'country'    => $_POST['country'],
    			'state'      => $_POST['state'],
    			'city'       => $_POST['city'],
    			'zip_code'   => $_POST['zip_code'],
    			'address'    => $_POST['address'],
    			'phone_no'   => $_POST['phone_no'],
    			'status' 	 => $_POST['status']
    		);
			if(empty($shipping_address_id) || $shipping_address_id==''){
				if($id = $this->common_model->insert('shipping_addresess', $insertData)){
					$responceShippingAdd = $this->productAndAmountInfo1(base64_encode($id));
					if($responceShippingAdd){
						echo json_encode(array('status' => 'success', 'msg'=>'Your billing address information added successfully')); 
					}else{
						echo json_encode(array('status' => 'failed', 'msg'=>'Sorry! Billing address insertion process has been failed. please try again')); 
					}
	    		}else{
	    			echo json_encode(array('status' => 'failed', 'msg'=>'Sorry! Billing address insertion process has been failed. please try again'));
	    		}
			}else{

				$shipping_addresess =  $this->common_model->get_row('shipping_addresess',array('shipping_address_id'=>$shipping_address_id, 'user_id'=>user_id()));
				if(empty($shipping_addresess)){
	    			echo json_encode(array('status' => 'failed', 'msg'=>'No Billing Address found'));
	    		}else{
	    			if($this->common_model->update('shipping_addresess',$insertData,array('shipping_address_id'=>$shipping_address_id))) {	
		    			echo json_encode(array('status' => 'success', 'msg'=>'Your billing address information updated successfully'));  
		    		}else{
		    			echo json_encode(array('status' => 'failed', 'msg'=>'Sorry! Billing address updation process has been failed. please try again'));
		    		}
	    		}
			}
    		
    	}else{
    		echo json_encode(array('status' => 'failed', 'msg'=>'Something went wrong! please try again.'));
    	}  

	}

	public function buy_product($type='', $product_variation_id='')
	{
		/*-------===========
			$type = 1 (For directly buy)
			$type = 2 (For buy using cart system )
		=========----------*/
		$product_tempinfo = array();
		$product_variation_id = base64_decode($product_variation_id);

		if($type==1 && !empty($product_variation_id)){
			$product_info = $this->product_model->product_details($product_variation_id);
			if(!empty($product_info)){
				if($product_info->quantity > 0 && $product_info->quantity!=''){
					if($product_info->sale_start_date!='' && $product_info->sale_start_date<=date('Y-m-d') && $product_info->sale_end_date!='' && $product_info->sale_end_date>=date('Y-m-d')){
						$product_info->base_price = $product_info->sale_price;
					}
					$product_tempinfo[$product_variation_id] = $product_info;
					$product_amountInfo = array('type'=> $type, 'grossAmount'=>$product_info->base_price, 'totalAmount'=>$product_info->base_price);
					$this->session->set_userdata('buyProductInfo', $product_tempinfo);
					$this->session->set_userdata('product_amountInfo', $product_amountInfo);
					redirect('cart/index');
				}else{
					$this->session->set_flashdata('msg_error', 'This product isn\'t available in the stock'); 
					redirect(base_url('pd/'.$product_info->slug.'/'.$product_info->product_variation_id));
				}
			}else{
				$this->session->set_flashdata('msg_error', 'This product isn\'t available in the stock'); 
				redirect(base_url('p'));
			}
		}else if($type==2 && empty($product_variation_id)){
			
			$cartData = $this->cart->contents();
			if(!empty($cartData)){

				$total = 0;
				foreach ($cartData as $key => $value) {
					$product_info = $this->product_model->product_details($value['id']);
					if(!empty($product_info)){
						if($product_info->quantity > 0 && $product_info->quantity!=''){
							if($product_info->sale_start_date!='' && $product_info->sale_start_date<=date('Y-m-d') && $product_info->sale_end_date!='' && $product_info->sale_end_date>=date('Y-m-d')){
								$product_info->base_price = $product_info->sale_price;
							}
							$total += $product_info->base_price;
							$product_tempinfo[$product_info->product_variation_id] = $product_info;
						}
					}
				}

				$product_amountInfo = array('type'=> $type, 'grossAmount'=> $total, 'totalAmount'=> $total);
				$this->session->set_userdata('buyProductInfo', $product_tempinfo);
				$this->session->set_userdata('product_amountInfo', $product_amountInfo);
				redirect('cart/index');
			}else{
				$this->session->set_flashdata('msg_error', 'Your Bag is empty'); 
				redirect(base_url('cart/index'));
			}
		}
	}


	public function add_to_wishlist($product_variation_id='')
	{
		$this->_check_login(); //check  login authentication

		$product_variation_id = base64_decode($product_variation_id);
		$product_info = $this->product_model->product_details($product_variation_id);
		if(!empty($product_info) && !empty($product_variation_id)){
    		
			$wishListProduct = $this->common_model->get_row('wish_list', array('user_id'=>user_id(), 'product_variation_id'=>$product_variation_id));

    		if(empty($wishListProduct)){

	    		$insertData = array(
	    			'user_id' 	 		   	=> user_id(),
	    			'product_variation_id' 	=> $product_variation_id,
	    			'product_variation_info'=> json_encode($product_info),
	    			'created' 		       	=> date('Y-m-d H:i:s A')
	    		);

	    		if($id = $this->common_model->insert('wish_list', $insertData)){
	    			$this->session->set_flashdata('success', 'Product has been added successfully in your wishlist'); 
	    			redirect($_SERVER['HTTP_REFERER']);
	    		}else{
	    			$this->session->set_flashdata('msg_error', 'Sorry! Product isn\'t added in your wishlist. please try again'); 
					redirect($_SERVER['HTTP_REFERER']); 
	    		}
	    	}else{
    			$this->session->set_flashdata('msg_error', 'This product is already available in your wishlist'); 
				redirect($_SERVER['HTTP_REFERER']);
    		}
    	}else{
    		$this->session->set_flashdata('msg_error', 'This product isn\'t available in the stock'); 
			redirect($_SERVER['HTTP_REFERER']);
    	} 
	}

	public function remove_from_wishlist($product_variation_id='')
	{
		$this->_check_login(); //check  login authentication

		$product_variation_id = base64_decode($product_variation_id);
		$product_info = $this->product_model->product_details($product_variation_id);
		if(!empty($product_info) && !empty($product_variation_id)){
    		if ($this->common_model->delete('wish_list', array('product_variation_id' => $product_variation_id, 'user_id'=>user_id()))){ 
    			$this->session->set_flashdata('success', 'Product has been removed successfully from your wishlist'); 
				redirect($_SERVER['HTTP_REFERER']); 
    		}else{
    			$this->session->set_flashdata('msg_error', 'Sorry! Product removing process has been failed. please try again');
				redirect($_SERVER['HTTP_REFERER']); 
    		}
    	}else{
    		$this->session->set_flashdata('msg_error', 'This product isn\'t available in the stock'); 
			redirect($_SERVER['HTTP_REFERER']);
    	} 
	}


	public function add_to_wishlist_using_ajax($product_variation_id='')
	{
		$this->_check_login(); //check  login authentication

		$product_variation_id = base64_decode($_POST['product_variation_id']);
		$product_info = $this->product_model->product_details($product_variation_id);
		
		if(!empty($product_info) && !empty($product_variation_id)){
    		
			$wishListProduct = $this->common_model->get_row('wish_list', array('user_id'=>user_id(), 'product_variation_id'=>$product_variation_id));

    		if(empty($wishListProduct)){

	    		$insertData = array(
	    			'user_id' 	 		   	=> user_id(),
	    			'product_variation_id' 	=> $product_variation_id,
	    			'product_variation_info'=> json_encode($product_info),
	    			'created' 		       	=> date('Y-m-d H:i:s A')
	    		);

	    		if($id = $this->common_model->insert('wish_list', $insertData)){
	    			echo json_encode(array('status'=>'success', 'msg'=>'Product has been added successfully in your wishlist'));
    				die;
	    		}else{
	    			echo json_encode(array('status'=>'error', 'msg'=>'Sorry! Product isn\'t added in your wishlist. please try again'));
    				die; 
	    		}
	    	}else{
	    		echo json_encode(array('status'=>'error', 'msg'=>'This product is already available in your wishlist'));
    			die; 
    		}
    	}else{
    		echo json_encode(array('status'=>'error', 'msg'=>'This product isn\'t available in the stock'));
    		die; 
    	} 
	}

	public function remove_from_wishlist_using_ajax($product_variation_id='')
	{
		$this->_check_login(); //check  login authentication

		$product_variation_id = base64_decode($_POST['product_variation_id']);
		$product_info = $this->product_model->product_details($product_variation_id);
		if(!empty($product_info) && !empty($product_variation_id)){
    		if ($this->common_model->delete('wish_list', array('product_variation_id' => $product_variation_id, 'user_id'=>user_id()))){ 
    			echo json_encode(array('status'=>'success', 'msg'=>'Product has been removed successfully from your wishlist'));
    			die;
    		}else{
    			echo json_encode(array('status'=>'error', 'msg'=>'Sorry! Product removing process has been failed. please try again'));
    			die;
    		}
    	}else{
    		echo json_encode(array('status'=>'error', 'msg'=>'This product isn\'t available in the stock'));
    		die;
    	} 
	}

	public function productAndAmountInfo1($shipping_addresessId='')
	{
		if(user_logged_in()===FALSE){
			echo json_encode(array('status'=>'failed', 'msg'=>'You have to login first'));
		}else{

			$shipping_addresessId = base64_decode($shipping_addresessId);
			$ProductInfo = $this->cart->contents();

			$total = 0.00;
			$shippingTotalCharges = 0.00;

			if(!empty($ProductInfo)){
				$shipping_addresess =  $this->common_model->get_row('shipping_addresess',array('shipping_address_id'=>$shipping_addresessId, 'user_id'=>user_id(), 'status'=>1));
				if(!empty($shipping_addresess)){
					foreach ($ProductInfo as $key => $item) {
						$shippingCharges 		 = shipping_charges($item['id'], $shipping_addresess->country, $shipping_addresess->state, $shipping_addresess->city, '');
						if(isset($shippingCharges['Normal_Shipping'])){

							$total += $item['subtotal'];
							$ProductInfo[$key]['shipping_method'] = 1;
							$ProductInfo[$key]['min_day'] = $shippingCharges['Normal_Shipping']->min_day;
							$ProductInfo[$key]['max_day'] = $shippingCharges['Normal_Shipping']->max_day;
							$ProductInfo[$key]['shipping_charges'] = $shippingCharges['Normal_Shipping']->price;
							$shippingTotalCharges 	+= $shippingCharges['Normal_Shipping']->price;

						}else if(isset($shippingCharges['Express_Shipping'])){

							$total += $item['subtotal'];
							$ProductInfo[$key]['shipping_method'] = 2;
							$ProductInfo[$key]['max_day'] = $shippingCharges['Express_Shipping']->max_day;
							$ProductInfo[$key]['min_day'] = $shippingCharges['Express_Shipping']->min_day;
							$ProductInfo[$key]['shipping_charges'] = $shippingCharges['Express_Shipping']->price;
							$shippingTotalCharges 	+= $shippingCharges['Express_Shipping']->price;

						}else if(isset($shippingCharges['method'])){

							$ProductInfo[$key]['shipping_method'] = 'Free Shipping';
							$ProductInfo[$key]['max_day'] = '0';
							$ProductInfo[$key]['min_day'] = '0';
							$ProductInfo[$key]['shipping_charges'] = '0.00';

						}else{

							unset($ProductInfo[$key]['shipping_method']);
							unset($ProductInfo[$key]['max_day']);
							unset($ProductInfo[$key]['min_day']);
							unset($ProductInfo[$key]['shipping_charges']);
						}
					}

					$this->cart->destroy();
					$this->cart->insert($ProductInfo);
					$this->session->set_userdata("shipping_address_id", $shipping_addresessId);
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
	}

	public function productAndAmountInfo($shipping_addresessId='')
	{
		$this->_check_login(); //check  login authentication
		$ProductInfo = $this->session->userdata('buyProductInfo');
		$product_amountInfo = $this->session->userdata('product_amountInfo');

		$shippingTotalCharges = 0.00;
		if(!empty($ProductInfo)){
			$shipping_addresess =  $this->common_model->get_row('shipping_addresess',array('shipping_address_id'=>$shipping_addresessId, 'user_id'=>user_id(), 'status'=>1));
			foreach ($ProductInfo as $key => $item) {
				$shippingCharges 		 = shipping_charges($item->product_variation_id, $shipping_addresess->country, $shipping_addresess->state, $shipping_addresess->city);
		
				$shippingTotalCharges 	+= $shippingCharges;
				$ProductInfo[$key]->shipping_charges = $shippingCharges;
			}
		
			$product_amountInfo['shipping_charges'] = $shippingTotalCharges;
			$this->session->set_userdata("buyProductInfo", $ProductInfo);
			$this->session->set_userdata("product_amountInfo", $product_amountInfo);
		}else{
			return false;
		}
	}


	private function generateOrderNo()
	{
		$no = rand(0, 999999999999);
		$no = str_pad($no, 12, "0", STR_PAD_LEFT);
		return $no;
	}


	public function authenticate(){

		if(user_logged_in()===TRUE){
			echo json_encode(array('status'=>'failed', 'msg'=>'You have already logged in.', 'validation'=>0));
			die;
		}else{
			if(empty($_POST)){
				echo json_encode(array('status'=>'failed', 'msg'=>'Something went wrong! please try again', 'validation'=>0));
				die;
			}else{
				if(isset($_POST['type']) && $_POST['type']==1){
					$this->form_validation->set_rules('password', 'Password', 'trim|required');
					$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
					$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
					
					if ($this->form_validation->run() == TRUE){
						$email = $this->input->post('email');
			       		$password = $this->input->post('password');
						if($this->user_model->login($email,$password,'customers')){
							$user_name = user_name();
							echo json_encode(array('status'=>'success', 'msg'=>'Hello '.$user_name.', You have logged in successfully', 'validation'=>0));
							die;
						}else{
							echo json_encode(array('status'=>'failed', 'msg'=>'Incorrect Email Or Password', 'validation'=>0));
							die;
						}
					}else{
						echo json_encode(array('status'=>'failed', 'msg'=>'', 'validation'=>validation_errors()));
						die;
					}
				}

				if(isset($_POST['type']) && $_POST['type']==2){
					$this->form_validation->set_rules('name', 'Full Name', 'trim|required');
			    	$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
			    	$this->form_validation->set_rules('country_code', 'Country Code', 'trim|required');
			    	$this->form_validation->set_rules('mobile', 'Mobile No.', 'trim|required|numeric|min_length[9]|max_length[13]');
			    	$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]'); 
			    	$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
			    	$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			    	if ($this->form_validation->run() == TRUE){

			    		$salt = $this->salt();
			    		$insert = [
				    		'user_name' => $this->input->post('name'),
				    		'salt' => $salt,
				    		'user_role' => 2,
				    		'status' => 1,
				    		'country_code' => $this->input->post('country_code'),
				    		'mobile' => $this->input->post('mobile'),
				    		'email' => $this->input->post('email'),
			    			'password' => sha1($salt.sha1($salt.sha1($this->input->post('password')))),
			    			'created' => date('Y-m-d H:i:s A'),
			        		'modified' => date('Y-m-d H:i:s A')
			    		];

			    		if($id = $this->common_model->insert('users', $insert)){
			    			if($this->user_model->login($this->input->post('email'),$this->input->post('password'),'customers')){

			    				//-------------For Send email AND SMS-----------

				    			$email_template = $this->common_model->get_row('email_templates', array('id'=>1));
				    			if(!empty($email_template)){
				        			
				        			//==-----------===Send Email==-----------
				        			if($email_template->template_email_enable==1){

						    			$userRole  = 2; //for Customer
						    			$to 	   = $this->input->post('email');
						    			$param 	   = array(
						                    'name'            => ucwords($this->input->post('name')),
						                    'user_email'      => $this->input->post('email'),
						                    'password'        => $this->input->post('password'),
						                    'contactus_link'  => base_url('page/contact'),
						                );
						    			$sendEmail = sendEmail($email_template, $to, $param, $userRole);


						    			$userRole  = 0; //for Admin
						    			$adminEMAIl= get_option_url('EMAIl');
						    			$to 	   = (!empty($adminEMAIl)) ? $adminEMAIl : SUPPORT_EMAIL;
						    			$param 	   = array(
						                    'name'            => ucwords($this->input->post('name')),
						                    'user_email'      => $this->input->post('email'),
						                    'password'        => $this->input->post('password'),
						                    'contactus_link'  => base_url('page/contact'),
						                );
						    			$sendEmailAdmin = sendEmail($email_template, $to, $param, $userRole);
						    		}

						    		//==-----------===Send SMS==-----------===
						    		if($email_template->template_sms_enable==1){

						    			$userRole  = 2; //for Customer
						    			$to 	   = ($this->input->post('country_code')) ? '+'.$this->input->post('country_code').''.$this->input->post('mobile') : $this->input->post('mobile');
						    			$param 	   = array(
						                    'name'            => ucwords($this->input->post('name')),
						                    'user_email'      => $this->input->post('email'),
						                    'password'        => $this->input->post('password'),
						                    'contactus_link'  => base_url('page/contact'),
						                );
						    			$sendSMS = sendSMS($email_template, $to, $param, $userRole);


						    			$userRole  = 0; //for Admin
						    			$to 	   = get_option_url('PHONE');
						    			$param 	   = array(
						                    'name'            => ucwords($this->input->post('name')),
						                    'user_email'      => $this->input->post('email'),
						                    'password'        => $this->input->post('password'),
						                    'contactus_link'  => base_url('page/contact'),
						                );
						    			$sendSMSAdmin = sendSMS($email_template, $to, $param, $userRole);
						    		}

						    	}
				                //-------------**For Send email AND SMS-----------
			    				
								echo json_encode(array('status'=>'success', 'msg'=>'Thanks to be registered! A confirmation email has been sent on your registered email address', 'validation'=>0));
								die;
							}else{
								echo json_encode(array('status'=>'failed', 'msg'=>'Sorry! Registration process has been failed. please try again', 'validation'=>0));
								die;
							}
			    		}else{
			    			echo json_encode(array('status'=>'failed', 'msg'=>'Sorry! Registration process has been failed. please try again', 'validation'=>0));
							die; 
			    		}
			    	}else{
			    		echo json_encode(array('status'=>'failed', 'msg'=>'', 'validation'=>validation_errors()));
						die;
			    	}
				}
			}
		}

	}


	/* Get Product data using ajax */
   	function getShippingAddressData($aId='')
   	{
   		$selected = '';
   		$data = array();
   		$stateData = array();
   		$optionData = array();
   		
   		if(isset($_POST)){
   			$aId = $_POST['aId'];
   			$data = $this->common_model->get_row('shipping_addresess', array('shipping_address_id'=> base64_decode($aId)));
   			if(!empty($data)){
   				
   				$dataStates = $this->common_model->get_result('states',array('country_id'=>$data->country), '', array('name','asc'));
   				if(!empty($dataStates)){
   					$stateData = "<option value=''>--Select State--</option>";
	                foreach ($dataStates as $row) {
	                	if($row->id==$data->state){
	                		$selected = 'selected="selected"';
	                	}
	                    $stateData .= "<option value='" . $row->id . "' ".$selected.">" . $row->name ."</option>";
	                    $selected = '';
	                }
   				}

   				$dataCities = $this->common_model->get_result('cities',array('state_id'=>$data->state), '', array('name','asc'));
   				if(!empty($dataCities)){
   					$optionData = "<option value=''>--Select City--</option>";
	                foreach ($dataCities as $row) {
	                	if($row->id==$data->city){
	                		$selected = 'selected="selected"';
	                	}
	                    $optionData .= "<option value='" . $row->id . "' ".$selected.">" . $row->name ."</option>";
	                    $selected = '';
	                }
   				}
   				$data = json_encode(array('status'=>'success', 'data'=>$data, 'stateData'=>$stateData, 'cityData'=>$optionData));
   				echo $data;
   			}else{
   				$data = json_encode(array('status'=>'failed', 'data'=>$data));
   				echo $data;
   			}
   		}else{
   			$data = json_encode(array('status'=>'failed', 'data'=>$data));
   			echo $data;	
   		}	
   	}

   	function salt() {
		return substr(md5(uniqid(rand(), true)), 0, 10);
	}

	private function sendOutOfStockEmail($product_variation_id=''){

		//-------------For Send email AND SMS-----------
        $email_template = $this->common_model->get_row('email_templates', array('id'=>14));
        if(!empty($email_template)){

          $product_variations = $this->common_model->get_row('product_variations', array('product_variation_id' => $product_variation_id));
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
                        'product_detail_link' => '<a target="_blank" href="'.base_url('seller/products/edit_product_basic_info/'.$product_variations->product_info_id.'/'.$product_variations->product_variation_id.'/'.$product_variations->type_of_product).'">Click here to view/edit the details of this product</a>'
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

                  $userRole  = 1; //for Customer
                  $to      = ($seller_info->country_code) ? '+'.$seller_info->country_code.''.$seller_info->mobile : $seller_info->mobile;
                  $param     = array(
                      'site_name'           => SITE_NAME,
                      'seller_name'         => ucfirst($seller_info->user_name),
                      'product_title'       => ucfirst($product_info->title),
                      'product_id'          => $product_variations->product_ID,
                      'product_type'        => $productTypeName,
                      'product_detail_link' => '<a target="_blank" href="'.base_url('seller/products/edit_product_basic_info/'.$product_variations->product_info_id.'/'.$product_variations->product_variation_id.'/'.$product_variations->type_of_product).'">Click here to view/edit the details of this product</a>'
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

          }
        }
        //-------------**For Send email AND SMS-----------
	}


	public function sendOrderPlacedEmailToAdminOrCustomer($o_id=''){

		//-------------For Send email AND SMS-----------
        $email_template = $this->common_model->get_row('email_templates', array('id'=>15));
        if(!empty($email_template)){

        	$data['order_info'] =  $this->common_model->get_row('orders',array('o_id'=>$o_id, 'user_id'=>user_id()));	
			$data['orders_details'] =  $this->common_model->get_result('order_details',array('order_table_id'=>$o_id));

			if(!empty($data['order_info']) && !empty($data['orders_details'])){

				$shipping_addresess = json_decode($data['order_info']->shipping_address);
				//==-----------===Send Email==-----------
	            if($email_template->template_email_enable==1){

	                $userRole  = 2; //for Customer
	                $to        = $shipping_addresess->email_id;
	                $param     = array(
	                    'site_name'           => SITE_NAME,
	                    'user_role'           => "Customer",
	                    'short_description'   => "Your Order has been placed successfully. Below are the details of your Item's",
	                    'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true))
	                );
	                $sendEmail = sendEmail($email_template, $to, $param, $userRole);


	                $userRole  = 0; //for Admin
	                $adminEMAIl= get_option_url('EMAIl');
	                $to      = (!empty($adminEMAIl)) ? $adminEMAIl : SUPPORT_EMAIL;
	                $param     = array(
	                    'site_name'           => SITE_NAME,
	                    'user_role'           => SITE_NAME." Administrator",
	                    'short_description'   => "New Order has been placed. Below are the details of the Item's",
	                    'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true))
	                );
	                $sendEmailAdmin = sendEmail($email_template, $to, $param, $userRole);
	            }

	            //==-----------===Send SMS==-----------===
	            if($email_template->template_sms_enable==1){

	              $userRole  = 2; //for Customer
	              $to      = ($shipping_addresess->country_code) ? '+'.$shipping_addresess->country_code.''.$shipping_addresess->phone_no : $shipping_addresess->phone_no;
	              $param     = array(
	                    'site_name'           => SITE_NAME,
	                    'user_role'           => "Customer",
	                    'short_description'   => "Your Order has been placed successfully. Below are the details of your Item's",
	                    'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true))
	                );
	              $sendSMS = sendSMS($email_template, $to, $param, $userRole);


	              $userRole  = 0; //for Admin
	              $to      = get_option_url('PHONE');
	              $param     = array(
	                    'site_name'           => SITE_NAME,
	                    'user_role'           => SITE_NAME." Administrator",
	                    'short_description'   => "New Order has been placed. Below are the details of the Item's",
	                    'item_details'        => trim($this->load->view('templates/email/order_placed',$data,true))
	              );
	              $sendSMSAdmin = sendSMS($email_template, $to, $param, $userRole);
	            }
			}
        }
        //-------------**For Send email AND SMS-----------
	}

	public function success()
	{
		$input = @file_get_contents("php://input");
        echo "<pre>"; var_dump($input);
	}

}	