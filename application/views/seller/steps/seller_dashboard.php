<?php 
  $data2['sellerInfo'] = $sellerInfo;
  $data2['business_info'] = $business_info;
  $data2['seller_interview'] = $seller_interview;
  $data2['seller_signature_and_licence'] = $seller_signature_and_licence;
  $data2['encrypted_id'] = $encrypted_id; 
  $this->load->view('seller/steps/menus', $data2); 
?>
<div class="common-contain-wrapper clearfix">
   <div class="seller-panel panel">
      <div class="panel-body">
         <div class="col-sm-12">
            <div class="step-dashboard-section">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="row">
                        <div class="col-sm-12 col-md-6 common-width">
                           <div class="box">
                              <div class="inner-box-block">
                                 <img src="<?php echo SELLER_THEME_URL; ?>/img/icons/checklist.svg" width="50">
                                 <div class="setp-dashboard-heading">
                                    <h4>Create your <?php echo SITE_NAME; ?> listings</h4>
                                    <p class="sub-heading">List the products you wish to sell on <?php echo SITE_NAME_WITH_EXTENTION; ?></p>
                                 </div>
                              </div>
                              <div class="dash-setp-block">
                                 <?php
                                   $getCatgoryNames = ""; 
                                   $category = (!empty($business_info->category)) ? json_decode($business_info->category) : '';
                                   if($category){
                                     $getCatgoryNames = getCatgoryNames($category);
                                   }
                                 ?>
                                 <h5>Start selling in these categories:</h5>
                                 <p>Want to edit the categories <?php //echo $getCatgoryNames; ?> <a href="<?php echo base_url().'seller/seller_information/'.$encrypted_id; ?>" class="link-text"><i class="icofont icofont-edit"></i></a></p>
                              </div>
                              <div class="listing-categories-wrapper">
                                 <!-- <div class="categories-tagilink">
                                    <a href="<?php //echo base_url().'seller/seller_information/'.$encrypted_id; ?>" class="link-text">Edit Categories</a>
                                 </div> -->
                                 <div class="start-listing-btn sell-dash-btn-wrap">
                                    <a href="<?php echo base_url().'seller/products/product_category' ?>" class="btn btn-red">Start Listing</a>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-12 col-md-6 common-width">
                           <div class="box">
                              <div class="inner-box-block">
                                 <img src="<?php echo SELLER_THEME_URL; ?>/img/icons/delivery-truck.svg" width="50">
                                 <div class="setp-dashboard-heading">
                                    <h4>Set your shipping rates</h4>
                                    <p class="sub-heading">Set the shipping rate you want to charge to buyers</p>
                                 </div>
                              </div>
                              <div class="dash-setp-block">
                                 <h5>Set your shipping rates:</h5>
                                 <p>Normal, Express <a href="<?php echo base_url().'seller/shipment_option/'.$encrypted_id; ?>" class="link-text"><i class="icofont icofont-edit"></i></a></p>
                              </div>
                              <div class="set-rates-wrapper">
                                 <!-- <div class="shipping-rates">
                                    <h5 class="font16">Set your shipping rates</h5>
                                 </div> -->
                                 <div class="set-rates sell-dash-btn-wrap">
                                    <a href="<?php echo base_url('seller/country_rates'); ?>" class="btn btn-red">Set Rates</a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- <div class="col-sm-6">
                     <div class="row">
                        <div class="box">
                           <div class="inner-box-block">
                              <img src="<?php echo SELLER_THEME_URL; ?>/img/icons/contract.svg" width="50">
                              <div class="setp-dashboard-heading">
                                 <h4>3. Enter Tax Details</h4>
                                 <p class="sub-heading">Update your Tax Details:</p>
                              </div>
                              <div class="tax-details-wrapper clearfix">
                                 <form action="" method="get" accept-charset="utf-8">
                                    <div class="form-group col-sm-6">
                                       <label for="pan-number">PAN Number</label>
                                       <input type="text" class="form-control" id="pan-number" placeholder="Example : AAAPL1234C">
                                    </div>
                                    <div class="form-group col-sm-6">
                                       <label for="provisional-gstin">Provisional GSTIN</label>
                                       <input type="text" class="form-control" id="provisional-gstin" placeholder="Example : 22AAAAA0000A1Z5">
                                    </div>
                                    <div class="save-tax-details">
                                       <a href="#" class="btn btn-red">Save</a>
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                        <div class="col-sm-12">
                           <div class="box">
                              <div class="inner-box-block">
                                 <img src="<?php echo SELLER_THEME_URL; ?>/img/icons/signature.svg" width="50">
                                 <div class="setp-dashboard-heading">
                                    <h4>Digital Image Signature</h4>
                                    <p class="sub-heading">Upload a scan copy of your signature which will be used on the invoices sent to customers</p>
                                 </div>
                              </div>
                              <div class="digital-signature-wrapper clearfix">
                                 <div class="digital-image-upload-preview col-sm-6">
                                    <div class="fileinput digital-fileinput-new">
                                       <div class="digital-fileinput-preview thumbnail" data-trigger="fileinput">
                                          <img class="upload-default-image" src="<?php echo SELLER_THEME_URL; ?>/img/uploadfile-img.svg">
                                          <p>Upload Digital Image Signature</p>
                                          <div class="digital-image-upload-footer">
                                             <input class="digital-imgUpload" name="image[]" type="file">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="clearfix"></div>
                                 </div>
                                 <div class="signature-instruction col-sm-6">
                                    <h5>What to upload ?</h5>
                                    <ul>
                                       <li>Sign on a white paper, scan the signature and upload the image.</li>
                                       <li>Signature should be legible and in focus.</li>
                                       <li>Only upload PNG, JPG or JPEG image format.</li>
                                       <li>Image size should not exceed 2mb.</li>
                                    </ul>
                                 </div>
                                 <div class="clearfix"></div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div> -->
               </div>
               <!-- <div class="text-center launch-your-business-btn">
                  <a class="btn btn-red btn-lg" href="<?php //echo base_url('seller/login_though_sellerDashboard/'.$encrypted_id); ?>">Launch your business</a>
                 <a class="btn btn-primary" href="<?php //echo base_url('seller/country_rates'); ?>">Want to set shipping rates globally</a>
               </div> -->
            </div>
         </div>
      </div>
   </div>
</div>
</div>
</div>
</div>
</div>