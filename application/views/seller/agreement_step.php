<br>
<div class="body-container clearfix">
   <div class="theme-container clearfix">
      <div class="clearfix"></div>
      <div class="col-md-12 col-lg-12">
         <div class="common-tab-wrapper seller-tab-wrapper">
            <div class="common-contain-wrapper clearfix">
               <div class="">

                  <div class="step1 seller-panel panel" style="display: <?php if(!empty($sellerInfo->business_name)) echo "block"; else echo "none"; ?>">
                     <div class="panel-heading">
                        <div class="panel-title"><i class="icofont icofont-ui-clip-board"></i> Register and Start Selling</div>
                     </div>
                     <div class="panel-body register-selling-panel">
                        <div class="col-sm-7 center-block">
                           <div class="form-group">
                              <h4>Please ensure that all the information you submit is accurate.</h4>
                              <h4><b>Enter the legal business name below to continue</b></h4>
                           </div>
                           <form id="loginform" method="post" class="" role="form" action="<?php echo current_url(); ?>">
                              <div class="form-group">
                                 <input id="login-username" type="text" class="form-control" name="business_name" value="<?php if(!empty($sellerInfo->business_name)) echo $sellerInfo->business_name; else echo set_value('business_name'); ?>" placeholder="Example: Tessa Scott's Cupcakes" data-bvalidator="required" data-bvalidator-msg="Please enter your Legal Business Name.">         
                                 <?php echo form_error('business_name'); ?>
                                 <p>If registering on behalf of a business, enter the business legal name.</p>
                              </div>
                              <div class="form-group terms-checkbox">
                                 <span class="checkbox-input">
                                 <input class="styled" type="checkbox" name="accept_TAC" id="accept_TAC" value="1" data-bvalidator="required" data-bvalidator-msg="Please accept the agreement.">
                                 <label for="accept_TAC"></label>
                                 </span>    
                                 <?php echo form_error('accept_TAC'); ?>
                                 <span>I have read and agree to comply with and/or be bound by the terms and conditions of <a href="<?php echo base_url('seller/page/terms-and-condition'); ?>" target="popup" onclick="window.open('<?php echo base_url('seller/page/terms-and-condition'); ?>','popup','width=600,height=600'); return false;"><?php echo ucwords(SITE_NAME); ?> Services Business Solutions Agreement</a></span>                             
                              </div>
                              <br>
                              <div class="form-group text-center">
                                 <button class="btn btn-red btn-continue"><span>Continue</span></button>
                                 <a class="btn btn-skip" href="<?php echo base_url('seller/skip/phone_verification/'.$encrypted_id); ?>">Remind me later</a>
                              </div>
                              <div class="divider-separator"></div>
                              <div class="text-center font16">
                                 <span>If you want to login with other account ?</span>
                                 <a class="link-text" href="<?php echo base_url('seller/logout'); ?>"><b>Click Here</b></a>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>

                  <div class="step2 seller-panel panel" style="display: <?php if(!empty($sellerInfo->business_name)) echo "none"; else echo "block"; ?>">
                     <div class="panel-body register-selling-panel">
                        <div class="col-sm-8 center-block">
                           <div class="almost-done-wrapper">
                              <img src="<?php echo SELLER_THEME_URL?>img/checked-mark.svg">
                              <h4>Congrats, You have registered successfully.</h4>
                              <div class="sub-heading">Few steps are remaining which will let us know about your business.</div>
                              <div class="sub-heading">You must have to complete all those steps.</div>
                              <div class="sub-heading">To complete those steps <a class="completePro" href="javascript:void(0)">Click here</a></div>
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
      setTimeout(function(){ 
         $('.step2').hide();
         $('.step1').show();
      }, 10000);
   });

   $(".completePro").click(function(){
      $('.step2').hide();
      $('.step1').show();
   });
</script>