<!DOCTYPE html>
<html>
<head>
<title>Solodev's Lazy Loading Slider</title>
<meta charset="UTF-8">
  <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.1.min.js"></script>     
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.slick/1.3.8/slick.min.js"></script>    
  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>       
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.css">  
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">    
  <link rel="stylesheet" type="text/css" href="http://cazshoppe.io/slider/lazy-load-slick.css">
</head>
<body>
<?php if(!empty($most_rated_or_discounted)){ ?>
<div class="ct-header ct-header--slider ct-slick-custom-dots" id="home">
  <div class="ct-slick-homepage" data-arrows="true" data-autoplay="true">
  <?php foreach($most_rated_or_discounted as $product){ ?>
	<div class="ct-header tablex item">
	<img data-lazy="<?php if($product->image) echo base_url('assets/uploads/seller/products/small_thumbnail/'.$product->image); ?>">
      <div class="ct-u-display-tablex">
        <div class="inner">
          <div class="container">
            <div class="row">
              <div class="col-md-4 col-lg-4 slider-inner">
                <h1 class="big"><?php echo ucfirst($product->brand_name); ?></h1>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem.</p>
                <a class="btn btn-transparent btn-lg text-uppercase" href="#">Learn More</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<!-- 
    <div class="ct-header tablex item">
	    <img data-lazy="images/slide5.jpg">
      <div class="ct-u-display-tablex">
        <div class="inner">
          <div class="container">
            <div class="row">
              <div class="col-md-8 col-lg-6 slider-inner">
                <h1 class="big">Lorem Ipsum Dolor sit Amet</h1>
                <p>Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam.</p>
                <a class="btn btn-transparent btn-lg text-uppercase" href="">Learn More</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="ct-header tablex item"> 
	    <img data-lazy="images/slide6.jpg">
      <div class="ct-u-display-tablex">
        <div class="inner">
          <div class="container">
            <div class="row">
              <div class="col-md-8 col-lg-6 slider-inner">
                <h1 class="big">Lorem Ipsum Dolor sit Amet</h1>
                <p>Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore.</p>
                <a class="btn btn-transparent btn-lg text-uppercase" href="">Learn More</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <?php } ?>
  </div>
</div>
<?php } ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.ct-slick-homepage').slick({
				lazyLoad: 'ondemand',
        slidesToShow: 4,
			});
		}); 
	</script>

</body>
</html>