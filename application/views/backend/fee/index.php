<div class="bread_parent">
   <div class="col-md-9">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
         <li><b>Your Fee</b> </li>
      </ul>
   </div>
   <div class="clearfix"></div>
</div>
<div class="panel-body no-padding-top">
   <header class="tabel-head-section">
      <form action="<?php echo base_url('backend/fee/index') ?>" method="get" role="form" class="form-horizontal">
         <div class="no-padding-top">
            <table class="responsive table_head" cellpadding="5">
               <thead>
                  <tr>
                     <th width="2%">Name Of Sellers</th>
                     <th width="10%"></th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
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
                     <td width="110"> 
                        <button class="btn btn-primary tooltips" rel="tooltip" data-placement="top" data-original-title="Search" type="submit"><i class="icon icon-search"></i></button>
                        <a class="btn btn-danger tooltips" rel="tooltip" data-placement="top" data-original-title="Reset your fee search" type="submit" href="<?php echo base_url('backend/fee/index'); ?>"> <i class="icon icon-refresh"></i></a>
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
               <th width="5%">#</th>
               <th width="15%">Name Of Sellers</th>
               <th width="10%">Count Of Orders</th>
               <th width="10%">Total Amount</th>
               <th width="8%">Your Fee</th>
               <th width="8%">Pay to Seller</th>
               <th width="10%">Paid Amount</th>
               <th width="12%">Remaining Amount</th>
               <th width="10%">Actions</th>
            </tr>
         </thead>
         <tbody>
            <?php
               if(!empty($sellers)){
               $i=0; 
               foreach($sellers as $row){
                  $i++;
            ?>
            <tr>
               <td><?php echo $offset+$i."."; ?></td>
               <td><a target="_balnk" href="<?php echo base_url('backend/user/view/1/'.$row->user_id); ?>"><?php echo ucwords($row->user_name); ?></a></td>
               <td>
                  <?php 
                     if($row->total_orders){
                       echo $row->total_orders;
                     }else{
                       echo 0;
                     }  
                  ?>
               </td>
               <td>
                  <div class="cryptocurrency-popover">
                     <?php
                        $total_amountInDollor = 0.00;
                        $total_amountInEth    = 0.00;
                        $total_amountInBtc    = 0.00;
                        if(!empty($row->total_amount)){
                          $total_amountInDollor = $row->total_amount * $row->currency_amount_in_dollor;
                          $total_amountInEth    = $row->total_amount * $row->currency_amount_in_ethereum;
                          $total_amountInBtc    = $row->total_amount * $row->currency_amount_in_bitcoin;
                        }
                     ?>
                     <span class="crypto-spn" role="top" data-placement="top" data-toggle="popover" data-trigger="hover" title="Cryptocurrency" data-content="<i class='cf cf-btc'></i> <?php echo number_format($total_amountInBtc,8); ?> BTH <br> <i class='cf cf-eth'></i> <?php echo number_format($total_amountInEth,8); ?> ETH">
                       <i class="fa fa-dollar"></i><?php echo number_format($total_amountInDollor,2); ?>
                     </span>
                  </div>
               </td>
               <td>
                  <div class="cryptocurrency-popover">
                     <?php
                        $fee_previewInDollor = 0.00;
                        $fee_previewInEth    = 0.00;
                        $fee_previewInBtc    = 0.00;
                        if(!empty($row->fee_preview)){
                          $fee_previewInDollor = $row->fee_preview * $row->currency_amount_in_dollor;
                          $fee_previewInEth    = $row->fee_preview * $row->currency_amount_in_ethereum;
                          $fee_previewInBtc    = $row->fee_preview * $row->currency_amount_in_bitcoin;
                        }
                     ?>
                     <span class="crypto-spn" role="top" data-placement="top" data-toggle="popover" data-trigger="hover" title="Cryptocurrency" data-content="<i class='cf cf-btc'></i> <?php echo number_format($fee_previewInBtc,8); ?> BTH <br> <i class='cf cf-eth'></i> <?php echo number_format($fee_previewInEth,8); ?> ETH">
                       <i class="fa fa-dollar"></i><?php echo number_format($fee_previewInDollor,2); ?>
                     </span>
                  </div>
               </td>
               <td>
                  <div class="cryptocurrency-popover">
                     <?php
                        $pay_to_sellerInDollor = 0.00;
                        $pay_to_sellerInEth    = 0.00;
                        $pay_to_sellerInBtc    = 0.00;
                        if(!empty($row->pay_to_seller)){
                          $pay_to_sellerInDollor = $row->pay_to_seller * $row->currency_amount_in_dollor;
                          $pay_to_sellerInEth    = $row->pay_to_seller * $row->currency_amount_in_ethereum;
                          $pay_to_sellerInBtc    = $row->pay_to_seller * $row->currency_amount_in_bitcoin;
                        }
                     ?>
                     <span class="crypto-spn" role="top" data-placement="top" data-toggle="popover" data-trigger="hover" title="Cryptocurrency" data-content="<i class='cf cf-btc'></i> <?php echo number_format($pay_to_sellerInBtc,8); ?> BTH <br> <i class='cf cf-eth'></i> <?php echo number_format($pay_to_sellerInEth,8); ?> ETH">
                       <i class="fa fa-dollar"></i><?php echo number_format($pay_to_sellerInDollor,2); ?>
                     </span>
                  </div>
               </td>
               <td>
                  <div class="cryptocurrency-popover">
                     <?php
                        $paid_amountInDollor = 0.00;
                        $paid_amountInEth    = 0.00;
                        $paid_amountInBtc    = 0.00;
                        if(!empty($row->paid_amount)){
                          $paid_amountInDollor = $row->paid_amount * $row->currency_amount_in_dollor;
                          $paid_amountInEth    = $row->paid_amount * $row->currency_amount_in_ethereum;
                          $paid_amountInBtc    = $row->paid_amount * $row->currency_amount_in_bitcoin;
                        }
                     ?>
                     <span class="crypto-spn" role="top" data-placement="top" data-toggle="popover" data-trigger="hover" title="Cryptocurrency" data-content="<i class='cf cf-btc'></i> <?php echo number_format($paid_amountInBtc,8); ?> BTH <br> <i class='cf cf-eth'></i> <?php echo number_format($paid_amountInEth,8); ?> ETH">
                       <i class="fa fa-dollar"></i><?php echo number_format($paid_amountInDollor,2); ?>
                     </span>
                  </div>
               </td>
               <td>
                  <div class="cryptocurrency-popover">
                     <?php
                        $remaining_amountInDollor = 0.00;
                        $remaining_amountInEth    = 0.00;
                        $remaining_amountInBtc    = 0.00;
                        if(!empty($row->remaining_amount)){
                          $remaining_amountInDollor = $row->remaining_amount * $row->currency_amount_in_dollor;
                          $remaining_amountInEth    = $row->remaining_amount * $row->currency_amount_in_ethereum;
                          $remaining_amountInBtc    = $row->remaining_amount * $row->currency_amount_in_bitcoin;
                        }
                     ?>
                     <span class="crypto-spn" role="top" data-placement="top" data-toggle="popover" data-trigger="hover" title="Cryptocurrency" data-content="<i class='cf cf-btc'></i> <?php echo number_format($remaining_amountInBtc,8); ?> BTH <br> <i class='cf cf-eth'></i> <?php echo number_format($remaining_amountInEth,8); ?> ETH">
                       <i class="fa fa-dollar"></i><?php echo number_format($remaining_amountInDollor,2); ?>
                     </span>
                  </div>
               </td>
               <td><a href="<?php echo base_url()?>backend/fee/transaction/<?php echo $row->user_id; ?>" class="btn-xs btn btn-info tooltips" rel="tooltip" data-placement="top" data-original-title="Click to view the list of orders payment">Checkout Orders Payment</a></td>
            </tr>
            <?php } ?>
            <?php }else{ ?>
            <tr>
               <th colspan="9">
                  <center>No sellers Available.</center>
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