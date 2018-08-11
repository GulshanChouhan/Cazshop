<!-- 
<div class="twelve columns filter-wrapper">
    <ul class="nav-bar-filter" id="nav-bar-filter">
        <li><a href="#">All</a> 
        </li>
        <li><a href="#">Small</a>

        </li>
        <li><a href="#">Medium</a>

        </li>
        <li><a href="#">Extra large</a>

        </li>
        <li><a href="#">Text</a>

        </li>
        <li><a href="#">Small-1</a>

        </li>
        <li><a href="#">Medium-1</a>

        </li>
        <li><a href="#">Extra large text</a>

        </li>
        <li><a href="#">Large text</a>

        </li>
        <li><a href="#">Another text</a>

        </li>
        <li><a href="#">text</a>

        </li>
    </ul>
    <ul id="more-nav">
        <li><b><a href="#">More &gt;</a></b>

            <ul class="subfilter"></ul>
        </li>
    </ul>
</div>


<br><br><br><br><br>
<div class="row shipment-step">
   <div class="col-xs-3 shipment-step-step  complete active">
      <div class="shipment-progress">
         <div class="shipment-progress-bar"></div>
      </div>
      <div class="shipment-step-icon with-hover-image">
         <div class="panel-image">
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Your Order has been placed.">
            <img class="active-image" width="40" height="40" src="<?php echo FRONTEND_THEME_URL ?>img/order-status/shopping-cart.svg">
            <img class="hover-image" width="40" height="40" src="<?php echo FRONTEND_THEME_URL ?>img/order-status/shopping-cart-white.svg">
            </a>
         </div>
      </div>
      <div class="shipment-step-info text-center">
         Ordered                        
         <p class="date">17 March 2018, 10.00 AM</p>
      </div>
   </div>
   <div class="col-xs-3 shipment-step-step">
      <div class="shipment-progress">
         <div class="shipment-progress-bar"></div>
      </div>
      <div class="shipment-step-icon with-hover-image">
         <div class="panel-image">
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Your item has been picked up by courier partner.">
            <img class="active-image" width="40" height="40" src="<?php echo FRONTEND_THEME_URL ?>img/order-status/cardboard-box.svg">
            <img class="hover-image" width="40" height="40" src="<?php echo FRONTEND_THEME_URL ?>img/order-status/cardboard-box-white.svg">
            </a>
         </div>
      </div>
      <div class="shipment-step-info text-center">
         Packed                    
         <p class="date"></p>
      </div>
   </div>
   <div class="col-xs-3 shipment-step-step ">
      <div class="shipment-progress">
         <div class="shipment-progress-bar"></div>
      </div>
      <div class="shipment-step-icon with-hover-image">
         <div class="panel-image">
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Item has been shipped.Ekart Logistics - FMPC0250515563">
            <img class="active-image" width="40" height="40" src="<?php echo FRONTEND_THEME_URL ?>img/order-status/delivery-truck.svg">
            <img class="hover-image" width="40" height="40" src="<?php echo FRONTEND_THEME_URL ?>img/order-status/delivery-truck-white.svg">
            </a>
         </div>
      </div>
      <div class="shipment-step-info text-center">
         Shipped                       
         <p class="date"></p>
      </div>
   </div>
   <div class="col-xs-3 shipment-step-step">
      <div class="shipment-progress">
         <div class="shipment-progress-bar"></div>
      </div>
      <div class="shipment-step-icon with-hover-image">
         <div class="panel-image">
            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Your item has been delivered">
            <img class="active-image" width="40" height="40" src="<?php echo FRONTEND_THEME_URL ?>img/order-status/delivered-box.svg">
            <img class="hover-image" width="40" height="40" src="<?php echo FRONTEND_THEME_URL ?>img/order-status/delivered-box-white.svg">
            </a>
         </div>
      </div>
      <div class="shipment-step-info text-center">
         Delivered                       
         <p class="date"></p>
      </div>
   </div>
</div>



<style type="text/css">
ul#more-nav, ul#nav-bar-filter {
    display: inline-block;
    vertical-align: top;
}
ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}
li {
    padding: 4px 8px 4px 8px;
    margin: 0;
}
#nav-bar-filter li {
    display: inline-block;
    font-weight: bold;
}
a {
    text-decoration: none;
    color: #666;
    font-size: 13px;
}
.filter-wrapper {
    width: 100%;
    background: #eee;
    padding: 5px 10px 5px 10px;
}
#more-nav {
    float: right;
}
.subfilter{
    padding-top: 10px;
}
.subfilter li {
    margin: 0 0 0 20px;
    padding: 5px 0 0 0;
}
</style>

<script type="text/javascript">
   $(document).ready(function () {
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
    more.css('width', smw);

    function contract() {
        var w = 0,
            outerWidth = parent.width() - smw - 50;
        for (i = 0; i < menu.children("li").size(); i++) {
            w += menu.children("li").eq(i).outerWidth();
            if (w > outerWidth) {
                menu.children("li").eq(i - 1).nextAll()
                    .detach()
                    .css('opacity', 0)
                    .prependTo(".subfilter")
                    .stop().animate({
                    'opacity': 1
                }, 300);
                break;
            }
        }
    }

    function expand() {
        var w = 0,
            outerWidth = parent.width() - smw - 20;
        menu.children("li").each(function () {
            w += $(this).outerWidth();
            return w;
        });
        for (i = 0; i < subMenu.children("li").size(); i++) {
            w += subMenu.children("li").eq(i).outerWidth();
            if (w > outerWidth) {
                var a = 0;
                while (a < i) {
                    subMenu.children("li").eq(a)
                        .css('opacity', 0)
                        .detach()
                        .appendTo("#nav-bar-filter")
                        .stop().animate({
                        'opacity': 1
                    }, 300);
                    a++;
                }
                break;
            }
        }
    }
    contract();

    $(window).on("resize", function (e) {
        ($(window).width() > ww) ? expand() : contract();
        ww = $(window).width();
    });

});
</script> -->

<div class="">
  <div class="theme-container">
    <div class="knowledge-header-block text-center">
      <div class="knowledge-head">
        <h1 class="main-head no-margin">Knowledge <span class="text-light">Base</span></h1>
        <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/Icon_KnowledgeBase_Red.svg" width="40">
      </div>          
    </div>
    <div class="knowledge-content-block">
      <div class="row">
        <div class="col-sm-3">
          <div class="col-sm-12 knowledge-tile-bg knowledge-leftsidebar-tile no-padding">           
            <ul>
              <li><a href="#">General</a></li>
              <li class="active"><a href="#">Usage Conditions</a></li>
              <li><a href="#">Payment & Pricing</a></li>
              <li><a href="#">Downloads</a></li>
              <li><a href="#">Contributions</a></li>
            </ul>           
          </div>
          <div class="col-sm-12 knowledge-tile-bg knowledge-leftsidebar-tile no-padding">           
            <ul>
              <li><a href="#">Terms & Conditions</a></li>
              <li><a href="#">Cookies</a></li>
              <li><a href="#">Privacy Policy</a></li>             
            </ul>
          </div>        
        </div>
        <div class="col-md-9">
          <div class="col-sm-12 knowledge-tile-bg knowledge-rightsidebar-tile">
            <div class="heading">
              <h3>FAQ: <span class="text-light">Usage Conditions</span></h3>
            </div>            
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      <i class="fa fa-angle-down" aria-hidden="true"></i>
                      After I've purchased photos, do I get the copyright to those images?
                    </a>
                  </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                  <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                      <i class="fa fa-angle-down" aria-hidden="true"></i>
                      Can I use your photos for printed media or physical products?
                    </a>
                  </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                      <p>As a general rule, there are few limitations as long as the photo used is not the main or only selling point of the final product. For example, you are not allowed to simply sell our images on post cards, calendars, t-shirt, mugs, etc... without significant modification.</p>
                  <p>If the photos are incorporated into the final product in a more creative way, there are usually no restrictions. For example, when you use photos as part of poster art, graphic design, collage, CD covers, etc...</p>
                  <p>For more information, please refer to our Terms & Conditions.</p>
                    </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingThree">
                  <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                      <i class="fa fa-angle-down" aria-hidden="true"></i>
                      Do you offer model releases for photos that contain recognizable people?
                    </a>
                  </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                  <div class="panel-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingfour">
                  <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                      <i class="fa fa-angle-down" aria-hidden="true"></i>
                      Do I need to credit Photobash or pay any royalties?
                    </a>
                  </h4>
                </div>
                <div id="collapsefour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingfour">
                  <div class="panel-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingfive">
                  <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsefive" aria-expanded="false" aria-controls="collapsefive">
                      <i class="fa fa-angle-down" aria-hidden="true"></i>
                      When purchasing I'm asked to select a License Type. Which one should I choose?
                    </a>
                  </h4>
                </div>
                <div id="collapsefive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingfive">
                  <div class="panel-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                  </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingsix">
                  <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsesix" aria-expanded="false" aria-controls="collapsesix">
                      <i class="fa fa-angle-down" aria-hidden="true"></i>
                      Can I use your images in products that will be sold commercially?
                    </a>
                  </h4>
                </div>
                <div id="collapsesix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingsix">
                  <div class="panel-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>