<section class="cart-page-warp">
   <div class="container-fluid two-col-holder">
      <!--cart page start here-->
      <div class="cart-holder">
         <div class="my-cart">
            <!--checkout-login-warp start here-->
            <div class="">
               <div class="">
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
                       <!--  <a href="<?php echo base_url('pd/'.$ProductInfo[0]->slug.'/'.base64_encode($ProductInfo[0]->product_variation_id)); ?>" class="back-cart-link"> &lt;  Buy related of this product</a> -->
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
                                 <tr class="grand-total-tr">
                                    <td><strong>TOTAL &nbsp;<span>:</span></strong></td>
                                    <td><strong> $<?php echo number_format($product_amountInfo['totalAmount'],2); ?></strong></td>
                                 </tr>
                              </tbody>
                           </table>
                        </div>
                        <div class="clearfix"></div>
                     </div>
                  </div>
                  <div class="col-md-6 col-lg-6 address-book-row">
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
                  </div>
               </div>
            </div>
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
   
</script>