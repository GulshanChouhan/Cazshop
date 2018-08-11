<div class="bread_parent">
   <div class="col-md-7">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
         <li><b>List Of Variation Themes</b></li>
      </ul>
   </div>
   <div class="col-md-5">
      <div class="btn-group pull-right" style="margin-left: 5px;">
         <a class="btn btn-primary tooltips" href="<?php echo base_url()?>backend/products/add_variation_theme" rel="tooltip" data-placement="top" data-original-title=" Click to add a product variation theme"><i class="icon-plus"></i> Add a Variation Theme
         </a>
      </div>
   </div>
   <div class="clearfix"></div>
</div>

<div class="panel-body no-padding-top">
   <header class="tabel-head-section">
      <form action="<?php echo base_url('backend/products/variation_themes') ?>" method="get" role="form" class="form-horizontal">
         <div class="no-padding-top">
            <table class="responsive table_head" cellpadding="5">          
               <thead>
                  <tr>
                     <th width="40%">Theme Title</th>
                     <th width="30%">Status</th>
                  </tr>
               </thead>
            <tbody>
               <tr>
               <td>
                  <div class="">                
                     <input type="text" placeholder="Product Theme Title" class="form-control" name="product_theme_title" value="<?php if(!empty($_GET['product_theme_title'])) echo $_GET['product_theme_title']; ?>">
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
                  <a class="btn btn-danger tooltips" rel="tooltip" data-placement="top" data-original-title="Reset your variation theme search" type="submit" href="<?php echo base_url('backend/products/variation_themes'); ?>"> <i class="icon icon-refresh"></i></a>
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
               <th>Theme Title</th>
               <th>Category</th>
               <th>Attributes</th>
               <th width="16%">Created </th>
               <th>Status </th>
               <th width="8%">Actions</th>
            </tr>
         </thead>
         <tbody>
            <?php
               if(!empty($variation_themes)){
               $i=0; 
               foreach($variation_themes as $row){
               $i++;
            ?>
            <tr>
               <td>
                  <span class="checkboxli term-check">
                  <input type="checkbox" id="checkall<?php echo $i ?>" name="checkstatus[]" value="<?php echo $row->product_theme_id; ?>">  &nbsp;&nbsp; <?php echo $offset+$i.".";?>
                  <label class="" for="checkall<?php echo $i ?>">
                  </label>
                  </span>
               </td>
               <td><?php echo ucwords($row->product_theme_title); ?></td>
               <td>
                  <?php
                     $cat = getPageCategoryName($row->category,'category','category_name','category_id');
                     if($cat)
                        echo ucwords($cat);
                     else
                        echo "-";
                  ?>
               </td>
               <td>
               <?php 
                  $attributes = json_decode($row->attributes);
                  if($attributes)
                     echo implode(" , ", $attributes);
                  else
                     echo "-";
               ?>
               </td>
               
               <td><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo date('d M Y,h:i  A',strtotime($row->created_at)); ?></td>
               <td>
                  <a href="javascript:void(0);" onclick="return confirmBox('<?php if($row->status==2) echo "Are you sure want to activate ?"; else if($row->status==1) echo "Are you sure want to deactivate ?"; ?>','<?php echo base_url().'backend/common/change_status/variation_themes/product_theme_id/'.$row->product_theme_id.'/'; if($row->status==2) echo '1'; else echo '2'; ?>')" class="btn btn-<?php if($row->status==2) echo 'danger'; else echo 'success';  ?> btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Click to <?php if($row->status==2) echo 'Active'; else echo 'Deactive';  ?>"><?php if($row->status==2) echo 'Deactive'; else echo 'Active';  ?>
                  </a>  
               </td>
               <td>

                  <a href="<?php echo base_url().'backend/products/edit_variation_theme/'.$row->product_theme_id?>" class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Edit Variation Theme"><i class="icon-pencil"></i>
                  </a>
                  <a href="javascript:void(0);" onclick="return confirmBox('Are you sure want to delete ?','<?php echo base_url().'backend/common/delete/variation_themes/product_theme_id/'.$row->product_theme_id; ?>')" class="btn btn-danger btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Delete Variation Theme" onclick="if(confirm('Are you sure want to delete?')){return true;} else {return false;}"><i class="icon-trash "></i>
                  </a>
               </td>
            </tr>
            <?php } ?>
            <?php }else{ ?>
            <tr>
               <th colspan="9">
                  <center>No Products Variation Themes Available.</center>
               </th>
            </tr>
            <?php } ?>
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
            if(confirm("Do you want to "+action_name+" it ?") == false){
               return false;
            }

            var i=0;
            $("input[type='checkbox']:checked").each(function() {
               if($(this).val()!=''){
                  row_id[i]=$(this).val();       
                  i++; 
               }    
            });   

            var tb_name = "<?php echo base64_encode('variation_themes'); ?>"; 
            var col_name = "<?php echo base64_encode('product_theme_id'); ?>";     

            $.post('<?php echo base_url() ?>'+'backend/pages/change_all_status', {'table_name': tb_name, 'col_name': col_name, 'status': new_status, 'row_id': row_id}, function(data) {            
               if(data.status==true){  
                  window.location.reload(true);
               }else{       
                  window.location.reload(true);
                  return false;
               }
            });    
         }else{
            errorMsg('Please Check the checkbox');
            return false;
         } 

      });

   });
</script>