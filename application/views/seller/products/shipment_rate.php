<div class="body-container clearfix">
<div class="bread_parent">
  <ul class="breadcrumb">
    <li><a href="<?php echo base_url('seller/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
    <li><a href="<?php echo base_url('seller/products/index'); ?>">Products</a></li>
    <li><b>Shipment rate</b></li>
  </ul>
  <div class="clearfix"></div>
</div>

<div class="theme-container clearfix">
  <div class="clearfix"></div>
  <div class="col-md-12 col-lg-12">
    <div class="common-tab-wrapper">
      <div class="common-contain-wrapper clearfix">
        <div class="">
          <div class="">
            <div class="">
              <div class="common-panel panel">
                <div class="panel-heading">
                  <div class="panel-title"><i class="fa fa-money" aria-hidden="true"></i> Shipment Rate of Product - <?php if(!empty($product_info->title)) echo '"'.ucfirst($product_info->title).'"'; ?></div>
                  <div class="category-breadcrum">
                    <?php
                      $category=explode(',',$product_info->category_id);
                      $bread=get_category_bread_crumb_seller($category[sizeof($category)-1]);
                       if(!empty($bread))
                        {
                          $bread=array_reverse($bread);
                          echo implode(' / ',$bread);
                       
                        } 
                    ?>
                  </div>
                </div>
                <div class="panel-body">
                  <ul style="background-color: #efeff9; padding: 15px 15px 15px 30px;">
                      <li>
                        <b>Free Shipment</b> - In free shipping, No shipping charges will be apply for this product.
                      </li>
                      <li>
                       <b>Custom Shipment</b> - By selecting the custom shipment you can custom define the shipping charges for this product.
                      </li>
                      <?php if(!empty($shipmentrate_setting)){ ?>
                      <li>
                       <b>Global Shipment</b> - In global shipment, shipping charges will be apply for this product which are already defined globally.
                      </li>
                      <?php } ?>
                  </ul>
                  <br>
                  <div class="col-sm-12 center-block clearfix">
                    <form autocomplete="off" role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post" data-bvalidator-validate>
                    <?php echo $this->session->flashdata('msg_error');?>

                    <div class="col-md-12">
                      <div class="form-group col-md-4">
                        <div class="radio-input text-center">
                          <input id="free_shipment" class="styled shipment_rate_type" type="radio" name="shipment_rate_type" value="1" <?php if(!empty($product_variationsData) && $product_variationsData->shipment_rate_type==1) echo "checked"; ?>>
                          <label for="free_shipment">Free Shipment
                          </label>
                        </div>
                      </div>

                      <div class="form-group col-md-4">
                        <div class="radio-input text-center">
                          <input id="custom_shipment" class="styled shipment_rate_type" type="radio" name="shipment_rate_type" value="2" <?php if(!empty($product_variationsData) && $product_variationsData->shipment_rate_type==2) echo "checked"; ?> <?php if(empty($shipmentrate_setting)){ echo 'data-bvalidator="required" data-bvalidator-msg="Please check atleast one checkbox."'; } ?>>
                          <label for="custom_shipment">Custom Shipment
                          </label>
                        </div>
                      </div>

                      <?php if(!empty($shipmentrate_setting)){ ?>
                        <div class="form-group col-md-4">
                          <div class="radio-input text-center">
                            <input id="global_shipment" class="styled shipment_rate_type" type="radio" name="shipment_rate_type" value="3" <?php if(!empty($product_variationsData) && $product_variationsData->shipment_rate_type==3) echo "checked"; ?> data-bvalidator="required" data-bvalidator-msg="Please check atleast one checkbox.">
                            <label for="global_shipment">Global Shipment
                            </label>
                            <a class="link-text text-center" target="_blank" href="<?php echo base_url('seller/country_rates'); ?>"><i class="icofont icofont-edit"></i></a>
                          </div>
                        </div>
                      </div>
                      <?php } ?>
                      <?php echo form_error('shipment_rate_type'); ?>
                      
                      <div class="col-md-12">
                        <div class="form-actiosns form-btn-block text-center">
                          <button  class="btn btn-red" type="submit" id="btnsubmission"><?php if(!empty($product_variationsData) && $product_variationsData->shipment_rate_type==2) echo "Go to the next step"; else echo "Submit"; ?></button>
                        </div>
                      </div>
                    </form>
                    <!-- END FORM--> 
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
  $(document).ready(function(){
    $('form').bValidator();
  });

  $('input.shipment_rate_type').on('change', function() {
    if($(this).val()==2){
      $("#btnsubmission").text("Go to the next step");
    }else{
      $("#btnsubmission").text("Submit");
    }
  });
</script>