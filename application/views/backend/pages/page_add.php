<div class="bread_parent">
   <ul class="breadcrumb">
      <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
      <li><a href="<?php echo base_url('backend/content/pages'); ?>">Pages </a></li>
      <li><a href="<?php echo base_url('backend/content/page_add'); ?>"><b>Add Pages</b> </a></li>
   </ul>
</div>
<div class="panel-body">
   <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">
      <?php echo $this->session->flashdata('msg_error');?>
      <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i>Attribute information :</header>
      <br>
      <div class="form-body">
         <div class="form-group">
            <label class="col-md-2 control-label">Title</label>
            <div class="col-md-9">
               <input type="text" placeholder="Page Title" class="form-control" name="page_title" value="<?php echo set_value('page_title');?>"> <?php echo form_error('page_title'); ?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Page layout</label>
            <div class="col-md-9">
               <select class="form-control" name="page_layout">
                  <option>Select Page layout</option>
                  <?php foreach(getPagelayout() as $key=>$value){ echo '<option value="'.$key.'" '.(($key==set_value('page_layout'))?'selected="selected"':"").'>'.$value.'</option>'; } ?> 
               </select>
               <?php echo form_error('page_layout'); ?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Banner</label>
            <div class="col-md-9">
               <textarea class="tinymce_edittor form-control" cols="50" rows="6" name="banner"><?php echo set_value('banner');?></textarea>
               <?php echo form_error('banner'); ?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Content</label>
            <div class="col-md-9">
               <textarea class="tinymce_edittor form-control" cols="100" rows="12" name="page_content"><?php echo set_value('page_content');?></textarea>
               <?php echo form_error('page_content'); ?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Request a call back today</label>
            <div class="col-md-9">
               <select class="form-control" name="request_form">
                  <option value="0" <?php if(set_value('request_form')==0) echo 'selected' ?>>No</option>
                  <option value="1" <?php if(set_value('request_form')==1) echo 'selected' ?>>Yes</option>
               </select>
               <?php echo form_error('request_form'); ?>
            </div>
         </div>
         <header class="panel-heading colum">Meta Information: </header>
         <br>  
         <div class="form-group">
            <label class="col-md-2 control-label">Meta Title</label>
            <div class="col-md-9">
               <textarea class="form-control" cols="150" rows="2" name="meta_title"  placeholder="Meta Title"  ><?php  echo set_value('meta_title'); ?></textarea>
               <?php echo form_error('meta_title'); ?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Meta Keywords </label>
            <div class="col-md-9">
               <textarea class="form-control" cols="150" rows="3" name="meta_keywords" placeholder="Meta Keywords"><?php   echo set_value('meta_keywords'); ?></textarea>
               <?php echo form_error('meta_keywords'); ?>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-2 control-label">Meta Descritpion </label>
            <div class="col-md-9">
               <textarea class="form-control" cols="150" rows="4" name="meta_description" placeholder="Meta Descritpion"><?php echo set_value('meta_description');  ?></textarea>          
               <b class="validation_info">The Brief Content must not have more than 225 characters.</b><br> 
               <?php echo form_error('meta_description'); ?>
            </div>
         </div>
      </div>
      <div class="form-actions fluid">
         <div class="col-md-offset-2 col-md-10">
            <button  class="btn btn-primary" type="submit">Submit</button>
            <a class="btn btn-danger" href="<?php echo base_url()?>backend/content/pages">
            Cancel</a>                              
         </div>
      </div>
   </form>
   <!-- END FORM--> 
</div>