<div class="body-container clearfix">
<div class="bread_parent">
   <ul class="breadcrumb">
      <li><a href="<?php echo base_url('seller/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
      <li><a href="<?php echo base_url('seller/orders/index');?>"> List of All Orders </a></li>
      <li><b>Orders Details</b></li>
   </ul>
   <div class="clearfix"></div>
</div>

<?php
   $cityName = "";
   $provinceName = "";
   $countryName = "";
   $orderCancelOrReturn = false;
   $reason = "";


   $other_shipping_details = json_decode($order_info->other_shipping_details);
   $shipping_address_details = json_decode($order_info->shipping_address);
   if(!empty($shipping_address_details)){
      $cityName = getData('cities', array('id',$shipping_address_details->city))->name;
      $provinceName = getData('states', array('id',$shipping_address_details->state))->name;
      $countryName = getData('countries', array('id',$shipping_address_details->country))->name;
   }

   if($status==5 || $status==6){
      $order_status = getRow('order_status',array('status'=>$status, 'order_detail_id'=>$order_detail_id));
      if(!empty($order_status)){
         $orderCancelOrReturn = true;
         $reason = orderStatusName($status);
      }
   }

?>

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
                        <div class="panel-heading">
                           <div class="panel-title"><i class="icofont icofont-shopping-cart"></i> Order Details</div>
                        </div>
                        <div class="col-sm-12 col-md-12 order-date-invoice-wrapper clearfix">
                           <div class="date-order-left">
                              <div class="a-row order-date-item">
                                 <span>Order ID #<?php echo $order_info->order_id; ?></span>
                              </div>
                           </div>
                        </div>
                        <div class="panel-body">
                           <div class="">
                              <div class="order-common-panel">
                                 <div class="order-panel-body order-details-summary-body clearfix">
                                    <div class="left-sdie">
                                       <div class="col-sm-12 col-md-12 no-padding-left">
                                          <div class="shipping-address-contain">
                                             <!-- <h5><b>Shipping Address</b></h5> -->
                                             <div class="shipping-address-order-details">
                                                <div class="inside-content-table">
                                                   <table class="table" cellspacing="0" cellpadding="0" border="0">
                                                      <tbody>
                                                         <tr>
                                                            <td class="label-tittle">Shipping Method</td>
                                                            <td class="value">
                                                               <?php
                                                                  if(is_numeric($other_shipping_details->shipping_method)){
                                                                     $shipping_method = getRow('shipping_option',array('shipping_option_id'=>$other_shipping_details->shipping_method),array('title')); 
                                                                     if($shipping_method->title) echo $shipping_method->title; else echo "-";
                                                                  }else{
                                                                     echo $other_shipping_details->shipping_method;
                                                                  }
                                                                  
                                                               ?>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td class="label-tittle">Date Of Purchasing</td>
                                                            <td class="value">
                                                               <?php echo date('D d M Y , h:i  A',strtotime($order_info->created));?>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td class="label-tittle">Date Of Delivery (approx.)</td>
                                                            <td class="value">
                                                               <?php
                                                                if($other_shipping_details->shipping_method=='Free Shipping'){
                                                                  echo "Not Confirmed";
                                                                }else{
                                                                  if($other_shipping_details->min_day>0 && $other_shipping_details->max_day>0){
                                                                     $orderdate = $order_info->created;
                                                                     $minduration = ($other_shipping_details->min_day*86400);
                                                                     $maxduration = ($other_shipping_details->max_day*86400);
                                                                     $dateinsec = strtotime($orderdate);
                                                                     $minnewdate=$dateinsec+$minduration;
                                                                     $maxnewdate=$dateinsec+$maxduration;
                                                                     echo date('D d M Y',$minnewdate).' <b>To</b> '.date('D d M Y',$maxnewdate);
                                                                  }else{
                                                                     echo "Not Confirmed";
                                                                  }
                                                                } 
                                                               ?>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td class="label-tittle">Ship To</td>
                                                            <td class="value">
                                                               <b>Name :</b> <?php echo ucwords($shipping_address_details->first_name.' '.$shipping_address_details->last_name); ?><br>
                                                               <b>Mobile No. :</b> <?php echo $shipping_address_details->country_code.' '.$shipping_address_details->phone_no; ?><br>
                                                               <?php echo $shipping_address_details->address; ?><br>
                                                               <?php echo $cityName; ?>, <?php echo $provinceName; ?>, <?php echo $shipping_address_details->zip_code; ?><br>
                                                               <?php echo $countryName; ?>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td class="label-tittle">Fulfillment</td>
                                                            <td class="value">Seller</td>
                                                         </tr>
                                                         <tr>
                                                            <td class="label-tittle">Sales Channel</td>
                                                            <td class="value"><?php echo SITE_NAME; ?></td>
                                                         </tr>
                                                         <tr>
                                                            <td class="label-tittle">Contact Buyer</td>
                                                            <td class="value"><?php echo ucwords($shipping_address_details->first_name.' '.$shipping_address_details->last_name); ?></td>
                                                         </tr>
                                                         <tr>
                                                            <td class="">&nbsp;</td>
                                                            <td class="">&nbsp;</td>
                                                         </tr>
                                                      </tbody>
                                                   </table>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="right-sdie">
                                       <div class="order-summary-deails-wrapper">
                                          <h4><b>Purchasing on <?php echo date('D d M Y',strtotime($order_info->created));?></b></h4>
                                          <div class="order-summary-contain">
                                             <div class="order-item a-row">
                                                <div class="col-sm-7 text-left no-padding">
                                                   <span>Items Total:</span>
                                                </div>
                                                <div class="col-sm-5 text-right no-padding">
                                                   <span>
                                                      <?php
                                                          if($order_info->price){
                                                            if($order_info->currency_type==1){
                                                              $totalGross = $order_info->price * $order_info->currency_amount_in_ethereum;
                                                            }else if($order_info->currency_type==2){
                                                              $totalGross = $order_info->price * $order_info->currency_amount_in_bitcoin;
                                                            }else{
                                                              $totalGross = $order_info->price * $order_info->currency_amount_in_dollor;
                                                            }
                                                            echo getCurrencyIcon($order_info->currency_type).''.number_format($totalGross, 8); 
                                                          }else{
                                                            echo "0.00";
                                                          }  
                                                      ?>
                                                   </span>
                                                </div>
                                             </div>
                                             <div class="order-item a-row">
                                                <div class="col-sm-7 text-left no-padding">
                                                   <span>Shipping Total:</span>
                                                </div>
                                                <div class="col-sm-5 text-right no-padding">
                                                   <span>
                                                      <?php
                                                          if($order_info->shipping_charges){
                                                            if($order_info->currency_type==1){
                                                              $totalGross = $order_info->shipping_charges * $order_info->currency_amount_in_ethereum;
                                                            }else if($order_info->currency_type==2){
                                                              $totalGross = $order_info->shipping_charges * $order_info->currency_amount_in_bitcoin;
                                                            }else{
                                                              $totalGross = $order_info->shipping_charges * $order_info->currency_amount_in_dollor;
                                                            }
                                                            echo getCurrencyIcon($order_info->currency_type).''.number_format($totalGross, 8); 
                                                          }else{
                                                            echo "0.00";
                                                          }  
                                                      ?>
                                                   </span>
                                                </div>
                                             </div>
                                             <!-- <div class="order-item a-row">
                                                <div class="col-sm-7 text-left no-padding">
                                                   <span>Tax Total:</span>
                                                </div>
                                                <div class="col-sm-5 text-right no-padding">
                                                   <span>-</span>
                                                </div>
                                             </div>
                                             <div class="order-item a-row">
                                                <div class="col-sm-7 text-left no-padding">
                                                   <span>Promotion Applied:</span>
                                                </div>
                                                <div class="col-sm-5 text-right no-padding">
                                                   <span>-</span>
                                                </div>
                                             </div> -->
                                             <div class="order-item grand-total a-row">
                                                <div class="col-sm-7 text-left no-padding">
                                                   <span><b>Grand Total:</b></span>
                                                </div>
                                                <div class="col-sm-5 text-right no-padding">
                                                   <span><b>
                                                      <?php
                                                          if($order_info->subtotal){
                                                            if($order_info->currency_type==1){
                                                              $totalGross = $order_info->subtotal * $order_info->currency_amount_in_ethereum;
                                                            }else if($order_info->currency_type==2){
                                                              $totalGross = $order_info->subtotal * $order_info->currency_amount_in_bitcoin;
                                                            }else{
                                                              $totalGross = $order_info->subtotal * $order_info->currency_amount_in_dollor;
                                                            }
                                                            echo getCurrencyIcon($order_info->currency_type).''.number_format($totalGross, 8); 
                                                          }else{
                                                            echo "0.00";
                                                          }  
                                                      ?>
                                                   </b></span>
                                                </div>
                                             </div>
                                             <div class="order-summary-btn-wrap">
                                                <a href="<?php echo base_url('seller/orders/invoice/'.base64_encode($order_info->order_detail_id).'/'.$status); ?>" class="btn btn-default btn-block"><i class="icofont icofont-print"></i> Print Invoice</a>

                                                <a href="<?php echo base_url('seller/orders/packing_slip/'.base64_encode($order_info->order_detail_id).'/'.$status); ?>" class="btn btn-default btn-block"><i class="icofont icofont-print"></i> Print Packing Slip</a>

                                                <?php if($order_info->order_status<4){ ?>
                                                <a href="<?php echo base_url('seller/orders/changeStatus/5/'.$order_info->order_detail_id); ?>" class="btn btn-default btn-block"><i class="icofont icofont-close"></i> Cancel the Order</a>
                                                <?php } ?>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="">
                                 <div class="order-common-panel">
                                    <?php 
                                       $orderDetailIDs = explode(',', $order_detail_id);
                                       foreach ($orderDetailIDs as $key => $value) {
                                        $order_details = getData('order_details',array('order_detail_id',$value));
                                        if(!empty($order_details)){
                                          $product_details = json_decode($order_details->product_details);
                                          $userName   = getData('users',array('user_id',$product_details->seller_id));
                                          $Image = $product_details->image;
                                          $Image = explode(',', $Image);
                                       ?>
                                    
                                       <div class="order-status-table">
                                          <div class="adv-table">
                                             <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
                                                <thead class="thead_color">
                                                   <tr>
                                                     <th class="">Status</th>
                                                     <th class="">Quantity</th>
                                                     <th class="">Product Details</th>
                                                     <?php 
                                                        if($orderCancelOrReturn){
                                                     ?>
                                                     <th class="">Reason <?php if(!empty($reason)) echo " Of ".$reason; ?></th>
                                                     <?php } ?>
                                                     <th width="10%">Unit Price</th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                   <tr>
                                                      <td>
                                                         <div class="dropdown">
                                                           <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><?php echo orderStatusName($order_details->order_status); ?>
                                                         </div>
                                                      </td>
                                                      <td>
                                                         <div class="text-center"><b>1</b></div>
                                                      </td>
                                                      <td>
                                                         <div class="a-row">
                                                            <h4 class="product-name">
                                                            <a target="_blank" class="link-text-black" href="<?php echo base_url('pd/'.$product_details->slug.'/'.base64_encode($product_details->product_variation_id)); ?>"><?php echo ucfirst($product_details->title); ?></a>
                                                            </h4>
                                                         </div>
                                                         <div class="order-item-list-inner">
                                                            <div class="img-order">
                                                               <a href="<?php echo base_url('pd/'.$product_details->slug.'/'.base64_encode($product_details->product_variation_id)); ?>">
                                                               <img src="<?php echo base_url(); ?>assets/uploads/seller/products/small_thumbnail/<?php echo $Image[0]; ?>">
                                                               </a>
                                                            </div>
                                                            <div class="order-details-map a-row">
                                                               <?php
                                                                  $tempMore = ""; 

                                                                  $product_variation_info = (isset($product_details->product_variation_info)) ? $product_details->product_variation_info : array();
                                                                  $product_basic_info = (isset($product_details->product_basic_info)) ? $product_details->product_basic_info : array();
                                              
                                                                  if(!empty($product_variation_info) && $product_variation_info!='null'){
                                                                     $product_variation_info = json_decode($product_variation_info);
                                                                     if(!empty($product_variation_info)){
                                                                        foreach ($product_variation_info as $key => $value) {
                                                                           if(!empty($key)){
                                                                              if($value){ $value = ucfirst($value); }else{ $value = "&nbsp;&nbsp;-"; }
                                                                              $tempMore .= "<div><label>".ucfirst($key)." :</label> <b class='font-roboto'>".$value."</b></div>"; 
                                                                           }
                                                                        }
                                                                     }
                                                                  }else if(!empty($product_basic_info)){
                                                                     $product_basic_info = json_decode($product_basic_info);
                                                                     if(!empty($product_basic_info)){
                                                                        foreach ($product_basic_info as $key => $value) {
                                                                           if(!empty($key)){
                                                                              
                                                                              if($value){ $value = ucfirst($value); }else{ $value = "&nbsp;&nbsp;-"; }
                                                                              $tempMore .= "<div><label>".ucfirst($key)." :</label> <b class='font-roboto'>".$value."</b></div>";
                                                                           }
                                                                        }
                                                                     }
                                                                  }
                                                                  echo $tempMore;
                                                               ?>
                                                            </div>
                                                         </div>
                                                      </td>
                                                      <?php 
                                                        if($orderCancelOrReturn){
                                                      ?>
                                                      <td>
                                                         <div class="order-details-map a-row">
                                                            <div><label><b class='font-roboto'>Subject :</b></label> <?php if($status==5){ echo orderCancellationReason($order_status->subject_of_reason); }else if($status==6){ echo orderReturnReason($order_status->subject_of_reason); }?></div>
                                                            <div><label><b class='font-roboto'>Message :</b></label> <?php echo $order_status->msg_of_reason; ?></div>
                                                         </div>
                                                      </td>
                                                      <?php } ?>
                                                      <td>
                                                         <div class="text-center font-roboto"><b>
                                                            <?php
                                                                if($order_info->price){
                                                                  if($order_info->currency_type==1){
                                                                    $totalGross = $order_info->price * $order_info->currency_amount_in_ethereum;
                                                                  }else if($order_info->currency_type==2){
                                                                    $totalGross = $order_info->price * $order_info->currency_amount_in_bitcoin;
                                                                  }else{
                                                                    $totalGross = $order_info->price * $order_info->currency_amount_in_dollor;
                                                                  }
                                                                  echo getCurrencyIcon($order_info->currency_type).''.number_format($totalGross, 8); 
                                                                }else{
                                                                  echo "0.00";
                                                                }  
                                                            ?>
                                                         </b></div>
                                                      </td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
                                    <?php   }
                                       }
                                       ?>
                                 </div>
                              </div>
                              <div class="clearfix"></div>
                              <div class="form-actiosns form-btn-block text-center">
                                 <a class="btn btn-default-white tooltips" href="<?php echo base_url(); ?>seller/orders/index/<?php echo $status; ?>" rel="tooltip" data-placement="top" title="" data-original-title="Back to Orders Listing">Back</a>
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
</script>
<script type="text/javascript" >
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
            if(confirm("Do you want to "+action_name+" it!") == false){
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
                  $(location).attr('href', '<?php echo base_url('seller/products/index')?>');
               }else{       
                  window.location.reload(true);
                  return false;
               }
            });    
         }else{
            warningMsg("Please check the checkbox");
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
              url: SITE_URL + 'seller/products/getVariationProducts',
              type: 'POST',
              data: {
                  product_info_id: product_info_id,
                  statusProduct: "1"
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

