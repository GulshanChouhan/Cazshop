<div class="bread_parent">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
         <li><a href="<?php echo base_url('backend/products/index'); ?>">Products</a></li>
         <li>Product Offers</li>
      </ul>
   </div>
   <div class="clearfix"></div>
</div>
<div class="superadmin-body panel-body partners">
   
   <?php $this->load->view('backend/products/tabMenus'); ?>

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

   <div class="adv-table">
      <div class="panel-body">

         <form autocomplete="off" role="form" class="form-horizontal tasi-form" action="<?php echo current_url(); ?>" enctype="multipart/form-data" method="post" data-bvalidator-validate>
         <?php
          if($showForm==1){
            $getVariationProduct = getVariationProduct($product_info_id);
            if(empty($getVariationProduct)){ 
         ?>

         
            <?php echo $this->session->flashdata('msg_error');?>
            <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i> Product Offer Information :</header>
            <br>

            <div class="form-group">
               <label class="col-md-2 control-label">Seller SKU :</label>
               <div class="col-md-9">
                  <?php if(set_value('seller_SKU')){ echo set_value('seller_SKU'); }else{ if(!empty($product_offerBasicInfo)){ echo $product_offerBasicInfo->seller_SKU; } } ?>
               </div>
            </div>

            <div class="form-group">
               <label class="col-md-2 control-label">Product ID :</label>
               <div class="col-md-9">
                  <?php if(set_value('product_ID')){ echo set_value('product_ID'); }else{ if(!empty($product_offerBasicInfo)){ echo ucfirst($product_offerBasicInfo->product_ID); } } ?>
               </div>
            </div>

            <div class="form-group">
               <label class="col-md-2 control-label">Product ID Type :</label>
               <div class="col-md-9">
                <?php 
                  $product_ID_type = product_ID_type(""); 
                  foreach ($product_ID_type as $key => $value) { 
                    if(!empty($product_offerBasicInfo)){ 
                      if($product_offerBasicInfo->product_ID_type==$key){
                        echo ucfirst($value); 
                      } 
                    }
                  }
                ?>
               </div>
            </div>

            <div class="form-group">
               <label class="col-md-2 control-label">Base Price :</label>
               <div class="col-sm-9">
                   <?php 
                    if(!empty($product_offerBasicInfo->base_price)){ 
                      echo '$'.number_format($product_offerBasicInfo->base_price,2); 
                    }else{ 
                      echo "$0.00"; 
                    } 
                   ?>
               </div>
            </div>

            <div class="form-group">
               <label class="col-md-2 control-label">Sell Price :</label>
               <div class="col-sm-9">
                   <?php 
                    if(!empty($product_offerBasicInfo->sell_price)){ 
                      echo '$'.number_format($product_offerBasicInfo->sell_price,2); 
                    }else{ 
                      echo "$0.00"; 
                    } 
                   ?>
               </div>
            </div>

            <div class="form-group">
               <label class="col-md-2 control-label">Quantity :</label>
               <div class="col-md-9">
                  <?php if(!empty($product_offerBasicInfo->quantity)){ echo ucfirst($product_offerBasicInfo->quantity); }else{ echo '0'; } ?>
               </div>
            </div>

            <div class="form-group">
               <label class="col-md-2 control-label">Warranty Description :</label>
               <div class="col-md-9">
                  <?php if(!empty($product_variationsData->warranty_description)){ echo ucfirst($product_variationsData->warranty_description); }else{ echo "-"; } ?>
               </div>
            </div>


            <div class="form-group">
               <label class="col-md-2 control-label">Seller Description :</label>
               <div class="col-md-9">
                  <?php if(!empty($product_variationsData->seller_description)){ echo ucfirst($product_variationsData->warranty_description); }else{ echo "-"; } ?>
               </div>
            </div>
            
         <?php }else{ ?>

         
            <?php echo $this->session->flashdata('msg_error');?>
            <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i> Product Offer Information :</header>
            <br>

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
                   <label class="col-md-2 control-label"><?php if($value->name){ echo ucfirst($value->name)." :"; } ?></label> 
                    <div class="col-md-9">
                  <?php if($value->file_type==1) 
                   {?>
                      <?php if(!empty($variation_info[$value->attribute_code])) echo ucfirst($variation_info[$value->attribute_code]); else echo ucfirst($value->default_value); ?>
                  <?php
                   }else if($value->file_type==2){ ?>
                        
                      <?php if(!empty($variation_info[$value->attribute_code])) echo ucfirst($variation_info[$value->attribute_code]); else echo ucfirst($value->default_value); ?>

                   <?php }else if($value->file_type==3){ ?>
                      <?php 
                        if(!empty(json_decode($value->attribute_value))){ 
                          foreach (json_decode($value->attribute_value) as $key) {
                            if(!empty($variation_info[$value->attribute_code]) && $variation_info[$value->attribute_code]==$key) 
                              echo ucfirst($key); 
                          } 
                        }
                      ?>
                  <?php }else if($value->file_type==5){ ?>
                      <?php 
                        if(!empty(json_decode($value->attribute_value))){ 
                          foreach (json_decode($value->attribute_value) as $key) { 
                            if(!empty($variation_info[$value->attribute_code]) && $variation_info[$value->attribute_code]==$key) 
                              echo ucfirst($key);
                          } 
                        }
                      ?>
                  <?php }else if($value->file_type==8){ ?>

                        <?php if(!empty($variation_info[$value->attribute_code])) echo ucfirst($variation_info[$value->attribute_code]); else echo ucfirst($value->default_value); ?>

                  <?php }else if($value->file_type==9){ ?>

                        <?php if(!empty($variation_info[$value->attribute_code])) echo ucfirst($variation_info[$value->attribute_code]); else echo ucfirst($value->default_value); ?>

                        <?php 
                          if(!empty(json_decode($value->attribute_value))){ 
                            foreach (json_decode($value->attribute_value) as $key){ 
                              if(!empty($variation_info[$value->attribute_code]) && $variation_info[$value->attribute_code]==$key)
                              echo ucfirst($key);
                            } 
                          }
                        ?>

                  <?php }else if($value->file_type==10){ ?>
                        <?php if(!empty($variation_info[$value->attribute_code])) echo ucfirst($variation_info[$value->attribute_code]); else echo ucfirst($value->default_value); ?>
                 <?php  }
               ?>
               </div> 
             </div>
          <?php } }  ?>
              <div class="form-group">
                 <label class="col-md-2 control-label">Seller SKU :</label>
                 <div class="col-md-9">
                    <?php if(!empty($getParVariationProduct->seller_SKU)){ echo ucfirst($getParVariationProduct->seller_SKU); }else{ echo "-"; } ?>
                 </div>
              </div>
              <div class="form-group">
                 <label class="col-md-2 control-label">Product ID :</label>
                 <div class="col-md-9">
                    <?php if(!empty($getParVariationProduct->product_ID)){ echo ucfirst($getParVariationProduct->product_ID); }else{ echo "-"; } ?>
                 </div>
              </div>

              <div class="form-group">
                 <label class="col-md-2 control-label">Product ID Type :</label>
                 <div class="col-md-9">
                    <?php 
                      $product_ID_type = product_ID_type("");
                      foreach ($product_ID_type as $key => $value) { 
                        if(!empty($getParVariationProduct)){ 
                          if($getParVariationProduct->product_ID_type==$key){ 
                            echo ucfirst($value); 
                          } 
                        }
                      }
                    ?>
                 </div>
              </div>

              <div class="form-group">
                 <label class="col-md-2 control-label">Base Price :</label>
                 <div class="col-sm-9">
                    <?php 
                      if(!empty($getParVariationProduct->base_price)){ 
                        echo '$'.number_format($getParVariationProduct->base_price,2); 
                      }else{ 
                        echo "$0.00"; 
                      } 
                     ?>
                 </div>
              </div>

              <div class="form-group">
                 <label class="col-md-2 control-label">Sell Price :</label>
                 <div class="col-sm-9">
                    <?php 
                      if(!empty($getParVariationProduct->sell_price)){ 
                        echo '$'.number_format($getParVariationProduct->sell_price,2); 
                      }else{ 
                        echo "$0.00"; 
                      } 
                     ?>
                 </div>
              </div>

              <div class="form-group">
                 <label class="col-md-2 control-label">Quantity :</label>
                 <div class="col-md-9">
                    <?php if(!empty($getParVariationProduct->quantity)){ echo ucfirst($getParVariationProduct->quantity); }else{ echo '0'; } ?>
                 </div>
              </div>

              <div class="form-group">
               <label class="col-md-2 control-label">Warranty Description :</label>
               <div class="col-md-9">
                  <?php if(!empty($product_variationsData->warranty_description)){ echo ucfirst($product_variationsData->warranty_description); }else{ echo '-'; } ?>
               </div>
            </div>


            <div class="form-group">
               <label class="col-md-2 control-label">Seller Description :</label>
               <div class="col-md-9">
                   <?php if(!empty($product_variationsData->seller_description)){ echo ucfirst($product_variationsData->seller_description); }else{ echo '-'; } ?>
               </div>
            </div>

            <?php 
              } }
           } 
           ?>

         <br>
            <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i> Other Offer Info :</header>
            <br>

            <div class="form-group">
               <label class="col-md-2 control-label">Maximun Retail Price :</label>
               <div class="col-sm-9">
                   <div class="input-group">
                     <?php 
                      if(!empty($product_offerOtherInfo->maximum_retail_price)){ 
                        echo '$'.number_format($product_offerOtherInfo->maximum_retail_price,2); 
                      }else{ 
                        echo "$0.00"; 
                      } 
                     ?>
                   </div>
               </div>
            </div>

            <div class="form-group">
               <label class="col-md-2 control-label">Sale Price :</label>
               <div class="col-sm-9">
                   <?php 
                      if(!empty($product_offerOtherInfo->sale_price)){ 
                        echo '$'.number_format($product_offerOtherInfo->sale_price,2); 
                      }else{ 
                        echo "$0.00"; 
                      } 
                     ?>
               </div>
            </div>


            <div class="form-group">
               <label class="col-md-2 control-label">Sale Start Date :</label>
               <div class="col-sm-9">
                   <?php if(!empty($product_offerOtherInfo->sale_start_date)){ echo date('d-m-Y',strtotime($product_offerOtherInfo->sale_start_date)); }else{ echo "-"; } ?>
               </div>
            </div>


            <div class="form-group">
               <label class="col-md-2 control-label">Sale End Date :</label>
               <div class="col-sm-9">
                   <?php if(!empty($product_offerOtherInfo->sale_end_date)){ echo date('d-m-Y',strtotime($product_offerOtherInfo->sale_end_date)); }else{ echo "-"; } ?>
               </div>
            </div>


            <div class="form-group">
               <label class="col-md-2 control-label">Can Be Gift Messaged :</label>
               <div class="col-md-9">
                  <?php if(!empty($product_offerOtherInfo) && $product_offerOtherInfo->can_be_gift_messaged==1){ echo "Yes"; }elseif(!empty($product_offerOtherInfo) && $product_offerOtherInfo->can_be_gift_messaged==0){ echo "No"; }else{ echo "-"; } ?>
               </div>
            </div>

            <div class="form-group">
               <label class="col-md-2 control-label">Is Gift Wrap Available? :</label>
               <div class="col-md-9">
                  <?php if(!empty($product_offerOtherInfo) && $product_offerOtherInfo->is_gift_wrap_available==1){ echo "Yes"; }elseif(!empty($product_offerOtherInfo) && $product_offerOtherInfo->is_gift_wrap_available==0){ echo "No"; }else{ echo "-"; } ?>
               </div>
            </div>


            <div class="form-group">
               <label class="col-md-2 control-label">Fulfillment Channel :</label>
               <div class="col-md-9">

                  <?php if(!empty($product_offerOtherInfo) && $product_offerOtherInfo->fulfillment_channel==1){ echo "I want to ship this item myself or use COPICO Easy Ship if it sells."; }elseif(!empty($product_offerOtherInfo) && $product_offerOtherInfo->fulfillment_channel==2){ echo "I want to use Fulfilled by COPICO to ship my items if they sell."; }else{ echo "-"; } ?>
               </div>
            </div>


            <div class="form-actiosns fluid">
                <div class="form-btn-block">
                   <div class="col-md-12 text-center">
                      <?php if($type==1){ ?>
                      <a class="btn btn-danger" href="<?php echo base_url('backend/products/edit_product_basic_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type); ?>">Back</a>
                      <?php } ?>
                   </div>
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