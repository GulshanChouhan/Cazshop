<section class="account-page" id="autoScrollDiv">
	<div class="join-now-bg contact-us-wrapper text-center">
		<h1 class="heading">Get In Touch</h1>
		<h3 class="sub-heading">New Ways to Choose Your Product and Ignore the Rest</h3>
	</div>
	<div class="join-now-container contact-us-page">
		<div class="a-row">
			<div class="contact-form-right">
				<div class="contact-form-right-inner">
					<h4 class="heading">Contact Information</h4>
					<div class="contactus-details">
					
						<!-- <div class="link-detail">
							<a>
								<img src="<?php //echo FRONTEND_THEME_URL ?>img/icons/contact-page-placeholder.svg" width="20">
								<?php //echo get_option_url('ADDRESS'); ?>
							</a>
						</div> -->
						<!-- <div class="link-detail">
							<a href="tel:202-555-0111">
								<img src="<?php //echo FRONTEND_THEME_URL ?>img/icons/contact-page-smartphone.svg" width="20">
								<?php //echo get_option_url('PHONE'); ?>
							</a>
						</div> -->
						<div class="link-detail">
							<a href="mailto:<?php echo get_option_url('SUPPORT_EMAIL'); ?>">
								<img src="<?php echo FRONTEND_THEME_URL ?>img/icons/contact-page-contact.svg" width="20">
								<?php echo get_option_url('SUPPORT_EMAIL'); ?>
							</a>
						</div>
					</div>
					<div class="footer-social-media contact-social-media">
                        <ul class="list-unstyled link-list">
                            <li>
                                <a target="_blank" href="<?php echo get_option_url('FACEBOOK_URL'); ?>" title="Facebook">
                                    <i class="fa fa-facebook" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="<?php echo get_option_url('TWITTER_URL'); ?>" title="twitter">
                                    <i class="fa fa-twitter" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="<?php echo get_option_url('INSTAGRAM_URL'); ?>" title="instagram">
                                    <i class="fa fa-instagram" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="<?php echo get_option_url('PINTEREST_URL'); ?>" title="pinterest">
                                    <i class="fa fa-pinterest" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="<?php echo get_option_url('RSS_URL'); ?>" title="Rss">
                                    <i class="fa fa-rss" aria-hidden="true"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
				</div>
			</div>
			<div class="contact-form-left">
				<div class="contact-form-left-inner">
					<div class="col-sm-12">
						<h4 class="heading">Send us a Message</h4>
					</div>
					<?php msg_alert(); ?>
					<form id="contact-form" method="POST" data-bvalidator-validate="" novalidate="novalidate">
					  	<div class="form-group col-md-6">
					    	<label for="name">Your Name <span class="mandatory">*</span></label>
					    	<input type="text" class="form-control" id="name" name="name" placeholder="John Doe" data-bvalidator="required" data-bvalidator-msg="Please enter your name" value="<?php $user_name = user_name(); if(!empty($user_name)) echo ucfirst($user_name); else set_value('name'); ?>">
					    	<?php echo form_error('name'); ?>
					    </div>
					  	<div class="form-group col-md-6">
					    	<label for="email">Email Address <span class="mandatory">*</span></label>
					    	<input type="email"  class="form-control" id="email" value="<?php $user_email = user_email(); if(!empty($user_email)) echo $user_email; else set_value('email'); ?>" name="email" placeholder="john@example.com" data-bvalidator="required,email" data-bvalidator-msg="Please enter a valid email address">
					    	<?php echo form_error('email'); ?>
					    </div>
		  				<div class="clearfix"></div>
						<div class="form-group col-md-6">
							<label for="number">Mobile number</label>
							<div class="mobile-number-wrapper">					  		
								<div class="mobile-number-left">
									<select class="form-control" name="country_code" id="country_code">
									<?php 
									  $user_countrycode = user_countrycode();
                                      if(!empty($countries))
                                      {
                                      	foreach ($countries as  $value) {
                                      ?>
                                      <option value="<?php echo $value->phonecode; ?>" <?php if(!empty($user_countrycode)){ if($user_countrycode==$value->phonecode){ echo "selected"; } } ?> ><?php echo $value->sortname; ?> +<?php echo $value->phonecode; ?></option>
									<?php } }?>
		                            </select>
		                            <?php echo form_error('country_code'); ?>
								</div>
						  		<div class="mobile-number-right">					  			
						    		<input type="text" class="form-control" id="mobile" value="<?php $user_mobile = user_mobile(); if(!empty($user_mobile)) echo $user_mobile; else set_value('mobile'); ?>" name="mobile" placeholder="xxxxxxxxxx" data-bvalidator="maxlen[13],minlen[9],number,required" data-bvalidator-msg="Please enter a valid mobile number.">
						    		  <?php echo form_error('mobile'); ?>
						  		</div>					    	
							</div>
						</div>
						<div class="col-md-6">
	                        <div class="form-group">
	                            <label for="form_phone">Subject</label>
	                            <select class="form-control" name="subject" required="">
	                              <option>Select the Subject </option>
	                              <?php $feed_status=feedback_subject_status(); foreach ($feed_status as $key=>$value) { ?>
                                      <option  value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                  <?php } ?>	        			          
	        			        </select>
	        			        <?php echo form_error('subject'); ?>
	                        </div>
	                    </div>	
	                    <div class="clearfix"></div>		 	
		                <div class="form-group col-md-12">
		                  <label class="">Message</label><br>
		                  <textarea name="message" placeholder="Enter Your Message here" rows="5" class="form-control"></textarea>
		                  <?php echo form_error('message'); ?>
		                </div>
		                <div class="clearfix"></div>
					  	<div class="form-group text-center">
					  		<button type="submit" class="btn btn-red">Submit</button>
					  	</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
