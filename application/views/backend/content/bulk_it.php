<div class="bread_parent">
<div class="col-md-8"> 
<ul class="breadcrumb">
    <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
    <li><a href="<?php echo base_url('backend/slider/sliders'); ?>">Home Page Setting</a></li>
     <li><a href="<?php echo base_url('backend/content/bulk_it'); ?>"><b>Shop the stores</b></a></li>
</ul>
</div>
<div class="col-md-4">
  <div class="btn-group pull-right">
          <a class="btn btn-primary btn-toggle-link tooltips" id="add" data-original-title="Click to add the bulk content">
             Add Shop content &nbsp;<i class="fa fa-chevron-down"></i>
           </a>&nbsp;&nbsp;&nbsp;         
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
            <label class="col-md-3 control-label">Slider Content : <span class="mandatory">*</span></label>
            <div class="col-md-6">
                 <textarea  class="tinymce_edittor form-control"  name="title1">
                <?php echo set_value('title1'); ?></textarea>  
               
             <?php echo form_error('title1') ?>
              </div>
        </div>  
          <div class="form-group">
              <label class="col-md-3 control-label">Order sequence :<span class="mandatory">*</span> </label>
                <div class="col-md-2" >
                   <input type="text" placeholder="Arrange order No" class="form-control" name="order" value="" data-bvalidator="number,required" data-bvalidator-msg="Order No is required and must be a number">
                    <input type="hidden" name="type" value="2">          
               </div>
                <?php echo form_error('order') ?>
         </div>
         <div class="form-group">
           <label class="col-md-3 control-label">Shop Slider Image</label>  
             
             <div class="col-lg-2 no-padding-right">                  
                  <input type="file" name="bulk_it_img">                
                  <?php echo form_error('bulk_it_img'); ?>    
             </div><br>
             <span class="validation_info col-md-10 col-md-offset-3">Bulk Slider image needs to be atleast 60 X 60 pixel and at max 250 X 250 pixels. </span> 
        </div>   
        <div class="form-group">
            <div class="col-md-offset-3 col-md-9">
              <button class="btn btn-primary" name="update" type="submit">Add Shop content</button>
            </div>
         </div>
        </div> 
     </form>
     </div>
     
   <ul class="nav nav-tabs " role="tablist">
      <li class=""><a href="<?php echo base_url().'backend/slider/sliders' ?>"><b>Home Page slider</b></a></li>   
      <li class=""><a href="<?php echo base_url().'backend/content/open_store' ?>"><b>Free Online Stores for Everyone</b></a></li>      
      <li class=""><a href="<?php echo base_url().'backend/content/live_stores' ?>"><b>Live Online Stores</b></a></li>
      <li class="active"><a href="<?php echo base_url().'backend/content/bulk_it' ?>"><b>Shop the stores</b></a></li>
      <li class=""><a href="<?php echo base_url().'backend/content/fund_it' ?>" ><b>Buy in Bulk and Save </b></a></li>
      <li ><a href="<?php echo base_url().'backend/content/we_love' ?>"><b>We love what we do</b></a></li>   
      <!-- <li><a href="<?php echo base_url().'backend/content/client_feedback' ?>"><b>Client feedback</b></a></li>    -->  
    </ul> 

     <div class="adv-table">   
     <form class="form-horizontal tasi-form" role="form" method="post" action="<?php echo current_url()?>" enctype="multipart/form-data" id="form_valid">      
    <table id="datatable_example" class="responsive table table-striped">
      <thead>
        <tr>
          <th>#</th>          
          <th>Type</th>          
          <th>Shop Image</th>
          <th>Title</th>   
          <th>Order</th>                                  
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead> 

        <?php      
        if(!empty($bulk_content)):
          $i=0; foreach($bulk_content as $row):
        $i++;?>
      <tbody>
       <input type="hidden" name="type_action" value="2">
        <tr class="<?php if($row->type==1){ echo 'toggle-inner-panel'; } ?> ">
         
          <td>ID : #<?php if(!empty($row->id)) echo $row->id; ?></td>
           <td><?php if($row->type==1){ echo '<b>Header Content</b>'; }else{ echo "<b>Sub Content</b>";  }  ?></td>
        
          <td><img src="<?php echo base_url().$row->bulk_it_img?>" alt="" height="100"></td>
          <td><?php if(!empty($row->title1)) echo html_entity_decode(word_limiter($row->title1, 7)); ?></td>          
            <?php if($row->type==2){ ?>
              <td>  <input class="form-control" type="text" name="order[<?php echo $row->id ?>]" value="<?php if(!empty($row->order)) echo $row->order; ?>"/>
              <?php echo form_error('order[]'); ?></td>
          <?php }else{ ?>
            <td></td>
          <?php } ?>    
          <?php if($row->type==2){ ?>
           <td class="to_hide_phone">
            <?php if($row->status==1){ ?>
              <a class="label label-success label-mini tooltips" href="<?php echo base_url('backend/content/changeuserstatus_t/'.$row->id.'/'.$row->status.'/0/cms_bulk_it')?>" rel="tooltip" data-placement="top" data-original-title="Change Status">Active </a> 
              <?php } 
              else{ ?><a class="label label-warning label-mini tooltips"  href="<?php echo base_url('backend/content/changeuserstatus_t/'.$row->id.'/'.$row->status.'/0/cms_bulk_it')?>"  rel="tooltip" data-placement="top" data-original-title="Change Status"> Deactive </a> 
              <?php } ?>
          </td>
          <?php }else{ ?>
          <td></td>
          <?php } ?>  
            <td class="ms">              
                <a href="<?php echo base_url().'backend/content/bulk_it_edit/'.$row->id ?>"  class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" Edit ">
                  <i class="icon-pencil"></i> 
                </a> 
               <!--  <a href="<?php //echo base_url().'backend/content/delete_bulk_it/'.$row->id?>" class="btn btn-danger btn-xs tooltips" rel="tooltip" rel="tooltip" data-placement="top" data-original-title="Remove" onclick="if(confirm('Do you want to delete it ?')){return true;} else {return false;}" >                        
                  <i class="icon-trash "></i></a>    -->             
              </td>
            </tr> 
        </tbody>
          <?php  endforeach; ?>        
          <tr><td colspan="8">
            <button type="submit" class="btn btn-primary pull-right tooltips" rel="tooltip" data-placement="left" data-original-title="Update order Sequence" name="update">
            <i class="fa fa-repeat"></i> Update Order Sequence </button>
         </td></tr>
        <?php else: ?>
          <tr>
            <th colspan="8"  class="msg"> <center>No Content Found.</center></th>
          </tr>
          <?php endif; ?>
        
      </table>
     </form> 
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
.img_size{
  max-height: 100px;
  max-width: 100px;
}

</style>