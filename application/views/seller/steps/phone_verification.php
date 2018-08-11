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
            <div class="panel-title"><i class="icofont icofont-iphone"></i> Phone Number Verification</div>
         </div>
         <div class="panel-body">
            <div class="phone-no-verification-wrap">
               <?php if(!empty($sellerInfo) && $sellerInfo->confirmation_code!='verified'){ ?>
               <div style="display: none;" class="alert alert-danger phoneErr">
                  <span id="err"></span>
               </div>
               <div class="main-loader" style='display: none;'>
                   <div class="loader">
                     <svg class="circular-loader" viewBox="25 25 50 50">
                       <circle class="loader-path" cx="50" cy="50" r="20" fill="none" stroke="#f45b69" stroke-width="2.5" />
                     </svg>
                   </div>
               </div>
               <div id="step1" class="">
                  <div class="text-center phone-security-img">
                     <img src="<?php echo SELLER_THEME_URL?>img/Smartphone-Security.svg">
                  </div>
                  <div class="phone-heading">
                     <h4>Verify your phone number to proceed further</h4>
                  </div>
                  <form method="post" class="step1" role="form" data-bvalidator-validate>
                     <div class="a-row number-group">
                        <div class="form-group">
                           <div class="mobile-number-wrapper">
                              <div class="mobile-number-left">
                                 <select name="country_code" id="country_code" class="form-control">
                                    <?php
                                       if(!empty($phnCode)){
                                       foreach ($phnCode as $row){
                                       ?>
                                    <option <?php if(!empty($user->country_code)){ if($user->country_code==$row->phonecode){ echo "selected"; } }else if($row->phonecode=='91'){ echo "selected"; } ?> value="<?php echo $row->phonecode; ?>"><?php echo $row->sortname.' +'.$row->phonecode; ?></option>
                                    <?php
                                       } }
                                       ?>
                                 </select>
                              </div>
                              <div class="mobile-number-right">
                                 <input type="text" class="form-control" id="phone_no" name="phone_no" value="" placeholder="09987654321" data-bvalidator="maxlen[13],minlen[9],number,required" data-bvalidator-msg="Please enter a valid phone no.">
                                 <?php echo form_error('mobile'); ?>
                              </div>
                           </div>
                        </div>
                        <!-- Button -->
                        <div class="text-center controls">
                           <button type="submit" class="btn btn-red stepone_btn" id="step1Btn">Verify via SMS</button>
                        </div>
                     </div>
                  </form>
                  <div class="clearfix"></div>
                  <div class="phone-bottom-text">We will send a verification code via <b>SMS</b> to your phone number.</div>
               </div>
               <div id="step2" class="" style="display: none">
                  <div class="text-center phone-security-img">
                     <img src="<?php echo SELLER_THEME_URL?>img/Smartphone-Security.svg">
                  </div>
                  <div class="phone-heading">
                     <h4>Enter a verification code</h4>
                  </div>
                  <div class="phone-bottom-text">An SMS has been sent to your Phone Number.</div>
                  <!-- <div style="display: none;" class="code-phone-success phoneSucc">
                     <strong>Your Verification Code - <span id="cc"></span></strong>
                  </div> -->
                  <form method="post" class="step2" role="form" data-bvalidator-validate>
                     <div class="a-row number-group">
                        <div class="form-group">
                           <input type="text" class="form-control" data-bvalidator="required" data-bvalidator-msg="Please enter a valid Verification Code" name="verify_no" value="" placeholder="Enter 6 digit code here">
                           <?php echo form_error('verify_no'); ?>
                        </div>
                        <!-- Button -->
                        <div class="text-center controls">
                           <button type="submit" class="btn btn-red steptwo_btn">Verify</button>
                        </div>
                     </div>
                  </form>
                  <div class="clearfix"></div>
                  <div class="verification-code-wrap">
                     A One Time Passcode has been sent to <span class="cnc">+91</span><span class="phn">25478XXXXX1</span> | <a href="javascript:void(0)" class="resendCode">Resend Code</a> | <a class="changeNo" href="javascript:void(0)">Change Number</a>
                  </div>
               </div>
               <?php }else{ ?>
               <div class="col-md-12">
                  <div class="text-center">
                     <div class="text-center phone-security-img">
                        <img src="<?php echo SELLER_THEME_URL?>img/Smartphone-Security-Check.svg">
                     </div>
                     <div class="phone-heading">
                        <h4>Your phone number is verified</h4>
                     </div>
                  </div>
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
<style>
.main-loader{
    position: absolute;
    z-index: 11; 
    width: 100%;
    background: rgba(255, 255, 255, 0.56);
    text-align: center;
    height: 70%;
    left: 0;
}
</style>
<script>
  SITE_URL = "<?php echo base_url(); ?>";
  $(document).ready(function() {
      $('.step1').bValidator();
      $('.step2').bValidator();
  });

  
  $('.stepone_btn').on('click', function() {
      if ($('.step1').data('bValidator').isValid()) {
          $('.stepone_btn').attr('disabled','disabled');
          $('.main-loader').show();
          var id = '<?php echo $encrypted_id; ?>';
          var phone = $('#phone_no').val();
          var country_code = $('#country_code').val();

          $.ajax({
              type: 'POST',
              url: SITE_URL + 'seller/generateConfirmation',
              async: false,
              data: {
                  'id': id,
                  'phone': phone,
                  'country_code': country_code
              },
              success: function(data) {
                  data = jQuery.parseJSON(data);
                  $('.main-loader').hide();
                  $('.stepone_btn').removeAttr('disabled');
                  if (data.status == 'success') {
                      $('.cnc').text('+' + country_code);
                      $('.phn').text(phone);
                      $('#step1').hide();
                      $('#step2').show();
                      $('.phoneSucc').show();
                      $('#cc').html(data.code);
                      successMsg("OTP Code has been sent successfully");
                  } else {
                      $('#step1').show();
                      $('#step2').hide();
                      $('.phoneSucc').hide();
                      errorMsg(data.msg);
                  }
              }
          });
          return false;
      }
  });

  $('.resendCode').click(function() {
      var id = '<?php echo $encrypted_id; ?>';
      var phone = $('.phn').text();
      var country_code = $('.cnc').text();

      if(id!='' && phone!='' && country_code!=''){
        $('.main-loader').show();
        $.ajax({
            type: 'POST',
            url: SITE_URL + 'seller/generateConfirmation',
            async: false,
            data: {
                'id': id,
                'phone': phone,
                'country_code': country_code
            },
            success: function(data) {
                $('.main-loader').hide();
                data = jQuery.parseJSON(data);
                if (data.status == 'success') {
                    $('.cnc').text(country_code);
                    $('.phn').text(phone);
                    $('#step1').hide();
                    $('#step2').show();
                    $('.phoneSucc').show();
                    $('#cc').html(data.code);
                    successMsg("OTP Code has been resent successfully");
                } else {
                    $('#step1').show();
                    $('#step2').hide();
                    $('.phoneSucc').hide();
                    errorMsg(data.msg);
                }
            }
        });
        return false;
      }else{
        errorMsg('Something went wrong. Please try again');
      }

  });

  $('.changeNo').on('click', function() {
      $('#step1').show();
      $('#step2').hide();
  });

  $('.steptwo_btn').on('click', function() {
      $('.step2').bValidator();
      if ($('.step2').data('bValidator').isValid()) {
        $('.main-loader').show();
        $('.steptwo_btn').attr('disabled','disabled');
        var id = '<?php echo $encrypted_id; ?>';
        var verify_no = $('input[name="verify_no"]').val();
        $.ajax({
            type: 'POST',
            url: SITE_URL + 'seller/confirmPhoneCheck',
            async: false,
            data: {
                'id': id,
                'verify_no': verify_no
            },
            success: function(data) {
                $('.main-loader').hide();
                $('.steptwo_btn').removeAttr('disabled');
                data = jQuery.parseJSON(data);
                if (data.status == 'success') {
                    successMsg(data.msg);
                    setTimeout(function(){
                        $(location).attr('href', '<?php echo base_url("seller/seller_information/".$encrypted_id); ?>');
                    }, 2000);
                } else {
                    errorMsg(data.msg);
                }
            }
        });
        return false;
      }
  });
</script>