<div class="body-container clearfix">
<div class="bread_parent">
  <ul class="breadcrumb">
    <li><a href="<?php echo base_url('seller/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
    <li><a href="<?php echo base_url('seller/products/index'); ?>">Products</a></li>
    <li><b>Product Description</b></li>
  </ul>
  <div class="clearfix"></div>
</div>

<div class="theme-container clearfix">
  <div class="clearfix"></div>
  <div class="col-md-12 col-lg-12">
    <div class="common-tab-wrapper">
      <div class="common-tab-system partners clearfix">
        <?php $this->load->view('seller/products/tabMenus'); ?>
   
          <?php
            if(!empty($product_info_id) && !empty($product_variation_id)){
              if($product_variationsData->type_of_product==2){
                $showForm = 0;
              }else{
                $showForm = 1;
              }
            }else if(!empty($product_info_id)){
              $showForm = 1;
            }
          ?>
      </div>
      <div class="clearfix"></div>
      <div class="common-contain-wrapper clearfix">
        <div class="">
          <div class="">
            <div class="">
              <div class="common-panel panel">
                <div class="panel-heading">
                  <div class="panel-title"><i class="icofont icofont-list"></i> Product Description Information <?php if(!empty($product_info->title)) echo ' - "'.ucfirst($product_info->title).'"'; ?></div>
                  <div class="category-breadcrum">
                    <?php
                      $category=explode(',',$product_info->category_id);
                      $bread=get_category_bread_crumb_seller($category[sizeof($category)-1]);
                         if(!empty($bread))
                          {
                            $bread=array_reverse($bread);
                            echo implode(' / ',$bread);
                         
                          } 
                      ?>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="col-sm-8 center-block">
                    <?php if($showForm==1){ ?>
                    <form role="form" autocomplete="off" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post" data-bvalidator-validate>
                      <?php echo $this->session->flashdata('msg_error');?>

                      <div class="form-group">
                        <label class="col-md-4 control-label">Product Description<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Write the product description in brief"></span> :</label>
                        <div class="col-md-8">
                          <textarea data-bvalidator="required" placeholder="Product Description" class="form-control tinymce_edittor" rows="5" cols="10" name="description" ><?php if(set_value('description')) echo set_value('description'); else echo $product_info->description; ?></textarea>
                            <span class="error"><?php echo form_error('description'); ?> </span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-4 control-label">Key Product Features <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the Key Features of your product. Input should be an alphanumeric string; 500 characters maximum length."></span> :</label>
                        <div class="col-md-8">
                          <textarea placeholder="Key Product Features" data-bvalidator="alphanum,maxlen[500]" class="form-control tinymce_edittor" rows="5" cols="10" name="key_product_feature" ><?php if(set_value('key_product_feature')) echo set_value('key_product_feature'); else echo $product_info->key_product_feature; ?></textarea>
                            <span class="error"><?php echo form_error('key_product_feature'); ?> </span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-4 control-label">Legal Disclaimer <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the Legal Disclaimer. Input should be an alphanumeric string; 500 characters maximum length."></span> :</label>
                        <div class="col-md-8">
                          <textarea placeholder="Legal Disclaimer" data-bvalidator="alphanum,maxlen[500]" class="form-control tinymce_edittor" rows="5" cols="10" name="legal_disclaimer" ><?php if(set_value('legal_disclaimer')) echo set_value('legal_disclaimer'); else echo $product_info->legal_disclaimer; ?></textarea>
                            <span class="error"><?php echo form_error('legal_disclaimer'); ?> </span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-4 control-label">Return/Replacement Policy<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="You need to choose your product return/replacement policy"></span> :</label>
                        <div class="checkbox-input col-md-8">
                          <span class="radio-input">
                            <input id="returnpolicy_yes" class="accepted_returnpolicy" type="radio" name="accepted_returnpolicy" value="1" <?php if($product_info->accepted_returnpolicy==1){ echo "checked"; } ?>>
                            <label for="returnpolicy_yes">Yes</label>
                          </span>
                          &nbsp;&nbsp;&nbsp;&nbsp;
                          <span class="radio-input">
                            <input id="returnpolicy_no" class="accepted_returnpolicy" type="radio" name="accepted_returnpolicy" value="2" data-bvalidator="required" data-bvalidator-msg="You need to choose return/replacement policy" <?php if($product_info->accepted_returnpolicy==2){ echo "checked"; } ?>>
                            <label for="returnpolicy_no">No</label>
                          </span>
                          <span class="error"><?php echo form_error('accepted_returnpolicy'); ?> </span>
                        </div>
                      </div>

                      <div class="returnDaysDesc" style="display: <?php if($product_info->accepted_returnpolicy==1) echo "block"; else echo "none"; ?>">
                        <div class="form-group">
                          <label class="col-md-4 control-label">Maximum days<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="please enter maximum days of return/replacement policy"></span> :</label>
                          <div class="col-md-8">
                            <input type="number" min="1" max="100" placeholder="Please enter maximum days of return policy" class="form-control" name="return_policydays" value="<?php if($product_info->return_policydays==0) echo ''; else echo $product_info->return_policydays; ?>" data-bvalidator="number,required"> <span class="error"><?php echo form_error('return_policydays'); ?> </span>
                          </div>
                        </div>

                        <div class="form-group">
                          <label class="col-md-4 control-label">Description Of Return/Replacement Policy<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="please enter the description of return/replacement policy"></span> :</label>
                          <div class="col-md-8">
                            <textarea placeholder="please enter the description of return/replacement policy" data-bvalidator="alphanum,maxlen[500]" class="form-control" rows="5" cols="10" name="returnpolicy_description" ><?php if(set_value('returnpolicy_description')) echo set_value('returnpolicy_description'); else echo $product_info->returnpolicy_description; ?></textarea>
                            <span class="error"><?php echo form_error('returnpolicy_description'); ?> </span>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4"></div>
                      <div class="col-md-8">
                        <div class="form-actiosns form-btn-block text-center">
                          <button  class="btn btn-red" type="submit">Continue</button>
                          <?php if($type==1){ ?>
                          <a class="btn btn-default-white" href="<?php echo base_url('seller/products/product_images/'.$product_info_id.'/'.$product_variation_id.'/'.$type)?>">Back</a>
                          <?php }else if($product_variation_id==0 && $type==2){ ?>
                          <a class="btn btn-default-white" href="<?php echo base_url('seller/products/product_other_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type)?>">Back</a>
                          <?php } ?>
                        </div>
                      </div>
                    </form>
                    <!-- END FORM--> 
                    <?php }else{ ?>
                      <div class="col-md-12 text-center">
                        <h4><b><i class="fa fa-info-circle" aria-hidden="true"></i> We have not permitted you to edit the Product Description Information</b></h4>
                      </div>
                    <?php } ?>
                  </div>
                </div>
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
  $(document).ready(function(){
    $('form').bValidator();
  });

  $('.accepted_returnpolicy').on('change', function() {
      if(this.value==1){
        $(".returnDaysDesc").show();
      }else if(this.value==2){
        $(".returnDaysDesc").hide();
      }else{
        $(".returnDaysDesc").hide();
      }
  });

</script>