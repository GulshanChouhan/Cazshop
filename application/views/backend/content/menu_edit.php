<div class="bread_parent">
<ul class="breadcrumb">
    <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
     <li><a href="<?php echo base_url('backend/content/menus'); ?>">Menus </a></li>
      <li><a href=""><b>Edit Menus</b> </a></li>         
</ul>
</div> 
  <div class="panel-body">
      <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post" id="form_valid">
          <?php echo $this->session->flashdata('msg_error');?>
          <div class="form-body label-static">
            <div class="form-group">
              <label class="col-md-2 control-label">Menu Section<span class="mandatory">*</span></label>
              <div class="col-md-6">
                 <?php $menu_section=''; $menu_section = menu_section(); ?>
                   <select name="menu_section" class="form-control">
                      <?php if(!empty($menu_section)){
                        foreach ($menu_section as $key => $value) { ?>
                         <option <?php if(!empty($menu->menu_section) && ($menu->menu_section==$key)){ echo "selected"; } ?>  value="<?php echo $key; ?>"><?php echo $value; ?></option>  
                     <?php } } ?>   
                    </select>
              </div>
            </div>
             <div class="form-group">
              <label class="col-md-2 control-label">Parent Menu</label>
              <div class="col-md-6">
                    <select name="parent_id" class="form-control">
                      <option value="">Select Parent Menu</option>
                      <?php if(!empty($parent_menu)){
                        foreach ($parent_menu as $key => $value) { ?>
                         <option  value="<?php echo $value->id; ?>" <?php if($value->id==$menu->parent_id) echo "selected"; ?>><?php echo $value->menu_title; ?></option>  
                     <?php } } ?>   
                    </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">Menu Title<span class="mandatory">*</span></label>
              <div class="col-md-6">
                <input type="text" placeholder="Menu Title" class="form-control" name="menu_title" value="<?php if(!empty($menu->menu_title)){ echo $menu->menu_title; }else{ echo set_value('menu_title'); } ?>" data-bvalidator="required" data-bvalidator-msg="Menu Title required"><?php echo form_error('menu_title'); ?>
              </div>
            </div>
              <div class="form-group">
              <label  class="col-md-2 control-label">Menu Link type<span class="mandatory">*</span></label>
              <div class="col-md-6">                
                 <select id="link_type" name="link_type" class="form-control">
                    <option <?php if(!empty($menu->link_type) && ($menu->link_type==1)){ echo "selected"; } ?>  value="1">Site Page link</option> 
                    <option <?php if(!empty($menu->link_type) && ($menu->link_type==3)){ echo "selected"; } ?> value="3">Site Link</option>  
                    <option <?php if(!empty($menu->link_type) && ($menu->link_type==2)){ echo "selected"; } ?> value="2">Custom Link</option> 
                 </select>
              </div>
            </div>
             <div class="form-group" id="site_page_link" style="<?php if(!empty($menu->link_type) && ($menu->link_type==1)){ echo 'display:block'; }else{  echo 'display:none';} ?>">
              <label class="col-md-2 control-label">Site Page Link<span class="mandatory">*</span></label>
              <div class="col-md-6">
                <div class="input-group m-bot15">   
                      <span class="input-group-addon"><?php echo base_url() ?></span>                
                      <select id="link" name="site_page_link" class="form-control" data-bvalidator="required" data-bvalidator-msg="Site Page Link required">
                      <?php if(!empty($pages)){  ?>
                            <!--  <option>Select the page</option> -->
                      <?php  foreach ($pages as  $value) { ?>
                             <option <?php if($value->page_slug==$menu->rediredt_link){ echo "selected"; } ?> value="<?php echo $value->page_slug ?>"><?php echo $value->page_slug ?></option>
                     <?php }
                       }else{ ?>
                             <option value="">No Pages Available</option>
                     <?php  } ?>
                    </select>
               </div>
                <?php echo form_error('site_page_link'); ?>
              </div>
            </div>
             <div id="site_link" class="form-group" style="<?php if(!empty($menu->link_type) && ($menu->link_type==3)){ echo 'display:block'; }else{  echo 'display:none';} ?>" >
              <label class="col-md-2 control-label">Site Link<span class="mandatory">*</span></label>
              <div class="col-md-6">
               <div class="input-group m-bot15">   
                      <span class="input-group-addon"><?php echo base_url() ?></span>
                         <input type="text" class="form-control" name="link" value="<?php if(!empty($menu->rediredt_link)){ echo $menu->rediredt_link; }else{ echo set_value('link'); } ?>"  data-bvalidator="required" data-bvalidator-msg="Site Link required" >
               </div>
               <?php echo form_error('link'); ?>
              </div>
            </div>

            <div id="custom_link" class="form-group" style="<?php if(!empty($menu->link_type) && ($menu->link_type==2)){ echo 'display:block'; }else{  echo 'display:none';} ?>">
              <label class="col-md-2 control-label">Custom Link<span class="mandatory">*</span></label>
              <div class="col-md-6">
                  <input type="text" class="form-control" name="custom_link" pattern="https?://.+" title="Include http://" value="<?php if(!empty($menu->rediredt_link)  && ($menu->link_type==2)){ echo $menu->rediredt_link; }else{ echo set_value('link'); } ?>" data-bvalidator="required" data-bvalidator-msg="Custom Link required" >
               <?php echo form_error('custom_link'); ?>
                <span class="validation_info">Add http:// or https:// while adding the custom link</span>
              </div>
            </div>
          </div>          
          <div class="form-actions fluid">
            <div class="col-md-offset-2 col-md-10">
              <button  class="btn btn-primary" name="submit" type="submit">Update</button>
              <a class="btn btn-danger" href="<?php echo base_url()?>backend/content/menus">
               Cancel</a>                              
              </div>
            </div>
          </form>
<!-- END FORM--> 
</div>

<script>
$(document).ready(function () {
$('#link_type').change(function(event) {
  if($('#link_type').val()==2){   
    $('#custom_link').css('display', 'block');
    $('#site_page_link').css('display', 'none');
    $('#site_link').css('display', 'none');   
  }else if($('#link_type').val()==1){
    $('#custom_link').css('display', 'none');
    $('#site_page_link').css('display', 'block');   
    $('#site_link').css('display', 'none');
  }else if($('#link_type').val()==3){
    $('#custom_link').css('display', 'none');
    $('#site_page_link').css('display', 'none');   
    $('#site_link').css('display', 'block');
  }else{
    $('#custom_link').css('display', 'block');
    $('#site_page_link').css('display', 'none');  
    $('#site_link').css('display', 'none'); 
  }
});
});
</script>
