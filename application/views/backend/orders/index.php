<div class="bread_parent">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
         <li><b>List Of <?php echo ucfirst($title); ?></b> </li>
      </ul>
   </div>
   <div class="clearfix"></div>
</div>

<div class="panel-body no-padding-top">
   <header class="tabel-head-section">
      <form action="<?php echo base_url('backend/orders/index/'.$status) ?>" method="get" role="form" class="form-horizontal">
         <div class="no-padding-top">
            <table class="responsive table_head" cellpadding="5">          
               <thead>
                  <tr>
                     <th width="8%">Product Title</th>
                     <th width="8%">Order ID</th>   
                     <th width="18%">Buyer Name</th>
                     <?php if(empty($status)){ ?>
                     <th width="10%">Order Status</th>
                     <?php } ?>
                     <th width="10%"></th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                     <td>                
                        <input type="text" placeholder="Ex : Sport shoes, Kurta for woman etc" class="form-control" name="title" value="<?php if(!empty($_GET['title'])) echo $_GET['title']; ?>">
                     </td>
                     <td>             
                        <input type="text" placeholder="Ex : 91491699218" class="form-control" name="order_id" value="<?php if(!empty($_GET['order_id'])) echo $_GET['order_id']; ?>">  
                     </td>
                     <td>          
                        <input type="text" placeholder="Search for First name, Last name, Email Id or Phone No." class="form-control" name="user_name" value="<?php if(!empty($_GET['user_name'])) echo $_GET['user_name']; ?>">
                     </td>
                     <?php if(empty($status)){ ?>
                     <td>          
                        <select class="form-control" name="orderstatus">
                          <option value="">--Select--</option>
                          <?php $orderStatusDD=orderStatusDD();
                            foreach ($orderStatusDD as $key => $value) {
                              ?>
                              <option value="<?php echo $key; ?>"<?php if(!empty($_GET['orderstatus'])) { if($key==$_GET['orderstatus']) { echo "selected"; } }?>><?php echo $value; ?></option>
                              <?php
                              
                            }
                          ?>
                        </select>
                     </td>
                     <?php } ?>
                     <td width="110"> 
                        <button class="btn btn-primary tooltips" rel="tooltip" data-placement="top" data-original-title="Search" type="submit"><i class="icon icon-search"></i></button>
                        <a class="btn btn-danger tooltips" rel="tooltip" data-placement="top" data-original-title="Reset your search result" type="submit" href="<?php echo base_url('backend/orders/index/'.$status); ?>"> <i class="icon icon-refresh"></i></a>
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
                <div class="col-md-12 no-padding">
                  <span class="checkboxli term-check">
                    <input class="styled" type="checkbox" id="checkAll" class="" >
                    <label class="" for="checkAll"></label>
                  </span>
                  <span>
                     <select class="form-control commonstatus order-select-status">
                        <option value="">All</option>
                        <?php
                            $orderStatus = orderStatus();
                           foreach ($orderStatus as $key => $value){
                              if($key!=1 && $key!=3 && $key<=5){ 
                        ?>
                        <option <?php if($status >=$key) echo 'disabled="disabled"'; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } } ?>
                     </select>
                  </span>
                </div>
               </th>
               <th width="8%">Order ID</th>
               <th width="20%">Product Title</th>
               <th width="10%">Buyer Information</th>
               <th class="text-center" width="10%">Grand Total</th>
               <th class="text-center" width="8%">Status</th>
               <?php if($status==4){ ?>
               <th class="text-center" width="10%">Your Confirmation</th>
               <?php } ?>
               <th class="text-center" width="14%">Actions</th>
            </tr>
         </thead>

         <tbody>
          <?php
             if(!empty($orders)){
             $i=0; 
             foreach($orders as $row){
                $shipping_address = json_decode($row->shipping_address);
                $product_details  = json_decode($row->product_details);
                $order_detail_id = base64_encode($row->order_detail_id);

                if(!empty($shipping_address)){
                  $country = getData('countries',array('id',$shipping_address->country))->name;
                  $state = getData('states',array('id',$shipping_address->state))->name;
                  $city = getData('cities',array('id',$shipping_address->city))->name;
                }
             $i++;
             ?>
          <tr>
              <td>
                  <span class="checkboxli term-check">
                    <input type="checkbox" id="checkall<?php echo $i ?>" name="checkstatus[]" value="<?php echo $row->order_detail_id; ?>">  &nbsp;&nbsp; <?php echo $offset+$i.".";?>
                    <label class="" for="checkall<?php echo $i ?>">
                    </label>
                  </span>
              </td>
              <td>
                  <?php echo "<a href='".base_url('backend/orders/order_details/'.base64_encode($row->order_detail_id))."'>".$row->order_id."</a>"; ?>
              </td>
              <td>
                <a class="link-text-black" target='_blank' href="<?php echo base_url('pd/'.$product_details->slug.'/'.base64_encode($product_details->product_variation_id)); ?>">
                  <?php echo ucfirst($product_details->title); ?>
                </a>
                <div>
                    <span><b>Order Date -</b> <?php echo date('d M Y',strtotime($row->created)); ?></span>
                </div>
              </td>
              <td>
                <span><a href="javascript:void(0)" class="link-text" data-container="body" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="<?php echo $shipping_address->address.', '.$city.', '.$state.', '.$country.' - '.$shipping_address->zip_code; ?>"><?php echo ucwords($shipping_address->first_name.' '.$shipping_address->last_name); ?></a></span><br>
                <span><?php echo $shipping_address->email_id; ?></span><br>
                <span><?php echo '+'.$shipping_address->country_code.' '.$shipping_address->phone_no; ?></span>
              </td>
              <td class="text-center">
               <?php
                   if($row->subtotal){
                     if($row->currency_type==1){
                       $totalGross = $row->subtotal * $row->currency_amount_in_ethereum;
                     }else if($row->currency_type==2){
                       $totalGross = $row->subtotal * $row->currency_amount_in_bitcoin;
                     }else{
                       $totalGross = $row->subtotal * $row->currency_amount_in_dollor;
                     }
                     echo getCurrencyIcon($row->currency_type).''.number_format($totalGross, 8); 
                   }else{
                     echo "0.00";
                   }  
               ?>
              </td>
              <td class="text-center">
                 <div class="btn-group">
                    <button data-toggle="dropdown" type="button" class="btn btn-<?php if(!empty($row->order_status)) echo orderStatuscls($row->order_status); else echo "primary"; ?> btn-xs dropdown-toggle">
                    <?php
                      $order_status = orderStatusName($row->order_status);
                      if($order_status) echo $order_status; else echo "-";
                    ?>
                    </button>
                 </div>
              </td>
              <?php 
                if($status==4){
                  $order_detail_id = base64_encode($row->order_detail_id); 
              ?>
              <td class="text-center">
                <?php if($row->admin_delivered_confirmation==0){ ?>
                  <a onclick="return confirmBox('Do you want to confirm this order as deliver ?','<?php echo base_url('backend/orders/admin_delivered/'.$order_detail_id.'/'.$status); ?>')" href="javascript:void(0)" class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Click to confirm this order as deliver">Complete the Order  
                  </a>
                <?php }else{ ?>
                  <span class="btn btn-success btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="You have confirmed to delivered the order successfully">completed</span>
                <?php } ?>
              </td>
              <?php } ?>
              <td>
                  <div class="btn-bunch">

                    <a target="_blank" href="<?php echo base_url('backend/orders/packing_slip/'.$order_detail_id.'/'.$status); ?>" class="btn btn-default btn-xs btn-block"><i class="icofont icofont-print"></i> Print Packing Slip
                    </a>

                    <a href="javascript:void(0)" <?php if($row->order_status>=3){ ?> disabled="disabled" style="pointer-events: none;" <?php }else{ ?> odi="<?php echo base64_encode($row->order_detail_id); ?>" <?php } ?> class="btn btn-default btn-xs btn-block <?php if($row->order_status<3){ ?>getTrackingDetails<?php } ?>"><i class="icofont icofont-check"></i> Confirm Dispatch</a>

                    <a href="javascript:void(0)" <?php if($row->order_status>=4){ ?> disabled="disabled" style="pointer-events: none;" <?php }else{ ?> onclick="return confirmBox('Do you want to mark this order as delivered ?','<?php echo base_url('backend/orders/changeStatus/4/'.$row->order_detail_id); ?>')" <?php } ?> class="btn btn-default btn-xs btn-block"><i class="icofont icofont-location-pin"></i> Deliver the Order</a>

                    <a href="javascript:void(0)" <?php if($row->order_status>=4){ ?> disabled="disabled" style="pointer-events: none;" <?php }else{ ?> onclick="return confirmBox('Do you want to cancel this order ?','<?php echo base_url('backend/orders/changeStatus/5/'.$row->order_detail_id); ?>')" <?php } ?> class="btn btn-default btn-xs btn-block"><i class="icofont icofont-close"></i> Cancel the Order</a>

                  </div>
              </td>

          </tr>
          <?php } ?>
          <?php }else{ ?>
          <tr>
             <th colspan="<?php if($status==4){ echo "8"; }else{ echo "7"; } ?>">
                <center>No orders available.</center>
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

<!-- Provide the 3rd party tracking details to customer -->
<div class="modal fade" id="trackingdetailspopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content support-ticket-modal comman-modal">
         <div class="modal-header comman-header-modal">
            <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><img src="<?php echo SELLER_THEME_URL; ?>/img/Icon_Basic_Close.svg" width="18"></span>
            </button>
            <h4 class="modal-title text-center" id="myModalLabel">Submit the Order Tracking Details</h4>
         </div>
         <div class="modal-body comman-body-modal">
            <form role="form" action="" method="post" id="orderTrackingForm">
               <div class="main-loader" style='display: none;'>
                  <div class="loader">
                     <svg class="circular-loader"viewBox="25 25 50 50" >
                       <circle class="loader-path" cx="50" cy="50" r="20" fill="none" stroke="#f45b69" stroke-width="2.5" />
                     </svg>
                  </div>
               </div>
               <div class="form-body contact-support-form ">
                  <div class="right-side col-md-12">
                     <div class="">
                        <div class="col-md-12 col-sm-12">     
                           <label><b>Tracking ID <span style="color: red;" class="front_error">*</span><b></label>
                        </div>
                        <div class="form-group col-md-12 col-sm-12">
                           <input type="text" class="form-control" placeholder="Please enter the order tracking id" name="tracking_id" data-bvalidator="required" value="<?php echo set_value('tracking_id'); ?>">
                           <?php echo form_error('tracking_id') ?>
                        </div>
                     </div>
                     <div class="">
                        <div class="col-md-12 col-sm-12">     
                           <label><b>Tracking URL <span style="color: red;" class="front_error">*</span><b></label>
                        </div>
                        <div class="form-group col-md-12 col-sm-12">
                           <input type="text" class="form-control" placeholder="Please enter the order tracking url" name="tracking_url" data-bvalidator="url,required" value="<?php echo set_value('tracking_url'); ?>">
                           <?php echo form_error('tracking_url') ?>
                        </div>
                     </div>
                     <div class="">
                        <div class="col-md-12 col-sm-12">    
                           <label><b>Description <span style="color: red;" class="front_error">*</span></b></label>  
                        </div>
                        <div class="form-group col-md-12 col-sm-12">        
                           <textarea name="tracking_description" class="form-control tooltips" rel="tooltip" data-placement="top right" rows="6" placeholder="Please describe the order tracking details" maxlength="500" data-bvalidator="required,maxlen[1000]"><?php echo set_value('tracking_description'); ?></textarea>
                           <?php echo form_error('tracking_description') ?>
                        </div>
                     </div>
                     <input type="hidden" name="track_order_detail_id" id="odi_tracking" value="">
                     <div class="">
                        <div class="col-md-12 col-sm-12">    
                           <label for="" class="label"></label>  
                        </div>
                        <div class="col-md-12 col-sm-12 text-center">
                           <button type="submit" class="btn btn-lg btn-red contact-submit">Submit</button>
                        </div>
                        <div class="clearfix"></div>
                     </div>
                  </div>
               </div>
               <div class="clearfix"></div>
            </form>
         </div>
      </div>
   </div>
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

    $(document).ready(function(){
        $('[data-toggle="popover"]').popover(); 
    });
</script>
<script type="text/javascript" >
   var SITE_URL  = "<?php echo base_url(); ?>";
   jQuery(document).ready(function($) {
      $('body').find('#tab1').on('change','.commonstatus', function(event) {      
         var row_id=[] ;  
   
          var new_status=$(this).val();
          if(new_status==1){
           var action_name = 'Unshipped';
           var action_comp = 'Unshipped';
          }else if(new_status==4){
           var action_name = 'Deliver the Order';
           var action_comp = 'Delivered';
          }else if(new_status==5){
           var action_name = 'Cancel the Order';
           var action_comp = 'Cancelled';
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

                var tb_name = "<?php echo base64_encode('product_variations'); ?>"; 
                var col_name = "<?php echo base64_encode('product_variation_id'); ?>";     

                $.post('<?php echo base_url() ?>'+'backend/orders/change_all_status', {'table_name': tb_name, 'col_name': col_name, 'status': new_status, 'row_id': row_id}, function(data) {            
                   if(data.status==true){ 
                      successMsg("Order has been marked as "+action_comp+" successfully");  
                      setTimeout(function() {
                        $(location).attr('href', '<?php echo base_url('backend/orders/index/'.$status); ?>');
                      }, 2000);                   
                   }else{       
                      warningMsg("Please choose correct orders for change it to "+action_comp);  
                      setTimeout(function() {
                        $(location).attr('href', '<?php echo base_url('backend/orders/index/'.$status); ?>');
                      }, 3000);
                   }
                });

            });    
         }else{
            errorMsg("Please check the checkbox");
            return false;
         } 

      });

   });
   
   /*Open product tracking details modal*/
   $('.getTrackingDetails').on('click', function() {
      var odiVal = $(this).attr("odi");
      if(odiVal){
         $('#odi_tracking').val(odiVal);
         $('#trackingdetailspopup').modal('show');
      }else{
         errorMsg("Something went wrong! Please try again");
         return false;
      }
       
   });


   /*Submit cancellation form*/
   $('#orderTrackingForm').submit(function() {
        
      $('#orderTrackingForm').bValidator();
      // check if form is valid
      if($('#orderTrackingForm').data('bValidator').isValid()){
   
         var order_detail_id      = $("input[name=track_order_detail_id]").val();
         var tracking_id          = $("input[name=tracking_id]").val();
         var tracking_url         = $("input[name=tracking_url]").val();
         var tracking_description = $("textarea[name=tracking_description]").val();
   
         $.ajax({
            url: SITE_URL + 'backend/orders/packedForShipping_process',
            type: 'POST',
            data: {
                order_status: 3,
                order_detail_id: order_detail_id,
                tracking_id: tracking_id,
                tracking_url: tracking_url,
                tracking_description: tracking_description
            },
            beforeSend: function()
            {
              $('.main-loader').show();
            },
            cache: false,
            success: function(result) {
                var data = JSON.parse(result);
                $('.notifyjs-corner').empty();
                if(data.status=='failed'){  
                    $('.main-loader').hide();
                    errorMsg(data.msg);
                }else{
                    successMsg(data.msg);
                }
                setTimeout(function(){
                    location.reload();
                }, 2000);
            }
         });
      }
      return false;
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