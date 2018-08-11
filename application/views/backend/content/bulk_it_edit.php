<div class="bread_parent">
<ul class="breadcrumb">
    <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
    <li><a href="<?php echo base_url('backend/slider/sliders'); ?>">Home Page Setting</a></li>
     <li><a href="<?php echo base_url('backend/content/bulk_it'); ?>">Shop the stores</a></li>  
    <li><a href=""><b>Shop the stores edit</b> </a></li>               
</ul>
</div> 
        <div class="panel-body">
              <!-- BEGIN FORM-->
              <form enctype= "multipart/form-data" class="form-horizontal" id="form" method="post" action="<?php echo current_url()?>" >

              <?php echo $this->session->flashdata('msg_error');?>
                 <div class="form-body">
                 
                <div class="form-group">
                  <label class="col-md-3 control-label"> <?php if($bulk_content->type==1){ echo 'Shop Header Content'; }else{ echo 'Shop Slider Content';  } ?> :<span class="mandatory">*</span> </label>
                  <div class="col-md-8">
                  <input type="hidden" name="type" value="<?php echo $bulk_content->type;  ?>"> 
                 <!--  <textarea disabled="true" cols="113" rows="3"> <?php if($bulk_content->type==1){ echo 'Header Content Format : <h3>Use our <a href="#"> Quick Quote</a> calculator and receive an instant estimate!</h3><h4>Ordering in Bulk Works For</h4>'; }else{ echo 'Slider Content Format :<div><strong>TEAMS</strong></div><strong><a>Teams</a> <a>Associations</a> <a>Leagues</a></strong>';  } ?>
                  </textarea> -->

                  <textarea  class="tinymce_edittor form-control"  name="title1" > 
                   <?php if(!empty($bulk_content->title1)){ echo $bulk_content->title1; }else{ echo set_value('title1'); } ?></textarea>    
                    <?php echo form_error('title1'); ?>        
                    </div>
                </div>     

              <div class="form-group">
                   <label class="col-md-3 control-label"><?php if($bulk_content->type==1){ echo 'Shop  Background Image'; }else{ echo 'Shop Slider Image';  } ?> :</label>
                    
                  <div class="col-md-4">
                    <?php if(!empty($bulk_content->bulk_it_img)){ ?>
                         <img class="img_size" src="<?php echo base_url().$bulk_content->bulk_it_img   ?>">
                    <?php } ?><br><br>
                    <input type="file" name="bulk_it_img"> 
                    <?php if($bulk_content->type==1){ ?>
                     <span class="validation_info">Background image needs  to be atleast 1240 x 560 pixels. </span> 
                   <?php }else{ ?>
                    <span class="validation_info">Shop Slider image needs to be atleast 60 X 60 pixel and at max 250 X 250 pixels. </span> 
                   <?php } ?>  
                    <?php echo form_error('bulk_it_img'); ?>
                  </div>
                </div>  
                 </div>
                 <div class="form-actions fluid">
                    <div class="col-md-offset-3 col-md-9">
                       <button  class="btn btn-primary" name="update" type="submit">Update Shop Slider Image Content</button>
                       <a href="<?php echo base_url()?>backend/content/bulk_it">
                       <button class="btn btn-danger" type="button">Cancel</button>  </a>                            
                    </div>
                 </div>
              </form>
              <!-- END FORM--> 
           </div>


     


        
