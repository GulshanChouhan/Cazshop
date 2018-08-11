<div class="bread_parent">
<ul class="breadcrumb">
    <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
    <li><a href="<?php echo base_url('backend/slider/sliders'); ?>">Home Page Setting</a></li>
    <li><a href="<?php echo base_url('backend/content/fund_it'); ?>"><b>Brand and what we do</b></a></li>
      
</ul> 
</div> 
<br>
   <ul class="nav nav-tabs " role="tablist">
      <li class=""><a href="<?php echo base_url().'backend/slider/sliders' ?>"><b>Home Page slider</b></a></li>      
      <li class=""><a href="<?php echo base_url().'backend/content/open_store' ?>"><b>IT All Starts With Great Products</b></a></li>         
      <li class=""><a href="<?php echo base_url().'backend/content/live_stores' ?>"><b>Live Online Stores</b></a></li>
      <!--<li class=""><a href="<?php echo base_url().'backend/content/bulk_it' ?>"><b>Shop the stores</b></a></li>-->
      <li class="active"><a href="<?php echo base_url().'backend/content/fund_it' ?>" ><b>Brand and what we do</b></a></li>
      <li ><a href="<?php echo base_url().'backend/content/we_love' ?>"><b>We love what we do</b></a></li>   
    <!--   <li><a href="<?php echo base_url().'backend/content/client_feedback' ?>"><b>Client feedback</b></a></li> -->       
    </ul> 
  
    <div class="adv-table">  
      <?php if(form_error('page_content')){ ?>
        <div class="alert alert-danger">
           <button type="button" class="close" data-dismiss="alert">&times;</button> 
        <?php  echo form_error('page_content'); ?>
        </div>
      <?php } ?>    
    <div class="panel-body">
      <form role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">
          <?php echo $this->session->flashdata('msg_error');?>
         
          <div class="form-body set-height-editor">
               <textarea  class="tinymce_edittor form-control" name="page_content">
                <?php if(!empty($open_store->updated_content)) { echo $open_store->updated_content; } ?></textarea>  
          </div>
          <div class="form-actiosns fluid">
            <div class="col-md-offset-4 col-md-10">
              <button  class="btn btn-primary" type="submit">Update Buy in bulk and save</button>                                         
              </div>
            </div>
          </form>
          <!-- END FORM--> 
        </div> 
    </div>
   

<!--
<div class="home-content-section clearfix">
<div class="col-md-6 col-sm-6 col-xs-12 block">
<div class="right-img-section"><img class="img-responsive" src="http://205.134.251.196/~examin8/CI/ssa/assets/uploads/logos/bulk-and-save.jpg" alt="" width="731" height="739" /></div>
</div>

<div class="col-md-6 col-sm-6 col-xs-12 block">
<div class="buy-bulk-right">
<h3 class="theme-head section-head">Buy in Bulk and Save</h3>
<br />
<div class="content">
<h4>Simple Bulk&nbsp;</h4>
<div class="col-md-8">
<p>urSTORE is your one stop shop for your gear, apparel, uniforms, promotional products. See how we can help your bulk order needs</p>
<a href="#">Read more &gt;&gt;</a></div>
</div>
<div class="clearfix">&nbsp;</div>
<br />
<div class="content">
<ul class="no-padding list-unstyled how-work">
<li class="col-md-3"><span class="icon"><img src="http://205.134.251.196/~examin8/CI/ssa/assets/uploads/logos/bulk-sports.png" alt="" width="67" height="66" /></span> <strong>Sports</strong><br /> Tournaments Fundraisers Team Gear</li>
<li class="col-md-3"><span class="icon"><img src="http://205.134.251.196/~examin8/CI/ssa/assets/uploads/logos/school-new.png" alt="" width="78" height="66" /></span> <strong>Schools</strong><br /> Athletics Clubs Grad</li>
<li class="col-md-3"><span class="icon"><img src="http://205.134.251.196/~examin8/CI/ssa/assets/uploads/logos/comapnies.png" alt="" width="78" height="66" /></span> <strong>Companies</strong><br /> Tournaments Fundraisers Team Gear</li>
<li class="col-md-3"><span class="icon"><img src="http://205.134.251.196/~examin8/CI/ssa/assets/uploads/logos/organization.png" alt="" width="78" height="66" /></span><strong>Organizations</strong><br /> Commemorative Promotions Events</li>
</ul>
<div class="clearfix">&nbsp;</div>
<br />
<div class="text-center"><a class="btn btn-theme" href="#">Contact</a></div>
</div>
<div class="clearfix">&nbsp;</div>
</div>
</div>
</div>

-->




  
<style type="text/css">
.img_size{
  max-height: 900px;
  max-width: 900px;
}
</style>        


        
