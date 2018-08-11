<div class="bread_parent">
   <ul class="breadcrumb">
      <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
      <li><a href="<?php echo base_url('backend/pages/faq');?>">List Of FAQs </a></li>
      <li><b>Edit FAQs</b></li>
   </ul>
</div>
<div class="panel-body">
   <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post" id="form_valid">
      <div class="form-body label-static">
         <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i> FAQ's information :</header>
         <br>
         <div class="form-group">
            <label class="col-md-3 control-label">Category<span class="mandatory">*</span></label>
            <div class="col-md-6">
               <select placeholder="Category" class="form-control" name="category_id" id="category_id" data-bvalidator="required" data-bvalidator-msg="Category required">
                  <option value="">Select category</option>
                  <?php
                     foreach($category as $row)
                      //p($row);
                     { ?>
                  <option value="<?php echo $row->faq_category_id; ?>" <?php if($question_answer->category_id==$row->faq_category_id) echo 'selected'; ?>><?php echo $row->category_name; ?></option>
                  <?php }
                     ?>
               </select>
               <?php echo form_error('category_id'); ?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-3 control-label">Sub Category<span class="mandatory">*</span></label>
            <div class="col-md-6">
               <select placeholder="Category" class="form-control" id="sub_category_id" name="sub_category_id" >
                  <option>Select sub category</option>
                  <?php
                     foreach($sub_category as $row)
                     {
                      if($question_answer->category_id==$question_answer->category_id)  
                      {
                     ?>
                  <option value="<?php echo $row->faq_sub_category_id; ?>" <?php if($question_answer->sub_category_id==$row->faq_sub_category_id) echo 'selected'; ?>><?php echo $row->sub_category_name; ?></option>
                  <?php } }
                     ?>
               </select>
               <?php echo form_error('sub_category_id'); ?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-3 control-label">Question<span class="mandatory">*</span></label>
            <div class="col-md-6">
               <input type="text" placeholder="Question" class="form-control" name="question" value="<?php if(!empty($question_answer->question)) echo trim($question_answer->question); else echo set_value('question'); ?>" data-bvalidator="required" data-bvalidator-msg="Question required"><?php echo form_error('question'); ?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-3 control-label">Answer<span class="mandatory">*</span></label>
            <div class="col-md-6">
               <textarea  class="tinymce_edittor form-control" name="answer"  placeholder="Answer" data-bvalidator="required" data-bvalidator-msg="Answer required" ><?php if(!empty($question_answer->answer)) echo trim($question_answer->answer); else echo set_value('answer'); ?></textarea>  
               <?php echo form_error('answer') ; ?>
            </div>
         </div>
         <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i> SEO/Meta Data (Optional) :</header>
         <br>
         <div class="form-group">
            <label class="col-md-3 control-label">Meta Keyword</label>
            <div class="col-md-6">
               <input type="text" placeholder="Meta Keyword" class="form-control" name="meta_keyword" value="<?php if(!empty($question_answer->meta_keyword)) echo trim($question_answer->meta_keyword); else echo set_value('meta_keyword'); ?>" data-bvalidator="required" data-bvalidator-msg="Meta Title required"><?php echo form_error('meta_keyword'); ?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-3 control-label">Meta Content</label>
            <div class="col-md-6">
               <textarea placeholder="Meta Content" class="form-control" name="meta_content"><?php if(!empty($question_answer->meta_content)) echo trim($question_answer->meta_content); else echo set_value('meta_content'); ?></textarea>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-3 control-label">Meta Description</label>
            <div class="col-md-6">
               <textarea placeholder="Meta Description" class="form-control" name="meta_description"><?php if(!empty($question_answer->meta_description)) echo trim($question_answer->meta_description); else echo set_value('meta_description'); ?></textarea>
            </div>
         </div>
         <div class="form-actions fluid">
            <div class="col-md-offset-3 col-md-10">
               <button  class="btn btn-primary tooltips" rel="tooltip" data-placement="left" data-original-title="Update FAQ's" type="submit"><i class="icon-plus"></i> Update FAQs</button>
               <a class="btn btn-danger tooltips" rel="tooltip" data-placement="right" data-original-title="Back to FAQ's" href="<?php echo base_url()?>backend/pages/faq"><i class="icon-remove"></i> Cancel</a>
            </div>
         </div>
   </form>
   <!-- END FORM--> 
   </div>
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
    
    
   $('#category_id').change(function() {
    var cat_id=$(this).val();
      $.post('<?php echo base_url() ?>'+'backend/pages/getSubcategory', {'cat_id':cat_id}, function(data) {            
        if(data!=false)
        {
          var text="<option value=''>Select sub category</option>";
          var result=jQuery.parseJSON(data);
          for(var i=0;i<result.length;i++)
          {
            text+="<option value='"+result[i]['faq_sub_category_id']+"'>"+result[i]['sub_category_name']+"</option>";
            
          }
          $('#sub_category_id').html(text);
          
        }
            
          });  
    
   });
   });
</script>