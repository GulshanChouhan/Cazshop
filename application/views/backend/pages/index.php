<div class="bread_parent">
   <div class="col-md-8">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
         <li><a href="javascript:;"><b>Pages</b> </a></li>
      </ul>
   </div>
   <div class="col-md-4">
      <div class="btn-group pull-right">
         <a class="btn btn-primary tooltips" href="<?php echo base_url()?>backend/pages/add" rel="tooltip" data-placement="top" data-original-title=" Click to add new page ">Add New Page
         <i class="icon-plus"></i></a>&nbsp;&nbsp;&nbsp;
      </div>
   </div>
   <div class="clearfix"></div>
</div>
<div class="panel-body no-padding-top">
   <header class="tabel-head-section">
      <form action="<?php echo base_url('backend/pages/index') ?>" method="get" role="form" class="form-horizontal">
         <div class="no-padding-top">
            <table class="responsive table_head" cellpadding="5">          
               <thead>
                  <tr>
                     <th width="20%">Page Title</th>
                     <th width="20%">Type of section</th>  
                     <th width="15%">Status</th>
                     <th width="15%"></th>
                  </tr>
               </thead>
            <tbody>
               <tr>
               <td>
                  <div class="">                
                     <input type="text" placeholder="Page Title" class="form-control" name="title" value="<?php if(!empty($_GET['title'])) echo $_GET['title']; ?>">
                  </div> 
               </td>
               <td> 
                  <div class="">                
                     <select class="form-control" name="type_of_section">
                        <option value="">--Select--</option>
                        <option value="1" <?php if(!empty($_GET['type_of_section']) && $_GET['type_of_section']=='1') echo 'selected'; ?>>Frontend</option>
                        <option value="2" <?php if(!empty($_GET['type_of_section']) && $_GET['type_of_section']=='2') echo 'selected'; ?>>Seller</option>
                     </select>
                  </div> 
               </td>
               <td>
                  <div class="">              
                     <select name="status" class="form-control">
                          <option value="">--Select--</option>                  
                          <option value="1" <?php if(!empty($_GET['status']) && $_GET['status']=='1') echo 'selected'; ?>>Active</option> 
                          <option value="2" <?php if(!empty($_GET['status']) && $_GET['status']=='2') echo 'selected'; ?>>Deactive</option> 
                     </select>
                  </div>     
               </td>
               
               <td width="110"> 
                  <button class="btn btn-primary tooltips" rel="tooltip" data-placement="top" data-original-title="Search" type="submit"><i class="icon icon-search"></i></button>
                  <a class="btn btn-danger tooltips" rel="tooltip" data-placement="top" data-original-title="Reset your pages search" type="submit" href="<?php echo base_url('backend/pages/index'); ?>"> <i class="icon icon-refresh"></i></a>
               </td>
               </tr> 
              </tbody>
            </table>
         </div>
      </form>
   </header> 

   <div class="adv-table">
      <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
         <thead class="thead_color">
            <tr>
               <th width="5%">S.No</th>
               <th width="20%">Page Title</th>
               <th width="15%">Type Of Section</th>
               <th width="20%">Slug</th>
               <th width="18%">Created </th>
               <th width="8%">Status </th>
               <th width="5%">Actions</th>
            </tr>
         </thead>
         <tbody>
            <?php
               if(!empty($templates)):
               $i=0; foreach($templates as $row){ $i++;?>
            <tr>
               <td><?php echo $offset+$i."." ; ?></td>
               <td><a href="<?php echo base_url().'backend/pages/edit/'.$row->page_id?>" class="btn btn-small" ><?php echo ucfirst($row->title); ?></a></td>
               <td ><?php if($row->type_of_section==1) echo "Frontend"; else if($row->type_of_section==2) echo "Seller"; else echo "-"; ?></td>
               <td ><?php echo $row->slug; ?></td>
               <td><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo date('d M Y,h:i  A',strtotime($row->created_at)); ?></td>
               <td>
                  <a href="javascript:void(0);" onclick="return confirmBox('<?php if($row->status==2) echo "Do you want to activate ?"; else if($row->status==1) echo "Do you want to deactivate ?"; ?>','<?php echo base_url().'backend/common/change_status/pages/page_id/'.$row->page_id.'/'; if($row->status==2) echo '1'; else echo '2'; ?>')" class="btn btn-<?php if($row->status==2) echo 'danger'; else echo 'success';  ?> btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Click to <?php if($row->status==2) echo 'Active'; else echo 'Deactive';  ?>"><?php if($row->status==2) echo 'Deactive'; else echo 'Active';  ?>
                  </a> 
               </td>
               <td>
                  <a href="<?php echo base_url().'backend/pages/edit/'.$row->page_id?>" class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" Edit ">
                  <i class="icon-pencil"></i>
                  </a>
                  <!--   <a href="javascript:void(0)" class="btn btn-danger btn-xs tooltips" rel="tooltip" rel="tooltip" data-placement="top" data-original-title="Remove" onclick="return confirmBox('Do you want to delete it ?','<?php echo base_url().'backend/pages/delete/'.$row->id; ?>')" >
                     <i class="icon-trash "></i></a>-->
               </td>
            </tr>
            <?php } ?>
            <?php else: ?>
            <tr>
               <th colspan="7">
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
   <!-- End .content -->
</div>