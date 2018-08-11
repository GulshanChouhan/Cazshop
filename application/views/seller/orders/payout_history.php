<div class="body-container clearfix">
<div class="bread_parent">
   <ul class="breadcrumb">
      <li><a href="<?php echo base_url('seller/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
      <li><b>Payout History</b></li>
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
                              <form action="<?php echo base_url('seller/orders/payout_history') ?>" method="get" role="form" class="form-horizontal">
                                <table class="responsive table_head common-table-top-section" cellpadding="5">
                                  <thead>
                                    <tr>
                                      <th width="20%">Order status</th>
                                      <th width="20%">Payment Status</th>
                                      <th width="100px"></th>
                                      <th></th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <div class="">
                                          <select name="order_status" class="form-control">                  
                                              <option value="" <?php if(!empty($_GET['order_status']) && $_GET['order_status']=='') echo 'selected'; ?>>--All Orders--</option>
                                              <?php 
                                                $orderStatusPages = orderStatusPages();
                                                foreach ($orderStatusPages as $key => $value) {
                                                  if($key!=5 && $key!=6){
                                              ?>
                                                <option value="<?php echo $key; ?>" <?php if(!empty($_GET['order_status']) && $_GET['order_status']==$key) echo 'selected'; ?>><?php echo $value; ?></option>  
                                              <?php } }
                                              ?>
                                         </select>
                                        </div>
                                      </td>
                                      <td>
                                        <div class="">
                                          <select name="paid_status" class="form-control">                  
                                              <option value="">All</option> 
                                              <option value="1" <?php if(!empty($_GET['paid_status']) && $_GET['paid_status']=='1') echo 'selected'; ?>>Paid</option> 
                                              <option value="2" <?php if(!empty($_GET['paid_status']) && $_GET['paid_status']=='2') echo 'selected'; ?>>Unpaid</option> 
                                          </select>
                                        </div>
                                      </td>
                                      <td>
                                        <button class="btn btn-primary tooltips" rel="tooltip" data-placement="top" data-original-title="Search" type="submit"><i class="icon icon-search"></i></button>
                                        <a class="btn btn-danger tooltips" rel="tooltip" data-placement="top" data-original-title="Reset your payout history search" type="submit" href="<?php echo base_url('seller/orders/payout_history') ?>"> <i class="icon icon-refresh"></i></a>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </form>
                              <!-- END FORM--> 
                           </div>

                           <div class="col-sm-12 no-padding">
                             <div class="adv-table inventory-experience-wrapper" id="tab1">
                                <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
                                   <thead class="thead_color">
                                      <tr>
                                         <th class="jv no_sort" width="4%">
                                          #
                                         </th>
                                         <th width="8%">Order ID</th>
                                         <th width="25%">Item Info</th>
                                         <th width="9%">Total Amount</th>
                                         <th width="8%">Fee Preview</th>
                                         <th width="9%">Paid Amount</th>
                                         <th width="10%">Item Status</th>
                                         <th width="10%">Payment Status</th>
                                         <th width="5%">Actions</th>
                                      </tr>
                                   </thead>
                                   <tbody>
                                      <?php
                                       if(!empty($fee_preview)){
                                         $i=0;
                                         foreach($fee_preview as $row){
                                          $i++;
                                      ?>
                                      <tr>
                                          <td>
                                            <?php 
                                              echo $i+$offset.".";
                                            ?>
                                          </td>
                                          <td>
                                            <?php 
                                              $orderData = getRow('orders',array('o_id'=>$row->order_table_id),array('order_id'));
                                              $orderId = ($orderData) ? $orderData->order_id : "0";
                                              if($orderId!=0){
                                                echo "<a target='_blank' href='".base_url('seller/orders/order_details/'.base64_encode($row->order_detail_id)).'/'.$row->order_status."'>".$orderId."</a>";
                                              }else{
                                                echo "-";
                                              }
                                            ?>
                                         </td>
                                         <td>
                                          <?php 
                                            $productDetails = json_decode($row->product_details);
                                            if(!empty($productDetails)){
                                          ?>
                                            <a class="link-text-black" target='_blank' href="<?php echo base_url('pd/'.$productDetails->slug.'/'.base64_encode($productDetails->product_variation_id)); ?>">
                                              <?php echo ucfirst($productDetails->title); ?>
                                            </a>
                                          <?php }else{
                                              echo "-";
                                            }
                                          ?>
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
                                         <td class="font-roboto">
                                           <?php
                                               if($row->fee_preview){
                                                 if($row->currency_type==1){
                                                   $totalGross = $row->fee_preview * $row->currency_amount_in_ethereum;
                                                 }else if($row->currency_type==2){
                                                   $totalGross = $row->fee_preview * $row->currency_amount_in_bitcoin;
                                                 }else{
                                                   $totalGross = $row->fee_preview * $row->currency_amount_in_dollor;
                                                 }
                                                 echo getCurrencyIcon($row->currency_type).''.number_format($totalGross, 8); 
                                               }else{
                                                 echo "0.00";
                                               }  
                                           ?>
                                         </td>
                                         <td class="font-roboto">
                                           <?php
                                               if($row->pay_to_seller){
                                                 if($row->currency_type==1){
                                                   $totalGross = $row->pay_to_seller * $row->currency_amount_in_ethereum;
                                                 }else if($row->currency_type==2){
                                                   $totalGross = $row->pay_to_seller * $row->currency_amount_in_bitcoin;
                                                 }else{
                                                   $totalGross = $row->pay_to_seller * $row->currency_amount_in_dollor;
                                                 }
                                                 echo getCurrencyIcon($row->currency_type).''.number_format($totalGross, 8); 
                                               }else{
                                                 echo "0.00";
                                               }  
                                           ?>
                                         </td>
                                         <td>
                                            <div class="btn-group">
                                              <span data-toggle="dropdown" type="button" class="btn btn-<?php if(!empty($row->order_status)) echo orderStatuscls($row->order_status); else echo "primary"; ?> btn-xs dropdown-toggle">
                                              <?php
                                                $order_status = orderStatusName($row->order_status);
                                                if($order_status) echo $order_status; else echo "-";
                                              ?>
                                              </span>
                                           </div>
                                         </td>
                                         <td>
                                            <span class="btn btn-<?php if($row->remaining_amount=='0.00' && $row->remaining_amount!='') echo 'success'; else echo 'danger';  ?> btn-xs">
                                              <?php if($row->remaining_amount=='0.00' && $row->remaining_amount!='') echo "Paid"; else echo "Unpaid";  ?>
                                            </span>
                                         </td>
                                         <td>
                                          <a target="_blank" href="<?php echo base_url('seller/orders/order_details/'.base64_encode($row->order_detail_id).'/'.$row->order_status); ?>" class="btn btn-info btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="View Order details"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                         </td>
                                      </tr>
                                      <?php } ?>
                                      <?php }else{ ?>
                                      <tr>
                                         <th colspan="9">
                                            <center>No Orders payment history available.</center>
                                         </th>
                                      </tr>
                                      <?php } ?>
                                   </tbody>
                                </table>
                                <div class="row-fluid control-group mt15 pull-right">
                                   <div class="span12">
                                      <?php if(!empty($pagination))  echo $pagination;?>
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
</div>
</div>

