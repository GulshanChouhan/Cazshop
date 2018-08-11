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
                           <li class="breadcrumb-item">
                              <a href="<?php echo base_url('account/open_orders'); ?>">Your Orders</a>
                           </li>
                           <li class="breadcrumb-item active" aria-current="page">Order Details</li>
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
                        <?php echo $headingOfPage = ($pageType==2) ? "Tracking details" : "Order Details"; ?>
                     </div>
                     <div class="clearfix"></div>
                  </div>

                  <?php 
                     if($pageType==2){
                        $newItemPlaced          = getRow("order_status",array("status"=>1, "order_detail_id"=>$orderDetailIDs));
                        $packedForShip          = getRow("order_status",array("status"=>3, "order_detail_id"=>$orderDetailIDs));
                        $delivered              = getRow("order_status",array("status"=>4, "order_detail_id"=>$orderDetailIDs, 'user_role'=>1));
                        $deliveredByAdmin       = getRow("order_status",array("status"=>4, "order_detail_id"=>$orderDetailIDs, 'user_role'=>0));
                  ?>

                  <div class="col-lg-12 col-md-12">
                     <div class="a-row shipment-step">
                        <div class="col-xs-4 shipment-step-step <?php if(!empty($newItemPlaced)) echo "active"; ?> <?php if(!empty($newItemPlaced) && (!empty($packedForShip) || !empty($delivered))) echo "complete"; ?>">
                           <div class="shipment-progress">
                              <div class="shipment-progress-bar"></div>
                           </div>
                           <div class="shipment-step-icon with-hover-image">
                              <div class="panel-image">
                                 <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Your Order has been placed.">
                                 <img class="active-image" width="40" height="40" src="<?php echo FRONTEND_THEME_URL ?>img/order-status/shopping-cart.svg">
                                 <img class="hover-image" width="40" height="40" src="<?php echo FRONTEND_THEME_URL ?>img/order-status/shopping-cart-white.svg">
                                 </a>
                              </div>
                           </div>
                           <div class="shipment-step-info text-center">
                              Order Placed
                              <?php if(!empty($newItemPlaced)){ ?>                        
                                 <p class="date"><?php echo date('d M Y h:i:s A',strtotime($newItemPlaced->created)); ?></p>
                              <?php } ?>
                           </div>
                        </div>
                        <div class="col-xs-4 shipment-step-step <?php if(!empty($newItemPlaced) && !empty($packedForShip)) echo "active"; ?> <?php if((!empty($newItemPlaced) && !empty($packedForShip)) && !empty($delivered) && !empty($deliveredByAdmin)) echo "complete"; ?>">
                           <div class="shipment-progress">
                              <div class="shipment-progress-bar"></div>
                           </div>
                           <div class="shipment-step-icon with-hover-image">
                              <div class="panel-image">
                                 <a href="javascript:void(0);" <?php if((!empty($newItemPlaced) && !empty($packedForShip)) && (!empty($delivered))){ ?> data-toggle="tooltip" data-placement="top" title="" data-original-title="Item has been packed for shipping." <?php } ?>>
                                 <img class="active-image" width="40" height="40" src="<?php echo FRONTEND_THEME_URL ?>img/order-status/delivery-truck.svg">
                                 <img class="hover-image" width="40" height="40" src="<?php echo FRONTEND_THEME_URL ?>img/order-status/delivery-truck-white.svg">
                                 </a>
                              </div>
                           </div>
                           <div class="shipment-step-info text-center">
                              Confirm Dispatch                       
                                 <?php 
                                    if(!empty($newItemPlaced) && !empty($packedForShip)){ 
                                 ?>       
                                 <p class="date"><?php echo date('d M Y h:i:s A',strtotime($packedForShip->created)); ?></p>
                                 <?php if(!empty($packedForShip->tracking_id) && !empty($packedForShip->tracking_url) && !empty($packedForShip->tracking_description)){ ?>
                                 <div style="font-size: 12px;"><a class="showTD" href="javascript:void(0)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Click to view tracking details">more details <i class="icofont icofont-simple-down"></i></a></div>
                              <?php } } ?>
                           </div>
                        </div>
                        <div class="col-xs-4 shipment-step-step <?php if(!empty($newItemPlaced) && !empty($packedForShip) && !empty($delivered) && !empty($deliveredByAdmin)) echo "active"; ?>">
                           <div class="shipment-progress">
                              <div class="shipment-progress-bar"></div>
                           </div>
                           <div class="shipment-step-icon with-hover-image">
                              <div class="panel-image">
                                 <a href="javascript:void(0);" <?php if(!empty($newItemPlaced) && !empty($packedForShip) && !empty($delivered) && !empty($deliveredByAdmin)){ ?> data-toggle="tooltip" data-placement="top" title="" data-original-title="Item has been delivered" <?php } ?>>
                                 <img class="active-image" width="40" height="40" src="<?php echo FRONTEND_THEME_URL ?>img/order-status/delivered-box.svg">
                                 <img class="hover-image" width="40" height="40" src="<?php echo FRONTEND_THEME_URL ?>img/order-status/delivered-box-white.svg">
                                 </a>
                              </div>
                           </div>
                           <div class="shipment-step-info text-center">
                              Order Completed                       
                              <?php if(!empty($newItemPlaced) && !empty($packedForShip) && !empty($delivered) && !empty($deliveredByAdmin)){ ?>                
                                 <p class="date"><?php echo date('d M Y h:i:s A',strtotime($deliveredByAdmin->created)); ?></p>
                              <?php } ?>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="clearfix"></div><br>

                  <?php 
                     if(!empty($newItemPlaced) && !empty($packedForShip)){
                        if(!empty($packedForShip->tracking_id) && !empty($packedForShip->tracking_url) && !empty($packedForShip->tracking_description)){
                  ?> 

                  <div class="col-lg-12 col-md-12 trackingDetails" style="display: none;">
                     <div class="a-row shipment-step shipping-tacking-details">
                        <div class="a-row shipping-tacking-item">
                           <div class="left-side">
                              Tracking Id :
                           </div>
                           <div class="right-side">
                              <?php echo $packedForShip->tracking_id; ?>
                           </div>
                        </div>
                        <div class="a-row shipping-tacking-item">
                           <div class="left-side">
                              Tracking URL :
                           </div>
                           <div class="right-side">
                              <a class="link-text" href="<?php echo $packedForShip->tracking_url; ?>" target="_blank"><?php echo $packedForShip->tracking_url; ?></a>
                           </div>
                        </div>
                        <div class="a-row shipping-tacking-item">
                           <div class="left-side">
                              Description :
                           </div>
                           <div class="right-side">
                              <?php echo $packedForShip->tracking_description; ?>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="clearfix"></div><br>
                  <?php } } ?>


                  <?php } ?>

                  <div class="col-lg-12 col-md-12">
                     <div class="order-date-invoice-wrapper clearfix">
                        <div class="date-order-left">
                           <div class="a-row order-date-item">
                              <span><strong>Order Id:</strong> #<?php echo $order_info->order_id; ?></span>
                              <span><strong>Ordered Date:</strong> <?php echo date('d M Y',strtotime($order_info->created)); ?></span>
                           </div>
                        </div>
                     </div>
                     <div class="order-common-panel">
                        <div class="order-panel-body order-details-summary-body clearfix">
                           <div class="left-sdie">
                              <?php
                                 $shipping_address = json_decode($order_info->shipping_address);
                                 if(!empty($shipping_address)){
                                      $country = getData('countries',array('id',$shipping_address->country))->name;
                                      $state = getData('states',array('id',$shipping_address->state))->name;
                                      $city = getData('cities',array('id',$shipping_address->city))->name;
                                 ?>
                              <div class="col-md-6 no-padding-left shipping-address-contain">
                                 <div class="">
                                    <h5><b>Shipping Address</b></h5>
                                    <div class="shipping-address-order-details">
                                       <ul class="display-address">
                                          <li class="name"><?php echo ucwords($shipping_address->first_name.' '.$shipping_address->last_name); ?></li>
                                          <li class="display-address-link"><?php if($shipping_address->country_code) echo '+'.$shipping_address->country_code; ?> <?php echo $shipping_address->phone_no; ?></li>
                                          <li class="display-address-link"><?php echo $shipping_address->address; ?></li>
                                          <li class="display-address-city-state"><?php echo $city; ?>, <?php echo $state; ?>, <?php echo $shipping_address->zip_code; ?></li>
                                          <li class="display-address-country"><?php echo $country; ?></li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                              <?php } ?>
                              <div class="col-md-6 no-padding-left shipping-payment-method">
                                 <div class="">
                                    <h5><b>Payment Method</b></h5>
                                    <div class="payment-shipping-details">
                                       <div>
                                        Paid by
                                        <?php if($order_info->currency_type==2){ ?>
                                          <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/bitcoinlgo-35.svg" width="16"> Bitcoin
                                        <?php }else if($order_info->currency_type==1){ ?>
                                          <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/ethereum35.svg" width="16"> Ethereum
                                        <?php }else{ ?>
                                          Cash on Delivery
                                        <?php } ?>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <?php 
                              $getOrderNamePrice = getOrderNamePrice($orderDetailIDs); 
                              ?>
                           <div class="right-sdie">
                              <div class="order-summary-deails-wrapper">
                                 <h5><b>Order Summary</b></h5>
                                 <div class="order-summary-contain">
                                    <div class="a-row">
                                       <div class="col-xs-7 col-sm-7 text-left no-padding">
                                          <span>Item(s) Subtotal:</span>
                                       </div>
                                       <div class="col-xs-5 col-sm-5 text-right no-padding">
                                          <span class="">
                                             <?php
                                               $grossprice = $getOrderNamePrice['grossprice'];
                                                 if($grossprice){
                                                   if($order_info->currency_type==1){
                                                     $totalGross = $grossprice * $order_info->currency_amount_in_ethereum;
                                                   }else if($order_info->currency_type==2){
                                                     $totalGross = $grossprice * $order_info->currency_amount_in_bitcoin;
                                                   }else{
                                                     $totalGross = $grossprice * $order_info->currency_amount_in_dollor;
                                                   }
                                                   echo "<span class='dollar-icon-normal'>".getCurrencyIcon($order_info->currency_type)."</span><span class='number-icon-normal'>".number_format($totalGross, 8)."</span>";
                                                 }else{
                                                   echo "<span class='dollar-icon-normal'>".getCurrencyIcon($order_info->currency_type)."</span><span class='number-icon-normal'>0.00</span>";
                                                 }  
                                             ?>
                                          </span>
                                       </div>
                                    </div>
                                    <div class="a-row">
                                       <div class="col-xs-7 col-sm-7 text-left no-padding">
                                          <span>Shipping:</span>
                                       </div>
                                       <div class="col-xs-5 col-sm-5 text-right no-padding">
                                          <span class="">
                                             <?php
                                               $shippingprice = $getOrderNamePrice['shippingprice'];
                                                 if($shippingprice){
                                                   if($order_info->currency_type==1){
                                                     $shippingpriceGross = $shippingprice * $order_info->currency_amount_in_ethereum;
                                                   }else if($order_info->currency_type==2){
                                                     $shippingpriceGross = $shippingprice * $order_info->currency_amount_in_bitcoin;
                                                   }else{
                                                     $shippingpriceGross = $shippingprice * $order_info->currency_amount_in_dollor;
                                                   }
                                                   echo "<span class='dollar-icon-normal'>".getCurrencyIcon($order_info->currency_type)."</span><span class='number-icon-normal'>".number_format($shippingpriceGross, 8)."</span>";
                                                 }else{
                                                   echo "<span class='dollar-icon-normal'>".getCurrencyIcon($order_info->currency_type)."</span><span class='number-icon-normal'>0.00</span>";
                                                 }  
                                             ?>
                                          </span>
                                       </div>
                                    </div>
                                    <!-- <div class="margin-bottom-10"></div>
                                    <div class="a-row">
                                       <div class="col-xs-7 col-sm-7 text-left no-padding">
                                          <span>Promotion Applied:</span>
                                       </div>
                                       <div class="col-xs-5 col-sm-5 text-right no-padding">
                                          <span>-</span>
                                       </div>
                                    </div> -->
                                    <div class="divider-line"></div>
                                    <div class="a-row grand-total">
                                       <div class="col-xs-7 col-sm-7 text-left no-padding">
                                          <span>Grand Total:</span>
                                       </div>
                                       <div class="col-xs-5 col-sm-5 text-right no-padding">
                                          <span class="">
                                             <?php
                                               $price = $getOrderNamePrice['price'];
                                                 if($price){
                                                   if($order_info->currency_type==1){
                                                     $priceGross = $price * $order_info->currency_amount_in_ethereum;
                                                   }else if($order_info->currency_type==2){
                                                     $priceGross = $price * $order_info->currency_amount_in_bitcoin;
                                                   }else{
                                                     $priceGross = $price * $order_info->currency_amount_in_dollor;
                                                   }
                                                   echo "<span class='dollar-icon-normal'>".getCurrencyIcon($order_info->currency_type)."</span><span class='number-icon-normal'>".number_format($priceGross, 8)."</span>";
                                                 }else{
                                                   echo "<span class='dollar-icon-normal'>".getCurrencyIcon($order_info->currency_type)."</span><span class='number-icon-normal'>0.00</span>";
                                                 }  
                                             ?>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="col-lg-12 col-md-12">
                     <div class="order-common-panel">
                        <?php
                           $orderDetailIDss = explode(',', $orderDetailIDs);
                           foreach ($orderDetailIDss as $key => $value) {
                              $order_details = getData('order_details',array('order_detail_id',$value));
                              if(!empty($order_details)){
                                 $other_shipping_details = json_decode($order_details->other_shipping_details);
                                 $product_details = json_decode($order_details->product_details);
                                 $userName   = getData('users',array('user_id',$product_details->seller_id));
                                 $Image = $product_details->image;
                                 $Image = explode(',', $Image);
                        ?>
                        <div class="order-panel-body clearfix">
                           <div class="left-sdie">
                              <div class="order-item-view">
                                 <div class="a-row">
                                    <div class="order-item-box clearfix">
                                       <div class="order-item-left">
                                          <div class="order-item-left-inner">
                                             <a href="<?php echo base_url('pd/'.$product_details->slug.'/'.base64_encode($product_details->product_variation_id)); ?>">
                                             <img src="<?php echo base_url(); ?>assets/uploads/seller/products/small_thumbnail/<?php echo $Image[0]; ?>">
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
                                          <div class="a-row font-roboto">
                                             <div class="left-label">Date Of Delivery (approx) :</div>
                                             <div class="right-label"><b>
                                                <?php
                                                 if($other_shipping_details->shipping_method=='Free Shipping'){
                                                   echo "Not Confirmed";
                                                 }else{
                                                   if($other_shipping_details->min_day>0 && $other_shipping_details->max_day>0){
                                                      $orderdate = $order_info->created;
                                                      $minduration = ($other_shipping_details->min_day*86400);
                                                      $maxduration = ($other_shipping_details->max_day*86400);
                                                      $dateinsec = strtotime($orderdate);
                                                      $minnewdate=$dateinsec+$minduration;
                                                      $maxnewdate=$dateinsec+$maxduration;
                                                      echo date('D d M Y',$minnewdate).' To '.date('D d M Y',$maxnewdate);
                                                   }else{
                                                      echo "Not Confirmed";
                                                   }
                                                 } 
                                                ?></b>
                                             </div>
                                          </div>
                                          <div class="a-row font-roboto">
                                             <div class="left-label">Sold by:</div>
                                             <div class="right-label"><?php if(!empty($userName->user_name)) echo ucwords($userName->user_name); else echo "-"; ?></div>
                                          </div>
                                          <?php if($order_details->shipping_charges==0){ echo "Free Shipping"; }else{ ?>
                                          <div class="a-row font-roboto">
                                             <div class="left-label">Shipping Charges:</div>
                                             <div class="right-label">
                                             <span class="dollar-icon-normal">
                                                <?php echo getCurrencyIcon($order_info->currency_type); ?>
                                             </span>
                                             <span class="number-icon-normal">
                                                <?php
                                                     $shipping_charges = $order_details->shipping_charges;
                                                     if($shipping_charges){
                                                       if($order_info->currency_type==1){
                                                         $shipping_chargesGross = $shipping_charges * $order_info->currency_amount_in_ethereum;
                                                       }else if($order_info->currency_type==2){
                                                         $shipping_chargesGross = $shipping_charges * $order_info->currency_amount_in_bitcoin;
                                                       }else{
                                                         $shipping_chargesGross = $shipping_charges * $order_info->currency_amount_in_dollor;
                                                       }
                                                       echo number_format($shipping_chargesGross, 8); 
                                                     }else{
                                                       echo "0.00";
                                                     }  
                                                ?>
                                             </span></div>
                                          </div>
                                          <?php } ?>
                                          <div class="a-row font-roboto">
                                             <div class="left-label">Price:</div>
                                             <div class="right-label">
                                             <span class="dollar-icon-normal">
                                                 <?php echo getCurrencyIcon($order_info->currency_type); ?>
                                             </span>
                                             <span class="number-icon-normal">
                                                <?php
                                                    $itemPrice = $order_details->price;
                                                    if($itemPrice){
                                                      if($order_info->currency_type==1){
                                                        $totalGross = $itemPrice * $order_info->currency_amount_in_ethereum;
                                                      }else if($order_info->currency_type==2){
                                                        $totalGross = $itemPrice * $order_info->currency_amount_in_bitcoin;
                                                      }else{
                                                        $totalGross = $itemPrice * $order_info->currency_amount_in_dollor;
                                                      }
                                                      echo number_format($totalGross, 8); 
                                                    }else{
                                                      echo "0.00";
                                                    }  
                                                ?>
                                             </span></div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="right-sdie">
                              <div class="right-btn-wrapper">
                                 <?php if($pageType!=2 && $pageType!=4){ ?>
                                 <div class="a-row margin-bottom-20">
                                    <a href="<?php echo base_url('account/order_details/'.base64_encode($o_id).'/'.base64_encode($order_details->order_detail_id).'/2'); ?>" class="btn btn-default-new btn-block"><i class="icofont icofont-location-pin"></i> Track your Item</a>
                                 </div>
                                 <?php } ?>
                                 <?php 
                                    if($order_details->order_status==4){ 
                                 ?>

                                 <?php
                                    if($product_details->accepted_returnpolicy==1){
                                       $return_policydays = $product_details->return_policydays;
                                       $delivered_date    = date('d M Y',strtotime($order_details->created));
                                       $expireOn = date('d-m-Y', strtotime($delivered_date. ' + '.$return_policydays.' days'));
                                       $expireOnStrTime = strtotime($expireOn);
                                       $currOnStrTime = strtotime(date('d-m-Y'));
                                       if($currOnStrTime <= $expireOnStrTime){
                                 ?>
                                 <div class="a-row margin-bottom-20">
                                       <a href="javascript:void(0)" odi="<?php echo base64_encode($order_details->order_detail_id); ?>" class="btn btn-default-new btn-block returnItem"><i class="icofont icofont-recycle"></i> Return Order</a>
                                 </div>
                                 <?php } } ?> 
                                 <?php 
                                    $alreadyReviewed = getRow("product_review",array('product_variation_id'=>$product_details->product_variation_id, 'user_id'=>user_id())); 
                                       if(empty($alreadyReviewed)){
                                 ?>
                                 <div class="a-row margin-bottom-20">
                                    <a href="javascript:void(0)" pID="<?php echo base64_encode($product_details->product_variation_id); ?>" class="btn btn-default-new btn-block writeAProductReview">
                                       <i class="icofont icofont-star"></i> Write a product review</a>
                                 </div>
                                 <?php } ?>

                                 <?php }else if($order_details->order_status<4){ ?>
                                 <div class="a-row margin-bottom-20">
                                    <a href="javascript:void(0);" odi="<?php echo base64_encode($order_details->order_detail_id); ?>" class="btn btn-default-new btn-block cancelItem"><i class="icofont icofont-close"></i> Cancel the Item</a>
                                 </div>
                                 <div class="a-row margin-bottom-20">
                                    <a target="_blank" href="<?php echo base_url('order/invoice/'.base64_encode($order_details->order_detail_id)); ?>" class="btn btn-default-new btn-block">
                                       <i class="icofont icofont-printer"></i> Download/Preview Invoice</a>
                                 </div>
                                 <?php } ?>

                              </div>
                           </div>
                        </div>
                        <hr>
                        <?php  }
                           }
                        ?>
                     </div>
                  </div>
                  <div class="form-actiosns form-btn-block text-left">
                     <a class="btn btn-red tooltips" href="<?php echo base_url(); ?>account/open_orders" rel="tooltip" data-placement="top" title="" data-original-title="Back to Orders Listing">Go Back</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

<!-- Product Review Modal -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
            <div class="pull-left ratings-reviews-tittle">
               <h4 class="modal-title" id="myModalLabel"><b>Ratings & Reviews</b></h4>
            </div>
            <div class="pull-right ratings-reviews-product">
               <div class="reviews-product-item-inner clearfix">
                  <div class="reviews-product-contain">
                     <a class="reviews-product-link productSlug" target="_blank" href="">
                        <div class="a-row">
                           <h4 class="overflow-ellipsis productTitle"></h4>
                        </div>
                        <div class="a-row">
                           <div class="rating">
                              <span class="event_star star_small productRating" data-starnum="0.0"><i></i></span>
                           </div>
                        </div>
                     </a>
                  </div>
                  <div class="reviews-product-img">
                     <a target="_blank" class="productSlug" href="">
                     <img class="productImg" src="">
                     </a>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-body">
            <div class="rate-product-stars">
               <h4>Rate this product</h4>
               <div class="rating">
                  <span class="event_star1 star_big rating" data-starnum="0.0"><i class="puttingrate"></i></span>
               </div>
               <div style="display:none; color: red; font-size: 12px;" id="errMsg"></div>
            </div>
            <div class="review-product-descropation">
               <form id="ratingForm" method="post" data-bvalidator-validate>
                  <div class="loading main-loader" id='loaderImg' style="display: none;">
                     <div class="loader">
                        <svg class="circular-loader" viewBox="25 25 50 50" >
                           <circle class="loader-path" cx="50" cy="50" r="20" fill="none" stroke="#f45b69" stroke-width="2.5" />
                        </svg>
                     </div>
                  </div>
                  <div class="review-descropation">
                     <textarea class="form-control" name="description" rows="6" placeholder="Description..." data-bvalidator="required" data-bvalidator-msg="Description is required"></textarea>
                  </div>
                  <div class="review-title-form">
                     <input type="hidden" class="form-control productVId" id="product_variation_id" name="product_variation_id">
                     <input type="hidden" class="form-control productIId" id="product_info_id" name="product_info_id">
                     <input type="hidden" class="form-control" id="ratingStar" name="ratingStar">
                  </div>
                  <div class="review-submit-btn">
                     <button type="button" class="btn btn-default-white" data-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-red submitRating">Submit</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>


<!-- Product Cancellation Modal -->
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
                           <textarea name="msg_of_reason" class="form-control tooltips" rel="tooltip" data-placement="top right" rows="6" placeholder="Please describe the cancellation reason" maxlength="500" data-bvalidator="required,maxlen[500]" data-bvalidator-msg="Please enter the message"><?php echo set_value('msg_of_reason'); ?></textarea>
                           <?php echo form_error('msg_of_reason') ?>
                        </div>
                     </div>
                     <input type="hidden" name="cancel_order_detail_id" id="odi_cancel" value="">
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


<!-- Product Return Modal -->
<div class="modal fade" id="returnpopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content support-ticket-modal comman-modal">
         <div class="modal-header comman-header-modal">
            <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><img src="<?php echo SELLER_THEME_URL; ?>/img/Icon_Basic_Close.svg" width="18"></span>
            </button>
            <h4 class="modal-title text-center" id="myModalLabel">Submit a Reason Of Returning</h4>
         </div>
         <div class="modal-body comman-body-modal">
            <form role="form" action="" method="post" id="returnReasonForm">
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
                           <select name="subject_of_reason" class="form-control" data-bvalidator="required" data-bvalidator-msg="Please select the reason for return">
                              <option value="">--Select the Reason--</option>
                              <?php
                                 $orderReturnReason = orderReturnReason(); 
                                 if(!empty($orderReturnReason)){ 
                                    foreach ($orderReturnReason as $key => $value) { 
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
                     <input type="hidden" name="return_order_detail_id" id="odi_return" value="">
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
   SITE_URL = "<?php echo base_url(); ?>";
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
   
   $('.event_star1').voteStar({
       callback: function(starObj, starNum){
           $("#ratingStar").val(starNum);
       }
   }); 
   
   /*Open product cancellation modal*/
   $('.showTD').on('click', function() {
       $('.trackingDetails').toggle(1000);
   });

   /*Open product cancellation modal*/
   $('.cancelItem').on('click', function() {
      var odiVal = $(this).attr("odi");
      if(odiVal){
         $('#odi_cancel').val(odiVal);
         $('#cancellationpopup').modal('show');
      }else{
         errMsg("Something went wrong! Please try again");
      }
       
   });
   

   /*Open product return modal*/
   $('.returnItem').on('click', function() {
      var odiVal = $(this).attr("odi");
      if(odiVal){
         $('#odi_return').val(odiVal);
         $('#returnpopup').modal('show');
      }else{
         errMsg("Something went wrong! Please try again");
      }
       
   });

   
   /*get particular product data for review section*/
   $('.writeAProductReview').on('click', function() {
       $('#ratingForm')[0].reset();
       $('#ratingStar').val('');
       $(".puttingrate").removeAttr("style");
       var pID = $(this).attr("pID");
       if(pID == '') {
       }else {
           $.ajax({
               url: SITE_URL + 'products/getParticularProductData',
               type: 'POST',
               data: {
                   pID: pID
               },
               cache: false,
               success: function(result) {
                   var data = JSON.parse(result);
                   if(data.status=='success'){
                     $('.productTitle').text(data.data.title);
                     $('.productSlug').attr("href", data.data.slug);
                     $('.productRating').attr("data-starnum", data.data.sum_rating);
                     $('.productImg').attr("src", data.data.image);
                     $('.productVId').val(data.data.product_variation_id_encode);
                     $('.productIId').val(data.data.product_info_id_encode);
                     $('.bs-example-modal-lg').modal('show');
                   }
               },
           });
       } 
   });
   
   
   /*Submit rating form*/
   $('#ratingForm').submit(function() {
      
      var rating = $("#ratingStar").val();
      if(!rating){
         $('#errMsg').show();
         $('#errMsg').html("please choose rating.<br>");
         return false;
      }

      $('#ratingForm').bValidator();
      // check if form is valid
      if($('#ratingForm').data('bValidator').isValid()){
         
         $("button").attr("disabled", true);
         var title = $("input[name=title]").val();
         var description = $("textarea[name=description]").val();
         var product_variation_id = $("input[name=product_variation_id]").val();
         var product_info_id = $("input[name=product_info_id]").val();
         var rating = $("#ratingStar").val();
   
         $.ajax({
            url: SITE_URL + 'account/insertProductRating',
            type: 'POST',
            data: {
                title: title,
                description: description,
                product_variation_id: product_variation_id,
                rating: rating,
                product_info_id: product_info_id
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
                    $("button").attr("disabled", false);
                    errMsg(data.msg);
                }else{
                    successMsg(data.msg);
                    setTimeout(function(){
                       location.reload();
                    }, 1000);
                }
            }
         });
      }
      return false;
   });
   
   
   /*Submit cancellation form*/
   $('#cancellationReasonForm').submit(function() {
        
      $('#cancellationReasonForm').bValidator();
      // check if form is valid
      if($('#cancellationReasonForm').data('bValidator').isValid()){
         
         $("button").attr("disabled", true);
         var order_detail_id = $("input[name=cancel_order_detail_id]").val();
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
                    $("button").attr("disabled", false);  
                    errMsg(data.msg);
                }else{
                    successMsg(data.msg);
                    setTimeout(function(){
                       location.reload();
                    }, 1000);
                }
            }
         });
      }
      return false;
   });
   

   /*Submit Return form*/
   $('#returnReasonForm').submit(function() {
        
      $('#returnReasonForm').bValidator();
      // check if form is valid
      if($('#returnReasonForm').data('bValidator').isValid()){
         
         $("button").attr("disabled", true);
         var order_detail_id = $("input[name=return_order_detail_id]").val();
         var subject_of_reason = $("select[name=subject_of_reason]").val();
         var msg_of_reason = $("textarea[name=msg_of_reason]").val();
   
         $.ajax({
            url: SITE_URL + 'order/return_process',
            type: 'POST',
            data: {
                order_status: 6,
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
                    $("button").attr("disabled", false);
                    errorMsg(data.msg);
                }else{
                    successMsg(data.msg);
                    setTimeout(function(){
                       location.reload();
                    }, 1000);
                }
            }
         });
      }
      return false;
   });

</script>