<div class="bread_parent">
   <div class="col-md-10">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
         <li><b>Brands</b></li>
      </ul>
   </div>
   <div class="col-md-2">
      <div class="btn-group tooltips add-toggle" rel="tooltips" data-placement="top" data-original-title="Add New Brand">
         <a class="btn btn-primary btn-toggle-link" id="add">
         Add Brand &nbsp;<i class="fa fa-chevron-down"></i>
         </a>
       
      </div>
   </div>
   <div class="clearfix"></div>
</div>


<div class="panel-body no-padding-top">
   <header class="tabel-head-section">
      <form action="<?php echo base_url('backend/category/brands') ?>" method="get" role="form" class="form-horizontal">
         <div class="no-padding-top">
            <table class="responsive table_head" cellpadding="5">          
               <thead>
                  <tr>
                     <th width="40%">Brand Name</th>
                     <th width="30%">Status</th>
                  </tr>
               </thead>
            <tbody>
               <tr>
               <td>
                  <div class="">                
                     <input type="text" placeholder="Brand Name" class="form-control" name="brand_name" value="<?php if(!empty($_GET['brand_name'])) echo $_GET['brand_name']; ?>">
                  </div> 
               </td>
               <td>
                  <div class="">              
                     <select name="status" class="form-control">                  
                          <option value="1" <?php if(!empty($_GET['status']) && $_GET['status']=='1') echo 'selected'; ?>>Active</option> 
                          <option value="2" <?php if(!empty($_GET['status']) && $_GET['status']=='2') echo 'selected'; ?>>Deactive</option> 
                     </select>
                  </div>     
               </td>
               
               <td width="110"> 
                  <button class="btn btn-primary tooltips" rel="tooltip" data-placement="top" data-original-title="Search" type="submit"><i class="icon icon-search"></i></button>
                  <a class="btn btn-danger tooltips" rel="tooltip" data-placement="top" data-original-title="Reset your brand search" type="submit" href="<?php echo base_url('backend/category/brands'); ?>"> <i class="icon icon-refresh"></i></a>
               </td>
               </tr> 
              </tbody>
            </table>
         </div>
      </form>
   </header> 

   <div class="">
      <div class="tab-pane row-fluid fade in active  toggle-inner-panel" id="form" style="<?php if(!empty($_POST) &&  $_POST['type_action']==1) echo"display:block"; else ?>display:none;">
         <span class="validation_info"> </span>
         <form class="form-horizontal tasi-form" role="form" method="post" action="<?php echo current_url(); ?>" enctype="multipart/form-data" id="form_valid">
            <input type="hidden" name="type_action" value="1">   
               <div class="form-body">
                  <div class="form-group">
                     <label class="col-md-2 control-label">Brand Name <span class="mandatory">*</span></label>          
                     <div class="col-md-3" >
                        <input type="text" placeholder="Brand Name" class="form-control" name="brand_name" value="<?php echo set_value('brand_name'); ?>" data-bvalidator="required" data-bvalidator-msg="brand_name is required">  
                        <span class="error"><?php echo form_error('brand_name'); ?> </span>         
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 control-label">Category Name <span class="mandatory">*</span></label>
                     <div class="col-md-9">
                        <select name="category_id[]" multiple class="form-control form-control input-sm my_multi_select1" data-bvalidator-msg="Category is required" data-bvalidator="required" id="artCategoryId">  
                        <?php if(set_value('category_id')){ echo getcategoryDropdown(implode(',',set_value('category_id'))); }else{ echo getcategoryDropdown(); } ?>
                        </select>  
                        <span class="error"><?php echo form_error('category_id[]'); ?> </span>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-md-2 control-label">Brand Image<span class="mandatory">*</span></label>
                     <div class="col-lg-9">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                           <div class="fileinput-preview thumbnail" data-trigger="fileinput">
                              <img src="<?php echo  BACKEND_THEME_URL ?>images/default_image.png" data-src="holder.js/100%x100%" alt="...">
                           </div>
                           <div>
                              <span class="btn btn-primary btn-file btn-xs"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="brand_image" id="brand_image"></span>
                              <a href="#" class="btn btn-danger fileinput-exists btn-xs" data-dismiss="fileinput">Remove</a>
                           </div>
                        </div>
                        <div class="clearfix"></div>
                        <span class="validation_info">Promotion Image must be <b>atleast 100 X 50 px and at max 300 X 100</b>. Image type allowed is <b>png , jpg , jpeg</b></span>
                        <span class="error"><?php echo form_error('brand_image'); ?> </span>
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-md-2 control-label">Order sequence  </label>
                     <div class="col-md-3" >
                        <input type="text" placeholder="Order sequence of Brand" class="form-control" name="order" value="<?php echo set_value('order'); ?>" data-bvalidator="number" data-bvalidator-msg="Order No is required and must be a number">   
                              
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-offset-2 col-md -9">
                        <button class="btn btn-primary" name="add" type="submit">Add Brand</button>
                     </div>
                  </div>
               </div>
            </div>
         </form><br>
      </div>

      <div class="adv-table" id="tab1">
         <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
            <thead class="thead_color">
               <tr>
                  <th width="5%">Brand ID</th>
                  <th width="15%">Brand Name</th>
                  <th width="15%">Seller Name</th>
                  <th width="8%">Order</th>
                  <th width="20%">Category</th>
                  <th width="15%">Brand Image</th>
                  <th>Status</th>
                  <th width="7%">Actions</th>
               </tr>
            </thead>
            <?php if(!empty($brand)): ?>
            <tbody>
            <?php 
               $i=0; 
               foreach($brand as $row):
               $i++;
            ?>  
            <form enctype= "multipart/form-data" class="form-horizontal" id="form" method="post" action="<?php echo current_url()?>" >
               <tr>
                  <td>#<?php if(!empty($row->brand_id)) echo $row->brand_id; ?>
                     <input type="hidden" name="type_action" value="3">
                     <input type="hidden" name="row_id" value="<?php echo $row->brand_id; ?>">
                  </td>
                  <td>
                     <div class="col-md-12 m-bot15">
                        <input type="text" placeholder="Brand Name" class="form-control" name="brand_name_edit" value="<?php if(!empty($row->brand_name)){ echo $row->brand_name; }else{ echo set_value('brand_name_edit'); } ?>">         
                     </div>
                  </td>

                  <td><a href="<?=base_url('backend/user/view/1/'.$row->seller_id)?>"><?=ucwords($row->seller_name)?></a></td>
                  <td> 
                     <input class="form-control" type="text" name="order_edit" value="<?php if(!empty($row->order)) { echo $row->order; }else{ echo set_value('order_edit'); } ?>"/>        
                  </td>
                  <td>
                     <select name="category_edit_id[]" multiple class="form-control form-control input-sm my_multi_select1" data-bvalidator-msg="Category is required" data-bvalidator="required" id="artCategoryId">  
                     <?php echo getcategoryDropdown($row->category_id); ?>
                     </select>
                  </td>
                  <td>
                     <img src="<?php echo base_url('assets/uploads/backend/category_img/brand/'.$row->brand_image)?>" data-src="holder.js/100%x100%" alt="..." style="max-width: 150px;max-height: 150px;">
                  </td>
            <!--       <td>
                     <a href="javascript:void(0);" onclick="return confirmBox('<?php if($row->status==2) echo "Do you want to activate ?"; else if($row->status==1) echo "Do you want to deactivate ?"; ?>','<?php echo base_url().'backend/common/change_status/brand/brand_id/'.$row->brand_id.'/'; if($row->status==2) echo '1'; else echo '2'; ?>')" class="btn btn-<?php if($row->status==2) echo 'danger'; else echo 'success';  ?> btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Click to <?php if($row->status==2) echo 'Active'; else echo 'Deactive';  ?>"><?php if($row->status==2) echo 'Deactive'; else echo 'Active';  ?>
                     </a> 
                  </td> -->

                  <td>
                    <div class="btn-group">

                       <?php  if($row->status==3) { ?>
                       <button data-toggle="dropdown" type="button" class="btn btn-success btn-xs dropdown-toggle">Seller created <span class="caret"></span>
                       </button>
                       <ul role="menu" class="dropdown-menu">
                           <li>
                             <a href="javascript:void(0);" onclick="return confirmBox('<?php if($row->status==3) echo "Do you want to Activate ?";  ?>','<?php echo base_url().'backend/common/change_status/brand/brand_id/'.$row->brand_id.'/'; if($row->status==3) echo '1'; ?>')"   > Active 
                             </a> 
                          </li>
                           
                           <li>
                              <a href="javascript:void(0);"  onclick="return confirmBox('<?php if($row->status==3) echo "Do you want to Deactivate ?"; ?>','<?php echo base_url().'backend/common/change_status/brand/brand_id/'.$row->brand_id.'/'; if($row->status==3)  echo '2'; ?>')"  > Deactive 
                             </a> 
                           </li>     
                       </ul>
                          <?php } else { ?>
                               <button data-toggle="dropdown" type="button" class="btn btn-<?php if($row->status==2) echo 'danger'; else echo 'success'; ?> btn-xs dropdown-toggle"><?php if($row->status==2) echo 'Deactive'; else echo 'Active';?> <span class="caret"></span>
                            </button>
                             
                                  <ul role="menu" class="dropdown-menu">
                           <li>
                             <a href="javascript:void(0);" onclick="return confirmBox('<?php if($row->status==2) echo "Do you want to Activate ?"; else if($row->status==1) echo "Do you want to Deactivate ?"; ?>','<?php echo base_url().'backend/common/change_status/brand/brand_id/'.$row->brand_id.'/'; if($row->status==2) echo '1'; else echo '2'; ?>')"  btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Click to <?php if($row->status==2) echo 'Deactive'; else echo 'Active';  ?>"><?php if($row->status==2) echo 'Active'; else echo 'Deactive';  ?>
                             </a> 
                          </li>
                           
                          
                       </ul>

                          <?php } ?>
                    </div>
                 </td>
                  <td class="to_hi de_phone">
                     
                     <button value="<?php echo $row->brand_id ?>" name="update" type="submit" class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Update "><i class="fa fa-repeat"></i>
                     </button>                
                     <a href="<?php echo base_url().'backend/common/delete/brand/brand_id/'.$row->brand_id?>" class="btn btn-danger btn-xs tooltips" rel="tooltip" rel="tooltip" data-placement="top" data-original-title="Remove" onclick="if(confirm('Do you want to delete it ?')){return true;} else {return false;}" >                        
                     <i class="icon-trash "></i></a>                
                  </td>
               </tr>
            </form>
            <?php  endforeach; ?>        
         </tbody>
         <?php else: ?>
         <tr>
            <th colspan="8"  class="msg">
               <center>No brand image available.</center>
            </th>
         </tr>
         <?php endif; ?>
         </table>
         <div class="row-fluid  control-group mt15">
            <div class="span12">
               <?php if(!empty($pagination))  echo $pagination;?>
            </div>
         </div>
      </div>
      <!-- End .content -->
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