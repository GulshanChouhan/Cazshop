<?php 
   $data2['sellerInfo'] = $sellerInfo;
   $data2['business_info'] = $business_info;
   $data2['seller_interview'] = $seller_interview;
   $data2['seller_signature_and_licence'] = $seller_signature_and_licence;
   $data2['encrypted_id'] = $encrypted_id; 
   $this->load->view('seller/steps/menus', $data2); 
   ?>
<div class="common-contain-wrapper clearfix">
   <div class="">
      <div class="seller-panel panel">
         <div class="panel-heading">
            <div class="panel-title"><i class="icofont icofont-truck-loaded"></i> Choose Shipment Option & Bitcoin and Ethereum Address</div>
         </div>
         <div class="panel-body">
            <div class="col-sm-12 custom-center-block">
              <div class="highlight-info-box">
                <h4 class="color-red">There are two types of Shipment Option that is mentioned below -</h4>
                <ul>
                   <li>
                      <strong>Local Shipping -</strong> In Local shipping, you will get your selected country on "shipment rate" page for providing shipping charges.
                   </li>
                   <li>
                      <strong>International Shipping -</strong> In International shipping, you will get the list of all countries on "shipment rate" page for providing shipping charges.
                   </li>
                </ul>
              </div>
               <br>
               <form id="seller_option" method="post" class="" role="form">
                  <div class="col-md-12 form-group">
                     <label class="">Shipment Option ?</label>
                     <div class="radio-input">
                        <input <?php if(!empty($business_info->shipment_option)){ if($business_info->shipment_option==1){ echo "checked"; } } ?> type="radio" class="shipment_option" name="shipment_option" id="Local_Shipping" value="1">
                        <label for="Local_Shipping">Local Shipping</label>
                     </div>
                     <div class="radio-input">
                        <input <?php if(!empty($business_info->shipment_option)){ if($business_info->shipment_option==2){ echo "checked"; } }else{ echo "checked"; } ?> type="radio" class="shipment_option" name="shipment_option" id="International_Shipping" value="2">
                        <label for="International_Shipping">International Shipping</label>
                     </div>
                     <?php echo form_error('shipment_option'); ?>
                  </div>
                  <div class="col-md-12 form-group shipping_country" style="display: <?php if(!empty($business_info->shipment_option) && $business_info->shipment_option==1) echo "block"; else echo "none"; ?>">
                     <label class="">Your Country<span class="mandatory">*</span></label>
                     <select name="shipping_country" class="form-control" data-bvalidator="required" id="shipping_country">
                        <option value="">--Select Country for local shipping--</option>
                        <?php if(!empty($country)){ foreach ($country as $row) { ?>
                        <option <?php if(!empty($business_info)){ if($business_info->shipping_country==$row->id){ echo "selected"; } } ?> value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                        <?php } } ?>
                     </select>
                     <?php echo form_error('shipping_country'); ?>
                  </div>

                  <?php if(!empty($choose_shippingOption)){ ?>
                  <div class="categories-wish-sell col-md-12">
                     <h3>Choose Shipping type as you wish to sell</h3>
                     <table class="table-bordered responsive table table-striped table-hover" cellpadding="5">
                        <thead>
                          <tr>
                            <th width="8%">#</th>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Delivery Days</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $i = 1;
                            $shippping_type = (!empty($business_info->shippping_type)) ? json_decode($business_info->shippping_type) : '';
                            
                            foreach ($choose_shippingOption as $row) {
                              $shipping_option_id = $row->shipping_option_id;
                          ?>
                          <tr>
                            <td>
                              <div class="">
                                <div class="checkbox-input">
                                  <input class="styled" <?php if(!empty($shippping_type->$shipping_option_id)) echo "checked"; ?> type="checkbox" id="checkall<?php echo $i ?>" name="checkstatus[]" value="<?php echo $row->shipping_option_id; ?>" <?php if($i==1){ ?> data-bvalidator='required' data-bvalidator-msg='Need to choose atleast one shipping type' <?php } ?>>      &nbsp;&nbsp; <?php echo $i.".";?>
                                  <label class="" for="checkall<?php echo $i ?>"></label>
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="">
                                <?php echo ucwords($row->title); ?>  
                              </div>
                            </td>
                            <td>
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-usd" aria-hidden="true"></i>
                                </span>
                                <div class="num-input-container">
                                  <input <?php if(empty($shippping_type->$shipping_option_id)){ ?> disabled="disabled" <?php } ?> data-bvalidator='number,required' data-bvalidator-msg='please enter price' class='form-control price<?php echo $row->shipping_option_id; ?>' type='text' value='<?php if(!empty($shippping_type->$shipping_option_id)) echo $shippping_type->$shipping_option_id->price; ?>' name='shippping_type[<?php echo $row->shipping_option_id; ?>][price]' placeholder='Price Of <?php echo ucwords($row->title); ?>'>
                                </div>
                              </div>
                            </td>
                            <td>
                              <div class="">
                                
                              </div>

                              <div class="input-group">
                                 <span><input <?php if(empty($shippping_type->$shipping_option_id)){ ?> disabled="disabled" <?php } ?> data-bvalidator='digit,required' data-bvalidator-msg='please enter minimum delivery day' class='form-control deliverydays<?php echo $row->shipping_option_id; ?>' type='text' value='<?php if(!empty($shippping_type->$shipping_option_id)) echo $shippping_type->$shipping_option_id->min_day; ?>' name='shippping_type[<?php echo $row->shipping_option_id; ?>][min_day]' placeholder='Minimum day of <?php echo ucwords($row->title); ?>'></span>
                                 <span class="input-group-addon" id="basic-addon1">To</span>
                                 <span><input <?php if(empty($shippping_type->$shipping_option_id)){ ?> disabled="disabled" <?php } ?> data-bvalidator='digit,required' data-bvalidator-msg='please enter maximum delivery day' class='form-control deliverydays<?php echo $row->shipping_option_id; ?>' type='text' value='<?php if(!empty($shippping_type->$shipping_option_id)) echo $shippping_type->$shipping_option_id->max_day; ?>' name='shippping_type[<?php echo $row->shipping_option_id; ?>][max_day]' placeholder='Maximum day of <?php echo ucwords($row->title); ?>'></span>
                              </div>

                            </td>
                          </tr>
                          <?php $i++; } ?>
                        </tbody>
                      </table>
                  </div>
                  <?php } ?>

                  <div class="clearfix"></div>
                  <div class="shippingOptionShow"></div>
                  <br>

                  <!-- Button -->
                  <div class="col-sm-12 controls">
                     <button class="btn btn-red btn-continue"><span><?php if(!empty($business_info->shippping_type) && !empty($business_info->shipment_option)) echo "Continue"; else echo "Continue"; ?></span></button>
                     <?php
                        $skipped_pages = 0;
                        if(!empty($sellerInfo->skipped)){
                           $skipped = json_decode($sellerInfo->skipped);
                           $skipped_pages = count($skipped->skipped_pages);
                        }
                     ?>
                     <?php if($skipped_pages < 7){ ?>
                     <a class="btn btn-skip" href="<?php echo base_url('seller/skip/signature_or_licence/'.$encrypted_id); ?>">Remind me later</a>
                     <?php }else{ ?>
                     <a class="btn btn-default-white" href="<?php echo base_url('seller/seller_interview/'.base64_encode(seller_id())); ?>">Back</a>
                     <?php } ?>
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
</div>
<script>

  SITE_URL = "<?php echo base_url(); ?>";
  $(document).ready(function(){
      $('#seller_option').bValidator();
  });

  $(".shipment_option").click(function() {
     if($(this).val()==1){
      $(".shipping_country").show();
     }else{
      $(".shipping_country").hide();
     }
  });

  $(document).ready(function() {
      $('.styled').click(function() {
          if($(this).is(":checked")) {
            $('.price'+this.value).removeAttr("disabled");
            $('.deliverydays'+this.value).removeAttr("disabled","disabled");
            $('.price'+this.value).attr("data-bvalidator","required"); 
            $('.price'+this.value).attr("data-bvalidator-msg","please enter price");
            $('.deliverydays'+this.value).attr("data-bvalidator","required"); 
            $('.deliverydays'+this.value).attr("data-bvalidator-msg","please enter delivery days");
          }else{
            $('.price'+this.value).attr("disabled","disabled");
            $('.deliverydays'+this.value).attr("disabled","disabled");
            $('.price'+this.value).val("");
            $('.deliverydays'+this.value).val("");
            $('.price'+this.value).attr("data-bvalidator","required"); 
            $('.price'+this.value).attr("data-bvalidator-msg","please enter price");
            $('.deliverydays'+this.value).attr("data-bvalidator","required"); 
            $('.deliverydays'+this.value).attr("data-bvalidator-msg","please enter delivery days");
          }    
      });
  });
</script>