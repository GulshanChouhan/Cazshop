<div class="body-container clearfix">
<div class="bread_parent">
  <ul class="breadcrumb">
    <li><a href="<?php echo base_url('seller/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
    <li><a href="<?php echo base_url('seller/country_rates');?>">Shipment Rate of Countries</a></li> 
    <?php
      $countries = "";
      $state = "";
      $country_id = ""; 
      $statedata = getData('states',array('id', $this->uri->segment(3)));
      if($statedata){
        $state = $statedata->name;
        $country_id = $statedata->country_id;
        if($country_id){
          $countriesData = getData('countries',array('id', $country_id));
          if($countriesData){
            $countries = $countriesData->name;
          }
        }
      }
    ?>
    <li><a href="<?php echo base_url('seller/province_rates/'.$country_id); ?>">
      Shipment Rate Of <?php echo $countries; ?> State/Province
      </a>
    </li>   
    <li><b>Shipment Rate Of <?php echo $state; ?> Cities</b></li>
  </ul>
</div>

<div class="theme-container clearfix">
   <div class="clearfix"></div>
   <div class="col-md-12 col-lg-12">
      <div class="common-tab-wrapper">
         <div class="clearfix"></div>
         <div class="common-contain-wrapper clearfix">
            <div class="common-panel panel">
              <div class="panel-heading">
                <div class="panel-title"><i class="icofont icofont-truck"></i> Shipment Rate Of <?php echo $state; ?> Cities</div>
              </div>
              <div class="panel-body">
                <div class="highlight-info-box">
                  <ul>
                    <li>The default shipping charges of the cities wil be same as the charge that we provided for that province.</li>
                    <li>You can update the charges for particular city.</li>
                  </ul>
                </div>
                <br>

                <?php
                  if(!empty($business_info->shipment_option) && !empty($business_info->shippping_type)){ 
                ?>
                <div class="col-md-12 no-padding">
                 <div class="adv-table" id="tab1">
                    <form action="" method="POST" id="rateOfCities" class="shipment-rating-form">
                      <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
                         <thead class="thead_color">
                            <tr>
                               <th class="jv no_sort checkbox-status" style="width:10%">
                                <div class="col-sm-12 no-padding">
                                  <span class="checkbox-input term-check">S No.
                                    <input class="styled" type="checkbox" id="checkAll" class="" >
                                    <label class="" for="checkAll"></label>
                                  </span>
                                </div>
                               </th>
                               <th style="width:20%"><span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Please choose only these Cities that you have to apply the shipping charges"></span> Name Of City</th>
                               <?php 
                                  $shippingRate_Cols = shippingRate_Cols($business_info->shippping_type);
                                  foreach ($shippingRate_Cols as $row) {
                               ?>
                               <th style="text-align: center;width:<?php echo 70/sizeof($shippingRate_Cols); ?>%">
                                  <table class="price_and_delivery_table" style="width: 100%;">
                                     <tr style="width: 100%;">
                                        <td colspan="2"><?php echo $row->title; ?></td>
                                     </tr>
                                     <tr style="width: 100%;">
                                        <td style="width:35%;"><span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Please entered your price for this shipping method and if you want to put your price commonly, click to downward arrow ˅, which is aligned on the right of the label 'price'."></span> Price <i smi="<?php echo $row->shipping_option_id; ?>price" class="fa fa-angle-down dropdownCommanly"></i>
                                            <div class="shipping-type input-group <?php echo $row->shipping_option_id; ?>price" style="display: none;"> 
                                              <div class="input-group-addon font-roboto">$</div>
                                              <input type="text" placeholder="Price Of <?php echo $row->title; ?>" class="form-control global" name="global_price" id="global_price" attr="<?php echo str_replace(" ","_",$row->title); ?>-price" value="">
                                            </div>  
                                        </td>
                                        <td style="width:65%;"><span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Please entered your minimum and maximum delivery days for this shipping method and if you want to put your days commonly, click to downward arrow ˅, which is aligned on the right of the label 'delivery days'."></span> Delivery Days <i smi="<?php echo $row->shipping_option_id; ?>days" class="fa fa-angle-down dropdownCommanly"></i>
                                            <div class="shipping-type input-group <?php echo $row->shipping_option_id; ?>days" style="display: none;">
                                               <span><input type="text" placeholder="Minimum Days" name="global_min" id="global_min" class="form-control global" attr="<?php echo str_replace(" ","_",$row->title); ?>-min"></span>
                                               <span class="input-group-addon" id="basic-addon1">To</span>
                                               <span><input type="text" placeholder="Maximum Days" name="global_max" id="global_max"  class="form-control global" attr="<?php echo str_replace(" ","_",$row->title); ?>-max"></span>
                                            </div>  
                                        </td>
                                     </tr>
                                 </table>
                               </th>
                               <?php } ?>
                            </tr>
                         </thead>
                         <tbody>
                            <?php 
                             if(!empty($shipmentrate_setting)){
                              $stateData = json_decode(trim($shipmentrate_setting->state));
                              $cityData = json_decode(trim($shipmentrate_setting->city));
                             }
                             
                             $i=1;
                             if(!empty($city)){
                             foreach ($city as $row){ 
                              $cityID = $row->id;
                               
                            ?>
                              <tr>
                                  <td>
                                    <div class="checkbox-input">
                                      <?php if (!empty($stateData->$province)){ ?>
                                      <input class="styled checkedCoun" type="checkbox" id="checkall<?php echo $row->id; ?>" name="city[<?php echo $row->id; ?>]" value="<?php echo $row->id; ?>" <?php if(!empty($cityData)){ if(!empty($cityData->$cityID)){ echo 'checked'; } }else{ if (!empty($stateData->$province)){ echo 'checked'; } } ?>>  &nbsp;&nbsp; <?php echo $i.".";?>
                                      <label class="" for="checkall<?php echo $row->id; ?>"></label>
                                      <?php }else{ ?>
                                      &nbsp;&nbsp; <?php echo $i.".";?>
                                      <?php } ?>
                                    </div>
                                  </td>
                                  <td>
                                    <?php echo ucfirst($row->name); ?>
                                  </td>
                                  <?php 
                                    $shippping_type = json_decode($business_info->shippping_type);
                                    $shippingRate_Cols = shippingRate_Cols($business_info->shippping_type);
                                    foreach ($shippingRate_Cols as $key => $value) {
                                      $shipping_option_id = $value->shipping_option_id;
                                      $field = str_replace(" ","_",$value->title);
                                  ?>

                                    <td>
                                      <table class="inner_price_and_delivery_table" style="width: 100%;">
                                         <tr style="width: 100%;">
                                            <td style="width: 35%;">
                                               <div class="input-group"> 
                                                 <div class="input-group-addon font-roboto">$</div>
                                                 <input type="text" class="form-control <?php echo str_replace(" ","_",$value->title); ?>-price shipping<?php echo $row->id; ?>" id="price<?php echo $row->id; ?>" name="city[<?php echo $row->id; ?>][<?php echo str_replace(" ","_",$value->title); ?>][price]" <?php if(empty($cityData)){ if(empty($cityData->$cityID) && empty($stateData->$province)){ echo 'disabled'; } }else{ if(empty($cityData->$cityID->$field->price)){ echo 'disabled'; } } ?>  value="<?php if(!empty($cityData)){ if(!empty($cityData->$cityID) && !empty($cityData->$cityID->$field->price)){ echo $cityData->$cityID->$field->price; } } ?>" placeholder="Price Of <?php echo $value->title; ?>" <?php if(empty($cityData) && empty($cityData->$cityID)) echo ''; else echo 'data-bvalidator="number,required" data-bvalidator-msg="Please enter price"'; ?>>
                                               </div>
                                            </td>
                                            <td style="width:65%;">
                                               <div class="input-group">
                                                 <span><input type="text" placeholder="Minimum Days of <?php echo $value->title; ?>" <?php if(empty($cityData)){ if(empty($cityData->$cityID) && empty($stateData->$province)){ echo 'disabled'; } }else{ if(empty($cityData->$cityID->$field->min_day)){ echo 'disabled'; } } ?> id="min_day<?php echo $row->id; ?>" class="<?php echo str_replace(" ","_",$value->title); ?>-min form-control shipping<?php echo $row->id; ?>" id="min_day<?php echo $row->id; ?>" name="city[<?php echo $row->id; ?>][<?php echo str_replace(" ","_",$value->title); ?>][min_day]" value="<?php if(!empty($cityData)){ if(!empty($cityData->$cityID) && !empty($cityData->$cityID->$field->min_day)){ echo $cityData->$cityID->$field->min_day; } } ?>" <?php if(empty($cityData) || empty($cityData->$cityID)) echo ''; else echo 'data-bvalidator="digit,required" data-bvalidator-msg="Please enter minimum delivery days"'; ?>></span>
                                                 <span class="input-group-addon" id="basic-addon1">To</span>
                                                 <span><input type="text" placeholder="Maximum Days of <?php echo $value->title; ?>" <?php if(empty($cityData)){ if(empty($cityData->$cityID) && empty($stateData->$province)){ echo 'disabled'; } }else{ if(empty($cityData->$cityID->$field->max_day)){ echo 'disabled'; } } ?> id="max_day<?php echo $row->id; ?>" class="<?php echo str_replace(" ","_",$value->title); ?>-max form-control shipping<?php echo $row->id; ?>" id="max_day<?php echo $row->id; ?>" name="city[<?php echo $row->id; ?>][<?php echo str_replace(" ","_",$value->title); ?>][max_day]" value="<?php if(!empty($cityData)){ if(!empty($cityData->$cityID) && !empty($cityData->$cityID->$field->max_day)){ echo $cityData->$cityID->$field->max_day; } } ?>" <?php if(empty($cityData) || empty($cityData->$cityID)) echo ''; else echo 'data-bvalidator="digit,required" data-bvalidator-msg="Please enter maximum delivery days"'; ?>></span>
                                              </div> 
                                            </td>
                                         </tr>
                                      </table>
                                    </td>

                                  <?php } ?>
                              </tr>
                              <?php $i++; } }else{  ?>

                              <tr>
                                <td colspan="4" align="center">
                                  <b>No Cities found.</b>
                                </td>
                              </tr>

                              <?php }  ?>
                         </tbody>
                      </table>
                       <?php if(!empty($city)){ ?>
                      <div class="col-sm-12 controls text-center">
                         <input class="btn btn-red" type="submit" name="subCityData" value="Submit">
                         <a class="btn btn-default-white" href="<?php echo base_url('seller/province_rates/'.$country_id); ?>">Back</a>
                      </div>
                       <?php } ?>
                    </form>
                 </div>
                </div>
                <?php }else{ ?>
                 <div class="col-md-12 no-padding">
                    <h4 align="center">You need to select the shipping method and atleast one shipping type, if you want to allow them <a href="<?php echo base_url('seller/shipment_option/'.base64_encode(seller_id())); ?>">click here</a></h4>
                 </div>
                <?php } ?>
              </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
<script>

   SITE_URL = "<?php echo base_url(); ?>";

   $(document).ready(function(){
      $('#rateOfCities').bValidator();
   });

   $("#tab1 #checkAll").click(function () {
      if($("#tab1 #checkAll").is(':checked')) {
        $("#tab1 input[type=checkbox]").each(function () {
            $('.shipping'+this.value).removeAttr("disabled");
            $('.shipping'+this.value).attr("data-bvalidator","number,required");
            $(this).prop("checked", true);
        });
      }else{
        $("#tab1 input[type=checkbox]").each(function () {
            $('.shipping'+this.value).attr("disabled","disabled");
            $('.shipping'+this.value).val("");
            $('.shipping'+this.value).attr("data-bvalidator","");
            $(this).prop("checked", false);
        });
      }
   });

   $(".dropdownCommanly").click(function(){
      var smi = $(this).attr("smi");
      $('.'+smi).toggle();
      $(".shipping-type").parent().addClass('shipping-padding');
      var count=0;
        $(".shipping-type").each(function () {
           if($(this).css('display') === 'table'){
              count++;
              $(this).parent().removeClass('shipping-padding');
          }
        });
        if(count===0)
        {
          $(".shipping-type").parent().removeClass('shipping-padding');
        }
       /* if(count>0){
            $(".shipping-type").each(function () {
              if(!$(this).is(':visible')){
                  count++;
                  $(this).parent().addClass('shipping-padding');
              }
            });
        }*/
   });

   $(".checkedCoun").click(function(){
      stateId = $(this).val();
      if ($("#checkall"+stateId).is(':checked')) {
        $('.shipping'+this.value).removeAttr("disabled");
        $('.shipping'+this.value).attr("data-bvalidator","number,required"); 
      } else {
        $('.shipping'+this.value).attr("disabled","disabled");
        $('.shipping'+this.value).val("");
        $('.shipping'+this.value).attr("data-bvalidator",""); 
      }
   });

   $('.global').keyup(function(){
        $('.'+$(this).attr('attr')).val($(this).val());
        $('.'+$(this).attr('attr')+':disabled').val('');
   });

</script>
<style>
.shipping-padding span{
  margin-bottom: 38px;
} 
</style>