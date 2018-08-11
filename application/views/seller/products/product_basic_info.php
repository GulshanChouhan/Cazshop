<div class="body-container clearfix">
   <div class="bread_parent">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('seller/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
         <li><a href="<?php echo base_url('seller/products/index'); ?>">Products</a></li>
         <li><b>Add Product Vital Info</b></li>
      </ul>
      <div class="clearfix"></div>
   </div>
   <div class="theme-container clearfix">
      <div class="clearfix"></div>
      <div class="col-md-12 col-lg-12" id="load_div">
         <div class="common-tab-wrapper">
            <div class="common-tab-system partners clearfix">
               <ul class="nav-common-tabs" role="tablist">
                  <li <?php if($this->session->userdata('productcat_info')['status']==1) echo ""; else echo "class='disabled' style='pointer-events:none;'"; ?>>
                     <a href="<?php echo base_url().'seller/products/product_category' ?>">
                        <div><i class="icofont icofont-chart-flow-alt-2"></i></div>
                        Product Categories
                     </a>
                  </li>
                  <li class="active">
                     <a href="<?php echo base_url().'seller/products/product_basic_info'; ?>">
                        <div><i class="icofont icofont-info-square"></i></div>
                        Vital Info
                     </a>
                  </li>
                  <li class='disabled' style='pointer-events:none;'>
                     <a href="javascript:void(0)" >
                        <div><i class="icofont icofont-document-search"></i></div>
                        Variation
                     </a>
                  </li>
                  <li class='disabled' style='pointer-events:none;'>
                     <a href="javascript:void(0)" >
                        <div><i class="icofont icofont-gift"></i></div>
                        Product Definition/Offer
                     </a>
                  </li>
                  <li class='disabled' style='pointer-events:none;'>
                     <a href="javascript:void(0)" >
                        <div><i class="icofont icofont-presentation-alt"></i></div>
                        Compliance
                     </a>
                  </li>
                  <li class='disabled' style='pointer-events:none;'>
                     <a href="javascript:void(0)" >
                        <div><i class="icofont icofont-image"></i></div>
                        Images/Videos
                     </a>
                  </li>
                  <li class='disabled' style='pointer-events:none;'>
                     <a href="javascript:void(0)" >
                        <div><i class="icofont icofont-list"></i></div>
                        Product Description
                     </a>
                  </li>
                  <li class='disabled' style='pointer-events:none;'>
                     <a href="javascript:void(0)" >
                        <div><i class="icofont icofont-key"></i></div>
                        Keywords
                     </a>
                  </li>
                  <li class='disabled' style='pointer-events:none;'>
                     <a href="javascript:void(0)" >
                        <div>
                           <i class="icofont icofont-stock-search"></i>
                        </div>
                        Meta Information
                     </a>
                  </li>
               </ul>
            </div>
            <div class="clearfix"></div>
            <div class="common-contain-wrapper clearfix">
               <div class="">
                  <div class="">
                     <div class="">
                        <div class="common-panel panel">
                           <div class="panel-heading">
                              <div class="panel-title"><i class="icofont icofont-info-square"></i> Product Basic Information</div>
                           </div>
                           <div class="panel-body">
                              <div class="highlight-info-box">
                                 <h4 class="color-red">There are two types of product which are mentioned below -</h4>
                                 <ul>
                                    <li>
                                       <b>Single Product</b> - If you select the product type as single, then the section of <b>Variation</b> will be hided and product will be added as single.
                                    </li>
                                    <li>
                                       <b>Variation Product</b> - If you select the product type as variation, then the sections of <b>Offer</b> and <b>Images</b> will be hided because you must have to select the image for each variation individually.
                                    </li>
                                 </ul>
                              </div>
                              <br>
                              <div class="col-sm-8 center-block">
                                 <form role="form" id="brand_form" autocomplete="off" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post" data-bvalidator-validate>
                                    <?php echo $this->session->flashdata('msg_error');?>             
                                    <div class="form-group">
                                       <label class="col-md-4 control-label">Product Title<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Please enter the suitable product title for your product. (maximum 250 characters)"></span> :</label>
                                       <div class="col-md-8">
                                          <input type="text" maxlength="250" placeholder="Example: Blue Washed Slim Fit Jeans" class="form-control" name="title" value="<?php echo set_value('title');?>" data-bvalidator="required"> <span class="error"><?php echo form_error('title'); ?> </span>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-4 control-label">Product Type<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Please select the type of your product."></span> :</label>
                                       <div class="col-md-8">
                                          <select name="chooseProductType" id="chooseProductType" class="form-control" data-bvalidator="required">
                                             <option value="">--Select Type--</option>
                                             <option value="1">Single Product</option>
                                             <option value="2">Variation Product</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group" id="brand_box">
                                       <label class="col-md-4 control-label">Brand Name <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="auto"  data-original-title="Need to select Product Brand"></span> :</label> 
                                       <div class="col-md-8">
                                          <select class="form-control chosen-select" name="brand_name">
                                             <option value="">--Select Brand--</option>
                                             <?php 
                                                if(!empty($brand_info)){
                                                   foreach ($brand_info as $row) { 
                                                ?>
                                             <option value="<?php echo $row->brand_name; ?>"><?php echo ucfirst($row->brand_name); ?></option>
                                             <?php } }
                                                ?>
                                          </select>
                                          <div class="brand-contact-info">If your product's brand is not available in the list, then  <a href="javascript:;" class="link-text"  data-toggle="modal" data-target="#brandModal">Create New Brand</a></div>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-4 control-label">Manufacturer Part Number <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Please enter the Manufacturer Part Number. (maximum 40 characters)"></span> :</label>
                                       <div class="col-md-8">
                                          <input type="text" maxlength="40" placeholder="Example: AM-007" class="form-control" name="manufacturer_part_number" value="<?php if(set_value('manufacturer_part_number')) echo set_value('manufacturer_part_number'); ?>">
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-md-4 control-label">Short Description <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Write the description about your product (maximum 1000 characters)."></span> :</label>
                                       <div class="col-md-8">
                                          <input type="text" maxlength="1000" placeholder="Example: Hit the streets in style wearing these jeans by Moda Rapido." class="form-control" name="short_description" value="<?php echo set_value('short_description');?>" > 
                                       </div>
                                    </div>
                                    <div class="productAttr" style="display: none;">
                                       <?php 
                                          if(!empty($attribute_info)){
                                             foreach($attribute_info as $row){
                                          ?> 
                                       <div class="form-group">
                                          <label class="col-md-4 control-label"><?php echo ucfirst($row->name); if($row->is_required_only){  ?><span class="mandatory">*</span><?php } if($row->tooltip_content){ ?>   <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="<?php echo $row->tooltip_content; ?>"></span> <?php } ?> :</label>
                                          <div class="col-md-8">
                                             <?php if($row->file_type==1){ ?>
                                             <input type="text" maxlength="500" placeholder="<?php echo ucfirst($row->placeholder_content);  ?>" class="form-control" name="basic_info[<?php echo $row->attribute_code; ?>]" value="<?php echo $row->default_value; ?>" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo ' data-bvalidator="required"'; ?> >
                                             <?php }else if($row->file_type==2){ ?>
                                             <textarea class="form-control" maxlength="1000" placeholder="<?php echo ucfirst($row->placeholder_content);  ?>" name="basic_info[<?php echo $row->attribute_code; ?>]" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo ' data-bvalidator="required"'; ?> ><?php echo $row->default_value; ?></textarea>
                                             <?php }else if($row->file_type==3){ ?>
                                             <select class="form-control chosen-select" name="basic_info[<?php echo $row->attribute_code; ?>]" <?php if($row->is_required_only) echo ' data-bvalidator="required"'; ?>>
                                                <option value="">--Select--</option>
                                                <?php if(!empty(json_decode($row->attribute_value))){ 
                                                   foreach (json_decode($row->attribute_value) as $key) { 
                                                   ?>
                                                <option value="<?php echo $key; ?>"><?php echo $key; ?></option>
                                                <?php } } ?>
                                             </select>
                                             <?php }else if($row->file_type==4){ ?>
                                             <?php if(!empty(json_decode($row->attribute_value))){ 
                                                foreach (json_decode($row->attribute_value) as $key) { 
                                                ?>
                                             <input type="checkbox" class="" name="basic_info[<?php echo $row->attribute_code; ?>][]" value="<?php echo $row->default_value; ?>" <?php if($row->is_required_only) echo ' data-bvalidator="required"'; ?> >&nbsp;&nbsp;<?php echo $key; ?>
                                             <?php } } ?>
                                             <?php }else if($row->file_type==5){ ?>
                                             <select class="form-control chosen-select" name="basic_info[<?php echo $row->attribute_code; ?>][]" <?php if($row->is_required_only) echo ' data-bvalidator="required"'; ?> multiple>
                                                <option value="">--Select--</option>
                                                <?php if(!empty(json_decode($row->attribute_value))){ 
                                                   foreach (json_decode($row->attribute_value) as $key) { 
                                                   ?>
                                                <option value="<?php echo $key; ?>"><?php echo $key; ?></option>
                                                <?php } } ?>
                                             </select>
                                             <?php }else if($row->file_type==6){ ?>
                                             <input type="file" class="form-control" name="basic_info[<?php echo $row->attribute_code; ?>]" value="<?php echo $row->default_value; ?>" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo ' data-bvalidator="extension[jpg:png:gif:jpeg],required"'; ?> >
                                             <?php }else if($row->file_type==7){ ?>
                                             <?php 
                                                $indexing = 1;
                                                if(!empty(json_decode($row->attribute_value))){ 
                                                   foreach (json_decode($row->attribute_value) as $key) { 
                                                ?>
                                             <input size="16" type="radio" value="<?php echo $row->default_value; ?>" name="basic_info[<?php echo $row->attribute_code; ?>]" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo ' data-bvalidator="required"'; if($row->default_value!=''){ if($key==$row->default_value){ echo "checked";} }else{ if($indexing==1){ echo "checked"; } } ?>>&nbsp;&nbsp;<?php echo $key; ?>
                                             <?php $indexing++; } } ?>
                                             <?php }else if($row->file_type==8){ ?>
                                             <input size="16" type="text" maxlength="50" placeholder="<?php echo ucfirst($row->placeholder_content);  ?>" value="<?php echo $row->default_value; ?>" class="default_date form-control date" name="basic_info[<?php echo $row->attribute_code; ?>]" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo ' data-bvalidator="date[dd-mm-yyyy],required"'; ?>>
                                             <?php }else if($row->file_type==9){ 
                                                ?>
                                             <input type="text" maxlength="500" placeholder="<?php echo ucfirst($row->placeholder_content);  ?>" class="form-control" name="basic_info[<?php echo $row->attribute_code.'-9'; ?>]" value="<?php echo $row->default_value; ?>" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo 'data-bvalidator="required"'; ?> >
                                             <select class="form-control chosen-select" name="basic_info[<?php echo $row->attribute_code; ?>]">
                                                <option value="">--Select--</option>
                                                <?php if(!empty(json_decode($row->attribute_value))){ 
                                                   foreach (json_decode($row->attribute_value) as $key) { 
                                                   ?>
                                                <option value="<?php echo $key; ?>"><?php echo $key; ?></option>
                                                <?php } } ?>
                                             </select>
                                             <?php }else if($row->file_type==10){ ?>
                                             <input type="text" maxlength="500" placeholder="<?php echo ucfirst($row->placeholder_content);  ?>" main="<?php echo $row->attribute_code ; ?>" class="form-control typeahead" name="basic_info[<?php echo $row->attribute_code ; ?>]" value="<?php echo $row->default_value; ?>" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo ' data-bvalidator="required"'; ?> >
                                             <?php } ?>
                                             <span class="error"><?php echo form_error('basic_info['.$row->attribute_code.']'); ?> </span>
                                          </div>
                                       </div>
                                       <?php } } ?>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8">
                                       <div class="form-actiosns form-btn-block text-center">
                                          <button  class="btn btn-red" type="submit">Continue</button>
                                          <a class="btn btn-default-white" href="<?php echo base_url('seller/products/product_category'); ?>">Back</a>
                                       </div>
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
   </div>
</div>


<!-- add brand modal -->
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
                           <select data-placeholder="Choose categories" id="category_id" data-bvalidator-msg="This field required" class="form-control chosen-select" name="category_id[]" data-bvalidator multiple >

                           <?php 
                                    if(!empty($category)){
                                         foreach ($category as  $value) { ?>

                                           <option value="<?=$value->category_id?>">
                                            <?php if($value->parent_id<>0){
                                               echo '&ensp;&ensp;';
                                                  } 
                                               echo $value->category_name;
                                             ?>
                                           </option>
                          
                                <?php     }

                                       } ?>

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
                                   <div class="fileinput-preview thumbnail" data-trigger="fileinput"><input type="file" class="imgUpload" name="brand_image" data-bvalidator="extension[jpg:png:svg:jpeg],required" data-bvalidator-msg="choose an image file and <br> the accepted file type is jpg, jpeg, png" name="image[]"><img class="upload-default-image" id="upload-default-image" src="<?=base_url('assets/seller/img/default-upload-image.png')?>" data-src="holder.js/100%x100%" alt="..."></div>
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
</div>
<script src="<?php echo BACKEND_THEME_URL ?>js/bootstrap3-typeahead.min.js; ?>"></script>
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

   $('.btn-close-modal').click(function(e){

         $('#image_error').html('');
         $('#brand_error').html('');
        }
        );


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


    $(document).ready(function (e) {
      $('#createbrandform').on('submit', function(e){

          e.preventDefault();
         $('#image_error').html('');
         $('#brand_error').html('');
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