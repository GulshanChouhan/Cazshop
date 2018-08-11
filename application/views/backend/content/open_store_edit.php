<div class="bread_parent">
<ul class="breadcrumb">
    <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
    <li><a href="<?php echo base_url('backend/slider/sliders'); ?>">Home Page Setting</a></li>
    <li><a href="<?php echo base_url('backend/content/open_store'); ?>">Open Store</a></li> 
   
    <li><a href=""><b>Open Store edit</b> </a></li>   
           
</ul>
</div> 
        <div class="panel-body">
              <!-- BEGIN FORM-->
              <form enctype= "multipart/form-data" class="form-horizontal" id="form" method="post" action="<?php echo current_url()?>" >
              <?php echo $this->session->flashdata('msg_error');?>
                 <div class="form-body">
                    <div class="form-group">
                      <label class="col-md-2 control-label"> Type : </label>
                        <div class="col-md-4">
                          <?php if($open_store->type==1){ echo 'Center Content'; }
                          else{ echo "Side Content";
                          } ?> 
                          <input type="hidden" name="type" value="<?php echo $open_store->type; ?>" placeholder="">
                        </div>
                    </div> 
                    <div class="form-group">
                      <label class="col-md-2 control-label"> Title1 <span class="mandatory">*</span> </label>
                        <div class="col-md-8">
                            <textarea class="form-control" cols="150" rows="2" name="title1" placeholder="Title1" data-bvalidator-msg="Main Sub title required" data-bvalidator="required"><?php if(!empty($open_store->title1)){ echo $open_store->title1; }else{ echo set_value('title1'); } ?></textarea><?php echo form_error('title1'); ?>
                        </div>
                    </div> 
                    <div class="form-group">
                      <label class="col-md-2 control-label">Title2 <span class="mandatory">*</span> </label>
                        <div class="col-md-8">
                          <textarea class="form-control" cols="150" rows="2" name="title2" placeholder="Title2" data-bvalidator-msg="Main Sub title required" data-bvalidator="required"><?php if(!empty($open_store->title2)){ echo $open_store->title2; }else{ echo set_value('title2'); } ?></textarea><?php echo form_error('title2'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">Title3  </label>
                        <div class="col-md-8">
                           <textarea class="form-control" cols="150" rows="2" name="title3" placeholder="Title3" data-bvalidator-msg="Main Sub title required" data-bvalidator="required"><?php if(!empty($open_store->title3)){ echo $open_store->title3; }else{ echo set_value('title3'); } ?></textarea><?php echo form_error('title3'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-2 control-label">Link to redired : </label>          
                      <div class="col-md-8 input-group m-bot15">
                         <span class="input-group-addon"><?php echo base_url() ?></span>
                           <input type="text" placeholder="Add the link address to redirect" class="form-control" name="page_to_redirect" value="<?php if(!empty($open_store->open_store_link)){ echo $open_store->open_store_link; }else{ echo set_value('page_to_redirect'); }?>"><?php echo form_error('page_to_redirect'); ?>
                      </div>          

                    </div>
                    <div class="form-group">
                         <label class="col-md-2 control-label">Open Store Image <span class="mandatory">*</span> </label>
                        <div class="col-lg-6">
                          <?php if(!empty($open_store->open_store_image)){  ?>
                            <div class="col-lg-4">
                                <div class="fileupload-new thumbnail">
                                  <img alt="" src="<?php echo base_url().$open_store->open_store_image ?>">
                                </div>
                            </div>  
                         <?php } ?>   
                        <div class="col-lg-6 no-padding-left">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-preview thumbnail" data-trigger="fileinput">
                                    <img src="<?php echo BACKEND_THEME_URL ?>img/default_images/common_img.png" data-src="holder.js/100%x100%" alt="...">
                                </div>
                                <div>
                                    <span class="btn btn-primary btn-xs btn-file"><span class="fileinput-new">Update image</span><span class="fileinput-exists">Change</span><input type="file" name="store_open_img"></span>
                                       <a href="#" class="btn btn-danger fileinput-exists btn-xs" data-dismiss="fileinput">Remove</a>
                                </div>
                            </div>
                            <?php echo form_error('store_open_img'); ?>
                        </div>   
                        <div class="clearfix"></div>
                           <b class="validation_info">Logo Image must be atleast 350 X 190 px and at max 525 X 280 px.Image allowed type is png , jpg , jpeg</b>
                        </div>
                    </div>
                    </div>                   
                    
                 </div>
                 <div class="form-actions fluid">
                    <div class="col-md-offset-3 col-md-9">
                       <button  class="btn btn-primary" name="update" type="submit">Update</button>
                       <a href="<?php echo base_url()?>backend/content/open_store">
                       <button class="btn btn-danger" type="button">Cancel</button>  </a>                            
                    </div>
                 </div>
              </form>
              <!-- END FORM--> 
           </div>