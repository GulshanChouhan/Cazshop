<?php 
  $product_details   = array();
  $getOrderNamePrice = getOrderNamePrice($order_detail_id);
  $order_details     = getData('order_details',array('order_detail_id',$order_detail_id));
  if(!empty($order_details)){
      $product_details   = json_decode($order_details->product_details);
      $userName   = getData('users',array('user_id',$product_details->seller_id));
  } 
?>
<html>
  <head>
  <title><?php echo $title; ?> - <?php echo ucfirst(SITE_NAME); ?></title>
  <link href="<?php echo SELLER_THEME_URL; ?>css/cryptofont.min.css" rel="stylesheet">
</head>
<body>
  <center>
   <img src="<?php echo base_url('assets/frontend/img/logos-Ai.png'); ?>" width="160" align="center" border="0">
  </center>
   <br clear="\&quot;all\&quot;">
   <center><b class="h1">
      Final Details for Order #<?php echo $order_info->order_id; ?>
      </b><br>
      <a href="javascript:void();" onclick="javascript:window.print();">Print this page for your records.</a>
   </center>
   <br>
   <table width="90%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
      <tbody>
         <tr>
            <td>
               <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tbody>
                     <tr>
                        <td valign="top" align="left">
                           <b>
                           Order Placed:
                           </b>
                           <?php echo date('d M Y',strtotime($order_info->created)); ?>
                        </td>
                     </tr>
                     <tr>
                        <td valign="top" align="left">
                           <b>Order number:</b>
                           <?php echo $order_info->order_id; ?>
                        </td>
                     </tr>
                     <tr>
                        <td valign="top" align="left">
                           <b>Order Total:
                           <span style="text-decoration: inherit; white-space: nowrap;">
                             <span class="currencyINR">&nbsp;&nbsp;</span>
                             <?php
                                $price = $getOrderNamePrice['price'];
                                if($price){
                                  if($order_info->currency_type==1){
                                    $totalGross = $price * $order_info->currency_amount_in_ethereum;
                                  }else if($order_info->currency_type==2){
                                    $totalGross = $price * $order_info->currency_amount_in_bitcoin;
                                  }else{
                                    $totalGross = $price * $order_info->currency_amount_in_dollor;
                                  }
                                  echo getCurrencyIcon($order_info->currency_type).''.number_format($totalGross, 8); 
                                }else{
                                  echo "0.00";
                                }  
                             ?>
                           </span></b>
                        </td>
                     </tr>
                  </tbody>
               </table>
               <br>
               <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#000000" align="center">
                  <tbody>
                     <tr bgcolor="#000000">
                        <td>
                           <table width="100%" border="0" cellspacing="3" cellpadding="0" align="center" bgcolor="#000000">
                              <tbody>
                                 <tr bgcolor="#ffffff">
                                    <td valign="top" colspan="2">
                                       <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                          <tbody>
                                             <tr bgcolor="#ffffff">
                                                <td>
                                                   <b class="sans">
                                                      <center>
                                                         Item Information
                                                      </center>
                                                   </b>
                                                </td>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td bgcolor="#ffffff" valign="top" colspan="2">
                                       <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tbody>
                                             <tr valign="top">
                                                <td width="100%">
                                                   <table border="0" cellspacing="0" cellpadding="2" align="right">
                                                      <tbody>
                                                         <tr valign="top">
                                                            <td align="right">
                                                               &nbsp;
                                                            </td>
                                                         </tr>
                                                      </tbody>
                                                   </table>
                                                   <table border="0" cellspacing="2" cellpadding="0" width="100%">
                                                      <tbody>
                                                         <tr valign="top">
                                                            <td valign="top">
                                                               <b>Items Ordered</b>
                                                            </td>
                                                            <td align="right" valign="top">
                                                               <b>Price</b>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <input type="hidden" name="onpimuinsronqw" value="1">
                                                            <td colspan="1" valign="top">
                                                               1
                                                               of:
                                                               <i><?php echo ucfirst($product_details->title); ?></i><br>
                                                               <span class="tiny">
                                                               Sold by: <?php if(!empty($userName->user_name)) echo $userName->user_name; else echo "-"; ?>
                                                               <br>
                                                               <br>
                                                               <br>
                                                               Seller SKU:
                                                               <?php echo $product_details->seller_SKU; ?>
                                                               </span>
                                                            </td>
                                                            <td align="right" valign="top" colspan="2">
                                                               <span style="text-decoration: inherit; white-space: nowrap;">
                                                                <span class="currencyINR">&nbsp;&nbsp;</span>
                                                                <?php
                                                                  $price = $getOrderNamePrice['price'];
                                                                  if($price){
                                                                    if($order_info->currency_type==1){
                                                                      $totalGross = $price * $order_info->currency_amount_in_ethereum;
                                                                    }else if($order_info->currency_type==2){
                                                                      $totalGross = $price * $order_info->currency_amount_in_bitcoin;
                                                                    }else{
                                                                      $totalGross = $price * $order_info->currency_amount_in_dollor;
                                                                    }
                                                                    echo getCurrencyIcon($order_info->currency_type).''.number_format($totalGross, 8); 
                                                                  }else{
                                                                    echo "0.00";
                                                                  }  
                                                               ?>
                                                               </span><br>
                                                            </td>
                                                         </tr>
                                                      </tbody>
                                                   </table>
                                                   <br>
                                                </td>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td bgcolor="#ffffff" valign="top" colspan="2">
                                       <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tbody>
                                             <tr>
                                                <td>
                                                   <b>
                                                   Delivery Address:
                                                   </b>
                                                   <br>
                                                   <?php
                                                     $shipping_address = json_decode($order_info->shipping_address);
                                                     if(!empty($shipping_address)){

                                                         $country = getData('countries',array('id',$shipping_address->country))->name;
                                                         $state = getData('states',array('id',$shipping_address->state))->name;
                                                         $city = getData('cities',array('id',$shipping_address->city))->name;
                                                     }
                                                   ?>
                                                   <div class="displayAddressDiv">
                                                      <ul class="displayAddressUL">
                                                         <li class="displayAddressLI displayAddressFullName"><?php echo ucwords($shipping_address->first_name.' '.$shipping_address->last_name); ?></li>
                                                         <li class="displayAddressLI displayAddressAddressLine2"><?php echo $shipping_address->address; ?></li>
                                                         <li class="displayAddressLI displayAddressCityStateOrRegionPostalCode"><?php echo $city.', '.$state.' - '.$shipping_address->zip_code; ?></li>
                                                         <li class="displayAddressLI displayAddressCountryName"><?php echo $country; ?></li>
                                                      </ul>
                                                   </div>
                                                   <br><b>
                                                   Delivery Option:
                                                   </b>
                                                   <br>
                                                   FREE Delivery on eligible orders
                                                   <br>
                                                </td>
                                                <td align="right">
                                                   <table border="0" cellpadding="0" cellspacing="1">
                                                      <tbody>
                                                         <tr valign="top">
                                                            <td nowrap="nowrap" align="right">Item(s) Subtotal:</td>
                                                            <td nowrap="nowrap" align="right"><span style="text-decoration: inherit; white-space: nowrap;"><span class="currencyINR">&nbsp;&nbsp;</span><span class="currencyINRFallback" style="display:none">Rs. </span>
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
                                                            </span></td>
                                                         </tr>
                                                         <tr valign="top">
                                                            <td nowrap="nowrap" align="right">Shipping:</td>
                                                            <td nowrap="nowrap" align="right"><span style="text-decoration: inherit; white-space: nowrap;"><span class="currencyINR">&nbsp;&nbsp;</span><span class="currencyINRFallback" style="display:none">Rs. </span>
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
                                                                echo "-";
                                                              }  
                                                            ?>
                                                            </span></td>
                                                         </tr>
                                                         <tr valign="top">
                                                            <td nowrap="nowrap" align="right">&nbsp;</td>
                                                            <td nowrap="nowrap" align="right">-----</td>
                                                         </tr>
                                                         <tr valign="top">
                                                            <td nowrap="nowrap" align="right">Total:</td>
                                                            <td nowrap="nowrap" align="right"><span style="text-decoration: inherit; white-space: nowrap;"><span class="currencyINR">&nbsp;&nbsp;</span><span class="currencyINRFallback" style="display:none">Rs. </span>
                                                            <?php
                                                              $price = $getOrderNamePrice['price'];
                                                              if($price){
                                                                if($order_info->currency_type==1){
                                                                  $totalGross = $price * $order_info->currency_amount_in_ethereum;
                                                                }else if($order_info->currency_type==2){
                                                                  $totalGross = $price * $order_info->currency_amount_in_bitcoin;
                                                                }else{
                                                                  $totalGross = $price * $order_info->currency_amount_in_dollor;
                                                                }
                                                                echo getCurrencyIcon($order_info->currency_type).''.number_format($totalGross, 8); 
                                                              }else{
                                                                echo "0.00";
                                                              }  
                                                            ?>
                                                            </span></td>
                                                         </tr>
                                                         <!-- <tr valign="top">
                                                            <td nowrap="nowrap" align="right">Promotion Applied:</td>
                                                            <td nowrap="nowrap" align="right">-<span style="text-decoration: inherit; white-space: nowrap;"><span class="currencyINR">&nbsp;&nbsp;</span><span class="currencyINRFallback" style="display:none">Rs. </span>None</span></td>
                                                         </tr> -->
                                                         <tr valign="top">
                                                            <td nowrap="nowrap" align="right">&nbsp;</td>
                                                            <td nowrap="nowrap" align="right">-----</td>
                                                         </tr>
                                                         <tr valign="top">
                                                            <td nowrap="nowrap" align="right"><b>Total for this Delivery:</b></td>
                                                            <td nowrap="nowrap" align="right"><b><span style="text-decoration: inherit; white-space: nowrap;"><span class="currencyINR">&nbsp;&nbsp;</span><span class="currencyINRFallback" style="display:none">Rs. </span>
                                                            <?php
                                                              $price = $getOrderNamePrice['price'];
                                                              if($price){
                                                                if($order_info->currency_type==1){
                                                                  $totalGross = $price * $order_info->currency_amount_in_ethereum;
                                                                }else if($order_info->currency_type==2){
                                                                  $totalGross = $price * $order_info->currency_amount_in_bitcoin;
                                                                }else{
                                                                  $totalGross = $price * $order_info->currency_amount_in_dollor;
                                                                }
                                                                echo getCurrencyIcon($order_info->currency_type).''.number_format($totalGross, 8); 
                                                              }else{
                                                                echo "0.00";
                                                              }  
                                                            ?>
                                                            </span></b></td>
                                                         </tr>
                                                         <tr valign="top">
                                                            <td nowrap="nowrap" align="right">&nbsp;</td>
                                                            <td nowrap="nowrap" align="right">-----</td>
                                                         </tr>
                                                      </tbody>
                                                   </table>
                                                </td>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                  </tbody>
               </table>
               <br>
               <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#000000" align="center">
                  <tbody>
                     <tr bgcolor="#000000">
                        <td>
                           <table width="100%" border="0" cellspacing="3" cellpadding="0" align="center" bgcolor="#000000">
                              <tbody>
                                 <tr bgcolor="#ffffff">
                                    <td valign="top" colspan="2">
                                       <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                          <tbody>
                                             <tr bgcolor="#ffffff">
                                                <td>
                                                   <b class="sans">
                                                      <center>Payment Information</center>
                                                   </b>
                                                </td>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td bgcolor="#ffffff" valign="top" colspan="2">
                                       <table width="100%" border="0" cellspacing="0" cellpadding="2">
                                          <tbody>
                                             <tr valign="top">
                                                <td width="100%">
                                                   <table border="0" cellspacing="0" cellpadding="2" align="right">
                                                      <tbody>
                                                         <tr valign="top">
                                                            <td align="right">
                                                               <table border="0" cellpadding="0" cellspacing="1">
                                                                  <tbody>
                                                                     <tr valign="top">
                                                                        <td nowrap="nowrap" align="right">Item(s) Subtotal:</td>
                                                                        <td nowrap="nowrap" align="right"><span style="text-decoration: inherit; white-space: nowrap;"><span class="currencyINR">&nbsp;&nbsp;</span><span class="currencyINRFallback" style="display:none">Rs. </span>
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
                                                                        </span></td>
                                                                     </tr>
                                                                     <tr valign="top">
                                                                        <td nowrap="nowrap" align="right">Shipping:</td>
                                                                        <td nowrap="nowrap" align="right"><span style="text-decoration: inherit; white-space: nowrap;"><span class="currencyINR">&nbsp;&nbsp;</span><span class="currencyINRFallback" style="display:none">Rs. </span>
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
                                                                                echo "-";
                                                                              }  
                                                                           ?>
                                                                        </span></td>
                                                                     </tr>
                                                                     <tr valign="top">
                                                                        <td nowrap="nowrap" align="right">&nbsp;</td>
                                                                        <td nowrap="nowrap" align="right">-----</td>
                                                                     </tr>
                                                                     <tr valign="top">
                                                                        <td nowrap="nowrap" align="right">Total:</td>
                                                                        <td nowrap="nowrap" align="right"><span style="text-decoration: inherit; white-space: nowrap;"><span class="currencyINR">&nbsp;&nbsp;</span><span class="currencyINRFallback" style="display:none">Rs. </span>
                                                                           <?php
                                                                              $price = $getOrderNamePrice['price'];
                                                                              if($price){
                                                                                if($order_info->currency_type==1){
                                                                                  $totalGross = $price * $order_info->currency_amount_in_ethereum;
                                                                                }else if($order_info->currency_type==2){
                                                                                  $totalGross = $price * $order_info->currency_amount_in_bitcoin;
                                                                                }else{
                                                                                  $totalGross = $price * $order_info->currency_amount_in_dollor;
                                                                                }
                                                                                echo getCurrencyIcon($order_info->currency_type).''.number_format($totalGross, 8); 
                                                                              }else{
                                                                                echo "0.00";
                                                                              }  
                                                                           ?>
                                                                        </span></td>
                                                                     </tr>
                                                                     <!-- <tr valign="top">
                                                                        <td nowrap="nowrap" align="right">Promotion Applied:</td>
                                                                        <td nowrap="nowrap" align="right">-<span style="text-decoration: inherit; white-space: nowrap;"><span class="currencyINR">&nbsp;&nbsp;</span><span class="currencyINRFallback" style="display:none">Rs. </span>
                                                                         None
                                                                        </span></td>
                                                                     </tr> -->
                                                                     <tr valign="top">
                                                                        <td nowrap="nowrap" align="right">&nbsp;</td>
                                                                        <td nowrap="nowrap" align="right">-----</td>
                                                                     </tr>
                                                                     <tr valign="top">
                                                                        <td nowrap="nowrap" align="right"><b>Grand Total:</b></td>
                                                                        <td nowrap="nowrap" align="right"><b><span style="text-decoration: inherit; white-space: nowrap;"><span class="currencyINR">&nbsp;&nbsp;</span><span class="currencyINRFallback" style="display:none">Rs. </span>
                                                                           <?php
                                                                              $price = $getOrderNamePrice['price'];
                                                                              if($price){
                                                                                if($order_info->currency_type==1){
                                                                                  $totalGross = $price * $order_info->currency_amount_in_ethereum;
                                                                                }else if($order_info->currency_type==2){
                                                                                  $totalGross = $price * $order_info->currency_amount_in_bitcoin;
                                                                                }else{
                                                                                  $totalGross = $price * $order_info->currency_amount_in_dollor;
                                                                                }
                                                                                echo getCurrencyIcon($order_info->currency_type).''.number_format($totalGross, 8); 
                                                                              }else{
                                                                                echo "0.00";
                                                                              }  
                                                                           ?>
                                                                        </span></b></td>
                                                                     </tr>
                                                                  </tbody>
                                                               </table>
                                                            </td>
                                                         </tr>
                                                      </tbody>
                                                   </table>
                                                   <b>Payment Method: </b>
                                                   <br>
                                                   <?php echo ucfirst(getCurrency($order_info->currency_type)); ?>
                                                   <!-- <nobr> | Last digits: 0956</nobr> -->
                                                   <br>
                                                   <br>
                                                   <b>Billing Address:</b>
                                                   <div class="displayAddressDiv">
                                                      <ul class="displayAddressUL">
                                                         <li class="displayAddressLI displayAddressFullName"><?php echo ucwords($shipping_address->first_name.' '.$shipping_address->last_name); ?></li>
                                                         <li class="displayAddressLI displayAddressAddressLine2"><?php echo $shipping_address->address; ?></li>
                                                         <li class="displayAddressLI displayAddressCityStateOrRegionPostalCode"><?php echo $city.', '.$state.' - '.$shipping_address->zip_code; ?></li>
                                                         <li class="displayAddressLI displayAddressCountryName"><?php echo $country; ?></li>
                                                      </ul>
                                                   </div>
                                                </td>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </td>
                                 </tr>
                              </tbody>
                           </table>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </td>
         </tr>
      </tbody>
   </table>
   <center>
      <p>To view the status of your order, return to <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Order Listing</a>.</p>
      <!-- <p><b>Please note:</b> this is not a GST invoice.</p> -->
   </center>
   <br>
   <table align="center" width="100%">
      <tbody>
         <tr align="center">
            <td colspan="2">
               <font size="-2">
               <a target="_blank" href="<?php echo base_url("seller/page/terms-and-condition"); ?>" rel="nofollow">Conditions of Use &amp; Sale</a>&nbsp;|&nbsp;
               <a target="_blank" href="<?php echo base_url("seller/page/privacy-policy"); ?>" rel="nofollow">Privacy Notice</a>&nbsp;&nbsp;© <?php echo date('Y'); ?>, <?php echo ucfirst(SITE_NAME_WITH_EXTENTION); ?>
            </td>
         </tr>
      </tbody>
   </table>
   <div></div>
</body>
</html>
<style type="text/css">
     BODY { background-color: #FFFFFF; font-family: verdana,arial,helvetica,sans-serif; font-size: small; }
     TD { font-family: verdana,arial,helvetica,sans-serif; font-size: small; }
     TH { font-family: verdana,arial,helvetica,sans-serif; font-size: small; }
     .h1 { font-family: verdana,arial,helvetica,sans-serif; color: #E47911; font-size: medium; }
     .h3color { font-family: verdana,arial,helvetica,sans-serif; color: #E47911; font-size: small; }
     .tiny { font-family: verdana,arial,helvetica,sans-serif; font-size: x-small; }
     .tinyprice { font-family: verdana,arial,helvetica,sans-serif; color: #990000; font-size: x-small; }
     .highlight { font-family: verdana,arial,helvetica,sans-serif; color: #990000; font-size: small; }

     .displayAddressDiv .displayAddressUL {
          list-style-type: none;
          padding: 0%;
          margin-left: 0%;
          margin-top: 0%;
          margin-bottom: 0%;
          text-align: left;
          vertical-align: top;
          }
          .displayAddressDiv .displayAddressLI {
          width: 100%;
          }
          .displayAddressDiv {
          vertical-align: top;
          padding-bottom: 0.5em;
          }
          .displayAddressDiv h2 {
          font-size: 1em;
          display: inline;
          }
          #chooseAddressDiv table {
          width: 100%;
          }
          #chooseAddressDiv td {
          vertical-align: top;
          }
          .enterAddressFieldLabel {
          text-align: right;
          }
          .enterAddressFieldICAMLabel {
          vertical-align: middle;
          max-width: 200px;
          }
          .enterAddressFieldICAMLong {
          width: 386px;
          }
          .enterAddressFieldICAMShort {
          width: 200px;
          }
          .enterAddressFormTable td {
          padding: 2px;
          }
          #enterAddressFormDiv input {
          text-align: left;
          }
          #enterAddressFormDiv select {
          text-align: left;
          overflow: auto;
          }
          div#enterAddressFormDiv {
          text-align: left;
          }
          .enterAddressFieldError {
          display: block;
          text-align: left;
          font-size: .8em;
          color: red;
          clear: both;
          }
          .enterAddressFieldWarning {
          display: block;
          text-align: left;
          font-size: .8em;
          color: #e77600;
          clear: both;
          }
          #enterAddressFormDiv .enterAddressFieldSeparatorDiv {
          clear: both;
          }
          .enterAddressFormInputError {
          border: 1px solid #990000;
          }
          #chooseAddressDiv .chooseAddressEditThisAddressButton {
          margin : 0em .5em;
          }
          #chooseAddressDiv .chooseAddressDeleteThisAddressButton {
          margin : 0em .5em;
          }
          #chooseAddressDiv .chooseAddressChooseThisAddressRadioButton {
          vertical-align: -4em;
          }
          #chooseAddressDiv .chooseAddressChooseThisAddressRadioButtonDiv {
          float : left;
          height: 100%;
          }
          #chooseAddressDiv td {
          width: 33%;
          }
          #chooseAddressDiv .chooseAddressSeparator {
          margin-top : 1em;
          }
          #deleteAddressDiv {
          color: #a00000;
          padding-left: 3em;
          }
          .enterDeliveryPrefsLabel {
          text-align: right;
          vertical-align: middle;
          }
          #deliveryPreferences {
          color: #E47911;
          text-decoration: none;
          }
          #learnMoreLink a {
          color: #004B91;
          text-decoration: none;
          }
          #learnMoreLink a:hover, #learnMoreLink a:active, #learnMoreLink a:hover span, #learnMoreLink a:active span {
          color: #E47911;
          text-decoration: underline;
          }
          #whatsThisLink a {
          color: #004B91;
          text-decoration: none;
          }
          #whatsThisLink a:hover, #whatsThisLink a:active, #whatsThisLink a:hover span, #whatsThisLink a:active span {
          color: #E47911;
          text-decoration: underline;
          }
  </style>