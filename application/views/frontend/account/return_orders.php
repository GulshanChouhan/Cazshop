
<section class="admin-background admin-page">
	<div class="container-fluid">
		<div class="row dashboard">
		    <div class="clearfix dashboard-width-wrap">
			    <?php $this->load->view('frontend/account/left_menus'); ?>
			    <div class="col-md-10 col-sm-9 dashboard-right-warp">
			    	<div class="col-lg-12 col-md-12">
			         	<div class="dashboaed-breadcrumb-wrapper">
			         		<nav aria-label="breadcrumb">
							  <ul class="breadcrumb">
							    <li class="breadcrumb-item">
							    	<a href="<?php echo base_url('account/dashboard'); ?>">Dashboard</a>
							    </li>
							    <li class="breadcrumb-item active" aria-current="page">Your Orders</li>
							  </ul>
							</nav>
			         	</div>
			         	<div class="clearfix"></div>
		      		</div>
		      		<div class="clearfix"></div>
		      		<?php msg_alert(); ?>  
			    	<div class="dashboard-right section-white no-padding-top">
			    		<div class="col-lg-12 col-md-12">
				            <div class="heading">
								<img src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/closed-cardboard-gray.svg" width="25"> 
								Your Orders
				         	</div>
				         	<div class="clearfix"></div>
			      		</div>
					    <div class="col-lg-12 col-md-12">
					    	<div class="order-tab-system clearfix">
							    <ul class="nav-order-tabs" role="tablist">
									<li class="">
										<a href="<?php echo base_url('account/orders'); ?>"><i class="icofont icofont-shopping-cart"></i> Order History</a>
							        </li>

							        <li class="">
							        	<a href="<?php echo base_url('account/open_orders'); ?>"><i class="icofont icofont-social-dropbox"></i> In Process</a>
							        </li>

							        <li class="">
							        	<a href="<?php echo base_url('account/cancel_orders'); ?>"><i class="icofont icofont-close"></i> Cancelled Orders</a>
							        </li>

							        <li class="active">
							        	<a href="<?php echo base_url('account/return_orders'); ?>"><i class="icofont icofont-recycle"></i> Return Orders</a>
							        </li>
								</ul>
							</div>

							<?php if(!empty($orders)){ foreach ($orders as $row) { ?>
					      	<div class="order-common-panel">
					      		<div class="order-panel-head">
			          				<div class="order-panel-head-inner clearfix">
			          					<div class="panel-left">
			          						<div class="a-row">
			          							<div class="col-width order-placed">
			          								<div class="a-row order-label">
														<span class="">Order placed</span>
													</div>
													<div class="a-row order-value">
														<span class=""><?php echo date('d M Y',strtotime($row->created)); ?></span>
													</div>
			          							</div>
			          							<div class="col-width order-total">
													<div class="a-row order-label">
														<span class="">Total</span>
													</div>
													<div class="a-row order-value">
														<span class="font-roboto">
															<?php
					                                            $price = getOrderNamePrice($row->orderDetailIDs)['price'];
					                                            if($price){
					                                                if($row->currency_type==1){
					                                                  $totalGross = $price * $row->currency_amount_in_ethereum;
					                                                }else if($row->currency_type==2){
					                                                  $totalGross = $price * $row->currency_amount_in_bitcoin;
					                                                }else{
					                                                  $totalGross = $price * $row->currency_amount_in_dollor;
					                                                }
					                                                echo getCurrencyIcon($row->currency_type).''.number_format($totalGross, 8); 
					                                            }else{
					                                                echo "0.00";
					                                            }  
					                                        ?>
														</span>
													</div>
												</div>
												<?php
													$shipping_address = json_decode($row->shipping_address);
													if(!empty($shipping_address)){

									                  $country = getData('countries',array('id',$shipping_address->country))->name;
									                  $state = getData('states',array('id',$shipping_address->state))->name;
									                  $city = getData('cities',array('id',$shipping_address->city))->name;
												?>
												<div class="col-width ship-to">
													<div class="a-row order-label">
														<span class="">Ship to</span>
													</div>
													<div class="a-row order-value">
														<span class="">
															<a href="javascript:void(0)" class="link-text" data-container="body" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<?php echo $shipping_address->address.', '.$city.', '.$state.', '.$country.' - '.$shipping_address->zip_code; ?>"><?php echo ucwords($shipping_address->first_name.' '.$shipping_address->last_name); ?> <i class="icofont icofont-caret-down"></i></a>
														</span>
													</div>
												</div>
												<?php } ?>
			          						</div>
			          					</div>
			          					<div class="panel-right">
			          						<div class="a-row order-label">
			                					<span class="">
												    Order #
												</span>       
												<span class="">
												    <?php echo $row->order_id; ?>
												</span>
			        						</div>
			          					</div>
			          				</div>
			        			</div>
			        			<div class="order-panel-body clearfix">
			        				<?php 
		        						$orderDetailIDs = explode(',', $row->orderDetailIDs);
		        						foreach ($orderDetailIDs as $key => $value) {
		        							$order_details = getData('order_details',array('order_detail_id',$value));
		        							$order_status  = getRow('order_status', array('order_detail_id'=>$value, 'status'=>6));
		        							if(!empty($order_details)){
		        								$product_details = json_decode($order_details->product_details);
		        								$userName   = getData('users',array('user_id',$product_details->seller_id));
		        								$Image = $product_details->image;
                                     			$Image = explode(',', $Image);
		        					?>
		        					<div>
				        				<div class="left-sdie">
<!-- 				        					<div class="order-heading margin-bottom-20">
				        						<b>Cancelled</b>
				        					</div> -->
				        					<div class="order-item-view">
				        						<div class="a-row">
				        							<div class="order-item-box clearfix">
				        								<div class="order-item-left">
				        									<div class="order-item-left-inner">
				        										<a href="#">
				        											<img src="<?php echo base_url(); ?>/assets/uploads/seller/products/small_thumbnail/<?php echo $Image[0]; ?>">
				        										</a>
				        									</div>
				        								</div>
				        								<div class="order-item-right">
				        									<div class="a-row">
				        										<a target="_blank" class="product-order-heading" href="<?php echo base_url('pd/'.$product_details->slug.'/'.base64_encode($product_details->product_variation_id)); ?>"><?php echo ucfirst($product_details->title); ?></a>
				        									</div>
				        									<div class="a-row">
				                                                <div class="left-label">Sold by:</div>
				                                                <div class="right-label"><?php if(!empty($userName->user_name)) echo ucwords($userName->user_name); else echo "-"; ?></div>
				                                            </div>
				                                            <div class="a-row">
				                                                <div class="left-label">Return Date:</div>
				                                                <div class="right-label"><?php if($order_details->created) echo date('d M Y',strtotime($order_details->created)); else echo "-"; ?></div>
				                                            </div>
															<div class="a-row">
				                                                <div class="left-label">Price:</div>
				                                                <div class="right-label">
				                                                <span class="dollar-icon-bold">
				                                                	<?php echo getCurrencyIcon($row->currency_type); ?>
				                                                </span>
				                                                <span class="number-icon-bold">
				                                                	<?php
				                                                    $itemPrice = $order_details->price;
				                                                    if($itemPrice){
				                                                      if($row->currency_type==1){
				                                                        $totalGross = $itemPrice * $row->currency_amount_in_ethereum;
				                                                      }else if($row->currency_type==2){
				                                                        $totalGross = $itemPrice * $row->currency_amount_in_bitcoin;
				                                                      }else{
				                                                        $totalGross = $itemPrice * $row->currency_amount_in_dollor;
				                                                      }
				                                                      echo number_format($totalGross, 8); 
				                                                    }else{
				                                                      echo "0.00";
				                                                    }  
				                                                ?>
				                                                </span></div>
				                                            </div>
															<?php if($order_details->shipping_charges==0){ ?>
				                                            <div class="a-row">
				                                                <div class="left-label">Free Shipping</div>
				                                            </div>
				                                            <?php }else{ ?>
															<div class="a-row">
				                                                <div class="left-label">Shipping Charges:</div>
				                                                <div class="right-label">
				                                                <span class="dollar-icon-bold">
				                                                	<?php echo getCurrencyIcon($row->currency_type); ?>
				                                                </span>
				                                                <span class="number-icon-bold">
				                                                	<?php
				                                                        $shipping_charges = $order_details->shipping_charges;
				                                                        if($shipping_charges){
				                                                          if($row->currency_type==1){
				                                                            $shipping_chargesGross = $shipping_charges * $row->currency_amount_in_ethereum;
				                                                          }else if($row->currency_type==2){
				                                                            $shipping_chargesGross = $shipping_charges * $row->currency_amount_in_bitcoin;
				                                                          }else{
				                                                            $shipping_chargesGross = $shipping_charges * $row->currency_amount_in_dollor;
				                                                          }
				                                                          echo number_format($shipping_chargesGross, 8); 
				                                                        }else{
				                                                          echo "0.00";
				                                                        }  
				                                                    ?>
				                                                </span></div>
				                                            </div>
															<?php } ?>

				        								</div>
				        							</div>
				        						</div>
				        					</div>
				        				</div>
			        				</div>
			        				<div class="clearfix"></div><br>
			        				<?php 	}
				        				}
				        			?>
			        			</div>
					      	</div>
					      	<?php } }else{ ?>
					      	<div class="col-md-12">
		                        <br><br><br>
		                        <div class="noresult-block text-center">
		                          <div class="noresult-img">
		                            <img src="<?php echo base_url('assets/frontend/img/empty-icon/shopping-cart-add-button.svg'); ?>">
		                          </div>
		                          <div class="noresult-content">
		                            <h4>Returned orders not available</h4>
		                          </div>
		                        </div>
		                    </div>
					      	<?php } ?>
					    </div>
				    </div>
			    </div>
			</div>
	    </div>
	</div>
</section>

<script>
   if($('.dashboard').length != 0){
     $(window).on("load resize", function () {
     winWidthnew = $('body').width();
     if(winWidthnew >=768){
     var dashboard_left = $('.dashboard-left').outerHeight();
     var dashboard_right  = $('.dashboard-right').outerHeight();
     if(dashboard_left <= dashboard_right){
         $('.dashboard-left').css('height' , dashboard_right);
     }
     else{
      $('.dashboard-left').css('height' , '400px;');
     }
    }
    }).resize();
   }
</script>
<script>//==popover
	$(document).ready(function(){
	    $('[data-toggle="popover"]').popover();   
	});

</script>