<?php
    $segment1 = $this->uri->segment(1);
    $segment2 = $this->uri->segment(2);
    $segment3 = $this->uri->segment(3);

    $phoneVerification   = "";
    $sellerInfo1         = "";
    $sellerInterview     = "";
    $shipmentOption      = "";
    $signatureLicence    = "";
    $sellerDashboard     = "";

    if($segment1=='seller' && $segment2=='phone_verification'){
          $phoneVerification = 'active';
    }
    if($segment1=='seller' && $segment2=='seller_information'){
          $sellerInfo1 = 'active';
    }
    if($segment1=='seller' && $segment2=='seller_interview'){
          $sellerInterview = 'active';
    }
    if($segment1=='seller' && $segment2=='shipment_option'){
          $shipmentOption = 'active';
    }
    if($segment1=='seller' && $segment2=='signature_or_licence'){
          $signatureLicence = 'active';
    }
    if($segment1=='seller' && $segment2=='seller_dashboard'){
          $sellerDashboard = 'active';
    }

    if(!empty($sellerInfo->skipped)){
      $skipped = json_decode($sellerInfo->skipped);
      $countPage = count($skipped->skipped_pages);
    }
?>

<br>
<div class="body-container clearfix">
<div class="theme-container clearfix">
  <div class="clearfix"></div>
  <div class="col-md-12 col-lg-12">
    <div class="common-tab-wrapper seller-tab-wrapper">
      <div class="common-tab-system seller-tab-system partners clearfix">
        <ul class="nav-common-tabs" role="tablist">
          
          <?php if($sellerInfo->confirmation_code!='verified'){ ?> 
          <li <?php if($sellerInfo->confirmation_code!='verified'){ ?> class="<?php echo $phoneVerification; ?>" style="pointer-events: none;" <?php }else{ ?> class="compTab <?php echo $phoneVerification; ?>" <?php } ?>>
            <a href="<?php echo base_url().'seller/phone_verification/'.$encrypted_id; ?>">
              <div><i class="icofont icofont-iphone"></i></div>
             <span>Phone Verification</span>
            </a>
          </li>
          <?php } ?>

          <li <?php if($sellerInfo->confirmation_code!='verified' || $countPage<3){ ?> class="disabled" style="pointer-events: none;" <?php }else{ ?> class="compTab <?php echo $sellerInfo1; ?>" <?php } ?>>
            <a href="<?php echo base_url().'seller/seller_information/'.$encrypted_id; ?>">
              <div><i class="icofont icofont-shopping-cart"></i></div>
             <span>Store Information</span>
            </a>
          </li>

          <li <?php if($sellerInfo->confirmation_code!='verified' || $countPage<4){ ?> class="disabled" style="pointer-events: none;" <?php }else{ ?> class="compTab <?php echo $sellerInterview; ?>" <?php } ?>>
             <a href="<?php echo base_url().'seller/seller_interview/'.$encrypted_id; ?>">
                <div><i class="icofont icofont-user-alt-5"></i></div>
                <span>Seller Interview</span>
             </a>
          </li>

          <li <?php if($sellerInfo->confirmation_code!='verified' || $countPage<5){ ?> class="disabled" style="pointer-events: none;" <?php }else{ ?> class="compTab <?php echo $shipmentOption; ?>" <?php } ?>>
            <a href="<?php echo base_url().'seller/shipment_option/'.$encrypted_id; ?>">
              <div><i class="icofont icofont-truck-loaded"></i></div>
              <span>Shipment Option</span>
            </a>
          </li>

          <li <?php if($sellerInfo->confirmation_code!='verified' || $countPage<6){ ?> class="disabled" style="pointer-events: none;" <?php }else{ ?> class="compTab <?php echo $signatureLicence; ?>" <?php } ?>>
            <a href="<?php echo base_url().'seller/signature_or_licence/'.$encrypted_id; ?>">
              <div><i class="icofont icofont-ui-clip-board"></i></div>
              <span>Account Verification</span>
            </a>
          </li>

          <li <?php if($sellerInfo->confirmation_code!='verified' || $countPage<7){ ?> class="disabled" style="pointer-events: none;" <?php }else{ ?> class="compTab <?php echo $sellerDashboard; ?>" <?php } ?>>
            <a href="<?php echo base_url().'seller/seller_dashboard/'.$encrypted_id; ?>">
               <div><i class="icofont icofont-dashboard"></i></div>
             <span>Dashboard</span>
            </a>
          </li>

        </ul>
      </div>