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
            <div class="panel-title"><i class="icofont icofont-shopping-cart"></i> Store Information</div>
         </div>
         <div class="panel-body">
            <div class="custom-center-block">
               <form id="seller_info" method="post" class="" role="form" data-bvalidator-validate>
                  <div class="col-sm-12">
                     <div class="add-cat-design clearfix highlight-info-box">
                        <div class="col-md-12">
                           <h4 class="color-red">Add Categories in which you wish to add your "products"<span class="mandatory" style="font-size: 25px; line-height: 0;">*</span></h4>
                        </div>
                        <div class="col-sm-12">
                           <div class="form-group">
                              <select data-placeholder="Choose categories" id="all_cats" class="form-control chosen-select" name="category[]" data-bvalidator="" multiple>
                                 <?php if(!empty($category)){ $toEnd = count($category); foreach ($category as $row) { ?>
                                 <option value="<?php echo $row->category_id; ?>" <?php if(!empty($business_info)){ if(in_array($row->category_id, json_decode($business_info->category))){ echo "selected"; } } ?>><?php echo $row->category_name; ?></option>
                                 <?php } } ?>
                              </select>
                              <?php echo form_error('category[]'); ?>
                           </div>
                        </div>
                        <div class="cleafix"></div>
                        <div class="col-sm-12">
                           <div><b>Note -</b> If the category is not available in above list OR if you want to add new category, <a data-toggle="modal" data-target="#category_popup" href="javascript:;" class="createCategory link-text"><b>Click Here</b></a></div>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-sm-6 border-right">
                     <div class="col-md-12 form-group">
                        <h4 class="seller-info-tittle">Store Basic Information</h4>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="">Store Name</label>
                           <input type="text" class="form-control" data-bvalidator="" name="store_name" value="<?php if(set_value('store_name')){ echo set_value('store_name'); }else if(!empty($business_info)){ echo $business_info->store_name; } ?>" placeholder="Cissy Wears" data-bvalidator-msg="Please enter the store name">
                           <?php echo form_error('store_name'); ?>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="">Store Email Address</label>
                           <input type="text" class="form-control" data-bvalidator="checkBusinessEmail,email" name="contact_email" value="<?php if(set_value('contact_email')){ echo set_value('contact_email'); }else if(!empty($business_info)){ echo $business_info->contact_email; } ?>" placeholder="jane.doe@example.com" data-bvalidator-msg="Please enter the valid/Unique Email address of store">
                           <?php echo form_error('contact_email'); ?>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="">Store Phone No.</label>
                           <div class="mobile-number-wrapper">
                              <div class="mobile-number-left">
                                 <select name="country_code" id="country_code" class="form-control">
                                    <?php
                                       if(!empty($phnCode)){
                                       foreach ($phnCode as $row){
                                       ?>
                                    <option <?php if(!empty($business_info->country_code)){ if($business_info->country_code==$row->phonecode){ echo "selected"; } }else if(!empty($sellerInfo->country_code)){ if($sellerInfo->country_code==$row->phonecode){echo "selected"; } }else if($row->phonecode=='91'){ echo "selected"; } ?> value="<?php echo $row->phonecode; ?>"><?php echo $row->sortname.' +'.$row->phonecode; ?></option>
                                    <?php
                                       } }
                                       ?>
                                 </select>
                              </div>
                              <div class="mobile-number-right">
                                 <input type="text" class="form-control" data-bvalidator="checkBusinessPhoneNo,maxlen[13],minlen[9],number" name="mobile" value="<?php if(set_value('mobile')){ echo set_value('mobile'); }else if(!empty($business_info)){ echo $business_info->mobile; }else{ if(!empty($sellerInfo->mobile)) echo $sellerInfo->mobile; } ?>" placeholder="09987654321" data-bvalidator-msg="Please enter a valid/Unique Phone No.">
                                 <?php echo form_error('country_code'); ?><?php echo form_error('mobile'); ?>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="">Store Alternate No.</label>
                           <input type="text" class="form-control" data-bvalidator="maxlen[13],minlen[9],number" name="alternate_no" value="<?php if(set_value('alternate_no')){ echo set_value('alternate_no'); }else if(!empty($business_info)){ echo $business_info->alternate_no; } ?>" placeholder="09987654321">
                           <?php echo form_error('alternate_no'); ?>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label class="">Owner Name</label>
                           <input type="text" class="form-control" data-bvalidator="" data-bvalidator-msg="Please enter the owner name" name="owner_name"  value="<?php if(set_value('owner_name')){ echo set_value('owner_name'); }else if(!empty($business_info)){ echo $business_info->owner_name; } ?>" placeholder="Jane Doe">
                           <?php echo form_error('owner_name'); ?>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                  </div>
                  <div class="col-sm-6">
                     <div class="col-md-12 form-group">
                        <h4 class="seller-info-tittle">Store Address Information</h4>
                     </div>
                     <div class="clearfix"></div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="">Country</label>
                           <select name="country" class="form-control" data-bvalidator="" data-bvalidator-msg="Please select the country" id="country">
                              <option value="">--Select Country--</option>
                              <?php if(!empty($country)){ foreach ($country as $row) { ?>
                              <option <?php if(!empty($business_info)){ if($business_info->country==$row->id){ echo "selected"; } } ?> value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                              <?php } } ?>
                           </select>
                           <?php echo form_error('country'); ?>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="">State</label>
                           <?php
                              $country = "";
                              if(!empty($business_info)){ $country = $business_info->country; }
                              $getProvinceData = getDataResult('states', array('country_id'=>$country));
                              ?>
                           <select name="state" class="form-control" data-bvalidator="" data-bvalidator-msg="Please select the state" id="state">
                              <option value="">--Select State--</option>
                              <?php if(!empty($getProvinceData)){ foreach ($getProvinceData as $row) { ?>
                              <option <?php if(!empty($business_info->state)  && $business_info->state!=0){ if($business_info->state==$row->id){ echo "selected='selected'"; } } ?> value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                              <?php } } ?>
                           </select>
                           <?php echo form_error('state'); ?>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="">City</label>
                           <?php
                              $state_id = "";
                              if(!empty($business_info)){ $state_id = $business_info->state; }
                              $getCityData = getDataResult('cities', array('state_id'=>$state_id));
                              ?>
                           <select name="city" class="form-control" data-bvalidator="" data-bvalidator-msg="Please select the city" id="city">
                              <option value="">--Select City--</option>
                              <?php if(!empty($getCityData)){ foreach ($getCityData as $row) { ?>
                              <option <?php if(!empty($business_info->city) && $business_info->city!=0){ if($business_info->city==$row->id){ echo "selected='selected'"; } } ?> value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                              <?php } } ?>
                           </select>
                           <?php echo form_error('city'); ?>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label class="">Postal Code</label>
                           <input autocomplete="off" type="text" data-bvalidator="maxlen[8],minlen[4]" data-bvalidator-msg="Please enter the valid postal code" class="form-control" name="zip" id="postalcode" value="<?php if(set_value('zip')){ echo set_value('zip'); }else if(!empty($business_info)){ echo $business_info->zip; } ?>" placeholder="40126">
                           <?php echo form_error('zip'); ?>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label class="">Street Address</label>
                           <input autocomplete="off" type="text" data-bvalidator="" data-bvalidator-msg="Please enter the street address" class="form-control" name="address" id="address" value="<?php if(set_value('address')){ echo set_value('address'); }else if(!empty($business_info)){ echo $business_info->address; } ?>" placeholder="Cissy Wears  New York, NY, USA">
                           <?php echo form_error('address'); ?>
                        </div>
                     </div>
                  </div>
                  <!-- Button -->
                  <div class="col-sm-12 controls text-center margin-top-30">
                     <button class="btn btn-red btn-continue"><span><?php if(!empty($business_info)) echo "Continue"; else echo "Continue"; ?></span></button>
                     <?php
                        $skipped_pages = 0;
                        if(!empty($sellerInfo->skipped)){
                        $skipped = json_decode($sellerInfo->skipped);
                        $skipped_pages = count($skipped->skipped_pages);
                        }
                        ?>
                     <?php if($skipped_pages < 7){ ?>
                     <a class="btn btn-skip" href="<?php echo base_url('seller/skip/seller_interview/'.$encrypted_id); ?>">Remind me later</a>
                     <?php }else{ ?>
                     <a class="btn btn-default-white" href="<?php echo base_url('seller/phone_verification/'.base64_encode(seller_id())); ?>">Back</a>
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
<div class="modal fade" id="category_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content support-ticket-modal comman-modal">
         <div class="modal-header comman-header-modal">
            <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><img src="<?php echo SELLER_THEME_URL; ?>/img/Icon_Basic_Close.svg" width="18"></span>
            </button>
            <h4 class="modal-title text-center" id="myModalLabel">Create Category</h4>
         </div>
         <div class="modal-body comman-body-modal">
            <form role="form" action="<?php echo base_url('seller/create_category'); ?>" method="post" id="createCategoryForm">
               <div class="form-body contact-support-form ">
                  <div class="col-md-12">
                     <div class="row">
                        <div class="form-group col-md-12 col-sm-12">
                           <label>Category Name <span class="mandatory">*</span></label>
                           <input type="text" class="form-control text-capitalize" name="category_name" id="" placeholder="Name Of Category" value="<?php echo set_value('category_name'); ?>" data-bvalidator="required">
                           <?php echo form_error('category_name') ?>
                        </div>
                        <div class="form-group col-md-12 col-sm-12">
                           <label>Short Description <span class="mandatory">*</span></label>
                           <textarea name="short_description" class="form-control tooltips" rel="tooltip" data-placement="top right" rows="6" placeholder="Category Description (Maxlength 160 characters)" maxlength="500" data-bvalidator="required,maxlen[500]"><?php echo set_value('short_description'); ?></textarea>
                           <?php echo form_error('short_description') ?>
                        </div>
                        <div class="col-md-12 col-sm-12 text-center">
                           <button type="submit" class="btn btn-lg btn-red contact-submit">Submit</button>
                        </div>
                        <div class="clearfix"></div>
                     </div>
                  </div>
                  <div class="clearfix"></div>
            </form>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
   SITE_URL = "<?php echo base_url(); ?>";
   $(document).ready(function(){
   $('#seller_info').bValidator();
   $('#createCategoryForm').bValidator();
   });
   
   function checkBusinessEmail(email){
   resultFun = false;
   var encrypted_id = "<?php echo $encrypted_id; ?>";
   if(email){
   $.ajax({
   type: 'POST',
   url: SITE_URL+'seller/checkBusinessEmail',
   async: false,
   data: {'id': encrypted_id, 'email':email},
   success: function(data){
   data = jQuery.parseJSON(data);
   if(data.status == 'success'){
   resultFun = true;
   }else{
   resultFun = false;
   }
   }
   });
   }else{
   resultFun = false;
   }
   return resultFun;
   }
   function checkBusinessPhoneNo(phone){
   resultFun = false;
   var encrypted_id = "<?php echo $encrypted_id; ?>";
   if(phone){
   $.ajax({
   type: 'POST',
   url: SITE_URL+'seller/checkBusinessPhoneNo',
   async: false,
   data: {'id': encrypted_id, 'phone':phone},
   success: function(data){
   data = jQuery.parseJSON(data);
   if(data.status == 'success'){
   resultFun = true;
   }else{
   resultFun = false;
   }
   }
   });
   }else{
   resultFun = false;
   }
   return resultFun;
   }
</script>