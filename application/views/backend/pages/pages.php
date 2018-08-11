<div class="bread_parent">
   <div class="col-md-10">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
         <li><a href="<?php echo base_url('backend/content/pages'); ?>"><b>Pages</b> </a></li>
      </ul>
   </div>
   <div class="col-md-2">
      <div class="btn-group pull-right">
         <a href="<?php echo base_url('backend/content/page_add'); ?>" class="btn btn-primary btn-toggle-link tooltips" id="add" rel="tooltip" data-placement="top" data-original-title="Add New Pages" > Add Pages
         <i class="icon-plus"></i></a>
      </div>
   </div>
   <div class="clearfix"></div>
</div>
<br>
<div id="tab1">
<!--table -->
<div class="panel-body">
   <div class="adv-table">
      <table id="datatable_example" class="responsive table table-striped " >
         <thead class="thead_color">
            <tr>
               <th class="jv no_sort">#</th>
               <th class="jv no_sort"> ID</th>
               <th class="no_sort">Page Name</th>
               <th class="no_sort">Page Slug</th>
               <th class="to_hide_phone ue no_sort">Status</th>
               <th class="to_hide_phone span2">Created</th>
               <th class="ms no_sort ">Actions</th>
            </tr>
         </thead>
         <tbody>
            <?php 
               if(!empty($pages)):
                 $i=$offset; foreach($pages as $row): 
               $i++;?>
            <tr>
               <td><?php echo $i.".";?></td>
               <td><?php echo '# '.$row->id;?></td>
               <td class=""><a href="<?php echo base_url().'backend/content/page_edit/'.$row->id.'/'.$offset?>" class="btn btn-small"  rel="tooltip" data-placement="left" data-original-title=" Edit "><?php if(!empty($row->page_title)) echo $row->page_title; ?></a></td>
               <td class=""><?php if(!empty($row->page_title)) echo $row->page_slug; ?></td>
               <td class="to_hide_phone">
                  <?php if($row->status==1){ ?>
                    <a class="label label-warning label-mini tooltips" href="javascript:void(0);" onclick="return confirmBox('<?php if($row->status==2) echo "Do you want to activate ?"; else if($row->status==1) echo "Do you want to deactivate ?"; ?>','<?php echo base_url('backend/content/changeuserstatus_t/'.$row->id.'/'.$row->status.'/'.$offset.'/pages')?>')" rel="tooltip" data-placement="top" data-original-title="Change Status" > Active </a> 
                  <?php } else{ ?>
                    <a class="label label-warning label-mini tooltips" href="javascript:void(0);" onclick="return confirmBox('<?php if($row->status==2) echo "Do you want to activate ?"; else if($row->status==1) echo "Do you want to deactivate ?"; ?>','<?php echo base_url('backend/content/changeuserstatus_t/'.$row->id.'/'.$row->status.'/'.$offset.'/pages')?>')" rel="tooltip" data-placement="top" data-original-title="Change Status" > Deactive </a> 
                  <?php } ?>
                  </a>   
               </td>
               <td class="to_hide_phone"><i class="fa fa-calendar"></i> <?php echo date('d M Y,h:i  A',strtotime($row->created)); ?></td>
               <td class="ms">
                  <a href="<?php echo base_url().'backend/content/page_edit/'.$row->id.'/'.$offset?>"  class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" Edit ">
                  <i class="icon-pencil"></i> 
                  </a> 
                  <a style="display:none;" href="<?php echo base_url().'backend/content/page_delete/'.$row->id.'/'.$offset?>" class="btn btn-danger btn-xs tooltips" rel="tooltip" rel="tooltip" data-placement="top" data-original-title="Remove" onclick="if(confirm('Do you want to delete it ?')){return true;} else {return false;}" >                        
                  <i class="icon-trash "></i></a> 
               </td>
            </tr>
            <?php  endforeach; ?>
            <?php else: ?>
            <tr>
               <th colspan="6"  class="msg">
                  <center>No Pages Found.</center>
               </th>
            </tr>
            <?php endif; ?>
         </tbody>
      </table>
      <div class="row-fluid  control-group mt15">
         <div class="span12">
            <?php if(!empty($pagination))  echo $pagination;?>              
         </div>
      </div>
   </div>
</div>