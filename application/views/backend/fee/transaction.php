<?php 
  $getFeePreviewDetails = getFeePreviewDetails($seller_id, 1);
  if(!empty($getFeePreviewDetails)){
?>
<div class="col-md-12"><br></div>
<div class="col-md-12 text-center">
  <button class="btn btn-info" type="button" style="cursor: text; margin: 0px;">
    Total Amount - 
    <span class="badge">
      <div class="cryptocurrency-popover">
         <?php
            $total_amountInDollor = 0.00;
            $total_amountInEth    = 0.00;
            $total_amountInBtc    = 0.00;
            if(!empty($getFeePreviewDetails->total_amount)){
              $total_amountInDollor = $getFeePreviewDetails->total_amount * $getFeePreviewDetails->currency_amount_in_dollor;
              $total_amountInEth    = $getFeePreviewDetails->total_amount * $getFeePreviewDetails->currency_amount_in_ethereum;
              $total_amountInBtc    = $getFeePreviewDetails->total_amount * $getFeePreviewDetails->currency_amount_in_bitcoin;
            }
         ?>
         <span class="crypto-spn" role="top" data-placement="top" data-toggle="popover" data-trigger="hover" title="Cryptocurrency" data-content="<i class='cf cf-btc'></i> <?php echo number_format($total_amountInBtc,8); ?> BTH <br> <i class='cf cf-eth'></i> <?php echo number_format($total_amountInEth,8); ?> ETH">
           <i class="fa fa-dollar"></i><?php echo number_format($total_amountInDollor,2); ?>
         </span>
      </div>
    </span>
  </button>

  <button class="btn btn-success" type="button" style="cursor: text; margin: 0px;">
    Your Fee -
    <span class="badge">
      <div class="cryptocurrency-popover">
         <?php
            $fee_previewInDollor = 0.00;
            $fee_previewInEth    = 0.00;
            $fee_previewInBtc    = 0.00;
            if(!empty($getFeePreviewDetails->fee_preview)){
              $fee_previewInDollor = $getFeePreviewDetails->fee_preview * $getFeePreviewDetails->currency_amount_in_dollor;
              $fee_previewInEth    = $getFeePreviewDetails->fee_preview * $getFeePreviewDetails->currency_amount_in_ethereum;
              $fee_previewInBtc    = $getFeePreviewDetails->fee_preview * $getFeePreviewDetails->currency_amount_in_bitcoin;
            }
         ?>
         <span class="crypto-spn" role="top" data-placement="top" data-toggle="popover" data-trigger="hover" title="Cryptocurrency" data-content="<i class='cf cf-btc'></i> <?php echo number_format($fee_previewInBtc,8); ?> BTH <br> <i class='cf cf-eth'></i> <?php echo number_format($fee_previewInEth,8); ?> ETH">
           <i class="fa fa-dollar"></i><?php echo number_format($fee_previewInDollor,2); ?>
         </span>
      </div>
    </span>
  </button>

  <button class="btn btn-warning" type="button" style="cursor: text; margin: 0px;">
    Pay to seller -
    <span class="badge">
      <div class="cryptocurrency-popover">
         <?php
            $pay_to_sellerInDollor = 0.00;
            $pay_to_sellerInEth    = 0.00;
            $pay_to_sellerInBtc    = 0.00;
            if(!empty($getFeePreviewDetails->pay_to_seller)){
              $pay_to_sellerInDollor = $getFeePreviewDetails->pay_to_seller * $getFeePreviewDetails->currency_amount_in_dollor;
              $pay_to_sellerInEth    = $getFeePreviewDetails->pay_to_seller * $getFeePreviewDetails->currency_amount_in_ethereum;
              $pay_to_sellerInBtc    = $getFeePreviewDetails->pay_to_seller * $getFeePreviewDetails->currency_amount_in_bitcoin;
            }
         ?>
         <span class="crypto-spn" role="top" data-placement="top" data-toggle="popover" data-trigger="hover" title="Cryptocurrency" data-content="<i class='cf cf-btc'></i> <?php echo number_format($pay_to_sellerInBtc,8); ?> BTH <br> <i class='cf cf-eth'></i> <?php echo number_format($pay_to_sellerInEth,8); ?> ETH">
           <i class="fa fa-dollar"></i><?php echo number_format($pay_to_sellerInDollor,2); ?>
         </span>
      </div>
    </span>
  </button>

  <button class="btn btn-success" type="button" style="cursor: text; margin: 0px;">
    Paid Amount -
    <span class="badge">
      <div class="cryptocurrency-popover">
         <?php
            $paid_amountInDollor = 0.00;
            $paid_amountInEth    = 0.00;
            $paid_amountInBtc    = 0.00;
            if(!empty($getFeePreviewDetails->paid_amount)){
              $paid_amountInDollor = $getFeePreviewDetails->paid_amount * $getFeePreviewDetails->currency_amount_in_dollor;
              $paid_amountInEth    = $getFeePreviewDetails->paid_amount * $getFeePreviewDetails->currency_amount_in_ethereum;
              $paid_amountInBtc    = $getFeePreviewDetails->paid_amount * $getFeePreviewDetails->currency_amount_in_bitcoin;
            }
         ?>
         <span class="crypto-spn" role="top" data-placement="top" data-toggle="popover" data-trigger="hover" title="Cryptocurrency" data-content="<i class='cf cf-btc'></i> <?php echo number_format($paid_amountInBtc,8); ?> BTH <br> <i class='cf cf-eth'></i> <?php echo number_format($paid_amountInEth,8); ?> ETH">
           <i class="fa fa-dollar"></i><?php echo number_format($paid_amountInDollor,2); ?>
         </span>
      </div>
    </span>
  </button>

  <button class="btn btn-danger" type="button" style="cursor: text; margin: 0px;">
    Remaining Amount -
    <span class="badge">
      <div class="cryptocurrency-popover">
         <?php
            $remaining_amountInDollor = 0.00;
            $remaining_amountInEth    = 0.00;
            $remaining_amountInBtc    = 0.00;
            if(!empty($getFeePreviewDetails->remaining_amount)){
              $remaining_amountInDollor = $getFeePreviewDetails->remaining_amount * $getFeePreviewDetails->currency_amount_in_dollor;
              $remaining_amountInEth    = $getFeePreviewDetails->remaining_amount * $getFeePreviewDetails->currency_amount_in_ethereum;
              $remaining_amountInBtc    = $getFeePreviewDetails->remaining_amount * $getFeePreviewDetails->currency_amount_in_bitcoin;
            }
         ?>
         <span class="crypto-spn" role="top" data-placement="top" data-toggle="popover" data-trigger="hover" title="Cryptocurrency" data-content="<i class='cf cf-btc'></i> <?php echo number_format($remaining_amountInBtc,8); ?> BTH <br> <i class='cf cf-eth'></i> <?php echo number_format($remaining_amountInEth,8); ?> ETH">
           <i class="fa fa-dollar"></i><?php echo number_format($remaining_amountInDollor,2); ?>
         </span>
      </div>
    </span>
  </button>
</div>
<?php } ?>

<div class="bread_parent">
   <div class="col-md-9">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
         <li><b>List Of Orders Payment</b> </li>
      </ul>
   </div>
   <div class="clearfix"></div>
</div>
<div class="panel-body no-padding-top">
   <header class="tabel-head-section">
      <form action="<?php echo current_url(); ?>" method="get" role="form" class="form-horizontal">
         <div class="no-padding-top">
            <table class="responsive table_head" cellpadding="5">
               <thead>
                  <tr>
                     <th width="5%">Order status</th>
                     <th width="5%">Payment Status</th>
                     <th width="10%"></th>
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
                     <td width="110"> 
                        <button class="btn btn-primary tooltips" rel="tooltip" data-placement="top" data-original-title="Search" type="submit"><i class="icon icon-search"></i></button>
                        <a class="btn btn-danger tooltips" rel="tooltip" data-placement="top" data-original-title="Reset your transaction history search" type="submit" href="<?php echo base_url() ?>backend/fee/transaction/<?php echo $seller_id; ?>"> <i class="icon icon-refresh"></i></a>
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
                        <option value="1">Pay to seller</option>                    
                     </select>
                  </div>
               </th>
               <th width="10%">Order ID</th>
               <th width="30%">Item Info</th>
               <th width="10%">Total Amount</th>
               <th width="10%">Your Fee</th>
               <th width="10%">Pay to seller</th>
               <th width="9%">Item Status</th>
               <th width="7%">Payment Status</th>
               <th width="10%">Action</th>
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
                    if($row->remaining_amount=='0.00' && $row->remaining_amount!=''){
                      echo $offset+$i.".";
                    }else{ 
                  ?>
                    <span class="checkboxli term-check">
                      <input type="checkbox" id="checkall<?php echo $i ?>" name="checkstatus[]" value="<?php echo $row->order_detail_id; ?>">  &nbsp;&nbsp; <?php echo $offset+$i."."; ?>
                      <label class="" for="checkall<?php echo $i ?>">
                      </label>
                    </span>
                  <?php  }
                  ?>
               </td>
               <td>
                <?php 
                  if($row->order_id!=0){
                    echo "<a target='_blank' href='".base_url('backend/orders/order_details/'.base64_encode($row->order_detail_id))."'>".$row->order_id."</a>";
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
                  <?php
                    if($row->remaining_amount!='0.00' && $row->remaining_amount!=''){
                      $matureItem    = "<br><b style='color:#78CD51'>- Item is matured</b>";
                      $notmatureItem = "<br><b style='color:#ff6c60'>- Item isn't mature</b>"; 
                      if($row->order_status==4){
                        $productDetails = json_decode($row->product_details);
                        if($productDetails->accepted_returnpolicy==2){
                          echo $matureItem;
                        }else if($productDetails->accepted_returnpolicy==1){
                          $deliveredByAdmin  = getRow("order_status",array("status"=>4, "order_detail_id"=>$row->order_detail_id, 'user_role'=>0));
                          if(!empty($deliveredByAdmin)){
                            $return_policydays = $productDetails->return_policydays;
                            $delivered_date    = date('d M Y',strtotime($deliveredByAdmin->created));
                            $expireOn = date('d-m-Y', strtotime($delivered_date. ' + '.$return_policydays.' days'));
                            $expireOnStrTime = strtotime($expireOn);
                            $currOnStrTime = strtotime(date('d-m-Y'));
                            if($currOnStrTime < $expireOnStrTime){
                              echo $notmatureItem;
                            }else{
                              echo $matureItem;
                            }
                          }else{
                            echo $notmatureItem;
                          }
                        }
                      }else{
                        echo $notmatureItem;
                      }
                    }
                  ?>
                <?php }else{
                    echo "-";
                  }
                ?>
               </td>
               <td>
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
               <td>
                 <?php
                    if($row->fee_preview){
                      if($row->currency_type==1){
                        $totalfee_previewGross = $row->fee_preview * $row->currency_amount_in_ethereum;
                      }else if($row->currency_type==2){
                        $totalfee_previewGross = $row->fee_preview * $row->currency_amount_in_bitcoin;
                      }else{
                        $totalfee_previewGross = $row->fee_preview * $row->currency_amount_in_dollor;
                      }
                      echo getCurrencyIcon($row->currency_type).''.number_format($totalfee_previewGross, 8); 
                    }else{
                      echo "0.00";
                    }  
                 ?>
               </td>
               <td>
                 <?php
                    if($row->pay_to_seller){
                      if($row->currency_type==1){
                        $totalpay_to_sellerGross = $row->pay_to_seller * $row->currency_amount_in_ethereum;
                      }else if($row->currency_type==2){
                        $totalpay_to_sellerGross = $row->pay_to_seller * $row->currency_amount_in_bitcoin;
                      }else{
                        $totalpay_to_sellerGross = $row->pay_to_seller * $row->currency_amount_in_dollor;
                      }
                      echo getCurrencyIcon($row->currency_type).''.number_format($totalpay_to_sellerGross, 8); 
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
                <?php 
                  if($row->remaining_amount!='0.00' && $row->remaining_amount!=''){
                ?>
                <a href="javascript:void(0);" odi="<?php echo base64_encode($row->order_detail_id); ?>" class="btn btn-success btn-xs tooltips paymentConfirmation" rel="tooltip" data-placement="top" data-original-title="Pay amount to seller for this particular item"> Pay amount
                </a>
                <?php }else{
                  echo "-";
                } 
                ?>
               </td>
            </tr>
            <?php } }else{ ?>
            <tr>
               <th colspan="9">
                  <center>No Orders payment history available.</center>
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

<!-- Product payment confirmation Modal -->
<div class="modal fade" id="paymentpopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content support-ticket-modal comman-modal">
         <div class="modal-header comman-header-modal">
            <button type="button" class="close btn-close-modal" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true" style="color: #000;"><img src="<?php echo SELLER_THEME_URL; ?>/img/Icon_Basic_Close.svg" width="18"></span>
            </button>
            <h4 class="modal-title text-center" id="myModalLabel">Review the payment details of Item</h4>
         </div>
         <div class="modal-body comman-body-modal">
            <form role="form" action="" method="post" id="paymentConfirmationForm">
               <div class="contact-support-form ">
                  <div class="right-side col-md-12">
                     <div class="row">
                        <div class="col-md-12 col-sm-12">     
                           <label><h4>Item Title</h4> <span class="item_title"></span></label>
                        </div>
                        
                     </div>
                     <div class="row">
                        <div class="col-md-4 col-sm-4">     
                           <label><h4>Item Amount</h4> <span class="currency_icon"></span><span class="item_amount"></span></label>
                        </div>
                        <div class="col-md-4 col-sm-4">     
                           <label><h4>Your Fee</h4> <span class="currency_icon"></span><span class="your_fee"></span></label>
                        </div>
                        <div class="col-md-4 col-sm-4">     
                           <label><h4>Pay to seller</h4> <span class="currency_icon"></span><span class="pay_to_seller"></span></label>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-12 col-sm-12">    
                           <label><b>Message</b> : (optional)</label>  
                        </div>
                        <div class="form-group col-md-12 col-sm-12">        
                           <textarea name="comment" id="pay_comment" class="form-control tooltips" rel="tooltip" data-placement="top right" rows="6" placeholder="Comment here for related to this payment.." maxlength="500"><?php echo set_value('comment'); ?></textarea>
                           <?php echo form_error('comment') ?>
                        </div>
                     </div>
                     <input type="hidden" name="payment_order_detail_id" id="payment_order_detail_id" value="">
                     <div class="">
                        <div class="col-md-12 col-sm-12">    
                           <label for="" class="label"></label>  
                        </div>
                        <div class="col-md-12 col-sm-12 text-center">
                           <button type="submit" class="btn btn-lg btn-red contact-submit">Continue to pay</button>
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

<script type="text/javascript" >

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
                      successMsg("Your Products "+action_name+" successfully"); 
                      setTimeout(function() {
                        window.location.reload(true);
                      }, 1000);
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
   

    /*payment confirmation*/
    $('.paymentConfirmation').on('click', function() {
        var odi = $(this).attr("odi");
        if(odi){
          $.ajax({
              url: SITE_URL + 'backend/fee/getPaymentData',
              type: 'POST',
              data: {
                  odi: odi,
                  user_id: <?php echo $seller_id; ?>
              },
              cache: false,
              success: function(result) {
                  var data = JSON.parse(result);

                  if(data.data.currency_type==1){
                    total_amount = (data.data.total_amount * data.data.currency_amount_in_ethereum).toFixed(8);
                    fee_preview  = (data.data.fee_preview * data.data.currency_amount_in_ethereum).toFixed(8);
                    pay_to_seller = (data.data.pay_to_seller * data.data.currency_amount_in_ethereum).toFixed(8);
                    currency_icon = '<i class="cf cf-eth"></i>';
                  }else if(data.data.currency_type==2){
                    total_amount = (data.data.total_amount * data.data.currency_amount_in_bitcoin).toFixed(8);
                    fee_preview  = (data.data.fee_preview * data.data.currency_amount_in_bitcoin).toFixed(8);
                    pay_to_seller = (data.data.pay_to_seller * data.data.currency_amount_in_bitcoin).toFixed(8);
                    currency_icon = '<i class="cf cf-btc"></i>';
                  }else if(data.data.currency_type==3){
                    total_amount = (data.data.total_amount * data.data.currency_amount_in_dollor).toFixed(8);
                    fee_preview  = (data.data.fee_preview * data.data.currency_amount_in_dollor).toFixed(8);
                    pay_to_seller = (data.data.pay_to_seller * data.data.currency_amount_in_dollor).toFixed(8);
                    currency_icon = '<i class="fa fa-dollar"></i>';
                  }

                  if(data.status=='success'){
                     $('#paymentpopup').modal('show');
                     $('.item_title').html(data.pd.title);
                     $('.item_amount').html(total_amount);
                     $('.your_fee').html(fee_preview);
                     $('.currency_icon').html(currency_icon);
                     $('.pay_to_seller').html(pay_to_seller); 
                     $('#payment_order_detail_id').val(odi);
                  }else{
                    errorMsg(data.msg);
                    return false;
                  }
              },
          });
        }
    });


    /*Submit payment confirmation form*/
    $('#paymentConfirmationForm').submit(function() {
      
      $("button").attr("disabled", true);
      var order_detail_id = $("#payment_order_detail_id").val();
      var seller_id       = <?php echo $seller_id; ?>;
      var pay_comment     = $("#pay_comment").val();

      $.ajax({
          url: SITE_URL + 'backend/fee/paymentconfirm',
          type: 'POST',
          data: {
              pay_comment: pay_comment,
              seller_id: seller_id,
              order_detail_id: order_detail_id
          },
          beforeSend: function()
          {
            $('#loaderImg').show();
          },
          cache: false,
          success: function(result) {
            var data = JSON.parse(result);
            $('#loaderImg').hide();
            if(data.status=='failed'){  
                $("button").attr("disabled", false);
                errorMsg(data.msg);
            }else{
                successMsg(data.msg);
            }
            setTimeout(function(){
                location.reload();
            }, 1000);
          }
      });
      return false;

    });

</script>