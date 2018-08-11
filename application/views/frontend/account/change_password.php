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
							    <li class="breadcrumb-item active" aria-current="page">Change Password</li>
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
				            	<img src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/lock-gray.svg" width="25"> 
				            	Change Password
				         	</div>
				         	<div class="clearfix"></div>
			      		</div>
					    <div class="col-lg-12 col-md-12">
					    	<div class="theme-box">
					    		<br>
								<div class="col-sm-6 center-block">
									<form id="changePassword" method="POST" data-bvalidator-validate>
									  	<div class="form-group">
									    	<label for="name">Old Password <span class="mandatory">*</span></label>
									    	<input type="password" class="form-control" id="oldpassword" name="oldpassword" value="<?php echo set_value('oldpassword'); ?>" placeholder="Please enter your current password" data-bvalidator="required" data-bvalidator-msg="Please enter your current password">
									    	<?php echo form_error('oldpassword'); ?>
									  	</div>
									  	<div class="form-group">
									    	<label for="name">New Password <span class="mandatory">*</span></label>
									    	<input type="password" class="form-control" id="newpassword" name="newpassword" value="<?php echo set_value('newpassword'); ?>" placeholder="Please enter your new password with Min 6 characters" data-bvalidator="minlen[6],required" data-bvalidator-msg="Please enter the password with minimum 6 characters">
									    	<?php echo form_error('newpassword'); ?>
									  	</div>
									  	<div class="form-group">
									    	<label for="email">Confirm Password <span class="mandatory">*</span></label>
									    	<input type="password" class="form-control" id="confpassword" value="<?php echo set_value('confpassword'); ?>" name="confpassword" placeholder="Please enter the same password again" data-bvalidator="equal[newpassword],required" data-bvalidator-msg="Please enter the same password again">
									    	<?php echo form_error('confpassword'); ?>
									 	</div>
						  	
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

	if($('.dashboard').length != 0){
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
	}

    $(document).ready(function(){
      $('#changePassword').bValidator();
    });

</script>
