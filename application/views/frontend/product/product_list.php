<?php 
   $btc=getCryptocurrencyRate('usd-btc');
   $eth=getCryptocurrencyRate('usd-eth');
   ?>
<div class="theme-background clearfix">
   <div id="container-wrapper" class="container-fluid clearfix ">
      <!-- =============Start Mobile fillter HTML ================ -->
      <div class="mob-filter-wrapper">
         <div class="mob-filter-width">
            <div class="mob-filter mob-sort-filter-toggle">
               <div class="mob-filter-heading">SORT BY</div>
               <div class="mob-filter-sub-head sortByNameText">None</div>
            </div>
            <div class="mob-sort-fix">
               <div class="mob-sort-fix-inner">
                  <div class="mob-sort-catg">
                     <div class="sortby">Sort by</div>
                     <div class="sortby-name-filter sb1 <?php if(!empty($search) && !empty($search['s']) && $search['s']==1) echo 'active'; ?>" onclick="searchFilter(0,1,'New & Popular')">New &amp; Popular</div>
                     <div class="sortby-name-filter sb2 <?php if(!empty($search) && !empty($search['s']) && $search['s']==2) echo 'active'; ?>" onclick="searchFilter(0,2,'Low to High')">Low to High</div>
                     <div class="sortby-name-filter sb3 <?php if(!empty($search) && !empty($search['s']) && $search['s']==3) echo 'active'; ?>" onclick="searchFilter(0,3,'High to Low')">High to Low</div>
                     <div class="sortby-name-filter sb4 <?php if(!empty($search) && !empty($search['s']) && $search['s']==4) echo 'active'; ?>" onclick="searchFilter(0,4,'Customer Review')">Customer Review</div>
                     <div class="sortby-name-filter sb5 <?php if(!empty($search) && !empty($search['s']) && $search['s']==5) echo 'active'; ?>" onclick="searchFilter(0,5,'Newest Arrivals')">Newest Arrivals</div>
                  </div>
                  <div class="mob-sort-cancel-btn mob-sort-filter-toggle">
                     <span>Cancel</span>
                  </div>
               </div>
            </div>
         </div>
         <div class="mob-filter-width ">
            <div class="mob-filter mob-main-filter-toggle">
               <div class="mob-filter-heading">FILTERS</div>
               <div class="mob-filter-sub-head">Select</div>
            </div>
         </div>
      </div>
      <!-- ==========End Mobile fillter HTML ================ -->
      <!-- ==========Start List Page HTML ================ -->
      <div class="list-bradcrum">
         <div class="left-fillter-grid">
            <div class="left-fillter-grid-bradcum">
               <?php  
                  if(!empty($category_info) && !empty($category_info->category_name)) {
                     $bread=get_category_bread_crumb_front($category_info->category_id);
                     if(!empty($bread))
                     {
                        $bread=array_reverse($bread);
                        echo '<a href="'.base_url().'"> Home </a><span class="a-list-item a-color-tertiary"><img src="'.FRONTEND_THEME_URL.'img/icons/bradcrum-right-arrow.svg" width="30"></span>';
                        echo implode('<span class="a-list-item a-color-tertiary"><img src="'.FRONTEND_THEME_URL.'img/icons/bradcrum-right-arrow.svg" width="30"></span>',$bread);
                     
                     }
                  }
                  ?>
            </div>
            <!-- <?php //echo  $this->ajax_pagination->create_links_record();   ?> -->
         </div>
      </div>
      <div class="list-page-canvas">
         <div id="blurProductListSection"></div>
         <div id="sidebar" class="nav-collapse">
            <!-- =========Start Mobile filter section========= -->
            <div class="mob-list-filter-head">
               <span>Filter by</span>
               <div class="back-icon mob-main-filter-toggle">
                  <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/left-arrow.svg" width="30">
               </div>
               <div class="reset-all">
                  Reset All
               </div>
            </div>
            <div class="mob-list-filter-btn mob-main-filter-toggle">
               Apply
            </div>
            <!-- =========End Mobile filter section========= -->
            <div class="siderbar-list">
               <div class="widget categories-left-list">
                  <div class="section-toggle section-category in">
                     <h6 class="subtitle">Categories <span class="toggle-icon"><i class="icofont icofont-minus"></i></span></h6>
                     <?php if(!empty($category_list)){ echo $category_list; } else { ?>
                     <ul>
                        <?php foreach($category_lists as $value){
                           echo "<li> <a href='".base_url('p/'.$value->category_slug)."'>" .ucwords($value->category_name). "</a> "
                           ?>
                        <?php } ?>  
                     </ul>
                     <?php } ?>
                  </div>
               </div>
               <!-- end widget -->
               <div class="widget">
                  <h4 class="refine-by">Refine by</h4>
               </div>
               <div class="widget">
                  <div class="section-toggle section-price in">
                     <h6 class="subtitle">Prices <span class="toggle-icon"><i class="icofont icofont-minus"></i></span></h6>
                     <div class="price-search">
                        <ul class="list list-unstyled custom-scroll-height pricefilter-section">
                           <li><a class="pricefilter" href="javascript:void(0)" min="0" max="25">Under $25</a></li>
                           <li><a class="pricefilter" href="javascript:void(0)" min="25" max="50">$25 to $50</a></li>
                           <li><a class="pricefilter" href="javascript:void(0)" min="50" max="100">$50 to $100</a></li>
                           <li><a class="pricefilter" href="javascript:void(0)" min="100" max="200">$100 to $200</a></li>
                           <li><a class="pricefilter" href="javascript:void(0)" min="200" max="">$200 & Above</a></li>
                        </ul>
                        <div>
                           <input type="text" name="min" value="<?php if(!empty($search) && !empty($search['min'])) echo $search['min']; ?>" id="min" class="form-control price-input" placeholder="$ Min">
                           <input type="text" name="max" value="<?php if(!empty($search) && !empty($search['max'])) echo $search['max']; ?>" id="max" class="form-control price-input" placeholder="$ Max">
                           <button class="btn btn-default" type="button" onclick="searchFilter(0)">Go</button>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- end widget -->
               <div class="widget">
                  <div class="section-toggle section-new in">
                     <h6 class="subtitle">New Arrivals <span class="toggle-icon"><i class="icofont icofont-minus"></i></span></h6>
                     <ul class="list list-unstyled custom-scroll-height" >
                        <li>
                           <div class="checkbox-input">
                              <input type="checkbox" name="na1" <?php if(!empty($search) && !empty($search['na']) && in_array(30,explode(',', $search['na']))) echo 'checked'; ?> id="na1" onchange="searchFilter(0)" value="30" class="styled na" >
                              <label for="na1">
                              <span>Last 30 days</span>
                              </label>
                           </div>
                        </li>
                        <li>
                           <div class="checkbox-input">
                              <input type="checkbox" name="na2" id="na2" onchange="searchFilter(0)" <?php if(!empty($search) && !empty($search['na']) && in_array(90,explode(',', $search['na']))) echo 'checked'; ?> value="90" class="styled na">
                              <label for="na2">
                              <span>Last 90 days</span>
                              </label>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
               <?php if(!empty($brands)){ ?>    
               <div class="widget">
                  <div class="section-toggle section-brand in">
                     <h6 class="subtitle">Brands <span class="toggle-icon"><i class="icofont icofont-minus"></i></span>
                        <a href="javascript:void(0)" style="display:<?php if(!empty($search) && !empty($search['brand']) && sizeof($search['brand'])>0) echo 'inline-block'; else echo 'none'; ?>;" attr="brand" id="brand-clear" class="attributes clear-at-dynamic" main="0">Clear </a> 
                     </h6>
                     <?php if(sizeof($brands)>12){ ?>
                     <div class="widget-search-filter-wrap clearable">
                        <input type="text" class="search-query form-control search-widget" placeholder="Search..." attr="brands">
                        <i class="icofont icofont-search"></i>
                        <i class="icofont icofont-close-line clearable__clear"></i>
                     </div>
                     <!--  <span class="clearable">
                        <input type="text" name="" value="" placeholder="">
                        <i class="clearable__clear">&times;</i>
                        </span> -->
                     <?php } ?>
                     <ul class="list list-unstyled custom-scroll-height brands-search" >
                        <?php foreach($brands as $brand){ ?>
                        <li>
                           <div class="checkbox-input">
                              <input id="brand<?php echo $brand->brand_id; ?>" onchange="searchFilter(0)" name="brand[]" class="styled brnad brand" type="checkbox"  value="<?php echo $brand->brand_name; ?>" <?php if(!empty($search) && !empty($search['brand']) && in_array($brand->brand_name,explode(',', $search['brand']))) echo 'checked'; ?>>
                              <label for="brand<?php echo $brand->brand_id; ?>">
                              <span><?php echo ucfirst($brand->brand_name); ?></span>
                              </label>
                           </div>
                        </li>
                        <?php } ?>
                     </ul>
                  </div>
               </div>
               <!-- end widget -->
               <?php } ?>
               <div class="widget">
                  <div class="section-toggle section-review in">
                     <h6 class="subtitle">Avg. Customer Review<span class="toggle-icon"><i class="icofont icofont-minus"></i></span>
                        <input type="hidden" value="<?php if(!empty($search) && !empty($search['pr'])) echo $search['pr'];  ?>" name="pr" id="pr"><a href="javascript:void(0)" style="display:<?php if(!empty($search) && !empty($search['pr']) && $search['pr']>0) echo 'inline-block'; else echo 'none'; ?>;" id="review-clear" class="review" main="0">Clear</a>
                     </h6>
                     <ul class="list list-unstyled">
                        <li>
                           <a href="javascript:void(0)" class="avg-customer-review review <?php if(!empty($search) && !empty($search['pr']) && $search['pr']==4) echo 'active'; ?>"" main="4"><i class="icon-star-medium star-medium-4"></i>
                           <span class="icon-alt">&amp; Up</span>
                           </a>
                        </li>
                        <li>
                           <a href="javascript:void(0)" class="avg-customer-review review <?php if(!empty($search) && !empty($search['pr']) && $search['pr']==3) echo 'active'; ?>"" main="3"><i class="icon-star-medium star-medium-3"></i>
                           <span class="icon-alt">&amp; Up</span>
                           </a>
                        </li>
                        <li>
                           <a href="javascript:void(0)" class="avg-customer-review review <?php if(!empty($search) && !empty($search['pr']) && $search['pr']==2) echo 'active'; ?>" main="2"><i class=" icon-star-medium star-medium-2"></i>
                           <span class="icon-alt">&amp; Up</span>
                           </a>
                        </li>
                        <li>
                           <a href="javascript:void(0)" class="avg-customer-review review <?php if(!empty($search) && !empty($search['pr']) && $search['pr']==1) echo 'active'; ?>" main="1"><i class="icon-star-medium star-medium-1"></i>
                           <span class="icon-alt">&amp; Up</span>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="widget">
                  <div class="section-toggle section-review in">
                     <h6 class="subtitle">Discount<span class="toggle-icon"><i class="icofont icofont-minus"></i></span>
                        <input type="hidden" value="<?php if(!empty($search) && !empty($search['o'])) echo $search['o'];  ?>" name="o" id="o"><a href="javascript:void(0)" class="offer" style="display:<?php if(!empty($search) && !empty($search['o']) && $search['o']>0) echo 'inline-block'; else echo 'none'; ?>;" id="offer-clear" main="0">Clear </a>
                     </h6>
                     <ul class="list list-unstyled custom-scroll-height" >
                        <li>
                           <a href="javascript:void(0)" class="discount offer <?php if(!empty($search) && !empty($search['o']) && $search['o']==10) echo 'active'; ?>" main="10" >10% Off or more</a>
                        </li>
                        <li>
                           <a href="javascript:void(0)" class="discount offer <?php if(!empty($search) && !empty($search['o']) && $search['o']==25) echo 'active'; ?>" main="25">25% Off or more</a>
                        </li>
                        <li>
                           <a href="javascript:void(0)" class="discount offer <?php if(!empty($search) && !empty($search['o']) && $search['o']==35) echo 'active'; ?>" main="35">35% Off or more</a>
                        </li>
                        <li>
                           <a href="javascript:void(0)" class="discount offer <?php if(!empty($search) && !empty($search['o']) && $search['o']==50) echo 'active'; ?>" main="50">50% Off or more</a>
                        </li>
                     </ul>
                  </div>
               </div>
               <?php $attr=array();
                  if(!empty($attributes)){ 
                     $ab='';
                     $attr_value=array();
                     if(!empty($search) && !empty($search['ab'])){
                        $ab=$search['ab'];   
                        $attribute=explode('__',$ab);
                        for($i=0;$i<sizeof($attribute);$i++)
                        {
                           if(!empty($attribute[$i]))
                           {
                              $attr=explode('--A,',$attribute[$i]);
                              if(sizeof($attr)==2){
                                 $attr_value[$attr[0]]=explode(',', $attr[1]);
                              }
                           }  
                        }  
                     }  
                     ?>
               <div class="widget">
                  <?php foreach($attributes as $attribute){
                     $values=json_decode($attribute->attribute_value);
                     if(!empty($values)){
                        $attr[]=$attribute->attribute_code;
                     ?>
                  <div class="section-toggle section-<?php echo $attribute->attribute_code; ?> <?php if(!empty($search) && !empty($attr_value) && !empty($attr_value[$attribute->attribute_code]) && sizeof($attr_value[$attribute->attribute_code])>0) echo 'in'; ?>">
                     <h6 class="subtitle"><?php echo ucfirst($attribute->name) ?> <span class="toggle-icon"><i class="icofont icofont-minus"></i></span>
                        <a href="javascript:void(0)" style="display:<?php if(!empty($search) && !empty($attr_value) && !empty($attr_value[$attribute->attribute_code]) && sizeof($attr_value[$attribute->attribute_code])>0) echo 'inline-block'; else echo 'none'; ?>;" attr="<?php echo $attribute->attribute_code; ?>" id="<?php echo $attribute->attribute_code; ?>-clear" class="attributes clear-at-dynamic" main="0">Clear </a>
                     </h6>
                     <?php if(sizeof($values)>4 && $attribute->attribute_code!='colourmap'){ ?>
                     <div class="widget-search-filter-wrap clearable">
                        <input type="text" class="search-query form-control search-widget" placeholder="Search..." attr="<?php echo $attribute->attribute_code; ?>">
                        <i class="icofont icofont-search"></i>
                        <i class="icofont icofont-close-line clearable__clear"></i>
                     </div>
                     <?php } ?>
                     <ul class="list list-unstyled custom-scroll-height <?php echo $attribute->attribute_code; ?>-search" >
                        <?php foreach ($values as $key => $value) {
                           if(!empty($value)){
                           if($value!='' && $attribute->attribute_code!='colourmap'){
                           ?>
                        <li>
                           <div class="checkbox-input">
                              <input onchange="getattributeCode(this)" attr="<?php echo $attribute->attribute_code; ?>" id="<?php echo $attribute->attribute_code.$key; ?>" class="attribute styled <?php echo $attribute->attribute_code ?>" name="attribute[<?php echo $attribute->attribute_code ?>][]" type="checkbox" value="<?php echo $value; ?>" <?php if(!empty($search) && !empty($attr_value) && !empty($attr_value[$attribute->attribute_code]) &&  in_array($value, $attr_value[$attribute->attribute_code])) echo 'checked'; ?>>
                              <label for="<?php echo $attribute->attribute_code.$key; ?>">
                              <span><?php echo ucfirst($value); ?></span>
                              </label>
                           </div>
                        </li>
                        <?php }else{ ?>
                        <li class="color-checkbox  <?php if(!empty($search) && !empty($attr_value) && !empty($attr_value[$attribute->attribute_code]) &&  in_array($value, $attr_value[$attribute->attribute_code])) echo 'active'; ?>">
                           <div class="checkbox-input ">
                              <input onchange="getattributeCode(this)"  id="<?php echo $attribute->attribute_code.$key; ?>" class="attribute styled <?php echo $attribute->attribute_code ?>" name="attribute[<?php echo $attribute->attribute_code ?>][]" type="checkbox" value="<?php echo $value; ?>"  <?php if(!empty($search) && !empty($attr_value) && !empty($attr_value[$attribute->attribute_code]) &&  in_array($value, $attr_value[$attribute->attribute_code])) echo 'checked'; ?>>
                              <label for="<?php echo $attribute->attribute_code.$key; ?>">
                                 <!-- <span><?php //echo ucfirst($value); ?></span> -->
                                 <span class="color-box-check" style="background:<?php echo $value; ?>" title="<?php echo $value; ?>"></span>
                              </label>
                           </div>
                        </li>
                        <?php } } } ?>
                     </ul>
                  </div>
                  <?php } } ?>
               </div>
               <!-- end widget -->
               <?php } ?>  
               <!--<div class="widget">
                  <h6 class="subtitle">New Collection</h6>
                  <figure>
                     <a href="javascript:void(0);">
                        <img src="http://diamondcreative.net/plus-v1.3.0/img/products/men_06.jpg" alt="collection" class="img-responsive">
                     </a>
                  </figure>
                  </div> end widget -->
            </div>
         </div>
         <section id="main-content">
            <section class="wrapper">
               <div class="row">
                  <div id="postList">
                     <div class="col-sm-12">
                        <?php if(!empty($category) && (count($category) > 10000)){ ?>
                        <div class="cat-title-block">
                           <h3 class="basic-heading">Shop by category</h3>
                        </div>
                        <ul class="list-unstyled catgory-list-grid catgory-list-grid-slider row">
                           <?php foreach($category as $row){
                              if($row->product_count>=0){
                              ?>
                           <li>
                              <div class="category-block-list-page">
                                 <div class="category-image-block">
                                    <a href="<?php  echo base_url('p/'.$row->category_slug);  ?>">
                                    <img alt="<?php echo $row->category_name ?>" src="<?php if($row->logo_image) echo base_url('assets/uploads/backend/category_img/logo/'.$row->logo_image); else echo FRONTEND_THEME_URL.'img/product-1.png'; ?>">
                                    </a>
                                 </div>
                                 <div class="category-product-desc">
                                    <div class="category-product-name">
                                       <a href="<?php  echo base_url('p/'.$row->category_slug);  ?>"><?php echo ucwords(trim($row->category_name)); ?></a>
                                    </div>
                                 </div>
                              </div>
                           </li>
                           <?php } } ?>
                        </ul>
                        <?php 
                           }if(!empty($_GET)){
                           ?>    
                        <div class="applied-filter">
                           <ul class="applied-filter-list">
                              <?php 
                                 if(!empty($_GET) && !empty($_GET['na'])){
                                   $na=explode(',',$_GET['na']);
                                   for($i=0;$i<sizeof($na);$i++)
                                   {
                                    if($na[$i]!=0){
                                       echo '<li><a href="javascript:void(0)"  class="filtered-brand">Last '.$na[$i].' days <span class="remove-icon remove-tag-filter" main="na" attr_value="'.$na[$i].'">x</span></a></li>';
                                    }
                                   }
                                  }
                                 
                                  if(!empty($_GET) &&  (isset($_GET['min']) || isset($_GET['max'])) && ($_GET['min']!=0 || $_GET['max']!=0)){
                                  
                                   if(!empty($_GET['min']))
                                    $price= $_GET['min'];
                                   else 
                                    $price='0'; 
                                 
                                   $price.=' - ';
                                   if(!empty($_GET['max']))                                  
                                    $price.= $_GET['max'];
                                   else 
                                    $price.='0';
                                 
                                   echo '<li><a href="javascript:void(0)"  class="filtered-brand">'.$price.' <span class="remove-icon remove-tag-filter" main="pricefilter" attr_value="'.$price.'">x</span></a></li>'; 
                                  } 
                                 
                                  if(!empty($_GET) &&  !empty($_GET['brand'])){
                                   $na=explode(',',$_GET['brand']);
                                   for($i=0;$i<sizeof($na);$i++)
                                   {
                                    echo '<li><a href="javascript:void(0)"  class="filtered-brand">'.$na[$i].' <span main="brand" attr_value="'.$na[$i].'" class="remove-icon remove-tag-filter">x</span></a></li>';
                                   }
                                  }
                                 
                                  if(!empty($_GET) && !empty($_GET['pr'])){
                                    echo '<li><a href="javascript:void(0)"  class="filtered-brand">'.$_GET['pr'].' Stars & Up <span class="remove-icon remove-tag-filter" main="review" attr_value="'.$_GET['pr'].'">x</span></a></li>';
                                  }
                                 
                                  if(!empty($_GET) && !empty($_GET['o'])){
                                    echo '<li><a href="javascript:void(0)"  class="filtered-brand">'.$_GET['o'].' Off or more <span main="offer" attr_value="'.$_GET['o'].'" class="remove-icon remove-tag-filter">x</span></a></li>';
                                  }
                                 
                                  $attr_value=array();
                                  if(!empty($_GET) && !empty($_GET['ab'])){
                                   $ab=$_GET['ab'];   
                                   $attribute=explode('__',$ab);
                                   for($i=0;$i<sizeof($attribute);$i++)
                                   {
                                    if(!empty($attribute[$i]))
                                    {
                                       $attr=explode('--A,',$attribute[$i]);
                                       if(sizeof($attr)==2){
                                          $attr_value[$attr[0]]=explode(',', $attr[1]);
                                       }
                                    }  
                                   }   
                                  }
                                 
                                  if(!empty($attr_value)){
                                   foreach($attr_value as $key=>$row){
                                    if(!empty($row)){
                                       for($i=0;$i<sizeof($row);$i++)
                                       {
                                          echo '<li><a href="javascript:void(0)"  class="filtered-brand">'.$row[$i].' <span class="remove-icon remove-tag-filter" main="'.$key.'" attr_value="'.$row[$i].'">x</span></a></li>';
                                       }
                                    }
                                   }
                                  }   
                                 ?>
                              <?php if(!empty($_GET['o']) || !empty($_GET['pr']) || !empty($_GET['key']) || !empty($_GET['ab']) || !empty($_GET['brand']) || !empty($_GET['min']) || !empty($_GET['max']) || !empty($_GET['na'])){ 
                                 if((isset($_GET['min']) && $_GET['min']!=0) || (isset($_GET['max']) && $_GET['max']!=0) || (isset($_GET['na']) && $_GET['na']!="0,0")){
                                 ?>
                              <li class="clear-all-list"><a href="<?php echo base_url('p/'.$category_slug); ?>" class="clear-all">Clear All</a></li>
                              <?php } } ?>
                           </ul>
                        </div>
                        <?php } ?>
                        <div class="clearfix"></div>
                        <div class="a-row">
                           <div class="well well-sm grid-well-section clearfix">
                              <?php if(!empty($category_info) && !empty($category_info->category_name)){ ?>
                              <div class="cat-title-block">
                                 <h2><?php echo ucwords($category_info->category_name); ?></h2>
                              </div>
                              <?php } ?>
                              <div class="right-fillter-grid">
                                 <span class="sort-by">Sort By</span>
                                 <select class="form-control" id="sortBy" onchange="searchFilter()">
                                    <option value="1" <?php if(!empty($search) && !empty($search['s']) && $search['s']==1) echo 'selected'; ?>>New &amp; Popular</option>
                                    <option value="2" <?php if(!empty($search) && !empty($search['s']) && $search['s']==2) echo 'selected'; ?>>Price: Low to High</option>
                                    <option value="3" <?php if(!empty($search) && !empty($search['s']) && $search['s']==3) echo 'selected'; ?>>Price: High to Low</option>
                                    <option value="4" <?php if(!empty($search) && !empty($search['s']) && $search['s']==4) echo 'selected'; ?>>Avg. Customer Review</option>
                                    <option value="5" <?php if(!empty($search) && !empty($search['s']) && $search['s']==5) echo 'selected'; ?>>Newest Arrivals</option>
                                 </select>
                                 <div class="grid-box-change">
                                    <a href="javascript:void(0)" id="list" class="list-box product-list <?php if($gird) echo 'active'; ?>">
                                    <i class="fa fa-th-large" aria-hidden="true"></i>
                                    </a>
                                    <a href="javascript:void(0)" id="grid" class="grid-box product-list <?php if(!$gird) echo 'active'; ?>">
                                    <i class="fa fa-th" aria-hidden="true"></i>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div id="products" class="a-row list-group brands-products">
                           <?php if(!empty($products)): foreach($products as $product): ?>
                           <div class="item width-product-list grid-group-item <?php if($gird) echo 'list-group-item'; ?>">
                              <div class="product-tile">
                                 <div class="image-block <?php if(empty($product->second_image)) echo 'signle-image'; ?>">
                                    <a class="image-without-hover" href="<?php echo base_url('pd/'.$product->slug.'/'.base64_encode($product->product_variation_id)); ?>">
                                    <img src="<?php if($product->image) echo base_url('assets/uploads/seller/products/small_thumbnail/'.$product->image); ?>">
                                    </a>
                                    <?php if(!empty($product->second_image)){ ?>
                                    <a class="image-on-hover" href="<?php echo base_url('pd/'.$product->slug.'/'.base64_encode($product->product_variation_id)); ?>">
                                    <img src="<?php if($product->second_image) echo base_url('assets/uploads/seller/products/small_thumbnail/'.$product->second_image); ?>">
                                    </a>
                                    <?php } ?>
                                    <?php $offer=round((($product->sell_price-$product->base_price)/$product->sell_price)*100);
                                       if($offer>0){
                                        ?>
                                    <span class="offer-sticker-tag offer-tag-overflow"><?php echo $offer; ?>%</span>
                                    <?php } ?>     
                                    <?php if($product->brand_name){ ?>     
                                    <div class="product-name">
                                       <a href="<?php echo base_url('pd/'.$product->slug.'/'.base64_encode($product->product_variation_id)); ?>"><?php echo ucfirst($product->brand_name); ?></a>
                                    </div>
                                    <?php } ?>           
                                 </div>
                                 <div class="product-desc">
                                    <!-- <span class="rating">
                                       <div class="rating-btn">3.3 ★</div> <span>(25)</span>
                                       </span> -->          
                                    <div class="short-desc">
                                       <a class="" href="<?php echo base_url('pd/'.$product->slug.'/'.base64_encode($product->product_variation_id)); ?>"><?php echo ucfirst($product->title); ?> </a>
                                    </div>
                                    <div class="pricing-block clearfix">
                                       <div class="price-tag clearfix">
                                          <div class="dollar-price">
                                             <span class="base-price">
                                             <span class="small-base-price-symbol">$</span><?php echo number_format($product->base_price,2); ?>
                                             </span>                       
                                             <?php if($product->base_price<$product->sell_price){
                                                echo '<span class="shell-price"><span class="small-base-price-symbol">$</span><del>'.number_format($product->sell_price,2).'</del></span>';
                                                } ?> 
                                          </div>
                                          <div class="cripto-price">
                                             <!-- <span class="bitcoin" data-toggle="tooltip" data-placement="top" title="<?php echo number_format($btc*$product->base_price,8); ?> BTC">
                                             <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/bitcoin35.svg">
                                             </span>
                                             <span class="ethereum" data-toggle="tooltip" data-placement="top" title="<?php echo number_format($eth*$product->base_price,8); ?> ETH">
                                             <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/ethereum35.svg">
                                             </span> -->
                                             <?php 
                                                $wishListProduct = getRow('wish_list',array('user_id'=>user_id(), 'product_variation_id'=>$product->product_variation_id), array('wish_list_id'));
                                                if(!empty($wishListProduct)){
                                                ?>
                                             <div class="wishlist-icon" data-toggle="tooltip" data-placement="top" title="Remove from Wishlist">   
                                                <a href="javascript:void(0)">
                                                <span class="heart-icon">
                                                <img class="removeFromWishlist" pID="<?php echo base64_encode($product->product_variation_id); ?>" src="<?php echo FRONTEND_THEME_URL ?>img/icons/heart-full.svg" width="22">
                                                </span> 
                                                </a>           
                                             </div>
                                             <?php }else{ ?>
                                             <div class="wishlist-icon" data-toggle="tooltip" data-placement="top" title="Add to Wishlist">
                                                <a href="javascript:void(0)">
                                                <span class="heart-icon">
                                                <img class="addToWishlist" pID="<?php echo base64_encode($product->product_variation_id); ?>" src="<?php echo FRONTEND_THEME_URL ?>img/icons/heart-empty.svg" width="22">
                                                </span>     
                                                </a>                                      
                                             </div>
                                             <?php } ?>
                                          </div>
                                       </div>
                                       <?php if($product->total_rating>0){ ?>
                                       <div class="rating">
                                          <span class="event_star star_small" data-starnum="<?php echo number_format($product->sum_rating,1); ?>"><i></i></span>
                                          <span class="rating-number">(<?php echo $product->total_rating; ?>)</span>
                                          <div class="rating-tooltip-tile-hover">
                                             <div class="rating-tooltip-inner clearfix">
                                                <div class="rating-tooltip-content clearfix">
                                                   <div class="col-sm-4 no-padding left-side">
                                                      <div class="rating-view text-center">
                                                         <div class="number"><?php echo number_format($product->sum_rating,1); ?></div>
                                                         <div class="start">★</div>
                                                      </div>
                                                      <div class="number-of-ratings">
                                                         <span><?php echo $product->total_rating; ?> Ratings </span>
                                                      </div>
                                                   </div>
                                                   <div class="col-sm-8 no-padding right-side">
                                                      <div class="progress-rating-bar">
                                                         <ul>
                                                            <li class="rating-bar-list">
                                                               <div class="ranking-points">
                                                                  <div class="number">5</div>
                                                                  <div class="start">★</div>
                                                               </div>
                                                               <div class="progress progress-slider">
                                                                  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 100%;">
                                                                  </div>
                                                               </div>
                                                               <div class="review-count">
                                                                  <div class="review-number"><?php echo ($product->rating5) ? $product->rating5 :0; ?></div>
                                                               </div>
                                                            </li>
                                                            <li class="rating-bar-list">
                                                               <div class="ranking-points">
                                                                  <div class="number">4</div>
                                                                  <div class="start">★</div>
                                                               </div>
                                                               <div class="progress progress-slider">
                                                                  <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 80%;">
                                                                  </div>
                                                               </div>
                                                               <div class="review-count">
                                                                  <div class="review-number"><?php echo ($product->rating4) ? $product->rating4 :0; ?></div>
                                                               </div>
                                                            </li>
                                                            <li class="rating-bar-list">
                                                               <div class="ranking-points">
                                                                  <div class="number">3</div>
                                                                  <div class="start">★</div>
                                                               </div>
                                                               <div class="progress progress-slider">
                                                                  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 60%;">
                                                                  </div>
                                                               </div>
                                                               <div class="review-count">
                                                                  <div class="review-number"><?php echo ($product->rating3) ? $product->rating3 :0; ?></div>
                                                               </div>
                                                            </li>
                                                            <li class="rating-bar-list">
                                                               <div class="ranking-points">
                                                                  <div class="number">2</div>
                                                                  <div class="start">★</div>
                                                               </div>
                                                               <div class="progress progress-slider">
                                                                  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 20%;">
                                                                  </div>
                                                               </div>
                                                               <div class="review-count">
                                                                  <div class="review-number"><?php echo ($product->rating2) ? $product->rating2 :0; ?></div>
                                                               </div>
                                                            </li>
                                                            <li class="rating-bar-list">
                                                               <div class="ranking-points">
                                                                  <div class="number">1</div>
                                                                  <div class="start">★</div>
                                                               </div>
                                                               <div class="progress progress-slider">
                                                                  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 10%;">
                                                                  </div>
                                                               </div>
                                                               <div class="review-count">
                                                                  <div class="review-number"><?php echo ($product->rating1) ? $product->rating1 :0; ?></div>
                                                               </div>
                                                            </li>
                                                         </ul>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <?php } ?>
                                       <!-- end rating section-->          
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <?php endforeach; else: ?>
                           <div class="no-product-found">
                              <div class="noresult-block">
                                 <div class="noresult-img no-result-img-block">
                                    <img src="<?php echo base_url('assets/frontend/img/empty-icon/no-product-found.png'); ?>">
                                 </div>
                                 <div class="noresult-content">
                                    <h4>No Product available</h4>
                                 </div>
                              </div>
                              <!--                                <img src="<?php //echo FRONTEND_THEME_URL.'img/icons/no-roduct-found.png' ?>"/>
                                 <p>No Product available.</p> -->
                           </div>
                           <?php endif; ?>                              
                        </div>
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
                        <?php echo $this->ajax_pagination->create_links(); ?>
                        <div class="clearfix"></div>
                     </div>
                  </div>
                  <div class="clearfix"></div>
                  <br>
               </div>
            </section>
         </section>
      </div>
   </div>
   <!-- ==========End List Page HTML ================ -->
   <?php if(!empty($most_rated_or_discounted)){ ?>
   <div class="container-fluid home-section">
      <h2 class="basic-heading"><?php echo $most_ratedDiscounted_heading; ?></h2>
      <div class="product-slider">
         <?php foreach($most_rated_or_discounted as $product){ ?>
         <div class="product-tile">
            <div class="image-block <?php if(empty($product->second_image)) echo 'signle-image'; ?>">
               <a class="image-without-hover" href="<?php echo base_url('pd/'.$product->slug.'/'.base64_encode($product->product_variation_id)); ?>">
               <img src="<?php if($product->image) echo base_url('assets/uploads/seller/products/small_thumbnail/'.$product->image); ?>" alt="<?php echo ucfirst($product->title); ?>">
               </a>
               <?php if(!empty($product->second_image)){ ?>
               <a class="image-on-hover" href="<?php echo base_url('pd/'.$product->slug.'/'.base64_encode($product->product_variation_id)); ?>">
               <img src="<?php if($product->second_image) echo base_url('assets/uploads/seller/products/small_thumbnail/'.$product->second_image); ?>" alt="<?php echo ucfirst($product->title); ?>">
               </a>
               <?php } ?>
               <?php $offer=round((($product->sell_price-$product->base_price)/$product->sell_price)*100);
                  if($offer>0){
                   ?>
               <span class="offer-sticker-tag offer-tag-overflow"><?php echo $offer; ?>%</span>
               <?php } ?>     
               <?php if($product->brand_name){ ?>     
               <div class="product-name">
                  <a href="<?php echo base_url('pd/'.$product->slug.'/'.base64_encode($product->product_variation_id)); ?>"><?php echo ucfirst($product->brand_name); ?></a>
               </div>
               <?php } ?>           
            </div>
            <div class="product-desc">
               <!-- <span class="rating">
                  <div class="rating-btn">3.3 ★</div> <span>(25)</span>
                  </span> -->          
               <div class="short-desc">
                  <a class="" href="<?php echo base_url('pd/'.$product->slug.'/'.base64_encode($product->product_variation_id)); ?>"><?php echo ucfirst($product->title); ?> </a>
               </div>
               <div class="pricing-block clearfix">
                  <div class="price-tag clearfix">
                     <div class="dollar-price">
                        <span class="base-price">
                        <span class="small-base-price-symbol">$</span><?php echo number_format($product->base_price,2); ?>
                        </span>                       
                        <?php if($product->base_price<$product->sell_price){
                           echo '<span class="shell-price"><span class="small-base-price-symbol">$</span><del>'.number_format($product->sell_price,2).'</del></span>';
                           } ?> 
                     </div>
                     <div class="cripto-price">
                        <!-- <span class="bitcoin" data-toggle="tooltip" data-placement="top" title="<?php echo number_format($btc*$product->base_price,8); ?> BTC">
                        <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/bitcoin35.svg">
                        </span>
                        <span class="ethereum" data-toggle="tooltip" data-placement="top" title="<?php echo number_format($eth*$product->base_price,8); ?> ETH">
                        <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/ethereum35.svg">
                        </span> -->  
                        <?php 
                           $wishListProduct = getRow('wish_list',array('user_id'=>user_id(), 'product_variation_id'=>$product->product_variation_id), array('wish_list_id'));
                           if(!empty($wishListProduct)){
                           ?>
                        <div class="wishlist-icon" data-toggle="tooltip" data-placement="top" title="Remove from Wishlist">   
                           <a href="javascript:void(0)">
                           <span class="heart-icon">
                           <img class="removeFromWishlist" pID="<?php echo base64_encode($product->product_variation_id); ?>" src="<?php echo FRONTEND_THEME_URL ?>img/icons/heart-full.svg" width="22">
                           </span> 
                           </a>           
                        </div>
                        <?php }else{ ?>
                        <div class="wishlist-icon" data-toggle="tooltip" data-placement="top" title="Add to Wishlist">
                           <a href="javascript:void(0)">
                           <span class="heart-icon">
                           <img class="addToWishlist" pID="<?php echo base64_encode($product->product_variation_id); ?>" src="<?php echo FRONTEND_THEME_URL ?>img/icons/heart-empty.svg" width="22">
                           </span>     
                           </a>                                      
                        </div>
                        <?php } ?>              
                     </div>
                  </div>
                  <?php if($product->total_rating>0){ ?>
                  <div class="rating">
                     <span class="event_star star_small" data-starnum="<?php echo number_format($product->sum_rating,1); ?>"><i></i></span>
                     <span class="rating-number">(<?php echo $product->total_rating; ?>)</span>
                     <div class="rating-tooltip-tile-hover">
                        <div class="rating-tooltip-inner clearfix">
                           <div class="rating-tooltip-content clearfix">
                              <div class="col-sm-4 no-padding left-side">
                                 <div class="rating-view text-center">
                                    <div class="number"><?php echo number_format($product->sum_rating,1); ?></div>
                                    <div class="start">★</div>
                                 </div>
                                 <div class="number-of-ratings">
                                    <span><?php echo $product->total_rating; ?> Ratings </span>
                                 </div>
                              </div>
                              <div class="col-sm-8 no-padding right-side">
                                 <div class="progress-rating-bar">
                                    <ul>
                                       <li class="rating-bar-list">
                                          <div class="ranking-points">
                                             <div class="number">5</div>
                                             <div class="start">★</div>
                                          </div>
                                          <div class="progress progress-slider">
                                             <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 100%;">
                                             </div>
                                          </div>
                                          <div class="review-count">
                                             <div class="review-number"><?php echo ($product->rating5) ? $product->rating5 :0; ?></div>
                                          </div>
                                       </li>
                                       <li class="rating-bar-list">
                                          <div class="ranking-points">
                                             <div class="number">4</div>
                                             <div class="start">★</div>
                                          </div>
                                          <div class="progress progress-slider">
                                             <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 80%;">
                                             </div>
                                          </div>
                                          <div class="review-count">
                                             <div class="review-number"><?php echo ($product->rating4) ? $product->rating4 :0; ?></div>
                                          </div>
                                       </li>
                                       <li class="rating-bar-list">
                                          <div class="ranking-points">
                                             <div class="number">3</div>
                                             <div class="start">★</div>
                                          </div>
                                          <div class="progress progress-slider">
                                             <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 60%;">
                                             </div>
                                          </div>
                                          <div class="review-count">
                                             <div class="review-number"><?php echo ($product->rating3) ? $product->rating3 :0; ?></div>
                                          </div>
                                       </li>
                                       <li class="rating-bar-list">
                                          <div class="ranking-points">
                                             <div class="number">2</div>
                                             <div class="start">★</div>
                                          </div>
                                          <div class="progress progress-slider">
                                             <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 20%;">
                                             </div>
                                          </div>
                                          <div class="review-count">
                                             <div class="review-number"><?php echo ($product->rating2) ? $product->rating2 :0; ?></div>
                                          </div>
                                       </li>
                                       <li class="rating-bar-list">
                                          <div class="ranking-points">
                                             <div class="number">1</div>
                                             <div class="start">★</div>
                                          </div>
                                          <div class="progress progress-slider">
                                             <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width: 10%;">
                                             </div>
                                          </div>
                                          <div class="review-count">
                                             <div class="review-number"><?php echo ($product->rating1) ? $product->rating1 :0; ?></div>
                                          </div>
                                       </li>
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php } ?>
                  <!-- end rating section-->                
               </div>
            </div>
         </div>
         <?php } ?>
      </div>
   </div>
   <?php } ?>
</div>
<input type="hidden" name="attribute" id="attribute_value" value="">
<script type="text/javascript">
   var key='';
   <?php if(isset($_GET['key'])){ ?>
   key="<?php echo $_GET['key'] ?>";
   <?php } ?>  
   function getParameterByName(name, url) {
       if (!url) url = window.location.href;
       name = name.replace(/[\[\]]/g, "\\$&");
       var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
           results = regex.exec(url);
       if (!results) return null;
       if (!results[2]) return '';
       return decodeURIComponent(results[2].replace(/\+/g, " "));
   }  
   
   var base_url='<?php echo base_url('p/'.$category_slug); ?>';   
   $(document).ready(function() {
      $('body').on('click','#list',function(event){
         event.preventDefault();
         $('#products .item').addClass('list-group-item');
         $('.product-list').removeClass('active');
         $(this).addClass('active');
         var url = window.location.href;
         var s=getParameterByName('s');
         if(s!= null && s!='')
            window.history.pushState("title","Product List",url.replace("s="+s, "s=0"));
         else if(url.indexOf('?') != -1)
            window.history.pushState("title","Product List",url+'&s=0');
         else
            window.history.pushState("title","Product List",base_url+'?s=0');
      });
   
      $('body').on('click','#grid',function(event){
         event.preventDefault();
         $('#products .item').removeClass('list-group-item');
         $('#products .item').addClass('grid-group-item');
         $('.product-list').removeClass('active');
         $(this).addClass('active');
         var url = window.location.href;
         var s=getParameterByName('s');
         if(s!= null && s!='')
            window.history.pushState("title","Product List",url.replace("s="+s, "s=1"));
         else if(url.indexOf('?') != -1)
            window.history.pushState("title","Product List",url+'&s=1');
         else
            window.history.pushState("title","Product List",base_url+'?s=1'); 
      });
   
   });
   
   
   $('body').on('click','.remove-tag-filter',function(){
   
      var main=$(this).attr('main');
      var value=$(this).attr('attr_value');
      $(this).closest('li').remove();
   
      if ($('.applied-filter-list li').length <=1) {
          $('.applied-filter').remove();
      }
        if(main=='pricefilter')
        {
           $('#min').val('');
           $('#max').val('');
        }else if(main=='review' || main=='offer' || main=='colourmap'){
           if(main=='review'){
              $('#pr').val('');
              $('.'+main+'[main*="'+value+'"]').removeClass('active');
              $('#review-clear').hide();
           }
           if(main=='offer'){
              $('#o').val('');
              $('.'+main+'[main*="'+value+'"]').removeClass('active');
              $('#offer-clear').hide();
           }      
           if(main=='colourmap'){
              $('.'+main+'[value*="'+value+'"]').removeAttr('checked');
              $('.'+main+'[value*="'+value+'"]').closest('li').removeClass('active');
              // $('#review-clear').hide();
           }   
        }else{
           $('.'+main+'[value*="'+value+'"]').removeAttr('checked');
        }   
      getattributeCode(0);
   
   });
   
   
   function searchFilter(page_num, sortBy='', sortByName='') {
      page_num = page_num?page_num:0;
   
        if(!sortBy){
           var sortBy = $('#sortBy').val();
           var sortByName = $("#sortBy option:selected").text();
        }else{
           var sortBy = sortBy;
           var sortByName = sortByName;
           $('.mob-sort-fix').toggleClass('show-toggle');
           $('body').toggleClass('body-off-scroll');
        }
      
        $('.sortByNameText').html(sortByName);
        $('.sortby-name-filter').removeClass('active');
        $('.sb'+sortBy).addClass('active');
   
      var grid=0;
      var min=$('#min').val();
      var max=$('#max').val();
      var pr=$('#pr').val();
      var o=$('#o').val();
      var na='';

      $("#blurProductListSection").removeClass("blurProductList");
      $('#blurProductListSection').addClass('blurProductList');

      if($('#na1').is(':checked'))
         na='30,';
      else
         na='0,';
      if($('#na2').is(':checked'))
         na+='90';
      else
         na+='0';
      var brand = $("input[name='brand[]']:checkbox:checked").map(function(){return $(this).val();}).get().toString();
      if(brand!='')
      {
         $('#brand-clear').css("display", "inline-block");
      }else{
         $('#brand-clear').hide();
      }
      if($('#list').hasClass('active'))
         grid=1;
      var attribute=$('#attribute_value').val();
      $.ajax({
         type: 'POST',
         url: '<?php echo base_url(); ?>products/ajaxPaginationData/'+page_num,
         data:'page='+page_num+'&s='+sortBy+'&category_id=<?php echo $category_id ?>&category_slug=<?php echo $category_slug ?>&grid='+grid+'&min='+min+'&max='+max+'&na='+na+'&brand='+brand+'&ab='+attribute+'&key='+key+'&pr='+pr+'&o='+o,
         beforeSend: function () {
            $('.loading').show();
         },
         success: function (html) {
            console.log(html);
            $('html, body').animate({scrollTop: '0px'}, 500);
            $("#blurProductListSection").removeClass("blurProductList");
            $('#postList').html(html);
            if (!$('.applied-filter-list li').length) {
                $('.applied-filter').remove();
            }
            $('.loading').fadeOut("slow");
            window.history.pushState("title","Product List",base_url+'?page='+page_num+'&g='+grid+'&s='+sortBy+'&min='+min+'&max='+max+'&na='+na+'&brand='+brand+'&ab='+attribute+'&key='+key+'&pr='+pr+'&o='+o);
            productlistSize();
         }
      });
   }
   
     $(document).ajaxStop(function(){
         console.log("All AJAX requests completed");
     });
   
   $('.review').click(function(){   
      $('.review').removeClass('active');
      var pr=$(this).attr('main');
      if(pr>0)
      {
         $(this).addClass('active');
         $('#pr').val(pr);
         $('#review-clear').css("display", "inline-block");
      }else{
         $('#pr').val('');
         $('#review-clear').hide();
      }
      searchFilter(0);
   });
   
   
   $('.attributes').click(function(){
      var id=$(this).attr('attr');
      if(id=='colourmap'){
         $('.color-checkbox').removeClass('active');
      }
      $(this).hide();
      $('.'+id).prop('checked', false);
      searchFilter(0);
   });
   
   
   $('.offer').click(function(){ 
      $('.offer').removeClass('active');
      var pr=$(this).attr('main');
      if(pr>0)
      {
         $(this).addClass('active');
         $('#o').val(pr);
         $('#offer-clear').css("display", "inline-block");
      }else{
         $('#0').val('');
         $('#offer-clear').hide();
      }
      searchFilter(0);
   });
   
   
   $('body').on('click', '.pricefilter', function (){
      var thisAttr = $(this);
      min = thisAttr.attr("min");
      max = thisAttr.attr("max");
   
      $('#min').val(min);
      $('#max').val(max);
      searchFilter(0);
   
   });
   
   var attr='<?php echo implode(',',$attr) ?>';
   attr=attr.split(',');
   function getattributeCode(obj)
   {
      var value='';
      var attribute = '';
      $("li.color-checkbox").removeClass('active');
      for(var i=0;i<attr.length;i++){
         var attribute = '';
         attribute=$("input[name='attribute["+attr[i]+"][]']:checkbox:checked").map(function(){
            if(attr[i]=='colourmap')
               $(this).closest('li').addClass('active');
            return $(this).val();}).get().toString();
         if(attribute!='')
         {
            value+='__';
            value+=attr[i]+'--A,'+attribute;
            $('#'+attr[i]+'-clear').css("display", "inline-block");
         }else
            $('#'+attr[i]+'-clear').hide();  
      }
      $('#attribute_value').val(value);
      searchFilter(0)
   }
   
   $(document).ready(function() {
       $('.section-toggle h6').click(function() {
            $(this).parent().toggleClass('in',500); 
       });
   });
   
</script>
<script type="text/javascript">
   $(document).ready(function() {
      $('.search-widget').keyup(function(){
            var valThis = $(this).val().toLowerCase();
            var section=$(this).attr('attr');
         $('.'+section+'-search>li>div>label>span').each(function(){
            var text = $(this).text().toLowerCase();
            (text.indexOf(valThis) == 0) ? $(this).closest('li').show(200) : $(this).closest('li').hide(200);            
            });
      });
   
      /**
       * Clearable text inputs
       */
   
      $(".clearable").each(function() {
   
         var $inp = $(this).find("input:text"),
         $cle = $(this).find(".clearable__clear");
   
         $inp.on("input", function(){
            //$cle.toggle(this.value);
              $cle.toggle(!!this.value);
         });
   
         $cle.on("touchstart click", function(e) {
            e.preventDefault();
            $inp.val("").trigger("input");
            $('.search-widget').trigger('keyup');
         });
   
      });
   });
</script>