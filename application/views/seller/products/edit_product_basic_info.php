<div class="body-container clearfix">
<div class="bread_parent">
  <ul class="breadcrumb">
      <li><a href="<?php echo base_url('seller/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
      <li><a href="<?php echo base_url('seller/products/index'); ?>">Products</a></li>
      <li><b>Edit Product Vital Info</b></li>
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
         }
         else{
            $showForm = 1;
         }
         }
         else if(!empty($product_info_id)){
            $showForm = 1;
         }
      ?>
      </div>
      <div class="clearfix"></div>
      <div class="common-contain-wrapper clearfix" id="load_div">
        <div class="">
          <div class="">
            <div class="">
              <div class="common-panel panel">
                <div class="panel-heading">
                  <div class="panel-title"><i class="icofont icofont-info-square"></i> Product Basic Information <?php if(!empty($product_info->title)) echo ' - "'.ucfirst($product_info->title).'"'; ?></div>
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
                  <?php if($showForm==1){ ?>

                  <?php if($type==3){ ?>
                    <div class="highlight-info-box">
                      <h4 class="color-red">There are two types of product that is mentioned below -</h4>
                      <ul>
                         <li>
                           <b>Single Product</b> - If you select the product type as single, then the section of <b>Variation</b> will be hided and product will be added as single.
                         </li>
                         <li>
                          <b>Variation Product</b> - If you select the product type as variation, then the sections of <b>Offer</b> and <b>Images</b> will be hided because you must have to select the image for each variation individually.
                         </li>
                      </ul>
                    </div><br>
                  <?php } ?>

                  <div class="col-sm-8 center-block">
                     <form role="form" autocomplete="off" class="form-horizontal tasi-form" action="<?php echo current_url(); ?>" enctype="multipart/form-data" method="post" data-bvalidator-validate>   
                        <div class="form-group">
                           <label class="col-md-4 control-label">Product Title<span class="mandatory">*</span>
                              <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Please enter the suitable product title for your product. (maximum 250 characters)"></span> :
                           </label>
                           <div class="col-md-8">
                              <input type="text" maxlength="250" placeholder="Example: Blue Washed Slim Fit Jeans" class="form-control" name="title" value="<?php if(set_value('title')) echo set_value('title'); else echo ucfirst($product_info->title); ?>" data-bvalidator="required"> <span class="error"><?php echo form_error('title'); ?> </span>
                           </div>
                        </div>

                        <?php if($type==3){ ?>
                        <div class="form-group">
                           <label class="col-md-4 control-label">Choose Product Type<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Please select the type of your product."></span> :</label>
                           <div class="col-md-8">
                              <select name="chooseProductType" id="chooseProductType" class="form-control" data-bvalidator="required">
                                 <option value="">--Select--</option>
                                 <option value="1">Single Product</option>
                                 <option value="2">Variation Product</option>
                              </select>
                           </div>
                        </div>
                        <?php } ?>

                        <div class="form-group">
                           <label class="col-md-4 control-label">Choose Brand Name <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Need to select Product Brand"></span> :
                           </label>
                           <div class="col-md-8">
                              <select class="form-control chosen-select" name="brand_name">
                                 <option value="">--Select Brand--</option>
                                 <?php
                                 if(!empty($brand_info)){
                                 foreach ($brand_info as $row) {
                                 ?>
                                 <option <?php if($row->brand_name==$product_info->brand_name) echo "selected"; ?> value="<?php echo $row->brand_name; ?>"><?php echo ucfirst($row->brand_name); ?></option>
                                 <?php } }
                                 ?>
                              </select>
                              <div class="brand-contact-info">If your product's brand is not available in the list, then   <a class="link-text" href="javascript:;"  data-toggle="modal" data-target="#brandModal">Create New Brand</a></div>
                           </div>
                        </div>
                        
                        <div class="form-group">
                           <label class="col-md-4 control-label">Manufacturer Part Number
                              <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Please enter the Manufacturer Part Number. (maximum 40 characters)"></span> :
                           </label>
                           <div class="col-md-8">
                              <input type="text" maxlength="40" placeholder="Example: AM-007" class="form-control" name="manufacturer_part_number" value="<?php if(set_value('manufacturer_part_number')) echo set_value('manufacturer_part_number'); else echo ucfirst($product_info->manufacturer_part_number); ?>"> 
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="col-md-4 control-label">Short Description
                              <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Write the description about your product (maximum 1000 characters)."></span> :
                           </label>
                           <div class="col-md-8">
                              <input type="text" maxlength="1000" placeholder="Example: Hit the streets in style wearing these jeans by Moda Rapido." class="form-control" name="short_description" value="<?php if(set_value('short_description')) echo set_value('short_description'); else echo $product_info->short_description; ?>" >
                           </div>
                        </div>
                        

                        <div class="productAttr" style="display: none;">
                        <?php
                           if($type==1 || $type==3){
                           $json_product_variation_info = array();
                           $product_variation_info = product_variation_info($product_info_id);
                           if(!empty($product_variation_info)){
                              $json_product_variation_info = json_decode($product_variation_info->product_variation_info);
                           }
                           $getbasic_info=json_decode($product_info->product_basic_info);
                           if(!empty($attribute_info)){
                           foreach($attribute_info as $row){
                           if (!array_key_exists($row->attribute_code,$json_product_variation_info)){
                           $attr_code = $row->attribute_code;
                        ?>
                        <div class="form-group">
                           <label class="col-md-4 control-label"><?php echo ucfirst($row->name); if($row->is_required_only){  ?><span class="mandatory">*</span><?php } if($row->tooltip_content){ ?>   <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="<?php echo $row->tooltip_content; ?>"></span> :<?php } ?>
                           </label>
                           <div class="col-md-8">
                              <?php if($row->file_type==1){ ?>
                              <input type="text" maxlength="500" placeholder="<?php echo ucfirst($row->placeholder_content);  ?>" class="form-control" name="basic_info[<?php echo $row->attribute_code; ?>]" value="<?php if(!empty($getbasic_info) && !empty($getbasic_info->$attr_code)) echo $getbasic_info->$attr_code; else echo $row->default_value; ?>" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo ' data-bvalidator="required"'; ?> >
                              <?php }else if($row->file_type==2){ ?>
                              <textarea class="form-control" maxlength="1000" placeholder="<?php echo ucfirst($row->placeholder_content);  ?>" name="basic_info[<?php echo $row->attribute_code; ?>]" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo ' data-bvalidator="required"'; ?> ><?php if(!empty($getbasic_info) && !empty($getbasic_info->$attr_code)) echo $getbasic_info->$attr_code; else echo $row->default_value; ?></textarea>
                              <?php }else if($row->file_type==3){ ?>
                              <select class="form-control chosen-select" name="basic_info[<?php echo $row->attribute_code; ?>]" <?php if($row->is_required_only) echo ' data-bvalidator="required"'; ?>>
                                 <option value="">--Select--</option>
                                 <?php if(!empty(json_decode($row->attribute_value))){
                                 foreach (json_decode($row->attribute_value) as $key) {
                                 ?>
                                 <option <?php if(!empty($getbasic_info->$attr_code) && $getbasic_info->$attr_code==$key) echo "selected"; ?> value="<?php echo $key; ?>"><?php echo $key; ?></option>
                                 <?php } } ?>
                              </select>
                              
                              <?php }else if($row->file_type==4){ ?>
                              
                              <?php if(!empty(json_decode($row->attribute_value))){
                              foreach (json_decode($row->attribute_value) as $key) {
                              ?>
                              <input type="checkbox" class="" name="basic_info[<?php echo $row->attribute_code; ?>][]"
                              <?php if(!empty($getbasic_info) && !empty($getbasic_info->$attr_code) && in_array($key,$getbasic_info->$attr_code)) echo 'checked';  ?>  value="<?php echo $key; ?>" <?php if($row->is_required_only) echo ' data-bvalidator="required"'; ?>>&nbsp;&nbsp;<?php echo $key; ?>
                              <?php } } ?>
                              <?php }else if($row->file_type==5){ ?>
                              
                              <select class="form-control chosen-select" name="basic_info[<?php echo $row->attribute_code; ?>][]" <?php if($row->is_required_only) echo " required"; ?> multiple>
                                 <option value="">--Select--</option>
                                 <?php if(!empty(json_decode($row->attribute_value))){
                                 foreach (json_decode($row->attribute_value) as $key) {
                                 ?>
                                 <option value="<?php echo $key; ?>" <?php if(!empty($getbasic_info) && !empty($getbasic_info->$attr_code) && in_array($key,$getbasic_info->$attr_code)) echo 'selected';  ?>   ><?php echo $key; ?></option>
                                 <?php } } ?>
                              </select>
                              <?php }else if($row->file_type==6){ ?>
                              <?php if(!empty($getbasic_info) && !empty($getbasic_info->$attr_code)){ ?>
                              <?php } ?>
                              <input type="file" class="form-control" name="basic_info[<?php echo $row->attribute_code; ?>]" value="<?php echo $row->default_value; ?>" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo ' data-bvalidator="extension[jpg:png:gif:jpeg],required"'; ?> >
                              <?php }else if($row->file_type==7){ ?>
                              <?php
                              $indexing = 1;
                              if(!empty(json_decode($row->attribute_value))){
                              foreach (json_decode($row->attribute_value) as $key) {
                              ?>
                              <input size="16" type="radio" value="<?php echo $row->default_value; ?>" name="basic_info[<?php echo $row->attribute_code; ?>]" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo ' data-bvalidator="required"'; if(!empty($getbasic_info) && !empty($getbasic_info->$attr_code)){ if($key==$getbasic_info->$attr_code){ echo "checked"; } }else{ if($indexing==1){ echo "checked"; } } ?>>&nbsp;&nbsp;<?php echo $key; ?>
                              <?php $indexing++; } } ?>
                              <?php }else if($row->file_type==8){ ?>
                              <input size="16" type="text" maxlength="50" placeholder="<?php echo ucfirst($row->placeholder_content);  ?>" value="<?php if(!empty($getbasic_info) && !empty($getbasic_info->$attr_code)) echo $getbasic_info->$attr_code; else echo $row->default_value; ?>" class="default_date form-control date" name="basic_info[<?php echo $row->attribute_code; ?>]" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo ' data-bvalidator="date[dd-mm-yyyy],required"'; ?>>
                              <?php }else if($row->file_type==9){ 
                                $attr_code1 = $attr_code.'-9';
                              ?>
                              
                              <input type="text" maxlength="500" placeholder="<?php echo ucfirst($row->placeholder_content);  ?>" class="form-control" name="basic_info[<?php echo $row->attribute_code.'-9' ; ?>]" value="<?php if(!empty($getbasic_info) && !empty($getbasic_info->$attr_code1)) echo $getbasic_info->$attr_code1; else echo $row->default_value; ?>" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo ' data-bvalidator="required"'; ?> >
                              <select class="form-control chosen-select" name="basic_info[<?php echo $row->attribute_code; ?>]">
                                 <option value="">--Select--</option>
                                 <?php if(!empty(json_decode($row->attribute_value))){
                                 foreach (json_decode($row->attribute_value) as $key) {
                                 ?>
                                 <option <?php if(!empty($getbasic_info->$attr_code) && $getbasic_info->$attr_code==$key) echo "selected"; ?> value="<?php echo $key; ?>"><?php echo $key; ?></option>
                                 <?php } } ?>
                              </select>
                              
                              <?php }else if($row->file_type==10){ ?>
                              
                              <input type="text" maxlength="500" placeholder="<?php echo ucfirst($row->placeholder_content);  ?>" main="<?php echo $row->attribute_code ; ?>" class="form-control typeahead" name="basic_info[<?php echo $row->attribute_code ; ?>]" value="<?php if(!empty($getbasic_info) && !empty($getbasic_info->$attr_code)) echo $getbasic_info->$attr_code; else echo $row->default_value; ?>" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo ' data-bvalidator="required"'; ?> >
                              
                              <?php } ?>
                              <span class="error"><?php echo form_error('basic_info['.$row->attribute_code.']'); ?> </span>
                           </div>
                        </div>
                        <?php } } } } ?>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-8">
                          <div class="form-actiosns form-btn-block text-center">
                            <button  class="btn btn-red" type="submit">Continue</button>
                            <a class="btn btn-default-white" href="<?php echo base_url('seller/products/edit_product_category/'.$product_info_id.'/'.$product_variation_id.'/'.$type); ?>">Back</a>
                          </div>
                      </div>
                     </form>
                     <!-- END FORM-->
                     <?php }else{ ?>
                     <div class="col-md-12 text-center">
                        <h4><b><i class="fa fa-info-circle" aria-hidden="true"></i> We have not permitted you to edit the Product Basic Information</b></h4>
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

<div class="modal fade" id="brandModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content support-ticket-modal comman-modal">
         <div class="modal-header comman-header-modal">
            <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><img src="<?php echo SELLER_THEME_URL; ?>/img/Icon_Basic_Close.svg" width="18"></span>
            </button>
            <h4 class="modal-title text-center" id="myModalLabel">Add Brand</h4>
         </div>
         <div class="modal-body comman-body-modal">
            <form role="form" action="<?php echo base_url('seller/products/add_brand'); ?>" enctype="multipart/form-data" method="post" id="createbrandform">
               <div class="form-body contact-support-form ">
                  <div class="col-md-12">
                     <div class="row">

                        <div class="form-group col-md-12 col-sm-12">
                           <label>Brand Name <span class="mandatory">*</span></label>
                           <input type="text" class="form-control text-capitalize" name="brand_name" id="brand_name" placeholder="Brand Name" value="<?php echo set_value('brand_name'); ?>" data-bvalidator="required">
                           <?php echo form_error('brand_name') ?>
                            <span class="error" id="brand_error"></span>
                        </div>

                        <div class="form-group col-md-12 col-sm-12">
                           <label>Category <span class="mandatory">*</span></label>
                           <select data-placeholder="Choose categories" id="category_id" class="form-control chosen-select" name="category_id[]" data-bvalidator="required" multiple>
                           <?php  if(!empty($brand_category)){
                                         foreach ($brand_category as  $value) { ?>

                                           <option value="<?=$value->category_id?>">
                                            <?php if($value->parent_id<>0){
                                               echo '&ensp;&ensp;';
                                                  } 
                                               echo $value->category_name;
                                             ?>
                                           </option>
                          
                                <?php     }

                                       } ?>

                   
                           </select>
                           <?php echo form_error('category_id[]'); ?>
                        </div>
                        

                        <div class="form-group img-choozen brand-img-upload col-md-12 col-sm-12">
                          <label>Upload Brand Image <span class="mandatory">*</span></label>
                          <div class="brand-contact-info"><b>Note - </b>Brand image needs to be atleast of 100 X 50 pixels and at most of 300 X 100 pixels and accept only jpg, jpeg, png, svg</div><br>
                          <div class="image-upload-box">
                             <div class="image-upload-preview">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                   <div class="fileinput-preview thumbnail" data-trigger="fileinput"><input type="file" class="imgUpload" name="brand_image" data-bvalidator="extension[jpg:png:jpeg:svg],required" data-bvalidator-msg="choose an image file and <br> the accepted file type is jpg, jpeg, png" name="image[]"><img class="upload-default-image" id="upload-default-image" src="<?=base_url('assets/seller/img/default-upload-image.png')?>" data-src="holder.js/100%x100%" alt="..."></div>
                                </div>
                             </div>
                          </div>
                          <span class="error" id="image_error"></span>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-md-12 col-sm-12 text-center">
                           <button type="submit" class="btn btn-lg btn-red contact-submit">Add Brand</button>
                        </div>
                        <div class="clearfix"></div>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
            </form>
            </div>
         </div>
      </div>
   </div>
   <!-- end add brand modal -->



<script src="<?php echo BACKEND_THEME_URL ?>js/bootstrap3-typeahead.min.js"></script>
<script type="text/javascript">
   $('input.typeahead').typeahead({
      minLength: 0,
      maxItem: 15,
      order: "asc",
      hint: true,
      accent: true,
      searchOnFocus: true,
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

      $('#chooseProductType').on('change', function() {
          window.sessionStorage.setItem("chooseProductType", this.value);
          if(this.value==1){
            $(".productAttr").show();
          }else if(this.value==2){
            $(".productAttr").hide();
          }else{
            $(".productAttr").hide();
          }
      });

      if(window.sessionStorage.getItem("chooseProductType")){
        if(window.sessionStorage.getItem("chooseProductType")==1){
          $(".productAttr").show();
          $('#chooseProductType').val(window.sessionStorage.getItem("chooseProductType"));
        }else if(window.sessionStorage.getItem("chooseProductType")==2){
          $(".productAttr").hide();
          $('#chooseProductType').val(window.sessionStorage.getItem("chooseProductType"));
        }else{
          $(".productAttr").hide();
        }
      }

   });




  function readURL(input) {

      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $(".fileinput-preview p").text('');
          $(input).closest('.image-upload-preview').find('.upload-default-image').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    $(".img-choozen").on('change', ".imgUpload", function() {
      readURL(this);
    });
   
      $('.btn-close-modal').click(function(e){
         $('#image_error').html('');
         $('#brand_error').html('');
        }
      );

    $(document).ready(function (e) {
      $('#createbrandform').on('submit', function(e){
          $('#image_error').html('');
         $('#brand_error').html('');
          e.preventDefault();
          var formData = new FormData(this);
          $.ajax({
              type:'POST',
              url: $(this).attr('action'),
              data:formData,
              cache:false,
              contentType: false,
              processData: false,
              success:function(data){
          
                  data = $.parseJSON(data);
                  if(data.status=='success'){
                    $.getScript("<?php echo BACKEND_THEME_URL ?>js/bootstrap3-typeahead.min.js; ?>");
                    $('#brandModal').modal('hide');
                     $('#brand_name').val('');
                   $('select#category_id option').removeAttr("selected");
                    $('#image_error').html('');
                    $('.chosen-choices').html('');
                   $('#upload-default-image').attr('src','<?=base_url()?>/assets/seller/img/default-upload-image.png');
                    // $('.theme-container').load('<?php echo current_url() ?> #load_div');
                     location.reload();

                  
                  }else{
                 if(data.msg=='brand-error'){
                           $('#brand_error').html('The Brand Name already Exist');
                        }
                        else {
                        $('#image_error').html(data.msg);
                           }
                  }
              }  
          });
      });
    });


</script>