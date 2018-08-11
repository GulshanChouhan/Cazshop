<style type="text/css">
   hr.style1{
   border:none;
   border-left:1px solid hsla(200, 10%, 50%,100);
   height:100vh;
   width:1px;
   }
</style>
<?php //p($attribute); die;?>
<div class="bread_parent">
   <ul class="breadcrumb">
      <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
      <li><a href="<?php echo base_url('backend/attribute'); ?>">Attribute Managment </a></li>
      <li><b>Edit Attribute</b></li>
   </ul>
</div>
<div class="col-sm-12">
   <div class="panel-body">
      <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">
         <?php echo $this->session->flashdata('msg_error');?>
         <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i>Attribute information :</header>
         <br>
         <div class="form-group">
            <label class="col-md-2 control-label">Attribute Name <span class="mandatory">*</span></label>
            <div class="col-md-9">
               <input type="text" placeholder="Attribute Name" class="form-control" name="attribute_name" value="<?php if(set_value('attribute_name')) echo set_value('attribute_name'); else if($attribute->name) echo $attribute->name; ?>" > <span class="error"><?php echo form_error('attribute_name'); ?> </span>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Attribute Code <span class="mandatory">*</span></label>
            <div class="col-md-9">
               <input type="text" placeholder="Attribute Code" class="form-control" readonly value="<?php if(set_value('attribute_code')) echo set_value('attribute_code'); else if($attribute->attribute_code) echo $attribute->attribute_code; ?>" > <span class="error"><?php echo form_error('attribute_code'); ?> </span>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Attribute Mapping <span class="mandatory">*</span></label>
            <div class="col-md-9">
               <select class="form-control" name="attribute_map" >
                  <option value="0" <?php if(set_value('attribute_map')==0) echo 'selected'; else if($attribute->attribute_map==0) echo 'selected' ?> >No</option>
                  <option value="1" <?php if(set_value('attribute_map')==1) echo 'selected'; else if($attribute->attribute_map==1) echo 'selected' ?>  >Yes</option>
               </select>
               <span class="error"><?php echo form_error('attribute_map'); ?> </span> 
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Category Name <span class="mandatory">*</span></label>
            <div class="col-md-9">
               <select name="category_id[]" multiple class="form-control form-control input-sm multiselect" data-bvalidator-msg="Category is required" data-bvalidator="required" id="artCategoryId"> 
               <?php echo getcategoryDropdown($attribute->category_id); ?>
               </select>  
               <span class="error"><?php echo form_error('category_id[]'); ?> </span>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Type <span class="mandatory">*</span></label>
            <div class="col-md-9">
               <select class="form-control" name="type" id="type" >
                  <option value="">Select Type</option>
                  <?php  if(type())   {
                     foreach(type() as $key => $value) {
                     ?>
                  <option value='<?php echo  $key; ?>' <?php if(empty($_POST) && $attribute->type==$key) echo 'selected'; else if(set_value('type')==$key) echo 'selected' ?>> <?php  echo $value;  ?></option>
                  <?php } } ?>
               </select>
               <span class="error"><?php echo form_error('type'); ?> </span>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Is used in filter <span class="mandatory">*</span></label>
            <div class="col-md-9">
               <input type="radio" id="used_in_filter_yes" name="used_in_filter" value="1" <?php if(!empty($attribute) && $attribute->used_in_filter==1) echo 'checked'; else if(set_value('used_in_filter')==1) echo 'checked' ?>> Yes &nbsp;
               <input type="radio" id="used_in_filter_no" name="used_in_filter" value="0" <?php if(!empty($attribute) && $attribute->used_in_filter==0) echo 'checked'; ?> > No
               <span class="error"><?php echo form_error('used_in_filter'); ?> </span>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Field Type <span class="mandatory">*</span></label>
            <div class="col-md-9">
               <select class="form-control" name="file_type" id="file_type" >
                  <option>Please Select Field Type</option>
                  <?php  if(file_type())   {
                     foreach(file_type() as $key => $value) {
                     ?>
                  <option value='<?php echo  $key; ?>' <?php if(set_value('file_type')==$key) echo 'selected'; else if(empty($_POST) && $attribute->file_type==$key) echo 'selected'; ?>> <?php  echo $value;  ?></option>
                  <?php } } ?>
               </select>
               <span class="error"><?php echo form_error('file_type'); ?> </span>
            </div>
         </div>
         <div class="form-group  section section-show1" id="default_text" style="display: <?php if(set_value('file_type')==1 || (empty($_POST) && $attribute->file_type==1)) echo 'block'; else echo 'none'; ?>" >
            <label class="col-md-2 control-label">Default value</label>
            <div class="col-md-9">
               <input type="text" placeholder="Default value" class="form-control" name="default_value" value="<?php if(set_value('default_value')) echo set_value('default_value'); else if($attribute->default_value) echo $attribute->default_value; ?>" > <span class="error"><?php echo form_error('default_value'); ?> </span>
            </div>
         </div>
         <div class="form-group  section section-show2" id="default_textarea" style="display: <?php if(set_value('file_type')==2 || (empty($_POST) && $attribute->file_type==2)) echo 'block'; else echo 'none'; ?>" >
            <label class="col-md-2 control-label">Default value</label>
            <div class="col-md-9">
               <textarea placeholder="Default value" class="form-control" name="default_textarea" ><?php if(set_value('default_textarea')) echo set_value('default_value'); else if($attribute->default_value) echo $attribute->default_value; ?></textarea>
            </div>
         </div>
         <div class="form-group  section section-show9" id="default_text" style="display: <?php if(set_value('file_type')==9 || (empty($_POST) && $attribute->file_type==9)) echo 'block'; else echo 'none'; ?>" >
            <label class="col-md-2 control-label">Default value</label>
            <div class="col-md-9">
               <input type="text" placeholder="Default value" class="form-control" name="default_value" value="<?php if(set_value('default_value')) echo set_value('default_value'); else if($attribute->default_value) echo $attribute->default_value; ?>" > <span class="error"><?php echo form_error('default_value'); ?> </span>
            </div>
         </div>
         <div class="form-group section section-show8" id="default_date" style="display: <?php if(set_value('file_type')==8 || (empty($_POST) && $attribute->file_type==8)) echo 'block'; else echo 'none'; ?>" >
            <label class="col-md-2 control-label">Default Date</label>
            <div class="col-md-9">
               <input size="16" type="text" value="<?php if(set_value('default_date')) echo set_value('default_value'); else if($attribute->default_value) echo $attribute->default_value; ?>" class="default_date form-control date" name="default_date">
            </div>
         </div>
         <div class="form-group" id="read_only" style="display: <?php if(!empty($_POST) && !empty($_POST['attribute_value'])) echo 'none'; else if(in_array($attribute->file_type,array(1,2,8))) 'block'; else echo 'none'; ?>;" >
            <label class="col-md-2 control-label">Read Only</label>
            <div class="col-md-9">
               <input type="checkbox" value="1" name="is_readonly" <?php if(set_value('is_readonly')) echo 'checked'; else if($attribute->is_readonly) echo 'checked' ?> >
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Required Status <span class="mandatory">*</span></label>
            <div class="col-md-9">
               <select class="form-control" name="required_status" >
                  <option value="0" <?php if(set_value('required_status')==0) echo 'selected'; else if($attribute->is_required_only==0) echo 'selected' ?> >No</option>
                  <option value="1" <?php if(set_value('required_status')==1) echo 'selected'; else if($attribute->is_required_only==1) echo 'selected' ?>  >Yes</option>
               </select>
               <span class="error"><?php echo form_error('required_status'); ?> </span> 
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Tooltip Content</label>
            <div class="col-md-9">
               <textarea placeholder="Tooltip Content" class="form-control" name="tooltip_content" ><?php if(set_value('tooltip_content')) echo set_value('tooltip_content'); else if($attribute->tooltip_content) echo $attribute->tooltip_content; ?></textarea>
                <span class="error"><?php echo form_error('tooltip_content'); ?> </span> 
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Placeholder Content</label>
            <div class="col-md-9">
               <textarea placeholder="Placeholder Content" class="form-control" name="placeholder_content" ><?php if(set_value('placeholder_content')) echo set_value('placeholder_content'); else if($attribute->placeholder_content) echo $attribute->placeholder_content; ?></textarea>
                <span class="error"><?php echo form_error('placeholder_content'); ?> </span> 
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Status <span class="mandatory">*</span></label>
            <div class="col-md-9">
               <select class="form-control" name="status" >
                  <?php 
                     $status = status();
                     foreach ($status as $key => $value) { 
                  ?>
                     <option value="<?php echo $key; ?>" <?php if($attribute->status==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                  <?php } ?>
               </select>
               <span class="error"><?php echo form_error('status'); ?> </span>
            </div>
         </div>
         <div class="attribute section section-show-all" style="display:<?php if(!empty($_POST) && !empty($_POST['attribute_value']) && !empty($_POST['file_type']) && in_array($_POST['file_type'], array(3,4,5,7,9,10))) echo 'block'; else if(empty($_POST) && !empty($attribute->attribute_value) && !empty($attribute->file_type) && in_array($attribute->file_type, array(3,4,5,7,9,10))) echo 'block'; else echo 'none'; ?>">
            <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i> Manage Options (values of your attribute) :</header>
            <br>
            <div class="input_fields_container">
               <?php if((!empty($_POST) && !empty($_POST['attribute_value'])) || (empty($_POST) && !empty($attribute->attribute_value))){
                  if(empty($_POST))
                    $_POST['attribute_value']=json_decode($attribute->attribute_value);   
                  for($i=0;$i<sizeof($_POST['attribute_value']);$i++){
                  ?>
               <div class="form-group">
                  <label class="col-md-2 control-label">Attribute Value <span class="mandatory">*</span></label>
                  <div class="input-group col-md-9">
                     <input autocomplete="off" class="input form-control"  name="attribute_value[]" value="<?php echo $_POST['attribute_value'][$i]; ?>" type="text" placeholder="Attribute Value" data-items="8"/>
                     <div class="input-group-addon">
                        <?php if($i==0){ ?>
                        <a href="javatpoint:void(0)" class="add_more_button" style="margin-left:10px;">Add More Fields</a>
                        <?php }else{ ?>
                        <a href="javatpoint:void(0)" class="remove_field" style="margin-left:10px;">Remove</a>
                        <?php } ?>
                     </div>
                  </div>
               </div>
               <?php } }else{ ?>
               <div class="form-group">
                  <label class="col-md-2 control-label">Attribute Value <span class="mandatory">*</span></label>
                  <div class="input-group col-md-9">
                     <input autocomplete="off" class="input form-control"  name="attribute_value[]" type="text" placeholder="Attribute Value" data-items="8"/>
                     <div class="input-group-addon">
                        <a href="javatpoint:void(0)" class="add_more_button" style="margin-left:10px;">Add More Fields</a>
                     </div>
                  </div>
               </div>
               <?php } ?>
               <div class="row">
                  <div class="col-md-2">
                  </div>
                  <div class="col-md-9"><span class="error"><?php echo form_error('attribute_value[]'); ?> </span></div>
               </div>
            </div>
         </div>
         <br>
         <div class="form-actions fluid">
            <div class="col-md-offset-2 col-md-10">
               <button  class="btn btn-primary" type="submit">Submit</button>
               <a class="btn btn-danger" href="<?php echo base_url()?>backend/attribute/index">
               Cancel</a>
            </div>
         </div>
      </form>
      <!-- END FORM--> 
   </div>
</div>
<link rel="stylesheet" type="text/css" href="<?php echo BACKEND_THEME_URL ?>/css/jquery.multiselect.css">
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>/js/jquery.multiselect.js"></script>
<script>
     $(function () {
        $('.multiselect').multiselect({
        //    columns: 3,
            placeholder: 'Select States',
            search: true,
            searchOptions: {
                'default': 'Search States'
            },
            selectAll: true
        });
    });
   $(document).ready(function(){
    var max_fields_limit      = 10; //set limit for maximum input fields
       var x = 1; //initialize counter for text box
       $('.add_more_button').click(function(e){ //click event on add more fields button having class add_more_button
           e.preventDefault();
               x++; //counter increment
               $('.input_fields_container').append('<div class="form-group"><label class="col-md-2 control-label">Attribute Value <span class="mandatory">*</span></label><div class="input-group col-md-9"><input autocomplete="off" class="input form-control" placeholder="Attribute Value"  name="attribute_value[]" type="text"><div class="input-group-addon"><a href="javatpoint:void(0)" class="remove_field" style="margin-left:10px;">Remove</a></div></div></div>'); //add input field
           
       });  
       $('.input_fields_container').on("click",".remove_field", function(e){ //user click on remove text links
           e.preventDefault(); $(this).parents('div.form-group').remove(); x--;
       });
   
   $('#file_type').change(function() {
    $('#read_only').show();
    $('.section').hide();
    if($(this).val()==1 || $(this).val()==2 || $(this).val()==8)
    {
      $('.section-show'+$(this).val()).show();
    }else if($(this).val()==6){
      $('#read_only').hide();
    }else if($(this).val()==9){
      $('.section-show'+$(this).val()).show();
      $('.section-show-all').show();
    }else{
      $('.section-show-all').show();
      $('#read_only').hide();
    }
      });
   });
</script>