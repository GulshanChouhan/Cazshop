<div class="product-block">
	<?php $image=''; if($product->image){ ?> 
	<div class="product-nav">
		<div class="product-preview-nav">
			<button type="button" class="top-arrow slick-arrow">
				<div><i class="fa fa-angle-up" aria-hidden="true"></i></div>
			</button>
			<ul class="nav-slider list-unstyled" id="gallery_01">
				<?php $images=explode(',',$product->image);
				 foreach($images as $key =>$value){ ?>
				<li>
					<div class="side-img-block">
						<a href="javascript:void(0)" class="center-block elevatezoom-gallery <?php if($key==0) echo 'active'; ?>" data-image="<?php echo base_url('assets/uploads/seller/products/thumbnail/'.$value); ?>" data-zoom-image="<?php echo base_url('assets/uploads/seller/products/'.$value); ?>">
						<img alt="Maheshwari Saree Ganga Jamuna Border" src="<?php echo base_url('assets/uploads/seller/products/small_thumbnail/'.$value); ?>" />
						</a>
					</div>
				</li>
				<?php } ?>
			</ul>
			<button type="button" class="bottom-arrow slick-arrow">
				<div><i class="fa fa-angle-down" aria-hidden="true"></i></div>
			</button>
		</div>

        <!-- Start Mobile Wishlist design -->
         <div class="mobile-wishlist">
            <div class="mobile-favourite wishListdiv-btn">
               <?php
                  if(!empty($wishListProduct)){
               ?>
               <div class="mob-wishlist-icon" data-toggle="tooltip" data-placement="top" title="Remove from Wishlist">   
                  <a href="javascript:void(0)">
                     <span class="heart-icon">
                        <img class="removeFromWishlist wishListRemove" pRWID="" src="<?php echo FRONTEND_THEME_URL ?>img/icons/heart-full.svg" width="22">
                     </span> 
                  </a>           
               </div>
               <?php }else{ ?>
               <div class="mob-wishlist-icon" data-toggle="tooltip" data-placement="top" title="Add to Wishlist">
                  <a href="javascript:void(0)">
                     <span class="mob-heart-icon">
                        <img class="addToWishlist wishListAdd" pAWID="" src="<?php echo FRONTEND_THEME_URL ?>img/icons/heart-empty.svg" width="22">
                     </span>     
                  </a>                                      
               </div>
               <?php } ?>
            </div>
         </div>
        <!-- End Mobile Wishlist design -->

	</div>
	<div class="img-cover">
        <div class="slide-for">
			<?php $image=base_url('assets/uploads/seller/products/'.$images[0]); ?>
				<img id="zoom_01" src='<?php echo base_url('assets/uploads/seller/products/thumbnail/'.$images[0]); ?>' data-zoom-image="<?php echo base_url('assets/uploads/seller/products/'.$images[0]); ?>" class="">
		</div>
	</div>
	<?php }else{ ?>
	<div class="img-cover">
		<div class="slide-for">
			<img src="<?php echo FRONTEND_THEME_URL ?>img/mobile.jpg" class="center-block">
		</div>
	</div>
	<?php } ?>
	<!-- <div class="loading product-cat-loader" style="display: none;">
			<div class="content">
				<img src="<?php //echo base_url().'assets/frontend/img/loading.gif'; ?>"/>
			</div>
	</div> -->

	<div class="loading main-loader product-cat-loader" style="display: none;">
        <div class="loader">
           <svg class="circular-loader" viewBox="25 25 50 50" >
             <circle class="loader-path" cx="50" cy="50" r="20" fill="none" stroke="#0a8ae2" stroke-width="2.5" />
           </svg>
        </div>
     </div>
</div>
<script src='<?php echo base_url('assets/frontend/js/jquery.elevatezoom.js') ?>'></script>
<script>
var screensize = document.documentElement.clientWidth;
if (screensize  <= 1100) {
   $("#zoom_01").elevateZoom({
		zoomType: "inner",
		cursor: "crosshair",
		zoomWindowFadeIn: 500,
		zoomWindowFadeOut: 750,
		gallery:$.trim('gallery_01'),
		cursor: $.trim('pointer'),
		galleryActiveClass: $.trim('active'), 
		imageCrossfade: true, 
		//loadingIcon: 'http://www.girlsgotit.org/images/ajax-loader.gif'
	}); 
}
else {
	$("#zoom_01").elevateZoom({
		cursor: "crosshair",
		zoomWindowFadeIn: 500,
		zoomWindowFadeOut: 750,
		gallery:$.trim('gallery_01'),
		cursor: $.trim('pointer'),
		galleryActiveClass: $.trim('active'), 
		imageCrossfade: true, 
		///loadingIcon: 'http://www.girlsgotit.org/images/ajax-loader.gif'
	}); 
}
$('.nav-slider').slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    vertical: true,
    dots: false,
    centerMode: true,
    focusOnSelect: true,
    prevArrow: $('.top-arrow'),
    nextArrow: $('.bottom-arrow'),
    responsive: [
	    {
	        breakpoint: 481,
	        settings: {
	           vertical: false,
	           slidesToShow: 1,
	           dots: true,
	        }
	    }
    ]
  });

</script>