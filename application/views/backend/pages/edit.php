<div class="bread_parent">
   <ul class="breadcrumb">
      <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
      <li><a href="<?php echo base_url('backend/pages/index'); ?>">Page </a></li>
      <li><a href="javascript:;"><b>Edit Page</b> </a></li>
   </ul>
</div>
<div class="panel-body">
   <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">
      <div class="form-body">
         <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i>Page  information :</header>
         <br>
         <div class="form-group">
            <label class="col-md-2 control-label">Page Title <span class="mandatory">*</span></label>
            <div class="col-md-10">
               <input type="text" class="form-control" name="title" onchange="convertToSlug(this.value)" value="<?php if (set_value('title')) echo set_value('title'); elseif(!empty($page->title)) echo $page->title ;?>"><?php echo form_error('title'); ?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Section Type <span class="mandatory">*</span></label>
            <div class="col-md-10">
               <select class="form-control" name="type_of_section">
                  <option <?php if($page->type_of_section==1) echo "selected"; ?> value="1">Frontend</option>
                  <option <?php if($page->type_of_section==2) echo "selected"; ?> value="2">Seller</option>
               </select>
               <?php echo form_error('type_of_section'); ?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Page Slug <span class="mandatory">*</span></label>
            <div class="col-md-10">
               <input type="text" class="form-control" name="slug" readonly="readonly" value="<?php if (set_value('slug')) echo set_value('slug'); elseif(!empty($page->slug)) echo $page->slug ;?>"><?php echo form_error('slug'); ?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Page Content <span class="mandatory">*</span></label>
            <div class="col-md-10">
               <textarea  class="tinymce_edittor form-control" cols="100" rows="12" name="description"><?php  if (set_value('description')) echo set_value('description'); elseif(!empty($page->description)) echo $page->description ; else echo " "; ?></textarea><?php echo form_error('description'); ?>
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
               <textarea placeholder="Meta Description" class="form-control" name="meta_description"  > <?php echo set_value('meta_description');?> </textarea> 
            </div>
         </div>
      </div>
      <div class="form-actions fluid form-btn-block">
         <div class="col-md-offset-2 col-md-10">
            <button class="btn btn-primary" type="submit"><i class="icon-plus"></i> Update</button>&nbsp;&nbsp;
            <a href="<?php echo base_url()?>backend/pages/index" class="btn btn-danger" ><i class="icon-remove"></i> Cancel
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