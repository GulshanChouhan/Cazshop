<div class="bread_parent">
   <ul class="breadcrumb">
      <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
      <li><a href="<?php echo base_url('backend/slider/sliders'); ?>">HomePage Banners </a></li>
      <li><a href="<?php echo base_url('backend/slider/slider_edit/'.$sliders->slider_images_id); ?>"><b>Edit Banner Details</b> </a></li>
   </ul>
</div>
<?php //echo "<pre>"; print_r($sliders); exit;?>
<div class="panel-body">
   <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">
      <?php echo $this->session->flashdata('msg_error');?>
      <div class="form-body">
         <div class="form-group">
            <label class="col-md-3 control-label">Banner Image</label>
            <div class="col-md-4"> 
               <img  class="img_size" src="<?php echo base_url().$sliders->slider_img;?>">              
               <input type="file" name="slider_file" ><br>
               <span class="validation_info">Slider image needs to be exactly 1300 X 400 pixel. And allowed file type are jpg,jpeg,png. </span>
               <?php echo form_error('slider_file'); ?>               
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-3 control-label">Banner Redirection link</label>
            <div class="col-md-6 ">
               <div class="col- md-4 input-group m-bot15">   
                  <span class="input-group-addon"><?php echo base_url() ?></span>                
                  <input type="text" class="form-control" name="main_img_link" value="<?php if(!empty($sliders->slider_img_link)){ echo $sliders->slider_img_link; }else{ echo set_value('main_img_link'); } ?>" >
               </div>
               <?php echo form_error('main_img_link'); ?>               
            </div>
         </div>
         <div class="form-group">
            <label class="col-md-3 control-label">Order Sequence<span class="mandatory">*</span></label>
            <div class="col-md-4">
               <input type="text" class="form-control" name="order" value="<?php if(!empty($sliders->order)){ echo $sliders->order; }else{ echo set_value('order'); } ?>" >
               <?php echo form_error('order'); ?>                 
            </div>
         </div>
      </div>
      <hr>
      <div class="form-actions fluid">
         <div class="col-md-offset-2 col-md-10">
            <button  class="btn btn-primary" type="submit">Update</button>
            <a class="btn btn-danger" href="<?php echo base_url()?>backend/slider/sliders">
            Cancel</a>                              
         </div>
      </div>
   </form>
   <!-- END FORM--> 
</div>