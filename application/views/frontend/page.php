<section class="account-page" id="autoScrollDiv">
	<div class="join-now-bg text-center">
		<h1 class="heading"><?php if(!empty($pageDetails)){ echo ucwords($pageDetails->title); } ?></h1>
		<h3 class="sub-heading">New Ways to Choose Your Product and Ignore the Rest</h3>
	</div>
	<div class="join-now-container">
		<div class="">
			<div class="a-row">
				<div class="col-sm-12">
					<div class="common-page-wrapper">
						<div><?php if(!empty($pageDetails)){ echo $pageDetails->description; } ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>