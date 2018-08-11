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

      if($segment1=='backend' && $segment2=='products' && ($segment3=='product_category' || $segment3=='edit_product_category')){
            $productCat = 'active';
      }
      if($segment1=='backend' && $segment2=='products' && ($segment3=='product_basic_info' || $segment3=='edit_product_basic_info')){
            $productVitalInfo = 'active';
      }
      if($segment1=='backend' && $segment2=='products' && $segment3=='product_variations'){
            $productVariation = 'active';
      }
      if($segment1=='backend' && $segment2=='products' && $segment3=='product_offer'){
            $productOfferInfo = 'active';
      }
      if($segment1=='backend' && $segment2=='products' && $segment3=='product_other_info'){
            $productOtherInfo = 'active';
      }
      if($segment1=='backend' && $segment2=='products' && $segment3=='product_images'){
            $productImg = 'active';
      }
      if($segment1=='backend' && $segment2=='products' && $segment3=='product_descriptions'){
            $productDescription = 'active';
      }
      if($segment1=='backend' && $segment2=='products' && $segment3=='product_keywords'){
            $productKeywords = 'active';
      }
      if($segment1=='backend' && $segment2=='products' && $segment3=='product_seo'){
            $productSEO = 'active';
      }
?>
<ul class="nav nav-tabs " role="tablist">

      <?php 
            if($type==1){
                  if(!empty($product_info_id) && !empty($product_variation_id)){
      ?>
            <li class="<?php echo $productCat; ?>"><a href="<?php echo base_url().'backend/products/edit_product_category/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><b>Product Categories</b></a></li>

            <li  class="<?php echo $productVitalInfo; ?>"><a href="<?php echo base_url().'backend/products/edit_product_basic_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><b>Vital Info</b></a></li>

            <li  class="<?php echo $productOfferInfo; ?>"><a href="<?php echo base_url().'backend/products/product_offer/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><b>Offer</b></a></li>

            <li  class="<?php echo $productOtherInfo; ?>"><a href="<?php echo base_url().'backend/products/product_other_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><b>Compliance</b></a></li>

            <li  class="<?php echo $productImg; ?>"><a href="<?php echo base_url().'backend/products/product_images/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><b> Images</b></a></li>

            <li  class="<?php echo $productDescription; ?>"><a href="<?php echo base_url().'backend/products/product_descriptions/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><b> Product Description</b></a></li>
            <li  class="<?php echo $productKeywords; ?>"><a href="<?php echo base_url().'backend/products/product_keywords/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><b> Keywords</b></a></li> 

            <li  class="<?php echo $productSEO; ?>"><a href="<?php echo base_url().'backend/products/product_seo/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><b>Meta Information</b></a></li>

      <?php       }
            }elseif ($type==2) {
                  if(!empty($product_info_id) && $product_variation_id==0){ 
      ?>
            <li class="<?php echo $productCat; ?>"><a href="<?php echo base_url().'backend/products/edit_product_category/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><b>Product Categories</b></a></li>

            <li class="<?php echo $productVitalInfo; ?>"><a href="<?php echo base_url().'backend/products/edit_product_basic_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><b>Vital Info</b></a></li>

            <li class="<?php echo $productVariation; ?>"><a href="<?php echo base_url().'backend/products/product_variations/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><b>Variation(Variation Theme)</b></a></li>

            <li class="<?php echo $productOtherInfo; ?>"><a href="<?php echo base_url().'backend/products/product_other_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><b>Compliance</b></a></li>

            <li class="<?php echo $productDescription; ?>"><a href="<?php echo base_url().'backend/products/product_descriptions/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><b> Product Description</b></a></li>

           <li class="<?php echo $productKeywords; ?>"><a href="<?php echo base_url().'backend/products/product_keywords/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><b> Keywords</b></a></li> 
            <li class="<?php echo $productSEO; ?>"><a href="<?php echo base_url().'backend/products/product_seo/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><b>Meta Information</b></a></li>


      <?php        }elseif (!empty($product_info_id) && $product_variation_id!=0) { 
      ?>
            <li class="<?php echo $productOfferInfo; ?>"><a href="<?php echo base_url().'backend/products/product_offer/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><b>Offer</b></a></li>

            <li class="<?php echo $productImg; ?>"><a href="<?php echo base_url().'backend/products/product_images/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><b> Images</b></a></li>
      <?php       } 
            }elseif ($type==3) {
                  if(!empty($product_info_id) && $product_variation_id==0){
      ?>

            <li class="<?php echo $productCat; ?>"><a href="<?php echo base_url().'backend/products/edit_product_category/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><b>Product Categories</b></a></li>

            <li  class="<?php echo $productVitalInfo; ?>"><a href="<?php echo base_url().'backend/products/edit_product_basic_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><b>Vital Info</b></a></li>

            <li class="<?php echo $productVariation; ?>"><a href="<?php echo base_url().'backend/products/product_variations/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><b>Variation(Variation Theme)</b></a></li>

            <li  class="<?php echo $productOfferInfo; ?>"><a href="<?php echo base_url().'backend/products/product_offer/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>"><b>Offer</b></a></li>

            <li  class="disabled" style="pointer-events: none;"><a href="<?php echo base_url().'backend/products/product_other_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><b>Compliance</b></a></li>

            <li  class="disabled" style="pointer-events: none;"><a href="<?php echo base_url().'backend/products/product_images/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><b> Images</b></a></li>

            <li  class="disabled" style="pointer-events: none;"><a href="<?php echo base_url().'backend/products/product_descriptions/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><b> Product Description</b></a></li>

            <li  class="disabled" style="pointer-events: none;"><a href="<?php echo base_url().'backend/products/product_keywords/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><b> Keywords</b></a></li> 

            <li  class="disabled" style="pointer-events: none;"><a href="<?php echo base_url().'backend/products/product_seo/'.$product_info_id.'/'.$product_variation_id.'/'.$type; ?>" ><b>Meta Information</b></a></li>

      <?php       }
            } 
      ?>

</ul>