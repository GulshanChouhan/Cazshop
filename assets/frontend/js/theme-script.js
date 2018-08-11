const colors = ["#00baff","#ff00c6","#5aff00","#ff9c00"];
var defaultColor = "#f95858";
$( document ).ready(function() {

  // Home page top banner slider
	$('.home-banner-slider').slick({
    lazyLoad: 'ondemand',
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: true,
    infinite: true,
    speed: 500,
    autoplay: true,
    autoplaySpeed: 6000,
  });
 /* $('img[data-lazy]').one('load', function(e) {
      if (this.complete) {
          $(this).siblings('.ajax-loader').remove();
      }
  });*/

// aboutus testimonial slider
  $('.testimonial-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: false,
    infinite: true,
    speed: 500,
    autoplay: false,
    autoplaySpeed: 4000
  });


  // Script for random border color
	var lastColor = null;
	$(".tile").each(function(){
		lastColor = setColor(lastColor);
		if(lastColor){
			$(this).css('border-bottom-color', lastColor);	
		}else{
			$(this).css('border-bottom-color', defaultColor);	
		}
	});
	function setColor(lastColor){
		var rand = Math.floor(Math.random()*colors.length);
	  	var currentColor = colors[rand];
		if(!lastColor){
			return currentColor;
		}else if(lastColor == currentColor){
			setColor(lastColor);
		}else{
			return currentColor;
		}
	}
       var $carousel = $('.product-slider');
       function showSliderScreen($widthScreen) {
           
       	  if ($widthScreen >= "4500") {
               if (!$carousel.hasClass('slick-initialized')) {
                   $carousel.slick({
                       slidesToShow: 9,
                       slidesToScroll: 1,
                       infinite: true,
                       arrows: true,
                       autoplay : true
                   });
               }

           }else if ($widthScreen >= "3000") {
               if (!$carousel.hasClass('slick-initialized')) {
                   $carousel.slick({
                       slidesToShow: 7,
                       slidesToScroll: 1,
                       infinite: true,
                       arrows: true,
                       autoplay : true
                   });
               }

           }else if ($widthScreen >= "1800") {
               if (!$carousel.hasClass('slick-initialized')) {
                   $carousel.slick({
                       slidesToShow: 5,
                       slidesToScroll: 1,
                       infinite: true,
                       arrows: true,
                       autoplay : true
                   });
               }

           }else
           if ($widthScreen > "1600") {
           	//console.log($widthScreen);
               if (!$carousel.hasClass('slick-initialized')) {
                   $carousel.slick({
                       slidesToShow: 5,
                       slidesToScroll: 1,
                       infinite: true,
                       arrows: true,
                      // autoplay : true
                   });
               }

           } else {
	           if ($widthScreen <= "1600") {
	               if (!$carousel.hasClass('slick-initialized')) {
	                   $carousel.slick({
	                       slidesToShow: 5,
	                       slidesToScroll: 1,
	                       infinite: true,
	                       arrows: true,
	                       //autoplay : true,
	                       focusOnSelect: true,responsive: [
                          {
                              breakpoint: 1367,
                              settings: {
                                  slidesToShow: 5,
                              }
                          },
                          {
                              breakpoint: 1300,
                              settings: {
                                  slidesToShow: 4,
                              }
                          },
	                        {
	                            breakpoint: 1200,
	                            settings: {
	                                slidesToShow: 3,
	                            }
	                        },	                       
	                        {
	                            breakpoint: 768,
	                            settings: {
	                                slidesToShow: 3,
	                            }
	                        },
	                       {
	                           breakpoint: 481,
	                           settings: {
	                               slidesToShow: 2
	                           }
	                       }]
	                   });
	               }

	           }           	

            }
       }

       var widthScreen = $(window).width();
       $(window).ready(showSliderScreen(widthScreen)).resize(
           function () {
               var widthScreen = $(window).width();
               showSliderScreen(widthScreen);
           }
       );
});

/*==================categori=======================*/

$( document ).ready(function() {

  var $carousel = $('.catgory-list-grid-slider');
       function showSliderScreen($widthScreen) {
           
          if ($widthScreen >= "4500") {
               if (!$carousel.hasClass('slick-initialized')) {
                   $carousel.slick({
                       slidesToShow: 9,
                       slidesToScroll: 1,
                       infinite: true,
                       arrows: true,
                       autoplay : true
                   });
               }

           }else if ($widthScreen >= "3000") {
               if (!$carousel.hasClass('slick-initialized')) {
                   $carousel.slick({
                       slidesToShow: 7,
                       slidesToScroll: 1,
                       infinite: true,
                       arrows: true,
                       autoplay : true
                   });
               }

           }else if ($widthScreen >= "1800") {
               if (!$carousel.hasClass('slick-initialized')) {
                   $carousel.slick({
                       slidesToShow: 5,
                       slidesToScroll: 1,
                       infinite: true,
                       arrows: true,
                       autoplay : true
                   });
               }

           }else
           if ($widthScreen > "1600") {
            //console.log($widthScreen);
               if (!$carousel.hasClass('slick-initialized')) {
                   $carousel.slick({
                       slidesToShow: 5,
                       slidesToScroll: 1,
                       infinite: true,
                       arrows: true,
                      // autoplay : true
                   });
               }

           } else {
             if ($widthScreen <= "1600") {
                 if (!$carousel.hasClass('slick-initialized')) {
                     $carousel.slick({
                         slidesToShow: 5,
                         slidesToScroll: 1,
                         infinite: true,
                         arrows: true,
                         //autoplay : true,
                         focusOnSelect: true,responsive: [
                          {
                              breakpoint: 1367,
                              settings: {
                                  slidesToShow: 4,
                              }
                          },
                          {
                              breakpoint: 1200,
                              settings: {
                                  slidesToShow: 3,
                              }
                          },                         
                          {
                              breakpoint: 768,
                              settings: {
                                  slidesToShow: 3
                              }
                          },
                         {
                             breakpoint: 481,
                             settings: {
                                 slidesToShow: 2
                             }
                         }]
                     });
                 }

             }            

            }
       }

       var widthScreen = $(window).width();
       $(window).ready(showSliderScreen(widthScreen)).resize(
           function () {
               var widthScreen = $(window).width();
               showSliderScreen(widthScreen);
           }
       );


  // Top Brands Slider
  $( document ).ready(function() {
     $('.top-brands-slider').slick({
        autoplay: true,
        autoplaySpeed: 2000,
        infinite: true,
        slidesToShow: 8,
        slidesToScroll: 1,
        arrows:false,
        responsive: [
         {
           breakpoint: 1024,
           settings: {
             slidesToShow: 6,
             slidesToScroll: 1,
             infinite: true,
             dots: false
           }
         },
         {
           breakpoint: 600,
           settings: {
             slidesToShow: 4,
             slidesToScroll: 1
           }
         },
         {
           breakpoint: 480,
           settings: {
             slidesToShow: 2,
             slidesToScroll: 1
           }
         }
        ]
     });
  });
  
});

$(document).ready(function(){
    //for shoppingbilling page
  $(".show_data1").click(function(){
      $(".roster_more").hide(1000);
      $(".show_data").show();
      $(".show_data1").hide();
  });

  $(".show_data").click(function(){ 
      $(".roster_more").show(1000);
      $(".show_data1").show();
      $(".show_data").hide();
  });

  $(".show_data1").click(function(){
      $(".show_cart_item").hide(1000);
      $(".show_data").show();
      $(".show_data1").hide();
      $("html, body").animate({ scrollTop:100 }, 1200); 
   });

   $(".show_data").click(function(){ 
      $(".show_cart_item").show(1000);
      $(".show_data1").show();
      $(".show_data").hide();
   });
  //for cartpage
  /*  var firstTr = $('.table.my-cart-desc').find('.first-tr');
    if(firstTr !== ''){
      var trOffset = firstTr.offset();
      var trHeight = firstTr.outerHeight();
       alert( "left: " + trOffset.left + ", top: " + trOffset.top );
      jQuery(window).on("resize", function() {
    var winWidthnew = $(window).width();
     if(winWidthnew > 768){
      $('.myCartDescBg').remove();
      $('.my-cart-desc-table').prepend( "<div class='myCartDescBg' style='height:"+trHeight+"px;width: "+winWidthnew+"px;'></div>" );
     }
      }).resize();
  }*/
//for shoppingbilling page
  jQuery('#shipping_address_to_check').on('click',function(){
      jQuery('#other_info').slideToggle();
  });
});

$( window ).load(function() {
    var menu = $("#nav-bar-filter"),
        subMenu = $(".subfilter"),
        more = $("#more-nav"),
        parent = $(".filter-wrapper"),
        ww = $(window).width(),
        smw = more.outerWidth();

    menu.children("li").each(function () {
        var w = $(this).outerWidth();
        if (w > smw) smw = w + 20;
        return smw
    });
     $('#more-nav').hide();
    function contract1()
    {

        var w = 0;
        //console.log(parent.width());
        outerWidth = parent.width()-150; 
        //console.log(outerWidth);
        for (i = 0; i < menu.children("li").size(); i++) {
            w += menu.children("li").eq(i).outerWidth();
           //console.log(w+' === '+outerWidth);
            if (w > outerWidth) {
          //    console.log('hello');
                $('#more-nav').show();
                menu.children("li").eq(i-1).nextAll()
                    .detach()
                    .css('opacity', 0)
                    .prependTo(".subfilter")
                    .stop().animate({
                    'opacity': 1
                }, 300);
                break;
            }
        }
       more_width(); 
    }
    function more_width()
    {
       var size=subMenu.children("li").size();
       $('.subfilter').removeClass('col3');
       $('.subfilter').removeClass('col2');
       $('.subfilter').removeClass('col1');
        if(size>10)
        {
          $('.subfilter').addClass('col3');
          $('.subfilter').css( "width",'660px');
        }  
        else if(size>5){
          $('.subfilter').addClass('col2');
          $('.subfilter').css( "width",'440px');
        }
        else{
          $('.subfilter').addClass('col1'); 
           $('.subfilter').css( "width",'220px');
        }


    }
    function expand1() {
        $('#more-nav').show();
        var w = 0,
            outerWidth = parent.width() - 150;
        menu.children("li").each(function () {
            w += $(this).outerWidth();
            
        });
      //  console.log(outerWidth+'  ===  '+w);
      //  console.log(subMenu.children("li").size());
        for (i = 0; i < subMenu.children("li").size(); i++) {
          w += subMenu.children("li").eq(i).outerWidth();
          if (w > outerWidth) {
                $('#more-nav').show();
                  subMenu.children("li").eq(i)
                        .css('opacity', 0)
                        .detach()
                        .appendTo("#nav-bar-filter")
                        .stop().animate({
                        'opacity': 1
                    }, 300);
                break;
            }
        }
        if(subMenu.children("li").size()==0)
          $('#more-nav').hide();
        more_width();
    }



    more.css('width', smw);
    $('#more-nav').hide();
    //console.log(smw);

    contract1();

    $(window).on("resize", function (e) {
     // console.log($(window).width()+'  '+ww);
        ($(window).width() > ww) ? expand1() : contract1();
        ww = $(window).width();
        //console.log(ww);
    });

});


$(document).ready(function(){
  //=======Mobile nav toggle left

  $('.toggle-bar-icon').click(function(){
    $('.mob-left-toggle-wrapper').toggleClass('left-toggle-move');
    $('body').toggleClass('body-off-scroll');
  });

  //=======Mobile fillter toggle bottom

  $('.mob-main-filter-toggle').click(function(){
    $('#sidebar').toggleClass('show-filter-toggle');
    $('body').toggleClass('body-off-scroll-fixed');
  });

  $('.mob-sort-filter-toggle').click(function(){
    $('.mob-sort-fix').toggleClass('show-toggle');
    $('body').toggleClass('body-off-scroll');
  });

});
