<?php 
  $data2['sellerInfo'] = $sellerInfo;
  $data2['business_info'] = $business_info;
  $data2['seller_interview'] = $seller_interview;
  $data2['seller_signature_and_licence'] = $seller_signature_and_licence;
  $data2['encrypted_id'] = $encrypted_id; 
  $this->load->view('seller/steps/menus', $data2); 
?>

<div class="common-contain-wrapper clearfix">
  <div class="">
      <div class="seller-panel panel">
        <div class="panel-heading">
          <div class="panel-title"><i class="icofont icofont-ui-clip-board"></i> Account Verification</div>
        </div>
         <div class="panel-body">
          <div class="col-sm-12 custom-center-block">
               <form id="signLicence" method="post" class="step1" role="form" enctype="multipart/form-data">
                  <div class="col-md-12">
                    <div class="highlight-info-box clearfix">
                      <h4 class="color-red">Attachment file types for an account verification that is mentioned below -</h4>
                      <ul>
                         <li>
                            Accepted file types is <b>.JPG</b>, <b>.JPEG</b>, <b>.PNG</b>, <b>.DOC</b>, <b>.PDF</b> and Max file Size 5024*5024.
                         </li>
                         <li>
                            Seller will need to upload a photo/scan of two types of documents, as per the list below, and submit them to us.
                         </li>
                      </ul>
                    </div>
                    <br>
                  </div>
                  <div class="form-group col-md-6">
                    <label>Proof of Name and D.O.B</label>
                      <select class="form-control" name="proof_of_name" data-bvalidator="">
                        <option value="">--Select--</option>
                        <?php $proof_of_name_and_dob = proof_of_name_and_dob('');
                        foreach ($proof_of_name_and_dob as $key => $value) {
                        ?>
                        <option <?php if(set_value('proof_of_name')){ if($key==set_value('proof_of_name')){ echo "selected"; } }else if(!empty($seller_signature_and_licence)){ if($key==$seller_signature_and_licence->proof_of_name){ echo "selected"; } } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php
                        }
                        ?>
                      </select>
                    <?php echo form_error('proof_of_name'); ?>
                  </div>
                  <div class="form-group col-md-6">
                     <label>Attachment - (Proof of Name and D.O.B)</label>
                     <div class="file-upload-wrapper clearfix">
                        <div class="file-upload-input">
                           <input id="CustomUploadFile" class="input-upload" placeholder="Choose File" disabled="disabled" />
                        </div>
                        <div class="file-upload-button">
                            <span>Choose a file…</span>
                            <input type="file" id="CustomUploadBtn" class="custom-file-upload-hidden" name="proof_of_name_attachment" data-bvalidator="extension[jpg:png:jpeg:pdf:doc]" data-bvalidator-msg="Please choose the attachment of Name/DOB with JPG, JPEG, PNG, DOC, PDF format.">
                        </div>
                     </div>
                     <?php echo form_error('proof_of_name_attachment'); ?>
                     <?php if(!empty($seller_signature_and_licence) && !empty($seller_signature_and_licence->proof_of_name_attachment) && file_exists("./assets/uploads/seller/signature_or_licence_copy/proof_of_name_and_DOB/".$seller_signature_and_licence->proof_of_name_attachment)){
                     ?>
                     <a target="_blank" href="<?php echo base_url().'assets/uploads/seller/signature_or_licence_copy/proof_of_name_and_DOB/'.$seller_signature_and_licence->proof_of_name_attachment; ?>">Preview/Download the Attachment (Proof of Name and D.O.B)</a>
                     <?php } ?>
                  </div>
                   <div class="clearfix"></div>
                  <div class="form-group col-md-6">
                     <label>Proof of Address (issued within the last three months)</label>
                     <select class="form-control" name="proof_of_address" data-bvalidator="">
                        <option value="">--Select--</option>
                        <?php $proof_of_address = proof_of_address('');
                        foreach ($proof_of_address as $key => $value) {
                        ?>
                        <option <?php if(set_value('proof_of_address')){ if($key==set_value('proof_of_address')){ echo "selected"; } }else if(!empty($seller_signature_and_licence)){ if($key==$seller_signature_and_licence->proof_of_address){ echo "selected"; } } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php
                        }
                        ?>
                     </select>
                     <?php echo form_error('proof_of_address'); ?>
                  </div>
                  <div class="form-group col-md-6">
                     <label>Attachment - Proof of Address (issued within the last three months)</label>
                     <div class="file-upload-wrapper clearfix">
                        <div class="file-upload-input">
                           <input id="CustomUploadFile1" class="input-upload" placeholder="Choose File" disabled="disabled" />
                        </div>
                        <div class="file-upload-button">
                            <span>Choose a file…</span>
                            <input type="file" id="CustomUploadBtn1" class="custom-file-upload-hidden" name="proof_of_address_attachment" data-bvalidator="extension[jpg:png:jpeg:pdf:doc]" data-bvalidator-msg="Please choose the attachment of Address with JPG, JPEG, PNG, DOC, PDF format.">
                        </div>
                     </div>
                     <?php echo form_error('proof_of_address_attachment'); ?>
                     <?php if(!empty($seller_signature_and_licence) && !empty($seller_signature_and_licence->proof_of_address_attachment) && file_exists("./assets/uploads/seller/signature_or_licence_copy/proof_of_address/".$seller_signature_and_licence->proof_of_address_attachment)){
                     ?>
                   <a target="_blank" href="<?php echo base_url().'assets/uploads/seller/signature_or_licence_copy/proof_of_address/'.$seller_signature_and_licence->proof_of_address_attachment; ?>">Preview/Download the Attachment (Proof of Address - issued within the last three months)</a>
                     <?php } ?>
                  </div>
                  <div class="clearfix"></div>
                  <div class="common-divider"></div>
                  <div class="form-group col-md-6">
                     <label class="">Bitcoin Address</label><br>
                     <input type="text" class="form-control" name="bitcoin_address" value="<?php if(!empty($business_info->bitcoin_address)) echo $business_info->bitcoin_address; else echo set_value('bitcoin_address'); ?>" placeholder="Example: 3QJmV3qfvL9SuYo34YihAf3sRCW3qSinyC" data-bvalidator="" data-bvalidator-msg="You must enter a Bitcoin address.">
                     <?php echo form_error('bitcoin_address'); ?>
                  </div>

                  <div class="form-group col-md-6">
                     <label class="">Ethereum Address</label><br>
                     <input type="text" class="form-control" name="ethereum_address" value="<?php if(!empty($business_info->ethereum_address)) echo $business_info->ethereum_address; else echo set_value('ethereum_address'); ?>" placeholder="Example: 3QJmV3qfvL9SuYo34YihAf3sRCW3qSinyC" data-bvalidator="" data-bvalidator-msg="You must enter a Ethereum address.">
                     <?php echo form_error('ethereum_address'); ?>
                  </div>

                  <div class="form-group col-md-6">
                     <label class="">Litecoin Address</label><br>
                     <input type="text" class="form-control" name="litecoin_address" value="<?php if(!empty($business_info->litecoin_address)) echo $business_info->litecoin_address; else echo set_value('litecoin_address'); ?>" placeholder="Example: 3QJmV3qfvL9SuYo34YihAf3sRCW3qSinyC" data-bvalidator="" data-bvalidator-msg="You must enter a Litecoin address.">
                     <?php echo form_error('litecoin_address'); ?>
                  </div>


                  <div class="form-group col-md-6">
                     <label class="">Cazcoin Addres</label><br>
                     <input type="text" class="form-control" name="cazcoin_address" value="<?php if(!empty($business_info->cazcoin_address)) echo $business_info->cazcoin_address; else echo set_value('cazcoin_address'); ?>" placeholder="Example: 3QJmV3qfvL9SuYo34YihAf3sRCW3qSinyC" data-bvalidator="" data-bvalidator-msg="You must enter a Cazcoin address.">
                     <?php echo form_error('cazcoin_address'); ?>
                  </div>


                  <div class="form-group col-md-6">
                     <label class="">Paypal Primary Email</label><br>
                     <input type="text" class="form-control" name="paypal_primary_email" value="<?php if(!empty($business_info->paypal_primary_email)) echo $business_info->paypal_primary_email; else echo set_value('paypal_primary_email'); ?>" placeholder="Example: johndoe@example.com" data-bvalidator="email" data-bvalidator-msg="You must enter a valid email address">
                     <?php echo form_error('paypal_primary_email'); ?>
                  </div>
                  <div class="clearfix"></div>

                  <!-- Button -->
                  <div class="col-sm-12 controls">
                     <button class="btn btn-red btn-continue"><span><?php if(!empty($seller_signature_and_licence)) echo "Continue"; else echo "Continue"; ?></span></button>
                     <?php
                        $skipped_pages = 0;
                        if(!empty($sellerInfo->skipped)){
                           $skipped = json_decode($sellerInfo->skipped);
                           $skipped_pages = count($skipped->skipped_pages);
                        }
                     ?>
                     <?php if($skipped_pages < 7){ ?>
                     <a class="btn btn-skip" href="<?php echo base_url('seller/skip/seller_dashboard/'.$encrypted_id); ?>">Remind me later</a>
                     <?php }else{ ?>
                     <a class="btn btn-default-white" href="<?php echo base_url('seller/shipment_option/'.base64_encode(seller_id())); ?>">Back</a>
                     <?php } ?>
                  </div>
               </form>
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

   SITE_URL = "<?php echo base_url(); ?>";
   $(document).ready(function(){
      $('#signLicence').bValidator();
   });

</script>
<script type="text/javascript">
$( document ).ready(function() {
      document.getElementById("CustomUploadBtn").onchange = function () {
       document.getElementById("CustomUploadFile").value = this.value;
   };
    document.getElementById("CustomUploadBtn1").onchange = function () {
       document.getElementById("CustomUploadFile1").value = this.value;
   };
});
   
</script>