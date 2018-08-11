<div class="bread_parent">
   <div class="col-md-8">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
         <li><a href="<?php echo base_url('backend/slider/sliders'); ?>"><b>HomePage Banners</b> </a></li>
      </ul>
   </div>
   <div class="col-md-4">
      <div class="btn-group pull-right">
         <a href="<?php echo base_url('backend/slider/slider_add') ?>" class="btn btn-primary tooltips"  data-original-title="Click to add the Banner Image">
         Add Banner &nbsp;<i class="icon-plus"></i>
         </a>&nbsp;&nbsp;&nbsp;         
      </div>
   </div>
   <div class="clearfix"></div>
</div>
<div class="panel-body no-padding-top" >
    <div class="adv-table" id="tab1">
      <form enctype= "multipart/form-data" class="form-horizontal" id="form" method="post" action="<?php echo current_url()?>" >
         <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
            <thead>
               <tr>
                  <th>#</th>
                  <th>Banner Image</th>
                  <th width="10%" >Order Sequence</th>
                  <th>Created At</th>
                  <th>Status</th>
                  <th>Actions</th>
               </tr>
            </thead>
            <tbody>
               <?php
                  if(!empty($sliders)):
                    $i=0;
                  foreach($sliders as $sliders){ $i++; ?>
               <tr>
                  <td><?php echo $offset+$i."." ;?></td>
                  <td class="to_hide_phone">
                     <?php if(!empty($sliders->slider_img)){ ?>
                     <img class="img_size" src="<?php echo base_url().$sliders->slider_img; ?>">
                     <?php } ?>
                  </td>
                  <td> 
                     <input class="form-control" type="text" name="order[<?php echo $sliders->slider_images_id; ?>]" value="<?php if(!empty($sliders->order)) { echo $sliders->order; }else{ echo set_value('order'); } ?>"/>        
                  </td>
                  <td><i class="fa fa-calendar"></i> <?php echo date('d M Y,h:i  A',strtotime($sliders->created)); ?></td>
                  <td>
                     <a href="javascript:void(0);" onclick="return confirmBox('<?php if($sliders->status==2) echo "Do you want to activate ?"; else if($sliders->status==1) echo "Do you want to deactivate ?"; ?>','<?php echo base_url().'backend/common/change_status/slider_images/slider_images_id/'.$sliders->slider_images_id.'/'; if($sliders->status==2) echo '1'; else echo '2'; ?>')" class="btn btn-<?php if($sliders->status==2) echo 'danger'; else echo 'success';  ?> btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Click to <?php if($sliders->status==2) echo 'Active'; else echo 'Deactive';  ?>"><?php if($sliders->status==2) echo 'Deactive'; else echo 'Active';  ?>
                     </a> 
                  </td>
                  <td class="ms">
                     <a href="<?php echo base_url().'backend/slider/slider_edit/'.$sliders->slider_images_id?>"  class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" Edit ">
                     <i class="icon-pencil"></i> 
                     </a> 
                     <a class="btn btn-danger btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Remove" href="javascript:void(0);" onclick="return confirmBox('Do you want to delete it ?','<?php echo base_url().'backend/slider/slider_delete/'.$sliders->slider_images_id; ?>')" >                        
                     <i class="icon-trash "></i></a> 
                  </td>
               </tr>
               <?php } ?>
               <tr>
                  <td colspan="8">
                     <button type="submit" class="btn btn-primary pull-right tooltips" rel="tooltip" data-placement="left" data-original-title="Update order Sequence" name="update">
                     <i class="fa fa-repeat"></i> Update Order Sequence </button>
                  </td>
               </tr>
               <?php else: ?>
               <tr>
                  <th colspan="6">
                     <center>No Banners found.</center>
                  </th>
               </tr>
               <?php endif; ?>
            </tbody>
         </table>
      </form>
      <div class="row-fluid  control-group mt15">             
         <?php if(!empty($pagination))  echo $pagination;?>              
      </div>
   </div>
</div>