<div class="body-container clearfix">
<div class="bread_parent">
   <ul class="breadcrumb">
      <li><a href="<?php echo base_url('seller/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
      <li><a href="<?php echo base_url('seller/products/index');?>">Products</a></li>
      <li><b>Product Definition/Offer Information</b></li>
   </ul>
   <div class="clearfix"></div>
</div>
<div class="theme-container clearfix">
  <div class="clearfix"></div>
  <div class="col-md-12 col-lg-12">
    <div class="common-tab-wrapper">
      <div class="common-tab-system partners clearfix">
       <?php $this->load->view('seller/products/tabMenus'); ?>

        <?php
          if(!empty($product_info_id) && !empty($product_variation_id)){
            $showForm = 1;
          }else if(!empty($product_info_id)){
            $productExist = productExist($product_info_id);
            if(!empty($productExist)){
              $showForm = 0;
            }else{
              $showForm = 1;
            }
          }
        ?>
      </div>
      <div class="clearfix"></div>
      <div class="common-contain-wrapper clearfix">
        <div class="">
          <div class="">
            <div class="">
              <div class="common-panel panel">
                <div class="panel-heading">
                  <div class="panel-title"><i class="icofont icofont-gift"></i> Product Definition/Offer Information <?php if(!empty($product_info->title)) echo ' - "'.ucfirst($product_info->title).'"'; ?></div>
                  <div class="category-breadcrum">
                    <?php
                      $category=explode(',',$product_info->category_id);
                      $bread=get_category_bread_crumb_seller($category[sizeof($category)-1]);
                        if(!empty($bread)){
                            $bread=array_reverse($bread);
                            echo implode(' / ',$bread);
                        } 
                    ?>
                  </div>
                </div>

                <?php if($type==2){ ?>

                    <div class="highlight-info-box">
                        <ul>
                          <li>You can edit the offer details and add the images for each individual variation.</li>
                          <li>You must have to edit the Parent product of that variations if you wish to edit the information in the remaining sections <a class="link-text" target="_blank" href="<?php echo base_url('seller/products/edit_product_category/'.$product_info_id.'/0/'.$type); ?>"> <b>Click here.</b></a></li>
                        </ul>
                    </div>
                    <br>

                  <?php }else if($type==3){ ?>

                    <div class="highlight-info-box">
                      <ul>
                        <li>Provide the product offer information here.</li>
                        <li>Once you submitted the details in offer section, the variation section will be hided and you won't be able to add the product with variations.</li>
                      </ul>
                    </div>
                    <br>

                  <?php } ?>

                  <div class="panel-body">
                  <div class="col-sm-8 center-block">

                    <div class="panel-heading">
                    <div class="panel-title"><i class="icofont icofont-info-square"></i> Product Information</div>
                    <hr>
                  </div>

                     <form autocomplete="off" role="form" class="form-horizontal tasi-form" action="<?php echo current_url(); ?>" enctype="multipart/form-data" method="post" data-bvalidator-validate>
                       <?php
                        if($showForm==1){
                          $getVariationProduct = getVariationProduct($product_info_id);
                          if(empty($getVariationProduct)){ 
                       ?>
                       <?php echo $this->session->flashdata('msg_error');?>
                      <div class="form-group">
                        <label class="col-md-4 control-label">Seller SKU<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the unique Seller SKU with atleast 5 characters."></span> :</label>
                        <div class="col-md-8">
                          <input type="text" data-bvalidator="required" minlength="5" maxlength="20" placeholder="Example: S12T-Gec-RM" <?php if(!empty($product_offerBasicInfo)) echo 'readonly';  ?> class="form-control" name="seller_SKU" value="<?php if(set_value('seller_SKU')){ echo set_value('seller_SKU'); }else{ if(!empty($product_offerBasicInfo)){ echo $product_offerBasicInfo->seller_SKU; } } ?>" > <span class="error"><?php echo form_error('seller_SKU'); ?> </span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label">Product ID<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the unique Product ID with atleast 8 characters."></span> :</label>
                        <div class="col-md-8">
                          <input type="text" data-bvalidator="required" <?php if(!empty($product_offerBasicInfo) && !empty($product_offerBasicInfo->product_ID)) echo 'readonly';  ?> placeholder="Example: 00012345" minlength="8" maxlength="15" class="form-control" name="product_ID" value="<?php if(set_value('product_ID')){ echo set_value('product_ID'); }else{ if(!empty($product_offerBasicInfo)){ echo $product_offerBasicInfo->product_ID; } } ?>" > <span class="error"><?php echo form_error('product_ID'); ?> </span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label">Product ID Type<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Select the unique Product ID type."></span> :</label>
                        <div class="col-md-8">
                          <?php $product_ID_type = product_ID_type(""); ?>
                          <select class="form-control" name="product_ID_type" data-bvalidator="required">
                             <option value="">--Select Product ID Type--</option>
                             <?php foreach ($product_ID_type as $key => $value) { ?>
                                <option <?php if(!empty($product_offerBasicInfo)){ if($product_offerBasicInfo->product_ID_type==$key){ echo "selected"; } } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                             <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label">Retail Price(MRP)<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the Product Retail Price (In Dollar Currency). Retail price should be greater than the Sell price."></span> :</label>
                        <div class="col-sm-8">
                           <div class="input-group">
                             <span style="" class="input-group-addon">
                                <i class="fa fa-usd" aria-hidden="true"></i>
                             </span>
                             <div class="num-input-container">
                                <input type="text" data-bvalidator="checkGreaterSellPrice,required" data-bvalidator-msg="The Retail price should be greater than the Sell price." value="<?php if(set_value('sell_price')){ echo set_value('sell_price'); }else{ if(!empty($product_offerBasicInfo)){ echo $product_offerBasicInfo->sell_price; } } ?>" tabindex="6" maxlength="15" placeholder="Example: 12.00" name="sell_price" class="form-control retail_price">
                             </div>
                           </div>
                            <span class="error"><?php echo form_error('sell_price'); ?> </span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label">Sell Price<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the Product Sell Price (In Dollar Currency)"></span> :</label>
                        <div class="col-sm-8">
                          <div class="input-group">
                            <span style="" class="input-group-addon">
                              <i class="fa fa-usd" aria-hidden="true"></i>
                            </span>
                            <div class="num-input-container">
                              <input type="text" data-bvalidator="number,required" value="<?php if(set_value('base_price')){ echo set_value('base_price'); }else{ if(!empty($product_offerBasicInfo)){ echo $product_offerBasicInfo->base_price; } } ?>" tabindex="6" maxlength="15" placeholder="Example: 10.00" name="base_price" class="form-control sell_price">
                            </div>
                          </div>
                          <span class="error"><?php echo form_error('base_price'); ?> </span>
                          <div class="brand-contact-info">Your entered "Retail" and "Sell" price will be appear as <b>BitCoin</b>, <b>Ethereum</b>, <b>LiteCoin</b> and <b>CazCoin</b> in the website.</div>
                        </div>

                      </div>
                      <div class="form-group">
                         <label class="col-md-4 control-label">Quantity<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the Quantity of product"></span> :</label>
                         <div class="col-md-8">
                            <input type="number" data-bvalidator="number,required" maxlength="5" min=0 placeholder="7" class="form-control" name="quantity" value="<?php if(set_value('quantity')){ echo set_value('quantity'); }else{ if(!empty($product_offerBasicInfo)){ echo $product_offerBasicInfo->quantity; } } ?>" > <span class="error"><?php echo form_error('quantity'); ?> </span>
                         </div>
                      </div>
                      <div class="form-group">
                         <label class="col-md-4 control-label">Warranty Description <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Write the Warranty Description"></span> :</label>
                         <div class="col-md-8">
                            <textarea data-bvalidator="" placeholder="Warranty Description" class="form-control tinymce_edittor" rows="5" cols="10" name="warranty_description" ><?php if(set_value('warranty_description')) echo set_value('warranty_description'); else if(!empty($product_variationsData)) echo $product_variationsData->warranty_description; ?></textarea>
                            <span class="error"><?php echo form_error('warranty_description'); ?> </span>
                         </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label">Seller Description <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Write your Description"></span> :</label>
                        <div class="col-md-8">

                          <textarea data-bvalidator="" placeholder="Seller Description" class="form-control tinymce_edittor" rows="5" cols="10" name="seller_description" ><?php if(set_value('seller_description')) echo set_value('seller_description'); else if(!empty($product_variationsData)) echo $product_variationsData->seller_description; ?></textarea>
                          <span class="error"><?php echo form_error('seller_description'); ?> </span>
                        </div>
                      </div>
                      <?php }else{ ?>

                      <?php echo $this->session->flashdata('msg_error');?>

                      <?php
                        if(!empty($product_variation_id)){
                          $getParVariationProduct = getParVariationProduct($product_info_id, $product_variation_id);
                          if(!empty($getParVariationProduct)){ 
                      ?>

                      <?php 
                        $variation_info = (array)json_decode($getParVariationProduct->product_variation_info);
                        if(!empty($variation_info)){
                            $variation_data=get_attribute_variation(array_keys($variation_info));
                           
                        foreach ($variation_data as $key => $value) { 
                       
                      ?>

                      <div class="form-group">
                      <label class="col-md-4 control-label"><?php if($value->name){ echo ucfirst($value->name); } ?> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="<?php $tooltipContent = getData('attributes',array('name',$value->name)); if($tooltipContent) echo $tooltipContent->tooltip_content; ?>"></span> :</label> 
                      <div class="col-md-8">
                        <?php if($value->file_type==1) 
                         {?>
                            <input type="text" maxlength="500" placeholder="<?php echo ucfirst($value->placeholder_content);  ?>" class="form-control" name="product_variation_info[<?php if($value->attribute_code){ echo $value->attribute_code; } ?>]" value="<?php if(!empty($variation_info[$value->attribute_code])) echo $variation_info[$value->attribute_code]; else echo $value->default_value; ?>" <?php if($value->is_readonly) echo "readonly"; if($value->is_required_only) echo 'data-bvalidator="required"'; ?> >
                        <?php
                         }else if($value->file_type==2){ ?>
                              <textarea class="form-control" maxlength="1000" placeholder="<?php echo ucfirst($value->placeholder_content);  ?>" name="product_variation_info[<?php if($value->attribute_code){ echo $value->attribute_code; } ?>]" <?php if($value->is_readonly) echo "readonly"; if($value->is_required_only) echo 'data-bvalidator="required"'; ?> ><?php if(!empty($variation_info[$value->attribute_code])) echo $variation_info[$value->attribute_code]; else echo $value->default_value; ?></textarea>

                         <?php }else if($value->file_type==3){ ?>
                            <select class="form-control chosen-select" name="product_variation_info[<?php if($value->attribute_code){ echo $value->attribute_code; } ?>]" <?php if($value->is_required_only) echo 'data-bvalidator="required"'; ?>>
                                <option value="">--Select--</option>
                                <?php if(!empty(json_decode($value->attribute_value))){ 
                                   foreach (json_decode($value->attribute_value) as $key) { 
                                ?>
                                   <option value="<?php echo $key; ?>" <?php if(!empty($variation_info[$value->attribute_code]) && $variation_info[$value->attribute_code]==$key) echo 'selected'; ?>><?php echo $key; ?></option>
                                <?php } } ?>
                             </select>
                        <?php }else if($value->file_type==5){ ?>
                              <select class="form-control chosen-select" name="product_variation_info[<?php if($value->attribute_code){ echo $value->attribute_code; } ?>][]" <?php if($value->is_required_only) echo 'data-bvalidator="required"'; ?> multiple>
                                  <option value="">--Select--</option>
                                  <?php if(!empty(json_decode($value->attribute_value))){ 
                                     foreach (json_decode($value->attribute_value) as $key) { 
                                  ?>
                                     <option value="<?php echo $key; ?>" <?php if(!empty($variation_info[$value->attribute_code]) && $variation_info[$value->attribute_code]==$key) echo 'selected'; ?> ><?php echo $key; ?></option>
                                  <?php } } ?>
                               </select>
                        <?php }else if($value->file_type==8){ ?>
                              <input size="16" type="text" maxlength="50" placeholder="<?php echo ucfirst($value->placeholder_content);  ?>" value="<?php if(!empty($variation_info[$value->attribute_code])) echo $variation_info[$value->attribute_code]; else echo $value->default_value; ?>" class="default_date form-control date" name="product_variation_info[<?php if($value->attribute_code){ echo $value->attribute_code; } ?>]" <?php if($value->is_readonly) echo "readonly"; if($value->is_required_only) echo 'data-bvalidator="date[dd-mm-yyyy],required"'; ?>>
                        <?php }else if($value->file_type==9){ ?>
                              <input type="text" maxlength="500" placeholder="<?php echo ucfirst($value->placeholder_content);  ?>" class="form-control" name="product_variation_info[<?php echo $value->attribute_code.'-9'; ?>]" value="<?php if(!empty($variation_info[$value->attribute_code])) echo $variation_info[$value->attribute_code]; else echo $value->default_value; ?>" <?php if($value->is_readonly) echo "readonly"; if($value->is_required_only) echo 'data-bvalidator="required"'; ?> >
                                  <select class="form-control chosen-select" name="product_variation_info[<?php echo $value->attribute_code; ?>]">
                                    <option value="">--Select--</option>
                                    <?php if(!empty(json_decode($value->attribute_value))){ 
                                       foreach (json_decode($value->attribute_value) as $key) { 
                                    ?>
                                       <option value="<?php echo $key; ?>" <?php if(!empty($variation_info[$value->attribute_code]) && $variation_info[$value->attribute_code]==$key) echo 'selected'; ?>><?php echo $key; ?></option>
                                    <?php } } ?>
                                 </select>
                            <?php }else if($value->file_type==10){ ?>
                              <input type="text" maxlength="500" placeholder="<?php echo ucfirst($value->placeholder_content);  ?>" main="<?php echo $value->attribute_code ; ?>" class="form-control typeahead" name="product_variation_info[<?php echo $value->attribute_code ; ?>]" value="<?php if(!empty($variation_info[$value->attribute_code])) echo $variation_info[$value->attribute_code]; else echo $value->default_value; ?>" <?php if($value->is_readonly) echo "readonly"; if($value->is_required_only) echo 'data-bvalidator="required"'; ?> >
                            <?php  }
                        ?>
                      </div> 
                    </div>
                    <?php } }  ?>

                    <div class="form-group">
                      <label class="col-md-4 control-label">Seller SKU<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the unique Seller SKU with atleast 5 characters."></span> :</label>
                      <div class="col-md-8">
                        <input type="text" data-bvalidator="required" <?php if(!empty($getParVariationProduct) && !empty($getParVariationProduct->seller_SKU)) echo 'readonly';  ?> minlength="5" maxlength="20" placeholder="Seller SKU" class="form-control" name="seller_SKU" value="<?php if(set_value('seller_SKU')){ echo set_value('seller_SKU'); }else{ if(!empty($getParVariationProduct)){ echo $getParVariationProduct->seller_SKU; } } ?>" > <span class="error"><?php echo form_error('seller_SKU'); ?> </span>
                      </div>
                    </div>
                    <div class="form-group">
                       <label class="col-md-4 control-label">Product ID<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the unique Product ID with atleast 8 characters."></span> :</label>
                       <div class="col-md-8">
                          <input type="text" data-bvalidator="required" <?php if(!empty($getParVariationProduct) && !empty($getParVariationProduct->product_ID)) echo 'readonly';  ?> placeholder="Product ID" minlength="8" maxlength="15" class="form-control" name="product_ID" value="<?php if(set_value('product_ID')){ echo set_value('product_ID'); }else{ if(!empty($getParVariationProduct)){ echo $getParVariationProduct->product_ID; } } ?>" > <span class="error"><?php echo form_error('product_ID'); ?> </span>
                       </div>
                    </div>
                    <div class="form-group">
                       <label class="col-md-4 control-label">Product ID Type<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Select the unique Product ID type."></span> :</label>
                       <div class="col-md-8">
                          <?php $product_ID_type = product_ID_type(""); ?>
                          <select class="form-control" name="product_ID_type" data-bvalidator="required">
                             <option value="">--Select Product ID Type--</option>
                             <?php foreach ($product_ID_type as $key => $value) { ?>
                                <option <?php if(!empty($getParVariationProduct)){ if($getParVariationProduct->product_ID_type==$key){ echo "selected"; } } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                             <?php } ?>
                          </select>
                       </div>
                    </div>
                    <div class="form-group">
                       <label class="col-md-4 control-label">Retail Price(MRP)<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the Product Retail Price (In Dollar Currency). Retail price should be greater than the Sell price."></span> :</label>
                       <div class="col-sm-8">
                           <div class="input-group">
                             <span style="" class="input-group-addon">
                                <i class="fa fa-usd" aria-hidden="true"></i>
                             </span>
                             <div class="num-input-container">
                                <input type="text" data-bvalidator="checkGreaterSellPrice,required" data-bvalidator-msg="The Retail price should be greater than Sell price." value="<?php if(set_value('sell_price')){ echo set_value('sell_price'); }else if(!empty($getParVariationProduct)){ echo $getParVariationProduct->sell_price;  } ?>" tabindex="6" maxlength="15" placeholder="Example: 12.00" name="sell_price" class="form-control retail_price">
                             </div>
                           </div>
                           <span class="error"><?php echo form_error('sell_price'); ?> </span>
                       </div>
                    </div>
                    <div class="form-group">
                       <label class="col-md-4 control-label">Sell Price<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the Product Sell Price (In Dollar Currency)"></span> :</label>
                       <div class="col-sm-8">
                           <div class="input-group">
                             <span style="" class="input-group-addon">
                                <i class="fa fa-usd" aria-hidden="true"></i>
                             </span>
                             <div class="num-input-container">
                                <input type="text" data-bvalidator="number,required" value="<?php if(set_value('base_price')){ echo set_value('base_price'); }else if(!empty($getParVariationProduct)){ echo $getParVariationProduct->base_price; } ?>" tabindex="6" maxlength="15" placeholder="Example: 10.00" name="base_price" class="form-control sell_price">
                             </div>
                           </div>
                           <span class="error"><?php echo form_error('base_price'); ?> </span>
                       </div>
                    </div>
                    <div class="form-group">
                       <label class="col-md-4 control-label">Quantity<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Enter the Quantity of product"></span> :</label>
                       <div class="col-md-8">
                          <input type="number" data-bvalidator="number,required"  maxlength="5" minlength="0" placeholder="Quantity" class="form-control" name="quantity" value="<?php if(set_value('quantity')){ echo set_value('quantity'); }else if(!empty($getParVariationProduct)){ echo $getParVariationProduct->quantity; }  ?>" > <span class="error"><?php echo form_error('quantity'); ?> </span>
                       </div>
                    </div>
                    <div class="form-group">
                       <label class="col-md-4 control-label">Warranty Description<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Write the Warranty Description"></span> :</label>
                       <div class="col-md-8">
                          <textarea data-bvalidator="required" placeholder="Warranty Description" class="form-control tinymce_edittor" rows="5" cols="10" name="warranty_description" ><?php if(set_value('warranty_description')) echo set_value('warranty_description'); else if(!empty($product_variationsData)) echo $product_variationsData->warranty_description; ?></textarea>
                          <span class="error"><?php echo form_error('warranty_description'); ?> </span>
                       </div>
                    </div>
                    <div class="form-group">
                       <label class="col-md-4 control-label">Seller Description<span class="mandatory">*</span> <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Write your Description"></span> :</label>
                       <div class="col-md-8">
                          <textarea data-bvalidator="required" placeholder="Seller Description" class="form-control tinymce_edittor" rows="5" cols="10" name="seller_description" ><?php if(set_value('seller_description')) echo set_value('seller_description'); else if(!empty($product_variationsData)) echo $product_variationsData->seller_description; ?></textarea>
                          <span class="error"><?php echo form_error('seller_description'); ?> </span>
                       </div>
                    </div>
                    <?php } }
                    } ?>

                    <div class="panel-heading">
                      <div class="panel-title"><i class="icofont icofont-gift"></i> Offer Information</div>
                      <hr>
                    </div>
                    <div class="form-group">
                       <label class="col-md-4 control-label">Maximum Retail Price <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="A number with up to 15 digits allowed to the left of the decimal point and 2 digits to the right of the decimal point. Please do not use commas or dollar signs."></span> :</label>
                       <div class="col-sm-8">
                           <div class="input-group">
                             <span style="" class="input-group-addon">
                                <i class="fa fa-usd" aria-hidden="true"></i>
                             </span>
                             <div class="num-input-container">
                                <input type="text" data-bvalidator="number" value="<?php if(set_value('maximum_retail_price')){ echo set_value('maximum_retail_price'); }else{ if(!empty($product_offerOtherInfo)){ echo $product_offerOtherInfo->maximum_retail_price; } } ?>" tabindex="6" maxlength="15" placeholder="Example: 10.00" name="maximum_retail_price" class="form-control">
                             </div>
                           </div>
                       </div>
                    </div>
                    <div class="form-group">
                       <label class="col-md-4 control-label">Sale Price <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="The price at which you offer the product for sale."></span> :</label>
                       <div class="col-sm-8">
                           <div class="input-group">
                             <span style="" class="input-group-addon">
                                <i class="fa fa-usd" aria-hidden="true"></i>
                             </span>
                             <div class="num-input-container">
                                <input type="text" data-bvalidator="number" value="<?php if(set_value('sale_price')){ echo set_value('sale_price'); }else{ if(!empty($product_offerOtherInfo)){ echo $product_offerOtherInfo->sale_price; } } ?>" tabindex="6" maxlength="15" placeholder="Example: 30.00" name="sale_price" class="form-control">
                             </div>
                           </div>
                       </div>
                    </div>
                    <div class="form-group">
                       <label class="col-md-4 control-label">Sale Start Date <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="The date that the sale price will begin to override the product's original price."></span> :</label>
                       <div class="col-sm-8">
                           <div class="input-group">
                             <span style="" class="input-group-addon">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                             </span>
                             <div class="num-input-container">
                                <input type="text" data-bvalidator="date[dd-mm-yyyy]" value="<?php if(set_value('sale_start_date')){ echo set_value('sale_start_date'); }else{ if(!empty($product_offerOtherInfo)){ echo date('d-m-Y',strtotime($product_offerOtherInfo->sale_start_date)); } } ?>" tabindex="6" maxlength="15" placeholder="Example: 17-01-2018" name="sale_start_date" id="dpd1" class="form-control default_date">
                             </div>
                           </div>
                       </div>
                    </div>
                    <div class="form-group">
                       <label class="col-md-4 control-label">Sale End Date <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="A date in this format: dd-mm-yyyy."></span> :</label>
                       <div class="col-sm-8">
                           <div class="input-group">
                             <span style="" class="input-group-addon">
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                             </span>
                             <div class="num-input-container">
                                <input type="text" data-bvalidator="date[dd-mm-yyyy]" value="<?php if(set_value('sale_end_date')){ echo set_value('sale_end_date'); }else{ if(!empty($product_offerOtherInfo)){ echo date('d-m-Y',strtotime($product_offerOtherInfo->sale_end_date)); } } ?>" tabindex="6" maxlength="15" placeholder="Example: 28-02-2018" name="sale_end_date" id="dpd2" class="form-control default_date">
                             </div>
                           </div>
                       </div>
                    </div>
                    <div class="form-group">
                       <label class="col-md-4 control-label">Can Be Gift Messaged <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="If you can print a gift message with the item indicate that here.  If left blank, defaults to 'false'."></span> :</label>
                       <div class="col-md-8">
                        <div class="checkbox-input">
                          <input type="checkbox" class="styled" id="can_be_gift_messaged" name="can_be_gift_messaged" value="1" <?php if(!empty($product_offerOtherInfo) && $product_offerOtherInfo->can_be_gift_messaged==1){ echo "checked"; } ?>>
                          <label for="can_be_gift_messaged"></label>
                        </div>
                       </div>
                    </div>
                    <div class="form-group">
                       <label class="col-md-4 control-label">Is Gift Wrap Available? <span class="fa fa-info-circle tooltips" rel="tooltip" data-placement="top" data-original-title="Select: TRUE or FALSE. If left blank, defaults to 'false'."></span> :</label>
                       <div class="col-md-8">
                        <div class="checkbox-input">
                          <input type="checkbox" class="styled" id="is_gift_wrap_available" name="is_gift_wrap_available" value="1" <?php if(!empty($product_offerOtherInfo) && $product_offerOtherInfo->is_gift_wrap_available==1){ echo "checked"; } ?>>
                          <label for="is_gift_wrap_available"></label>
                        </div>
                       </div>
                    </div>
                    <div class="form-group">
                       <label class="col-md-4 control-label">Fulfillment Channel :</label>
                       <div class="col-md-8">
                        <div class="radio-input">
                          <input type="radio" id="fulfillment_channel1" name="fulfillment_channel" value="1" <?php if(!empty($product_offerOtherInfo) && $product_offerOtherInfo->fulfillment_channel==1){ echo "checked"; }else{ echo "checked"; } ?>> 
                          <label for="fulfillment_channel1">I want to ship this item myself or use <?php echo SITE_NAME; ?> Easy Ship if it sells.</label>
                        </div>
                        <div class="radio-input">
                          <input type="radio" id="fulfillment_channel2" name="fulfillment_channel" value="2" <?php if(!empty($product_offerOtherInfo) && $product_offerOtherInfo->fulfillment_channel==1){ echo "checked"; } ?>> 
                          <label for="fulfillment_channel2">I want to use Fulfilled by <?php echo SITE_NAME; ?> to ship my items if they sell.</label>
                        </div>
                       </div>
                    </div>
                      <div class="col-md-4"></div>
                      <div class="col-md-8">
                        <div class="form-actiosns form-btn-block text-center">
                          <input type="submit" name="submitInfo" class="btn btn-red" value="<?php if(!empty($product_offerOtherInfo)){ echo "Update"; }else{ echo "Continue"; } ?>">
                          <?php if($type==1){ ?>
                          <a class="btn btn-default-white" href="<?php echo base_url('seller/products/edit_product_basic_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type); ?>">Back</a>
                          <?php }else if($type==2){ ?>
                          <a class="btn btn-default-white" href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a>
                          <?php }else if($type==3){ ?>
                          <a class="btn btn-default-white" href="<?php echo base_url('seller/products/edit_product_basic_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type); ?>">Back</a>
                          <?php } ?>
                        </div>
                      </div>
                    </form>
                    <?php  }else{ ?>
                     <!-- END FORM--> 
                     <div class="col-md-12 text-center">
                        <h4><b><i class="fa fa-info-circle" aria-hidden="true"></i> We have not permitted you to edit the Product Offer Information</b></h4>
                     </div>
                    <?php } ?>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script type="text/javascript">
   $('input.typeahead').typeahead({
       source:  function (query, process) {
         var attr=this.$element.attr('main');
         return $.get('<?php echo base_url(); ?>backend/common/autocomplete', { query: query,attribute_code:attr }, function (data) {
            data = $.parseJSON(data);
               return process(data);
           });
       }
   });

   $("body").on("keydown, keyup", ".retail_price", function(event) {
      var retail_price = $(this).val();
      $('.sell_price').val(retail_price);
   });

   $(document).ready(function(){
      $('form').bValidator();
   });

   function checkGreaterSellPrice(sell_price){
      var base_price = $("input[name='base_price']").val();
      if(parseInt(base_price) > parseInt(sell_price)){
        return false;
      }else{
        return true;
      }
   }

</script>