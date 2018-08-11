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
                           <li class="active">
                              <a href="<?php echo base_url('account/orders'); ?>"><i class="icofont icofont-shopping-cart"></i> Order History</a>
                           </li>
                           <li class="">
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
                              $order_status  = getRow('order_status', array('order_detail_id'=>$value, 'status'=>4));
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
                                                <a href="<?php echo base_url('pd/'.$product_details->slug.'/'.base64_encode($product_details->product_variation_id)); ?>">
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
                                                   <div class="right-label"><?php if(!empty($userName->user_name)) echo ucwords($userName->user_name); else echo "-"; ?></div>
                                                </div>

                                                <div class="orderstatus-tag">
                                                   <div class="left-label">Order Status:</div>
                                                   <div class="label-status label-status-<?php if(!empty($order_details->order_status)) echo orderStatuscls($order_details->order_status); else echo "primary"; ?>"><?php if(!empty($order_details->order_status)) echo orderStatusName($order_details->order_status); else echo "-"; ?></div>
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
                              <div class="right-sdie">
                                 <div class="right-btn-wrapper">

                                 <?php
                                    if($product_details->accepted_returnpolicy==1){
                                       $deliveredByAdmin  = getRow("order_status",array("status"=>4, "order_detail_id"=>$row->order_detail_id, 'user_role'=>0));
                                       if(!empty($deliveredByAdmin)){
                                          $return_policydays = $product_details->return_policydays;
                                          $delivered_date    = date('d M Y',strtotime($deliveredByAdmin->created));
                                          $expireOn = date('d-m-Y', strtotime($delivered_date. ' + '.$return_policydays.' days'));
                                          $expireOnStrTime = strtotime($expireOn);
                                          $currOnStrTime = strtotime(date('d-m-Y'));
                                          if($currOnStrTime <= $expireOnStrTime){
                                 ?>
                                    <div class="a-row margin-bottom-20">
                                          <a href="javascript:void(0)" odi="<?php echo base64_encode($order_details->order_detail_id); ?>" class="btn btn-default-new btn-block returnItem"><i class="icofont icofont-recycle"></i> Return Order</a>
                                    </div>
                                    
                                    <?php } } } ?>

                                    <?php
                                       $alreadyReviewed = getRow("product_review",array('product_variation_id'=>$product_details->product_variation_id, 'user_id'=>user_id())); 
                                       if(empty($alreadyReviewed)){ 
                                    ?>
                                    <div class="a-row margin-bottom-20">
                                       <a href="javascript:void(0)" pID="<?php echo base64_encode($product_details->product_variation_id); ?>" class="btn btn-default-new btn-block writeAProductReview"><i class="icofont icofont-star"></i> Write a product review</a>
                                    </div>
                                    <?php } ?>
                                 </div>
                              </div>
                           </div>
                           <div class="clearfix"></div>
                        </div>
                        <hr>
                        <?php }
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
                            <h4>Order history not available</h4>
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


<!-- Product Review Modal -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="icofont icofont-close"></i></span></button> -->
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
                 <div class="loading main-loader" id='main-loader' style="display: none;">
                     <div class="loader">
                        <svg class="circular-loader" viewBox="25 25 50 50" >
                           <circle class="loader-path" cx="50" cy="50" r="20" fill="none" stroke="#f45b69" stroke-width="2.5" />
                        </svg>
                     </div>
                  </div>
                  <div class="review-descropation">
                     <textarea class="form-control" name="description" rows="6" data-bvalidator="required" placeholder="Description..."  data-bvalidator-msg="Description is required"></textarea>
                     <?php echo form_error('description') ?>
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
                           <textarea name="msg_of_reason" class="form-control tooltips" data-bvalidator="required,maxlen[500]" rel="tooltip" data-placement="top right" rows="6" data-bvalidator-msg="Please enter the message" placeholder="Please describe the cancellation reason" maxlength="500" ><?php echo set_value('msg_of_reason'); ?></textarea>
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
   });

   $('.event_star1').voteStar({
       callback: function(starObj, starNum){
           $("#ratingStar").val(starNum);
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

</script>

<script>
   SITE_URL = "<?php echo base_url(); ?>";

   /*Open product review modal*/
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


   /*Submit Product review form*/
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
                $('#main-loader').hide();
                if(data.status=='failed'){
                    $("button").attr("disabled", false);
                    errMsg(data.validation_errors);
                    return false;
                }else if(data.status=='failed'){  
                    $("button").attr("disabled", false);
                    errMsg(data.msg);                   
                    return false;
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
/*Submit Return form*/
   $('#returnReasonForm').submit(function() {        
      $('#returnReasonForm').bValidator();      // check if form is valid
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
                $('.main-loader').hide();
                if(data.status=='failed'){  
                    $("button").attr("disabled", false);
                    errMsg(data.validation_errors);
                    return false;
                }
                else if(data.status=='failed'){  
                    $("button").attr("disabled", false);
                    errMsg(data.msg);
                    return false;
                }
                else{
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