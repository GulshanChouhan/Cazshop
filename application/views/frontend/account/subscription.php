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
							    <li class="breadcrumb-item active" aria-current="page">Wish List</li>
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
				            	<img src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/email-opened-envelope-gray.svg" width="25"> 
				            	Subscription
				         	</div>
				         	<div class="clearfix"></div>
			      		</div>
					    <div class="col-lg-12 col-md-12">
					      	<div class="subscription-wrapper">
				      			<div class="subscription-img">
				      				<img src="<?php echo FRONTEND_THEME_URL ?>img/icons/subscription.svg" width="100%">
				      			</div>
				      			<div class="newsletter-section">
					      			<h2>Stay up to date with our latest releases.</h2>
					      			 <form class="" method="post" data-bvalidator-validate>
                                        <div class="input-group">
                                            <input aria-describedby="basic-addon2" class="form-control" name="email" id="emailid" placeholder="john@example.com" type="text" onblur="check_email_exists()" data-bvalidator="required,email"> <input aria-describedby="basic-addon2" class="form-control" name="subscription_type" type="hidden" value="2">
                                            <span class="input-group-btn">
                                                <button class="btn btn-red" type="submit">Join</button>
                                            </span>
                                        </div>
                                        <?php echo form_error('email'); ?>                              
                                    </form>
								</div>
					      	</div>
					    </div>
				    </div>
			    </div>
			</div>
	    </div>
	</div>
</section>

<script type="text/javascript">
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

	function check_email_exists() {
		var email = $("#email").val();
		$.ajax({

	        type:"post",
	        url: "<?php echo base_url(); ?>page/email_exists",
	        data:{ email:email},
	        success:function(response)
	        {        	
	            if (response==1) 
	            {
	              warningMsg("This email is already registered");
	              return false;
	            }            
	        }
	    });
	}
	

</script>
