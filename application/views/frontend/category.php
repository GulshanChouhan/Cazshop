<div class="theme-background theme-custom-bg">
<!--=============Page Banner==================-->
	<div class="page-banner container-fluid no-padding">
		<img src="<?php if($category_info->banner_image) echo base_url('assets/uploads/backend/category_img/banner/'.$category_info->banner_image); else echo FRONTEND_THEME_URL.'img/sub-banner-apperals.jpg'; ?>">
		<!-- <header class="header text-center">
			<?php //echo ucwords($category_info->category_name); ?>
		</header> -->
		<!-- <ol class="breadcrumb">
		  <li><a href="<?php //echo base_url(); ?>">Home</a></li>
		  <li class="active"><?php //echo ucwords($category_info->category_name); ?></li>
		</ol> -->
	</div>
<!--=============Page Banner End==============-->
	<div class="container-fluid category-page-wrapper clearfix">
		<?php if(!empty($category)){ ?>
		<ul class="list-unstyled catgory-list-grid clearfix">
			<?php foreach($category as $row){
			if($row->product_count>=0){	
			 ?>
			<li>
				<div class="category-product-tile wow fadeIn" data-wow-duration="0.5s" data-wow-delay="0.5s" style="visibility: hidden;">
					<div class="category-image-block">
						<div class="category-image-block-overlay">
							<a href="<?php if($row->parent_id==0) echo base_url($row->category_slug); else echo base_url('p/'.$row->category_slug);  ?>">
								<img src="<?php if($row->logo_image) echo base_url('assets/uploads/backend/category_img/logo/'.$row->logo_image); else echo FRONTEND_THEME_URL.'img/product-1.png'; ?>">
							</a>
						</div>
					</div>
					<div class="category-product-desc">
						<div class="category-product-name">
							<a href="<?php if($row->parent_id==0) echo base_url($row->category_slug); else echo base_url('p/'.$row->category_slug);  ?>"><?php echo ucwords(trim($row->category_name)); ?></a>
						</div>
						<div class="category-short-desc">
							<a href="<?php if($row->parent_id==0) echo base_url($row->category_slug); else echo base_url('p/'.$row->category_slug);  ?>"><?php echo ucwords(trim($row->short_description)); ?></a>
						</div>
					</div>
				</div>			
			</li>	
			<?php } } ?>
		</ul>	
		<?php } ?>
			<div class="clearfix"></div>

		<!--VERTICAL BANNERS-->		
		<div class="catg-banner-block row">	
			<?php
			if(!empty($promotion_image)){
			 foreach($promotion_image as $row){
				if($row->promotion_image){
			 ?>				
			  <div class="col-sm-6 col-md-6">
			  	<div class="catg-add-block">
					<a href="<?php if($row->link) echo base_url($row->link); ?>">
						<img src="<?php echo base_url('assets/uploads/backend/category_img/promotion/'.$row->promotion_image) ?>" class="img-responsive">
						<div class="overlay-hover"></div>
					</a>
					<!-- <div class="caption-tag">
						<a href="<?php if($row->link) //echo base_url($row->link); ?>" class="read-more-btn">Shop Now</a>
					</div> -->
				</div>
			  </div>
		    <?php } } } ?>
		  <div class="clearfix"></div>		  
		</div>

		<!--TOP BRAND BANNER-->
		<?php if($brand){ ?>
		<div class="top-brand-block home-section">
			<h3 class="text-center weather-font"><b>Shop By Top Brands</b></h3>
			<div class="row">
				<div class="top-brands-slider">
				<?php foreach($brand as $row){ ?>	
					<div class="brand-block">
					  <a href="<?php echo base_url('p/'.$category_info->category_slug.'?brand='.$row->brand_name);  ?>">
						<img src="<?php echo base_url('assets/uploads/backend/category_img/brand/'.$row->brand_image) ?>" class="img-responsive">	
					  </a>
					</div>
				<?php } ?>																								
				</div>
			</div>
		</div>
		<?php } ?>
	</div>	
</div>