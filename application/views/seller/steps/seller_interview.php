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
          <div class="panel-title"><i class="icofont icofont-user-alt-5"></i> Seller Interview</div>
        </div>
         <div class="panel-body">
          <div class="col-sm-10 custom-center-block">
               <form id="seller_interview" method="post" class="step1" role="form">

                  <div class="categories-wish-sell col-md-12">
                     <div class="cat-name">Where do you get products from ?</div>
                     <?php $getProductFrom = getProductFrom('');
                     foreach ($getProductFrom as $key => $value) {
                     ?>
                     <div class="checkbox-input">
                        <input id="cat<?php echo $key; ?>" class="styled" type="checkbox" name="get_product_from[]" value="<?php echo $key; ?>" <?php if(!empty($seller_interview->get_product_from) && $seller_interview->get_product_from!='null'){ if(in_array($key, json_decode($seller_interview->get_product_from))){ echo "checked"; } }?>>
                        <label for="cat<?php echo $key; ?>">
                           <?php echo $value; ?>
                        </label>
                     </div>
                     <?php
                     }
                     ?>
                     <?php echo form_error('get_product_from'); ?>
                  </div>
                  <div class="clearfix"></div>
                  <br>
                  <div class="col-md-6 form-group">
                     <label class="">What is your annual turnover ?</label>
                     <select class="form-control" name="annual_turnover" data-bvalidator="" data-bvalidator-msg="Please select the annual turnover">
                        <option value="">--Select--</option>
                        <?php $annual_turnover = annual_turnover('');
                        foreach ($annual_turnover as $key => $value) {
                        ?>
                        <option <?php if(!empty($seller_interview)){ if($key==$seller_interview->annual_turnover){ echo "selected"; } } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php
                        }
                        ?>
                     </select>
                     <?php echo form_error('annual_turnover'); ?>
                  </div>
                  <div class="col-md-6 form-group">
                     <label class="">How many products do you sell ?</label>
                     <select class="form-control" name="how_much_sell" data-bvalidator="" data-bvalidator-msg="Please select the dropdown field">
                        <option value="">--Select--</option>
                        <?php $how_much_do_you_sell = how_much_do_you_sell('');
                        foreach ($how_much_do_you_sell as $key => $value) {
                        ?>
                        <option <?php if(!empty($seller_interview)){ if($key==$seller_interview->how_much_sell){ echo "selected"; } } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php
                        }
                        ?>
                     </select>
                     <?php echo form_error('how_much_sell'); ?>
                  </div>
                  <div class="clearfix"></div>
                  <div class="col-md-6 form-group">
                     <label class="">Do you sell in other websites ?</label>
                     <div class="radio-input">
                        <input class="sell_in_otherwebsite" id="yes" <?php if(!empty($seller_interview)){ if($seller_interview->sell_in_otherwebsite=='Yes'){ echo "checked"; } } ?> type="radio" name="sell_in_otherwebsite" value="Yes">
                        <label for="yes">Yes</label>
                        &nbsp;&nbsp;
                        <input class="sell_in_otherwebsite" id="no" <?php if(!empty($seller_interview)){ if($seller_interview->sell_in_otherwebsite=='No'){ echo "checked"; } }else{ echo "checked"; } ?> type="radio" name="sell_in_otherwebsite" value="No" data-bvalidator="">
                        <label for="no">No</label>
                     </div>
                     <?php echo form_error('sell_in_otherwebsite'); ?>
                  </div>
                  <div class="col-md-6 OWebURL form-group">
                     <label class="">Website URL <span class="mandatory">*</span></label>
                     <input type="text" class="form-control" data-bvalidator="url,required" name="sell_in_otherwebsite_url" value="<?php if(set_value('sell_in_otherwebsite_url')){ echo set_value('sell_in_otherwebsite_url'); }else if(!empty($seller_interview)){ echo $seller_interview->sell_in_otherwebsite_url; } ?>" placeholder="http://www.example.com">
                  </div>
                  <div class="clearfix"></div>
                  <!-- Button -->
                  <div class="col-sm-12 controls">
                     <button class="btn btn-red btn-continue"><span><?php if(!empty($seller_interview)) echo "Continue"; else echo "Continue"; ?></span></button>
                     <?php
                        $skipped_pages = 0;
                        if(!empty($sellerInfo->skipped)){
                           $skipped = json_decode($sellerInfo->skipped);
                           $skipped_pages = count($skipped->skipped_pages);
                        }
                     ?>
                     <?php if($skipped_pages < 7){ ?>
                      <a class="btn btn-skip" href="<?php echo base_url('seller/skip/shipment_option/'.$encrypted_id); ?>">Remind me later</a>
                     <?php }else{ ?>
                      <a class="btn btn-default-white" href="<?php echo base_url('seller/seller_information/'.base64_encode(seller_id())); ?>">Back</a>
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

<div class="modal fade" id="subcategory_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
<div class="modal-dialog" role="document">
   <div class="modal-content support-ticket-modal comman-modal">
      <div class="modal-header comman-header-modal">
         <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
         <span aria-hidden="true"><img src="<?php echo SELLER_THEME_URL; ?>/img/Icon_Basic_Close.svg" width="18"></span>
         </button>
         <h4 class="modal-title text-center" id="myModalLabel">Create Subcategory</h4>
      </div>
      <div class="modal-body comman-body-modal">
         <form role="form" action="<?php echo base_url('seller/create_subcategory'); ?>" method="post" id="createSubcategoryForm">
            <div class="form-body contact-support-form ">
               <div class="col-md-12">
                  <div class="row">
                     <div class="form-group col-md-12 col-sm-12">   
                        <label>Subcategory Name <span class="mandatory">*</span></label>   
                        <input type="text" class="form-control text-capitalize" name="category_name" id="" placeholder="Name Of Subcategory" value="<?php echo set_value('category_name'); ?>" data-bvalidator="required">
                        <?php echo form_error('category_name') ?>
                     </div>
                     <div class="form-group col-md-12 col-sm-12">   
                        <label>Choose Category <span class="mandatory">*</span></label>   
                        <select placeholder="Choose category" class="form-control" name="parent_id" data-bvalidator="required">
                          <option value="">--Select--</option>
                          <?php if(!empty($categories)){ foreach ($categories as $row) { ?>
                          <option value="<?php echo $row->category_id; ?>"><?php echo $row->category_name; ?></option>
                          <?php } } ?>
                       </select>
                       <?php echo form_error('parent_id'); ?>
                     </div>
                     <div class="form-group col-md-12 col-sm-12">      
                        <label>Short Description <span class="mandatory">*</span></label>
                        <textarea name="short_description" class="form-control tooltips" rel="tooltip" data-placement="top right" rows="6" placeholder="Subcategory Description (Maxlength 160 characters)" maxlength="500" data-bvalidator="required,maxlen[500]"><?php echo set_value('short_description'); ?></textarea>
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

<script>

   SITE_URL = "<?php echo base_url(); ?>";
   $(document).ready(function(){
      $('#createSubcategoryForm').bValidator();
      $('#seller_interview').bValidator();
   });

   var sell_in_otherwebsiteLoad = "<?php if(!empty($seller_interview)){ echo $seller_interview->sell_in_otherwebsite; } ?>";
   if(sell_in_otherwebsiteLoad=="Yes"){
      $('.OWebURL').show();
   }else{
      $('.OWebURL').hide();
   }


   $("input[name='sell_in_otherwebsite']").change(function(){
        var sell_in_otherwebsite = $(this).val();
        if(sell_in_otherwebsite=="Yes"){
         $('.OWebURL').show();
        }else{
         $('.OWebURL').hide();
        }
   });

</script>