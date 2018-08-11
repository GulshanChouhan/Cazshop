<ul class="breadcrumb">
   <li><a href="<?php echo base_url('backend/superadmin/dashboard') ?>"><i class="icon-home"></i> Dashboard  </a></li>
   <li><a href="<?php echo base_url('backend/pages/faq_category') ?>">FAQs Categories</a></li>
   <li><a href="<?php echo base_url('backend/pages/faq_sub_category/'.$page_sub_category->category_id);?>">FAQs Subcategory of <?php if(!empty($page_category->category_name)) echo $page_category->category_name; ?> </a></li>
   <li><?php if(!empty($page_sub_category->sub_category_name)) echo $page_sub_category->sub_category_name; ?></li>
</ul>
<div class="panel-body ">
   <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">
      <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i>Edit FAQs Subcategory :</header>
      <br>
      <div class="form-body">
         <div class="form-group">
            <label class="col-md-3 control-label">FAQs Subcategory name : </label>
            <div class="col-md-6">
               <input type="text" placeholder="Page Sub Category Name" class="form-control" name="category_name" value="<?php if(!empty($page_sub_category->sub_category_name)) echo $page_sub_category->sub_category_name; ?>"><?php echo form_error('category_name'); ?>
            </div>
         </div>
          <div class="form-group">
         <label class="col-md-3 control-label">Description <span class="mandatory">*</span></label>
         <div class="col-md-6">
            <textarea  class="tinymce_edittor form-control" name="description"  placeholder="Description" data-bvalidator="required" data-bvalidator-msg="Description required" ><?php  if(!empty($page_sub_category->description)) echo $page_sub_category->description; echo set_value('description');?></textarea> 
            <?php echo form_error('description'); ?>
         </div>
      </div>
      </div>
      <div class="form-actions fluid">
         <div class="col-md-offset-3 col-md-10">
            <button  class="btn btn-primary tooltips" rel="tooltip" data-placement="left" data-original-title="Update the <?php if(!empty($page_category->category_name)) echo $page_category->category_name; ?> FAQs Subcategory"  type="submit"><i class="icon-repeat"></i> Update Subcategory</button>
            <a class="btn btn-danger tooltips" rel="tooltip" data-placement="right" data-original-title="Back to FAQs Subcategories"  href="<?php echo base_url('backend/pages/faq_sub_category/'.$page_sub_category->category_id);?>"><i class="icon-remove"></i> Cancel</a>
         </div>
      </div>
   </form>
   <!-- END FORM--> 
</div>