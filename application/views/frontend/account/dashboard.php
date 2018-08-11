<section class="admin-background admin-page">
	<div class="container-fluid">
		<div class="row dashboard">
		   <div class="clearfix dashboard-width-wrap">
			   <?php $this->load->view('frontend/account/left_menus'); ?>
			   <div class="col-md-10 col-sm-9 dashboard-right-warp">
			      <div class="dashboard-right section-white">
			         <div class="col-lg-12 col-md-12 responsive-form no-padding-right">
			            <div class="heading">
			            	Welcome to your dashboard <span><?php echo ucwords(user_name()) ?></span>
			         	</div>
			         <div class="clearfix"></div>
			      </div>
			      <div class="clearfix"></div>
               	  <?php msg_alert(); ?>
			      <div class="col-lg-12 col-md-12 no-padding-right">
			      	<div class="flex-container dashboard-col-block">
			      		<div class="flex-item">
			      			<div class="dashboard-tile">
			      				<div class="left">
				      				<div class="tile-image">
				      					<img src="<?php echo FRONTEND_THEME_URL ?>img/icons/order-icon.png">
				      				</div>
			      				</div>
			      				<div class="right">
			      					<div class="tittle">Your Orders</div>
			      					<div class="decs">Track, return, or buy<br>things again</div>
			      					<div><a href="<?php echo base_url('account/open_orders'); ?>" class="read-more-link">Show More <img class="right-arrow-icon" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/thin-right-arrow.png"></a></div>
			      				</div>
			      			</div>
			      		</div>
			      		<div class="flex-item">
			      			<div class="dashboard-tile">
			      				<div class="left">
				      				<div class="tile-image">
				      					<img src="<?php echo FRONTEND_THEME_URL ?>img/icons/login-icon.png">
				      				</div>
			      				</div>
			      				<div class="right">
			      					<div class="tittle">Login & security</div>
			      					<div class="decs">Edit login, name, and<br>mobile number</div>
			      					<div><a href="<?php echo base_url('account/profile'); ?>" class="read-more-link">Show More <img class="right-arrow-icon" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/thin-right-arrow.png"></a></div>
			      				</div>
			      			</div>
			      		</div>
			      		<div class="flex-item">
			      			<div class="dashboard-tile">
			      				<div class="left">
				      				<div class="tile-image">
				      					<img src="<?php echo FRONTEND_THEME_URL ?>img/icons/payment-icon.png">
				      				</div>
			      				</div>
			      				<div class="right">
			      					<div class="tittle">Transaction History</div>
			      					<div class="decs">Check your transaction<br>history</div>
			      					<div><a href="<?php echo base_url('account/transaction'); ?>" class="read-more-link">Show More <img class="right-arrow-icon" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/thin-right-arrow.png"></a></div>
			      				</div>
			      			</div>
			      		</div>
			      		<div class="flex-item">
			      			<div class="dashboard-tile">
			      				<div class="left">
				      				<div class="tile-image">
				      					<img src="<?php echo FRONTEND_THEME_URL ?>img/icons/email-icon.png">
				      				</div>
			      				</div>
			      				<div class="right">
			      					<div class="tittle">Subscriptions</div>
			      					<div class="decs">E-mail Subscriptions</div>
			      					<div><a href="<?php echo base_url('account/subscription'); ?>" class="read-more-link">Show More <img class="right-arrow-icon" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/thin-right-arrow.png"></a></div>
			      				</div>
			      			</div>
			      		</div>
			      		<div class="flex-item">
			      			<div class="dashboard-tile">
			      				<div class="left">
				      				<div class="tile-image">
				      					<img src="<?php echo FRONTEND_THEME_URL ?>img/icons/wishlist-icon.png">
				      				</div>
			      				</div>
			      				<div class="right">
			      					<div class="tittle">Your Wish List</div>
			      					<div class="decs">collection of all your<br>favorites items</div>
			      					<div><a href="<?php echo base_url('account/wish_list'); ?>" class="read-more-link">Show More <img class="right-arrow-icon" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/thin-right-arrow.png"></a></div>
			      				</div>
			      			</div>
			      		</div>
			      		<div class="flex-item">
			      			<div class="dashboard-tile">
			      				<div class="left">
				      				<div class="tile-image">
				      					<img src="<?php echo FRONTEND_THEME_URL ?>img/icons/support-icon.png">
				      				</div>
			      				</div>
			      				<div class="right">
			      					<div class="tittle">Support</div>
			      					<div class="decs">Product preferences <br>Communication preferences</div>
			      					<div><a href="<?php echo base_url('support/messages'); ?>" class="read-more-link">Show More <img class="right-arrow-icon" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/thin-right-arrow.png"></a></div>
			      				</div>
			      			</div>
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
</script>