<?php
   $btc = getCryptocurrencyRate('usd-btc');
   $eth = getCryptocurrencyRate('usd-eth');
?>
<div class="theme-background">
   <section class="cart-page-warp">
      <div class="container-fluid two-col-holder">
         <!--cart page start here-->
         <div class="cart-holder">

            <div class="my-cart">
               <?php 
                  $cart = $this->cart->contents(); 
                  if (!empty($cart)){ 
                  ?>
               <!--checkout-login-warp start here-->
               <div class="">
                  <div class="my-cart-holder-wrapper clearfix">
                     <div class="block order-left-section">
                        <div class="product-list-cart">
                           <div class="cart-prodcut-deatil">
                              <div class="cart-prodcut-deatil-box">
                                 <div class="my-cart-wrapper clearfix">
                                    <div class="my-cart-items">
                                       <h4>My Bag (<?php echo count($this->cart->contents()); ?> Items)</h4>
                                    </div>
                                    <?php 
                                       if(!empty(user_id()) && !empty($this->session->userdata('shipping_address_id'))){ 
                                          $product_ShipmentAddress = getData('shipping_addresess', array('shipping_address_id',$this->session->userdata('shipping_address_id')));
                                          if(!empty($product_ShipmentAddress)){
                                    ?>
                                    <div class="my-select-address-shipping get-address-toggle-btn">
                                       <h4>
                                          <i class="icofont icofont-truck-loaded"></i>
                                          <span>Delivery to</span>
                                          <span class="name"><?php echo ucfirst($product_ShipmentAddress->first_name.' '.$product_ShipmentAddress->last_name); ?>,</span>
                                          <span class="pin-code"><?php echo $product_ShipmentAddress->zip_code; ?></span>
                                          <i class="icofont icofont-simple-right"></i>
                                       </h4>
                                    </div>
                                    <?php } } ?>
                                 </div>
                          
                                 <?php 
                                    $grand_total = 0.00; $shipping_total = 0.00; $i = 1;
                                    foreach ($cart as $cartRowId => $item){
                                       $product_infoItem = json_decode($item['product_info']);
                                     //  p($product_infoItem);
                                       $Image = $item['image'];
                                       $Image = explode(',', $Image);
                                    ?>
                                 <div class="buying-from">
                                    <span>Buying from</span>
                                    <?php 
                                       $sellerInfo = getData('users', array('user_id',$product_infoItem->seller_id));
                                    ?>
                                    <span class="seller-name"><?php if($sellerInfo->user_name) echo ucfirst($sellerInfo->user_name); else echo "Anonymous Seller"; ?></span>
                                 </div>
                                 <div class="cart-product-tile">
                                    <div class="cart-product">
                                       <div class="no-padding-left img-view-box">
                                          <a href="<?php echo base_url('pd/'.$item['slug'].'/'.base64_encode($item['id'])); ?>">
                                          <img src="<?php echo base_url(); ?>assets/uploads/seller/products/thumbnail/<?php echo $Image[0]; ?>">
                                          </a>
                                       </div>
                                       <div class="details-view-box">
                                          <h4><a href="<?php echo base_url('pd/'.$item['slug'].'/'.base64_encode($item['id'])); ?>"><?php echo ucfirst($item['name']); ?></a></h4>
                                          <div class="product-property">
                                             <?php
                                                 $tempMore = ""; 
                                                 $product_variation_info = (isset($item['product_variation_info'])) ? $item['product_variation_info'] : array();
                                                 $product_basic_info = (isset($item['product_basic_info'])) ? $item['product_basic_info'] : array();
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
                                          <div class="product-quantity">
                                             <label>Quantity:</label>
                                             <span>1</span>
                                          </div>

                                          <?php 
                                             $shipping_address_id = $this->session->userdata("shipping_address_id");
                                             if(!empty($shipping_address_id) && isset($item['shipping_method']) && !empty($item['shipping_method'])){ 
                                                if($item['shipping_method']==1 || $item['shipping_method']==2){
                                          ?>
                                            <div class="shipping-methods clearfix">
                                               <?php 
                                                  $applicableMethods = getShippingUsingIP(base64_encode($item['id']), $shipping_address_id, '');
                                                   if(!empty($applicableMethods['data']) && $applicableMethods['data']!=0.00 && $applicableMethods['data']!=0){
                                                     foreach ($applicableMethods['data'] as $key => $value) {
                                                        $shipmentTitle = str_replace("_"," ",$key);
                                                        $row = getRow('shipping_option',array('title'=> $shipmentTitle));


                                               ?>
                                                <div class="shipping-methods-btn">
                                                   <div class="radio-input">
                                                     <input rowID="<?php echo base64_encode($cartRowId); ?>" pID="<?php echo base64_encode($item['id']); ?>" id="<?php echo $item['id'].'_'.$key; ?>" sm="<?php echo $key; ?>" class="chooseShipmentMethod" type="radio" name="shipment_rate_type<?php echo $item['id']; ?>" value="1" <?php if($item['shipping_method']==$row->shipping_option_id) echo 'checked="checked"'; ?>>
                                                     <label for="<?php echo $item['id'].'_'.$key; ?>"><?php echo str_replace("_"," ",$key); ?></label>
                                                   </div>
                                                </div>
                                              <?php } } ?>
                                            </div>
                                          <?php } } ?>

                                          <?php
                                          if(!empty(user_id())){
                                             if(isset($item['shipping_charges']) && !empty($item['shipping_charges'])){
                                                $shipmentOptinotitle = "";
                                                if(isset($item['shipping_method']) && !empty($item['shipping_method'])){
                                                   $shipping_option = getRow('shipping_option',array('shipping_option_id'=>$item['shipping_method']),array('title'));
                                                   if(!empty($shipping_option)){
                                                      $shipmentOptinotitle = $shipping_option->title;
                                                   }
                                                   
                                                }
                                          ?>
                                             <div class="delivery-applicable">
                                                <span><?php if($product_infoItem->shipment_rate_type==0){ echo "Delivery not applicable"; }else if($product_infoItem->shipment_rate_type==1){ echo "Free shipping"; }else{ echo 'Will charge <span class="dollar-icon-bold">$</span><span class="number-icon-bold">'.number_format($item['shipping_charges'], 2).'</span> for '.$shipmentOptinotitle.' and delivered within <span class="number-icon-bold">'.$item['min_day'].'-'.$item['max_day'].'</span> business days.'; } ?></span>
                                             </div>
                                          <?php 
                                             }else{ 
                                          ?>
                                             <div class="delivery-not-applicable">
                                                <span>Not available for delivery at your location</span>
                                             </div>
                                          <?php  } }
                                          ?>

                                       </div>

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
                                       <div class="price-view-box">
                                          <div class="price-label">
                                             <span class="dollar-icon-bold">$</span><span class="number-icon-bold"><?php echo number_format($item['base_price'],2); ?></span>
                                          </div>
                                          <div class="discount-price-label">
                                             <span class="percantage">-<?php echo round((($item['sell_price']-$item['base_price'])/$item['sell_price'])*100, 2) ?>%</span>
                                             <span class="dollar-icon-normal">$</span><del class="number-icon-normal"><?php echo number_format($item['sell_price'],2); ?></del>
                                          </div>

                                          <?php if($product_infoItem->accepted_returnpolicy==1){ ?>
                                          <div class="policy-wrapper">
                                             <div class="policy">
                                                <a class="link-text" style="text-decoration: underline; font-size: 12px;" href="javascript:void(0)" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="<?php echo $product_infoItem->returnpolicy_description; ?>">View Return & Replacement Policy</a>
                                             </div>
                                          </div>
                                          <?php } ?>

                                          <?php 
                                             $grand_total = $grand_total + $item['subtotal'];
                                             if(isset($item['shipping_charges']) && !empty($item['shipping_charges'])){
                                                $shipping_total = $shipping_total + $item['shipping_charges'];
                                             }
                                          ?>
                                          <div class="remove-save-product-wrapper">
                                             <?php if(!empty(user_id())){ ?>
                                                <div class="save-link"><a href="<?php echo base_url('cart/save_for_later/'.$item['rowid'].'/'.base64_encode($item['id'])); ?>"><i class="icofont icofont-book-mark"></i> Save for Later</a></div>
                                             <?php } ?>
                                             <div class="remove-link"><a href="javascript:void(0)" onclick="return confirmBox('Do you want to remove this product from bag ?','<?php echo base_url('cart/remove/'.$item['rowid']); ?>')"><i class="icofont icofont-trash"></i> Remove</a></div>
                                          </div>
                                       </div>
                                       <div class="clearfix"></div>
                                    </div>
                                    <div class="product-not-applicable pItem<?php echo $item['id']; ?>" style="display: none;">
                                       <p><i class="icofont icofont-info-circle"></i> The Delivery of the product haven't applicable by the seller. If you want to remove it, 
                                          <a class="removeProduct" href="javascript:void(0)" onclick="return confirmBox('Do you want to remove this product from bag ?','<?php echo base_url('cart/remove/'.$item['rowid']); ?>')">click here</a>
                                       </p>
                                    </div>
                                 </div>
                                 <?php } ?>
                              </div>
                              <div class="clearfix"></div>
                           </div>
                        </div>
                     </div>
                     <?php if (!empty($cart)){ ?>
                     <div class="address-book-row right-cart-price-total">
                        <div class="payment-cart-items">
                           <h4>Payment Summary</h4>
                        </div>
                        <div class="cart-total-wrapper">
                           <div class="cart-total-block">
                              <div class="left-side">Subtotal</div>
                              <div class="right-side"><span class="dollar-icon-normal">$</span><span class="number-icon-normal"><?php echo number_format($grand_total,2); ?></span></div>
                           </div>
                           <div class="cart-total-block">
                              <div class="left-side">Shipping Fee</div>
                              <div class="right-side"><span class="dollar-icon-normal">$</span><span class="number-icon-normal"><?php echo number_format($shipping_total,2); ?></span></div>
                           </div>
                           <?php 
                              $orderTotal = $grand_total + $shipping_total;
                           ?>
                           <div class="cart-total-block cart-total-block-footer">
                              <div class="left-side">Order Total</div>
                              <div class="right-side"><span class="dollar-icon-bold">$</span><span class="number-icon-bold"><?php echo number_format($orderTotal, 2); ?></span></div>
                           </div>

                           <input type="hidden" name="2_amt" value="<?php echo base64_encode(number_format($btc*$orderTotal,8)); ?>">
                           <input type="hidden" name="1_amt" value="<?php echo base64_encode(number_format($eth*$orderTotal,8)); ?>">

                           <div class="cart-total-block cart-total-block-footer">
                             <div class="left-side">Payment Currency</div>
                             <div class="right-side">
                               <div class="title-label-right">
                                 <div class="clearfix">
                                    <div class="currency-converter">
                                       <div class="bitcoin" style="padding-bottom: 10px;">
                                          <span>
                                            <div class="radio-input">
                                               <input id="in_btc" class="chooseShipmentMethod1" type="radio" name="chooseCurrency" value="2" checked>
                                               <label for="in_btc"><i class="cf cf-btc"></i> <?php echo number_format($btc*$orderTotal,8); ?> BTC</label>
                                            </div>
                                          </span>
                                       </div>
                                       <div class="ethereum">
                                          <span>
                                            <div class="radio-input">
                                               <input id="in_eth" class="chooseShipmentMethod1" type="radio" name="chooseCurrency" value="1">
                                               <label for="in_eth"><i class="cf cf-eth"></i> <?php echo number_format($eth*$orderTotal,8); ?> ETH</label>
                                            </div>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                               </div>
                             </div>
                           </div>

                           <div class="payment-button-wrapper">
                              <?php 
                                 if(empty(user_id())){ 
                              ?>
                              <a href="javascript:void(0)" class="btn btn-red loginModalOpen">Login to proceed</a>
                              <?php 
                                 }else if(!empty(user_id()) && empty($this->session->userdata('shipping_address_id'))){ 
                              ?>
                              <a href="javascript:void(0)" class="btn btn-red get-address-toggle-btn">Checkout</a>
                              <?php 
                                 }else{
                                 $product_ShipmentAddress = getData('shipping_addresess', array('shipping_address_id',$this->session->userdata('shipping_address_id')));
                                    if(!empty($product_ShipmentAddress)){ 
                              ?>

                                 <a href="javascript:void(0)" class="btn btn-red continuePayment">Pay <span class="dollar-icon-bold">$</span><span class="number-icon-bold"><?php echo number_format($orderTotal, 2); ?></span></a>

                              <?php }else{ ?>

                                 <a href="javascript:void(0)" class="btn btn-red get-address-toggle-btn">Checkout</a>
                              
                              <?php } } ?>
                              
                           </div>
                        </div>
                     </div>
                     <?php } ?>
                     <?php if(!empty(user_id())){ ?>
                     <div class="right-address-wrapper">
                      <div class="get-address-toggle-btn"></div>
                        <div class="right-address-toggle-section addressBox">
                           <span class="close-toggle-btn get-address-toggle-btn">
                           <i class="icofont icofont-close"></i>
                           </span>
                           <div class="main-loader" style='display: none;'>
                               <div class="loader">
                                 <svg class="circular-loader" viewBox="25 25 50 50">
                                   <circle class="loader-path" cx="50" cy="50" r="20" fill="none" stroke="#f45b69" stroke-width="2.5" />
                                 </svg>
                               </div>
                           </div>
                           <?php  if(!empty($shipping_addresess)){ ?>
                           <h4><i class="icofont icofont-location-pin"></i> Select a Delivery Address</h4>
                           <div class="cart-address-list-wrapper">
                           <?php 
                              foreach ($shipping_addresess as $row) {
                           
                                 $country = '';
                                 $state = '';
                                 $city = '';
                           
                                 if($row->country) $country = getData('countries',array('id',$row->country))->name;
                                 if($row->state)   $state   = getData('states',array('id',$row->state))->name;
                                 if($row->city)    $city    = getData('cities',array('id',$row->city))->name;
                           ?>
                           
                           <div class="address-field-section">
                              <div class="address-block-field clearfix">
                                 <div class="address-book-entry">
                                    <ul class="display-address">
                                       <li class="name"><?php echo ucwords($row->first_name.' '.$row->last_name); ?></li>
                                       <li class="display-address-link"><?php echo $row->address; ?></li>
                                       <li class="display-address-city-state">
                                          <?php 
                                             if(!empty($city)){ 
                                                echo $city.', '; 
                                             }
                                             if(!empty($state)){ 
                                                echo $state.', '; 
                                             }
                                             echo $row->zip_code; 
                                             ?>
                                       </li>
                                       <li class="display-address-country"><?php if(!empty($country)) echo $country; ?></li>
                                       <li class="display-number-link"><label>Mobile:</label><?php echo '+'.$row->country_code.' '.$row->phone_no; ?></li>
                                    </ul>
                                    <div class="address-save-delete-wrap">
                                       <a class="editAddress" aid="<?php echo base64_encode($row->shipping_address_id); ?>" href="javascript:void(0)"><i class="icofont icofont-ui-edit"></i> Edit</a>
                                       <a class="delete-address" href="javascript:void(0)" onclick="return confirmBox('Do you want to delete this product from bag ?','<?php echo base_url().'backend/common/delete/shipping_addresess/shipping_address_id/'.$row->shipping_address_id?>')"><i class="icofont icofont-ui-delete"></i> Delete</a>
                                    </div>
                                 </div>
                                 <div class="ship-to-this-address-wrapper">
                                    <div class="ship-to-this-address">
                                       <?php 
                                          if($this->session->userdata('shipping_address_id')!=$row->shipping_address_id){
                                       ?>
                                          <a class="link btn-default-white btn-lg selectAddress" aId="<?php echo base64_encode($row->shipping_address_id); ?>" href="javascript:void(0)">Select</a>
                                       <?php }else{ ?>
                                          <a class="link btn-red btn-lg active" href="javascript:void(0)">Selected</a>
                                       <?php } ?>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <?php } ?>
                           </div>
                           <?php }else{ ?>
                           <h4><i class="icofont icofont-location-pin"></i> No shipping addresess found.</h4>
                           <?php } ?>
                           <div class="add-new-address-btn">
                              <a href="javascript:void(0)" class="btn btn-red btn-block addAddress">Add New Address</a>
                           </div>
                        </div>
                        <div class="right-address-toggle-section addressForm" style="display: none;">
                           <span class="close-toggle-btn get-address-toggle-btn">
                           <i class="icofont icofont-close"></i>
                           </span>
                           <h4 class="billibgTitle"></h4>
                           <div class="address-form-wrap-scrol">
                             <form method="post" id="form_valid_billing" data-bvalidator-validate>
                                <div class="main-loader" style='display: none;'/>
                                   <div class="loader">
                                      <svg class="circular-loader" viewBox="25 25 50 50" >
                                        <circle class="loader-path" cx="50" cy="50" r="20" fill="none" stroke="#f45b69" stroke-width="2.5" />
                                      </svg>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                      <label class="control-label">First Name</label>
                                      <input type="text" id="first_name" name="first_name" value="" class="form-control" placeholder="John" data-bvalidator="required" data-bvalidator-msg="Please enter your first name">
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                      <label class="control-label">Last Name</label>
                                      <input type="text" id="last_name" name="last_name" value="" class="form-control" placeholder="Doe" data-bvalidator="required" data-bvalidator-msg="Please enter your last name">
                                   </div>
                                </div>
                                <div class="col-md-12">
                                   <div class="form-group">
                                      <label class="control-label">Email Id</label>
                                      <input type="text" id="email_id" name="email_id" value="" class="form-control" placeholder="John@example.com" data-bvalidator="email,required">
                                   </div>
                                </div>
                                <div class="col-md-12">
                                   <div class="form-group">
                                      <label class="control-label">Mobile No.</label>
                                      <div class="mobile-number-wrapper">
                                         <div class="mobile-number-left">
                                            <select class="form-control country_code" name="country_code" id="country_codeBilling">
                                               <?php 
                                                  if(!empty($phnCode)){ 
                                                  foreach ($phnCode as $row){
                                                  ?>
                                               <option <?php if($row->phonecode=='91') echo "selected"; ?> value="<?php echo $row->phonecode; ?>"><?php echo $row->sortname.' +'.$row->phonecode; ?></option>
                                               <?php 
                                                  } }
                                               ?>
                                            </select>
                                         </div>
                                         <div class="mobile-number-right">                        
                                            <input type="text" class="form-control" id="mobileBilling" value="<?php echo set_value('mobile'); ?>" name="mobile" placeholder="xxxxxxxxxx" data-bvalidator="maxlen[13],minlen[9],number,required" data-bvalidator-msg="Please enter a valid Mobile No.">
                                         </div>
                                      </div>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                      <label class="control-label">Country</label>
                                      <select name="country" class="form-control" id="country" data-bvalidator="required" data-bvalidator-msg="Please select the country">
                                         <option value="">--Select Country--</option>
                                         <?php 
                                            if(!empty($phnCode)){ 
                                            foreach ($phnCode as $row){
                                            ?>
                                         <option <?php if($row->phonecode=='91') echo "selected"; ?> value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                         <?php 
                                            } }
                                            ?>
                                      </select>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                      <label class="control-label">State</label>
                                      <?php
                                         $getProvinceData = getDataResult('states', array('country_id'=>101));
                                         ?>
                                      <select name="state" class="form-control" id="state" data-bvalidator="required" data-bvalidator-msg="Please select the state">
                                         <option value="">--Select State--</option>
                                         <?php if(!empty($getProvinceData)){ foreach ($getProvinceData as $row) { ?>
                                         <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                         <?php } } ?>
                                      </select>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                      <label class="control-label">City</label>
                                      <select name="city" class="form-control" id="city" data-bvalidator="required" data-bvalidator-msg="Please select the city">
                                         <option value="">--Select City--</option>
                                      </select>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                   <div class="form-group">
                                      <label class="control-label">Postal Code</label>
                                      <input type="text" id="zip" name="zip_code" value="" class="form-control" data-bvalidator="maxlen[8],minlen[4],required" placeholder="452101" data-bvalidator-msg="Please enter the valid postal code">
                                      <input type="hidden" id="shipping_address_id" name="shipping_address_id" value="">
                                   </div>
                                </div>
                                <div class="col-md-12">
                                   <div class="form-group">
                                      <label class="control-label">Address</label>
                                      <textarea class="form-control" name="address" id="address" placeholder="Address" rows="3" cols="6" data-bvalidator="required" data-bvalidator-msg="Please enter the address"></textarea>
                                   </div>
                                </div>
                                <div class="text-center">
                                   <button type="submit" class="btn btn-red submitBillingDetails">Submit</button>
                                   <button type="button" class="btn btn-default-white backBillingDetails">Back</button>
                                   <br><br><br>
                                </div>
                             </form>
                           </div>
                        </div>
                     </div>
                     <?php } ?>
                  </div>
               </div>
               <?php 
                  }else{
                  ?>
               <div class="col-md-10 center-block" align="center">
                  <br><br><br><br><br>
                  <div class="noresult-block">
                     <div class="noresult-img">
                        <img src="<?php echo base_url('assets/frontend/img/empty-icon/shopping-cart-add-button.svg'); ?>">
                     </div>
                     <div class="noresult-content">
                        <h4>Your Shopping Bag is empty</h4>
                        <p>If you want to add items <a href="<?php echo base_url('p'); ?>">click here</a></p>
                     </div>
                  </div>
               </div>
               <?php } ?>
            </div>
            <div class="clearfix"></div>
         </div>
      </div>
   </section>
</div>
<!-- Modal -->
<div class="modal fade" id="signInModal" role="dialog">
   <div class="modal-dialog account-modal">
      <!-- Modal content-->
      <div class="modal-content comman-modal">
         <div class="modal-header comman-header-modal">
            <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><img src="<?php echo SELLER_THEME_URL; ?>/img/Icon_Basic_Close.svg" width="18"></span>
            </button>
            <h4 class="modal-title text-center popUpTitle"></h4> 
         </div>
         <div class="modal-body comman-body-modal clearfix">
            <div class="">
               <div class="row signInNow">
                  <div class="col-sm-12">
                     <div class="login-wrapper login-modal">
                        <div class="main-loader" style='display: none;'>
                           <div class="loader">
                              <svg class="circular-loader" viewBox="25 25 50 50" >
                                <circle class="loader-path" cx="50" cy="50" r="20" fill="none" stroke="#f45b69" stroke-width="2.5" />
                              </svg>
                           </div>
                        </div>
                        <form id="loginform" method="POST" data-bvalidator-validate>
                           <div class="form-group">
                              <label for="Email">Email Address</label>
                              <input type="text" class="form-control" id="loginEmail" name="email" placeholder="john@example.com" data-bvalidator="required,email" data-bvalidator-msg="Please enter a valid email address">
                              <?php echo form_error('email'); ?>
                           </div>
                           <div class="form-group">
                              <label for="Password">Password</label>
                              <input type="password" class="form-control" id="loginPassword" name="password" placeholder="john@123" data-bvalidator="required" data-bvalidator-msg="Please enter a password">
                              <?php echo form_error('password'); ?>
                           </div>
                           <div class="form-group">
                              <input type="submit" class="btn btn-cart btn-block signIn-Btn" name="sign_in" value="Submit">
                           </div>
                           <div class="login-extras clearfix">
                              <div class="text-center">
                                 <div class="forgot-block">
                                    <a class="forgot-link" href="<?php echo base_url('page/forgotpassword'); ?>">Forgot Password</a>
                                 </div>
                              </div>
                           </div>
                           <div class="divider-with-text">
                              <span>New to <?php echo ucwords(SITE_NAME); ?> ?</span>
                           </div>
                           <div class="create-account-link">
                              <a href="javascript:void(0)" class="btn btn-default btn-block signUpNowBtn">Create your account</a>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
               <div class="row signUpNow" style="display: none;">
                  <div class="col-sm-12">
                     <div class="login-wrapper login-modal">
                        <div class="main-loader" style='display: none;'>
                           <div class="loader">
                              <svg class="circular-loader" viewBox="25 25 50 50" >
                                <circle class="loader-path" cx="50" cy="50" r="20" fill="none" stroke="#f45b69" stroke-width="2.5" />
                              </svg>
                           </div>
                        </div>
                        <form id="signupform" method="POST" data-bvalidator-validate>
                           <div class="form-group">
                              <label for="name">Your Name</label>
                              <input type="text" class="form-control" id="name" name="name" value="<?php echo set_value('name'); ?>" placeholder="Ex : John Doe" data-bvalidator="required" data-bvalidator-msg="Please enter a full name">
                              <?php echo form_error('name'); ?>
                           </div>
                           <div class="form-group">
                              <label for="number">Mobile number</label>
                              <div class="mobile-number-wrapper">
                                 <div class="mobile-number-left">
                                    <select class="form-control" name="country_code" id="registrationCountryCode">
                                       <?php 
                                          if(!empty($phnCode)){ 
                                          foreach ($phnCode as $row){
                                          ?>
                                       <option <?php if($row->phonecode=='91') echo "selected"; ?> value="<?php echo $row->phonecode; ?>"><?php echo $row->sortname.' +'.$row->phonecode; ?></option>
                                       <?php 
                                          } }
                                          ?>
                                    </select>
                                 </div>
                                 <div class="mobile-number-right">                        
                                    <input type="text" class="form-control" id="mobile" value="<?php echo set_value('mobile'); ?>" name="mobile" placeholder="xxxxxxxxxx" data-bvalidator="maxlen[13],minlen[9],number,required" data-bvalidator-msg="Please enter a valid Mobile No.">
                                 </div>
                              </div>
                              <?php echo form_error('mobile'); ?>
                           </div>
                           <div class="form-group">
                              <label for="email">Email Address</label>
                              <input type="email" class="form-control" id="registrationEmail" value="<?php echo set_value('email'); ?>" name="email" placeholder="john@example.com" data-bvalidator="required,email" data-bvalidator-msg="Please enter a valid email address">
                              <?php echo form_error('email'); ?>
                           </div>
                           <div class="form-group">
                              <label for="Password">Password</label>
                              <input type="Password" class="form-control" id="registrationPassword" value="<?php echo set_value('registrationPassword'); ?>" name="registrationPassword" placeholder="john@123" data-bvalidator="minlen[6],required" data-bvalidator-msg="Please enter the password with minimum 6 characters">
                              <?php echo form_error('registrationPassword'); ?>
                           </div>
                           <div class="form-group">
                              <label for="Password">Confirm Password</label>
                              <input type="Password" class="form-control" id="registrationCPassword" value="<?php echo set_value('registrationCPassword'); ?>" name="registrationCPassword" placeholder="john@123" data-bvalidator="equal[registrationPassword],required" data-bvalidator-msg="Please enter the same password again">
                              <?php echo form_error('registrationCPassword'); ?>
                           </div>
                           <div class="form-group">
                              <input type="submit" class="btn btn-cart btn-block signUp-btn" name="sign_up" value="Continue">
                           </div>
                           <div class="already-account-link">
                              <p>Already have an account? <a href="javascript:void(0)" class="sign-in-link signInNowBtn">Sign in <i class="icofont icofont-caret-right"></i></a></p>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
   $(document).ready(function(){
      $("#signInModal").on("hide.bs.modal", function () {
         $('#loginform')[0].reset();
         $('#signupform')[0].reset();
      });
      $('[data-toggle="popover"]').popover(); 
   });

</script>
<script>
   SITE_URL = "<?php echo base_url(); ?>";
   
   /*Open Signin bootstrap modal when user is not login here*/
   $('.loginModalOpen').on('click', function() {
      $('#loginform')[0].reset();
      $('#signupform')[0].reset();
      $(".alert-danger").hide();
      $(".alert-success").hide();
      $(".signUpNow").hide();
      $(".signInNow").show();
      $(".popUpTitle").html("Sign <b>In</b>");
      $('#signInModal').modal('show'); 
   });
   
   /*Hide Signup form and show Signin showing in modal*/
   $(".signInNowBtn").click(function(){
       $(".popUpTitle").html("Sign <b>In</b>");
       $(".signUpNow").hide();
       $(".signInNow").show();
   });
   
   /*If We are click on Login button then below code will be executed*/
   $('#loginform').submit(function() {
      $('#loginform').bValidator();
      if($('#loginform').data('bValidator').isValid()){
        
         $(".signIn-Btn").attr("disabled", true);
         var email = $("#loginEmail").val();
         var password = $("#loginPassword").val();
         var type = 1;
   
         $.ajax({
            url: SITE_URL + 'order/authenticate',
            type: 'POST',
            data: {
                email: email,
                password: password,
                type: type
            },
            beforeSend: function()
            {
              $('.main-loader').show();
            },
            cache: false,
            success: function(result) {
                var data = JSON.parse(result);
                if(data.status=='failed'){
                    $(".signIn-Btn").attr("disabled", false);  
                    $('.main-loader').hide();
                    if(data.msg!=''){
                       errorMsg(data.msg);
                    }
                }else{
                    if(data.msg!=''){
                       setTimeout(function(){
                            location.reload();
                       }, 2000);
                    }
                }
            },
         });
      }
     
      return false;
      
   });
   
   /*Hide Signin form and show Signup showing in modal*/
   $(".signUpNowBtn").click(function(){
       $(".popUpTitle").html("Sign <b>Up</b>");
       $(".signInNow").hide();
       $(".signUpNow").show();
   });
   
   /*If We are click on Registration button then below code will be executed*/
   $('#signupform').submit(function() {
      $('#signupform').bValidator();
      if($('#signupform').data('bValidator').isValid()){
         
         $(".signUp-Btn").attr("disabled", true);
         var name = $("input[name=name]").val();
         var country_code = $("#registrationCountryCode").val();
         var mobile = $("input[name=mobile]").val();
         var email = $("#registrationEmail").val();
         var password = $("#registrationPassword").val();
         var cPassword = $("#registrationCPassword").val();
         var type = 2;
   
         $.ajax({
            url: SITE_URL + 'order/authenticate',
            type: 'POST',
            data: {
                name: name,
                country_code: country_code,
                mobile: mobile,
                email: email,
                password: password,
                confirm_password: cPassword,
                type: type
            },
            beforeSend: function()
            {
              $('.main-loader').show();
            },
            cache: false,
            success: function(result) {
                var data = JSON.parse(result);
                if(data.status=='failed'){
                    $(".signUp-Btn").attr("disabled", false);  
                    $('.main-loader').hide();
                    if(data.msg!=''){
                       errorMsg(data.msg);
                    }
                }else{
                    if(data.msg!=''){
                       successMsg(data.msg);
                       setTimeout(function(){
                             location.reload();
                       }, 2000);
                    }
                }
            },
         });
      }
     
      return false;

   });
   
   $('.addAddress').on('click', function() {
      $('#form_valid_billing')[0].reset();
      $(".billibgTitle").text("Add New Billing Address");
      $(".submitBillingDetails").text("Submit");
      $("#shipping_address_id").val('');
      $('.addressBox').hide();
      $('.addressForm').show();
   });
   
   $('.backBillingDetails').on('click', function() {
      $('#form_valid_billing')[0].reset();
      $("#shipping_address_id").val('');
      $('.addressForm').hide();
      $('.addressBox').show();
   });
   
   $('.editAddress').on('click', function() {
       $(".billibgTitle").text("Update Billing Address");
       $(".submitBillingDetails").text("Update");
       var aId = $(this).attr("aId");
   
       if(aId == '') {
         $("#shipping_address_id").val('');
         $('.addressForm').show();
       }else {
           $.ajax({
               url: SITE_URL + 'order/getShippingAddressData',
               type: 'POST',
               data: {
                   aId: aId
               },
               cache: false,
               success: function(result) {
                   var data = JSON.parse(result);
                   if(data.status=='success'){
   
                     $('#first_name').val(data.data.first_name);
                     $('#last_name').val(data.data.last_name);
                     $('#email_id').val(data.data.email_id);
                     $('#country_codeBilling').val(data.data.country_code);
                     $('#country').val(data.data.country);
                     $('#state').html(data.stateData);
                     $('#city').html(data.cityData);
                     $('#mobileBilling').val(data.data.phone_no);
                     $('#address').val(data.data.address);
                     $('#zip').val(data.data.zip_code);
   
                     $("#shipping_address_id").val(aId);
                     $('.addressForm').show();
                   }
               },
           });
       } 
   });
   
   /*get Country Data according to their Country Code*/
   $('#form_valid_billing').submit(function() {
      $('#form_valid_billing').bValidator();
      // check if form is valid
      if($('#form_valid_billing').data('bValidator').isValid()){
        
         $("button").attr("disabled", true);
         var shipping_address_id = $("input[name=shipping_address_id]").val();
         var first_name = $("input[name=first_name]").val();
         var last_name = $("input[name=last_name]").val();
         var email_id = $("input[name=email_id]").val();
         var country_code = $('#country_codeBilling').val();
         var country = $('#country').val();
         var state = $('#state').val();
         var city = $('#city').val();
         var zip_code = $("input[name=zip_code]").val();
         var address = $("textarea[name=address]").val();
         var mobile = $("input[name=mobile]").val();
   
         $.ajax({
            url: SITE_URL + 'order/insertBillingdata',
            type: 'POST',
            data: {
                shipping_address_id: shipping_address_id,
                first_name: first_name,
                last_name: last_name,
                email_id: email_id,
                country: country,
                country_code: country_code,
                state: state,
                city: city,
                zip_code: zip_code,
                address: address,
                phone_no: mobile,
                status: 1
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
                    var cur_shipment_address   = "<?php echo $this->session->userdata('shipping_address_id'); ?>";
                    shipping_address_id_hidden = window.atob(shipping_address_id);

                    /*check session address and select address is matched or not*/
                    if(cur_shipment_address!='' && (cur_shipment_address==shipping_address_id_hidden)){

                        $.ajax({
                           url: SITE_URL + 'cart/productAndAmountInfo',
                           type: 'POST',
                           data: {
                               shipping_addresessId: shipping_address_id
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
                               }else{
                                   setTimeout(function(){
                                       location.reload();
                                   }, 2000);
                               }
                           },
                       });
                    }else{
                       setTimeout(function(){
                           location.reload();
                       }, 2000);
                    }
                }
            },
         });
      }
      return false;
   });
   

   $('.selectAddress').on('click', function() {
       var shipping_addresessId = $(this).attr("aId");
       if(shipping_addresessId == '') {
         errorMsg("Something went wrong! Please try again");
       }else{
           $.ajax({
               url: SITE_URL + 'cart/productAndAmountInfo',
               type: 'POST',
               data: {
                   shipping_addresessId: shipping_addresessId
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
                   }else{
                       location.reload();
                   }
               },
           });
       } 
   });

   $('.chooseShipmentMethod').on('click', function() {
       var ShipmentMethod = $(this).attr("sm");
       var pID = $(this).attr("pID");
       var rowID = $(this).attr("rowID");

       if(ShipmentMethod == '' || pID=='' || rowID=='') {
         errorMsg("Something went wrong! Please try again");
       }else {
           $.ajax({
               url: SITE_URL + 'cart/chooseShipmentMethod',
               type: 'POST',
               data: {
                   ShipmentMethod: ShipmentMethod,
                   pID: pID,
                   rowID: rowID
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
                       setTimeout(function(){
                             location.reload();
                       }, 2000);
                   }else{
                       location.reload();
                   }
               },
           });
       } 
   });

   $('.get-address-toggle-btn').click(function(){
      $('.addressForm').hide();
      $('.addressBox').show();
      $('.right-address-wrapper').toggleClass('right-toggle-move');
      $('body').toggleClass('body-off-scroll-right');
   });

   var is_error = false;
   $('.continuePayment').on('click', function() {
      var chooseCurrency = $('input[name=chooseCurrency]:checked').val();
      if(chooseCurrency){

        var totalAmtInEth = $('input[name=1_amt]').val();
        var totalAmtInBtc = $('input[name=2_amt]').val();

        var productData = <?php echo json_encode($this->cart->contents()); ?>;

        $.each(productData, function(i){
           product_info = $.parseJSON(productData[i].product_info);
           if(productData[i].shipping_method==undefined || product_info.shipment_rate_type=='' || product_info.shipment_rate_type==0.00){
              product_variation_id = product_info.product_variation_id;
              $(".pItem"+product_info.product_variation_id).show();
              is_error = true;
           }
        });

        if (is_error) {
           $('html, body').animate({scrollTop: $(".pItem"+product_variation_id).offset().top -500 }, 'slow');
           return false;
        }

        UrlArr = [<?php echo $this->session->userdata('shipping_address_id'); ?>,chooseCurrency,totalAmtInEth,totalAmtInBtc];
        var tempUrlArr = encodeURIComponent(JSON.stringify(UrlArr));
        $(location).attr('href', SITE_URL+'cart/directPayment/'+tempUrlArr);
        
      }else{

      }
   });

</script>
