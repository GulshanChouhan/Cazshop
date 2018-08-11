<div class="bread_parent">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
         <li><a href="<?php echo base_url('backend/products/index'); ?>">Products</a></li>
         <li>Product Other Info</li>
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
         <form autocomplete="off" role="form" class="form-horizontal tasi-form" action="<?php echo current_url()?>" enctype="multipart/form-data" method="post" data-bvalidator-validate>
            <?php echo $this->session->flashdata('msg_error');?>
            <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i> Product Other Information :</header>
            <br>

            <?php 
            if(!empty($attribute_info)){
               $getOther_info=json_decode($product_info->product_other_info);
               foreach($attribute_info as $row){
                  $attr_code = $row->attribute_code;
            ?>   

               <div class="form-group">
                  <label class="col-md-2 control-label"><?php echo ucfirst($row->name); ?>:</label>
                  <div class="col-md-9">
                     <?php if($row->file_type==1){ ?>
                        <div class="col-md-12">
                           <?php if(!empty($getOther_info) && !empty($getOther_info->$attr_code)) echo $getOther_info->$attr_code; else echo "-"; ?>
                        </div>      
                     <?php }else if($row->file_type==2){ ?>
                        <div class="col-md-12">
                           <?php if(!empty($getOther_info) && !empty($getOther_info->$attr_code)) echo $getOther_info->$attr_code; else echo "-"; ?>
                        </div>   
                     <?php }else if($row->file_type==3){ ?>
                        <div class="col-md-12">
                            <?php 
                              if(!empty(json_decode($row->attribute_value)) && !empty($getOther_info->$attr_code)){ 
                                foreach (json_decode($row->attribute_value) as $key) {
                                  if(!empty($getOther_info->$attr_code) && $getOther_info->$attr_code==$key) 
                                    echo $key;
                                } 
                              }else{
                                echo "-";
                              } 
                            ?>
                                
                        </div>  
                     <?php }else if($row->file_type==4){ ?>
                        <div class="col-md-12">   
                           <?php 
                              if(!empty(json_decode($row->attribute_value)) && !empty($getOther_info->$attr_code)){ 
                                foreach (json_decode($row->attribute_value) as $key) { 
                                  if(!empty($getOther_info) && !empty($getOther_info->$attr_code) && in_array($key,json_decode($row->attribute_value))) 
                                    echo $key;
                                } 
                              }else{
                                echo "-";
                              }
                           ?>
                        </div>   
                     <?php }else if($row->file_type==5){ 
                      ?>
                        <div class="col-md-12">   
                          <?php 
                            if(!empty(json_decode($row->attribute_value)) && !empty($getOther_info->$attr_code)){ 
                              foreach (json_decode($row->attribute_value) as $key) {
                                if(!empty($getOther_info) && !empty($getOther_info->$attr_code) && in_array($key,$getOther_info->$attr_code)) 
                                  echo $key; 
                              
                              } 
                            }else{
                              echo "-";
                            }
                          ?>
                        </div>   
                     <?php }else if($row->file_type==6){ ?>
                           <?php if(!empty($getOther_info) && !empty($getOther_info->$attr_code)){ ?>

                           <?php } ?>
                        <div class="col-md-12">   

                        </div>   
                     <?php }else if($row->file_type==7){ ?>
                        <div class="col-md-12">
                           <?php 
                              $indexing = 1;
                              if(!empty(json_decode($row->attribute_value)) && !empty($getOther_info->$attr_code)){ 
                                foreach (json_decode($row->attribute_value) as $key) { 
                                  if(!empty($getOther_info) && !empty($getOther_info->$attr_code)){ 
                                    if($key==$getOther_info->$attr_code){ 
                                      echo $key; 
                                    } 
                                  }else{ 
                                    if($indexing==1){ 
                                      echo $key; 
                                    } 
                                  }
                                  $indexing++; 
                                } 
                              }else{
                                echo "-";
                              }
                           ?>
                        </div>    
                     <?php }else if($row->file_type==8){ ?>
                        <div class="col-md-12">
                           <?php if(!empty($getOther_info) && !empty($getOther_info->$attr_code)) echo $getOther_info->$attr_code; else echo "-"; ?>
                        </div>      
                     <?php }else if($row->file_type==9){ ?>
                         <div class="col-md-8">
                           <?php if(!empty($getOther_info) && !empty($getOther_info->$attr_code)) echo $getOther_info->$attr_code; else echo "-"; ?>
                        </div>
                        <div class="col-md-4">
                            <?php 
                              if(!empty(json_decode($row->attribute_value)) && !empty($getOther_info->$attr_code)){ 
                                foreach (json_decode($row->attribute_value) as $key) { 
                                  if(!empty($getOther_info->$attr_code) && $getOther_info->$attr_code==$key) 
                                    echo $key;
                                } 
                              }else{
                                echo "-";
                              } 
                            ?>
                        </div>   

                     <?php }else if($row->file_type==10){ ?>
                        <div class="col-md-12">
                            <?php if(!empty($getOther_info) && !empty($getOther_info->$attr_code)) echo $getOther_info->$attr_code; else echo "-"; ?>
                        </div>

                     <?php } ?>

                  </div>
               </div>
               <?php } ?>

               <div class="form-actiosns fluid">
                   <div class="form-btn-block">
                      <div class="col-md-12 text-center">
                         <?php if($type==1){ ?>
                          <a class="btn btn-danger" href="<?php echo base_url('backend/products/product_offer/'.$product_info_id.'/'.$product_variation_id.'/'.$type)?>">Back</a>
                          <?php }else if($product_variation_id==0 && $type==2){ ?>
                          <a class="btn btn-danger" href="<?php echo base_url('backend/products/product_variations/'.$product_info_id.'/'.$product_variation_id.'/'.$type)?>">Back</a>
                          <?php } ?>
                      </div>
                   </div>
               </div>
            <?php }else{ ?>

               <h4 class="col-md-12 text-center"><b>Product other information not required.</b></h4>

            <?php } ?>
         
         </form>
         <!-- END FORM--> 
         <?php }else{ ?>
         <div class="col-md-12 text-center">
            <h4><b><i class="fa fa-info-circle" aria-hidden="true"></i> We have not permitted you to edit the Product Other Information</b></h4>
         </div>
         <?php } ?>
      </div>
   </div>
</div>