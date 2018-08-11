<div class="bread_parent">
   <div class="row">
      <div class="col-md-10">
         <ul class="breadcrumb">
            <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
            <li><a href="<?php echo base_url('backend/category/index/0');?>"><b>Product Category</b> </a></li>

            <?php $bread=get_category_bread_crumb( $this->uri->segment(4));
               if(!empty($bread))
               {
                  $bread=array_reverse($bread);
                  echo implode(' ',$bread);
               }
            ?>
            <?php if($parentRow->parent_id==0){ ?>
            <li><b>Edit Product Category Information</b></li>
            <?php }else{ ?>
            <li><b>Edit Product Subcategory Information</b></li>
            <?php } ?>
         </ul>
      </div>
      <div class="col-md-2 text-right">
         <a  class="btn btn-primary"  href="<?php echo base_url('backend/category/add_subcategory/'.$parentRow->category_id); ?>" ><i class="fa fa-plus" aria-hidden="true"></i> Subcategory</a>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-sm-4">
      <div class="panel-body">
         <?php getCategoryTreeStructure(); ?>
         <hr class="vertical">
      </div>
   </div>
   <div class="col-sm-8">
      <div class="panel-body">
         <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">
            <?php echo $this->session->flashdata('msg_error');?>
            <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i> <?php if($parentRow->parent_id==0){ echo "Product Category"; }else{ echo "Product Subcategory"; } ?> Information : <a onclick="return confirmBox('Do you want to delete it ?','<?php echo base_url().'backend/Category/delete/'.$parentRow->category_id; ?>')" rel="tooltip" data-placement="top" data-original-title="Delete <?php echo $parentRow->category_name; ?>" onclick="if(confirm('Do you want to delete it ?')){return true;} else {return false;}" class="btn btn-danger btn-sm pull-right cross tooltips"><i class="fa fa-times" aria-hidden="true"></i></a></header>
            <br>
            <div class="form-group">
               <label class="col-md-2 control-label"><?php if($parentRow->parent_id==0){ echo "Category Name"; }else{ echo "Subcategory Name"; } ?><span class="mandatory">*</span></label>
               <div class="col-md-9">
                  <input type="text" placeholder="<?php if($parentRow->parent_id==0){ echo "Category Name"; }else{ echo "Subcategory Name"; } ?>" class="form-control" name="category_name" value="<?php if(set_value('category_name')) echo set_value('category_name'); else echo $parentRow->category_name; ?>" > <span class="error"><?php echo form_error('category_name'); ?> </span>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-2 control-label"><?php if($parentRow->parent_id==0){ echo "Category Slug"; }else{ echo "Subcategory Slug"; } ?><span class="mandatory">*</span></label>
               <div class="col-md-9">
                  <input type="text" readonly placeholder="<?php if($parentRow->parent_id==0){ echo "Category slug"; }else{ echo "Subcategory slug"; } ?>" class="form-control" name="category_slug" value="<?php if(set_value('category_slug')) echo set_value('category_slug'); else echo $parentRow->category_slug; ?>" > <span class="error"><?php echo form_error('category_slug'); ?> </span>
               </div>
            </div>
             <div class="form-group">
               <label class="col-md-2 control-label">Short Description<span class="mandatory">*</span></label>
               <div class="col-md-9">
                  <textarea class="form-control" placeholder="Short Description" name="short_description" ><?php if(set_value('short_description')) echo set_value('short_description'); else echo $parentRow->short_description; ?></textarea>
                  <span class="error"><?php echo form_error('short_description'); ?> </span>
               </div>
            </div>
            <!--<div class="form-group">
               <label class="col-md-2 control-label">Description<span class="mandatory">*</span></label>
               <div class="col-md-9">
                  <textarea class="form-control tinymce_edittor" name="description" ><?php //if(set_value('description')) echo set_value('description'); else echo $parentRow->description; ?></textarea>
                  <span class="error"><?php //echo form_error('description'); ?> </span>
               </div>
            </div> -->
            <?php if($parentRow->parent_id==0){ ?>
            <div class="form-group">
               <label class="col-md-2 control-label">Menu Icon<span class="mandatory">*</span></label>
               <div class="col-lg-9">
                  <div class="fileinput fileinput-new" data-provides="fileinput">
                     <div class="fileinput-preview thumbnail" data-trigger="fileinput">
                        <?php
                           if(!empty($parentRow->menu_icon) && file_exists("assets/uploads/backend/category_img/icon/".$parentRow->menu_icon)){
                        ?>
                        <img src="<?php echo base_url().'assets/uploads/backend/category_img/icon/'.$parentRow->menu_icon; ?>" data-src="holder.js/100%x100%" alt="...">
                        <?php }else{ ?>
                        <img src="<?php echo  BACKEND_THEME_URL ?>images/default_image.png" data-src="holder.js/100%x100%" alt="...">
                        <?php } ?>
                     </div>
                     <div>
                        <span class="btn btn-primary btn-file btn-xs"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="menu_icon" id="menu_icon"></span>
                        <a href="#" class="btn btn-danger fileinput-exists btn-xs" data-dismiss="fileinput">Remove</a>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                  <span class="validation_info">Tile Image must be <b>atleast 10 X 10 px and at max 100 X 100</b>. Image type allowed is <b>png , jpg , jpeg</b></span>
                  <span class="error"><?php echo form_error('menu_icon'); ?> </span>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-2 control-label">Mega Menu Image<span class="mandatory">*</span></label>
               <div class="col-lg-9">
                  <div class="fileinput fileinput-new" data-provides="fileinput">
                     <div class="fileinput-preview thumbnail" data-trigger="fileinput">
                        <?php
                           if(!empty($parentRow->menu_image) && file_exists("assets/uploads/backend/category_img/menu/".$parentRow->menu_image)){
                        ?>
                        <img src="<?php echo base_url().'assets/uploads/backend/category_img/menu/'.$parentRow->menu_image; ?>" data-src="holder.js/100%x100%" alt="...">
                        <?php }else{ ?>
                        <img src="<?php echo  BACKEND_THEME_URL ?>images/default_image.png" data-src="holder.js/100%x100%" alt="...">
                        <?php } ?>
                     </div>
                     <div>
                        <span class="btn btn-primary btn-file btn-xs"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="menu_image" id="menu_image"></span>
                        <a href="#" class="btn btn-danger fileinput-exists btn-xs" data-dismiss="fileinput">Remove</a>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                  <span class="validation_info">Tile Image must be <b>atleast 300 X 300 px and at max 500 X 500</b>. Image type allowed is <b>png , jpg , jpeg</b></span>
                  <span class="error"><?php echo form_error('menu_image'); ?> </span>
               </div>
            </div>
            <?php } ?>
            <div class="form-group">
               <label class="col-md-2 control-label">Tile<span class="mandatory">*</span></label>
               <div class="col-lg-9">
                  <div class="fileinput fileinput-new" data-provides="fileinput">
                     <div class="fileinput-preview thumbnail" data-trigger="fileinput">
                        <?php
                           if(!empty($parentRow->logo_image) && file_exists("assets/uploads/backend/category_img/logo/".$parentRow->logo_image)){
                        ?>
                        <img src="<?php echo base_url().'assets/uploads/backend/category_img/logo/'.$parentRow->logo_image; ?>" data-src="holder.js/100%x100%" alt="...">
                        <?php }else{ ?>
                        <img src="<?php echo  BACKEND_THEME_URL ?>images/default_image.png" data-src="holder.js/100%x100%" alt="...">
                        <?php } ?>
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
               <label class="col-md-2 control-label">Banner Image<span class="mandatory">*</span></label>
               <div class="col-lg-9">
                  <div class="fileinput fileinput-new" data-provides="fileinput">
                     <div class="fileinput-preview thumbnail" data-trigger="fileinput">
                        <?php
                           if(!empty($parentRow->banner_image) && file_exists("assets/uploads/backend/category_img/banner/".$parentRow->banner_image)){
                        ?>
                        <img src="<?php echo base_url().'assets/uploads/backend/category_img/banner/'.$parentRow->banner_image; ?>" data-src="holder.js/100%x100%" alt="...">
                        <?php }else{ ?>
                        <img src="<?php echo  BACKEND_THEME_URL ?>images/default_image.png" data-src="holder.js/100%x100%" alt="...">
                        <?php } ?>
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
               <label class="col-md-2 control-label">Display Order</label>
               <div class="col-md-9">
                  <input type="text" placeholder="Display Order" class="form-control" name="order_by" value="<?php if(set_value('order_by')) echo set_value('order_by'); else echo $parentRow->order_by; ?>" > <span class="error"><?php echo form_error('order_by'); ?> </span>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-2 control-label">Status</label>
               <div class="col-md-9">
                  <select class="form-control" name="category_status" >
                  <?php 
                     $status = status();
                     foreach ($status as $key => $value) { 
                  ?>
                     <option value="<?php echo $key; ?>" <?php if($parentRow->status==$key) echo 'selected'; ?>><?php echo $value; ?></option>
                  <?php } ?>
                  </select>
                  <span class="error"><?php echo form_error('category_status'); ?> </span>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-2 control-label">Show in Menu</label>
               <div class="col-md-9">
                  <select class="form-control" name="is_menu" >
                     <option value="0" <?php if($parentRow->is_menu==0) echo "selected"; ?>>No</option>
                     <option value="1" <?php if($parentRow->is_menu==1) echo "selected"; ?>>Yes</option>
                  </select>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-2 control-label">Popular Categories</label>
               <div class="col-md-9">
                  <select class="form-control" name="is_home" >
                     <option value="0" <?php if($parentRow->is_home==0) echo "selected"; ?>>No</option>
                     <option value="1" <?php if($parentRow->is_home==1) echo "selected"; ?>>Yes</option>
                  </select>
               </div>
            </div>
            <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i> SEO/Meta Data (Optional)</header>
            <br> 
            <div class="form-group">
               <label class="col-md-2 control-label">Meta Title</label>
               <div class="col-md-9">
                  <input type="text" placeholder="Meta Title" class="form-control" name="meta_title" value="<?php if(set_value('meta_title')) echo set_value('meta_title'); else echo $parentRow->meta_title; ?>" > <span class="error"><?php echo form_error('meta_title'); ?> </span>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-2 control-label">Meta Keywords</label>
               <div class="col-md-9">
                  <textarea class="form-control" placeholder="Meta Keywords" name="meta_keyword" ><?php if(set_value('meta_keyword')) echo set_value('meta_keyword'); else echo $parentRow->meta_keyword; ?></textarea>
                  <span class="error"><?php echo form_error('meta_keyword'); ?> </span>
               </div>
            </div>
            <div class="form-group">
               <label class="col-md-2 control-label">Meta Description</label>
               <div class="col-md-9">
                  <textarea class="form-control" placeholder="Meta Description" name="meta_description" ><?php if(set_value('meta_description')) echo set_value('meta_description'); else echo $parentRow->meta_description; ?></textarea>
                  <span class="error"><?php echo form_error('meta_description'); ?> </span>
               </div>
            </div>
            <div class="form-actions fluid">
               <div class="col-md-offset-2 col-md-10">
                  <a class="btn btn-danger" href="<?php echo base_url()?>backend/Category/add_category">Back</a>
                  <button  class="btn btn-primary" type="submit">Submit</button>
                  <a onclick="return confirmBox('Do you want to delete it ?','<?php echo base_url().'backend/Category/delete/'.$parentRow->category_id; ?>')" rel="tooltip" data-placement="top" data-original-title="Delete <?php echo $parentRow->category_name; ?>" onclick="if(confirm('Do you want to delete it ?')){return true;} else {return false;}" class="cross btn btn-danger tooltips">Delete</a>
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