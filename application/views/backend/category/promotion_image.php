<div class="bread_parent">
   <div class="col-md-10">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
         <li><a href="<?php echo base_url('backend/category/index/0');?>"><b>Product Category</b> </a></li>
         <?php $bread=get_category_bread_crumb( $this->uri->segment(4));
            if(!empty($bread))
            {
               $bread=array_reverse($bread);
               echo implode(' ',$bread);
            }
            ?>
         <li><b>Promotional Images</b></li>
      </ul>
   </div>
   <div class="col-md-2">
      <div class="btn-group tooltips add-toggle" rel="tooltips" data-placement="top" data-original-title="Add the live Store">
         <a class="btn btn-primary btn-toggle-link" id="add">
         Add Promotion Image &nbsp;<i class="fa fa-chevron-down"></i>
         </a>
      </div>
   </div>
   <div class="clearfix"></div>
</div>
<div class="panel-body ">
   <div class="tab-pane row-fluid fade in active  toggle-inner-panel" id="form" style="<?php if(!empty($_POST) &&  $_POST['type_action']==1) echo"display:block"; else ?>display:none;">
      <span class="validation_info"> </span>
      <form class="form-horizontal tasi-form" role="form" method="post" action="<?php echo current_url()?>" enctype="multipart/form-data" id="form_valid">
         <input type="hidden" name="type_action" value="1">   
         <div class="form-body">
            <div class="form-group">
               <label class="col-md-2 control-label">Promotion Image<span class="mandatory">*</span></label>
               <div class="col-lg-9">
                  <div class="fileinput fileinput-new" data-provides="fileinput">
                     <div class="fileinput-preview thumbnail" data-trigger="fileinput">
                        <img src="<?php echo  BACKEND_THEME_URL ?>images/default_image.png" data-src="holder.js/100%x100%" alt="...">
                     </div>
                     <div>
                        <span class="btn btn-primary btn-file btn-xs"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="promotion_image" id="promotion_image"></span>
                        <a href="#" class="btn btn-danger fileinput-exists btn-xs" data-dismiss="fileinput">Remove</a>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                  <span class="validation_info">Promotion Image must be <b>atleast 500 X 500 px and at max 1000 X 1000</b>. Image type allowed is <b>png , jpg , jpeg</b></span>
                  <span class="error"><?php echo form_error('promotion_image'); ?> </span>
               </div>
               <label class="col-md-2 control-label">Link to redirect : </label>          
               <div class="col-md-4 input-group m-bot15">
                  <span class="input-group-addon"><?php echo base_url() ?></span>
                  <input type="text" placeholder="Add the link address to redirect" class="form-control" name="page_to_redirect" value="<?php echo set_value('page_to_redirect'); ?>">         
               </div>
               <label class="col-md-2 control-label">Order sequence :<span class="mandatory">*</span> </label>
               <div class="col-md-3" >
                  <input type="text" placeholder="Arrange order No" class="form-control" name="order" value="<?php echo set_value('order'); ?>" data-bvalidator="number,required" data-bvalidator-msg="Order No is required and must be a number">         
               </div>
               <div class="form-group">
                  <div class="col-md-offset -3 col-md -9">
                     <button class="btn btn-primary" name="add" type="submit">Add Image</button>
                  </div>
               </div>
            </div>
         </div>
      </form>
   </div>
   <div class="adv-table" id="tab1">
      <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
         <thead class="thead_color">
            <tr>
               <th width="5%">#</th>
               <th width="40%">Redirection Link</th>
               <th width="10%">Order Sequence</th>
               <th width="20%">Promotional Image</th>
               <th width="8%">Actions</th>
            </tr>
         </thead>
         <tbody>
            <?php 
               if(!empty($promotion)):
                 $i=0; foreach($promotion as $row):
               $i++;?>  
            <form enctype= "multipart/form-data" class="form-horizontal" id="form" method="post" action="<?php echo current_url()?>" >
               <tr>
                  <td>ID : #<?php if(!empty($row->promotion_image_id)) echo $row->promotion_image_id; ?>
                     <input type="hidden" name="type_action" value="3">
                     <input type="hidden" name="row_id" value="<?php echo $row->promotion_image_id; ?>">
                  </td>
                  <td>
                     <div class="col-md-9 input-group m-bot15">
                        <span class="input-group-addon"><?php echo base_url() ?></span>
                        <input type="text" placeholder="Add the link address to redirect" class="form-control" name="page_to_redirect_edit" value="<?php if(!empty($row->link)){ echo $row->link; }else{ echo set_value('page_to_redirect_edit'); } ?>">         
                     </div>
                  </td>
                  <td> 
                     <input class="form-control" type="text" name="order_edit" value="<?php if(!empty($row->order)) { echo $row->order; }else{ echo set_value('order_edit'); } ?>"/>        
                  </td>
                  <td>
                     <img src="<?php echo base_url('assets/uploads/backend/category_img/promotion/'.$row->promotion_image)?>" data-src="holder.js/100%x100%" alt="..." style="max-width: 150px;max-height: 150px;">
                  </td>
                  <td class="to_hi de_phone">
                     <a onclick="return confirmBox('<?php if($row->status==2) echo "Do you want to activate ?"; else if($row->status==1) echo "Do you want to deactivate ?"; ?>','<?php echo base_url().'backend/common/change_status/promotion_image/promotion_image_id/'.$row->promotion_image_id.'/'; if($row->status==2) echo '1'; else echo '2'; ?>')" class="btn btn-<?php if($row->status==2) echo 'danger'; else echo 'success';  ?> btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Click to <?php if($row->status==2) echo 'Active'; else echo 'Deactive';  ?>"><?php if($row->status==2) echo 'Deactive'; else echo 'Active';  ?>
                     </a>    
                     <!-- <button value="<?php echo $row->promotion_image_id ?>" name="update" type="submit" class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Update "><i class="fa fa-repeat"></i>
                     </button>   -->              
                     <a href="<?php echo base_url().'backend/common/delete/promotion_image/promotion_image_id/'.$row->promotion_image_id?>" class="btn btn-danger btn-xs tooltips" rel="tooltip" rel="tooltip" data-placement="top" data-original-title="Remove" onclick="if(confirm('Do you want to delete it ?')){return true;} else {return false;}" >                        
                     <i class="icon-trash "></i></a>                
                  </td>
               </tr>
            </form>
            <?php  endforeach; ?>        
         </tbody>
         <?php else: ?>
         <tr>
            <th colspan="8"  class="msg">
               <center>No Promotional Image available.</center>
            </th>
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