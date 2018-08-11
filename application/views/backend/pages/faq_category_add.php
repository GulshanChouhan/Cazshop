<div class="bread_parent">
   <ul class="breadcrumb">
      <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
      <li><a href="<?php echo base_url('backend/pages/faq_category');?>">FAQs Categories List</a></li>
      <li><b>Add FAQs Category </b></li>
   </ul>
</div>
<div class="panel-body">
<form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post" id="form_valid">
   <div class="form-body">
      <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i>FAQs Category information:</header>
      <br>
      <div class="form-group">
         <label class="col-md-3 control-label">FAQs Category Name <span class="mandatory">*</span></label>
         <div class="col-md-6">
            <input type="text" placeholder="FAQs Category Name" class="form-control" name="category_name" value="<?php echo set_value('category_name');  ?>" data-bvalidator="required" data-bvalidator-msg="Category required"><?php echo form_error('category_name'); ?>
         </div>
      </div>
      <div class="form-group">
         <label class="col-md-3 control-label">Description <span class="mandatory">*</span></label>
         <div class="col-md-6">
            <textarea  class="tinymce_edittor form-control" name="description"  placeholder="Description" data-bvalidator="required" data-bvalidator-msg="Description required" ><?php echo set_value('description');?></textarea> 
            <?php echo form_error('description'); ?>
         </div>
      </div>
      <div class="form-actions fluid">
         <div class="col-md-offset-3 col-md-10">
            <button  class="btn btn-primary tooltips" rel="tooltip" data-placement="left" data-original-title="Add FAQs Category" type="submit"><i class="icon-plus"></i> Add FAQs Category</button>
            <a class="btn btn-danger tooltips" rel="tooltip" data-placement="right" data-original-title="Back to FAQs Category listing" href="<?php echo base_url('backend/pages/faq_category'); ?>"><i class="icon-remove"></i> Cancel</a>                              
         </div>
      </div>
</form>
<!-- END FORM--> 
</div>
<script language="javascript" type="text/javascript">
   function checkMaxLength(textareaID, maxLength, fieldid){
       currentLengthInTextarea = $("#"+textareaID).val().length;
       $(fieldid).text(parseInt(maxLength) - parseInt(currentLengthInTextarea));
   if (currentLengthInTextarea > (maxLength)) { 
     // Trim the field current length over the maxlength.
     $("input#textareaID").val($("input#textareaID").val().slice(0, maxLength));
     $(fieldid).text(0);
   }
   }
   
   $(document).ready( function () {
   maxLength = $("input#top_promo_text").attr("maxlength");
   $("input#top_promo_text").after("<div><span id='remainingLengthTempId'><small>"+ maxLength + "</small></span> <small>character remaining</small></div>");
       $("input#top_promo_text").bind("keyup change", function(){checkMaxLength(this.id,  maxLength,remainingLengthTempId); } )  
   
   });
   
</script>
<script>
   $(document).ready(function () {
    
   $('#cat_type').change(function(event) {
      
     if($('#cat_type').val()==1){   
       $('#tile_img').css('display', 'none');
       $('#banner_img').css('display', 'none');   
       $('#cat_title').css('display', 'none');   
       
     }else{
       $('#tile_img').css('display', 'block');
       $('#banner_img').css('display', 'block');
       $('#cat_title').css('display', 'block'); 
      
     }
   });
   });
</script>