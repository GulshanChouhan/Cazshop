<div class="bread_parent">
<div class="col-md-10">
<ul class="breadcrumb">
    <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
    <li><a href="<?php echo base_url('backend/slider/sliders'); ?>">Home Page Setting</a></li>
     <li><a href="<?php echo base_url('backend/content/live_stores'); ?>"><b>Live Online Store</b></a></li>
</ul>
</div>
<div class="col-md-2">
  <div class="btn-group tooltips add-toggle" rel="tooltips" data-placement="top" data-original-title="Add the live Store">
          <a class="btn btn-primary btn-toggle-link" id="add">
              Add New live store &nbsp;<i class="fa fa-chevron-down"></i>
          </a>
  </div>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-body ">  

 <div class="tab-pane row-fluid fade in active  toggle-inner-panel" id="form" style="<?php if(!empty($_POST)) echo"display:block"; else ?>display:none;">
  <span class="validation_info"> </span>
  <span class="validation_info">Live Store image needs to be atleast of 160 x 45 pixels and at most of 320 X 90 pixels. </span>
         <form class="form-horizontal tasi-form" role="form" method="post" action="<?php echo current_url()?>" enctype="multipart/form-data" id="form_valid">   
               <input type="hidden" name="type_action" value="1">   
              <div class="form-body">          
                      <div class="form-group">
                         <label class="col-md-2 control-label">Live Store Image :</label>
                          <div class="col-md-4">             
                                    <input type="file" name="live_store" data-bvalidator="required" data-bvalidator-msg="Please select the  Front Image">
                                    <?php echo form_error('live_store'); ?>
                          </div>
                
                        <label class="col-md-2 control-label">Link to redirect : </label>          
                          <div class="col-md-4 input-group m-bot15">
                              <span class="input-group-addon"><?php echo base_url() ?></span>
                              <input type="text" placeholder="Add the link address to redirect" class="form-control" name="page_to_redirect" value="<?php echo set_value('page_to_redirect'); ?>">         
                          </div>   

                      <label class="col-md-2 control-label">Order sequence :<span class="mandatory">*</span> </label>
                          <div class="col-md-3" >
                             <input type="text" placeholder="Arrange order No" class="form-control" name="order" value="" data-bvalidator="number,required" data-bvalidator-msg="Order No is required and must be a number">         
                         </div>

                     <div class="form-group">
                      <div class="col-md-offset -3 col-md -9">
                        <button class="btn btn-primary" name="add" type="submit">Add Logo</button>
                        </div> 
                      </div>   
                  </div>
               
              </div>
     </form>
     </div>
    <ul class="nav nav-tabs " role="tablist">
      <li class=""><a href="<?php echo base_url().'backend/slider/sliders' ?>"><b>Home Page slider</b></a></li>     
      <li class=""><a href="<?php echo base_url().'backend/content/open_store' ?>"><b>IT All Starts With Great Products</b></a></li>    
      <li class="active"><a href="<?php echo base_url().'backend/content/live_stores' ?>"><b>Live Online Stores</b></a></li>
      <!--<li><a href="<?php echo base_url().'backend/content/bulk_it' ?>"><b>Shop the stores</b></a></li>-->
      <li class=""><a href="<?php echo base_url().'backend/content/fund_it' ?>" ><b>Brand and what we do</b></a></li>
      <li ><a href="<?php echo base_url().'backend/content/we_love' ?>"><b>We love what we do</b></a></li>   
       <!--  <li><a href="<?php echo base_url().'backend/content/client_feedback' ?>"><b>Client feedback</b></a></li>  -->    
    </ul> 
    <div class="toggle-inner-panel">
      
        <form enctype= "multipart/form-data" class="form-horizontal" id="form" method="post" action="<?php echo current_url()?>" >
              <?php echo $this->session->flashdata('msg_error');?>
          <div class="form-body">
              <div class="form-group">
                   <input type="hidden" name="type_action" value="2">
                 <label class="col-md-2 control-label"> Header title of live store : </label>
                <div class="col-md-8">
                       <textarea class="form-control" cols="150" rows="2" name="title" placeholder="Main Title" data-bvalidator-msg="Main Sub title required" data-bvalidator="required"><?php if(!empty($live_store_title->title)){ echo $live_store_title->title; }else{ echo set_value('title'); } ?></textarea><?php echo form_error('title'); ?>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                      <input class="btn btn-primary btn-lg" type="submit" name="submit" value="Update Title">
                   </div>   
                </div>
              </div>  
          </div>

                
        </form>                            
    </div>

     <div class="adv-table">     
    <table id="datatable_example" class="responsive table table-striped">
      <thead>
        <tr>
          <th width="5%">#</th>          
          <th width="35%">Link to redirect</th> 
          <th width="10%">Order</th>
          <th width="10%">Store Image</th> 
          <th>Actions</th>
        </tr>
      </thead>     
      <tbody>
      <?php 
        if(!empty($live_store_img)):
          $i=0; foreach($live_store_img as $row):
        $i++;?>  
      <form enctype= "multipart/form-data" class="form-horizontal" id="form" method="post" action="<?php echo current_url()?>" >
        <tr>         
          <td>ID : #<?php if(!empty($row->id)) echo $row->id; ?>
              <input type="hidden" name="type_action" value="3">
              <input type="hidden" name="row_id" value="<?php echo $row->id; ?>">
         </td>
         <td>
            <div class="col-md-9 input-group m-bot15">
                <span class="input-group-addon"><?php echo base_url() ?></span>
                <input type="text" placeholder="Add the link address to redirect" class="form-control" name="page_to_redirect_edit" value="<?php if(!empty($row->live_store_link)){ echo $row->live_store_link; }else{ echo set_value('page_to_redirect_edit'); } ?>">         
            </div>
        </td>
        <td> 
          <input class="form-control" type="text" name="order_edit" value="<?php if(!empty($row->order)) { echo $row->order; }else{ echo set_value('order_edit'); } ?>"/>        
          </td>

          <td><img src="<?php echo base_url().$row->live_store_img?>" alt=""></td>
          <td>
              <input type="file" name="live_store">
            </td>
                  
          <td class="to_hi de_phone">
            <?php if($row->status==1){ ?>
              <a class="label label-success label-mini tooltips" href="<?php echo base_url('backend/content/changeuserstatus_t/'.$row->id.'/'.$row->status.'/0/cms_live_online_store')?>" rel="tooltip" data-placement="top" data-original-title="Change Status">Active </a> 
              <?php } 
              else{ ?><a class="label label-warning label-mini tooltips"  href="<?php echo base_url('backend/content/changeuserstatus_t/'.$row->id.'/'.$row->status.'/0/cms_live_online_store')?>" rel="tooltip" data-placement="top" data-original-title="Change Status"> Deactive </a> 
              <?php } ?>

          </td>
            <td class="ms">  
               <button value="<?php echo $row->id ?>" name="update" type="submit" class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title="Update "><i class="fa fa-repeat"></i>
               </button>                
                <a href="<?php echo base_url().'backend/content/delete_live_store/'.$row->id?>" class="btn btn-danger btn-xs tooltips" rel="tooltip" rel="tooltip" data-placement="top" data-original-title="Remove" onclick="if(confirm('Do you want to delete it ?')){return true;} else {return false;}" >                        
                  <i class="icon-trash "></i></a>                
              </td>
            </tr> 
           </form> 
          <?php  endforeach; ?>        
        </tbody>
         
        <?php else: ?>
          <tr>
            <th colspan="8"  class="msg"> <center>No Content Found.</center></th>
          </tr>
          <?php endif; ?>
        
      </table>
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