<div class="bread_parent">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
         <li><a href="<?php echo base_url('backend/products/index'); ?>">Products</a></li>
         <li>Add Product Basic Info</li>
      </ul>
   </div>
   <div class="clearfix"></div>
</div>
<div class="superadmin-body panel-body partners">
   <ul class="nav nav-tabs " role="tablist">
      <li <?php if($this->session->userdata('productcat_info')['status']==1) echo ""; else echo "class='disabled' style='pointer-events:none;'"; ?>><a href="<?php echo base_url().'backend/products/product_category' ?>"><b>Product Categories</b></a></li>
      <li class="active"><a href="<?php echo base_url().'backend/products/product_basic_info'; ?>"><b>Vital Info</b></a></li>
      <li class='disabled' style='pointer-events:none;'><a href="javascript:void(0)"><b>Variation(Variation Theme)</b></a></li>
      <li class='disabled' style='pointer-events:none;'><a href="javascript:void(0)"><b>Offer</b></a></li>
      <li class='disabled' style='pointer-events:none;'><a href="javascript:void(0)" ><b>Compliance</b></a></li>
      <li class='disabled' style='pointer-events:none;'><a href="javascript:void(0)" ><b>Images</b></a></li>
      <li class='disabled' style='pointer-events:none;'><a href="javascript:void(0)" ><b>Product Description</b></a></li>
      <li class='disabled' style='pointer-events:none;'><a href="javascript:void(0)" ><b>Keywords</b></a></li>
      <li class='disabled' style='pointer-events:none;'><a href="javascript:void(0)" ><b>Meta Information</b></a></li>
   </ul>
   <div class="adv-table">
      <div class="panel-body">

         <form role="form" autocomplete="off" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post" data-bvalidator-validate>
            <?php echo $this->session->flashdata('msg_error');?>
            <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i> Product Basic Information :</header>
            <br>
            <div class="form-group">
               <label class="col-md-2 control-label">Product Title<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Text - maximum 500 characters. HTML tags and special characters not on a standard keyboard (eg. ®, ©, ™ or other Type 1 High ASCII characters) are not supported"></span> </label>
               <div class="col-md-9">
                  <input type="text" maxlength="500" placeholder="Product Title" class="form-control" name="title" value="<?php echo set_value('title');?>" data-bvalidator="required"> <span class="error"><?php echo form_error('title'); ?> </span>
               </div>
            </div>

            <div class="form-group">
               <label class="col-md-2 control-label">Choose Brand Name <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="auto"  data-original-title="Need to select Product Brand"></span></label> 
               <div class="col-md-9">
                  <select class="form-control chosen-select" name="brand_name">
                     <option value="">--Select Brand--</option>
                     <?php 
                     if(!empty($brand_info)){
                        foreach ($brand_info as $row) { 
                     ?>
                        <option value="<?php echo $row->brand_name; ?>"><?php echo $row->brand_name; ?></option>
                     <?php } }
                     ?>
                  </select>
               </div>
            </div>

            <div class="form-group">
               <label class="col-md-2 control-label">Manufacturer Part Number<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Text - maximum 100 characters. HTML tags and special characters not on a standard keyboard (eg. ®, ©, ™ or other Type 1 High ASCII characters) are not supported"></span></label>
               <div class="col-md-9">
                  <input type="text" maxlength="40" placeholder="Manufacturer Part Number" class="form-control" name="manufacturer_part_number" value="<?php if(set_value('manufacturer_part_number')) echo set_value('manufacturer_part_number'); ?>" data-bvalidator="required"> <span class="error"><?php echo form_error('manufacturer_part_number'); ?> </span>
               </div>
            </div>

            <div class="form-group">
               <label class="col-md-2 control-label">Short Description<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Text - maximum 100 characters. HTML tags and special characters not on a standard keyboard (eg. ®, ©, ™ or other Type 1 High ASCII characters) are not supported"></span></label>
               <div class="col-md-9">
                  <input type="text" maxlength="1000" placeholder="Short Description" class="form-control" name="short_description" value="<?php echo set_value('short_description');?>" data-bvalidator="required"> <span class="error"><?php echo form_error('short_description'); ?> </span>
               </div>
            </div>

            <div class="form-group">
               <label class="col-md-2 control-label">Status</label>
               <div class="col-md-9">
                  <select class="form-control" name="status" data-bvalidator="required">
                     <option value="1" >Active</option>
                     <option selected value="2" >Inactive</option>
                  </select>
                  <span class="error"><?php echo form_error('status'); ?> </span>
               </div>
            </div>
            <?php 
            if(!empty($attribute_info)){
               foreach($attribute_info as $row){
            ?>   

               <div class="form-group">
                  <label class="col-md-2 control-label"><?php echo ucfirst($row->name); if($row->is_required_only){  ?><span class="mandatory">*</span><?php } if($row->tooltip_content){ ?>   <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="<?php echo $row->tooltip_content; ?>"></span> <?php } ?></label>
                  <div class="col-md-9">
                     <?php if($row->file_type==1){ ?>

                           <input type="text" maxlength="500" placeholder="<?php echo ucfirst($row->name);  ?>" class="form-control" name="basic_info[<?php echo $row->attribute_code; ?>]" value="<?php echo $row->default_value; ?>" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo ' data-bvalidator="required"'; ?> >

                     <?php }else if($row->file_type==2){ ?>

                           <textarea class="form-control" maxlength="1000" placeholder="<?php echo ucfirst($row->name);  ?>" name="basic_info[<?php echo $row->attribute_code; ?>]" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo ' data-bvalidator="required"'; ?> ><?php echo $row->default_value; ?></textarea>

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

                           <input size="16" type="text" maxlength="50" placeholder="<?php echo ucfirst($row->name);  ?>" value="<?php echo $row->default_value; ?>" class="default_date form-control date" name="basic_info[<?php echo $row->attribute_code; ?>]" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo ' data-bvalidator="date[dd-mm-yyyy],required"'; ?>>

                     <?php }else if($row->file_type==9){ ?>
                           
                           <input type="text" maxlength="500" placeholder="<?php echo ucfirst($row->name);  ?>" class="form-control" name="basic_info[<?php echo $row->attribute_code.'-9'; ?>]" value="<?php echo $row->default_value; ?>" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo 'data-bvalidator="required"'; ?> >

                           <select class="form-control chosen-select" name="basic_info[<?php echo $row->attribute_code; ?>]">
                              <option value="">--Select--</option>
                              <?php if(!empty(json_decode($row->attribute_value))){ 
                                 foreach (json_decode($row->attribute_value) as $key) { 
                              ?>
                                 <option value="<?php echo $key; ?>"><?php echo $key; ?></option>
                              <?php } } ?>
                           </select>
                     <?php }else if($row->file_type==10){ ?>
                   
                           <input type="text" maxlength="500" placeholder="<?php echo ucfirst($row->name);  ?>" main="<?php echo $row->attribute_code ; ?>" class="form-control typeahead" name="basic_info[<?php echo $row->attribute_code ; ?>]" value="<?php echo $row->default_value; ?>" <?php if($row->is_readonly) echo "readonly"; if($row->is_required_only) echo ' data-bvalidator="required"'; ?> >
                     <?php } ?>

                     <span class="error"><?php echo form_error('basic_info['.$row->attribute_code.']'); ?> </span>
                  </div>
               </div>

            <?php } } ?>
         
            <div class="form-actiosns fluid">
                <div class="form-btn-block">
                   <div class="col-md-12 text-center">
                      <button  class="btn btn-primary" type="submit">Submit</button>
                      <a class="btn btn-danger" href="<?php echo base_url('backend/products/product_cateogry'); ?>">Back</a>
                   </div>
                </div>
             </div>
         </form>
         <!-- END FORM--> 

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