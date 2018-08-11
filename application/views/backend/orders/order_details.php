<style type="text/css">
  .estimatedate
  {
    color: green;
    font-size: 12px;

  }
</style>
<div class="bread_parent">
   <div class="col-md-9">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
         <li><b>Order Details</b></li>
      </ul>
   </div>
   <div class="clearfix"></div>
</div>

<?php
   $orderCancelOrReturn = false;
   $reason = "";
   if($order_info->par_order_status==5 || $order_info->par_order_status==6){
      $par_order_status = getRow('order_status',array('status'=>$order_info->par_order_status, 'order_detail_id'=>$order_detail_id));
      if(!empty($par_order_status)){
         $orderCancelOrReturn = true;
         $reason = orderStatusName($order_info->par_order_status);
      }
   }
?>

<section class="panel">
   <div class="panel-body">
      <div class="table-responsive">
         <div class="panel-heading colum">
            <i class="icon-user"></i> Order Details
         </div>
         <!-- <table  width="100%" class="table table-striped table-hover">
            <tr> -->
               <br>
               <div class="col-md-4 ">
               <div class="info-view">
                  <h5 class="heading"><span><i class="fa fa-map-marker" aria-hidden="true"></i> </span><b>Shipping Address </b></h5>

                  <table class="table">
                     <tr>
                        <th>Order Date</th>
                        <td> <font class="colon">: &nbsp;</font><?php echo date('d M Y',strtotime($order_info->created)); ?></td>
                     </tr>
                     <tr>
                        <th>Order ID# </th>
                        <td> <font class="colon">: &nbsp;</font><?php echo $order_info->order_id; ?></td>
                     </tr>
                     <?php
                       $shipping_address = json_decode($order_info->shipping_address);
                       if(!empty($shipping_address)){
                       
                         $country = getData('countries',array('id',$shipping_address->country))->name;
                         $state = getData('states',array('id',$shipping_address->state))->name;
                         $city = getData('cities',array('id',$shipping_address->city))->name;
                       ?>
                     <tr>
                        <th>Full Name</th>
                        <td> <font class="colon">: &nbsp;</font><?php echo "<a target='_blank' href='".base_url('backend/user/view/2/'.$shipping_address->user_id)."'>".ucwords($shipping_address->first_name.' '.$shipping_address->last_name)."</a>"; ?></td>
                     </tr>
                     <tr>
                        <th>Phone No.</th>
                        <td> <font class="colon">: &nbsp;</font><?php echo $shipping_address->phone_no; ?></td>
                     </tr>
                     <tr>
                        <th>Address</th>
                        <td> <font class="colon">: &nbsp;</font><?php echo $shipping_address->address; ?> <?php echo $city; ?>, <?php echo $state; ?>, <?php echo $shipping_address->zip_code; ?> <?php echo $country; ?></td>
                     </tr>
                     <?php } ?>
                  </table>
               </div>
               </div>
               <div class="col-md-4 ">
               <div class="info-view">
                  <h5 class="heading"><span><i class="fa fa-info-circle" aria-hidden="true"></i> </span><b>Payment Method </b></h5>
                  <table class="table">
                     <tr>
                        <th>Paid By</th>
                        <td> 
                          <font class="colon">: &nbsp;</font>
                          <?php if($order_info->currency_type==2){ ?>
                            <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/bitcoinlgo-35.svg" width="16"> Bitcoin
                          <?php }else if($order_info->currency_type==1){ ?>
                            <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/ethereum35.svg" width="16"> Ethereum
                          <?php }else{ ?>
                            Cash on Delivery
                          <?php } ?>
                        </td>
                     </tr>
                  </table>
               </div>
               </div>
               <?php 
                  $getOrderNamePrice = getOrderNamePrice($order_detail_id);
               ?>
               <div class="col-md-4 ">
               <div class="info-view">
                  <h5 class="heading"><span><i class="fa fa-money" aria-hidden="true"></i> </span><b>Order Summary </b></h5>
                  <table class="table">
                     <tr>
                        <th>
                           Sub Total
                        </th>
                        <td> <font class="colon">: &nbsp;</font>
                            <?php
                                $grossprice = $getOrderNamePrice['grossprice'];
                                if($grossprice){
                                  if($order_info->currency_type==1){
                                    $totalgrossprice = $grossprice * $order_info->currency_amount_in_ethereum;
                                  }else if($order_info->currency_type==2){
                                    $totalgrossprice = $grossprice * $order_info->currency_amount_in_bitcoin;
                                  }else{
                                    $totalgrossprice = $grossprice * $order_info->currency_amount_in_dollor;
                                  }
                                  echo getCurrencyIcon($order_info->currency_type).''.number_format($totalgrossprice, 8); 
                                }else{
                                  echo "0.00";
                                }  
                            ?>
                          <br>
                        </td>
                     </tr>
                     <tr>
                        <th>
                           Shipping Charges
                        </th>
                        <td> <font class="colon">: &nbsp;</font>
                            <?php
                                $shippingprice = $getOrderNamePrice['shippingprice'];
                                if($shippingprice){
                                  if($order_info->currency_type==1){
                                    $totalshippingprice = $shippingprice * $order_info->currency_amount_in_ethereum;
                                  }else if($order_info->currency_type==2){
                                    $totalshippingprice = $shippingprice * $order_info->currency_amount_in_bitcoin;
                                  }else{
                                    $totalshippingprice = $shippingprice * $order_info->currency_amount_in_dollor;
                                  }
                                  echo getCurrencyIcon($order_info->currency_type).''.number_format($totalshippingprice, 8); 
                                }else{
                                  echo "0.00";
                                }  
                            ?>
                          <br>
                        </td>
                     </tr>
                     <!-- <tr>
                        <th>
                           Promotion Applied
                        </th>
                        <td> <font class="colon">: &nbsp;</font>
                            -
                          <br>
                        </td>
                     </tr> -->
                     <tr>
                        <th style="font-size: 18px; font-weight: bold;">
                           Grand Total
                        </th>
                        <td style="font-size: 18px; font-weight: bold;"> <font class="colon">: &nbsp;</font>
                            <?php
                                $price = $getOrderNamePrice['price'];
                                if($price){
                                  if($order_info->currency_type==1){
                                    $totalprice = $price * $order_info->currency_amount_in_ethereum;
                                  }else if($order_info->currency_type==2){
                                    $totalprice = $price * $order_info->currency_amount_in_bitcoin;
                                  }else{
                                    $totalprice = $price * $order_info->currency_amount_in_dollor;
                                  }
                                  echo getCurrencyIcon($order_info->currency_type).''.number_format($totalprice, 8); 
                                }else{
                                  echo "0.00";
                                }  
                            ?>
                          <br>
                        </td>
                     </tr>
                  </table>
               </div>
               </div>

               <div class="adv-table" id="tab1">
                  <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
                     <thead class="thead_color">
                        <tr>
                           <th class="jv no_sort" width="4%">
                              #
                           </th>
                           <th width="10%">Product Image</th>
                           <th width="25%">Product Title</th>
                           <th width="8%">Sold By</th>
                           <?php 
                              if($orderCancelOrReturn){
                           ?>
                           <th width="20%">Reason <?php if(!empty($reason)) echo " Of ".$reason; ?></th>
                           <?php } ?>
                           <th width="8%">Unit Price</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php 
                         $orderDetailIDs = explode(',', $order_detail_id);
                         $i=0;
                         foreach ($orderDetailIDs as $key => $value) {
                          $i++;
                          $order_details = getData('order_details',array('order_detail_id',$value));
                          if(!empty($order_details)){
                            $product_details = json_decode($order_details->product_details);
                            $userName   = getData('users',array('user_id',$product_details->seller_id));
                            $Image = $product_details->image;
                                              $Image = explode(',', $Image);
                         ?>
                        <tr>
                           <td>
                              <?php echo $i; ?>.
                           </td>
                           <td>
                              <a href="<?php echo base_url('pd/'.$product_details->slug.'/'.base64_encode($product_details->product_variation_id)); ?>">
                               <img width="150px" height="auto" src="<?php echo base_url(); ?>assets/uploads/seller/products/small_thumbnail/<?php echo $Image[0]; ?>">
                              </a>
                           </td>
                           <td>
                              <a target="_blank" class="link-text-black" href="<?php echo base_url('pd/'.$product_details->slug.'/'.base64_encode($product_details->product_variation_id)); ?>"><?php echo ucfirst($product_details->title); ?></a>
                              <?php 
                                $product_variation_info = $product_details->product_variation_info;
                                if(!empty($product_variation_info) && $product_variation_info!=''){
                                  echo "<br>";
                                  $tempMore = "";
                                  $product_variation_info = json_decode($product_variation_info);
                                  if(!empty($product_variation_info)){
                                    foreach ($product_variation_info as $key => $value) {
                                      $tempMore .= "<span><b>".ucfirst($key)." :</b> &nbsp;".ucfirst($value)."</span><br>";
                                    }
                                  }
                                }else{
                                  echo "<br>";
                                  $tempMore = "";
                                  $product_basic_info = json_decode($product_details->product_basic_info);
                                  if(!empty($product_basic_info)){
                                    foreach ($product_basic_info as $key => $value) {
                                      $tempMore .= "<span><b>".ucfirst($key)." :</b> &nbsp;".ucfirst($value)."</span><br>";
                                    }
                                  }
                                }
                                echo $tempMore;
                              ?>

                              <span><b>Estimated Delivery Date :</b></span>
                              <div>
                              <?php
                                $other_shipping_details = json_decode($order_info->other_shipping_details);
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
                              </div>

                           </td>
                           <td>
                              <?php 
                                if(!empty($userName->user_name)) 
                                  echo "<a target='_blank' href='".base_url('backend/user/view/1/'.$product_details->seller_id)."'>".ucwords($userName->user_name)."</a>";
                                else 
                                  echo "-"; 
                              ?>
                           </td>
                           <?php 
                              if($orderCancelOrReturn){
                            ?>
                            <td>
                               <div class="order-details-map a-row">
                                  <div><label><b class='font-roboto'>Subject :</b></label> <?php if($order_info->par_order_status==5){ echo orderCancellationReason($par_order_status->subject_of_reason); }else if($order_info->par_order_status==6){ echo orderReturnReason($par_order_status->subject_of_reason); }?></div>
                                  <div><label><b class='font-roboto'>Message :</b></label> <?php echo $par_order_status->msg_of_reason; ?></div>
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
                        <?php } } ?>
                     </tbody>
                  </table>
               </div>
               <!-- 
            </tr>
         </table> -->
      </div>
      <div class="clearfix"></div>
   </div>
   <div class="clearfix"></div>
</section>
