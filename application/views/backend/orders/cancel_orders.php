<div class="bread_parent">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
         <li><b>List Of Cancel Orders</b> </li>
      </ul>
   </div>
   <!-- <div class="col-md-5">
      <div class="btn-group pull-right" style="margin-left: 5px;">
         <a class="btn btn-primary tooltips" href="<?php echo base_url()?>backend/products/product_category" rel="tooltip" data-placement="top" data-original-title=" Click to add a product "><i class="icon-plus"></i> Add a Product
         </a>
      </div>
      <div class="btn-group pull-right">
         <a class="btn btn-primary tooltips" href="<?php echo base_url()?>backend/products/product_category" rel="tooltip" data-placement="top" data-original-title=" Click to add a variation"><i class="icon-plus"></i> Add a Variation
         </a>
      </div>
   </div> -->
   <div class="clearfix"></div>
</div>

<div class="panel-body">
   <header class="row">
      <form action="<?php echo base_url('backend/orders/open_orders') ?>" method="get" role="form" class="form-horizontal">
         <div class="panel-body">
            <table class="responsive table_head" cellpadding="5">          
               <thead>
                  <tr>
                     <th width="8%"><i class="fa fa-info-circle" aria-hidden="true"></i> Product Title</th>
                     <th width="8%"><i class="fa fa-info-circle" aria-hidden="true"></i> Order ID</th>   
                     <th width="8%"><i class="fa fa-user"></i> Customer Name</th>
                     <th width="10%"></th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>                
                        <input type="text" placeholder="Product Title" class="form-control" name="title" value="<?php if(!empty($_GET['title'])) echo $_GET['title']; ?>">
                     </td>
                     <td>             
                        <input type="text" placeholder="Order ID" class="form-control" name="order_id" value="<?php if(!empty($_GET['order_id'])) echo $_GET['order_id']; ?>">  
                     </td>
                     <td>          
                        <input type="text" placeholder="Customer Name" class="form-control" name="user_name" value="<?php if(!empty($_GET['user_name'])) echo $_GET['user_name']; ?>">
                     </td>
                     <td width="110"> 
                        <button class="btn btn-primary tooltips" rel="tooltip" data-placement="top" data-original-title="Search" type="submit"><i class="icon icon-search"></i></button>
                        <a class="btn btn-danger tooltips" rel="tooltip" data-placement="top" data-original-title="Reset your open order search" type="submit" href="<?php echo base_url('backend/orders/open_orders'); ?>"> <i class="icon icon-refresh"></i></a>
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
               <th width="12%">Order ID</th>
               <th width="15%">Shipping To</th>
               <th width="10%">Gross Items</th>
               <th width="12%">Shipping Amount</th>
               <th width="12%">Total Amount</th>
               <th width="8%">No. Of Items</th>
               <th width="12%">Order Date</th>
               <th width="8%">Actions</th>
            </tr>
         </thead>
         <tbody>
            <?php
               if(!empty($orders)){
               $i=0; 
               foreach($orders as $row){
               $i++;
            ?>
            <tr>
               <td>
                  <span class="checkboxli term-check">
                  <input type="checkbox" id="checkall<?php echo $i ?>" name="checkstatus[]" value="<?php echo $row->o_id; ?>">  &nbsp;&nbsp; <?php echo $i.".";?>
                  <label class="" for="checkall<?php echo $i ?>">
                  </label>
                  </span>
               </td>
               <td><?php echo $row->order_id; ?></td>
               <td>
                <?php 
                  $shipping_address = json_decode($row->shipping_address);
                  if(!empty($shipping_address)){
                    echo "<a target='_blank' href='".base_url('backend/user/view/2/'.$shipping_address->user_id)."'>".ucwords($shipping_address->first_name.' '.$shipping_address->last_name)."</a>";
                  }else{
                    echo "-";
                  } 
                ?>
               </td>
               <td><?php echo "$".number_format($row->gross_amount,2); ?></td>
               <td><?php if($row->totalShippingCharges) echo "$".number_format($row->totalShippingCharges,2); else echo "-"; ?></td>
               <td><?php echo "$".number_format($row->total_amount,2); ?></td>
               <td><?php if($row->total_items) echo $row->total_items; else echo "0"; ?></td>
               <td><?php echo date('d M Y,h:i  A',strtotime($row->created)); ?></td>
               <td>

                  <a href="javascript:void(0);" onclick="return confirmBox('Do you want to delete it ?','<?php echo base_url().'backend/common/delete/orders/o_id/'.$row->o_id; ?>')" class="btn btn-danger btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Delete Product"><i class="icon-trash "></i>
                  </a>
                  
               </td>
            </tr>
            <?php } ?>
            <?php }else{ ?>
            <tr>
               <th colspan="9">
                  <center>No Orders Available.</center>
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
            if(confirm("Are you Sure you want to "+action_name+" it!") == false){
               return false;
            }

            var i=0;
            $("input[type='checkbox']:checked").each(function() {
               if($(this).val()!=''){
                  row_id[i]=$(this).val();       
                  i++; 
               }    
            });   

            var tb_name = "<?php echo base64_encode('product_variations'); ?>"; 
            var col_name = "<?php echo base64_encode('product_variation_id'); ?>";     

            $.post('<?php echo base_url() ?>'+'backend/pages/change_all_status', {'table_name': tb_name, 'col_name': col_name, 'status': new_status, 'row_id': row_id}, function(data) {            
               if(data.status==true){  
                  $(location).attr('href', '<?php echo base_url('backend/products/index')?>');
               }else{       
                  window.location.reload(true);
                  return false;
               }
            });    
         }else{
            alert('Please Check the checkbox');
            return false;
         } 

      });

   });
   
   function getChildVariationProducts(obj){
      var toggleShow      = $(obj).attr("toggleShow");
      var product_info_id = $(obj).attr("infoDetails");

      if(toggleShow=='close'){
         $(obj).attr("toggleShow", "open");
         $.ajax({
              url: SITE_URL + 'backend/products/getVariationProducts',
              type: 'POST',
              data: {
                  product_info_id: product_info_id
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