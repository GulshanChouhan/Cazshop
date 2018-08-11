<section class="">
   <div class="cart-holder">
      <div class="clearfix"></div>
      <div class="">
         <div class="cart-page-warp">
            <div class="theme-container">
               <div class="col-md-12 col-lg-12 no-padding-left">
                  <h3 class="heading"><b>Shopping Cart </b></h3>
                  <div class="clearfix"></div>
                  <!-- <div class="shipping_billing_message">
                     <p><span style="color: #ff0000;"><strong>IMPORTANT</strong>:</span>&nbsp;Your order will be custom produced. Please ensure you review your order to confirm design, personalization, color, size and quantity are correct.</p>
                  </div> -->
               </div>
               <div class="clearfix"></div>
               <?php msg_alert(); ?>
               <br>
               <?php 
                  $cart = $this->cart->contents(); 
                  if (!empty($cart)){ 
               ?>
               <form action="<?php echo base_url('cart/update_cart'); ?>" method="post" accept-charset="utf-8">
                  <div class="table-responsive my-cart-desc-table customscrollbar">
                     <div class="myCartDescBg"></div>
                     <table class="table my-cart-desc">
                        <tbody>
                           <tr class="first-tr">
                              <th class="cart-desc-th">Product Description</th>
                              <th class="cart-price-th">Price</th>
                              <!-- 	    <th class="cart-discount-th">Discount</th> -->
                              <th class="cart-qty-th">Quantity</th>
                              <th class="cart-total-th">Sub-total</th>
                           </tr>
                           <?php 
                              $grand_total = 0.00; $i = 1;
                           	foreach ($cart as $item){
                           		$Image = $item['image'];
                           		$Image = explode(',', $Image);
                              ?>
                           <tr>
                              <td class="cart-prodcut-deatil">
                                 <div class="cart-prodcut-deatil-box">
                                    <div class="cart-product">
                                       <span class="no-padding-left img-view-box">
                                          <img src="<?php echo base_url(); ?>assets/uploads/seller/products/thumbnail/<?php echo $Image[0]; ?>">
                                       </span>
                                       <span class="details-view-box">
                                          <h4><?php echo $item['name']; ?></h4>
                                          <?php
                                             $tempMore = ""; 
                                             $product_variation_info = (isset($item['product_variation_info'])) ? $item['product_variation_info'] : array();
                                             if(!empty($product_variation_info) && $product_variation_info!=''){
                                                $tempMore = "";
                                                $product_variation_info = json_decode($product_variation_info);
                                                if(!empty($product_variation_info)){
                                                   foreach ($product_variation_info as $key => $value) {
                                                      $tempMore .= "<span> <label>".ucfirst($key).":</label> &nbsp;".ucfirst($value)."</span><br>";
                                                   }
                                                }
                                             }
                                             echo $tempMore;
                                          ?>
                                          <p>
                                             <a href="<?php echo base_url('pd/'.$item['slug'].'/'.base64_encode($item['id'])); ?>" class=""> &lt; Buy More Of This Product</a>
                                          </p>
                                       </span>
                                       <div class="clearfix"></div>
                                       <!-- <div class="col-md-12 no-padding product-viewer">
                                          <a class="" rel="group1" href="#"></a>
                                       </div> -->
                                    </div>
                                 </div>
                                 <!-- <div class="cart-color">
                                    <span class="head-name">Color: &nbsp;</span>
                                    <div class="color_outter_box">
                                       <span class="productIColor color_div" style="background-color:#ffffff" title="White" data-toggle="tooltip" data-placement="top" data-original-title="White">
                                       </span>
                                    </div>
                                    <span class="cart-productcolor-name">White</span>
                                 </div>-->
                                 <div class="clearfix"></div>
                                 <input type="hidden" name="cart[<?php echo $item['id']; ?>][id]" value="<?php echo $item['id']; ?>">
                                 <input type="hidden" name="cart[<?php echo $item['id']; ?>][rowid]" value="<?php echo $item['rowid']; ?>">
                                 <input type="hidden" name="cart[<?php echo $item['id']; ?>][name]" value="<?php echo $item['name']; ?>">
                                 <input type="hidden" name="cart[<?php echo $item['id']; ?>][price]" value="<?php echo $item['price']; ?>">
                                 <input type="hidden" name="cart[<?php echo $item['id']; ?>][short_description]" value="<?php echo $item['short_description']; ?>">
                                 <input type="hidden" name="cart[<?php echo $item['id']; ?>][base_price]" value="<?php echo $item['base_price']; ?>">
                                 <input type="hidden" name="cart[<?php echo $item['id']; ?>][sell_price]" value="<?php echo $item['sell_price']; ?>">
                                 <input type="hidden" name="cart[<?php echo $item['id']; ?>][product_variation_info]" value="<?php if(!empty($item['product_variation_info'])) echo $item['product_variation_info']; ?>">
                                 <input type="hidden" name="cart[<?php echo $item['id']; ?>][product_basic_info]" value="<?php echo $item['product_basic_info']; ?>">
                                 <input type="hidden" name="cart[<?php echo $item['id']; ?>][product_other_info]" value="<?php if(!empty($item['product_other_info'])) echo $item['product_other_info']; ?>">
                                 <input type="hidden" name="cart[<?php echo $item['id']; ?>][image]" value="<?php echo $item['image']; ?>">
                                 <input type="hidden" name="cart[<?php echo $item['id']; ?>][qty]" value="<?php echo $item['qty']; ?>">
                              </td>
                              <td class="cartIndex-price pull-right cart-price-box">
                                 <span class="new-price_cart font-roboto"><b>$<?php echo number_format($item['base_price'],2); ?></b></span>
                                 <span id="reg_price" class="reg_price font-roboto"><strike>&nbsp;<b>$<?php echo number_format($item['sell_price'],2); ?></b></strike></span>
                              </td>
                              <td class="quantity-updates-td">
                                 <div class="quantity-updates">
                                    <span class="quantity-updates-roster-right">
                                       <span class="select-box">
                                          1
                                          <!-- <select name="quantity" class="form-control">
                                             <option value="1" selected="selected">1</option>
                                             </select> -->
                                       </span>
                                    </span>
                                    <div class="clearfix"></div>
                                    <!-- <div class="cart-update-btn text-right roster-cart-update-btn">
                                       <input class="btn btn-blue" type="submit" name="update" value="Update">
                                       </div> -->
                                 </div>
                              </td>
                              <?php $grand_total = $grand_total + $item['subtotal']; ?>
                              <td class="cartIndex-subtotal">
                                 <b class="font-roboto">
                                 $<?php echo number_format($item['subtotal'],2) ?>	</b>
                                 <div class="clearfix"></div>
                                 <br>
                                 <a class="confirm_to_delete" data="" href="javascript:void(0)" onclick="return confirmBox('Do you want to remove this product from cart ?','<?php echo base_url('cart/remove/'.$item['rowid']); ?>')"><i class="fa fa-close"></i> Remove</a>
                              </td>
                           </tr>
                           <?php 
                              } 
                           ?>
                        </tbody>
                     </table>
                  </div>
               </form>
               <?php 
                  }else{
               ?>
               <div class="col-md-12" align="center">
                  <img style="width: 500px;" src="<?php echo base_url('assets/frontend/img/empty-cart.png'); ?>"><br>
                  <div class="shipping_billing_message">
                     <p>Your Shopping Cart lives to serve. Give it purpose — fill it with Clothing, electronics or other accessories. If you want to add the items <a href="<?php echo base_url('p'); ?>"> click here</a></p>
                     <p><span style="color: #ff0000;"><strong>Note </strong>:</span>&nbsp;The price and availability of items at <?php echo SITE_NAME; ?> are subject to change. The Cart is a temporary place to store a list of your items and reflects each item's most recent price.</p>
                  </div>
               </div>
               <?php } ?>
               <div class="clearfix"></div>
            </div>
         </div>

         <?php if (!empty($cart)){ ?>
         <div class="shopping-total-warp">
            <div class="cart-page-warp">
               <div class="theme-container">
                  <div class="row">
                     <div class="col-md-10 col-lg-10 col-sm-8 coupan-code-warp-holder">
                        <!-- <div class="col-md-8 col-lg-8 col-sm-8">
                           <div class="coupan-code-warp">
                              <div class="coupan-code-form-warp">
                                 <form action="#" method="post" accept-charset="utf-8" id="form_valid">
                                    <div class="">
                                       <div class="col-md-12">
                                          <p class="text-left"><b>Promo Code</b></p>
                                       </div>
                                       <div class="col-md-6 col-lg-6 col-sm-9 col-xs-6 form-tag">
                                          <div class="form-group formgroup-btn">
                                             <input type="text" class="form-control coupon_code" placeholder="Enter Promo Code" name="promo_code" value="" maxleng="" th="20" data-bvalidator="required,maxlength[20]" data-bvalidator-msg="">
                                          </div>
                                       </div>
                                       <div class="col-md-4 col-lg-4 col-sm-3 col-xs-6 no-padding-left form-tag-btn">
                                          <div class="form-group formgroup-btn">
                                             <input class="btn apply-code-btn btn-blue" type="submit" name="update" value="Apply">
                                          </div>
                                       </div>
                                       <label class="">
                                       </label>
                                       <div class="clearfix"></div>
                                    </div>
                                 </form>
                              </div>
                              <div class="clearfix"></div>
                              <div class="clearfix"></div>
                           </div>
                           <div class="clearfix"></div>
                           <div class="col-md-12 col-lg-12 promo-note">
                              <b style="color: #000;">PLEASE NOTE: </b> If you update your cart you will need to reapply your promo code.
                               		<p>Most orders are produced & shipped within 5-15 business days and can be delayed due to weather or product availability.</p>
                           </div>
                        </div> -->
                        <!-- 	                     <div class="col-md-6 col-lg-6 col-sm-8 no-padding text-center">
                           <div id="carousel-example-product" class="carousel slide list-promo-slide" data-ride="carousel">
                           </div>
                           </div> -->
                     </div>
                     <div class="col-md-2 col-lg-2 pull-right col-sm-4">
                        <div class="pull-right cart-total-table-warp">
                           <table class="table text-right cart-total-table table-condensed">
                              <tbody>
                                 <tr>
                                    <td class="text-right">Subtotal :</td>
                                    <td class="font-roboto">$<?php echo number_format($grand_total,2); ?></td>
                                 </tr>
                                 <tr class="grand-total-tr">
                                    <td class="text-right"><strong>TOTAL :</strong></td>
                                    <td class="font-roboto"><strong>$<?php echo number_format($grand_total,2); ?></strong>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                        <div class="clearfix"></div>
                     </div>
                  </div>
                  <div class="clearfix"></div>
               </div>
            </div>
         </div>

         <div class="theme-container">
            <!-- <div class="blue-border"></div> -->
            <div class="cart-page-warp">
               <div class="pull-right text-right btn-containt-block">
                  <a class="btn checkout-btn btn-cart" href="<?php echo base_url('order/buy_product/2'); ?>"> Checkout</a>
               </div>
               <div class="pull-right text-right btn-containt-block">
                  <div class="form-group">
                     <a href="<?php echo base_url('p'); ?>" class="btn cartshop btn-blue">Continue Shopping</a>
                  </div>
               </div>
               <div class="clearfix"></div>
            </div>
            <br>
            <div class="clearfix"></div>
         </div>
         <?php } ?>

      </div>
   </div>
</section>
<style type="text/css">
   .popoverCls{
      color: #0685b5;
   }
   .popoverCls:hover{
      color: #000;
   }
</style>
<script>
   $(document).ready(function(){
       $('[data-toggle="popover"]').popover(); 
   });
</script>