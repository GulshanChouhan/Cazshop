<section class="admin-background admin-page">
	<div class="container-fluid">
		<div class="row dashboard">
		    <div class="clearfix dashboard-width-wrap">
			    <?php $this->load->view('frontend/account/left_menus'); ?>
			    <div class="col-md-10 col-sm-9 dashboard-right-warp">
			        <div class="col-lg-12 col-md-12">
			         	<div class="dashboaed-breadcrumb-wrapper">
			         		<nav aria-label="breadcrumb">
							  <ul class="breadcrumb">
							    <li class="breadcrumb-item">
							    	<a href="<?php echo base_url('account/dashboard'); ?>">Dashboard</a>
							    </li>
							    <li class="breadcrumb-item active" aria-current="page">My Profile</li>
							  </ul>
							</nav>
			         	</div>
			         	<div class="clearfix"></div>
		      		</div>
		      		<div class="clearfix"></div>
               		<?php msg_alert(); ?>
			    	<div class="dashboard-right section-white no-padding-top">
			    		<div class="col-lg-12 col-md-12">
				            <div class="heading">
				            	<img src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/my-profile-gray.svg" width="25"> 
				            	My Profile
				         	</div>
				         	<div class="clearfix"></div>
			      		</div>
					    <div class="col-lg-12 col-md-12">
					    	<div class="theme-box">
					    		<br>
								<div class="col-sm-8 center-block">
									<form id="profileform" method="POST" data-bvalidator-validate>
									  	<div class="form-group col-md-6">
									    	<label for="name">Full Name <span class="mandatory">*</span></label>
									    	<input type="text" class="form-control" id="name" name="name" value="<?php if(set_value('name')) echo set_value('name'); else if(!empty($user->user_name)) echo ucfirst($user->user_name); ?>" placeholder="Ex : John Doe" data-bvalidator="required" data-bvalidator-msg="Please enter your full name">
									    	<?php echo form_error('name'); ?>
									  	</div>
									  	<div class="form-group col-md-6">
									    	<label for="name">Gender</label>
									    	<div class="profile-gender">
										    	<div class="radio-input">
										    		<input <?php if(!empty($user->gender)){ if($user->gender=='male'){ echo "checked='checked'"; } }else{ echo "checked='checked'"; } ?> type="radio" id="male" name="gender" value="male">
										    		<label for="male">Male</label>
										    	</div>
										    	<div class="radio-input">
										    	<input <?php if(!empty($user->gender)){ if($user->gender=='female'){ echo "checked='checked'"; } } ?> type="radio" id="female" name="gender" value="female">
										    	<label for="female">Female</label>
										    	</div>
									    	</div>
									    	<?php echo form_error('gender'); ?>
									  	</div>
									  	<div class="clearfix"></div>
									 	<div class="form-group col-md-6">
									  		<label for="number">Mobile number</label>
										  	<div class="mobile-number-wrapper">					  		
										  		<div class="mobile-number-left">
										  			<select class="form-control" name="country_code" id="country_code">
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
										    		<input type="text" class="form-control" id="mobile" value="<?php if(set_value('mobile')) echo set_value('mobile'); else if(!empty($user->mobile)) echo $user->mobile; ?>" name="mobile" placeholder="xxxxxxxxxx" data-bvalidator="maxlen[13],minlen[9],number,required" data-bvalidator-msg="Please enter a valid Mobile No.">
										  		</div>					    	
										 	</div>
										 	<?php echo form_error('mobile'); ?>				 		
						                </div>
									  	<div class="form-group col-md-6">
									    	<label for="email">Email Address <span class="mandatory">*</span></label>
									    	<input type="email" disabled="disabled" class="form-control" id="email" value="<?php if(set_value('email')) echo set_value('email'); else if(!empty($user->email)) echo $user->email; ?>" name="email" placeholder="john@example.com" data-bvalidator="required,email" data-bvalidator-msg="Please enter a valid email address">
									    	<?php echo form_error('email'); ?>
									 	</div>
						  				<div class="clearfix"></div>
									 	<div class="form-group col-md-6">
						                  <label class="">Country <span class="mandatory">*</span></label>
						                  <select name="country" class="form-control" data-bvalidator="required" data-bvalidator-msg="Please select your country" id="country">
						                     <option value="">--Select Country--</option>
						                     <?php foreach ($country as $row) { ?>
						                        <option <?php if($user->country==$row->id) echo "selected"; ?> value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
						                     <?php } ?>
						                  </select>     
						                  <?php echo form_error('country'); ?>                        
						               </div>
						               <div class="form-group col-md-6">
						                  <label class="">State <span class="mandatory">*</span></label>
						                  <?php
						                  	$getProvinceData = getDataResult('states', array('country_id'=>$user->country));
						                  ?>
						                  <select name="province" class="form-control" data-bvalidator="required" data-bvalidator-msg="Please select your state" id="state">

						                     <option value="">--Select State--</option>
							                 <?php if(!empty($getProvinceData)){ foreach ($getProvinceData as $row) { ?>
							                 <option <?php if(!empty($user->province)  && $user->province!=0){ if($user->province==$row->id){ echo "selected='selected'"; } } ?> value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
							                 <?php } } ?>

						                  </select>                           
						                  <?php echo form_error('province'); ?>         
						               </div>
						               <div class="clearfix"></div>
						               <div class="form-group col-md-6">
						                  <label class="">City <span class="mandatory">*</span></label>
						                  <?php
						                  	$getCityData = getDataResult('cities', array('state_id'=>$user->province));
						                  ?>
						                  <select name="city" class="form-control" data-bvalidator="required" data-bvalidator-msg="Please select your city" id="city">

						                     <option value="">--Select City--</option>
							                 <?php if(!empty($getCityData)){ foreach ($getCityData as $row) { ?>
							                 <option <?php if(!empty($user->city) && $user->city!=0){ if($user->city==$row->id){ echo "selected='selected'"; } } ?> value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
							                 <?php } } ?>

						                  </select>          
						                  <?php echo form_error('city'); ?>                            
						               </div>
						               <div class="form-group col-md-6">
						                  <label class="">Postal Code</label>
						                  <input autocomplete="off" type="text" data-bvalidator="maxlen[8],minlen[4]" data-bvalidator-msg="Please enter the valid postal code"class="form-control" name="zip" id="zip" value="<?php if(set_value('zip')){ echo set_value('zip'); }else if(!empty($user)){ echo $user->zip; } ?>" placeholder="452101">
						                  <?php echo form_error('zip'); ?>
						               </div>
						               <div class="clearfix"></div>
						               <div class="form-group col-md-12">
						                  <label class="">Address</label><br>
						                  <textarea name="address" placeholder="xyz street" rows="5" class="form-control" id="address"><?php if(set_value('address')) echo set_value('address'); else if(!empty($user->address)) echo $user->address; ?></textarea>
						                  <?php echo form_error('address'); ?>
						               </div>
						               <div class="clearfix"></div>
									  	<div class="form-group text-center">
									  		<button type="submit" class="btn btn-red">Update</button>
									  	</div>
									</form>
								</div>
								<br>
							</div>
					    </div>

				    </div>
			    </div>
			</div>
	    </div>
	</div>
</section>

<script>

	/*if($('.dashboard').length != 0){
		$(window).on("load resize", function () {
		winWidthnew = $('body').width();
		if(winWidthnew >=768){
			var dashboard_left = $('.dashboard-left').outerHeight();
			var dashboard_right  = $('.dashboard-right').outerHeight();
			if(dashboard_left <= dashboard_right){
				$('.dashboard-left').css('height' , dashboard_right);
			}
			else{
				$('.dashboard-left').css('height' , '400px;');
			}
		}
		}).resize();
	}*/

    SITE_URL = "<?php echo base_url(); ?>";

    $(document).ready(function(){
      $('#profileform').bValidator();
    });

</script>
