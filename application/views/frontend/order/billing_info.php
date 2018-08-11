<section class="cart-page-warp">
   <div class="container-fluid two-col-holder">
      <!-- <div class="address-book-row right-cart-price-total">
         <?php 
            if(!empty($shipping_addresess)){
            ?>
         <div class="shipping_billing_address">
            <h3>Select a delivery address</h3>
            <p>Is the address you'd like to use displayed below? If so, click the corresponding "Deliver to this address" button. Or you can <a href="javascript:void(0)" class="addAddress"> Enter a new delivery address.</a></p>
         </div>
         <?php } ?>
         <?php 
            if(!empty($shipping_addresess)){ foreach ($shipping_addresess as $row) { 
               $country = getData('countries',array('id',$row->country))->name;
               $state = getData('states',array('id',$row->state))->name;
               $city = getData('cities',array('id',$row->city))->name;
            ?>
         <div class="col-md-12 address-book-col no-padding-left">
            <div class="address-book-entry">
               <ul class="display-address">
                  <li class="name"><?php echo ucwords($row->first_name.' '.$row->last_name); ?></li>
                  <li class="display-number-link"><?php echo '+'.$row->country_code.' '.$row->phone_no; ?></li>
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
               </ul>
               <div class="clearfix"></div>
               <div class="ship-to-this-address-wrapper">
                  <div class="ship-to-this-address btn-red btn-lg">
                     <a class="link" href="<?php echo base_url('order/payment/'.base64_encode($row->shipping_address_id)); ?>">Deliver to this address</a>
                  </div>
                  <div class="address-save-delete-wrap">
                     <a class="btn btn-default editAddress" aId="<?php echo base64_encode($row->shipping_address_id); ?>" href="javascript:void(0)">Edit</a>
                     <a class="btn btn-default" href="javascript:void(0)" onclick="return confirmBox('Do you want to delete it ?','<?php echo base_url().'backend/common/delete/shipping_addresess/shipping_address_id/'.$row->shipping_address_id?>')">Delete</a>
                  </div>
               </div>
            </div>
         </div>
         <?php } }else{ ?>
         <div class="no-billing-block">
            <div class="no-billing-inner-block">
               <div class="no-billing-result-img">
                  <img src="http://205.134.251.196/~examin8/CI/Qipost/assets/backend/admin/img/location-marker.png" width="60">
               </div>
               <div class="no-billing-text">
                  <p>No Delivery Address Available Here.</p>
                  <h4><b>If you want to add <a href="javascript:void(0)" class="link-text addAddress">click here</a></b></h4>
               </div>
            </div>
         </div>
         <?php } ?>
         </div> -->
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
                                 <div class="my-select-address-shipping get-address-toggle-btn">
                                    <h4>
                                       <i class="icofont icofont-truck-loaded"></i>
                                       <span>Delivery to</span>
                                       <span class="name">Amitesh patidar,</span>
                                       <span class="pin-code">452001</span>
                                       <i class="icofont icofont-simple-right"></i>
                                    </h4>
                                 </div>
                              </div>
                              <?php 
                                 $grand_total = 0.00; $i = 1;
                                 foreach ($cart as $item){
                                    $Image = $item['image'];
                                    $Image = explode(',', $Image);
                                 ?>
                              <div class="buying-from">
                                 <span>Buying from</span>
                                 <span class="seller-name">Brand Studio Lifestyle Private Limited</span>
                              </div>
                              <div class="cart-product">
                                 <div class="no-padding-left img-view-box">
                                    <a href="<?php echo base_url('pd/'.$item['slug'].'/'.base64_encode($item['id'])); ?>">
                                    <img src="<?php echo base_url(); ?>assets/uploads/seller/products/thumbnail/<?php echo $Image[0]; ?>">
                                    </a>
                                 </div>
                                 <div class="details-view-box">
                                    <h4><a href="#"><?php echo ucfirst($item['name']); ?></a></h4>
                                    <div class="product-property">
                                       <?php
                                          $tempMore = ""; 
                                          $product_variation_info = (isset($item['product_variation_info'])) ? $item['product_variation_info'] : array();
                                          if(!empty($product_variation_info) && $product_variation_info!=''){
                                             $tempMore = "";
                                             $product_variation_info = json_decode($product_variation_info);
                                             if(!empty($product_variation_info)){
                                                foreach ($product_variation_info as $key => $value) {
                                                   $tempMore .= "<span> <label>".ucfirst($key).":</label> &nbsp;".ucfirst($value)."</span>";
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
                                    <!-- <p>
                                       <a href="http://192.168.2.137/marketplace/pd/kurta-for-women-straight-polycrepe-short-sleeves-yellow-and-black-color-mandarin-collar-long-kurta-b/MTEw" class=""> &lt; Buy More Of This Product</a>
                                       </p> -->
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
                                       <span>$<?php echo number_format($item['base_price'],2); ?></span>
                                    </div>
                                    <div class="discount-price-label">
                                       <span class="percantage">-20%</span>
                                       <del class="">$<?php echo number_format($item['sell_price'],2); ?></del>
                                    </div>
                                    <div class="policy-wrapper">
                                       <div class="policy">
                                          <a href="javascript:void(0)">View Return Policy</a>
                                       </div>
                                       <!-- <div class="policy">
                                          <a href="#">View Warranty Policy</a>
                                          </div>
                                          <div class="policy">
                                          <a href="#">View Guaranty Policy</a>
                                          </div> -->
                                    </div>
                                    <?php $grand_total = $grand_total + $item['subtotal']; ?>
                                    <div class="remove-save-product-wrapper">
                                       <div class="save-link"><a href="javascript:void(0)">Save for Later</a></div>
                                       <div class="remove-link"><a href="javascript:void(0)" onclick="return confirmBox('Do you want to remove it ?','<?php echo base_url('cart/remove/'.$item['rowid']); ?>')">Remove</a></div>
                                    </div>
                                 </div>
                                 <div class="clearfix"></div>
                              </div>
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
                           <span class="left-side">Subtotal</span>
                           <span class="right-side">$<?php echo number_format($grand_total,2); ?></span>
                        </div>
                        <div class="cart-total-block">
                           <span class="left-side">Shipping Fee</span>
                           <span class="right-side">$0.00</span>
                        </div>
                        <div class="cart-total-block cart-total-block-footer">
                           <span class="left-side">Order Total</span>
                           <span class="right-side">$<?php echo number_format($grand_total,2); ?></span>
                        </div>
                        <div class="payment-button-wrapper">
                           <a href="javascript:void(0)" class="btn btn-red">Pay <span class="font-roboto">$<?php echo number_format($grand_total,2); ?></span></a>
                        </div>
                     </div>
                  </div>
                  <?php } ?>
                  <div class="right-address-wrapper">
                     <div class="right-address-toggle-section">
                        <span class="close-toggle-btn get-address-toggle-btn">
                        <i class="icofont icofont-close"></i>
                        </span>
                        <h4>Select a Delivery Address</h4>
                        <div class="address-field-section">
                           <div class="address-block-field">
                              <div class="address-book-entry">
                                 <ul class="display-address">
                                    <li class="name">Gulshan Chouhan</li>
                                    <li class="display-address-link">RJ Road</li>
                                    <li class="display-address-city-state">
                                       Ahmedabad, Gujarat, 382213 
                                    </li>
                                    <li class="display-address-country">India</li>
                                    <li class="display-number-link"><label>Mobile:</label> +91 9896564510</li>
                                 </ul>
                                 <div class="address-save-delete-wrap">
                                    <a class="editAddress" aid="NA==" href="javascript:void(0)"><i class="icofont icofont-ui-edit"></i> Edit</a>
                                    <a class="delete-address" href="javascript:void(0)" onclick="return confirmBox('Do you want to delete it ?','http://192.168.2.137/marketplace/backend/common/delete/shipping_addresess/shipping_address_id/4')"><i class="icofont icofont-ui-delete"></i> Delete</a>
                                 </div>
                              </div>
                              <div class="ship-to-this-address-wrapper">
                                 <div class="ship-to-this-address">
                                    <a class="link btn-red btn-lg" href="http://192.168.2.137/marketplace/order/payment/NA==">Select address</a>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="add-new-address-btn">
                           <a href="#" class="btn btn-default btn-block">Add New Address</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
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
         </div>
         <div class="clearfix"></div>
      </div>
   </div>
</section>
<!-- Modal -->
<div class="modal fade" id="newBillinkAddressModal" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content comman-modal">
         <div class="modal-header comman-header-modal">
            <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><img src="<?php echo SELLER_THEME_URL; ?>/img/Icon_Basic_Close.svg" width="18"></span>
            </button>
            <h4 class="modal-title text-center billibgTitle">Add New Billing Address</h4>
         </div>
         <div class="modal-body comman-body-modal clearfix">
            <form method="post" id="form_valid_billing" data-bvalidator-validate>
               <div class="alert alert-danger" style="display:none;" id="errMsg" role="alert"></div>
               <div class="alert alert-success" style="display:none;" id="successMsg" role="alert"></div>
               <div class="loader" id='loaderImg' style='display: none; position: absolute;z-index: 1; width: 100%;background: rgba(255, 255, 255, 0.56);text-align: center;height: 100%;left: 0;'>
                  <img style="width:250px; position: relative; top: 20%;" src='<?php echo base_url('./assets/frontend/img/loader.gif')?>'/>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label class="control-label">First Name</label>
                     <input type="text" id="first_name" name="first_name" value="" class="form-control" placeholder="First Name" data-bvalidator="required" data-bvalidator-msg="First name is required">
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label class="control-label">Last Name</label>
                     <input type="text" id="last_name" name="last_name" value="" class="form-control" placeholder="Last Name" data-bvalidator="required" data-bvalidator-msg="Last name is required">
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
                     <label class="control-label">Email Id</label>
                     <input type="text" id="email_id" name="email_id" value="" class="form-control" placeholder="Email Id" data-bvalidator="email,required">
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
                     <label class="control-label">Mobile No.</label>
                     <div class="mobile-number-wrapper">
                        <div class="mobile-number-left">
                           <select class="form-control" name="country_code" id="country_code">
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
                           <input type="text" class="form-control" id="mobile" value="<?php echo set_value('mobile'); ?>" name="mobile" placeholder="xxxxxxxxxx" data-bvalidator="maxlen[13],minlen[9],number,required" data-bvalidator-msg="Please enter a 10 digit Mobile No.">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label class="control-label">Country</label>
                     <select name="country" class="form-control" id="country" data-bvalidator="required">
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
                     <select name="state" class="form-control" id="state" data-bvalidator="required">
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
                     <select name="city" class="form-control" id="city" data-bvalidator="required">
                        <option value="">--Select City--</option>
                     </select>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="form-group">
                     <label class="control-label">Postal Code</label>
                     <input type="text" id="zip_code" name="zip_code" value="" class="form-control" data-bvalidator="maxlen[8],minlen[4],number,required" placeholder="Postal Code" data-bvalidator-msg="Valid Postal Code is required">
                     <input type="hidden" id="shipping_address_id" name="shipping_address_id" value="">
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="form-group">
                     <label class="control-label">Address</label>
                     <textarea class="form-control" name="address" id="address" placeholder="Address" rows="3" cols="6" data-bvalidator="required" data-bvalidator-msg="Address is required"></textarea>
                  </div>
               </div>
               <div class="text-center">
                  <button type="submit" class="btn btn-red submitBillingDetails">Submit</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<script>
   SITE_URL = "<?php echo base_url(); ?>";
   /*get Country Data according to their Country Code*/
   $('.addAddress').on('click', function() {
      
      $('#form_valid_billing')[0].reset();
      $(".billibgTitle").text("Add New Billing Address");
      $(".submitBillingDetails").text("Submit");
      $("#shipping_address_id").val('');
      $('#newBillinkAddressModal').modal('show');
   
   });
   
   $('.editAddress').on('click', function() {
   
       $(".billibgTitle").text("Update Billing Address");
       $(".submitBillingDetails").text("Update");
       var aId = $(this).attr("aId");
   
       if(aId == '') {
         $("#shipping_address_id").val('');
         $('#newBillinkAddressModal').modal('show');
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
                     $('#country_code').val(data.data.country_code);
                     $('#country').val(data.data.country);
                     $('#state').html(data.stateData);
                     $('#city').html(data.cityData);
                     $('#mobile').val(data.data.phone_no);
                     $('#address').val(data.data.address);
                     $('#zip_code').val(data.data.zip_code);
   
                     $("#shipping_address_id").val(aId);
                     $('#newBillinkAddressModal').modal('show');
   
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
   
         var shipping_address_id = $("input[name=shipping_address_id]").val();
         var first_name = $("input[name=first_name]").val();
         var last_name = $("input[name=last_name]").val();
         var email_id = $("input[name=email_id]").val();
         var country_code = $('#country_code').val();
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
              $('#loaderImg').show();
            },
            cache: false,
            success: function(result) {
                var data = JSON.parse(result);
                if(data.status=='failed'){  
                    $('#loaderImg').hide();
                    $('.modal-body #errMsg').show(data.msg);
                    $(".modal-body #errMsg").html(data.msg);
                    setTimeout(function(){
                        $('.modal-body #errMsg').hide(data.msg);
                    }, 3000);
                }else{
                    $('#loaderImg').hide();
                    $('.modal-body #successMsg').show(data.msg);
                    $(".modal-body #successMsg").html(data.msg);
                    setTimeout(function(){
                          $('.modal-body #successMsg').hide(data.msg);
                          location.reload();
                    }, 3000);
                }
            },
         });
      }
      return false;
   
   });
   jQuery('.get-address-toggle-btn').click(function(){
      jQuery('.right-address-wrapper').toggleClass('right-toggle-move');
   });
</script>
<style type="text/css">
   .my-cart-wrapper {
   margin-bottom: 20px;
   }
   .payment-cart-items {
   margin-bottom: 20px;
   }
   .my-cart-items {
   float: left;
   display: inline-block;
   }
   .my-cart-items h4,
   .payment-cart-items h4 {
   font-weight: 700;
   font-family: Roboto;
   margin:0;
   font-size: 19px;
   }
   .my-select-address-shipping {
   float: right;
   display: inline-block;
   cursor: pointer;
   }
   .my-select-address-shipping h4{
   margin: 0;
   font-size: 15px;
   color: #222;
   padding-left: 30px;
   padding-right: 15px;
   position: relative;
   }
   .my-select-address-shipping h4>.pin-code{
   color: #f45b69;
   font-weight: 600;
   }
   .my-select-address-shipping h4>.icofont-truck-loaded{
   font-size: 26px;
   color: #f45b69;
   position: absolute;
   left: 0;
   top: -4px;
   }
   .my-select-address-shipping h4>.icofont-simple-right{
   font-size: 23px;
   position: absolute;
   top: -2px;
   right: -5px;
   color: #f45b69;
   }
   .my-cart-holder-wrapper{
   padding-right: 400px;
   position: relative;      
   }
   .my-cart-holder-wrapper .order-left-section{
   float: left;
   display: inline-block;
   position: relative;
   width: 100%;
   padding-right: 50px;
   }
   .my-cart-holder-wrapper .right-cart-price-total{
   margin-right: -400px;
   width: 400px;
   position: relative;
   display: inline-block;
   float: right;
   }
   .cart-prodcut-deatil-box .cart-product {
   display: block;
   position: relative;
   padding-left: 130px;
   /*padding-right: 250px;*/
   }
   .cart-prodcut-deatil-box .price-view-box {
   /*margin-right: -250px;*/
   position: relative;
   text-align: right;
   /*width: 250px;*/
   float: left;
   width: 35%;
   }
   .buying-from {
   padding: 10px 15px;
   background: #fafafa;
   border-radius: 4px;
   margin-bottom: 15px;
   font-size: 15px;
   }
   .buying-from .seller-name{
   font-weight: 600;
   text-transform: capitalize;
   }
   .product-property>span {
   padding: 0px 10px;
   border-right: 1px solid #ddd;
   }
   .product-property>span:first-child{
   padding-left: 0;
   }
   .product-property>span:last-child{
   border-right: 0;
   }
   .details-view-box h4 {
   margin-top: 0;
   font-weight: 600;
   font-size: 15px;
   line-height: 20px;
   font-family: Roboto;
   }
   .details-view-box h4>a {
   color: #f45b69;
   }
   .details-view-box h4>a:hover{
   color: #333;
   }
   .product-quantity {
   margin-top: 10px;
   }
   .product-quantity>span{
   display: inline-block;
   border: 1px solid #bbb;
   padding: 6px 8px;
   font-weight: 500;
   font-family: Roboto;
   line-height: 13px;
   }
   .price-label {
   font-size: 16px;
   font-family: Roboto;
   font-weight: 600;
   margin-bottom: 5px;
   } 
   .discount-price-label {
   font-size: 14px;
   font-family: Roboto;
   font-weight: 500;
   color: #666;
   margin-bottom: 5px;
   }
   .discount-price-label .percantage {
   color: #09ac63;
   padding-right: 10px;
   font-weight: 500;
   }
   .policy-wrapper{
   margin-top: 10px;
   }
   .policy-wrapper .policy a {
   text-decoration: underline;
   color: #555;
   }
   .policy-wrapper .policy a:hover{
   color: #fb1328;
   }
   .remove-save-product-wrapper{
   margin-top: 15px;
   }
   .remove-save-product-wrapper .save-link {
   display: inline-block;
   padding-right: 10px;
   }
   .remove-save-product-wrapper .remove-link {
   display: inline-block;
   }
   .remove-save-product-wrapper a{
   color: #ef4e28;
   font-weight: 600;
   text-transform: capitalize;
   font-size: 13px
   }
   .remove-save-product-wrapper a:hover{
   color: #333;
   }
   .cart-total-block{
   font-size: 1.5rem;
   color: #222;
   font-weight: 400;
   padding-bottom: 15px;
   }
   .cart-total-block .left-side{
   width: 60%;
   display: inline-block;
   color: #4a4a4a;
   float: left;
   }
   .cart-total-block .right-side{
   width: 40%;
   display: inline-block;
   text-align: right;
   font-family: Roboto;
   }
   .cart-total-block-footer{
   color: #222;
   font-weight: 500;
   padding: 1rem 0;
   border-top: 1px solid #ebebeb;
   border-bottom: 1px solid #ebebeb;
   }
   .cart-total-block-footer span{
   font-weight: 600;
   }
   .payment-button-wrapper {
   padding: 30px 0;
   }
   .payment-button-wrapper .btn-red {
   display: block;
   margin: 0;
   width: 100%;
   font-size: 19px;
   font-weight: 500;
   text-transform: uppercase;
   }
   .right-address-wrapper.right-toggle-move {
   position: fixed;
   width: 100%;
   height: 100%;
   top: 0;
   left: 0;
   z-index: 111;
   background: rgba(0,0,0,.5);
   }
   .right-address-toggle-section{
   position: absolute;
   bottom: 0;
   top: 0;
   right: -500px;
   width: 450px;
   height: 100%;
   background: #fff;
   z-index: 1;
   padding: 10px 15px;
   box-shadow: 0 0 3px #999;
   transform: translateX(500px);
   transition: all ease 0.5s;
   }
   .right-address-wrapper.right-toggle-move .right-address-toggle-section{
   transform: translateX(0px);
   right: 0;
   }
   .right-address-toggle-section .close-toggle-btn {
   position: absolute;
   left: -45px;
   top: 0px;
   padding: 4px;
   font-size: 35px;
   border-radius: 0px;
   background-color: transparent;
   color: #fff;
   border: none;
   cursor: pointer;
   opacity: 0.8;
   }
   .right-address-toggle-section .close-toggle-btn:hover{
   opacity: 1;
   }
   .right-address-toggle-section h4{
   font-weight: 600;
   margin-bottom: 20px;
   }
   .address-block-field {
   position: relative;
   padding-right: 130px;
   }
   .address-book-entry {
   position: relative;
   display: inline-block;
   float: left;
   width: 100%;
   }
   .ship-to-this-address-wrapper {
   width: 130px;
   margin-right: -130px;
   position: relative;
   display: inline-block;
   float: left;
   top: 12px;
   }
   .address-save-delete-wrap>a {
   font-weight: 600;
   padding: 10px 10px;
   }
   .address-save-delete-wrap>a:first-child{
   padding-left: 0;
   }
   .add-new-address-btn {
   position: absolute;
   width: 100%;
   left: 0;
   bottom: 0;
   z-index: 1;
   background: #fff;
   padding: 2rem;
   box-shadow: 0 2px 6px 0 hsla(0,0%,46%,.5);
   }
   .add-new-address-btn .btn-default{
   padding: 10px 20px;
   font-weight: 600;
   font-size: 16px;
   }
</style>