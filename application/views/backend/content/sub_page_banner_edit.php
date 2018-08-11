<div class="bread_parent">
<ul class="breadcrumb">
    <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
    <li><a href="<?php echo base_url('backend/content/sub_page_banner'); ?>">Sub Page Banners</a></li>
     <li><a href=""><b>Edit  store Banner</b></a></li>
</ul>
</div>

 <div class="panel-body ">
 <div class="tab-pane row-fluid fade in active"  >
 <form class="form-horizontal tasi-form" role="form" method="post" action="<?php echo current_url()?>" enctype="multipart/form-data" id="form_valid">   
     <input type="hidden" name="type_action" value="1">   
    <div class="form-body">
       <div class="form-group">   
              <label class="col-md-3 control-label"><span class="mandatory">*</span> Page Name : </label>
               <div class="col-md-6">
                <select name="page_name" class="form-control" data-bvalidator-msg="Page Name required" data-bvalidator="required" >
                    <option <?php if($banner_info->page_id==1){ echo "selected"; } ?>  value="1">Create your store</option>
                    <option <?php if($banner_info->page_id==2){ echo "selected"; } ?> value="2">Find your Store</option>
                </select>         
                </div>                        
         </div> 
        <div class="form-group">
            <label class="col-md-3 control-label"> Title : </label>
            <div class="col-md-6">
                <input type="text" name="title"  class="form-control" value="<?php if(!empty($banner_info->title)){ echo $banner_info->title; }else{echo set_value('title'); }?>" >
             <?php echo form_error('title') ?>
              </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"> Sub title1 : </label>
            <div class="col-md-6">
              <textarea class="form-control" cols="150" rows="4" name="sub_title1"><?php if(!empty($banner_info->sub_titile_1)){ echo $banner_info->sub_titile_1; }else{echo set_value('sub_title1'); }?></textarea><?php echo form_error('sub_title1'); ?>               
              </div>
        </div>
         <div class="form-group">   
              <label class="col-md-3 control-label"><span class="mandatory">*</span> Content Alignment : </label>
               <div class="col-md-6">
                <select name="content_alignment" class="form-control" data-bvalidator-msg="Page Name required" data-bvalidator="required" >
                    <option <?php if($banner_info->content_alignment==1){ echo "selected"; } ?> value="1">Left</option>
                    <option <?php if($banner_info->content_alignment==2){ echo "selected"; } ?> value="2">Right</option>
                    <option <?php if($banner_info->content_alignment==3){ echo "selected"; } ?> value="3">Center</option>
                </select>         
                </div>                        
         </div> 
        <div class="form-group">
            <label class="col-md-3 control-label"><span class="mandatory">*</span> Banner Image : </label>
            <div class="col-md-6">
              <?php if($banner_info->banner_image){ ?>
                <div style="width: 200px;" class="fileupload-new thumbnail">
                    <img alt="" src="<?php echo base_url().$banner_info->banner_image;?>">
                </div>
               <?php } ?>
               <b>Want to update banner image</b>
                <input type="file" name="banner_img" class="btn default btn-file">
              <span class="validation_info">Banner image needs to be exactly 1600 X 200 pixel. Allowed file type is jpg,jpeg and png. </span>  

              <?php echo form_error('banner_img'); ?> 
              </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-3 col-md-9">
              <button class="btn btn-primary" type="submit">Add Banner</button>
              <a class="btn btn-danger btn-md tooltips" href="<?php echo base_url().'backend/content/sub_page_banner' ?>" rel="tooltip" data-placement="right" title="" data-original-title="Back to the Sub page banner"><i class="icon-remove"></i>
               Cancel</a>
              </div>
            </div>
            </div>
     </form>
     </div>
</div>     
