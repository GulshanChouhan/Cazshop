<div class="thankyou-block1">
  <br>
   <div class="theme-container">
      <div class="col-md-12">
         <div class="cart-holder">
            <div class="my-cart-container">
               <!--checkout-login-warp start here-->
               <div class="">
                  <h2 class="success-heading ">Thank you for your purchase</h2>
                  <div class="success-subheading">
                     <p>A copy of your order confirmation will be sent to your registered email.<br>
                        If you do not receive one please contact <a href="mailto:<?php echo get_option_url('EMAIl'); ?>" target="_blank"><?php echo get_option_url('EMAIl'); ?></a>
                     </p>
                  </div>
                  <h3><b class="confirm-line">Order Confirmation: #<?php echo $order_info->order_id; ?></b></h3>
                  <br>
                  <div class="col-md-12 col-sm-12 success-login-warp-right">
                     <div>
                     </div>
                     <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 no-padding">
                           <div class="table-responsive">
                              <table class="table">
                                 <tbody>
                                    <tr>
                                       <th width="5%">No.</th>
                                       <th width="50%">Product Info</th>
                                       <th class="text-center">Qty.</th>
                                       <th class="text-right">Price</th>
                                       <!--  <th  width="25%">Sub-total</th> -->
                                    </tr>
                                    <?php
                                      $i=0;
                                      $product_price = 0.00;
                                      $shipping_charges = 0.00;
                                      $total = 0.00; 

                                      foreach ($orders_details as $row) {
                                        $i++; 
                                        $product_details = json_decode($row->product_details);
                                        $product_price += $row->price;
                                        $shipping_charges += $row->shipping_charges;
                                        $total = $product_price + $shipping_charges;
                                    ?>
                                    <tr>
                                       <td><?php echo $i; ?>.</td>
                                       <td>
                                          <div class="order-product-heading">
                                             <h5 class="link-text"><?php echo $product_details->title; ?></h5> 
                                          </div>
                                          <?php 
                                            $tempMore = ""; 
                                            $product_variation_info = $product_details->product_variation_info;
                                            if(!empty($product_variation_info) && $product_variation_info!=''){
                                              $tempMore = "";
                                              $product_variation_info = json_decode($product_variation_info);
                                              if(!empty($product_variation_info)){
                                                foreach ($product_variation_info as $key => $value) {
                                                  $tempMore .= "<span>".ucfirst($key)." : &nbsp;".ucfirst($value)."</span><br>";
                                                }
                                              }
                                            }else{
                                              $tempMore = "";
                                              $product_basic_info = json_decode($product_details->product_basic_info);
                                              if(!empty($product_basic_info)){
                                                foreach ($product_basic_info as $key => $value) {
                                                  $tempMore .= "<span>".ucfirst($key)." : &nbsp;".ucfirst($value)."</span><br>";
                                                }
                                              }
                                            }
                                            echo $tempMore;
                                          ?>
                                       </td>
                                       <td class="text-center">1</td>
                                       <td class="text-right">
                                        <?php
                                          if($row->price){
                                            if($order_info->currency_type==1){
                                              $totalGross = $row->price * $order_info->currency_amount_in_ethereum;
                                            }else if($order_info->currency_type==2){
                                              $totalGross = $row->price * $order_info->currency_amount_in_bitcoin;
                                            }else{
                                              $totalGross = $row->price * $order_info->currency_amount_in_dollor;
                                            }
                                            echo getCurrencyIcon($order_info->currency_type).''.number_format($totalGross, 8); 
                                          }else{
                                            echo "0.00";
                                          }  
                                        ?> 
                                       </td>
                                    </tr>
                                    <?php } ?>
                                 </tbody>
                              </table>
                              <div class="col-md-6 pull-right no-padding">
                                 <table class="table pricie-grand-total text-right">
                                    <tbody>
                                       <tr>
                                          <td>Subtotal &nbsp;<span>:</span></td>
                                          <td>
                                            <?php
                                              if($product_price){
                                                if($order_info->currency_type==1){
                                                  $totalproduct_priceGross = $product_price * $order_info->currency_amount_in_ethereum;
                                                }else if($order_info->currency_type==2){
                                                  $totalproduct_priceGross = $product_price * $order_info->currency_amount_in_bitcoin;
                                                }else{
                                                  $totalproduct_priceGross = $product_price * $order_info->currency_amount_in_dollor;
                                                }
                                                echo getCurrencyIcon($order_info->currency_type).''.number_format($totalproduct_priceGross, 8); 
                                              }else{
                                                echo "-";
                                              }  
                                            ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>Shipping Charge :</td>
                                          <td>
                                            <?php
                                              if($shipping_charges){
                                                if($order_info->currency_type==1){
                                                  $totalshipping_chargesGross = $shipping_charges * $order_info->currency_amount_in_ethereum;
                                                }else if($order_info->currency_type==2){
                                                  $totalshipping_chargesGross = $shipping_charges * $order_info->currency_amount_in_bitcoin;
                                                }else{
                                                  $totalshipping_chargesGross = $shipping_charges * $order_info->currency_amount_in_dollor;
                                                }
                                                echo getCurrencyIcon($order_info->currency_type).''.number_format($totalshipping_chargesGross, 8); 
                                              }else{
                                                echo "-";
                                              }  
                                            ?>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>TOTAL &nbsp;<span>:</span></td>
                                          <td>
                                            <?php
                                              if($total){
                                                if($order_info->currency_type==1){
                                                  $totalGross = $total * $order_info->currency_amount_in_ethereum;
                                                }else if($order_info->currency_type==2){
                                                  $totalGross = $total * $order_info->currency_amount_in_bitcoin;
                                                }else{
                                                  $totalGross = $total * $order_info->currency_amount_in_dollor;
                                                }
                                                echo getCurrencyIcon($order_info->currency_type).''.number_format($totalGross, 8); 
                                              }else{
                                                echo "-";
                                              }  
                                            ?>
                                          </td>
                                       </tr>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 ship-add-block">
                           <address class="ship-add">
                              <h4><b>Shipping to:</b></h4>
                              <?php 
                                $shipping_address = json_decode($order_info->shipping_address);
                       
                                if(!empty($shipping_address)){
                              ?>
                              <table class="table order_managment bill-info-managment">
                                 <tbody>
                                    <tr>
                                       <td><?php echo ucwords($shipping_address->first_name." ".$shipping_address->last_name); ?>                  <br>
                                          <?php echo $shipping_address->city; ?> <br><?php echo $shipping_address->address; ?> <br> <?php echo $shipping_address->zip_code; ?> <?php echo $shipping_address->country; ?>                  
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                              <?php 
                                }
                              ?>
                           </address>
                           <address class="help-ship-add">
                              <h4><b>Still Need Help?</b></h4>
                              <p><a href="mailto:<?php echo get_option_url('EMAIl')?>"><i class="fa fa-envelope" aria-hidden="true"></i> &nbsp;<?php echo get_option_url('EMAIl')?></a></p>
                              <p><a href=""></a><i class="fa fa-phone" aria-hidden="true"></i> &nbsp;&nbsp;<a href="tel:<?php echo get_option_url('PHONE'); ?>" style="color:#373d3f; text-decoration: none;"><?php echo get_option_url('PHONE'); ?></a></p>
                           </address>
                        </div>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                  <?php if(empty($order_info->order_msg)){ ?>
                  <div class="success-customer-help row">
                     <div class="col-md-6 col-sm-6 success-login-warp-left">
                        <div class="">
                           <div class="thankyou-info-line">
                              Our customers are important to us.
                              Feel free to leave feedback below.
                           </div>
                        </div>
                        <form role="form" action="" method="post" id="form_valid" data-bvalidator-validate>
                           <div class="">
                              <div class="form-group">
                                 <textarea class="form-control" name="message" id="message" rows="4" data-bvalidator="required"></textarea>
                                  <span class="error"><?php echo form_error('message'); ?> </span>
                              </div>
                              <div><input type="submit" value="Submit" class="btn btn-gray-new pull-right"></div>
                           </div>
                        </form>
                     </div>
                     <div class="clearfix visible-xs"></div>
                     <div class="col-md-6 col-sm-5">
                     </div>
                     <div class="clearfix"></div>
                  </div>
                  <?php } ?>
                  <div class="clearfix"></div>
                  <br>
               </div>
            </div>
         </div>
      </div>
      <div class="clearfix"></div>
   </div>
  <br>
</div>

<script>
  $('#form_valid').submit(function() {
      $('#form_valid').bValidator();
  });
</script>