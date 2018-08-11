<div class="body-container clearfix">
   <div class="bread_parent">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('seller/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
         <li><b><?php echo ucfirst($title); ?></b></li>
      </ul>
      <div class="clearfix"></div>
   </div>
   <div class="theme-container clearfix">
      <div class="clearfix"></div>
      <div class="col-md-12 col-lg-12">
         <div class="common-tab-wrapper">
            <div class="common-tab-system partners clearfix">
               <div id="alertQuantity"></div>
            </div>
            <div class="clearfix"></div>
            <div class="common-contain-wrapper clearfix">
               <div class="">
                  <div class="">
                     <div class="">
                        <div class="common-panel panel">
                           <div class="panel-body">
                              <div class="col-sm-12 no-padding">
                                 <form action="<?php echo base_url('seller/report/orders') ?>" method="get" role="form" class="form-horizontal">
                                    <table class="responsive table_head common-table-top-section" cellpadding="5">
                                       <thead>
                                          <tr>
                                             <th width="20%">Order Date</th>
                                             <th width="12%">Order ID</th>
                                             <th width="12%">Product Title</th>
                                             <th width="15%">Buyer Infomation</th>
                                             <?php if(empty($status)){ ?>
                                             <th width="12%">Order Status</th>
                                             <?php } ?>
                                             <th width="30%"></th>
                                             <th></th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <tr>
                                             <td>
                                                <div class="input-group input-large" data-date="08-03-2018" data-date-format="dd-mm-yyyy">                 
                                                   <input type="text" class="form-control datetimepicker"  name="start_date" placeholder="Start Date" value="<?php if(!empty($_GET['start_date'])) echo $_GET['start_date']; ?>" >
                                                   <span class="input-group-addon"><i class=" icon-calendar"></i></span>
                                                   <input type="text" class="form-control datetimepicker"  placeholder="End Date" name="end_date" value="<?php if(!empty($_GET['end_date'])) echo $_GET['end_date']; ?>">
                                                </div>
                                             </td>
                                             <td>
                                                <div class="">
                                                   <input type="text" placeholder="Ex : 91491699218" class="form-control" name="order_id" value="<?php if(!empty($_GET['order_id'])) echo $_GET['order_id']; ?>"> 
                                                </div>
                                             </td>
                                             <td>
                                                <div class="">
                                                   <input type="text" placeholder="Ex : Sport shoes, Kurta for woman etc" class="form-control" name="title" value="<?php if(!empty($_GET['title'])) echo $_GET['title']; ?>">
                                                </div>
                                             </td>
                                             <td>
                                                <div class="">
                                                   <input type="text" placeholder="Search for First name, Last name, Email Id or Phone No." class="form-control" name="user_name" value="<?php if(!empty($_GET['user_name'])) echo $_GET['user_name']; ?>"> 
                                                </div>
                                             </td>
                                             <?php if(empty($status)){ ?>
                                             <td>
                                                <div class="">
                                                   <select class="form-control" name="getstatus">
                                                      <option value="">--Select--</option>
                                                      <?php 
                                                         $orderStatusDD = orderStatusDD();
                                                         if(!empty($orderStatusDD))
                                                         {
                                                           foreach ($orderStatusDD as $key => $value) {
                                                            ?>
                                                      <option value="<?php echo $key; ?>"<?php if(!empty($_GET['getstatus'])) { if($key==$_GET['getstatus']) { ?>selected<?php } } ?>><?php echo $value; ?></option>
                                                      <?php 
                                                         }
                                                         }
                                                         ?>
                                                   </select>
                                                </div>
                                             </td>
                                             <?php } ?>
                                             <td>

                                                <button class="btn btn-primary tooltips" rel="tooltip" data-placement="top" data-original-title="Search" type="submit"><i class="icon icon-search"></i></button>

                                                <a class="btn btn-danger tooltips" rel="tooltip" data-placement="top" data-original-title="Reset your order search" type="submit" href="<?php echo base_url('seller/report/orders/') ?>"> <i class="icon icon-refresh"></i></a>

                                                <a o1="export" class="btn btn-info pull-right tooltips exportData" rel="tooltip" data-placement="top" data-original-title="Export the orders excel sheet" href="javascript:void(0)">Export Orders Report</a>

                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </form>
                                 <!-- END FORM--> 
                              </div>
                              <div class="col-sm-12 no-padding">
                                 <div class="adv-table inventory-experience-wrapper" id="tab1">
                                    <form method="POST" id="order_reports" novalidate="novalidate">
                                      <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
                                         <thead class="thead_color">
                                            <tr>
                                               <th class="jv no_sort" width="8%">
                                                   <div class="col-sm-12 no-padding">
                                                     <span class="checkbox-input term-check">
                                                     <input class="styled" type="checkbox" id="checkAll" class="" >
                                                     <label class="" for="checkAll"></label>
                                                     </span>
                                                     <span>
                                                        <select class="form-control commonstatus order-select-status">
                                                          <option value="">All</option>
                                                          <?php
                                                              $orderStatus = orderStatus();
                                                             foreach ($orderStatus as $key => $value){
                                                                if($key!=3){ 
                                                          ?>
                                                          <option <?php if($status >=$key) echo 'disabled="disabled"'; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                          <?php } } ?>
                                                       </select>
                                                     </span>
                                                  </div>
                                               </th>
                                               <th width="10%">Order ID</th>
                                               <th width="25%">Product Title</th>
                                               <th width="20%">Buyer Information</th>
                                               <th width="10%">Grand Total</th>
                                               <th width="12%" class="text-center">Status</th>
                                               <th width="14%">Action</th>
                                            </tr>
                                         </thead>
                                         <tbody>
                                            <?php
                                               if(!empty($orders)){
                                               $i=0; 
                                               foreach($orders as $row){
                                                  $i++;
                                                  $order_detail_id = base64_encode($row->order_detail_id);
                                                  $shipping_address = json_decode($row->shipping_address);
                                                  $product_details  = json_decode($row->product_details);
                                               
                                                  if(!empty($shipping_address)){
                                                    $country = getData('countries',array('id',$shipping_address->country))->name;
                                                    $state = getData('states',array('id',$shipping_address->state))->name;
                                                    $city = getData('cities',array('id',$shipping_address->city))->name;
                                                  }
                                               
                                               ?>
                                            <tr>
                                               <td>
                                                  <div class="checkbox-input">
                                                     <input class="styled" type="checkbox" id="checkall<?php echo $i ?>" name="checkstatus[]" value="<?php echo $row->order_detail_id; ?>">  &nbsp;&nbsp; <?php echo $offset+$i.".";?>
                                                     <label class="" for="checkall<?php echo $i ?>"></label>
                                                  </div>
                                               </td>
                                               <td>
                                                  <a class="link-text" href="<?php echo base_url('seller/orders/order_details/'.$order_detail_id.'/'.$status); ?>"><?php echo $row->order_id; ?></a>
                                               </td>
                                               <td>
                                                  <a target="_blank" class="product-title-link" href="<?php echo base_url('pd/'.$product_details->slug.'/'.base64_encode($product_details->product_variation_id)); ?>"><?php echo ucfirst($product_details->title); ?></a>
                                                  <div>
                                                      <span><b>Order Date -</b> <?php echo date('d M Y',strtotime($row->created)); ?></span>
                                                  </div>
                                               </td>
                                               <td>
                                                  <span><a href="javascript:void(0)" class="link-text" data-container="body" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="<?php echo $shipping_address->address.', '.$city.', '.$state.', '.$country.' - '.$shipping_address->zip_code; ?>"><?php echo ucwords($shipping_address->first_name.' '.$shipping_address->last_name); ?></a></span><br>
                                                  <span><?php echo $shipping_address->email_id; ?></span><br>
                                                  <span><?php echo '+'.$shipping_address->country_code.' '.$shipping_address->phone_no; ?></span>
                                               </td>
                                               <td class="font-roboto">
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
                                               <td>
                                                  <div class="btn-bunch">

                                                    <a target="_blank" href="<?php echo base_url('seller/orders/packing_slip/'.$order_detail_id.'/'.$status); ?>" class="btn btn-default btn-xs btn-block"><i class="icofont icofont-print"></i> Print Packing Slip
                                                    </a>

                                                    <a href="javascript:void(0)" <?php if($row->order_status>=3){ ?> disabled="disabled" style="pointer-events: none;" <?php }else{ ?> odi="<?php echo base64_encode($row->order_detail_id); ?>" <?php } ?> class="btn btn-default btn-xs btn-block <?php if($row->order_status<3){ ?>getTrackingDetails<?php } ?>"><i class="icofont icofont-check"></i> Confirm Dispatch</a>

                                                    <a href="javascript:void(0)" <?php if($row->order_status>=4){ ?> disabled="disabled" style="pointer-events: none;" <?php }else{ ?> onclick="return confirmBox('Do you want to mark this order as delivered ?','<?php echo base_url('seller/orders/changeStatus/4/'.$row->order_detail_id); ?>')" <?php } ?> class="btn btn-default btn-xs btn-block"><i class="icofont icofont-location-pin"></i> Deliver the Order</a>

                                                    <a href="javascript:void(0)" <?php if($row->order_status>=4){ ?> disabled="disabled" style="pointer-events: none;" <?php }else{ ?> onclick="return confirmBox('Do you want to cancel this order ?','<?php echo base_url('seller/orders/changeStatus/5/'.$row->order_detail_id); ?>')" <?php } ?> class="btn btn-default btn-xs btn-block"><i class="icofont icofont-close"></i> Cancel the Order</a>

                                                  </div>
                                              </td>
                                            </tr>
                                            <?php } ?>
                                            <?php }else{ ?>
                                            <tr>
                                               <th colspan="7">
                                                  <center>No records available.</center>
                                               </th>
                                            </tr>
                                            <?php } ?>
                                         </tbody>
                                      </table>
                                      <div class="row-fluid  control-group mt15">
                                         <div class="text-right">
                                            <?php if(!empty($pagination))  echo $pagination;?>
                                         </div>
                                      </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
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
   var SITE_URL  = "<?php echo base_url(); ?>";
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
   
   $(document).on('input', '.quantityNo', function(){
    if (this.value.length > this.maxLength)
      this.value = this.value.slice(0, this.maxLength)
   });

   $('.exportData').click(function(){
      base_url = "<?php echo base_url(); ?>";
      titletype = $(this).attr('o1');
      if(titletype=='export'){
        $('#order_reports').attr('action', base_url+"seller/report/exportCSV").submit();
      }
      return false;
   });

</script>
<script type="text/javascript" >
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

            var tb_name = "<?php echo base64_encode('order_details'); ?>"; 
            var col_name = "<?php echo base64_encode('order_detail_id'); ?>";     

            $.post('<?php echo base_url() ?>'+'seller/orders/change_all_status', {'table_name': tb_name, 'col_name': col_name, 'order_status': new_status, 'row_id': row_id}, function(data) {  

               if(data.status==true){ 
                  successMsg("Order has been marked as "+action_comp+" successfully");  
                  setTimeout(function() {
                    $(location).attr('href', '<?php echo base_url('seller/report/orders'); ?>');
                  }, 2000);                   
               }else{       
                  warningMsg("Please choose correct orders for change it to "+action_comp);  
                  setTimeout(function() {
                    $(location).attr('href', '<?php echo base_url('seller/report/orders'); ?>');
                  }, 3000);
               }

            });  

        });

      }else{
        warningMsg("Please check the checkbox");
        return false;
      } 

    });
  });

  /*Open product cancellation modal*/
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
            url: SITE_URL + 'seller/orders/packedForShipping_process',
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