<?php 
	$segment1 = $this->uri->segment(1);
	$segment2 = $this->uri->segment(2);
	$segment3 = $this->uri->segment(3);
?>
<div class="col-md-2 col-sm-3 dashboard-left-warp">
	<div class="dashboard-left section-white">
	<span class="dashborad-left-close visible-xs  hidden-sm hidden-md">
		<a href="#" class="btn btn-red dashboard-toggle-btn">
			<i class="fa fa-times" aria-hidden="true"></i>
		</a>
	</span>
	<header>My Account </header>
	<!--   <span class="close visible-xs hidden-md hidden-sm"><i class="fa fa-times" aria-hidden="true"></i></span> -->
		<ul class="dashboard-left-nav">
			<li class="<?php if($segment1=='account' && $segment2=='dashboard') echo "active"; ?>">
				<a href="<?php echo base_url('account/dashboard'); ?>">
					<span class="icon">
						<img class="active-img" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/speedometer-gray.svg">
						<img class="hover-img" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/speedometer.svg">
					</span>
				Dashboard</a>
			</li>

			<li class="<?php if($segment1=='account' && ($segment2=='orders' || $segment2=='open_orders' || $segment2=='cancel_orders' || $segment2=='order_details')) echo "active"; ?>">
				<a href="<?php echo base_url('account/open_orders'); ?>">
					<span class="icon">
						<img class="active-img" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/closed-cardboard-gray.svg">
						<img class="hover-img" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/closed-cardboard.svg">
					</span>
				Your Orders</a>
			</li>

			<li class="<?php if($segment1=='account' && $segment2=='wish_list') echo "active"; ?>">
				<a href="<?php echo base_url('account/wish_list'); ?>">
					<span class="icon">
						<img class="active-img" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/wishlist-gray.svg">
						<img class="hover-img" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/wishlist.svg">
					</span>
				My Wishlist</a>
			</li>

			<li class="<?php if($segment1=='account' && $segment2=='transaction') echo "active"; ?>">
				<a href="<?php echo base_url('account/transaction'); ?>"> 
					<span class="icon">
						<img class="active-img" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/verification-gray.svg">
						<img class="hover-img" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/verification.svg">
					</span>
				Transaction</a>
			</li>

			<li class="<?php if($segment1=='support' && ($segment2=='messages' || $segment2=='support' || $segment2=='complete_tickets')) echo "active"; ?>">
				<a href="<?php echo base_url('support/messages'); ?>"> 
					<span class="icon">
						<img class="active-img" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/support-system-gray.svg">
						<img class="hover-img" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/support-system.svg">
					</span>
				Support</a>
			</li>

			<li class="<?php if($segment1=='account' && $segment2=='subscription') echo "active"; ?>">
				<a href="<?php echo base_url('account/subscription'); ?>"> 
					<span class="icon">
						<img class="active-img" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/email-opened-envelope-gray.svg">
						<img class="hover-img" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/email-opened-envelope.svg">
					</span>
				Subscription</a>
			</li>
			<!-- <li><a href="#"> <span class="icon"><img src="<?php //echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/support-chat.svg"></span>Support</a></li> -->
			<li class="<?php if($segment1=='account' && $segment2=='profile') echo "active"; ?>">
				<a href="<?php echo base_url('account/profile'); ?>"> 
					<span class="icon">
						<img class="active-img" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/my-profile-gray.svg">
						<img class="hover-img" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/my-profile.svg">
					</span>
				My Profile</a>
			</li>


			<li class="<?php if($segment1=='account' && $segment2=='change_password') echo "active"; ?>">
				<a href="<?php echo base_url('account/change_password'); ?>"> 
					<span class="icon">
						<img class="active-img" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/lock-gray.svg">
						<img class="hover-img" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/lock.svg">
					</span>
				Change Password</a>
			</li>
			<!-- <li><a href="#"><span class="icon"><img src="<?php //echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/password-lock.svg"></span>Change Password</a></li> -->
			<li class="<?php if($segment1=='account' && $segment2=='logout') echo "active"; ?>">
				<a href="<?php echo base_url('account/logout'); ?>">
					<span class="icon">
						<img class="active-img" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/logout-or-send-gray.svg">
						<img class="hover-img" src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/logout-or-send.svg">
					</span>
				Logout</a>
			</li>
		</ul>
	</div>
</div>
  