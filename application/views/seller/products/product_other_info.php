<div class="body-container clearfix">
<div class="bread_parent">
  <ul class="breadcrumb">
    <li><a href="<?php echo base_url('seller/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
    <li><a href="<?php echo base_url('seller/products/index'); ?>">Products</a></li>
    <li><b>Product Other Info</b></li>
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
                  <div class="panel-title"><i class="icofont icofont-presentation-alt"></i>  Product Other Information <?php if(!empty($product_info->title)) echo ' - "'.ucfirst($product_info->title).'"'; ?></div>
                  <div class="category-breadcrum">
                    <?php
                      $category=explode(',',$product_info->category_id);
                      $bread=get_category_bread_crumb_seller($category[sizeof($category)-1]);
                        if(!empty($bread)){
                          $bread=array_reverse($bread);
                          echo implode(' / ',$bread);
                        } 
                    ?>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="col-sm-8 center-block">
                    <?php if($showForm==1){ ?>
                    <form autocomplete="off" role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post" data-bvalidator-validate>
                      <?php echo $this->session->flashdata('msg_error');?>
                      <?php 
                        if(!empty($attribute_info)){
                           $getOther_info=json_decode($product_info->product_other_info);
                           foreach($attribute_info as $row){
                              $attr_code = $row->attribute_code;
                      ?> 
                      <div class="form-group">
                           <label class="col-md-4 control-label"><?php echo ucfirst($row->name); if($row->is_required_only){  ?><span class="mandatory">*</span><?php } if($row->tooltip_content){ ?>   <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="<?php echo $row->tooltip_content; ?>"></span> <?php } ?> :
                        </label>
                        <div class="col-md-8">
                           <?php if($row->file_type==1){ ?>
                           <div class="">
                              <input type="text" maxlength="500" placeholder="<?php echo ucfirst($row->placeholder_content);  ?>" class="form-control" name="other_info[<?php echo $row->attribute_code; ?>]" value="<?php if(!empty($getOther_info) && !empty($getOther_info->$attr_code)) echo $getOther_info->$attr_code; else echo $row->default_value; ?>" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo 'data-bvalidator="required"'; ?> >
                           </div>
                           <?php }else if($row->file_type==2){ ?>
                           <div class="">
                              <textarea class="form-control" maxlength="1000" placeholder="<?php echo ucfirst($row->placeholder_content);  ?>" name="other_info[<?php echo $row->attribute_code; ?>]" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo 'data-bvalidator="required"'; ?> ><?php if(!empty($getOther_info) && !empty($getOther_info->$attr_code)) echo $getOther_info->$attr_code; else echo $row->default_value; ?></textarea>
                           </div>
                           <?php }else if($row->file_type==3){ ?>
                           <div class="">
                              <select class="form-control chosen-select" name="other_info[<?php echo $row->attribute_code; ?>]" <?php if($row->is_required_only) echo 'data-bvalidator="required"'; ?>>
                                 <option value="">--Select--</option>
                                 <?php if(!empty(json_decode($row->attribute_value))){
                                 foreach (json_decode($row->attribute_value) as $key) {
                                 ?>
                                 <option <?php if(!empty($getOther_info->$attr_code) && $getOther_info->$attr_code==$key) echo "selected"; ?> value="<?php echo $key; ?>"><?php echo $key; ?></option>
                                 <?php } } ?>
                              </select>
                           </div>
                           <?php }else if($row->file_type==4){ ?>
                           <div class="">
                              <?php if(!empty(json_decode($row->attribute_value))){
                              foreach (json_decode($row->attribute_value) as $key) {
                              ?>
                              <input type="checkbox" class="" name="other_info[<?php echo $row->attribute_code; ?>][]"
                              <?php if(!empty($getOther_info) && !empty($getOther_info->$attr_code) && in_array($key,json_decode($row->attribute_value))) echo 'checked';  ?>  value="<?php echo $key; ?>" <?php if($row->is_required_only) echo 'data-bvalidator="required"'; ?>>&nbsp;&nbsp;<?php echo $key; ?>
                              <?php } } ?>
                           </div>
                           <?php }else if($row->file_type==5){
                           ?>
                           <div class="">
                              <select class="form-control chosen-select" name="other_info[<?php echo $row->attribute_code; ?>][]" <?php if($row->is_required_only) echo 'data-bvalidator="required"'; ?> multiple>
                                 <option value="">--Select--</option>
                                 <?php if(!empty(json_decode($row->attribute_value))){
                                 foreach (json_decode($row->attribute_value) as $key) {
                                 ?>
                                 <option value="<?php echo $key; ?>" <?php if(!empty($getOther_info) && !empty($getOther_info->$attr_code) && in_array($key,$getOther_info->$attr_code)) echo 'selected';  ?>   ><?php echo $key; ?></option>
                                 <?php } } ?>
                              </select>
                           </div>
                           <?php }else if($row->file_type==6){ ?>
                           <?php if(!empty($getOther_info) && !empty($getOther_info->$attr_code)){ ?>
                           <?php } ?>
                           <div class="">
                              <input type="file" class="form-control" name="other_info[<?php echo $row->attribute_code; ?>]" value="<?php echo $row->default_value; ?>" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo 'data-bvalidator="extension[jpg:png:gif:jpeg],required"'; ?> >
                           </div>
                           <?php }else if($row->file_type==7){ ?>
                           <div class="">
                              <?php
                              $indexing = 1;
                              if(!empty(json_decode($row->attribute_value))){
                              foreach (json_decode($row->attribute_value) as $key) {
                              ?>
                              <input size="16" type="radio" value="<?php echo $row->default_value; ?>" name="other_info[<?php echo $row->attribute_code; ?>]" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo 'data-bvalidator="required"'; if(!empty($getOther_info) && !empty($getOther_info->$attr_code)){ if($key==$getOther_info->$attr_code){ echo "checked"; } }else{ if($indexing==1){ echo "checked"; } } ?>>&nbsp;&nbsp;<?php echo $key; ?>
                              <?php $indexing++; } } ?>
                           </div>
                           <?php }else if($row->file_type==8){ ?>
                           <div class="">
                              <input size="16" maxlength="500" type="text" placeholder="<?php echo ucfirst($row->placeholder_content);  ?>" value="<?php if(!empty($getOther_info) && !empty($getOther_info->$attr_code)) echo $getOther_info->$attr_code; else echo $row->default_value; ?>" class="default_date form-control date" name="other_info[<?php echo $row->attribute_code; ?>]" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo 'data-bvalidator="date[dd-mm-yyyy],required"'; ?>>
                           </div>
                           <?php }else if($row->file_type==9){ 
                            $attr_code1 = $attr_code.'-9';
                           ?>
                           <div class="col-md-8">
                              <input type="text" maxlength="500" placeholder="<?php echo ucfirst($row->placeholder_content);  ?>" class="form-control" name="other_info[<?php echo $row->attribute_code.'-9' ; ?>]" value="<?php if(!empty($getOther_info) && !empty($getOther_info->$attr_code1)) echo $getOther_info->$attr_code1; else echo $row->default_value; ?>" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo "required"; ?> >
                           </div>
                           <div class="col-md-4">
                              <select class="form-control chosen-select" name="other_info[<?php echo $row->attribute_code; ?>]" <?php if($row->is_required_only) echo "required"; ?>>
                                 <option value="">--Select--</option>
                                 <?php if(!empty(json_decode($row->attribute_value))){
                                 foreach (json_decode($row->attribute_value) as $key) {
                                 ?>
                                 <option <?php if(!empty($getOther_info->$attr_code) && $getOther_info->$attr_code==$key) echo "selected"; ?> value="<?php echo $key; ?>"><?php echo $key; ?></option>
                                 <?php } } ?>
                              </select>
                           </div>
                           <?php }else if($row->file_type==10){ ?>
                           <div class="">
                              <input type="text" maxlength="500" placeholder="<?php echo ucfirst($row->placeholder_content);  ?>" main="<?php echo $row->attribute_code ; ?>" class="form-control typeahead" name="other_info[<?php echo $row->attribute_code ; ?>]" value="<?php if(!empty($getOther_info) && !empty($getOther_info->$attr_code)) echo $getOther_info->$attr_code; else echo $row->default_value; ?>" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo "required"; ?> >
                           </div>
                           <?php } ?>
                           <span class="error"><?php echo form_error('other_info['.$row->attribute_code.']'); ?> </span>
                        </div>
                      </div>
                      <?php } ?>
                      <div class="col-md-4"></div>
                      <div class="col-md-8">
                        <div class="form-actiosns form-btn-block text-center">
                          <input class="btn btn-red submitProductOtherInfo" type="submit" name="submitProductOtherInfo" id="submitProductOtherInfo" value="Continue">
                          <?php if($type==1){ ?>
                          <a class="btn btn-default-white" href="<?php echo base_url('seller/products/product_offer/'.$product_info_id.'/'.$product_variation_id.'/'.$type)?>">Back</a>
                          <?php }else if($product_variation_id==0 && $type==2){ ?>
                          <a class="btn btn-default-white" href="<?php echo base_url('seller/products/product_variations/'.$product_info_id.'/'.$product_variation_id.'/'.$type)?>">Back</a>
                          <?php } ?>
                        </div>
                      </div>
                      <?php }else{ ?>
                        <div class="col-md-12 text-center">
                          <h4><b><i class="fa fa-info-circle" aria-hidden="true"></i> Product other information not required.</b></h4>
                          <?php if($product_variation_id==0 && $type==2){ ?>
                            <br><a class="btn btn-red" href="<?php echo base_url('seller/products/product_images/'.$product_info_id.'/'.$product_variation_id.'/'.$type)?>">Continue</a>
                          <?php }else if($type==1){ ?>
                            <br><a class="btn btn-red" href="<?php echo base_url('seller/products/product_images/'.$product_info_id.'/'.$product_variation_id.'/'.$type)?>">Continue</a>
                          <?php } ?>
                        </div>
                      <?php } ?>
                    </form>
                      <!-- END FORM--> 
                      <?php }else{ ?>
                        <div class="col-md-12 text-center">
                          <h4><b><i class="fa fa-info-circle" aria-hidden="true"></i> We have not permitted you to edit the Product Other Information</b></h4>
                          <?php if($product_variation_id==0 && $type==2){ ?>
                              <br><a class="btn btn-red" href="<?php echo base_url('seller/products/product_images/'.$product_info_id.'/'.$product_variation_id.'/'.$type)?>">Continue</a>
                            <?php }else if($type==1){ ?>
                              <br><a class="btn btn-red" href="<?php echo base_url('seller/products/product_images/'.$product_info_id.'/'.$product_variation_id.'/'.$type)?>">Continue</a>
                            <?php } ?>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script type="text/javascript">
   $('input.typeahead').typeahead({
       source:  function (query, process) {
         var attr=this.$element.attr('main');
         return $.get('<?php echo base_url(); ?>backend/common/autocomplete', { query: query,attribute_code:attr }, function (data) {
            data = $.parseJSON(data);
               return process(data);
           });
       }
   });

   $(document).ready(function(){
      $('form').bValidator();
   });
</script>