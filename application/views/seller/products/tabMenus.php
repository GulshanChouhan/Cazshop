<?php
      $segment1 = $this->uri->segment(1);
      $segment2 = $this->uri->segment(2);
      $segment3 = $this->uri->segment(3);

      $productCat = "";
      $productVitalInfo    = "";
      $productVariation    = "";
      $productOfferInfo    = "";
      $productOtherInfo    = "";
      $productImg          = "";
      $productDescription  = "";
      $productKeywords     = "";
      $productSEO          = "";

      if($segment1=='seller' && $segment2=='products' && ($segment3=='product_category' || $segment3=='edit_product_category')){
            $productCat = 'active';
      }
      if($segment1=='seller' && $segment2=='products' && ($segment3=='product_basic_info' || $segment3=='edit_product_basic_info')){
            $productVitalInfo = 'active';
      }
      if($segment1=='seller' && $segment2=='products' && $segment3=='product_variations'){
            $productVariation = 'active';
      }
      if($segment1=='seller' && $segment2=='products' && $segment3=='product_offer'){
            $productOfferInfo = 'active';
      }
      if($segment1=='seller' && $segment2=='products' && $segment3=='product_other_info'){
            $productOtherInfo = 'active';
      }
      if($segment1=='seller' && $segment2=='products' && $segment3=='product_images'){
            $productImg = 'active';
      }
      if($segment1=='seller' && $segment2=='products' && $segment3=='product_descriptions'){
            $productDescription = 'active';
      }
      if($segment1=='seller' && $segment2=='products' && $segment3=='product_keywords'){
            $productKeywords = 'active';
      }
      if($segment1=='seller' && $segment2=='products' && $segment3=='product_seo'){
            $productSEO = 'active';
      }
?>
<ul class="nav-common-tabs" role="tablist">

      <?php 
            if($type==1){

                  if(!empty($product_info_id) && !empty($product_variation_id)){
      ?>
            <li class="<?php echo $productCat; ?>">
                  <a href="<?php echo base_url().'seller/products/edit_product_category/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><div><i class="icofont icofont-chart-flow-alt-1"></i></div>Product Categories</a>
            </li>

            <li  class="<?php echo $productVitalInfo; ?>">
                  <a href="<?php echo base_url().'seller/products/edit_product_basic_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><div><i class="icofont icofont-info-square"></i></div>Vital Info</a>
            </li>

            <li  class="<?php echo $productOfferInfo; ?>">
                  <a href="<?php echo base_url().'seller/products/product_offer/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><div><i class="icofont icofont-gift"></i></div>Product Definition/Offer</a>
            </li>

            <li  class="<?php echo $productOtherInfo; ?>"><a href="<?php echo base_url().'seller/products/product_other_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><div><i class="icofont icofont-presentation-alt"></i></div>Compliance</a>
            </li>

            <li  class="<?php echo $productImg; ?>"><a href="<?php echo base_url().'seller/products/product_images/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><div><i class="icofont icofont-image"></i></div>Images/Videos</a>
            </li>

            <li  class="<?php echo $productDescription; ?>"><a href="<?php echo base_url().'seller/products/product_descriptions/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><div><i class="icofont icofont-list"></i></div>Product Description</a>
            </li>

            <li  class="<?php echo $productKeywords; ?>"><a href="<?php echo base_url().'seller/products/product_keywords/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><div><i class="icofont icofont-key"></i></div>Keywords</a>
            </li>

            <li  class="<?php echo $productSEO; ?>"><a href="<?php echo base_url().'seller/products/product_seo/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><div>
            <i class="icofont icofont-stock-search"></i></div>Meta Information</a></li>

      <?php       }
            }elseif ($type==2) {

                  if(!empty($product_info_id) && $product_variation_id==0){ 
      ?>
            <li class="<?php echo $productCat; ?>"><a href="<?php echo base_url().'seller/products/edit_product_category/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><div><i class="icofont icofont-chart-flow-alt-1"></i></div>Product Categories</a>
            </li>

            <li class="<?php echo $productVitalInfo; ?>"><a href="<?php echo base_url().'seller/products/edit_product_basic_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><div><i class="icofont icofont-info-square"></i></div>Vital Info</a>
            </li>

            <li class="<?php echo $productVariation; ?>"><a href="<?php echo base_url().'seller/products/product_variations/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><div><i class="icofont icofont-document-search"></i></div>Variation</a>
            </li>

            <li class="<?php echo $productOtherInfo; ?>"><a href="<?php echo base_url().'seller/products/product_other_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><div><i class="icofont icofont-presentation-alt"></i></div>Compliance</a>
            </li>

            <li class="<?php echo $productDescription; ?>"><a href="<?php echo base_url().'seller/products/product_descriptions/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><div><i class="icofont icofont-list"></i></div>Product Description</a>
            </li>

            <li class="<?php echo $productKeywords; ?>"><a href="<?php echo base_url().'seller/products/product_keywords/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><div><i class="icofont icofont-key"></i></div>Keywords</a>
            </li>

            <li class="<?php echo $productSEO; ?>"><a href="<?php echo base_url().'seller/products/product_seo/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><div>
            <i class="icofont icofont-stock-search"></i></div>Meta Information</a>
            </li>


      <?php        }elseif (!empty($product_info_id) && $product_variation_id!=0) { 
      ?>
            <li style="width: 15.5%" class="<?php echo $productOfferInfo; ?> show-tab-2"><a href="<?php echo base_url().'seller/products/product_offer/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><div><i class="icofont icofont-gift"></i></div>Product Definition/Offer</a>
            </li>

            <li style="width: 15.5%" class="<?php echo $productImg; ?> show-tab-2"><a href="<?php echo base_url().'seller/products/product_images/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><div><i class="icofont icofont-image"></i></div>Images</a>
            </li>
      <?php       } 
            }elseif ($type==3) {
              if(!empty($product_info_id) && $product_variation_id==0){
      ?>

            <li class="<?php echo $productCat; ?>"><a href="<?php echo base_url().'seller/products/edit_product_category/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><div><i class="icofont icofont-chart-flow-alt-1"></i></div>Product Categories</a>
            </li>

            <li  class="<?php echo $productVitalInfo; ?>"><a href="<?php echo base_url().'seller/products/edit_product_basic_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><div><i class="icofont icofont-info-square"></i></div>Vital Info</a>
            </li>

            <?php if($this->session->userdata('chooseProductType')==2){ ?>
            <li class="<?php echo $productVariation; ?>"><a href="<?php echo base_url().'seller/products/product_variations/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><div><i class="icofont icofont-document-search"></i></div>Variation</a>
            </li>
            <?php } ?>

            <?php if($this->session->userdata('chooseProductType')==1){ ?>
            <li class="<?php echo $productOfferInfo; ?>"><a href="<?php echo base_url().'seller/products/product_offer/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><div><i class="icofont icofont-gift"></i></div>Product Definition/Offer</a>
            </li>
            <?php } ?>

            <li  class="disabled" style="pointer-events: none;"><a href="<?php echo base_url().'seller/products/product_other_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><div><i class="icofont icofont-presentation-alt"></i></div>Compliance</a>
            </li>

            <li  class="disabled" style="pointer-events: none;"><a href="<?php echo base_url().'seller/products/product_images/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><div><i class="icofont icofont-image"></i></div>Images/Videos</a>
            </li>

            <li  class="disabled" style="pointer-events: none;"><a href="<?php echo base_url().'seller/products/product_descriptions/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><div><i class="icofont icofont-list"></i></div>Product Description</a>
            </li>

            <li  class="disabled" style="pointer-events: none;"><a href="<?php echo base_url().'seller/products/product_keywords/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><div><i class="icofont icofont-key"></i></div>Keywords</a>
            </li>

            <li  class="disabled" style="pointer-events: none;"><a href="<?php echo base_url().'seller/products/product_seo/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><div>
            <i class="icofont icofont-stock-search"></i></div>Meta Information</a>
            </li>

      <?php       }
            } 
      ?>

</ul>