<div class="bread_parent">
   <ul class="breadcrumb">
      <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
      <li><a href="<?php echo base_url('backend/slider/sliders'); ?>">HomePage Banners </a></li>
      <li><a href="<?php echo base_url('backend/slider/slider_add'); ?>"><b>Add Banner Details</b> </a></li>
   </ul>
</div>
<div class="panel-body">
   <!-- BEGIN FORM-->
   <form enctype= "multipart/form-data" class="form-horizontal" method="post" action="<?php echo current_url()?>">
      <?php echo $this->session->flashdata('msg_error');?>
      <div class="form-body">
         <div class="form-group">
            <label class="col-md-3 control-label">Banner Image <span class="mandatory">*</span></label>
            <div class="col-md-4">                   
               <input type="file" name="slider_file" >
               <?php echo form_error('slider_file'); ?>               
               <span class="validation_info">Slider image needs to be exactly 1300 X 400 pixel. And allowed file type are jpg,jpeg,png </span>
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-3 control-label">Banner Redirection link </label>
            <div class="col-md-6 input-group m-bot15">   
               <span class="input-group-addon"><?php echo base_url() ?></span>                
               <input type="text" class="form-control" name="main_img_link" value="<?php echo set_value('main_img_link'); ?>" >
            </div>
            <?php echo form_error('main_img_link'); ?>               
         </div>
         <div class="form-group">
            <label class="col-md-3 control-label">Order Sequence<span class="mandatory">*</span></label>
            <div class="col-md-4">
               <input type="text" class="form-control" name="order" value="<?php echo set_value('order'); ?>" >
               <?php echo form_error('order'); ?>                 
            </div>
         </div>
      </div>
      <hr>
      <div class="form-actions fluid">
         <div class="col-md-offset-3 col-md-9">
            <button  class="btn btn-primary" type="submit">Submit</button>
            <a href="<?php echo base_url()?>backend/slider/sliders">
            <button class="btn btn-danger" type="button">Cancel</button>  </a>                            
         </div>
      </div>
   </form>
   <!-- END FORM--> 
</div>