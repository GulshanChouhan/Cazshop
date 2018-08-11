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

							        <li class="active">
							        	<a href="<?php echo base_url('account/open_orders'); ?>"><i class="icofont icofont-social-dropbox"></i> In Process</a>
							        </li>

							        <li class="">
							        	<a href="<?php echo base_url('account/cancel_orders'); ?>"><i class="icofont icofont-close"></i> Cancelled Orders</a>
							        </li>

							        <li class="">
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
															<a href="javascript:void(0)" class="link-text" data-container="" data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<?php echo $shipping_address->address.', '.$city.', '.$state.', '.$country.' - '.$shipping_address->zip_code; ?>"><?php echo ucwords($shipping_address->first_name.' '.$shipping_address->last_name); ?> <i class="icofont icofont-caret-down"></i></a>
														</span>
													</div>
												</div>
												<?php } ?>
			          						</div>
			          					</div>
			          					<div class="panel-right">
			          						<div class="a-row order-label">
			                					<span class="">
												    Order #<?php echo $row->order_id; ?>
												</span>       
			        						</div>
			        						<?php
			        							$o_id = base64_encode($row->o_id);
			        							$orderDetailIDs = base64_encode($row->orderDetailIDs);
			        						?>
			        						<div class="a-row order-details-invoice">
			        							<ul>
													<li>
													    <a class="link-text" href="<?php echo base_url('account/order_details/'.$o_id.'/'.$orderDetailIDs.'/1'); ?>">View Order Details</a>
													</li>
												</ul>
			        						</div>
			          					</div>
			          				</div>
			        			</div>

			        			<?php 
	        						$orderDetailIDs = explode(',', $row->orderDetailIDs);
	        						foreach ($orderDetailIDs as $key => $value) {
	        							$order_details = getData('order_details',array('order_detail_id',$value));
	        							if(!empty($order_details)){
	        								$product_details = json_decode($order_details->product_details);
	        								$userName   = getData('users',array('user_id',$product_details->seller_id));
	        								$Image = $product_details->image;
                                 			$Image = explode(',', $Image);
	        					?>
			        			<div class="order-panel-body clearfix">
		        					<div>
				        				<div class="left-sdie">
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
				        									<div class="product-property">
																<?php
					                                                 $tempMore = ""; 
					                                                 $product_variation_info = $product_details->product_variation_info;
					                                                 $product_basic_info = $product_details->product_basic_info;
					                                                 if(!empty($product_variation_info) && $product_variation_info!=''){
					                                                    $tempMore = "";
					                                                    $product_variation_info = json_decode($product_variation_info);
					                                                    if(!empty($product_variation_info)){
					                                                       foreach ($product_variation_info as $key => $value) {
					                                                          if(!empty($key) && !empty($value)){
					                                                       	  	$tempMore .= "<span> <label>".ucfirst($key).":</label> &nbsp;".ucfirst($value)."</span>";
					                                                       	  }
					                                                       }
					                                                    }
					                                                 }else if(!empty($product_basic_info)){
					                                                 	$tempMore = "";
					                                                    $product_basic_info = json_decode($product_basic_info);
					                                                    if(!empty($product_basic_info)){
					                                                       foreach ($product_basic_info as $key => $value){
					                                                       	  if(!empty($key) && !empty($value)){
					                                                       	  	$tempMore .= "<span> <label>".ucfirst($key).":</label> &nbsp;".ucfirst($value)."</span>";
					                                                       	  }
					                                                       }
					                                                    }
					                                                 }
					                                                 echo $tempMore;
					                                            ?>
															</div>
				        									<div class="a-row">
				        										<div class="soldby-name">
					                                                <div class="left-label">Sold by:</div>
					                                                <div class="right-label"><?php if(!empty($userName->user_name)) echo ucwords($userName->user_name); else echo "-"; ?>
					                                                </div>
					                                            </div>
					                                            <div class="orderstatus-tag">
					                                                <div class="left-label">Order Status:</div>
					                                                <div class="label-status label-status-<?php if(!empty($order_details->order_status)) echo orderStatuscls($order_details->order_status); else echo "primary"; ?>"><?php if(!empty($order_details->order_status)) echo orderStatusName($order_details->order_status); else echo "-"; ?>
					                                                </div>
					                                            </div>
					                                        </div>
				                                            <div class="clearfix"></div>
															<div class="a-row">
				                                                <div class="left-label">Price:</div>
				                                                <div class="right-label">
				                                                <span class="dollar-icon-bold">
				                                                	<?php echo getCurrencyIcon($row->currency_type); ?>
				                                                </span>
				                                                <span class="number-icon-bold">
				                                                	<?php
						                                      		  $price = $order_details->price;
						                                              if($price){
						                                                if($row->currency_type==1){
						                                                  $totalGross = $price * $row->currency_amount_in_ethereum;
						                                                }else if($row->currency_type==2){
						                                                  $totalGross = $price * $row->currency_amount_in_bitcoin;
						                                                }else{
						                                                  $totalGross = $price * $row->currency_amount_in_dollor;
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
				        				<div class="right-sdie">
				        					<div class="right-btn-wrapper">
				        						<?php
				        							$o_id = base64_encode($row->o_id);
				        						?>
				        						<div class="a-row margin-bottom-20">
				                                    <a href="<?php echo base_url('account/order_details/'.$o_id.'/'.base64_encode($order_details->order_detail_id).'/2'); ?>" class="btn btn-default-new btn-block"><i class="icofont icofont-location-pin"></i> Track your Item</a>
				                                </div>
												<div class="a-row margin-bottom-20">
													<a odi="<?php echo base64_encode($order_details->order_detail_id); ?>" class="btn btn-default-new btn-block cancelItem" href="javascript:void(0)"><i class="icofont icofont-close"></i> Cancel the Item</a>
												</div>
											</div>
				        				</div>
			        				</div>
			        				<div class="clearfix"></div>
			        			</div>
			        			<hr>
			        			<?php 	}
			        				}
			        			?>
					      	</div>
					      	<?php } }else{ ?>
					      	<div class="col-md-12">
					      		<br><br><br>
					      		<div class="noresult-block text-center">
				                    <div class="noresult-img">
				                       	<img src="<?php echo base_url('assets/frontend/img/empty-icon/shopping-cart-add-button.svg'); ?>">
				                    </div>
				                    <div class="noresult-content">
				                        <h4>Currently there are no orders available</h4>
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


<!-- Modal -->
<div class="modal fade" id="cancellationpopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content support-ticket-modal comman-modal">
         <div class="modal-header comman-header-modal">
            <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true"><img src="<?php echo SELLER_THEME_URL; ?>/img/Icon_Basic_Close.svg" width="18"></span>
            </button>
            <h4 class="modal-title text-center" id="myModalLabel">Submit a Reason Of Cancellation</h4>
         </div>
         <div class="modal-body comman-body-modal">
            <form role="form" action="" method="post" id="cancellationReasonForm">
	         	<div class="main-loader" style='display: none;'>
	               <div class="loader">
	                  <svg class="circular-loader"viewBox="25 25 50 50" >
	                    <circle class="loader-path" cx="50" cy="50" r="20" fill="none" stroke="#f45b69" stroke-width="2.5" />
	                  </svg>
	               </div>
	            </div>
               <div class="form-body contact-support-form ">
                  <div class="right-side <?php  if(user_logged_in()!=1) echo 'col-md-7'; else echo 'col-md-12'; ?>">
                     <div class="">
                        <div class="col-md-12 col-sm-12">     
                           <label><b>Reason <span style="color: red;" class="front_error">*</span></b></label>
                        </div>
                        <div class="form-group col-md-12 col-sm-12">
                           <select name="subject_of_reason" class="form-control" data-bvalidator="required" data-bvalidator-msg="Please select the reason for cancellation">
                              <option value="">--Select the Reason--</option>
                              <?php
                                 $orderCancellationReason = orderCancellationReason(); 
                                 if(!empty($orderCancellationReason)){ 
                                    foreach ($orderCancellationReason as $key => $value) { 
                              ?>
                              <option <?php if(!empty($_POST['subject_of_reason']) && ($_POST['subject_of_reason']==$key)){ echo "selected"; } ?> value="<?php echo $key ?>"><?php echo $value ?></option>
                              <?php  
                                    }
                                 }  
                              ?>
                           </select>
                           <?php echo form_error('subject_of_reason') ?>
                        </div>
                     </div>
                     <div class="">
                        <div class="col-md-12 col-sm-12">    
                           <label><b>Message <span style="color: red;" class="front_error">*</span></b></label>  
                        </div>
                        <div class="form-group col-md-12 col-sm-12">        
                           <textarea name="msg_of_reason" class="form-control tooltips" rel="tooltip" data-placement="top right" rows="6" placeholder="Please describe the cancellation reason" data-bvalidator-msg="Please enter the message" maxlength="500" data-bvalidator="required,maxlen[500]"><?php echo set_value('msg_of_reason'); ?></textarea>
                           <?php echo form_error('msg_of_reason') ?>
                        </div>
                     </div>
                     <input type="hidden" name="order_detail_id" id="odi" value="">
                     <div class="">
                        <div class="col-md-12 col-sm-12">    
                           <label for="" class="label"></label>  
                        </div>
                        <div class="col-md-12 col-sm-12 text-center">
                           <button type="submit" class="btn btn-lg btn-red contact-submit">Submit</button>
                        </div>
                        <div class="clearfix"></div>
                     </div>
                  </div>
               </div>
               <div class="clearfix"></div>
            </form>
         </div>
      </div>
   </div>
</div>

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

   $(document).ready(function(){
	    $('[data-toggle="popover"]').popover();  
	    $('#cancellationReasonForm').bValidator(); 
   });

   /*Open cancellation modal*/
   $('.cancelItem').on('click', function() {
      var odiVal = $(this).attr("odi");
      if(odiVal){
         $('#odi').val(odiVal);
         $('#cancellationpopup').modal('show');
      }else{
      	errorMsg("Something went wrong! Please try again")
      }
       
   });


   /*Submit cancellation form*/
   $('#cancellationReasonForm').submit(function() {
        
      $('#cancellationReasonForm').bValidator();
      // check if form is valid
      if($('#cancellationReasonForm').data('bValidator').isValid()){

      	 $("button").attr("disabled", true);
         var order_detail_id = $("input[name=order_detail_id]").val();
         var subject_of_reason = $("select[name=subject_of_reason]").val();
         var msg_of_reason = $("textarea[name=msg_of_reason]").val();

         $.ajax({
            url: SITE_URL + 'order/cancellation_process',
            type: 'POST',
            data: {
                order_status: 5,
                order_detail_id: order_detail_id,
                subject_of_reason: subject_of_reason,
                msg_of_reason: msg_of_reason
            },
            beforeSend: function()
            {
              $('.main-loader').show();
            },
            cache: false,
            success: function(result) {
                var data = JSON.parse(result);
                if(data.status=='failed'){ 
                    $('.main-loader').hide(); 
                    errorMsg(data.msg);
                    return false;
                }
                else if(data.status=='failed'){  
                	$('.main-loader').hide();
                	$("button").attr("disabled", false);
                    errorMsg(data.msg);
                }else{
                    successMsg(data.msg);
                    setTimeout(function(){
		                location.reload();
		            }, 2000);
                }
            }
         });
      }
      return false;
   });

</script>