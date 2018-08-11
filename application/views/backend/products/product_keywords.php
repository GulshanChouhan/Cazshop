<div class="bread_parent">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
         <li><a href="<?php echo base_url('backend/products/index'); ?>">Products</a></li>
         <li>Product Keywords</li>
      </ul>
   </div>
   <div class="clearfix"></div>
</div>
<div class="superadmin-body panel-body partners">
   
   <?php $this->load->view('backend/products/tabMenus'); ?>

   <?php
      if(!empty($product_info_id) && !empty($product_variation_id)){
        if($product_variationsData->type_of_product==2){
          $showForm = 0;
        }else{
          $showForm = 1;
        }
      }else if(!empty($product_info_id)){
        $showForm = 1;
      }
   ?>
   
   <div class="adv-table">
      <div class="panel-body">

        <?php if($showForm==1){ ?>
         <form role="form" autocomplete="off" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post">

            <div class="col-md-12">
               <div class="input_fields_container">
               <?php 
               if(empty($_POST))
                  $_POST['keywords']=json_decode($product_info->keywords);
               if(!empty($_POST) && !empty($_POST['keywords'])){
               for($i=0;$i<sizeof($_POST['keywords']);$i++){
               ?>
               <div class="form-group">
                  <label class="col-md-2 control-label">Search Term :</label>
                  <div class="input-group col-md-9">
                    <?php echo ucfirst($_POST['keywords'][$i]); ?>               
                  </div>
               </div>
               <?php } } ?>            
            </div>
             <div class="col-md-12"><label class="col-md-2 "></label><div class="input-group col-md-9"><span class="error"><?php echo form_error('keywords[]'); ?> </span></div></div>
         </div>
         <hr>
            <div class="form-actiosns fluid">
                <div class="form-btn-block">
                   <div class="col-md-12 text-center">
                      <?php if($type==1){ ?>
                      <a class="btn btn-danger" href="<?php echo base_url('backend/products/product_descriptions/'.$product_info_id.'/'.$product_variation_id.'/'.$type)?>">Back</a>
                      <?php }else if($product_variation_id==0 && $type==2){ ?>
                      <a class="btn btn-danger" href="<?php echo base_url('backend/products/product_other_info/'.$product_info_id.'/'.$product_variation_id.'/'.$type)?>">Back</a>
                      <?php } ?>
                   </div>
                </div>
             </div>
         </form>
         <?php }else{ ?>
         <div class="col-md-12 text-center">
            <h4><b><i class="fa fa-info-circle" aria-hidden="true"></i> We have not permitted you to edit the Product Keywords Information</b></h4>
         </div>
         <?php } ?>
      </div>
   </div>
</div>
<script>
$(document).ready(function(){
 var max_fields_limit      = 10; //set limit for maximum input fields
    var x = 1; //initialize counter for text box
    $('.add_more_button').click(function(e){ //click event on add more fields button having class add_more_button
        e.preventDefault();
            x++; //counter increment
            $('.input_fields_container').append('<div class="form-group"><label class="col-md-2 control-label"></label><div class="input-group col-md-9"><input autocomplete="off" class="input form-control" placeholder="Search Terms"  name="keywords[]" type="text"><div class="input-group-addon"><a href="javatpoint:void(0)" class="remove_field" style="margin-left:10px;">Remove</a></div></div></div>'); //add input field
        
    });  
    $('.input_fields_container').on("click",".remove_field", function(e){ //user click on remove text links
        e.preventDefault(); $(this).parents('div.form-group').remove(); x--;
    });
 });
</script>   
