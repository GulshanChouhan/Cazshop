<section class="cart-page-warp">
   <div class="container-fluid two-col-holder">
      <!--cart page start here-->
      <div class="cart-holder">
         <div class="my-cart">
            <!--checkout-login-warp start here-->
            <div class="">
               <div class="">
               <!-- <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12 order-overview-block block">
                  <?php if($product_amountInfo['type']==2){ ?>
                  <div class="pull-left">
                     <a href="<?php echo base_url('cart/index'); ?>" class="back-cart-link"> &lt; Back to cart</a>
                  </div>
                  <?php }else if($product_amountInfo['type']==1){ ?>
                  <div class="pull-left">
                     <a href="<?php echo base_url('pd/'.$ProductInfo[0]->slug.'/'.base64_encode($ProductInfo[0]->product_variation_id)); ?>" class="back-cart-link"> &lt;  Buy related of this product</a>
                  </div>
                  <?php } ?>
                  <div class="more-btn-block pull-right">
                     <div>
                        <a href="javascript:void(0)" class="show_data btn btn-blue" style="float: right; display: block;"> Show Order Details</a>
                        <a href="javascript:void(0)" class="show_data1 btn btn-blue" style="float: right; display: none;"> Hide Order Details</a>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                  <br>
                  <h3 class="block-head">Order Overview</h3>
                  <div class="my-cart-block">
                     <div class="my-cart-desc my-cart-desc-order-view" style="border-bottom-color: transparent;">
                        <div class="table-responsive">
                           <table class="table">
                              <tbody>
                              <?php 
                                 $grand_total = 0.00; $i = 1;
                                 $shippingTotalCharges = 0.00;
                                 if (!empty($ProductInfo)){
                                    foreach ($ProductInfo as $item){
                                       if($item->sale_start_date!='' && $item->sale_start_date<=date('Y-m-d') && $item->sale_end_date!='' && $item->sale_end_date>=date('Y-m-d')){
                                          $item->base_price = $item->sale_price;
                                       }
                                       $Image = $item->image;
                                       $Image = explode(',', $Image);
                                 ?>
                                 <tr class="show_cart_item" style="border-bottom: 1px solid rgb(55, 61, 63); display: none;">
                                    <td width="120" class="pro-view-th">
                                       <div class="cart-product text-center">
                                          <span class="img-view-box no-padding">
                                          <img id="front508849239342077710458" src="<?php echo base_url(); ?>assets/uploads/seller/products/thumbnail/<?php echo $Image[0]; ?>" width="100" style="display: inline;">
                                          </span>
                                       </div>
                                       <div class="clearfix"></div>
                                    </td>
                                    <td class="pro-desc-th" width="200">
                                       <p>
                                          <b><?php echo ucwords($item->title); ?></b> <span style="color: #ff0000; font-size: 12px;">(Shipping charges: $<?php echo number_format($item->shipping_charges,2); ?></span>)
                                       </p>
                                       <p>
                                          <?php
                                             $tempMore = ""; 
                                             $product_variation_info = (isset($item->product_variation_info)) ? $item->product_variation_info : array();
                                             if(!empty($product_variation_info) && $product_variation_info!=''){
                                                $tempMore = "";
                                                $product_variation_info = json_decode($product_variation_info);
                                                if(!empty($product_variation_info)){
                                                   foreach ($product_variation_info as $key => $value) {
                                                      $tempMore .= "<span>".ucfirst($key).": &nbsp;".ucfirst($value)."</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                   }
                                                }
                                             }
                                             echo $tempMore;
                                          ?>
                                       </p>
                                       <div>
                                          Qty:1
                                       </div>
                                       <div>
                                          Price:$<?php echo number_format($item->base_price,2); ?>       
                                       </div>
                                    </td>
                                 </tr>
                                 <?php 
                                    } 
                                    }
                                    ?>
                              </tbody>
                           </table>
                           <table class="table">
                              <tbody>
                                 <?php 
                                    $grand_total = 0.00; $i = 1;
                                    $shippingTotalCharges = 0.00;
                                    if (!empty($ProductInfo)){
                                       foreach ($ProductInfo as $item){
                                          if($item->sale_start_date!='' && $item->sale_start_date<=date('Y-m-d') && $item->sale_end_date!='' && $item->sale_end_date>=date('Y-m-d')){
                                             $item->base_price = $item->sale_price;
                                          }

                                          $Image = $item->image;
                                          $Image = explode(',', $Image);
                                    ?>
                                 <tr class="single-tr">
                                    <td class="first-td">
                                       <table class="">
                                          <tbody>
                                             <tr>
                                                <td width="75%">
                                                   <div class="pro-view-th">
                                                      <p>
                                                         <b><?php echo ucwords($item->title); ?></b> <span style="color: #ff0000; font-size: 12px;"><br>(Shipping charges: $<?php echo number_format($item->shipping_charges,2); ?></span>)
                                                      </p>
                                                   </div>
                                                </td>
                                                <td class="text-right pro-view-th">
                                                   <p class="pull-right  ">
                                                      <b>$<?php echo number_format($item->base_price,2); ?>    </b>
                                                   </p>
                                                </td>
                                             </tr>
                                             <tr>
                                                <td colspan="2">
                                                   <div class="pro-desc-th" width="200">
                                                      <table width="100%" style="table-layout: fixed;">
                                                         <tbody>
                                                            <tr>
                                                               <td>
                                                                  <p>
                                                                     <?php
                                                                        $tempMore = ""; 
                                                                        $product_variation_info = (isset($item->product_variation_info)) ? $item->product_variation_info : array();
                                                                        if(!empty($product_variation_info) && $product_variation_info!=''){
                                                                           $tempMore = "";
                                                                           $product_variation_info = json_decode($product_variation_info);
                                                                           if(!empty($product_variation_info)){
                                                                              foreach ($product_variation_info as $key => $value) {
                                                                                 $tempMore .= "<span>".ucfirst($key).": &nbsp;".ucfirst($value)."</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                                                              }
                                                                           }
                                                                        }
                                                                        echo $tempMore;
                                                                     ?>
                                                                  </p>            
                                                               </td>
                                                               <td>
                                                                  Qty: <span style="position: relative;top:1px;">1</span>
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </div>
                                                </td>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </td>
                                 </tr>
                                 <?php 
                                    } 
                                    }
                                    ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                     <div class="pull-right order-summary-warp no-padding">
                        <table class="table pricie-grand-total" align="right">
                           <tbody id="sub_total_show">
                              <tr>
                                 <td>Subtotal &nbsp;<span>:</span></td>
                                 <td>$<?php echo number_format($product_amountInfo['grossAmount'],2); ?></td>
                              </tr>
                              <tr>
                                 <td>Shipping Charges &nbsp;<span>:</span></td>
                                 <td>$<?php echo number_format($product_amountInfo['shipping_charges'],2); ?></td>
                              </tr>
                              <tr class="grand-total-tr">
                                 <td><strong>TOTAL &nbsp;<span>:</span></strong></td>
                                 <td> $<?php echo number_format($product_amountInfo['totalAmount']+$product_amountInfo['shipping_charges'],2); ?></td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div> -->
               <div class="col-md-6 col-lg-6 block order-overview-block">
                     <div class="section_loader_shipp" style="display:none;">
                        <img src="#/assets/front/images/shippingpage.gif">
                     </div>
                     <?php if($product_amountInfo['type']==2){ ?>
                     <div class="pull-left">
                        <a href="<?php echo base_url('cart/index'); ?>" class="back-cart-link"> &lt; Back to cart</a>
                     </div>
                     <?php }else if($product_amountInfo['type']==1){ ?>
                     <div class="pull-left">
                        <!-- <a href="<?php echo base_url('pd/'.$ProductInfo[0]->slug.'/'.base64_encode($ProductInfo[0]->product_variation_id)); ?>" class="back-cart-link"> &lt;  Buy related of this product</a> -->
                     </div>
                     <?php } ?>
                     <div class="more-btn-block pull-right">
                        <div class="clearfix">
                           <a href="javascript:void(0)" class="show_data btn btn-blue" style="float: right; display: block;">
                              <!-- <i class="fa fa-plus-square" aria-hidden="true"></i> -->Show Order Details
                           </a>
                           <a href="javascript:void(0)" class="show_data1 btn btn-blue" style="float: right; display: none;">Hide Order Details</a>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                     <br>
                     <h3 class="block-head">Order Overview</h3>
                     <div class="my-cart-block shopbilling-cart-block">
                        <div class="my-cart-desc">
                           <div class="table-responsive">
                              <table class="table order-with-product" style="margin-bottom: 0px;">
                                 <tbody>
                                    <?php 
                                       $grand_total = 0.00; $i = 1;
                                       if (!empty($ProductInfo)){
                                          foreach ($ProductInfo as $item){
                                             if($item->sale_start_date!='' && $item->sale_start_date<=date('Y-m-d') && $item->sale_end_date!='' && $item->sale_end_date>=date('Y-m-d')){
                                                $item->base_price = $item->sale_price;
                                             }
                                             $Image = $item->image;
                                             $Image = explode(',', $Image);
                                       ?>
                                    <tr class="show_cart_item" style="border-bottom: 1px solid rgb(55, 61, 63); display: none;">
                                       <td width="250" class="pro-view-th">
                                          <div class="cart-product text-center">
                                             <span class="img-view-box no-padding">
                                             <img src="<?php echo base_url(); ?>assets/uploads/seller/products/thumbnail/<?php echo $Image[0]; ?>" style="display: inline;">
                                             </span>
                                             <div class="clearfix"></div>
                                          </div>
                                          <div class="clearfix"></div>
                                       </td>
                                       <td class="pro-desc-th">
                                          <h5 class="pro-view-tittle">
                                             <?php echo $item->title; ?>
                                          </h5>
                                          <!-- <div class="cart-color">
                                             <span class="head-name">Color: &nbsp;</span>
                                                     <div class="color_outter_box">
                                                <span class="productIColor color_div" style="background-color:" title=""   data-toggle='tooltip' data-placement='top' data-original-title=''>
                                                </span>
                                                </div>
                                             <span class="cart-productcolor-name">Black</span>
                                             </div> -->
                                          <!-- <p>Color: </p> -->
                                          <div class="clearfix"></div>
                                          
                                             <?php
                                                $tempMore = "";
                                                $product_variation_info = (isset($item->product_variation_info)) ? $item->product_variation_info : array(); 
                                                if(!empty($product_variation_info) && $product_variation_info!=''){
                                                   $tempMore = "";
                                                   $product_variation_info = json_decode($product_variation_info);
                                                   if(!empty($product_variation_info)){
                                                      foreach ($product_variation_info as $key => $value) {
                                                         $tempMore .= "<div class='col-md-6 no-padding-left'> <label>".ucfirst($key).":</label> &nbsp;".ucfirst($value)."</div>";
                                                      }
                                                   }
                                                }
                                                echo $tempMore;
                                             ?>
                                          <div class="clearfix"></div>
                                          <br>
                                          <p><label>Qty:</label> 1</p>
                                          <div class="shipping-charge-tittle">
                                             <p class=""><label>Shipping charges:</label> $<?php echo number_format($item->shipping_charges,2); ?></p>
                                          </div>
                                          <!--        </td>
                                             <td align="right"  width="110"> -->
                                          <div class="clearfix"></div>
                                             <!-- <div>
                                                <p>Reg Price:
                                                   <del>$<?php //echo number_format($item->sell_price,2); ?></del>    
                                                </p>  
                                             <div> -->
                                                <p><a href="<?php echo base_url('pd/'.$item->slug.'/'.base64_encode($item->product_variation_id)); ?>" class=""> &lt; Buy more of this product
                                                   </a>
                                                </p>
                                                <p>
                                                   <a href="<?php echo base_url('p'); ?>" class=""> &lt; Continue shopping
                                                   </a>
                                                </p>
                                             </div>
                                             <div class="clearfix"></div>
                                          </div>
                                       </td>
                                    </tr>
                                    <?php 
                                       } 
                                       }
                                       ?>
                                 </tbody>
                              </table>
                              <!--      -->
                              <!--   -->
                              <table class="table summary-table table-condensed">
                                 <tbody>
                                    <?php 
                                       $grand_total = 0.00; $i = 1;
                                       if (!empty($ProductInfo)){
                                          foreach ($ProductInfo as $item){

                                             if($item->sale_start_date!='' && $item->sale_start_date<=date('Y-m-d') && $item->sale_end_date!='' && $item->sale_end_date>=date('Y-m-d')){
                                                $item->base_price = $item->sale_price;
                                             }
                                             $Image = $item->image;
                                             $Image = explode(',', $Image);
                                       ?>
                                    <tr class="single-tr">
                                       <td width="70%" class="first-td">
                                          <div class="pro-view-th">
                                             <h4 class="pro-view-tittle">
                                                <?php echo $item->title; ?>
                                             </h4>
                                          </div>
                                          <div class="pro-desc-th">
                                             <table class="table table-condensed">
                                                <tbody>
                                                   <tr>
                                                      <td class="no-padding-left" width="20%">
                                                         <p class="pull-left">
                                                            <?php
                                                               $tempMore = ""; 
                                                               $product_variation_info = (isset($item->product_variation_info)) ? $item->product_variation_info : array();
                                                               if(!empty($product_variation_info) && $product_variation_info!=''){
                                                                  $tempMore = "";
                                                                  $product_variation_info = json_decode($product_variation_info);
                                                                  if(!empty($product_variation_info)){
                                                                     foreach ($product_variation_info as $key => $value) {
                                                                        $tempMore .= "<div class='col-md-6 no-padding-left'> <label>".ucfirst($key).":</label> &nbsp;".ucfirst($value)."</div>";
                                                                     }
                                                                  }
                                                               }
                                                               echo $tempMore;
                                                            ?>
                                                         </p>
                                                      </td>
                                                      <!--<td>
                                                         <div class="cart-color pull-left">
                                                            <span class="head-name">Color: &nbsp;</span>
                                                                    <div class="color_outter_box">
                                                               <span class="productIColor color_div" style="background-color:" title=""   data-toggle='tooltip' data-placement='top' data-original-title=''>
                                                               </span>
                                                               </div> 
                                                            <span class="">Black</span>
                                                         </div>
                                                      </td>-->
                                                   </tr>
                                                   <tr>
                                                      <td class="no-padding-left">
                                                         <p class="pull-left"><label>Qty:</label> 1</p>
                                                      </td>
                                                   </tr>
                                                   <tr>
                                                      <td class="no-padding-left">
                                                         <?php if($item->shipment_rate_type!=1 && $item->shipment_rate_type!=2 && $item->shipment_rate_type!=3){ ?>
                                                            <p class="pull-left pItem<?php echo $item->product_variation_id; ?>" style="color: red; display: none;"><b>The Delivery of the product haven't applicable by the seller. If you want to remove it, <a class="removeProduct" href="javascript:void(0)" onclick="return confirmBox('Do you want to remove it ?','<?php echo base_url('order/removeProduct/'.base64_encode($item->product_variation_id).'/'.base64_encode($shipping_addresessId)); ?>')">click here</a></b></p>
                                                         <?php }else{ ?>
                                                            <?php if($item->shipment_rate_type==1){ ?>
                                                               <p class="pull-left"><label>Shipping charges:</label> Free Delivery</p>
                                                            <?php }else{ ?>
                                                               <p class="pull-left"><label>Shipping charges:</label> $<?php echo number_format($item->shipping_charges,2); ?></p>
                                                            <?php } ?>
                                                         <?php } ?>
                                                      </td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                             <div class="clearfix"></div>
                                          </div>
                                       </td>
                                       <td class="text-right pro-view-th font-roboto">
                                          <p class="pull-right ">
                                             <span class="new-price_cart font-roboto"><b>$<?php echo number_format($item->base_price,2); ?></b></span>&nbsp;
                                             <span class="reg_price font-roboto"><del><b>$<?php echo number_format($item->sell_price,2); ?></b></del></span>
                                          </p>
                                       </td>
                                    </tr>
                                    <?php 
                                       } 
                                       }
                                       ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                        <div class="pull-right order-summary-warp no-padding">
                           <table class="table pricie-grand-total" align="right">
                              <tbody id="sub_total_show">
                                 <tr>
                                    <td>Subtotal &nbsp;<span>:</span></td>
                                    <td>$<?php echo number_format($product_amountInfo['grossAmount'],2); ?></td>
                                 </tr>
                                 <tr>
                                    <td>Shipping Charges &nbsp;<span>:</span></td>
                                    <td>$<?php echo number_format($product_amountInfo['shipping_charges'],2); ?></td>
                                 </tr>
                                 <tr class="grand-total-tr">
                                    <td><strong>TOTAL &nbsp;<span>:</span></strong></td>
                                    <td><strong> $<?php echo number_format($product_amountInfo['totalAmount']+$product_amountInfo['shipping_charges'],2); ?></strong></td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                        <div class="clearfix"></div>
                     </div>
               </div>

               <?php 
                  $country = getData('countries',array('id',$shipping_addresess->country))->name;
                  $state = getData('states',array('id',$shipping_addresess->state))->name;
                  $city = getData('cities',array('id',$shipping_addresess->city))->name;
               ?>
               <div class="col-md-6 col-lg-6 col-xs-12 no-padding block right-column">
                  <!-- <div class="col-md-3 col-lg-3 col-sm-8 col-xs-8"> -->
                  <div class="col-md-6 col-sm-6 form-group">
                     <h3 class="block-head">Deliver Address <!-- <a href="#" class="address-edit" data-toggle="tooltip" data-placement="top" title="Edit shipping address"><i class="fa fa-edit"></i></a> --></h3>
                     <div class="">
                        <div class="col-sm-12 order-billing-add">
                           <?php echo $shipping_addresess->first_name; ?>
                           <?php echo $shipping_addresess->last_name; ?><br>
                           <?php echo $shipping_addresess->address; ?><br>
                           <?php echo $city.', '; ?>
                           <?php echo $state.', '; ?>
                           <?php echo $country.', '; ?>
                           <?php echo $shipping_addresess->zip_code; ?><br>
                        </div>
                        <div class="clearfix"></div>
                     </div>
                     <div class="clearfix"></div>
                  </div>
                  <!-- </div> -->
                  <div class="col-md-6 col-sm-6 form-group">
                     <h3 class="block-head">Contact Info  <!-- <a href="#" class="address-edit" data-toggle="tooltip" data-placement="top" title="Edit Contact detail">
                        <i class="fa fa-edit"></i></a> -->
                     </h3>
                     <div class="order-billing-add">
                        <div class="">
                           <div class="contact-line"><?php echo '+'.$shipping_addresess->country_code.' '.$shipping_addresess->phone_no; ?></div>
                           <div><?php echo $shipping_addresess->email_id; ?></div>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                  </div>
                  <div class="col-md-12 col--sm-12">
                     <div class=""><hr></div>
                  </div>
                  <div class="col-md-6 col-sm-6 total-payment-block form-group">
                     <div class="cart-grand-total">
                        <h3 class="block-head">Total Payment</h3>
                        <table class="table pricie-grand-total ">
                           <tbody>
                              <tr>
                                 <td>Subtotal &nbsp;<span>:</span></td>
                                 <td>$<?php echo number_format($product_amountInfo['grossAmount'],2); ?></td>
                              </tr>
                              <tr>
                                 <td> Shipping charge &nbsp;<span>:</span>
                                 </td>
                                 <td><?php echo number_format($product_amountInfo['shipping_charges'],2); ?></td>
                              </tr>
                              <tr>
                                 <td> GST (5 %) &nbsp;<span>:</span>
                                 </td>
                                 <td>-</td>
                              </tr>
                              <tr class="grand-total-tr">
                                 <td><strong>TOTAL &nbsp;<span>:</span></strong></td>
                                 <td> $ <span class="total_amount" data="<?php echo number_format($product_amountInfo['totalAmount'],2); ?>"><?php echo number_format($product_amountInfo['totalAmount']+$product_amountInfo['shipping_charges'],2); ?><span></span></span></td>
                              </tr>
                           </tbody>
                        </table>
                        <div class="clearfix"></div>
                     </div>
                  </div>
                  <div class="col-md-6 col-sm-6 form-group">
                     <br><br><br><br><br>
                     <div class="continue-payment-block">
                        <button type="button" class="btn btn-red btn-lg continuePayment">Continue to payment</button>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                  <!-- <form action="#/cart/gift_cart_used" id="giftcartused" method="post" class="form-horizontal">
                     <div class="form-group shipping-extras">
                        <div class="col-sm-8 col-md-8 pull-right">
                           <div class="gift-price-selector">
                              <div class="gift-price-selector-inner">
                                 <div class="bill-add-gift-line text-center">
                                    <h4>Gift Card balance available in your account   </h4>
                                 </div>
                                 <div class="gift-price-sub-section">
                                    <div class="">
                                       <div class="gift_card_amot form-group">
                                          <label class="control-label col-sm-9">Test_Corporate_GC( $4.05)  <a class="popover_gift" id="popVolume_discount18" rel="popover" data-content="You can use $4.05" data-placement="top" data-trigger="hover" data-original-title="" title=""><i class="fa fa-question-circle" aria-hidden="true"></i></a> :</label>
                                          <div class="col-sm-3">
                                             <div class="input-group">
                                                <div class="input-group-addon">$</div>
                                                <input type="value" data="4.05" name="amount[18]" value="" class="form-control gift_amount">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="gift_card_amot form-group">
                                          <label class="control-label col-sm-9">Test_Corporate_GC( $0.17)  <a class="popover_gift" id="popVolume_discount19" rel="popover" data-content="You can use $0.17" data-placement="top" data-trigger="hover" data-original-title="" title=""><i class="fa fa-question-circle" aria-hidden="true"></i></a> :</label>
                                          <div class="col-sm-3">
                                             <div class="input-group">
                                                <div class="input-group-addon">$</div>
                                                <input type="value" data="0.17" name="amount[19]" value="" class="form-control gift_amount">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="gift_card_amot form-group">
                                          <label class="control-label col-sm-9">Gift Card Balance ( $28.71)  <a class="popover_gift" id="popVolume_discount0" rel="popover" data-content="You can use $28.71" data-placement="top" data-trigger="hover" data-original-title="" title=""><i class="fa fa-question-circle" aria-hidden="true"></i></a> :</label>
                                          <div class="col-sm-3">
                                             <div class="input-group">
                                                <div class="input-group-addon">$</div>
                                                <input type="value" data="28.71" name="amount[0]" value="" class="form-control gift_amount">
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="gift-price-footer clearfix">
                                    <span class="pull-left"><button type="submit" disabled="" class="btn btn-orange btn-sm apply_button_gift"> Apply Now</button></span>
                                    <span class="pull-right amount-block error_msg" style="display:none;color:red;font-size: 13px;">Total amount should be less then and equal to $50.</span>
                                    <span class="pull-right amount-block">Use Gift Card Amount : $ <b class="gift_amount_card">0.00</b></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="clearfix"></div>
                     </div>
                  </form> -->
               </div>
            </div>
            <div class="clearfix"></div>
         </div>
         <div class="clearfix"></div>
         <br>
         <!-- <div class="col-md-12">
            <p class="order-review-note">
               <b>PLEASE NOTE:</b> Most orders are produced &amp; shipped within 5-10 business days. In some cases orders will be delayed further due unforeseen circumstances including products out of stock &amp; inclement weather.
            </p>
         </div>
         <div class="clearfix"></div>
         <div class="block payment-detail-column">
            <div class="col-md-7 col-lg-7 col-sm-6 ">
                <h3>Paypal Information</h3> 
               <div class="paypal-info-warp">
                  <div class="col-md-10 payment center-block">
                      <p class="paypal-text heading">You'll be directed to sign in with your PayPal account and pay through PayPal's secure service.<br></p> 
                     <br>
                     <p class="paypal-text">
                        When selecting the PayPal payment method you will be redirected to PayPal. There you can log in or create a new PayPal account to make your payment.
                        Once you have confirmed the payment you will be redirected back to complete your Order.
                     </p>
                     <div class="paypal-btn-warp text-center">
                         <h4><u>Click here to checkout with Paypal</u></h4> 
                        <form action="#/cart/paymentByPaypal" method="POST">
                           <input type="image" name="paypal_submit" id="paypal_submit" src="http://v2.urstore.net/assets/front/images/express-checkout.png" border="0" align="top" alt="Pay with PayPal">
                        </form>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-5 col-lg-5 col-sm-6 payment-card-detail-column">
               <h3 class="block-head">Credit Card Info</h3>
               <div class="clearfix"></div>
               <div class="creadit-cardinfo-form-warp ">
                    <p class="paypal-text heading">Enter the billing details for your credit card in the secure form below. Make sure that the details match those on file with your card provider.</p><br>
                  <form method="post" role="form" id="form_valid" action="#/cart/order_review">
                     <div class="center-block credit-form-warp-outer">
                        <div class="credit-form-warp">
                           <div class="form-group">
                              <div class="col-md-12 col-sm-12 col-xs-12 ">
                                 <label class="col-md-12 no-padding-left control-label" for="normal-field">
                                 <span style="color:red;">*</span>Card Number</label>
                                 <input name="cardnumber" type="text" class="card-number form-control" data-bvalidator="required" data-bvalidator-msg="required">
                                 <div class="pull-right creadit-cardinfo-img-warp">
                                    <img src="#/assets/front/images/paypal-stipe.png" alt="" class="img-responsive">
                                 </div>
                              </div>
                              <div class="clearfix"></div>
                           </div>
                           <div class="clearfix"></div>
                           <div class="form-group">
                              <div class="col-md-12 no-padding-right">
                                  <label class="col-md-12 col-sm-12 col-xs-12 control-label no-padding-left" for="default-select"><span style="color:red;">*</span>Expiration Month /Year</label>
                                 <div class="col-md-3 col-sm-3 col-xs-3 no-padding cvv-number-warp">
                                    <label class="col-md-12 control-label no-padding" for="default-select"><span style="color:red;">*</span>CVV</label>
                                    <div class="col-md-12  no-padding">
                                       <input type="text" name="cvm" maxlength="4" class="card-cvc form-control" data-bvalidator="required" data-bvalidator-msg="required">
                                    </div>
                                 </div>
                                 <div class="col-md-1 col-sm-1 col-xs-1 no-padding-left">
                                    <label></label>
                                    <a href="javascript:void()" id="popover" data-trigger="hover" class="btn-card-help btn-sm tooltips" rel="popover" data-placement="left" data-original-title="" style="border-radius:50%;"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
                                 </div>
                                 <div class="col-md-4 col-sm-4 col-xs-4 card-expiry-month-block">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label no-padding" for="default-select">Month</label>
                                       <select class="card-expiry-month chzn-select form-control" data-bvalidator="required" data-bvalidator-msg="required" name="cardexpmonth">
                                          <option value="01">01</option>
                                          <option value="02">02</option>
                                          <option value="03">03</option>
                                          <option value="04">04</option>
                                          <option value="05">05</option>
                                          <option value="06">06</option>
                                          <option value="07">07</option>
                                          <option value="08">08</option>
                                          <option value="09">09</option>
                                          <option value="10">10</option>
                                          <option value="11">11</option>
                                          <option value="12">12</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-md-4 col-sm-4 col-xs-4 card-expiry-year-block">
                                    <div class="form-group">
                                       <label class="col-md-12 control-label no-padding" for="default-select">Year</label>
                                       <select name="cardexpyear" class="card-expiry-year form-control" data-bvalidator="required" data-bvalidator-msg="required">
                                          <option value="18">2018</option>
                                          <option value="19">2019</option>
                                          <option value="20">2020</option>
                                          <option value="21">2021</option>
                                          <option value="22">2022</option>
                                          <option value="23">2023</option>
                                          <option value="24">2024</option>
                                          <option value="25">2025</option>
                                          <option value="26">2026</option>
                                          <option value="27">2027</option>
                                          <option value="28">2028</option>
                                          <option value="29">2029</option>
                                          <option value="30">2030</option>
                                          <option value="31">2031</option>
                                          <option value="32">2032</option>
                                          <option value="33">2033</option>
                                          <option value="34">2034</option>
                                          <option value="35">2035</option>
                                          <option value="36">2036</option>
                                          <option value="37">2037</option>
                                          <option value="38">2038</option>
                                          <option value="39">2039</option>
                                          <option value="40">2040</option>
                                          <option value="41">2041</option>
                                          <option value="42">2042</option>
                                          <option value="43">2043</option>
                                          <option value="44">2044</option>
                                          <option value="45">2045</option>
                                          <option value="46">2046</option>
                                          <option value="47">2047</option>
                                          <option value="48">2048</option>
                                       </select>
                                    </div>
                                 </div>
                                 <div class="clearfix"></div>
                              </div>
                              <div class="clearfix"></div>
                           </div>
                           <br>
                           <div class="form-group">
                              <div class="col-md-12">
                                 <div class="place-order-btn-block">
                                    <button type="submit" id="pay_by_card" class="place-order-btn btn btn-orange" value="Place Order">
                                    Submit Order
                                    </button>
                                 </div>
                                 <div class="clearfix"></div>
                              </div>
                           </div>
                           <div class="clearfix"></div>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                  </form>
               </div>
            </div>
            <div class="clearfix"></div>
         </div> -->
      </div>
   </div>
</section>
<style>
.removeProduct{
   color: #0098d2;
}

.removeProduct:hover{
   color: #0098d2;
   text-decoration: underline;
}
</style>
<script>
   SITE_URL = "<?php echo base_url(); ?>";
   var is_error = false;
   $('.continuePayment').on('click', function() {
      var productData = <?php echo json_encode($this->session->userdata('buyProductInfo')); ?>;
      $.each(productData, function(i) {
//         console.log(productData[i].shipping_charges);
         if(productData[i].shipment_rate_type=='' || productData[i].shipment_rate_type==0.00){
            $(".pItem"+productData[i].product_variation_id).show();
            is_error = true;
         }
      });
      if (is_error) {
         return false;
      }
      $(location).attr('href', '<?php echo base_url('order/directPayment/'.$shipping_addresessId); ?>');
   });
</script>