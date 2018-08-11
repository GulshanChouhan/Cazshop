<div class="bread_parent">
   <div class="col-md-9">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
         <li><a href="javascript:;"><b>List Of Attributes</b> </a></li>
      </ul>
   </div>
   <div class="col-md-3">
      <div class="btn-group pull-right">
         <a class="btn btn-primary tooltips" href="<?php echo base_url()?>backend/attribute/add_attribute" rel="tooltip" data-placement="top" data-original-title=" Click to add new attribute "><i class="icon-plus"></i> Add New Attribute
         </a>
      </div>
   </div>
   <div class="clearfix"></div>
</div>
<div class="panel-body no-padding-top">
   <header class="tabel-head-section">
      <form action="<?php echo base_url('backend/attribute/index') ?>" method="get" role="form" class="form-horizontal">
         <div class="no-padding-top">
            <table class="responsive table_head" cellpadding="5">          
               <thead>
                  <tr>
                     <th>Attribute Name</th>
                     <th>Attribute Code</th>
                     <th>Category Name</th>  
                     <th>Sort By</th>
                     <th width="10%">Status</th>
                     <th></th>
                  </tr>
               </thead>
            <tbody>
               <tr>
               <td>
                  <div class="">                
                     <input type="text" placeholder="Attribute Name" class="form-control" name="attribute_name" value="<?php if(!empty($_GET['attribute_name'])) echo $_GET['attribute_name']; ?>">
                  </div> 
               </td>
               <td> 
                  <div class="">                
                     <input type="text" placeholder="Attribute Code" class="form-control" name="attribute_code" value="<?php if(!empty($_GET['attribute_code'])) echo $_GET['attribute_code']; ?>">
                  </div> 
               </td>
               <td> 
                  <div class="">                
                        <select name="category_id" class="form-control form-control " id="artCategoryId">  
                           <option value="">Select Category</option>
                           <?php $cate=''; if(!empty($_GET['category_id'])) $cate=$_GET['category_id']; echo getcategoryDropdown($cate); ?>
                        </select>  
                  </div> 
               </td>
               <td>
                  <div class="">              
                     <select name="order" class="form-control">                  
                          <option value="DESC" <?php if(!empty($_GET['order']) && $_GET['order']=='DESC') echo 'selected'; ?>>Sort by New</option> 
                          <option value="ASC" <?php if(!empty($_GET['order']) && $_GET['order']=='ASC') echo 'selected'; ?>>Sort by Old</option> 
                     </select>
                  </div>     
               </td>
               <td>
                  <div class="">              
                     <select name="status" class="form-control">                  
                          <option value="" <?php if(empty($_GET['status']) || $_GET['status']=='') echo 'selected'; ?>>--Select--</option>
                          <option value="1" <?php if(!empty($_GET['status']) && $_GET['status']=='1') echo 'selected'; ?>>Active</option> 
                          <option value="2" <?php if(!empty($_GET['status']) && $_GET['status']=='2') echo 'selected'; ?>>Deactive</option> 
                     </select>
                  </div>     
               </td>
               <td width="110"> 
                  <button class="btn btn-primary tooltips" rel="tooltip" data-placement="top" data-original-title="Search" type="submit"><i class="icon icon-search"></i></button>
                  <a class="btn btn-danger tooltips" rel="tooltip" data-placement="top" data-original-title="Reset your attribute search" type="submit" href="<?php echo base_url('backend/attribute/index'); ?>"> <i class="icon icon-refresh"></i></a>
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
               <th>Attribute Name</th>
               <th>Attribute Code</th>
               <th>Type</th>
               <th>Is used in filter</th>
               <th>File Type</th>
               <th>Read Only</th>
               <th>Field Required</th>
               <th>Status</th>
               <th width="7%">Actions</th>
            </tr>
         </thead>
         <tbody>
            <?php
               if(!empty($attribute)):
               $i=0; foreach($attribute as $row){ $i++;
            ?>
            <tr>
               <td>
                  <span class="checkboxli term-check">
                  <input type="checkbox" id="checkall<?php echo $i ?>" name="checkstatus[]" value="<?php echo $row->attribute_id; ?>">  &nbsp;&nbsp; <?php echo $offset+$i.".";?>
                  <label class="" for="checkall<?php echo $i ?>">
                  </label>
                  </span>
               </td>
               <td><a href="<?php echo base_url().'backend/attribute/edit_attribute/'.$row->attribute_id?>" class="" ><?php echo ucwords($row->name); ?></a></td>
               <td><?php echo $row->attribute_code ?></td>
               <td><?php if($row->type==1) echo 'Product Basic Info'; else if($row->type==2) echo 'Product Other Info'; else  if($row->type==3) echo 'Variations';  ?></td>
               <td class="text-center"><?php if($row->used_in_filter) echo '<i class="fa fa-check" aria-hidden="true"></i>'; else echo '<i class="fa fa-times" aria-hidden="true"></i>';  ?></td>
               <td><?php echo file_type($row->file_type) ?></td>
               <td class="text-center"><?php if($row->is_readonly) echo '<i class="fa fa-check" aria-hidden="true"></i>'; else echo '<i class="fa fa-times" aria-hidden="true"></i>';  ?></td>
               <td class="text-center"><?php if($row->is_required_only) echo '<i class="fa fa-check" aria-hidden="true"></i>'; else echo '<i class="fa fa-times" aria-hidden="true"></i>'; ?></td>
               <td>
                  <a href="javascript:void(0);" onclick="return confirmBox('<?php if($row->status==2) echo "Do you want to activate ?"; else if($row->status==1) echo "Do you want to deactivate ?"; ?>','<?php echo base_url().'backend/common/change_status/attributes/attribute_id/'.$row->attribute_id.'/'; if($row->status==2) echo '1'; else echo '2'; ?>')" class="btn btn-<?php if($row->status==2) echo 'danger'; else echo 'success';  ?> btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Click to <?php if($row->status==2) echo 'Deactive'; else echo 'Active';  ?>"><?php if($row->status==2) echo 'Deactive'; else echo 'Active';  ?>
                  </a>  
               </td>
               <td>
                  <a href="<?php echo base_url().'backend/attribute/edit_attribute/'.$row->attribute_id?>" class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" Edit <?php echo ucwords($row->name); ?>"><i class="icon-pencil"></i>
                  </a>
                  <a href="javascript:void(0);" onclick="return confirmBox('Do you want to delete it ?','<?php echo base_url().'backend/common/delete/attributes/attribute_id/'.$row->attribute_id?>')" class="btn btn-danger btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Delete  <?php echo ucwords($row->name); ?>" onclick="if(confirm('Do you want to delete it ?')){return true;} else {return false;}"><i class="icon-trash "></i>
                  </a>
               </td>
            </tr>
            <?php } ?>
            <?php else: ?>
            <tr>
               <th colspan="9">
                  <center>No Attribute Available.</center>
               </th>
            </tr>
            <?php endif; ?>
         </tbody>
      </table>
      <div class="row-fluid  control-group mt15">
         <div class="span12 pull-right">
            <?php if(!empty($pagination))  echo $pagination;?>
         </div>
      </div>
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

                  var tb_name = "<?php echo base64_encode('attributes'); ?>"; 
                  var col_name = "<?php echo base64_encode('attribute_id'); ?>";     

                  $.post('<?php echo base_url() ?>'+'backend/pages/change_all_status', {'table_name': tb_name, 'col_name': col_name, 'status': new_status, 'row_id': row_id}, function(data) {            
                     if(data.status==true){  
                        $(location).attr('href', '<?php echo base_url('backend/attribute/index')?>');
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