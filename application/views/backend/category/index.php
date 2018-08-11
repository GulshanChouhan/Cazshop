<div class="bread_parent">
   <div class="col-md-9">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
         <?php if($parent_id==0 || $parent_id==''){ ?>
         <li><b>Product Category</b></li>
         <?php }else{ ?>
         <li><a href="<?php echo base_url('backend/category/index/0');?>"><b>Product Category</b> </a>
         <?php $bread=get_category_bread_crumb($parent_id);
               if(!empty($bread))
               {
                  $bread=array_reverse($bread);
                  echo implode(' ',$bread);
               }
          ?>
         </li>
         <?php } ?>
      </ul>
   </div>
   <div class="col-md-3">
      <div class="btn-group pull-right">
        <?php if($parent_id){ ?>
            <a class="btn btn-primary tooltips" href="<?php echo base_url('backend/category/add_subcategory//'.$parent_id) ?>" rel="tooltip" data-placement="top" data-original-title=" Click to add new category "><i class="icon-plus"></i> Subcategory
            </a>
       <?php  }else{ ?>
         <a class="btn btn-primary tooltips" href="<?php echo base_url()?>backend/category/add_category" rel="tooltip" data-placement="top" data-original-title=" Click to add new category "><i class="icon-plus"></i> Add New Category
         </a>
        <?php } ?> 
      </div>
   </div>
   <div class="clearfix"></div>
</div>
<div class="panel-body no-padding-top">
   <header class="tabel-head-section">
      <form action="<?php echo base_url('backend/category/index/'.$parent_id) ?>" method="get" role="form" class="form-horizontal">
         <div class="no-padding-top">
            <table class="responsive table_head" cellpadding="5">          
               <thead>
                  <tr>
                     <th width="20%">Category Name</th>
                     <th width="20%">Category ID</th>  
                     <th width="15%">Sort By</th>
                     <th width="10%">Status</th>
                     <th width="15%"></th>
                  </tr>
               </thead>
            <tbody>
               <tr>
               <td>
                  <div class="">                
                     <input type="text" placeholder="Category Name" class="form-control" name="category_name" value="<?php if(!empty($_GET['category_name'])) echo $_GET['category_name']; ?>">
                  </div> 
               </td>
               <td> 
                  <div class="">                
                     <input type="number" min="1" placeholder="Category ID" class="form-control" name="category_id" value="<?php if(!empty($_GET['category_id'])) echo $_GET['category_id']; ?>">
                  </div> 
               </td>
               <td>
                  <div class="">              
                     <select name="order" class="form-control">    
                          <option value="">--Select--</option>              
                          <option value="DESC" <?php if(!empty($_GET['order']) && $_GET['order']=='DESC') echo 'selected'; ?>>Sort by New</option> 
                          <option value="ASC" <?php if(!empty($_GET['order']) && $_GET['order']=='ASC') echo 'selected'; ?>>Sort by Old</option> 
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
                  <a class="btn btn-danger tooltips" rel="tooltip" data-placement="top" data-original-title="Reset your category search" type="submit" href="<?php echo base_url('backend/category/index/'.$parent_id); ?>"> <i class="icon icon-refresh"></i></a>
               </td>
               </tr> 
              </tbody>
            </table>
         </div>
      </form>
   </header>   
   <div class="adv-table" id="tab1">
      <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
         <thead class="thead_color">
            <tr>
               <th class="jv no_sort" width="8%">
                  <div class="col-md-12 no-padding-left">
                     <span class="checkboxli term-check">
                     <input type="checkbox" id="checkAll" class="" >
                     <label class="" for="checkAll"></label>
                     </span>
                     <select class="form-control commonstatus order-select-status" >
                        <option value="">All</option>
                        <option value="1">Active</option>
                        <option value="2">Deactive</option>
                        <option value="3">Delete</option>                     
                     </select>
                  </div>
               </th>
               <th>Category Name</th>
               <th>Category Tile</th>
               <th>Sub Category</th>
               <th width="14%">Created By</th>
               <th width="16%">Created </th>
               <th>Status </th>
               <th width="10%">Actions</th>
            </tr>
         </thead>
         <tbody>
            <?php
               if(!empty($category)):
               $i=0; foreach($category as $row){ $i++;
            ?>
            <tr>
               <td>
                  <span class="checkboxli term-check">
                  <input type="checkbox" id="checkall<?php echo $i ?>" name="checkstatus[]" value="<?php echo $row->category_id; ?>">  &nbsp;&nbsp; <?php echo $i.".";?>
                  <label class="" for="checkall<?php echo $i ?>">
                  </label>
                  </span>
               </td>
               <td><a href="<?php echo base_url().'backend/category/edit/'.$row->category_id?>" class="" ><?php echo ucwords($row->category_name); ?></a></td>
               <?php
                  if(!empty($row->logo_image) && file_exists("assets/uploads/backend/category_img/logo/".$row->logo_image)){
               ?>
               <td><img src="<?php echo base_url().'assets/uploads/backend/category_img/logo/'.$row->logo_image; ?>" style="max-width: 150px;max-height: 150px;"></td>
               <?php }else{ ?>
               <td><img src="<?php echo  BACKEND_THEME_URL ?>images/default_image.png" style="max-width: 120px;max-height: 120px;"></td>
               <?php } ?>
               <td><?php if($row->sub_category_name){ ?><a class="tooltips btn btn-round btn-sm btn-info" rel="tooltip" data-placement="top" data-original-title="Click to view the sub categories of <?php echo ucwords($row->category_name); ?>" href="<?php echo base_url('backend/category/index/'.$row->category_id) ?>"><i class="icon-plus  tooltips" data-original-title="" title=""> </i> Sub category</a> <?php }else echo 'Direct Category'; ?>
               </td>
               <td>
                <?php 
                  if(!empty($row->user_id) && $row->user_id!=0){
                    $users = getRow('users',array('user_id'=>$row->user_id), array('user_name'));
                ?>
                  <a target="_blank" href="<?php echo base_url('backend/user/view/1/'.$row->user_id); ?>"><?php echo ucfirst($users->user_name); ?></a>
                <?php }else{
                    echo SITE_NAME.' Admin';
                  }
                ?>
               </td>
               <td><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo date('d M Y,h:i  A',strtotime($row->created_at)); ?></td>
               <td>
                <?php 
                  if(!empty($row->user_id) && $row->user_id!=0){
                ?>
                <a href="javascript:void(0);" onclick="return confirmBox('<?php if($row->adminstatus==2) echo "Do you want to activate ?"; else if($row->adminstatus==1) echo "Do you want to deactivate ?"; ?>','<?php echo base_url().'backend/category/change_status/category/category_id/'.$row->category_id.'/'; if($row->adminstatus==2) echo '1'; else echo '2'; ?>')" class="btn btn-<?php if($row->adminstatus==2) echo 'danger'; else echo 'success';  ?> btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Click to <?php if($row->adminstatus==2) echo 'Active'; else echo 'Deactive';  ?>"><?php if($row->adminstatus==2) echo 'Deactive'; else echo 'Active';  ?>
                  </a> 
                <?php }else{ ?>
                  <a href="javascript:void(0);" onclick="return confirmBox('<?php if($row->status==2) echo "Do you want to activate ?"; else if($row->status==1) echo "Do you want to deactivate ?"; ?>','<?php echo base_url().'backend/category/change_status/category/category_id/'.$row->category_id.'/'; if($row->status==2) echo '1'; else echo '2'; ?>')" class="btn btn-<?php if($row->status==2) echo 'danger'; else echo 'success';  ?> btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Click to <?php if($row->status==2) echo 'Active'; else echo 'Deactive';  ?>"><?php if($row->status==2) echo 'Deactive'; else echo 'Active';  ?>
                  </a> 
                 <?php } ?>
               </td>
               <td>
                     
                  <a href="<?php echo base_url().'backend/category/promotion_image/'.$row->category_id?>" class="btn btn-info btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="View Promotional Images of <?php echo $row->category_name; ?>"><i class="fa fa-picture-o"></i>
                  </a>         
                  <a href="<?php echo base_url().'backend/category/edit/'.$row->category_id?>" class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" Edit details of <?php echo $row->category_name; ?>"><i class="icon-pencil"></i>
                  </a>
                  <a onclick="return confirmBox('Do you want to delete it ?','<?php echo base_url().'backend/category/delete/'.$row->category_id?>')" class="btn btn-danger btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Delete  <?php echo $row->category_name; ?>" onclick="if(confirm('Do you want to delete it ?')){return true;} else {return false;}"><i class="icon-trash "></i>
                  </a>
               </td>
            </tr>
            <?php } ?>
            <?php else: ?>
            <tr>
               <th colspan="9">
                  <center>No Categories Available.</center>
               </th>
            </tr>
            <?php endif; ?>
         </tbody>
      </table>

   </div>
   <!-- End .content -->
</div>

<script>
   $("#tab1 #checkAll").click(function () {
        if ($("#tab1 #checkAll").is(':checked')) {
            $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", true);
            });

        } else {
            $("#tab1 input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
        }
   });

   jQuery(document).ready(function($) {
      $('body').find('#tab1').on('change','.commonstatus', function(event) {      
         var row_id=[] ;  

         var new_status=$(this).val();
          if(new_status==1){
           var action_name = 'Active';
          }else if(new_status==2){
           var action_name = 'Deactive';
          }else if(new_status==3){
           var action_name = 'Delete';
          }else{
            return false;
          }


         if($("input:checkbox[name='checkstatus[]']").is(':checked')){    

            swal({
                title: "Do you want to "+action_name+" it!",
                type: "warning",
                padding: 0,
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                background: '#f1f1f1',
                buttonsStyling: false,
                confirmButtonClass: 'btn btn-confirm',
                cancelButtonClass: 'btn btn-cancle',
                confirmButtonText: 'Ok',
                cancelButtonText: 'Cancel',
                animation: false
            }, function() {

                var i=0;
                $("input[type='checkbox']:checked").each(function() {
                   if($(this).val()!=''){
                      row_id[i]=$(this).val();       
                      i++; 
                   }    
                });   

                var tb_name = "<?php echo base64_encode('category'); ?>"; 
                var col_name = "<?php echo base64_encode('category_id'); ?>";     

                $.post('<?php echo base_url() ?>'+'backend/pages/change_all_status', {'table_name': tb_name, 'col_name': col_name, 'status': new_status, 'row_id': row_id}, function(data) {            
                   if(data.status==true){  
                      $(location).attr('href', '<?php echo base_url('backend/category/index'); ?>');
                   }else{       
                      window.location.reload(true);
                      return false;
                   }
                });  
                 
            });    
         }else{
            errorMsg('Please check the checkbox');
            return false;
         } 

      });

   });
</script>