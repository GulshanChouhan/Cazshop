<div class="bread_parent">
   <div class="col-md-9">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
         <li><b>List Of Products</b> </li>
      </ul>
   </div>

   <div class="col-md-3">
      <a o1="export" class="btn btn-primary tooltips pull-right exportInventoryData" href="javascript:void(0)" rel="tooltip" data-placement="top" data-original-title="Export Inventory Report">Export Inventory Report
         </a>
   </div>
   <div class="clearfix"></div>
</div>

<div class="panel-body no-padding-top">
   <header class="tabel-head-section">
      <form action="<?php echo base_url('backend/report/inventory') ?>" method="get" role="form" class="form-horizontal">
         <div class="no-padding-top">
            <table class="responsive table_head" cellpadding="5">          
               <thead>
                  <tr>
                     <th width="20%">Order Date</th>
                     <th width="10%">Product Title</th>
                     <th width="12%">Categories</th>  
                     <th width="12%">Name Of Sellers</th>  
                     <th width="20%">Quantity</th>
                     <th width="10%">Status</th>
                     <th width="10%"></th>
                  </tr>
               </thead>
               <tbody>
                  <tr>  
                      <td>
                        <div class="input-group input-large" data-date="08-03-2018" data-date-format="dd-mm-yyyy">  <input type="text" class="form-control datetimepicker"  name="start_date" placeholder="Start Date" value="<?php if(!empty($_GET['start_date'])) echo $_GET['start_date']; ?>" >
                        <span class="input-group-addon"><i class=" icon-calendar"></i></span>
                        <input type="text" class="form-control datetimepicker"  placeholder="End Date" name="end_date" value="<?php if(!empty($_GET['end_date'])) echo $_GET['end_date']; ?>">
                     </div>
                     </td>
                     <td>                
                        <input type="text" placeholder="Product Title" class="form-control" name="title" value="<?php if(!empty($_GET['title'])) echo $_GET['title']; ?>">
                     </td>
                     <td>              
                        <select name="category_id" class="form-control">  
                           <option value="">Select Category</option>
                           <?php $cate=''; if(!empty($_GET['category_id'])) $cate=$_GET['category_id']; echo getcategoryDropdown($cate); ?>
                        </select>   
                     </td>
                     <td>             
                        <select name="seller_id" class="form-control">  
                           <option value="">Select Seller</option>
                           <?php 
                              $sellers_list = users_list(1);
                              foreach ($sellers_list as $row) { 
                           ?>
                              <option <?php if(!empty($_GET['seller_id'])){ if($row->user_id==$_GET['seller_id']){ echo "selected"; } } ?> value="<?php echo $row->user_id; ?>"><?php echo ucwords($row->user_name).' [ '.$row->email.' ]'; ?></option>
                           <?php } ?>
                        </select>   
                     </td>
                     <td>
                         <div class="input-group input-large"> 
                            <input type="text" class="form-control"  name="minquantity" placeholder="Min Quantity" value="<?php if(!empty($_GET['minquantity'])) echo $_GET['minquantity']; ?>" >
                            <span class="input-group-addon">To</span>
                            <input type="text" class="form-control"  placeholder="Max Quantity" name="maxquantity" value="<?php if(!empty($_GET['maxquantity'])) echo $_GET['maxquantity']; ?>">  
                         </div>
                     </td>
                     <td>          
                        <select name="status" class="form-control">                  
                             <option value="1" <?php if(!empty($_GET['status']) && $_GET['status']=='1') echo 'selected'; ?>>Active</option> 
                             <option value="2" <?php if(!empty($_GET['status']) && $_GET['status']=='2') echo 'selected'; ?>>Deactive</option> 
                        </select> 
                     </td>
                     
                     <td width="110"> 
                        <button class="btn btn-primary tooltips" rel="tooltip" data-placement="top" data-original-title="Search" type="submit"><i class="icon icon-search"></i></button>
                        <a class="btn btn-danger tooltips" rel="tooltip" data-placement="top" data-original-title="Reset your inventory search" type="submit" href="<?php echo base_url('backend/report/inventory'); ?>"> <i class="icon icon-refresh"></i></a>
                     </td>
                  </tr> 
                 </tbody>
            </table>
         </div>
      </form>     
   </header>   
    <div class="adv-table" id="tab1">
      <form method="POST" id="inventory_reports" novalidate="novalidate">
        <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
           <thead class="thead_color">
              <tr>
                 <th class="jv no_sort" width="10%">
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
                 <th width="10%">Name Of Seller</th>
                 <th width="15%">Product Image</th>
                 <th width="25%">Product Title</th>
                 <th width="8%">Retail Price(MRP)</th>
                 <th width="8%">Base Price</th>
                 <th width="5%">Quantity</th>
                 <th width="5%">Your Commision</th>
                 <th width="5%">Status</th>
                 <th width="13%">Actions</th>
              </tr>
           </thead>
           <tbody>
              <?php
                 if(!empty($products)){
                 $i=0; 
                 foreach($products as $row){
                 $i++;
                 ?>
              <tr>
                 <td>
                    <span class="checkboxli term-check">
                    <input type="checkbox" id="checkall<?php echo $i ?>" name="checkstatus[]" value="<?php echo $row->product_info_id; ?>">  &nbsp;&nbsp; <?php echo $offset+$i.".";?>
                    <label class="" for="checkall<?php echo $i ?>">
                    </label>
                    </span>
                 </td>
                 <td><a target="_balnk" href="<?php echo base_url('backend/user/view/1/'.$row->seller_id); ?>"><?php echo ucwords(get_NameUsingID($row->seller_id)); ?></a></td>
                 <td>
                    <?php
                       $image = getFeaturedImage($row->product_info_id, $row->product_variation_id);
                       if($row->type_of_product==1 && !empty($image) && file_exists("assets/uploads/seller/products/thumbnail/".$image)){
                       ?>
                    <img width="100" height="auto" src="<?php echo base_url('assets/uploads/seller/products/thumbnail/'.$image)?>">
                    <?php }else{ ?>
                    
                    <?php if($row->type_of_product==1){ ?>
                      <img src="<?php echo base_url('assets/backend/image/product_default_image.png'); ?>">
                    <?php }else if($row->type_of_product==2){ ?>
                      <img toggleShow="close" s_no="<?php echo $i; ?>" infoDetails="<?php echo $row->product_info_id; ?>" onclick="getChildVariationProducts(this)" height="auto" src="<?php echo base_url('assets/backend/image/default_image.png'); ?>">
                    <?php } ?>
                    
                    <a rel="tooltip" s_no="<?php echo $i; ?>" data-placement="top" data-original-title="CLICK HERE to view the variations of this product." class="productCount tooltips" toggleShow="close" infoDetails="<?php echo $row->product_info_id; ?>" onclick="getChildVariationProducts(this)" href="javascript:void(0)"><?php if($row->type_of_product==2){ echo 'See '.$row->totalVariationCount.' variations of this product'; } ?></a>
                    <?php } ?>
                 </td>
                 <td>
                    <?php echo ucwords($row->title); if($row->type_of_product==1){ echo " <b>(".$row->product_ID.")</b>"; } ?><br>
                    <?php if($row->type_of_product==1){ if($row->admin_approvel==1){ echo "<b style='color:green'>Approved by Admin</b>"; }else{ echo "<b style='color:#f45b69'>Not Approved by Admin</b>";  } echo "<br>"; } ?>
                    <?php if(!empty($row->type_of_product)){ ?><b>Product Type - <?php if($row->type_of_product==1) echo "Single"; else if($row->type_of_product==2) echo "Variation"; ?></b><?php } ?>
                    <br>
                    <?php if($row->shipment_rate_type!=0){ ?>
                    <b style='color:green'>- Applied 
                    <?php if($row->shipment_rate_type==1){ echo "Free Shipping"; }else if($row->shipment_rate_type==2){ echo "Custom Shipping"; }else if($row->shipment_rate_type==3){ echo "Global Shipping"; } ?></b><br>
                    <?php } ?>
                    <b>Created Date - </b><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo date('d M Y',strtotime($row->created_at)); ?>
                 </td>
                 <td><?php if(!empty($row->type_of_product==1)){ echo '$'. number_format($row->sell_price,2); }else{ echo "-"; } ?></td>
                 <td><?php if(!empty($row->type_of_product==1)){ echo '$'. number_format($row->base_price,2); }else{ echo "-"; } ?></td>
                 <td>
                    <?php
                       if(!empty($row->type_of_product==1)){
                          if(!empty($row->quantity)){
                             echo $row->quantity;
                          }else{
                             echo "-";
                          }
                       }else{
                          echo "-";
                       }
                       ?>
                 </td>
                 <td>
                    <?php
                       if(!empty($row->type_of_product==1)){
                         if(!empty($row->commision_fee) && !empty($row->sell_price)){
                            $feePreview = $row->commision_fee * $row->sell_price/100;
                            echo '$'.number_format($feePreview, 2);
                         }else{
                            echo "-";
                         }
                       }else{
                          echo "-";
                       }
                       ?>
                 </td>
                 <td>
                    <?php
                       if(!empty($row->type_of_product==1)){
                         if(!empty($row->admin_approvel) && !empty($row->admin_approvel)){
                          ?>
                    <a href="javascript:void(0);" onclick="return confirmBox('<?php if($row->admin_approvel==2) echo "Are you sure want to activate ?"; else if($row->admin_approvel==1) echo "Are you sure want to deactivate ?"; ?>','<?php echo base_url().'backend/products/changeadminstatus/'.$row->product_variation_id.'/'.$row->admin_approvel.'/admin_approvel/product_variations'; ?>')" class="btn btn-<?php if($row->admin_approvel==2) echo 'danger'; else echo 'success';  ?> btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Click to <?php if($row->admin_approvel==2) echo 'Active'; else echo 'Deactive';  ?>"><?php if($row->admin_approvel==2) echo 'Deactive'; else echo 'Active';  ?>
                    </a>
                    <?php    
                       }else{
                          echo "-";
                       }
                       }else{
                        echo "-";
                       }
                       ?>
                 <td>
                    <?php if($row->type_of_product==1){ ?>                     
                    <a href="<?php echo base_url().'backend/products/edit_product_category/'.$row->product_info_id.'/'.$row->product_variation_id.'/1'; ?>" class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" Edit Product"><i class="fa fa-eye"></i>
                    </a>
                    <?php }else if($row->type_of_product==2){ ?>
                    <!-- <a toggleShow="close" class="btn btn-primary btn-xs tooltips" infoDetails="<?php echo $row->product_info_id; ?>" onclick="getChildVariationProducts(this)" href="javascript:void(0)" rel="tooltip" data-placement="top" data-original-title="Click to view all products"><i id="toggleVRIcon<?php echo $row->product_info_id; ?>" class="fa fa-plus" aria-hidden="true"></i>
                       </a> -->
                    <a href="<?php echo base_url().'backend/products/edit_product_category/'.$row->product_info_id.'/0/2'; ?>" class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" View Product Details"><i class="fa fa-eye"></i>
                    </a>
                    <?php } ?>
                    <a href="javascript:void(0);" onclick="return confirmBox('Are you sure want to delete ?','<?php echo base_url().'backend/products/delete_product/'.$row->product_info_id.'/'.$row->product_variation_id; ?>')" class="btn btn-danger btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Delete Product"><i class="icon-trash "></i>
                    </a>
                 </td>
              </tr>
              <?php } ?>
              <?php }else{ ?>
              <tr>
                 <th colspan="10">
                    <center>No Products Available.</center>
                 </th>
              </tr>
              <?php } ?>
           </tbody>
        </table>
        <div class="row-fluid pull-right control-group mt15">
           <div class="span12">
              <?php if(!empty($pagination))  echo $pagination;?>
           </div>
        </div>
      </form>
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

   $('.exportInventoryData').click(function(){
     base_url = "<?php echo base_url(); ?>";
     titletype = $(this).attr('o1');
     if(titletype=='export'){
       $('#inventory_reports').attr('action', base_url+"backend/report/inventoryExportCSV").submit();
     }
     return false;
   });
</script>
<script type="text/javascript" >
   var SITE_URL  = "<?php echo base_url(); ?>";
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

                var tb_name = "<?php echo base64_encode('products_info'); ?>"; 
                var col_name = "<?php echo base64_encode('product_info_id'); ?>";      

                $.post('<?php echo base_url() ?>'+'backend/products/manage_product_status', {'type': '0', 'status': new_status, 'row_id': row_id}, function(data) {            
                   if(data.status==true){  
                      successMsg("Your products "+action_name+" successfully"); 
                      setTimeout(function() {
                        $(location).attr('href', '<?php echo base_url('backend/products/index')?>');
                      }, 1000);
                   }else{       
                      window.location.reload(true);
                      return false;
                   }
                });

            });    
         }else{
            errorMsg('Please Check the checkbox');
            return false;
         } 

      });

   });
   
  
   function getChildVariationProducts(obj){
      var toggleShow      = $(obj).attr("toggleShow");
      var product_info_id = $(obj).attr("infoDetails");
      var s_no            = $(obj).attr("s_no");

      if(toggleShow=='close'){
         $(obj).attr("toggleShow", "open");
         $.ajax({
              url: SITE_URL + 'backend/products/getVariationProducts',
              type: 'POST',
              data: {
                  product_info_id: product_info_id,
                  s_no: s_no,
              },
              cache: false,
              success: function(result) {
                 var data = JSON.parse(result);
                 if(data){
                   $("#toggleVRIcon"+product_info_id).removeClass('fa fa-plus').addClass('fa fa-minus');
                   $("child_"+product_info_id).show(500);
                   $(obj).closest('tr').after(data.data);
                 }
              },
         });
      }else{
         $(".child_"+product_info_id).remove();
         $("#toggleVRIcon"+product_info_id).removeClass('fa fa-minus').addClass('fa fa-plus');
         $(obj).attr("toggleShow", "close");
      }
   }
   
</script>
<script type="text/javascript">
   $(document).ready(function() {
           $(function () {
               $('.datetimepicker').datetimepicker({
                 format: 'YYYY-MM-DD'
               });
           });
       });
</script>