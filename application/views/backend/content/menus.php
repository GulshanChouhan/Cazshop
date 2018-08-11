 <?php $menu_section=''; $menu_section = menu_section(); ?>
<div class="bread_parent">
  <div class="col-md-10">
  <ul class="breadcrumb">
      <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
       <li><a href="<?php echo base_url('backend/content/menus'); ?>"><b>Menu</b> </a></li>       
  </ul>
  </div>
  <div class="col-md-2">
    <div class="btn-group pull-right">
       <a class="btn btn-primary btn-toggle-link tooltips" id="add" rel="tooltip" data-placement="left" data-original-title="Click to add new menu">Add New Menu
        <i class="icon-plus"></i></a>
     </div>
  </div>
  <div class="clearfix"></div>
</div><br>
 <div id="tab1"> 
  <div class="panel-body div_border toggle-inner-panel" id="form" style="<?php if(isset($_POST['add'])) echo"display:block"; else ?>display:none;" >  
    <div class="panel-body">
      <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post" id="form_valid"> 
          <input type="hidden" name="action_type" value="1">
          <?php echo $this->session->flashdata('msg_error');    ?>
          <div class="form-body">
            
            <div class="form-group">
              <label class="col-md-2 control-label">Menu Section<span class="mandatory">*</span></label>
              <div class="col-md-6">
                    <select name="menu_section" class="form-control">
                      <?php if(!empty($menu_section)){
                        foreach ($menu_section as $key => $value) { ?>
                         <option  value="<?php echo $key; ?>"><?php echo $value; ?></option>  
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
                         <option  value="<?php echo $value->id; ?>"><?php echo $value->menu_title; ?></option>  
                     <?php } } ?>   
                    </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">Menu Title<span class="mandatory">*</span></label>
              <div class="col-md-6">
                <input type="text" placeholder="Menu Title" class="form-control" name="menu_title" value="<?php echo set_value('menu_title');?>" data-bvalidator="required" data-bvalidator-msg="Menu Title required"><?php echo form_error('menu_title'); ?>
              </div>
            </div>
          
              <div class="form-group">
              <label class="col-md-2 control-label">Menu Link type<span class="mandatory">*</span></label>
              <div class="col-md-6">                
                   <select id="link_type" name="link_type" class="form-control">
                      <option  value="1">Site Page link</option> 
                      <option  value="3">Site Link</option>  
                      <option  value="2">Custom Link</option>  
                    </select>
              </div>
            </div>
             <div id="site_page_link" class="form-group" >
              <label class="col-md-2 control-label">Site Page Link<span class="mandatory">*</span></label>
              <div class="col-md-6">
               <div class="input-group m-bot15">   
                      <span class="input-group-addon"><?php echo base_url() ?></span>
                      <select id="link" name="site_page_link" class="form-control"  data-bvalidator="required" data-bvalidator-msg="Site Page Link required">
                      <?php if(!empty($pages)){  ?>
                            <!--  <option>Select the page slug</option> -->
                      <?php  foreach ($pages as  $value) { ?>
                             <option value="<?php echo $value->page_slug ?>"><?php echo $value->page_slug ?></option>
                     <?php }
                       }else{ ?>
                             <option value="">No Pages Available</option>
                     <?php  } ?>
                    </select>
               </div>
               <?php echo form_error('site_page_link'); ?>
              </div>
            </div>
            <div id="site_link" class="form-group" style="display:none;" >
              <label class="col-md-2 control-label">Site Link<span class="mandatory">*</span></label>
              <div class="col-md-6">
               <div class="input-group m-bot15">   
                      <span class="input-group-addon"><?php echo base_url() ?></span>
                         <input type="text" class="form-control" name="site_link" value="<?php echo set_value('site_link'); ?>"  data-bvalidator="required" data-bvalidator-msg="Site Link required">
               </div>
               <?php echo form_error('site_link'); ?>
              </div>
            </div>
            <div id="custom_link" class="form-group" style="display:none;">
              <label class="col-md-2 control-label">Custom Link<span class="mandatory">*</span></label>
              <div class="col-md-6">
                  <input type="text" class="form-control" pattern="https?://.+" title="Include http://" name="custom_link" value="<?php echo set_value('custom_link'); ?>" data-bvalidator="required" data-bvalidator-msg="Custom Link required" >
               <?php echo form_error('custom_link'); ?>
               <span class="validation_info">Add http:// or https:// while adding the custom link</span>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label">Menu Order<span class="mandatory">*</span></label>
              <div class="col-md-6">
                <input type="text" placeholder="Menu Order" class="form-control" name="order" value="<?php echo set_value('order');?>" data-bvalidator="required" data-bvalidator-msg="order required" ><?php echo form_error('order'); ?>
              </div>
            </div>           
          </div>          
          <div class="form-actions fluid">
            <div class="col-md-offset-2 col-md-10">
              <button  class="btn btn-primary" name="add" type="submit">Add New Menu</button>
              </div>
            </div>
          </form>
          <!-- END FORM--> 
        </div>
       </div> 
         <!--table -->
<div class="panel-body">
  <div class="adv-table">
    <form enctype= "multipart/form-data" class="form-horizontal" id="form" method="post" action="<?php echo current_url()?>" >
      <input type="hidden" name="action_type" value="2">
    <table id="datatable_example" class="responsive table table-striped " >
      <thead class="thead_color">
        <tr>
          <th class="jv no_sort">#</th>
          <th class="jv no_sort"> Menu Section</th>
          <th class="no_sort">Menu Title</th>   
          <th class="no_sort">Menu Linking</th>   
          <th width="10%" class="no_sort">Menu Order</th>                  
          <th class="to_hide_phone ue no_sort">Status</th>
          <th class="to_hide_phone span2">Created</th>
          <th class="ms no_sort ">Actions</th>
        </tr>
      </thead>
      <tbody>

        <?php 
        if(!empty($menu)):
          $i=$offset; foreach($menu as $row): 
        $i++;?>
        <tr>
          <td><?php echo $i.".";?></td>
          <td>
             <?php $menu_section_class=''; $menu_section_class = menu_section_class($row->menu_section); 
               $menu_section_color=''; $menu_section_color = menu_section_color($row->menu_section);
              ?>
           <div class="<?php if(!empty($menu_section_color)){ echo $menu_section_color; }  ?>"> <?php echo $menu_section_class ?></div>
          </td>
          <td><?php echo $row->menu_title ?></td> 
          <td>
            <?php if($row->link_type==1 || $row->link_type==3){
                     if(!empty($row->rediredt_link)){ echo base_url().$row->rediredt_link; }               
                  }else{
                     if(!empty($row->rediredt_link)){ echo $row->rediredt_link; } 
                  }      
             ?>
          </td>          
          <td> <input class="form-control" type="text" name="order[<?php echo $row->id; ?>]" value="<?php if(!empty($row->order)) { echo $row->order; }else{ echo set_value('order'); } ?>"/>    </td>

                         
          <td class="to_hide_phone">
            <?php if($row->status==1){ ?>
            <a class="label label-success label-mini tooltips" href="<?php echo base_url('backend/content/changeuserstatus_t/'.$row->id.'/'.$row->status.'/'.$offset.'/menu_footer')?>" rel="tooltip" data-placement="top" data-original-title="Change Status" >Active </a> 
            <?php } 
            else{ ?><a class="label label-warning label-mini tooltips"  href="<?php echo base_url('backend/content/changeuserstatus_t/'.$row->id.'/'.$row->status.'/'.$offset.'/menu')?>" rel="tooltip" data-placement="top" data-original-title="Change Status" > Deactive </a> 
            <?php } ?>
          </td>
          <td class="to_hide_phone"><i class="fa fa-calendar"></i> <?php echo date('d M Y,h:i  A',strtotime($row->created)); ?></td>
          <td class="ms">
           
              <a href="<?php echo base_url().'backend/content/menu_edit/'.$row->id.'/'.$offset?>"  class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" Edit ">
                <i class="icon-pencil"></i> 
              </a> 
              <a style="display:none;" href="<?php echo base_url().'backend/content/menu_delete/'.$row->id.'/'.$offset?>" class="btn btn-danger btn-xs tooltips" rel="tooltip" rel="tooltip" data-placement="top" data-original-title="Remove" onclick="if(confirm('Do you want to delete it ?')){return true;} else {return false;}" >
                <i class="icon-trash "></i></a> 
            </td>
          </tr> 
        <?php  endforeach; ?>
       <tr> <td colspan="8">
            <button type="submit" class="btn btn-primary pull-right tooltips" rel="tooltip" data-placement="left" data-original-title="Update order Sequence" name="update">
            <i class="fa fa-repeat"></i> Update Order Sequence </button>
        </td>
      </tr> 
      <?php else: ?>
        <tr>
          <th colspan="6"  class="msg"> <center>No Menu Found.</center></th>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
 </form> 

  <div class="row-fluid  control-group mt15">             

    <div class="span12">
      <?php if(!empty($pagination))  echo $pagination;?>              
    </div>

  </div>
</div>
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
