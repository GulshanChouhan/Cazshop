<div class="bread_parent">
   <ul class="breadcrumb">
      <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
      <li><a href="<?php echo base_url('backend/pages/index'); ?>">Page </a></li>
      <li><b>Add Page</b> </li>
   </ul>
</div>
<div class="panel-body">
   <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">
      <div class="form-body">
         <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i>Page  Information :</header>
         <br>
         <div class="form-group">
            <label class="col-md-2 control-label">Page Title <span class="mandatory">*</span></label>
            <div class="col-md-10">
               <input type="text" placeholder="Page Title" onchange="convertToSlug(this.value)" class="form-control" name="title" value="<?php if (set_value('title')) echo set_value('title'); elseif(!empty($page->title)) echo $page->title ;?>"><?php echo form_error('title'); ?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Section Type <span class="mandatory">*</span></label>
            <div class="col-md-10">
               <select class="form-control" name="type_of_section">
                  <option value="1">Frontend</option>
                  <option value="2">Seller</option>
               </select>
               <?php echo form_error('type_of_section'); ?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Page Slug <span class="mandatory">*</span></label>
            <div class="col-md-10">
               <input type="text" class="form-control" placeholder="Page Slug" name="slug" value="<?php if (set_value('slug')) echo set_value('slug'); elseif(!empty($page->slug)) echo $page->slug ;?>"><?php echo form_error('slug'); ?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Page Content <span class="mandatory">*</span></label>
            <div class="col-md-10">
               <textarea  class="tinymce_edittor form-control" placeholder="Page Content" cols="100" rows="12" name="description"><?php  if (set_value('description')) echo set_value('description'); elseif(!empty($page->description)) echo $page->description ; else echo " "; ?></textarea><?php echo form_error('description'); ?>
            </div>
         </div>
         <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i> SEO/Meta Data (Optional) :</header>
         <br>
         <div class="form-group">
            <label class="col-md-2 control-label">Meta Keyword</label>
            <div class="col-md-10">
               <input type="text" placeholder="Meta Keyword" class="form-control" name="meta_keyword" value="<?php echo set_value('meta_keyword');?>" data-bvalidator="required" data-bvalidator-msg="Meta Meta Keyword required"><?php echo form_error('meta_keyword'); ?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Meta Content</label>
            <div class="col-md-10">
               <textarea placeholder="Meta Content" class="form-control" name="meta_content" value="<?php echo set_value('meta_content');?>" ></textarea>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Meta Description</label>
            <div class="col-md-10">
               <textarea placeholder="Meta Description" class="form-control" name="meta_description"> <?php echo set_value('meta_description');?> </textarea> 
            </div>
         </div>
      </div>
      <div class="form-actions fluid form-btn-block">
         <div class="col-md-offset-2 col-md-10">
            <button  class="btn btn-primary" type="submit"><i class="icon-plus"></i> Submit</button>&nbsp;&nbsp;
            <a class="btn btn-danger" href="<?php echo base_url()?>backend/pages/index"><i class="icon-remove"></i> Back
            </a>                              
         </div>
      </div>
   </form>
   <!-- END FORM--> 
</div>

<script>
function convertToSlug(Text)
{
    var slug = Text
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
        console.log(slug);
    $("input[name='slug']").val(slug);
}
</script>