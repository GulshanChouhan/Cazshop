<div class="bread_parent">
<div class="col-md-12">
<ul class="breadcrumb">
    <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
    <li><a href="<?php echo base_url('backend/slider/sliders'); ?>">Home Page Setting</a></li>
     <li><a href="<?php echo base_url('backend/content/open_store'); ?>"><b>We love what we do</b></a></li>  
</ul>
</div> 

<div class="clearfix"></div>
</div>
  
<div class="panel-body ">     
      <ul class="nav nav-tabs " role="tablist">
      <li class=""><a href="<?php echo base_url().'backend/slider/sliders' ?>"><b>Home Page slider</b></a></li>     
      <li ><a href="<?php echo base_url().'backend/content/open_store' ?>"><b>IT All Starts With Great Products</b></a></li>      
	    <li><a href="<?php echo base_url().'backend/content/live_stores' ?>"><b>Live Online Stores</b></a></li>
      <!--<li><a href="<?php echo base_url().'backend/content/bulk_it' ?>"><b>Shop the stores</b></a></li>-->
      <li class=""><a href="<?php echo base_url().'backend/content/fund_it' ?>" ><b>Brand and what we do</b></a></li>
	    <li class="active"><a href="<?php echo base_url().'backend/content/we_love' ?>"><b>We love what we do</b></a></li>   
      <!-- <li><a href="<?php echo base_url().'backend/content/client_feedback' ?>"><b>Client feedback</b></a></li>    -->  
    </ul> 

    <div class="adv-table">   
    <div class="panel-body">
      <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">
          <?php echo $this->session->flashdata('msg_error');?>
         
          <div class="form-body set-height-editor">
               <textarea  class="tinymce_edittor form-control" cols="100" rows="1200" name="page_content">
                <?php if(!empty($we_love->updated_content)) { echo $we_love->updated_content; } ?></textarea>              
          </div>
          <div class="form-actiosns fluid">
            <div class="col-md-offset-4 col-md-10">
              <button  class="btn btn-primary" type="submit">Update We love what we do</button>
              </div>
            </div>
          </form>
          <!-- END FORM--> 
        </div> 
    </div>
   
     	
	</div>



<style>
label{

font-size: 16px;
font-weight: 400;
}

.back{
  background: rgba(240, 238, 238, 0.28);
margin: 0px 0px 20px 0px;
padding: 15px;
box-shadow: 1px 1px 3px 1px;
}

.registration_heading{
	font-size: 20px;
line-height: 20px;
padding: 3px;
font-weight: bold;
}
</style>

<!--commanted code-->
<!--<div>
<div class="open-store text-center">
<h3>ONLINE STORES FOR EVERYONE!</h3>
<h4>Now at 1,104,276 Custom E-Stores and Counting!</h4>
<h5>See why more than 3,000 schools <a href="http://205.134.251.196/~examin8/CI/ssa/"> choose us <img src="http://205.134.251.196/~examin8/CI/ssa/assets/uploads/bg_image/tag-arrow.png" alt="" /></a></h5>
</div>
<div class="open-store-block">
<div class="col-md-3 col-lg-3 col-sm-4 col-xs-10">
<div class="store-col">
<div class="media"><span class="media-left"><img class="wow zoomIn" src="http://205.134.251.196/~examin8/CI/ssa/assets/uploads/bg_image/build-stores1.png" alt="..." /> </span>
<div class="media-body"><strong class="media-heading">OPEN YOUR STORE</strong>
<p>Create your free online store in minutes including your own designs, logos or artwork!</p>
</div>
</div>
<div class="media"><span class="media-left"><img class="wow zoomIn" src="http://205.134.251.196/~examin8/CI/ssa/assets/uploads/bg_image/shipdeliver1.png" alt="..." /> </span>
<div class="media-body"><strong class="media-heading">WE DO ALL THE WORK</strong>
<p>We receive the orders, produce the products and ship directly to your customers!</p>
</div>
</div>
<div class="media"><span class="media-left"> <img class="wow zoomIn" src="http://205.134.251.196/~examin8/CI/ssa/assets/uploads/bg_image/MINIMUMS1.png" alt="..." /> </span>
<div class="media-body"><strong class="media-heading">NO INVENTORY, NO MINIMUMS</strong>
<p>We carry the inventory and you can order one piece at a time on demand!</p>
</div>
</div>
</div>
<div class="clearfix">&nbsp;</div>
</div>
<div class="col-md-6 col-lg-6 col-sm-4 col-xs-10"><img class="img-responsive wow zoomIn" src="http://205.134.251.196/~examin8/CI/ssa/assets/uploads/bg_image/my-store.png" alt="" />
<div class="clearfix">&nbsp;</div>
</div>
<div class="col-md-3 col-lg3 col-sm-4 col-xs-10">
<div class="store-col">
<div class="media"><span class="media-left"> <img class="wow zoomIn" src="http://205.134.251.196/~examin8/CI/ssa/assets/uploads/bg_image/funding1.png" alt="..." /> </span>
<div class="media-body"><strong class="media-heading">RAISING FUNDS ONLINE</strong>
<p>Open your free online store and receive a generous commission from every sale!</p>
</div>
</div>
<div class="media"><span class="media-left"> <img class="wow zoomIn" src="http://205.134.251.196/~examin8/CI/ssa/assets/uploads/bg_image/no-fee1.png" alt="..." /> </span>
<div class="media-body"><strong class="media-heading">NO MONTHLY COSTS OR FEES</strong>
<p>Your online store is free. There are no risks and no monthly fees!</p>
</div>
</div>
<div class="media"><span class="media-left"><img class="wow zoomIn" src="http://205.134.251.196/~examin8/CI/ssa/assets/uploads/bg_image/per-pice1.png" alt="..." /> </span>
<div class="media-body"><strong class="media-heading">BULK WHOLESALE ORDERS</strong>
<p>When you need to place a bulk order we also provide bulk wholesale discounts!</p>
</div>
</div>
</div>
</div>
<div class="clearfix">&nbsp;</div>
</div>
</div>-->