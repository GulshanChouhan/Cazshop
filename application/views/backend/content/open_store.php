<div class="bread_parent">
<div class="col-md-12">
<ul class="breadcrumb">
    <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
    <li><a href="<?php echo base_url('backend/slider/sliders'); ?>">Home Page Setting</a></li>
     <li><a href="<?php echo base_url('backend/content/open_store'); ?>"><b>IT All Starts With Great Products</b></a></li>  
</ul>
</div> 

<div class="clearfix"></div>
</div>
  
<div class="panel-body ">     
      <ul class="nav nav-tabs " role="tablist">
        <li class=""><a href="<?php echo base_url().'backend/slider/sliders' ?>"><b>Home Page slider</b></a></li>     
        <li class="active"><a href="<?php echo base_url().'backend/content/open_store' ?>"><b>IT All Starts With Great Products</b></a></li>      
        <li><a href="<?php echo base_url().'backend/content/live_stores' ?>"><b>Live Online Stores</b></a></li>
       <!-- <li><a href="<?php echo base_url().'backend/content/bulk_it' ?>"><b>Shop the stores</b></a></li>-->
        <li class=""><a href="<?php echo base_url().'backend/content/fund_it' ?>" ><b>Brand and what we do</b></a></li>
        <li ><a href="<?php echo base_url().'backend/content/we_love' ?>"><b>We love what we do</b></a></li>   
      <!-- <li><a href="<?php echo base_url().'backend/content/client_feedback' ?>"><b>Client feedback</b></a></li>     --> 
    </ul> 

    <div class="adv-table">   
    <div class="panel-body">
      <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">
          <?php echo $this->session->flashdata('msg_error');?>
         
          <div class="form-body set-height-editor">
               <textarea  class="tinymce_edittor form-control" cols="100" rows="1200" name="page_content">
                <?php if(!empty($open_store->updated_content)) { echo $open_store->updated_content; } ?></textarea>              
          </div>
          <div class="form-actiosns fluid">
            <div class="col-md-offset-4 col-md-10">
              <button  class="btn btn-primary" type="submit">Update Free Online Stores for Everyone</button>
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
<!--<div class="home-content-section clearfix howit-works-block">
<div class="col-md-6 col-sm-6 col-xs-12 block">
<h3 class="theme-head section-head">Free Online Stores for Everyone</h3>
<div class="content">
<h4>How it works</h4>
<ul class="no-padding list-unstyled text-center how-work">
<li><span class="icon"><img src="http://205.134.251.196/~examin8/CI/ssa/assets/front/images/how-work-signup-icon.png" alt="" width="55" height="68" />&nbsp; &nbsp;&nbsp;</span><span class="icon">Sign up</span></li>
<li><span class="icon"><img src="http://205.134.251.196/~examin8/CI/ssa/assets/uploads/logos/shop-icon.png" alt="" width="82" height="71" /></span> Open your <br />Free Shop</li>
<li><span class="icon"><img src="http://205.134.251.196/~examin8/CI/ssa/assets/uploads/logos/sell-to-icon.png" alt="" width="63" height="73" /></span> Sell to your <br />Audience</li>
<li><span class="icon"><img src="http://205.134.251.196/~examin8/CI/ssa/assets/uploads/logos/earn-money-icon.png" alt="" width="66" height="66" /></span>Earn Money</li>
</ul>
</div>
<div class="clearfix">&nbsp;</div>
<div class="content">
<h4>Benefits</h4>
<div class="col-md-4">
<ul class="no-padding benefits list-unstyled">
<li>No minimums</li>
<li>Mobile friendly</li>
<li>Subscribe in minutes</li>
</ul>
</div>
<div class="col-md-6">
<ul class="no-padding list-unstyled benefits">
<li>Secure shopping cart</li>
<li>Door to door delivery</li>
<li>No set-up costs or fees</li>
</ul>
</div>
<div class="clearfix">&nbsp;</div>
</div>
<div class="clearfix">&nbsp;</div>
<div class="content">
<h4>Fundraising</h4>
<div class="col-md-8 ">
<p>We give back. Help raise money for your school, teams, organization, non-profit or charity with your own customized online apparel store.</p>
<br />
<div class="text-center"><a class="btn btn-theme" href="#">Start now</a></div>
</div>
</div>
<div class="clearfix">&nbsp;</div>
</div>

<div class="col-md-6 block col-sm-6 col-xs-12"><img class="img-responsive" src="http://205.134.251.196/~examin8/CI/ssa/assets/uploads/logos/how-it-works.jpg" alt="" width="639" height="523" /></div>
</div>-->