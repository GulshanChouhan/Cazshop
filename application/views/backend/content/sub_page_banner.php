<div class="bread_parent">

<div class="col-md-9">
<ul class="breadcrumb">
    <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
    <li><a href="<?php echo base_url('backend/content/sub_page_banner'); ?>"><b>Sub Page Banners</b></a></li>    
</ul>
</div>
<div class="col-md-3">
  <div class="btn-group pull-right">
    <a class="btn btn-primary btn-toggle-link tooltips" id="add" data-original-title="Click to add new page banner">
        Add New Pages Banner &nbsp;<i class="fa fa-chevron-down"></i>
    </a>
 </div> 
</div>
<div class="clearfix"></div>
</div>

<div class="panel-body ">    
   
 <div class="tab-pane row-fluid fade in active  toggle-inner-panel" id="form" style="<?php if(!empty($_POST)) echo"display:block"; else ?>display:none;">
 <form class="form-horizontal tasi-form" role="form" method="post" action="<?php echo current_url()?>" enctype="multipart/form-data" id="form_valid">   
     <input type="hidden" name="type_action" value="1">   
    <div class="form-body">
       <div class="form-group">   
              <label class="col-md-3 control-label"><span class="mandatory">*</span> Page Name : </label>
               <div class="col-md-6">
                <select name="page_name" class="form-control" data-bvalidator-msg="Page Name required" data-bvalidator="required" >
                    <option value="1">Create your store</option>
                    <option value="2">Find your Store</option>
                </select>         
                </div>                        
         </div> 
        <div class="form-group">
            <label class="col-md-3 control-label"> Title : </label>
            <div class="col-md-6">
                <input type="text" name="title"  class="form-control" value="<?php echo set_value('title');?>"  data-bvalidator-msg="Title required" data-bvalidator="required">
             <?php echo form_error('title') ?>
              </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label"> Sub title1 : </label>
            <div class="col-md-6">
              <textarea class="form-control" cols="150" rows="4" name="sub_title1" data-bvalidator-msg="Sub title1 required" data-bvalidator="required"><?php echo set_value('sub_title1');?></textarea><?php echo form_error('sub_title1'); ?>               
              </div>
        </div>
         <div class="form-group">   
              <label class="col-md-3 control-label"><span class="mandatory">*</span> Content Alignment : </label>
               <div class="col-md-6">
                <select name="content_alignment" class="form-control" data-bvalidator-msg="Page Name required" data-bvalidator="required" >
                    <option value="1">Left</option>
                    <option value="2">Right</option>
                    <option value="3">Center</option>
                </select>         
                </div>                        
         </div> 
        <div class="form-group">
            <label class="col-md-3 control-label"><span class="mandatory">*</span> Banner Image : </label>
            <div class="col-md-6">
               <input type="file" name="banner_img" class="btn default btn-file " data-bvalidator-msg="Banner Image required" data-bvalidator="required">
             <?php echo form_error('banner_img') ?>
               <span class="validation_info">Banner image needs to be exactly 1600 X 200 pixel. Allowed file type is jpg,jpeg and png. </span>     
              </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-3 col-md-9">
              <button class="btn btn-primary" type="submit">Add Banner</button>
              </div>
            </div>
            </div>
     </form>
     </div>

     <div class="adv-table">     
    <table id="datatable_example" class="responsive table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Page Name</th>
          <th>Banner Image</th>
          <th>Title</th>                                          
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>      
        <?php 
        if(!empty($banner_info)):
          $i=0; foreach($banner_info as $row):
        $i++;?>
      <tbody>
       <input type="hidden" name="type_action" value="2">
        <tr>
         
          <td>Banner ID : #<?php if(!empty($row->id)) echo $row->id; ?></td>
          <td><?php if(!empty($row->page_id)){ if($row->page_id==1){ echo "create your store"; }else{ echo "Find your Store"; } } ?></td>
          <td><img src="<?php echo base_url().$row->banner_image?>" alt="" height="100"></td>
          <td><?php if(!empty($row->title)) echo $row->title; ?></td>                         
          <td class="to_hide_phone">
            <?php if($row->status==1){ ?>
              <a class="label label-success label-mini tooltips" href="<?php echo base_url('backend/content/changeuserstatus_t/'.$row->id.'/'.$row->status.'/0/sub_page_banners')?>" data-original-title="Click to Deactive " >Active </a> 
              <?php } 
              else{ ?><a class="label label-warning label-mini tooltips"  href="<?php echo base_url('backend/content/changeuserstatus_t/'.$row->id.'/'.$row->status.'/0/sub_page_banners')?>" data-original-title="Click to Active " > Deactive </a> 
              <?php } ?>

          </td>
            <td class="ms">              
                <a href="<?php echo base_url().'backend/content/sub_page_banner_edit/'.$row->id?>"  class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" Edit " >
                  <i class="icon-pencil"></i> 
                </a> 
                <a href="<?php echo base_url().'backend/content/delete_sub_page_banner/'.$row->id?>" class="btn btn-danger btn-xs tooltips" rel="tooltip" rel="tooltip" data-placement="top" data-original-title="Remove" onclick="if(confirm('Do you want to delete?')){return true;} else {return false;}" >                        
                  <i class="icon-trash "></i></a>                
              </td>
            </tr> 
        </tbody>
          <?php  endforeach; ?>
        
         
        <?php else: ?>
          <tr>
            <th colspan="8"  class="msg"> <center>No Banners Found.</center></th>
          </tr>
          <?php endif; ?>
        
      </table>
    </div>
   
     	
	</div>



<style>
label{

font-size: 16px;
font-weight: 400;
}

.back{
  background: rgba(240, 238, 238, 0.28);
margin: 0px 0px 20px 0px;
padding: 15px;
box-shadow: 1px 1px 3px 1px;
}

.registration_heading{
	font-size: 20px;
line-height: 20px;
padding: 3px;
font-weight: bold;
}

</style>