<?php if(site_access()===TRUE){ ?>
<?php if(!empty($stat_sevenDays_salesData)){ ?>
<script>
   window.onload = function() {

      var dataPoints = [];

      var options =  {
        animationEnabled: true,
        theme: "light2",
        title: {
          text: "Daily Sales Data"
        },
        axisX: {
          valueFormatString: "DD MMM YYYY",
        },
        axisY: {
          title: "USD",
          titleFontSize: 20,
          includeZero: false
        },
        data: [{
          type: "spline", 
          yValueFormatString: "$#,###.##",
          dataPoints: dataPoints
        }]
      };

      function addData(){
        var data = <?php echo $stat_sevenDays_salesData; ?>;
        for (var i = 0; i < data.length; i++) {
          var d = new Date(data[i].created);
          var n = d.getTime();
          dataPoints.push({
            x: new Date(n),
            y: data[i].subtotal
          });
        }
        $("#chartContainer").CanvasJSChart(options);

      }
      addData();
   }
</script>
<script src="<?php echo base_url('assets/seller/js/canvasjs.min.js'); ?>"></script>
<?php } ?>

<div class="body-container clearfix">
<br>

<div class="col-md-12 clearfix">
  <div class="col-md-3"> <!--class="wow fadeIn" data-wow-duration="1s" data-wow-delay="1s" style="visibility: hidden;" -->
    <div class="panel panel-dashboard box">
      <div class="panel-heading"><img src="<?php echo SELLER_THEME_URL; ?>/img/icons/shopping-cart.svg" width="20"> Your Orders</div>
        <div class="panel-body dashboard-apnel-body">
          <table class="table table-hover personal-task tabel-dashboard-section tabel-dashboard-section">
             <tbody>
                <tr>
                   <td>Today</td>
                   <td>
                    <?php 
                      if (!empty($stat_today_orders->total_orders))
                        echo $stat_today_orders->total_orders;
                      else
                        echo "0";
                     ?>
                   </td>
                </tr>
                <tr>
                   <td>Last 7 days</td>
                   <td>
                     <?php 
                      if (!empty($stat_sevenDays_orders->total_orders))
                        echo $stat_sevenDays_orders->total_orders;
                      else
                        echo "0";
                     ?>
                   </td>
                </tr>
                <tr>
                   <td>Last 15 days</td>
                   <td>
                     <?php 
                      if (!empty($stat_fifteenDays_orders->total_orders))
                        echo $stat_fifteenDays_orders->total_orders;
                      else
                        echo "0";
                     ?>
                   </td>
                </tr>
                <tr>
                   <td>Last 30 days</td>
                   <td>
                     <?php 
                      if (!empty($stat_thirtyDays_orders->total_orders))
                        echo $stat_thirtyDays_orders->total_orders;
                      else
                        echo "0";
                     ?>
                   </td>
                </tr>
                <tr>
                <tr class="total-block-wrap">
                   <td class="name">Total</td>
                   <td class="value">
                     <?php 
                      if (!empty($stat_all_orders->total_orders))
                        echo $stat_all_orders->total_orders;
                      else
                        echo "0";
                     ?>
                   </td>
                </tr>
             </tbody>
          </table>
        </div>
    </div>

    <div class="panel panel-dashboard box">
      <div class="panel-heading"><img src="<?php echo SELLER_THEME_URL; ?>/img/icons/history.svg" width="20"> History of Product Orders</div>
        <div class="panel-body">
          <table class="table table-hover personal-task tabel-dashboard-section">
             <tbody>
                <?php 
                  $orderStatus = orderStatus(); 
                  foreach ($orderStatus as $key => $value){
                    $link = base_url('seller/orders/index/'.$key);
                    $orderTotal = orderCount_with_status(seller_id(), $key);
                ?>
                <tr>
                   <td><?php echo $value; ?></td>
                   <td><?php echo $orderTotal; ?></td>
                </tr>
                <?php }
                ?>
             </tbody>
          </table>
        </div>
    </div>

  </div>
  <div class="col-md-6">
    <div class="panel panel-dashboard box">
        <?php if(!empty($stat_sevenDays_salesData)){ ?>
          <div class="panel-heading"><img src="<?php echo SELLER_THEME_URL; ?>/img/icons/profits.svg" width="20"> Orders Graph for daily basis</div>
          <div class="panel-body">
              <div id="chartContainer" style="height: 300px; width: 100%;"></div>
          </div>
        <?php }else{ ?>
          <div class="panel-body">
              <div class="flex-vertical">
                <div><img src="<?php echo SELLER_THEME_URL; ?>/img/icons/profits.svg" width="20"></div>
                <div><h4><b>No Orders available for the graph</b></h4></div>
              </div>
          </div>
        <?php } ?>
    </div>
    <div class="panel panel-dashboard box">
        <?php if(!empty($support)){ ?>
          <div class="flex-wrapper panel-heading">
            <div class=""><img src="<?php echo SELLER_THEME_URL; ?>/img/icons/support-chat.svg" width="20"> Support</div>
            <div class="view-all-support">
              <a href="<?php echo base_url('seller/support/messages'); ?>" class="text-link">View All</a>
              <span class="badge bg-important"><?php echo count($support); ?></span>
            </div>
          </div>
          <div class="panel-body">
            <div class="dashboard-chat-support" id="scrollbar-design">
              <ul class="chat">
                <?php foreach ($support as $row) { ?>
                <li class="left-chat-section clearfix">
                  <div class="chat-img">
                    <span>J</span>
                  </div>
                  <div class="chat-body clearfix">
                    <div class="header">
                      <strong class="primary-font">
                        <?php  
                            if(!empty($row->reason)){
                              $feedback_subject_status=''; 
                              $feedback_subject_status=feedback_subject_status($row->reason); 
                              echo $feedback_subject_status;
                            }else{
                              echo "Anonymous Subject";
                            } 
                        ?> 
                      </strong> 
                      <small class="pull-right time-date-wrap">
                       <?php if(!empty($row->created)) { echo'<i class="icofont icofont-clock-time"></i> '. date('d M Y,H:i ',strtotime($row->created)); } ?>
                      </small>
                    </div>
                    <div class="chat-content">
                        <?php if(!empty($row->message)){ echo character_limiter($row->message,60); } ?>
                    </div>
                    <div class="reply-chat clearfix">
                      <span class="pull-right"><a href="<?php echo base_url().'seller/support/messages/'.$row->support_id ?>"><i class="icofont icofont-reply-all"></i> Reply</a></span>
                    </div>
                  </div>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        <?php }else{ ?>
          <div class="panel-body">
              <div class="flex-vertical">
                <div><img src="<?php echo SELLER_THEME_URL; ?>/img/icons/support-chat.svg" width="20"></div>
                <h4><b>No support messages found</b></h4>
              </div>
          </div>
        <?php } ?>
    </div>
  </div>
  <div class="col-md-3">
    <div class="panel panel-dashboard box">
        <div class="panel-heading"><img src="<?php echo SELLER_THEME_URL; ?>/img/icons/Sales-Data.svg" width="20"> Sales Summary</div>
        <div class="panel-body">
            <table class="table table-hover personal-task tabel-dashboard-section">
               <tbody>
                  <tr>
                     <td>Today</td>
                     <td>
                      <div class="cryptocurrency-popover">
                      <?php
                        $todayInDollor = 0.00;
                        $todayInEth    = 0.00;
                        $todayInBtc    = 0.00;
                        if(!empty($stat_today_orders)){
                          $todayInDollor = $stat_today_orders->total_amounts * $stat_today_orders->currency_amount_in_dollor;
                          $todayInEth    = $stat_today_orders->total_amounts * $stat_today_orders->currency_amount_in_ethereum;
                          $todayInBtc    = $stat_today_orders->total_amounts * $stat_today_orders->currency_amount_in_bitcoin;
                        }
                      ?>
                        <span class="crypto-spn" role="top" data-placement="top" data-toggle="popover" data-trigger="hover" title="Cryptocurrency" data-content="<i class='cf cf-btc'></i> <?php echo number_format($todayInBtc,8); ?> BTH <br> <i class='cf cf-eth'></i> <?php echo number_format($todayInEth,8); ?> ETH">
                          <i class="fa fa-dollar"></i><?php echo number_format($todayInDollor,2); ?>
                        </span>
                      </div>
                     </td>
                  </tr>
                  <tr>
                     <td>Last 7 days</td>
                     <td>
                      <div class="cryptocurrency-popover">
                      <?php
                        $sevenDaysInDollor = 0.00;
                        $sevenDaysInEth    = 0.00;
                        $sevenDaysInBtc    = 0.00;
                        if(!empty($stat_sevenDays_orders)){
                          $sevenDaysInDollor = $stat_sevenDays_orders->total_amounts * $stat_sevenDays_orders->currency_amount_in_dollor;
                          $sevenDaysInEth    = $stat_sevenDays_orders->total_amounts * $stat_sevenDays_orders->currency_amount_in_ethereum;
                          $sevenDaysInBtc    = $stat_sevenDays_orders->total_amounts * $stat_sevenDays_orders->currency_amount_in_bitcoin;
                        }
                      ?>
                        <span class="crypto-spn" role="top" data-placement="top" data-toggle="popover" data-trigger="hover" title="Cryptocurrency" data-content="<i class='cf cf-btc'></i> <?php echo number_format($sevenDaysInBtc,8); ?> BTH <br> <i class='cf cf-eth'></i> <?php echo number_format($sevenDaysInEth,8); ?> ETH">
                          <i class="fa fa-dollar"></i><?php echo number_format($sevenDaysInDollor,2); ?>
                        </span>
                      </div>
                     </td>
                  </tr>
                  <tr>
                     <td>Last 15 days</td>
                     <td>
                      <div class="cryptocurrency-popover">
                      <?php
                        $fifteenDaysInDollor = 0.00;
                        $fifteenDaysInEth    = 0.00;
                        $fifteenDaysInBtc    = 0.00;
                        if(!empty($stat_fifteenDays_orders)){
                          $fifteenDaysInDollor = $stat_fifteenDays_orders->total_amounts * $stat_fifteenDays_orders->currency_amount_in_dollor;
                          $fifteenDaysInEth    = $stat_fifteenDays_orders->total_amounts * $stat_fifteenDays_orders->currency_amount_in_ethereum;
                          $fifteenDaysInBtc    = $stat_fifteenDays_orders->total_amounts * $stat_fifteenDays_orders->currency_amount_in_bitcoin;
                        }
                      ?>
                        <span class="crypto-spn" role="top" data-placement="top" data-toggle="popover" data-trigger="hover" title="Cryptocurrency" data-content="<i class='cf cf-btc'></i> <?php echo number_format($fifteenDaysInBtc,8); ?> BTH <br> <i class='cf cf-eth'></i> <?php echo number_format($fifteenDaysInEth,8); ?> ETH">
                          <i class="fa fa-dollar"></i><?php echo number_format($fifteenDaysInDollor,2); ?>
                        </span>
                      </div>
                     </td>
                  </tr>
                  <tr>
                     <td>Last 30 days</td>
                     <td>
                      <div class="cryptocurrency-popover">
                      <?php
                        $thirtyDaysInDollor = 0.00;
                        $thirtyDaysInEth    = 0.00;
                        $thirtyDaysInBtc    = 0.00;
                        if(!empty($stat_thirtyDays_orders)){
                          $thirtyDaysInDollor = $stat_thirtyDays_orders->total_amounts * $stat_thirtyDays_orders->currency_amount_in_dollor;
                          $thirtyDaysInEth    = $stat_thirtyDays_orders->total_amounts * $stat_thirtyDays_orders->currency_amount_in_ethereum;
                          $thirtyDaysInBtc    = $stat_thirtyDays_orders->total_amounts * $stat_thirtyDays_orders->currency_amount_in_bitcoin;
                        }
                      ?>
                        <span class="crypto-spn" role="top" data-placement="top" data-toggle="popover" data-trigger="hover" title="Cryptocurrency" data-content="<i class='cf cf-btc'></i> <?php echo number_format($thirtyDaysInBtc,8); ?> BTH <br> <i class='cf cf-eth'></i> <?php echo number_format($thirtyDaysInEth,8); ?> ETH">
                          <i class="fa fa-dollar"></i><?php echo number_format($thirtyDaysInDollor,2); ?>
                        </span>
                      </div>
                     </td>
                  </tr>
                  <tr class="total-block-wrap">
                     <td class="name">Total</td>
                     <td>
                      <div class="cryptocurrency-popover">
                      <?php
                        $allInDollor = 0.00;
                        $allInEth    = 0.00;
                        $allInBtc    = 0.00;
                        if(!empty($stat_all_orders)){
                          $allInDollor = $stat_all_orders->total_amounts * $stat_all_orders->currency_amount_in_dollor;
                          $allInEth    = $stat_all_orders->total_amounts * $stat_all_orders->currency_amount_in_ethereum;
                          $allInBtc    = $stat_all_orders->total_amounts * $stat_all_orders->currency_amount_in_bitcoin;
                        }
                      ?>
                        <span class="crypto-spn" role="top" data-placement="top" data-toggle="popover" data-trigger="hover" title="Cryptocurrency" data-content="<i class='cf cf-btc'></i> <?php echo number_format($allInBtc,8); ?> BTH <br> <i class='cf cf-eth'></i> <?php echo number_format($allInEth,8); ?> ETH">
                          <i class="fa fa-dollar"></i><?php echo number_format($allInDollor,2); ?>
                        </span>
                      </div>
                     </td>
                  </tr>
               </tbody>
            </table>
        </div>
    </div>

    <div class="panel panel-dashboard box">
        <div class="panel-heading"><img src="<?php echo SELLER_THEME_URL; ?>/img/icons/Categories.svg" width="20"> Inventory Products</div>
        <div class="panel-body">
            <table class="table table-hover personal-task tabel-dashboard-section">
               <tbody>
                  <?php 
                    $simpleProduct = typeOfProducts(seller_id(), 1, 'inventory');
                    $variationProduct = typeOfProducts(seller_id(), 2, 'inventory'); 
                  ?>
                  <tr>
                     <td>Simple Products</td>
                     <td><?php echo $simpleProduct; ?></td>
                  </tr>
                  <tr>
                     <td>Variation Products</td>
                     <td><?php echo $variationProduct; ?></td>
                  </tr>
                  <tr class="total-block-wrap">
                     <td class="name">Totals</td>
                     <td class="value"><?php echo $variationProduct+$simpleProduct; ?></td>
                  </tr>
               </tbody>
            </table>
        </div>
    </div>

    <div class="panel panel-dashboard box">
        <div class="panel-heading"><img src="<?php echo SELLER_THEME_URL; ?>/img/icons/Categories.svg" width="20"> Draft Products</div>
        <div class="panel-body">
            <table class="table table-hover personal-task tabel-dashboard-section">
               <tbody>
                  <?php 
                    $simpleProduct = typeOfProducts(seller_id(), 1, 'draft');
                    $variationProduct = typeOfProducts(seller_id(), 2, 'draft'); 
                  ?>
                  <tr>
                     <td>Simple Products</td>
                     <td><?php echo $simpleProduct; ?></td>
                  </tr>
                  <tr>
                     <td>Variation Products</td>
                     <td><?php echo $variationProduct; ?></td>
                  </tr>
                  <tr class="total-block-wrap">
                     <td class="name">Totals</td>
                     <td class="value"><?php echo $variationProduct+$simpleProduct; ?></td>
                  </tr>
               </tbody>
            </table>
        </div>
    </div>
    
  </div>
  <div class="clearfix"></div>
</div>
</div>
<div class="clearfix"></div>

<?php }else{ ?>

<div class="body-container clearfix">
<br>

<div class="col-md-12 clearfix">
  <div class="col-md-3">
    <div class="panel panel-dashboard box">
        <div class="panel-heading"><img src="<?php echo SELLER_THEME_URL; ?>/img/icons/Categories.svg" width="20"> Inventory Products</div>
        <div class="panel-body">
            <table class="table table-hover personal-task tabel-dashboard-section">
               <tbody>
                  <?php 
                    $simpleProduct = typeOfProducts(seller_id(), 1, 'inventory');
                    $variationProduct = typeOfProducts(seller_id(), 2, 'inventory'); 
                  ?>
                  <tr>
                     <td>Simple Products</td>
                     <td><?php echo $simpleProduct; ?></td>
                  </tr>
                  <tr>
                     <td>Variation Products</td>
                     <td><?php echo $variationProduct; ?></td>
                  </tr>
                  <tr class="total-block-wrap">
                     <td class="name">Totals</td>
                     <td class="value"><?php echo $variationProduct+$simpleProduct; ?></td>
                  </tr>
               </tbody>
            </table>
        </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="panel panel-dashboard box">
        <?php if(!empty($support)){ ?>
          <div class="flex-wrapper panel-heading">
            <div class=""><img src="<?php echo SELLER_THEME_URL; ?>/img/icons/support-chat.svg" width="20"> Support</div>
            <div class="view-all-support">
              <a href="<?php echo base_url('seller/support/messages'); ?>" class="text-link">View All</a>
              <span class="badge bg-important"><?php echo count($support); ?></span>
            </div>
          </div>
          <div class="panel-body">
            <div class="dashboard-chat-support" id="scrollbar-design">
              <ul class="chat">
                <?php foreach ($support as $row) { ?>
                <li class="left-chat-section clearfix">
                  <div class="chat-img">
                    <span>J</span>
                  </div>
                  <div class="chat-body clearfix">
                    <div class="header">
                      <strong class="primary-font">
                        <?php  
                            if(!empty($row->reason)){
                              $feedback_subject_status=''; 
                              $feedback_subject_status=feedback_subject_status($row->reason); 
                              echo $feedback_subject_status;
                            }else{
                              echo "Anonymous Subject";
                            } 
                        ?> 
                      </strong> 
                      <small class="pull-right time-date-wrap">
                       <?php if(!empty($row->created)) { echo'<i class="icofont icofont-clock-time"></i> '. date('d M Y,H:i ',strtotime($row->created)); } ?>
                      </small>
                    </div>
                    <div class="chat-content">
                        <?php if(!empty($row->message)){ echo character_limiter($row->message,60); } ?>
                    </div>
                    <div class="reply-chat clearfix">
                      <span class="pull-right"><a href="<?php echo base_url().'seller/support/messages/'.$row->support_id ?>"><i class="icofont icofont-reply-all"></i> Reply</a></span>
                    </div>
                  </div>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
        <?php }else{ ?>
          <div class="panel-body">
              <div class="flex-vertical">
                <div><img src="<?php echo SELLER_THEME_URL; ?>/img/icons/support-chat.svg" width="20"></div>
                <h4><b>No support messages found</b></h4>
              </div>
          </div>
        <?php } ?>
    </div>
  </div>
  <div class="col-md-3">
    <div class="panel panel-dashboard box">
        <div class="panel-heading"><img src="<?php echo SELLER_THEME_URL; ?>/img/icons/Categories.svg" width="20"> Draft Products</div>
        <div class="panel-body">
            <table class="table table-hover personal-task tabel-dashboard-section">
               <tbody>
                  <?php 
                    $simpleProduct = typeOfProducts(seller_id(), 1, 'draft');
                    $variationProduct = typeOfProducts(seller_id(), 2, 'draft'); 
                  ?>
                  <tr>
                     <td>Simple Products</td>
                     <td><?php echo $simpleProduct; ?></td>
                  </tr>
                  <tr>
                     <td>Variation Products</td>
                     <td><?php echo $variationProduct; ?></td>
                  </tr>
                  <tr class="total-block-wrap">
                     <td class="name">Totals</td>
                     <td class="value"><?php echo $variationProduct+$simpleProduct; ?></td>
                  </tr>
               </tbody>
            </table>
        </div>
    </div>
    
  </div>
  <div class="clearfix"></div>
</div>
</div>
<div class="clearfix"></div>
<?php } ?>
