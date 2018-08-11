<div class="bread_parent">
  <div class="row">
    <div class="col-md-12">
     <ul class="breadcrumb">
        <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
        <li><a href="<?php echo base_url('backend/category/index/0');?>"><b>Product Category</b> </a>
         <?php $bread=get_category_bread_crumb( $this->uri->segment(4));
               if(!empty($bread))
               {
                  $bread=array_reverse($bread);
                  echo implode(' ',$bread);
               }
            ?>
        <li><b>Add Product Subcategory in <?php echo $parentRow->category_name; ?></b></li>
     </ul>
   </div>
  </div>
</div>
<div class="row">
   <div class="col-sm-4">
      <div class="panel-body">
         <div class="form-actions fluid">
            <div class="col-md-offset-2 col-md-10">
               <br>
            </div>
         </div>
         <div>
            <?php getCategoryTreeStructure(); ?>
         </div>
         <hr class="vertical">
      </div>
   </div>
   <div class="col-sm-8">
      <div class="panel-body">
         <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">
            <?php echo $this->session->flashdata('msg_error');?>
            <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i> Product Subcategory Information :</header>
            <br>
            <div class="form-group">
               <label class="col-md-3 control-label">Subcategory Name<span class="mandatory">*</span></label>
               <div class="col-md-8">
                  <input type="text" placeholder="Subcategory Name" class="form-control" name="category_name" id="category_name" value="<?php echo set_value('category_name');?>" > <span class="error"><?php echo form_error('category_name'); ?> </span>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-3 control-label">Subcategory Slug<span class="mandatory">*</span></label>
               <div class="col-md-8">
                  <input type="text" placeholder="Subcategory slug" class="form-control" name="category_slug" id="category_slug" value="<?php echo set_value('category_slug');?>" > <span class="error"><?php echo form_error('category_slug'); ?> </span>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-3 control-label">Short Description<span class="mandatory">*</span></label>
               <div class="col-md-8">
                  <textarea class="form-control" placeholder="Short Description" name="short_description" ></textarea>
                  <span class="error"><?php echo form_error('short_description'); ?> </span>
               </div>
            </div>
             <!--<div class="form-group">
               <label class="col-md-3 control-label">Description<span class="mandatory">*</span></label>
               <div class="col-md-8">
                  <textarea class="form-control tinymce_edittor" name="description" ><?php //echo set_value('description');?></textarea>
                  <span class="error"><?php //echo form_error('description'); ?> </span>
               </div>
            </div> -->
            <div class="form-group">
               <label class="col-md-3 control-label">Tile<span class="mandatory">*</span></label>
               <div class="col-lg-8">
                  <div class="fileinput fileinput-new" data-provides="fileinput">
                     <div class="fileinput-preview thumbnail" data-trigger="fileinput">
                        <img src="<?php echo  BACKEND_THEME_URL ?>images/default_image.png" data-src="holder.js/100%x100%" alt="...">
                     </div>
                     <div>
                        <span class="btn btn-primary btn-file btn-xs"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="logo_image" id="logo_image"></span>
                        <a href="#" class="btn btn-danger fileinput-exists btn-xs" data-dismiss="fileinput">Remove</a>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                  <span class="validation_info">Tile Image must be <b>atleast 100 X 100 px and at max 500 X 500</b>. Image type allowed is <b>png , jpg , jpeg</b></span>
                  <span class="error"><?php echo form_error('logo_image'); ?> </span>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-3 control-label">Banner Image<span class="mandatory">*</span></label>
               <div class="col-lg-8">
                  <div class="fileinput fileinput-new" data-provides="fileinput">
                     <div class="fileinput-preview thumbnail" data-trigger="fileinput">
                        <img src="<?php echo  BACKEND_THEME_URL ?>images/default_image.png" data-src="holder.js/100%x100%" alt="...">
                     </div>
                     <div>
                        <span class="btn btn-primary btn-file btn-xs"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="banner_image" id="banner_image"></span>
                        <a href="#" class="btn btn-danger fileinput-exists btn-xs" data-dismiss="fileinput">Remove</a>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                  <span class="validation_info">Banner Image must be <b>atleast 1400 X 350 px and at max 1600 X 500</b>. Image type allowed is <b>png , jpg , jpeg</b></span>
                  <span class="error"><?php echo form_error('banner_image'); ?> </span>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-3 control-label">Display Order</label>
               <div class="col-md-8">
                  <input type="text" placeholder="Display Order" class="form-control" name="order_by" value="<?php echo set_value('order_by');?>" > <span class="error"><?php echo form_error('order_by'); ?> </span>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-3 control-label">Status</label>
               <div class="col-md-8">
                  <select class="form-control" name="status" >
                  <?php 
                     $status = status();
                     foreach ($status as $key => $value) { 
                  ?>
                     <option value="<?php echo $key; ?>" <?php if(set_value('status')==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                  <?php } ?>
                  </select>
                  <span class="error"><?php echo form_error('status'); ?> </span>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-3 control-label">Show in Menu</label>
               <div class="col-md-8">
                  <select class="form-control" name="is_menu" >
                     <option value="0" >No</option>
                     <option value="1" >Yes</option>
                  </select>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-3 control-label">Popular Categories</label>
               <div class="col-md-8">
                  <select class="form-control" name="is_home" >
                     <option value="0" >No</option>
                     <option value="1" >Yes</option>
                  </select>
               </div>
            </div>
            <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i> SEO/Meta Data (Optional)</header>
            <br>   
            <div class="form-group">
               <label class="col-md-3 control-label">Meta Title</label>
               <div class="col-md-8">
                  <input type="text" placeholder="Meta Title" class="form-control" name="meta_title" value="<?php echo set_value('meta_title');?>" > <span class="error"><?php echo form_error('meta_title'); ?> </span>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-3 control-label">Meta Keywords</label>
               <div class="col-md-8">
                  <textarea class="form-control" placeholder="Meta Keywords" name="meta_keyword" ></textarea>
                  <span class="error"><?php echo form_error('meta_keyword'); ?> </span>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-3 control-label">Meta Description</label>
               <div class="col-md-8">
                  <textarea class="form-control" placeholder="Meta Description" name="meta_description" ></textarea>
                  <span class="error"><?php echo form_error('meta_description'); ?> </span>
               </div>
            </div>
            <div class="form-actions fluid">
               <div class="col-md-offset-3 col-md-9">
                  <button  class="btn btn-primary" type="submit">Submit</button>
                  <a class="btn btn-danger" href="<?php echo base_url()?>backend/Category/add_category">Back</a>
               </div>
            </div>
         </form>
         <!-- END FORM--> 
      </div>
   </div>
</div>
<style type="text/css">
   hr.style1{
   border:         none;
   border-left:    1px solid hsla(200, 10%, 50%,100);
   height:         100vh;
   width:          1px;
   }
   .tree .selected{
   color: red;
   }
</style>