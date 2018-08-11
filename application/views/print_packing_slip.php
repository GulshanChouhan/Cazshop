<!DOCTYPE html>
<html>
<head>
<title><?php echo $order_info->order_id; ?> - <?php echo $title; ?></title>
<link href="<?php echo SELLER_THEME_URL; ?>css/cryptofont.min.css" rel="stylesheet">
<style type="text/css">
   BODY { background-color: #FFFFFF; font-family: verdana,arial,helvetica,sans-serif; font-size: 14px; }
   TD { font-family: verdana,arial,helvetica,sans-serif; font-size: 14px; }
   TH { font-family: verdana,arial,helvetica,sans-serif; font-size: 14px; }
   .main_table_wrapper {
      width: 950px;
   }
</style>
</head>
<body>

<?php 
   $getOrderNamePrice = getOrderNamePrice($order_detail_id);
   $seller_info = getRow('business_info',array('seller_id'=>$order_info->seller_id));
   $product_details = json_decode($order_info->product_details);
?>
<table id="page_break" class="main_table_wrapper" style="margin:0 auto;">
   <tbody>
      <tr>
         <td id="main_wrapper">
            <table class="inner_table hgt77" width="100%" id="first_page">
               <tbody>
                  <tr>
                     <td align="left" width="40%">
                        <img src="<?php echo base_url(); ?>assets/frontend/img/logos-Ai.png" width="">
                     </td>
                     <td width="10%">&nbsp;</td>
                     <td align="right" width="50%">
                        <img src="<?php echo base_url(); ?>assets/uploads/frontend/barcode_images/<?php echo $order_info->order_id.".jpg"; ?>" style="width: auto;height: 60px; float:right;">
                        <!-- <img src="/assets/barcode_images/V359223R.jpg" style="width: auto;height: 60px; float:left;"> --> 
                     </td>
                  </tr>
                  <tr>
                     <td colspan="4" height="3px" bgcolor="#000" style="background-color:#000;-webkit-print-color-adjust:exact;"></td>
                  </tr>
               </tbody>
            </table>
            <table class="inner_table hgt259" width="100%" cellpadding="" id="">
               <tbody>
                  <tr>
                     <td width="40%">
                        <table width="100%">
                           <tbody>
                              <tr>
                                 <td width="60%" style="font-size:13px;padding-right: 2px;color: #000000;">
                                    <div style="color: #666666;font-size: 15px;padding-bottom:0px;font-weight: 600;">STORE INFO</div>
                                    <?php if($seller_info->store_name) echo ucwords($seller_info->store_name); ?><br>
                                    Store #: <?php if($order_info->seller_id) echo $order_info->seller_id; ?>
                                 </td>
                                 <td width="40%" valign="bottom" align="left" color="#000" style="font-size:12px;color: #000000;padding-left: 10px;">
                                    <br>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                     <td width="60%">
                        <table class="inner_table" width="100%" style=" border-collapse: collapse; font-size:13px;" cellpadding="5">
                           <tbody>
                              <tr bgcolor="#f3f3f3" style="font-size:13px; font-weight:bold; margin-top:15px;">
                                 <td width="33.33%" style="border-left: 2px solid #D2D3D5;border-top: 2px solid #D2D3D5; border-bottom: 2px solid #D2D3D5; border-right: 2px solid #D2D3D5;padding:1px;">
                                    <b style="font-weight: 800;">ORDER #</b>
                                 </td>
                                 <td width="33.33%" style="border-top: 2px solid #D2D3D5; border-bottom: 2px solid #D2D3D5; border-right: 2px solid #D2D3D5;padding:1px;">
                                    <b style="font-weight: 800;">ORDER DATE</b>
                                 </td>
                                 <td width="33.33%" style="border-top: 2px solid #D2D3D5; border-bottom: 2px solid #D2D3D5; border-right: 2px solid #D2D3D5;padding:1px;">
                                    <b style="font-weight: 800;">PAYMENT METHOD</b>
                                 </td>
                              </tr>
                              <tr>
                                 <td width="33.33%" align="center" style="font-size:13px; border-right: 2px solid #D2D3D5; border-left: 2px solid #D2D3D5; border-bottom: 2px solid #D2D3D5;">
                                    <?php echo $order_info->order_id; ?>                                  
                                 </td>
                                 <td width="33.33%" align="center" style="font-size:13px;border-right: 2px solid #D2D3D5; border-bottom: 2px solid #D2D3D5;">
                                     <?php echo date('d M Y',strtotime($order_info->created)); ?>                                  
                                 </td>
                                 <td width="33.33%" align="center" style="font-size:13px;border-right: 2px solid #D2D3D5; border-bottom: 2px solid #D2D3D5;">
                                    <?php echo ucwords(getCurrency($order_info->currency_type)); ?>                                  
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
            <?php
              $shipping_address = json_decode($order_info->shipping_address);
              if(!empty($shipping_address)){

                  $country = getData('countries',array('id',$shipping_address->country))->name;
                  $state = getData('states',array('id',$shipping_address->state))->name;
                  $city = getData('cities',array('id',$shipping_address->city))->name;
              
            ?>
            <table style="margin-top: 7px;width: 100%;">
               <tbody>
                  <tr>
                     <td width="50%" valign="bottom" align="left" color="#000" style="font-size:13px;color: #000000;text-align: left;">
                        <div style="color: #666666;font-size: 15px;padding-bottom: 5px;font-weight: 600;">SOLD TO</div>
                        <?php echo ucwords($shipping_address->first_name.' '.$shipping_address->last_name); ?><br>
                        <?php echo '+'.$shipping_address->country_code.' '.$shipping_address->phone_no; ?><br>
                        <?php echo $shipping_address->email_id; ?>                               
                     </td>
                     <td width="50%" style="font-size:13px;padding-left: 10px;border-left: 2px solid #D2D3D5;color: #000000; text-align: right;">
                        <div style="color: #666666;font-size: 15px;padding-bottom: 5px;font-weight: 600;">SHIP TO</div>
                        <?php echo ucwords($shipping_address->first_name.' '.$shipping_address->last_name); ?><br>
                        <?php echo $shipping_address->address; ?><br> 
                        <?php echo $city.', '.$state.' - '.$shipping_address->zip_code; ?><br>  
                        <?php echo $country; ?>                                  
                     </td>
                  </tr>
               </tbody>
            </table>
            <?php } ?>

            <?php 
               if(!empty($product_details)){ 
                  $Image = $product_details->image;
                  $Image = explode(',', $Image);
            ?>
            <table class="inner_table hgt450" width="100%" style="margin-top: 7px; border-collapse: collapse; font-size:15px;" cellpadding="5">
               <tbody>
                  <tr bgcolor="#f3f3f4" style="font-size:17px; font-weight:bold; margin-top:15px;">
                     <td width="25%" style="border-left: 2px solid #D2D3D5;border-top: 2px solid #D2D3D5; border-bottom: 2px solid #D2D3D5; border-right: 2px solid #D2D3D5;"><b>ITEM</b> </td>
                     <td width="45%" style="border-top: 2px solid #D2D3D5; border-bottom: 2px solid #D2D3D5; border-right: 2px solid #D2D3D5;"><b>DESCRIPTION</b></td>
                     <td width="10%" style="border-top: 2px solid #D2D3D5; border-bottom: 2px solid #D2D3D5; border-right: 2px solid #D2D3D5;" align="center"><b>QTY</b></td>
                     <td width="15%" style="border-top: 2px solid #D2D3D5; border-bottom: 2px solid #D2D3D5;border-right: 2px solid #D2D3D5;" align="center"><b>COST</b></td>
                  </tr>
                  <tr>
                     <td width="25%" style="border-right: 2px solid #D2D3D5; border-left: 2px solid #D2D3D5; border-bottom: 2px solid #D2D3D5;">
                        <table style="text-align:center;" color="#000" width="100%">
                           <tbody>
                              <tr>
                                 <td>
                                    <center>
                                       <img src="<?php echo base_url(); ?>assets/uploads/seller/products/small_thumbnail/<?php echo $Image[0]; ?>" style="width: auto;height: 120px;">
                                       <center> 
                                       </center>
                                    </center>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                     <td width="45%" style="border-right: 2px solid #D2D3D5; border-bottom: 2px solid #D2D3D5;padding:10px!important;">
                        Item #: <b> <?php echo ucfirst($product_details->title); ?></b> <br>

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
                                       $tempMore .= ucfirst($key)." <b>".$value."</b><br>"; 
                                    }
                                 }
                              }
                           }else if(!empty($product_basic_info)){
                              $product_basic_info = json_decode($product_basic_info);
                              if(!empty($product_basic_info)){
                                 foreach ($product_basic_info as $key => $value) {
                                    if(!empty($key)){
                                       
                                       if($value){ $value = ucfirst($value); }else{ $value = "&nbsp;&nbsp;-"; }
                                       $tempMore .= ucfirst($key)." <b>".$value."</b><br>";
                                    }
                                 }
                              }
                           }
                           echo $tempMore;
                        ?>

                     </td>
                     <td width="10%" align="center" style="border-right: 2px solid #D2D3D5; border-bottom: 2px solid #D2D3D5;"><b style="font-size:16px; color:#000">1</b></td>
                     <td width="10%" align="center" style="border-right: 2px solid #D2D3D5;border-bottom: 2px solid #D2D3D5;">
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
                     </td>
                  </tr>
               </tbody>
            </table>
            <?php } ?>

            <table class="inner_table hgt605" width="100%">
               <tbody>
                  <tr>
                     <td width="50%" style="font-size:15px;    font-weight: 600; color:#000;">
                        TOTAL ITEMS:<b style="color:#000; padding-top:30px;"> 1</b>
                     </td>
                     <td width="50%">
                        <table align="right" style="font-size:15px; color:#000; text-align:right;">
                           <tbody>
                              <tr>
                                 <td>Gross Total:</td>
                                 <td>
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
                                 </td>
                              </tr>
                              <tr>
                                 <td>Discount:</td>
                                 <td>-</td>
                              </tr>
                              <tr>
                                 <td>Shipping:</td>
                                 <td>
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
                                 </td>
                              </tr>
                              <tr>
                                 <td><b>Grand Total:</b></td>
                                 <td><b>
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
                                 </b></td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                  </tr>
               </tbody>
            </table>
            <br>
            <table color="#000" style="text-align: center;font-size: 16px;width: 100%;" class="hgt629">
               <tbody>
                  <tr>
                     <td>Thank you for your purchase!</td>
                  </tr>
               </tbody>
            </table>
            <table class="inner_table bbb hgt629"></table>
         </td>
      </tr>
   </tbody>
</table>


</body>
</html>