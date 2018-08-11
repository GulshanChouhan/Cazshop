<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cart extends CI_Controller {
	public function __construct(){ 
		parent::__construct(); 
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

	public function index(){

		$data['title']='My Bag';
		$data['phnCode']=$this->common_model->get_result('countries',array(),'',array('name','asc'));
		$data['shipping_addresess']=$this->common_model->get_result('shipping_addresess',array('user_id'=>user_id(), 'status'=>1),'',array('shipping_address_id','desc'));

		$data['template']='frontend/cart/cartpage';
	    $this->load->view('templates/frontend/front_template',$data);
	}

	

	public function add_to_cart()
	{
		$data['title']='My Bag';
		if(isset($_POST) && !empty($_POST) && !empty($_POST['pid'])){
			$pid = $_POST['pid'];
			$this->addToCartProcess($pid);
		}else{
			$this->session->set_flashdata('msg_error', 'Something went wrong! please try again'); 
			redirect('cart/index');
		}
	}


	public function add_to_cart_using_wishList($pid="")
	{
		$data['title']='My Bag';
		if(!empty($pid) && $pid!=''){
			$this->addToCartProcess($pid);
		}else{
			$this->session->set_flashdata('msg_error', 'Something went wrong! please try again'); 
			redirect('cart/index');
		}
	}


	public function save_for_later($rowid='', $product_variation_id="")
	{
		$data['title']='Save for later';
		if($rowid=='' || $product_variation_id==''){
			$this->session->set_flashdata('msg_error', 'Something went wrong! please try again'); 
			redirect($_SERVER['HTTP_REFERER']);
		}else{
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

		    			// Destroy selected rowid in session.
						$data = array(
							'rowid' => $rowid,
							'qty' => 0
						);
						// Update cart data, after cancel.
						$this->cart->update($data);

		    			$this->session->set_flashdata('msg_success', 'Product added successfully in your wishlist'); 
						redirect(base_url('cart/index')); 
		    		}else{
		    			$this->session->set_flashdata('msg_error', 'Sorry! Product isn\'t added in your wishlist. please try again'); 
						redirect(base_url('cart/index'));
		    		}
		    	}else{
	    			$this->session->set_flashdata('msg_error', 'This product is already available in your wishlist'); 
					redirect(base_url('cart/index'));
	    		}
	    	}else{
	    		$this->session->set_flashdata('msg_error', 'Sorry! This product isn\'t available in our stock'); 
				redirect(base_url('cart/index'));
	    	}
		}
	}


	public function remove($rowid) {
		// Check rowid value.
		if ($rowid==="all"){
			// Destroy data which store in session.
			$this->cart->destroy();
		}else{
			// Destroy selected rowid in session.
			$data = array(
			'rowid' => $rowid,
			'qty' => 0
			);
			// Update cart data, after cancel.
			$this->cart->update($data);
		}

		// This will show cancel data in cart.
		redirect('cart/index');
	}


	function update_cart(){

		// Recieve post values,calcute them and update
		$cart_info = $_POST['cart'] ;
		foreach( $cart_info as $id => $cart)
		{
			$rowid = $cart['rowid'];
			$price = $cart['price'];
			$amount = $price * $cart['qty'];
			$qty = $cart['qty'];

			$data = array(
				'rowid' => $rowid,
				'price' => $price,
				'amount' => $amount,
				'qty' => $qty
			);

			$this->cart->update($data);
		}
		redirect('cart/index');
	}


	public function notifications()
	{
		error_reporting(E_ALL);
        $input = @file_get_contents("php://input");
		if(!empty($input)){
			$dataaaaaa=array(
	            'responce_data1'        =>  $input
	        );
	        $this->common_model->insert('get_responce_data',$dataaaaaa);
			parse_str($input, $paymentArr);
			if($paymentArr['status']=='completed'){
				$getPaymentInfo = $this->common_model->getPaymentInfo($paymentArr['id'], $paymentArr['order_id']);
				if(!empty($getPaymentInfo)){
					$tempArray = json_decode($getPaymentInfo->other_info);
					$shipping_addresessId = $tempArray[0];
					$currencyType = $tempArray[1];
					$totalAmtInEth = $tempArray[2];
					$totalAmtInBtc = $tempArray[3];

					if(!empty($shipping_addresessId) && !empty($currencyType) && !empty($totalAmtInEth) && !empty($totalAmtInBtc)){
						//$shipping_addresessId = base64_decode($shipping_addresessId);
						$shipping_addresess =  $this->common_model->get_row('shipping_addresess',array('shipping_address_id'=>$shipping_addresessId,'user_id'=>$getPaymentInfo->user_id, 'status'=>1));
						if(empty($shipping_addresess)){
							$this->paymentIssueEmail($shipping_addresess, "The choosing address isn't correct. You have to forwarded atleast one address");
							die;
						}

						$ProductInfo = (array) json_decode($getPaymentInfo->cart_info);
						if(empty($ProductInfo)){
							$this->paymentIssueEmail($shipping_addresess, "Before accessing this page, You have to choose atleast one item");
							die;
						}else{
							$grossAmount 	= 0.00;
							$shippingTotal 	= 0.00;
							$totalAmount 	= 0.00;
							$order_id = $paymentArr['order_id'];
							$total_items = count($ProductInfo);
							$orderData = array(
								'user_id' 						=> $getPaymentInfo->user_id,
								'order_id' 						=> $order_id,
								'shipping_charges' 				=> $shippingTotal,
								'total_amount' 					=> $totalAmount,
								'gross_amount' 					=> $grossAmount,
								'currency_type' 				=> $currencyType,
								'currency_amount_in_bitcoin'	=> 0.00,
								'currency_amount_in_ethereum'	=> 0.00,
								'currency_amount_in_dollor'		=> 1,
								'transaction_id' 				=> '',
								'total_items' 					=> $total_items,
								'payment_method' 				=> $currencyType,
								'payment_status' 				=> '',
								'other_payment_info'			=> json_encode($paymentArr),
								'order_status' 					=> 1,
								'cancelled_info' 				=> '',
								'discount_amount' 				=> '',
								'discount_code' 				=> '',
								'shipping_address' 				=> json_encode($shipping_addresess),
								'shipping_addressId'			=> $shipping_addresessId,
								'created' 						=> date('Y-m-d H:i:s A')
							);
							
							if($id = $this->common_model->insert('orders', $orderData)){
								$this->barcode($order_id);
				    			foreach ($ProductInfo as $row) {
				    				$row = (array) $row;
				    				$other_shipping_details = array(
				    					'shipping_charges' 	=> $row['shipping_charges'],
				    					'shipping_method' 	=> $row['shipping_method'],
				    					'min_day' 			=> $row['min_day'],
				    					'max_day' 			=> $row['max_day']
				    				);

				    				$grossAmount 	+= $row['subtotal'];
									$shippingTotal 	+= round($row['shipping_charges'], 2);
									$totalAmount 	+= round($row['subtotal'] + $row['shipping_charges'], 2);

				    				$product_info 			=  json_decode($row['product_info']);
				    				$commision_percentage	=  ($product_info->commision_fee) ? $product_info->commision_fee : 0;
				    				$subtotal 				=  round($row['subtotal'] + $row['shipping_charges'],2);

				    				$orderDetailsData = array(
										'order_table_id'   		=> $id,
										'seller_id' 	   		=> $product_info->seller_id,
										'product_id' 	   		=> $row['id'],
										'quantity' 		   		=> 1,
										'price' 		   		=> $row['subtotal'],
										'subtotal' 	       		=> $subtotal,
										'order_status' 	   		=> 1,
										'shipping_charges' 		=> $row['shipping_charges'],
										'product_details'  		=> json_encode($product_info),
										'other_shipping_details'=> json_encode($other_shipping_details),
										'commision_percentage'	=> $commision_percentage,
										'created' 		   		=> date('Y-m-d H:i:s A')
									);
									$successID = $this->common_model->insert('order_details', $orderDetailsData);
									if($successID){

										$orderStatusData = array(
											'user_role'   			=> 2,
											'user_id' 				=> $getPaymentInfo->user_id,
											'order_detail_id' 	    => $successID,
											'status' 	    		=> 1,
											'created' 		   		=> date('Y-m-d H:i:s A')
										);

										$successStatusID = $this->common_model->insert('order_status', $orderStatusData);
										if($successStatusID){
											$quantityDeducted = $this->db->query('update product_variations set quantity=quantity-1 where product_variation_id='.$row['id']);
											if($quantityDeducted){
												$product_variation_info = $this->common_model->get_row('product_variations',array('product_variation_id'=>$row['id']));
												if(!empty($product_variation_info) && $product_variation_info->quantity<=2){
													$this->sendOutOfStockEmail($row['id']);
												}
											}
										}	
									}
				    			}
				    			
				    			$currencyAmtInEth = 0.00;
				    			$totalAmtInEthTemp = base64_decode($totalAmtInEth);
				    			if($totalAmtInEthTemp){
				    				$currencyAmtInEth = $totalAmtInEthTemp/$totalAmount;
				    			}

				    			$currencyAmtInBtc = 0.00;
				    			$totalAmtInBtcTemp = base64_decode($totalAmtInBtc);
				    			if($totalAmtInBtcTemp){
				    				$currencyAmtInBtc = $totalAmtInBtcTemp/$totalAmount;
				    			}

				    			$updateOrder = $this->db->query('update orders set shipping_charges='.$shippingTotal.', total_amount='.$totalAmount.', gross_amount='.$grossAmount.', currency_amount_in_ethereum='.$currencyAmtInEth.', currency_amount_in_bitcoin='.$currencyAmtInBtc.' where o_id='.$id);

				    			if($updateOrder){
				    				
				    				$this->sendOrderPlacedEmailToAdminOrCustomer($id,$getPaymentInfo->user_id);
				    				$this->cart->destroy();
					    			$this->session->unset_userdata('shipping_address_id');
					    			$this->common_model->delete('tempary_paymentinfo', array('temp_paymentinfo_id'=>$getPaymentInfo->temp_paymentinfo_id));
				    			}else{
				    				$this->paymentIssueEmail($shipping_addresess, "Sorry! Your order not placed successfully. Please try again");
									die;
				    			}
				    		}else{
				    			$this->paymentIssueEmail($shipping_addresess, "Sorry! Your order not placed successfully. Please try again");
								die;
				    		}
						}
					}
				}else{
					die('Something went wrong in your payment process. Please try again');
				}
			}
		}
	}


	public function paymentProcess($tempArr='')
	{
		$tempArray = json_decode(urldecode($tempArr));
		$shipping_addresessId = $tempArray[0];
		$currencyType = $tempArray[1];
		$totalAmtInEth = $tempArray[2];
		$totalAmtInBtc = $tempArray[3];

		if(!empty($shipping_addresessId) && !empty($currencyType) && !empty($totalAmtInEth) && !empty($totalAmtInBtc)){

			$shipping_addresess =  $this->common_model->get_row('shipping_addresess',array('shipping_address_id'=>$shipping_addresessId, 'user_id'=>user_id(), 'status'=>1));

			$ProductInfo = $this->cart->contents();
			$subtotal = array_sum(array_column($ProductInfo,'subtotal'));
			$shipping_charges = array_sum(array_column($ProductInfo,'shipping_charges'));
			$product_titles = implode(",", array_column($ProductInfo, "name"));
			$orderTotal = round($subtotal + $shipping_charges, 2);

			if(!empty($orderTotal) && !empty($shipping_addresess)){
				//
		        // A very simple PHP example that sends a HTTP POST to a remote site
		        //
		        $post = [
        		  "name"=> ALFACOIN_SHOP,
		          "secret_key"=> ALFACOIN_SECRET,
		          "password"=> ALFACOIN_PASSWORD,
		          "type"=> getCurrency($currencyType),
		          "amount"=> $orderTotal, //'1.42'
		          "order_id"=> $this->generateOrderId(),
		          "currency"=> DEFAULT_CURRENCY,
		          "description"=> $product_titles,
		          "options"=> [
		              "notificationURL" => base_url()."cart/notifications",
		              "redirectURL"=> base_url()."order/success",
		              "payerName"=> ucfirst($shipping_addresess->first_name).' '.ucfirst($shipping_addresess->last_name),
		              "payerEmail"=> $shipping_addresess->email_id,
		              /*"test"=> 1,
                	  "status"=> "completed"*/
		            ]
		        ];
		        //p($post); die;
		        $ch = curl_init();

		        curl_setopt($ch, CURLOPT_URL,"https://www.alfacoins.com/api/create");
		        curl_setopt($ch, CURLOPT_POST, 1);
		        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
		        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

		        // in real life you should use something like:
		        // curl_setopt($ch, CURLOPT_POSTFIELDS, 
		        // http_build_query(array('postvar1' => 'value1')));

		        // receive server response ...
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		        $server_output = curl_exec ($ch);

		        curl_close ($ch);

		        // further processing ....
		        if($server_output){
		          	$tempary_paymentinfo = array(
		          		'payment_info' => $server_output,
		          		'user_id'	=>user_id(),
		          		'cart_info' => json_encode($ProductInfo),
		          		'other_info' => json_encode($tempArray),
		          		'alfacoin_info' => json_encode($post)
		          	);

		          	if($id = $this->common_model->insert('tempary_paymentinfo', $tempary_paymentinfo)){
		          		$this->cart->destroy();
		          		redirect('cart/payment/'.base64_encode($id));
		          	}else{
		          		$this->session->set_flashdata('msg_error', 'Something went wrong. Please try again'); 
	        			redirect('cart/index');
		          	}
		        }else{
		          	$this->session->set_flashdata('msg_error', 'The choosing address isn\'t correct. You have to forwarded atleast one address'); 
	        		redirect('cart/index');
		        }
			}else{
				$this->session->set_flashdata('msg_error', 'Something went wrong. Please try again'); 
	        	redirect('cart/index');
			}
		}else{
			$this->session->set_flashdata('msg_error', 'Something went wrong. Please try again'); 
	        redirect('cart/index');
		}
	}


	public function payment($id=''){

		if(empty($id)) redirect(base_url('cart/index'));

		$id = base64_decode($id);
		$data['tempary_paymentinfo'] = $tempary_paymentinfo =  $this->common_model->get_row('tempary_paymentinfo',array('temp_paymentinfo_id'=>$id));
		if(empty($tempary_paymentinfo)) redirect(base_url('cart/index'));

		$data['title']='Payment';
	    $this->load->view('frontend/cart/payment_page',$data);
	}


	public function directPayment($tempArr='')
	{
		$this->_check_login(); //check  login authentication

		$tempArray = json_decode(urldecode($tempArr));
		$shipping_addresessId = $tempArray[0];
		$currencyType = $tempArray[1];
		$totalAmtInEth = $tempArray[2];
		$totalAmtInBtc = $tempArray[3];

		if(!empty($shipping_addresessId) && !empty($currencyType) && !empty($totalAmtInEth) && !empty($totalAmtInBtc)){

			//$shipping_addresessId = base64_decode($shipping_addresessId);
			$shipping_addresess =  $this->common_model->get_row('shipping_addresess',array('shipping_address_id'=>$shipping_addresessId, 'user_id'=>user_id(), 'status'=>1));
			if(empty($shipping_addresess)){
				$this->session->set_flashdata('msg_error', 'The choosing address isn\'t correct. You have to forwarded atleast one address'); 
				redirect(base_url('cart/index'));
			}

			$ProductInfo = $this->cart->contents();
			
			if(empty($ProductInfo)){
				$this->session->set_flashdata('msg_error', 'Before accessing this page, You have to choose atleast one item');
				redirect(base_url('cart/index'));
			}else{

				$grossAmount 	= 0.00;
				$shippingTotal 	= 0.00;
				$totalAmount 	= 0.00;

				$order_id = $this->generateOrderId();
				$total_items = count($ProductInfo);

				$orderData = array(
					'user_id' 						=> user_id(),
					'order_id' 						=> $order_id,
					'shipping_charges' 				=> $shippingTotal,
					'total_amount' 					=> $totalAmount,
					'gross_amount' 					=> $grossAmount,
					'currency_type' 				=> $currencyType,
					'currency_amount_in_bitcoin'	=> 0.00,
					'currency_amount_in_ethereum'	=> 0.00,
					'currency_amount_in_dollor'		=> 1,
					'transaction_id' 				=> '',
					'total_items' 					=> $total_items,
					'payment_method' 				=> '',
					'payment_status' 				=> '',
					'other_payment_info'			=> '',
					'order_status' 					=> 1,
					'cancelled_info' 				=> '',
					'discount_amount' 				=> '',
					'discount_code' 				=> '',
					'shipping_address' 				=> json_encode($shipping_addresess),
					'shipping_addressId'			=> $shipping_addresessId,
					'created' 						=> date('Y-m-d H:i:s A')
				);

				if($id = $this->common_model->insert('orders', $orderData)){
					$this->barcode($order_id);
	    			foreach ($ProductInfo as $row) {

	    				$other_shipping_details = array(
	    					'shipping_charges' 	=> $row['shipping_charges'],
	    					'shipping_method' 	=> $row['shipping_method'],
	    					'min_day' 			=> $row['min_day'],
	    					'max_day' 			=> $row['max_day']
	    				);

	    				$grossAmount 	+= $row['subtotal'];
						$shippingTotal 	+= round($row['shipping_charges'], 2);
						$totalAmount 	+= round($row['subtotal'] + $row['shipping_charges'], 2);

	    				$product_info 			=  json_decode($row['product_info']);
	    				$commision_percentage	=  ($product_info->commision_fee) ? $product_info->commision_fee : 0;
	    				$subtotal 				=  round($row['subtotal'] + $row['shipping_charges'],2);

	    				$orderDetailsData = array(
							'order_table_id'   		=> $id,
							'seller_id' 	   		=> $product_info->seller_id,
							'product_id' 	   		=> $row['id'],
							'quantity' 		   		=> 1,
							'price' 		   		=> $row['subtotal'],
							'subtotal' 	       		=> $subtotal,
							'order_status' 	   		=> 1,
							'shipping_charges' 		=> $row['shipping_charges'],
							'product_details'  		=> json_encode($product_info),
							'other_shipping_details'=> json_encode($other_shipping_details),
							'commision_percentage'	=> $commision_percentage,
							'created' 		   		=> date('Y-m-d H:i:s A')
						);
						$successID = $this->common_model->insert('order_details', $orderDetailsData);
						if($successID){

							$orderStatusData = array(
								'user_role'   			=> 2,
								'user_id' 				=> user_id(),
								'order_detail_id' 	    => $successID,
								'status' 	    		=> 1,
								'created' 		   		=> date('Y-m-d H:i:s A')
							);

							$successStatusID = $this->common_model->insert('order_status', $orderStatusData);
							if($successStatusID){
								$quantityDeducted = $this->db->query('update product_variations set quantity=quantity-1 where product_variation_id='.$row['id']);
								if($quantityDeducted){
									$product_variation_info = $this->common_model->get_row('product_variations',array('product_variation_id'=>$row['id']));
									if(!empty($product_variation_info) && $product_variation_info->quantity<=2){
										$this->sendOutOfStockEmail($row['id']);
									}
								}
							}	
						}
	    			}
	    			
	    			$currencyAmtInEth = 0.00;
	    			$totalAmtInEthTemp = base64_decode($totalAmtInEth);
	    			if($totalAmtInEthTemp){
	    				$currencyAmtInEth = $totalAmtInEthTemp/$totalAmount;
	    			}

	    			$currencyAmtInBtc = 0.00;
	    			$totalAmtInBtcTemp = base64_decode($totalAmtInBtc);
	    			if($totalAmtInBtcTemp){
	    				$currencyAmtInBtc = $totalAmtInBtcTemp/$totalAmount;
	    			}

	    			$updateOrder = $this->db->query('update orders set shipping_charges='.$shippingTotal.', total_amount='.$totalAmount.', gross_amount='.$grossAmount.', currency_amount_in_ethereum='.$currencyAmtInEth.', currency_amount_in_bitcoin='.$currencyAmtInBtc.' where o_id='.$id);

	    			if($updateOrder){
	    				
	    				$this->sendOrderPlacedEmailToAdminOrCustomer($id, user_id());
	    				$this->cart->destroy();
		    			$this->session->unset_userdata('shipping_address_id');

		    			$this->session->set_flashdata('msg_success', 'Congratulations! Your order placed successfully');
		    			redirect('order/payment_successful/'.$id);
	    			}else{
	    				$this->session->set_flashdata('msg_error', 'Sorry! Your order not added successfully. Please try again'); 
	        			redirect('cart/index');
	    			}
	    		}else{
	    			$this->session->set_flashdata('msg_error', 'Sorry! Your order not added successfully. Please try again'); 
	        		redirect('cart/index');
	    		}
			}
		}
	}


	public function addToCartProcess($pID='') {

		$pid = base64_decode($pID);
		$product_info = $this->product_model->product_details($pid);
		if(!empty($product_info) && !empty($product_info->quantity) && $product_info->quantity!=0){

			$checkProductExist = $this->checkProductExistInCart($pid, $this->cart->contents());
			if($checkProductExist){

				if($product_info->sale_start_date!='' && $product_info->sale_start_date<=date('Y-m-d') && $product_info->sale_end_date!='' && $product_info->sale_end_date>=date('Y-m-d')){
					$product_info->base_price = $product_info->sale_price;
				}

				$insert_data = array(
					'id' 						=> $product_info->product_variation_id,
					'qty' 						=> 1,
					'price' 					=> $product_info->base_price,
					'name' 						=> $product_info->title,
					'short_description' 		=> $product_info->short_description,
					'base_price' 				=> $product_info->base_price,
					'sell_price' 				=> $product_info->sell_price,
					'slug' 						=> $product_info->slug,
					'product_basic_info' 		=> $product_info->product_basic_info,
					'image' 					=> $product_info->image,
					'product_availability' 		=> $product_info->quantity,
					'product_info' 				=> json_encode($product_info)
				);

				if(!empty($product_info->product_other_info)){
					$insert_data['product_other_info'] = $product_info->product_other_info;
				}

				if(!empty($product_info->product_variation_info)){
					$insert_data['product_variation_info'] = $product_info->product_variation_info;
				}

				$this->cart->insert($insert_data);
				if(!empty($this->session->userdata('shipping_address_id'))){
					$this->getShippingUsingAddress($this->session->userdata('shipping_address_id'));
				}
				//p($this->cart->contents()); die;
				$this->session->set_flashdata('msg_success', 'Product has been added successfully in your bag'); 
				redirect('cart/index');

			}else{
				$this->session->set_flashdata('msg_error', 'This product is already available in your bag'); 
				redirect('cart/index');
			}
		}else{
			$this->session->set_flashdata('msg_error', 'Sorry! Currently this product isn\'t available in our stock'); 
			redirect('cart/index');
		}

	}


	public function productAndAmountInfo($shipping_addresessId='')
	{
		if(user_logged_in()===FALSE){
			echo json_encode(array('status'=>'failed', 'msg'=>'You have to login first'));
		}else{

			$shipping_addresessId = base64_decode($this->input->post('shipping_addresessId'));
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

					echo json_encode(array('status'=>'success', 'msg'=>''));
				}else{
					echo json_encode(array('status'=>'failed', 'msg'=>'Sorry! No shipping address found'));
				}
			}else{
				echo json_encode(array('status'=>'failed', 'msg'=>'Sorry! No information found'));
			}
		}
	}


	public function chooseShipmentMethod($ShipmentMethod='', $pID='', $rowID='')
	{
		$shipping_address_id = $this->session->userdata("shipping_address_id");
		$ShipmentMethod = str_replace(" ","_", $_POST['ShipmentMethod']);
		$pID 			= base64_decode($_POST['pID']);
		$rowID 			= base64_decode($_POST['rowID']);

		$cartInfo = $this->cart->contents();
		if(!empty($cartInfo)){
			$shippingCharge = getShippingUsingIP(base64_encode($pID), $shipping_address_id, '');
			if(isset($shippingCharge['data'][$ShipmentMethod])){
				if($ShipmentMethod=='Normal_Shipping'){
					$method = 1;
				}else if($ShipmentMethod=='Express_Shipping'){
					$method = 2;
				}
				$result = $shippingCharge['data'][$ShipmentMethod];
				$data = array(
					'rowid' => $rowID,
					'shipping_charges' => $result->price,
					'min_day' => $result->min_day,
					'max_day' => $result->max_day,
					'shipping_method' => $method
				);
				$this->cart->update($data);
				echo json_encode(array('status'=>'success', 'msg'=>'Updated'));
			}else{
				echo json_encode(array('status'=>'failed', 'msg'=>'Something went wrong! please try again'));
			}
		}else{
			echo json_encode(array('status'=>'failed', 'msg'=>'Something went wrong! please try again'));
		}
	}


	private function checkProductExistInCart($pID='', $cartData=array()) {
		if(empty($cartData)){
			return true;
		}else{
			foreach ($cartData as $key => $value) {
				if($value['id']==$pID){
					return false;
				}
			}
			return true;
		}
	}


	public function getShippingUsingAddress($shipping_addresessId='')
	{
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
					}
				}

				$this->cart->destroy();
				$this->cart->insert($ProductInfo);
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
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


	public function sendOrderPlacedEmailToAdminOrCustomer($o_id='',$user_id=''){

		//-------------For Send email AND SMS to customer and Admin-----------
        $email_template = $this->common_model->get_row('email_templates', array('id'=>15));
        if(!empty($email_template)){

        	$data['order_info'] =  $this->common_model->get_row('orders',array('o_id'=>$o_id, 'user_id'=>$user_idy));	
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
        //-------------**For Send email AND SMS to admin and customer-----------
	}


	public function paymentIssueEmail($shipping_addresess='',$msg=''){

		//-------------For Send email to customer for payment issue-----------
        $email_template = $this->common_model->get_row('email_templates', array('id'=>21));
        if(!empty($email_template)){
			//==-----------===Send Email==-----------
            if($email_template->template_email_enable==1){

                $userRole  = 2; //for Customer
                $to        = $shipping_addresess->email_id;
                $param     = array(
                    'site_name'           => SITE_NAME,
                    'user_role'           => "Customer",
                    'msg'   => $msg,
                );
                $sendEmail = sendEmail($email_template, $to, $param, $userRole);

            }
        }
        //-------------**For Send email to customer for payment issue-----------
	}

	public function barcode($code='', $type='') {
        include_once(APPPATH."libraries/barcode/php-barcode.php");
        $_GET['data'] = $code; 
        //$barcodeData =  (isset($_GET['data']) && ctype_alnum($_GET['data'])) ? $_GET['data'] : die('No barcode data!');
        if(isset($_GET['data']) && ctype_alnum($_GET['data'])){
            $barcodeData = $_GET['data'];
        }else{
            $barcodeData = die('No barcode data!');
        }

        $barcodeTypes = array(  'codabar' =>    1,
                                'code11' =>     1,
                                'code39' =>     1,
                                'code93' =>     1,
                                'code128' =>    1,
                                'ean8' =>       1,
                                'ean13' =>      0,
                                'std25' =>      1,
                                'int25' =>      1,
                                'msi' =>        1,
                                'datamatrix' => 1
                                );

        // Define the type of barcode to render
        $barcodeType =  'code128';

		// Image canvas defaults to 300x300, gets trimmed later
		$im     = imagecreatetruecolor(600, 600); 
		$black  = ImageColorAllocate($im,0x00,0x00,0x00);  
		$white  = ImageColorAllocate($im,0xff,0xff,0xff);  
		$red    = ImageColorAllocate($im,0xff,0x00,0x00);
		$blue   = ImageColorAllocate($im,0x00,0x00,0xff);
		// Start with a White canvas
		//echo $white;
		//exit;
		imagefilledrectangle($im, 0, 0, 600, 600, $white);  

		// Generate the barcode
		$data =	Barcode::gd($im, $black, 300, 300, 0, $barcodeType, $barcodeData, 3.3, 192);   

        // Variables for trimming
        $originalWidth =    imagesx($im);
        $originalHeight =   imagesy($im);
        $trim =             array(  'top' =>    0,
                                    'right' =>  0,
                                    'bottom' => 0,
                                    'left' =>   0
                                    );

        // Find top trim value
        for ($y = 0; $y < $originalHeight; $y++)
        {
            for ($x = 0; $x < $originalWidth; $x++)
            {
                $c = imagecolorat($im, $x, $y);

                if ($c != $white)
                {
                    $trim['top'] = ($y) ? $y - 1 : 0;
                    break;
                }
            }
            
            if ($trim['top']) break;
        }

        // Find left trim value
        for ($x = 0; $x < $originalWidth ; $x++)
        {
          for ($y = 0; $y < $originalHeight; $y++)
          {
            $c = imagecolorat($im, $x, $y);
            
            if ($c != $white)
            {
              $trim['right'] = $x;
              break;
            }
          }
          
          if ($trim['right']) break;
        }


        
        // Find bottom trim value
        for ($y = 0; $y < $originalHeight; $y++)
        {
          for ($x = 0; $x < $originalWidth; $x++)
          {
            $c = imagecolorat($im, $x, $y);

            if ($c != $white)
            {
              $trim['bottom'] = ($y) ? $y - 1 : 0;
              break;
            }
          }
          
          if ($trim['bottom']) break;
        }

        // Find left trim value
        for ($x = 0; $x < $originalWidth ; $x++)
        {
            for ($y = 0; $y < $originalHeight; $y++)
            {
                $c = imagecolorat($im, $x, $y);
                
                if ($c != $white)
                {
                    $trim['left'] = $x;
                    break;
                }
            }
            
            if ($trim['left']) break;
        }

        // Create copy of original
        $tempImg = imagecreatetruecolor($originalWidth, $originalHeight);
        imagecopy($tempImg, $im, 0, 0, 0, 0, $originalWidth, $originalHeight);

        // Clean up
        imagedestroy($im);

        // Define trimmed width and height
        $newWidth =     $originalWidth - $trim['left'] - $trim['right'];
        $newHeight =    $originalHeight - $trim['top'] - $trim['bottom'];

        // Create new trim-sized canvas
        $im = imagecreatetruecolor($newWidth, $newHeight);

        // Copy original to trimmed canvas
        imagecopy($im, $tempImg, 0, 0, $trim['left'], $trim['top'], $newWidth, $newHeight);

        // Clean up
        imagedestroy($tempImg);
        // Output image
        //header('Content-Type: image/jpeg');
        $image_path = "./assets/uploads/frontend/barcode_images/".$_GET['data'].".jpg";
        imagejpeg($im, $image_path);

        //echo "<img style='text-align:center' src='http://www.qi-post.com/assets/frontend/img/barcode_images/third_party/".$_GET['data'].".jpg'>"; die;
        return true;
    }

	private function generateOrderId(){
		$today = date("Ymd");
		$rand = strtoupper(substr(uniqid(sha1(time())),0,4));
		$unique = $today . $rand;
		return $unique;
	}

}	