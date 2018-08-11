<div class="">
   <header class="panel-heading">
      Hello <?php echo superadmin_name(); ?>, Welcome to the admin section of  <?php echo SITE_NAME; ?>  <i class="icon-smile"></i>
   </header>
</div>
<div class="panel-body">
   <!--========================ORDER SECTION===================-->
   <div class="col-md-8">
      <div class="adv-table" id="tab1">
         <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
            <thead class="thead_color">
               <tr>
                  <th class="jv no_sort" width="3%">
                     #
                  </th>
                  <th width="8%">Order ID</th>
                  <th width="10%">Buyer Information</th>
                  <th width="14%">Grand Total</th>
                  <th width="8%">Status</th>
                  <th width="10%">Order Date</th>
               </tr>
            </thead>
            <tbody>
               <?php
                  if(!empty($orders)){
                  $i=0; 
                  foreach($orders as $row){
                     $shipping_address = json_decode($row->shipping_address);
                     $product_details  = json_decode($row->product_details);
                  
                     if(!empty($shipping_address)){
                       $country = getData('countries',array('id',$shipping_address->country))->name;
                       $state = getData('states',array('id',$shipping_address->state))->name;
                       $city = getData('cities',array('id',$shipping_address->city))->name;
                     }
                  $i++;
                  ?>
               <tr>
                  <td>
                     &nbsp;<?php echo $i.".";?>
                  </td>
                  <td>
                     <?php echo "<a href='".base_url('backend/orders/order_details/'.base64_encode($row->order_detail_id))."'>".$row->order_id."</a>"; ?>
                  </td>
                  <td>
                     <span><a href="javascript:void(0)" class="link-text" data-container="body" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="<?php echo $shipping_address->address.', '.$city.', '.$state.', '.$country.' - '.$shipping_address->zip_code; ?>"><?php echo ucwords($shipping_address->first_name.' '.$shipping_address->last_name); ?></a></span><br>
                     <span><?php echo $shipping_address->email_id; ?></span><br>
                     <span><?php echo '+'.$shipping_address->country_code.' '.$shipping_address->phone_no; ?></span>
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
                     <div class="btn-group">
                        <button data-toggle="dropdown" type="button" class="btn btn-<?php if(!empty($row->order_status)) echo orderStatuscls($row->order_status); else echo "primary"; ?> btn-xs dropdown-toggle">
                        <?php
                           $order_status = orderStatusName($row->order_status);
                           if($order_status) echo $order_status; else echo "-";
                           ?>
                        </button>
                     </div>
                  </td>
                  <td><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo date('d M Y',strtotime($row->created)); ?>
                  </td>
               </tr>
               <?php } ?>
               <?php }else{ ?>
               <tr>
                  <th colspan="10">
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
   </div>
   <div class="col-md-4">
      <div class="report-section">
         <!--daily report-->
         <div class="">
            <div class="info-box info-warning">
               <span class="info-box-icon"><i class="fa fa-usd"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Today<span class="pull-right" style="font-size: 12px">- 
                  <?php 
                     if (!empty($stat_today_orders->total_orders))
                       echo $stat_today_orders->total_orders;
                     else
                       echo "0";
                  ?> orders
                  </span></span>
                  <div class="info-box-number">
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
                  </div>
                  <div class="progress">
                     <div class="progress-bar" style="width: 50%"></div>
                  </div>
               </div>
               <!-- /.info-box-content -->
            </div>
         </div>
         <!--Weekly report-->
         <div class="">
            <div class="info-box info-success">
               <span class="info-box-icon"><i class="fa fa-usd"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Last 7 Days
                  <span class="pull-right" style="font-size: 12px">- <?php 
                     if (!empty($stat_sevenDays_orders->total_orders))
                       echo $stat_sevenDays_orders->total_orders;
                     else
                       echo "0";
                     ?> orders
                  </span></span>
                  <div class="info-box-number">
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
                  </div>
                  <div class="progress">
                     <div class="progress-bar" style="width: 50%"></div>
                  </div>
               </div>
               <!-- /.info-box-content -->
            </div>
         </div>
         <!--Monthly report-->
         <div class="">
            <div class="info-box info-danger">
               <span class="info-box-icon"><i class="fa fa-usd"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Last 30 Days 
                  <span class="pull-right" style="font-size: 12px">- <?php 
                     if (!empty($stat_thirtyDays_orders->total_orders))
                       echo $stat_thirtyDays_orders->total_orders;
                     else
                       echo "0";
                     ?> orders
                  </span></span>
                  <div class="info-box-number">
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
                  </div>
                  <div class="progress">
                     <div class="progress-bar" style="width: 50%"></div>
                  </div>
               </div>
               <!-- /.info-box-content -->
            </div>
         </div>
         <!--Yearly report-->
         <div class="">
            <div class="info-box info-info">
               <span class="info-box-icon"><i class="fa fa-usd"></i></span>
               <div class="info-box-content">
                  <span class="info-box-text">Total <span class="pull-right" style="font-size: 12px">- <?php 
                     if (!empty($stat_all_orders->total_orders))
                       echo $stat_all_orders->total_orders;
                     else
                       echo "0";
                     ?> orders</span></span>
                  <div class="info-box-number">
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
                  </div>
                  <div class="progress">
                     <div class="progress-bar" style="width: 50%"></div>
                  </div>
               </div>
               <!-- /.info-box-content -->
            </div>
         </div>
      </div>
   </div>
   <!--========================SUPPORT SECTION===================-->
   
 <div class="col-md-6">
      <div class="board-block board-block-primary  direct-chat direct-chat-primary">
         <div class="block-header with-border clearfix">
            <h3 class="box-title">Support</h3>
            <a target="_blank" href="<?php echo base_url(); ?>backend/support/user_contactus" class="badge block-badge pull-right block-toggle-btn">View All</a>
         </div>
         <!-- /.box-header -->
         <div class="panel in" id="collapseExample13">
            <!-- Conversations are loaded here -->
            <div class="direct-chat-messages">
               <div class="chatbox-body">
                  <!-- Message. Default to the left -->
                  <?php if(!empty($contactus)){ 
                     foreach($contactus as $row){ ?>
                  <div class="direct-chat-msg">
                     <div class="direct-chat-info clearfix">
                        <a target="_blank" href="<?php echo base_url(); ?>backend/superadmin/user_view/0"><span class="direct-chat-name pull-left"><?php 
                                 if(!empty($row->firstname)) { 
                                    echo ucfirst($row->firstname);
                                 }
                              ?></span></a>
                        <span class="direct-chat-timestamp pull-right"><?php echo date('d M Y,H:i ',strtotime($row->created)); ?></span>
                     </div>
                     <!-- /.direct-chat-info -->
                     <img class="direct-chat-img" src="<?php echo base_url(); ?>assets/backend/admin/images/support-user.png" alt="message user image"><!-- /.direct-chat-img -->
                     <div class="direct-chat-text">
                        <?php 
                           $feedback_subject='';
                           $feedback_subject = feedback_subject_status($row->reason);
                           if(!empty($feedback_subject)){
                              echo $feedback_subject."<br>";
                           }
                        ?>
                        <?php if(!empty($row->message)) echo word_limiter($row->message, 7); ?>
                     </div>
                     <!-- /.direct-chat-text -->
                     <!--chat reply section-->
                     <div class="chat-reply clearfix">
                        <a target="_blank" href="<?php echo base_url().'backend/support/user_contactus_reply/'.$row->support_id;?>"><i class="fa fa-reply-all"></i> Reply</a>
                     </div>
                  </div>
                  <?php } }else{ ?>
                  <div align="center"><b>No support messages found.</b></div>
                  <?php } ?>
                  <!-- /.direct-chat-msg -->
               </div>
               <div class="clearfix"></div>
            </div>
            <!--/.direct-chat-messages-->
         </div>
         <!-- /.box-body -->
      </div>
   </div>

   <div class="adv-table">
      <div class="col-lg-3">
         
         <div class="board-block board-block-warning">
            <div class="block-header">
               <a target="_blank" href="<?php echo base_url(); ?>backend/user/index/2">
                  <h3 class="chart-tittle">
                     All Customers 
                  </h3>
               </a>
               <span class=" pull-right badge block-badge"><?php echo $active_customers->total_rows + $deactive_customers->total_rows;  ?></span>
            </div>
            <section class="panel in" id="collapseExample2">
               <table class="table table-hover personal-task">
                  <tbody>
                     <tr>
                        <td>
                           <i class="fa fa-thumbs-up"></i>
                        </td>
                        <td><a target="_blank" href="<?php echo base_url(); ?>backend/user/index/2?user_name=&email=&country_code=&mobile=&status=1">Active Customers</a></td>
                        <td><?php echo $active_customers->total_rows;  ?></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="icon-thumbs-down"></i>
                        </td>
                        <td><a target="_blank" href="<?php echo base_url(); ?>backend/user/index/2?user_name=&email=&country_code=&mobile=&status=2">Inactive Customers</a></td>
                        <td><?php echo $deactive_customers->total_rows;  ?></td>
                     </tr>
                  </tbody>
               </table>
            </section>
         </div>

         <div class="board-block board-block-warning">
            <div class="block-header">
               <a target="_blank" href="<?php echo base_url(); ?>backend/products/index">
                  <h3 class="chart-tittle">
                     All Products 
                  </h3>
               </a>
               <?php 
                     $simpleProduct = typeOfProducts('',1, 'inventory');
                     $variationProduct = typeOfProducts('', 2, 'inventory'); 
                    
                  ?>
               <span class=" pull-right badge block-badge"><?php echo $variationProduct+$simpleProduct; ?></span>
            </div>
            <section class="panel in" id="collapseExample2">
               <table class="table table-hover personal-task">
                  <tbody>
                     <tr>
                        <td>
                           <i class="fa fa-thumbs-up"></i>
                        </td>
                        <td><a target="_blank" href="<?php echo base_url('backend/products/index?product_type=1'); ?>">Single Products</a></td>
                        <td><?php echo $simpleProduct; ?></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="icon-thumbs-down"></i>
                        </td>
                        <td><a target="_blank" href="<?php echo base_url('backend/products/index?product_type=2'); ?>">Variation Products</a></td>
                        <td><?php echo $variationProduct; ?></td>
                     </tr>
                  </tbody>
               </table>
            </section>
         </div>

      </div>
      <div class="col-lg-3">
         
         <div class="board-block board-block-primary">
            <div class="block-header">
               <a target="_blank" href="<?php echo base_url(); ?>backend/user/index/1">
                  <h3 class="chart-tittle">
                     <!-- <i class="icon-sitemap"></i> --> All Sellers
                  </h3>
               </a>
               <span class="badge block-badge pull-right"><?php echo $active_sellers->total_rows + $deactive_sellers->total_rows;  ?></span>
            </div>
            <section class="panel in" id="collapseExample">
               <table class="table table-hover personal-task">
                  <tbody>
                     <tr>
                        <td>
                           <i class="fa fa-thumbs-up"></i>
                        </td>
                        <td><a target="_blank" href="<?php echo base_url(); ?>backend/user/index/1?user_name=&email=&country_code=&mobile=&status=1">Active Sellers</a></td>
                        <td><?php echo $active_sellers->total_rows;  ?></td>
                     </tr>
                     <tr>
                        <td>
                           <i class="icon-thumbs-down"></i>
                        </td>
                        <td><a target="_blank" href="<?php echo base_url(); ?>backend/user/index/1?user_name=&email=&country_code=&mobile=&status=2">Inactive Sellers</a></td>
                        <td><?php echo $deactive_sellers->total_rows;  ?></td>
                     </tr>
                  </tbody>
               </table>
            </section>
         </div>

         <div class="board-block board-block-primary">
            <div class="block-header">
               <a target="_blank" href="<?php echo base_url(); ?>backend/orders/index">
                  <h3 class="chart-tittle">
                     <!-- <i class="icon-sitemap"></i> --> Manage Orders
                  </h3>
               </a>
              <span class="badge block-badge pull-right"><?php echo $total_order;  ?></span>
            </div>
            <section class="panel in" id="collapseExample">
               <table class="table table-hover personal-task">
                  <tbody>
                     <?php 
                         $orderStatus = orderStatus(); 
                         foreach ($orderStatus as $key => $value){
                         $link = base_url('backend/orders/index/'.$key);
                         $orderTotal = orderCount_with_status_admin($key);
                     ?>
                     <tr>
                        <td>
                           <i class="fa fa-thumbs-up"></i>
                        </td>
                        <td><a target="_blank" href="<?php echo $link; ?>"><?php echo $value; ?></a></td>
                        <td><?php echo $orderTotal; ?></td>
                     </tr>
                     <?php }
                     ?>
                  </tbody>
               </table>
            </section>
         </div>

      </div>
      <div class="clearfix"></div>
   </div>
   <div class="clearfix"></div>
   <div class="col-md-6">
      <div class="board-block board-block-danger">
         <div class="block-header">
            <h3 class="chart-tittle">
               Content Managment 
            </h3>
         </div>
         <section class="panel in" id="collapseExample26">
            <div style="min-height:280px;">
               <div class="content-manager">
                  <ul>
                     <li><a target="_blank" href="<?php echo base_url(); ?>backend/slider/sliders"><i class="fa fa-file-text-o"></i>Home Sliders</a></li>
                     <li><a target="_blank" href="<?php echo base_url(); ?>backend/pages/index"><i class="fa fa-file"></i>Static Pages</a></li>
                     <li><a target="_blank" href="<?php echo base_url(); ?>backend/pages/faq"><i class="fa fa-question"></i>List Of FAQs</a></li>
                     <li><a target="_blank" href="<?php echo base_url(); ?>backend/pages/faq_category"><i class="fa fa-sitemap"></i>FAQs Categories</a></li>
                     <li><a target="_blank" href="<?php echo base_url(); ?>backend/email_template/email_templates"><i class="icon-envelope"></i>Email Templates</a></li>
                     <li><a target="_blank" href="<?php echo base_url(); ?>backend/settings"><i class="fa fa-cogs"></i>Setting</a></li>
                  </ul>
               </div>
            </div>
         </section>
      </div>
   </div>


   <div class="col-md-6">
      <div class="board-block board-block-danger">
         <div class="block-header">
            <h3 class="chart-tittle">
               Other Sections 
            </h3>
         </div>
         <section class="panel in" id="collapseExample26">
            <div style="min-height:280px;">
               <div class="content-manager">
                  <ul>
                     <li><a target="_blank" href="<?php echo base_url(); ?>backend/category/index"><i class="fa fa-sitemap"></i>Product Categories</a></li>
                     <li><a target="_blank" href="<?php echo base_url(); ?>backend/attribute/index"><i class="fa fa-sun-o"></i>List Of Atrributes</a></li>
                     <li><a target="_blank" href="<?php echo base_url(); ?>backend/products/variation_themes"><i class="fa fa-upload"></i>Variation Themes</a></li>
                     <li><a target="_blank" href="<?php echo base_url(); ?>backend/category/brands"><i class="fa fa-dribbble"></i>Manage Brands</a></li>
                     <li><a target="_blank" href="<?php echo base_url(); ?>backend/products/index"><i class="fa fa-cubes"></i>Manage Products</a></li>
                     <li><a target="_blank" href="<?php echo base_url(); ?>backend/fee/index"><i class="fa fa-money"></i>Fee Preview</a></li>
                  </ul>
               </div>
            </div>
         </section>
      </div>
   </div>

</div>
<div class="panel-body"></div>