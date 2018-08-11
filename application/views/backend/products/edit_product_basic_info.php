<div class="bread_parent">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
         <li><a href="<?php echo base_url('backend/products/index'); ?>">Products</a></li>
         <li>Product Basic Information</li>
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
         <form role="form" autocomplete="off" class="form-horizontal tasi-form" action="<?php echo current_url(); ?>" enctype="multipart/form-data" method="post" data-bvalidator-validate> 
            

            <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i> Product Basic Information :</header>
            <br>
            <div class="form-group">
               <label class="col-md-2 control-label">Product Title  :</label>
               <div class="col-md-9">
                  <?php if(!empty($product_info->title)){ echo ucfirst($product_info->title); }else{ echo "-"; } ?>
               </div>
            </div>

            <div class="form-group">
               <label class="col-md-2 control-label">Choose Brand Name :</label>
               <div class="col-md-9">
                  <?php 
                     if(!empty($product_info->brand_name) && !empty($brand_info)){
                        foreach ($brand_info as $row) {
                           if($row->brand_name==$product_info->brand_name){
                              echo ucfirst($row->brand_name);
                           } 
                        }
                     }else{
                        echo "-";
                     }
                  ?>
               </div>
            </div>

            <div class="form-group">
               <label class="col-md-2 control-label">Manufacturer Part Number :</label>
               <div class="col-md-9">
                  <?php if(!empty($product_info->manufacturer_part_number)){ echo ucfirst($product_info->manufacturer_part_number); }else{ echo "-"; } ?>
               </div>
            </div>

            <div class="form-group">
               <label class="col-md-2 control-label">Short Description :</label>
               <div class="col-md-9">
                  <?php if(!empty($product_info->short_description)){ echo ucfirst($product_info->short_description); }else{ echo "-"; } ?>
               </div>
            </div>

            <div class="form-group">
               <label class="col-md-2 control-label">Status:</label>
               <div class="col-md-9">
                  <?php if($product_info->status==1){ echo "Active"; }elseif($product_info->status==2){ echo "Deactive"; } ?>
               </div>
            </div>

            <?php
            
            $json_product_variation_info = array();
            $product_variation_info = product_variation_info($product_info_id);
            if(!empty($product_variation_info)){
               $json_product_variation_info = json_decode($product_variation_info->product_variation_info);
            }

            $getbasic_info=json_decode($product_info->product_basic_info);
            if(!empty($attribute_info)){
               foreach($attribute_info as $row){
                  if (!array_key_exists($row->attribute_code,$json_product_variation_info)){
                     $attr_code = $row->attribute_code;
            ?>   

               <div class="form-group">
                  <label class="col-md-2 control-label"><?php echo ucfirst($row->name);  ?><?php if($row->tooltip_content){ ?>   :<?php } ?></label>
                  <div class="col-md-9">
                     <?php if($row->file_type==1){ ?>

                           <?php if(!empty($getbasic_info) && !empty($getbasic_info->$attr_code)) echo ucfirst($getbasic_info->$attr_code); else echo "-"; ?>

                     <?php }else if($row->file_type==2){ ?>

                           <?php if(!empty($getbasic_info) && !empty($getbasic_info->$attr_code)) echo ucfirst($getbasic_info->$attr_code); else echo "-"; ?>

                     <?php }else if($row->file_type==3){ ?>

                              <?php 
                                 if(!empty(json_decode($row->attribute_value))){ 
                                    foreach (json_decode($row->attribute_value) as $key) { 
                                       if(!empty($getbasic_info->$attr_code) && $getbasic_info->$attr_code==$key) 
                                          echo ucfirst($key);
                                       else
                                          echo "-";
                                    } 
                                 } 
                              ?>
                           

                     <?php }else if($row->file_type==4){ ?>
                           
                           <?php 
                              if(!empty(json_decode($row->attribute_value))){ 
                                 foreach (json_decode($row->attribute_value) as $key) { 
                                    if(!empty($getbasic_info) && !empty($getbasic_info->$attr_code) && in_array($key,$getbasic_info->$attr_code)) 
                                       echo ucfirst($key);
                                    else
                                       echo "-";
                                 } 
                              } 
                           ?>

                     <?php }else if($row->file_type==5){ ?>
                           
                              <?php 
                                 if(!empty(json_decode($row->attribute_value))){ 
                                    foreach (json_decode($row->attribute_value) as $key) {
                                       if(!empty($getbasic_info) && !empty($getbasic_info->$attr_code) && in_array($key,$getbasic_info->$attr_code)) 
                                          echo ucfirst($key);
                                       else
                                          echo "-";
                                    } 
                                 } 
                              ?>

                     <?php }else if($row->file_type==6){ ?>
                           <?php if(!empty($getbasic_info) && !empty($getbasic_info->$attr_code)){ ?>

                           <?php } ?>
                     <?php }else if($row->file_type==7){ ?>

                        <?php 
                           $indexing = 1;
                              if(!empty(json_decode($row->attribute_value))){ 
                                 foreach (json_decode($row->attribute_value) as $key) {
                                    if(!empty($getbasic_info) && !empty($getbasic_info->$attr_code)){ 
                                       if($key==$getbasic_info->$attr_code){ 
                                          echo ucfirst($key); 
                                       }else{
                                          echo "-";
                                       } 
                                    }else{ 
                                       if($indexing==1){ 
                                          echo ucfirst($key); 
                                       }else{
                                          echo "-";
                                       } 
                                    }
                                    $indexing++; 
                                 } 
                              }
                        ?>

                     <?php }else if($row->file_type==8){ ?>

                        <?php if(!empty($getbasic_info) && !empty($getbasic_info->$attr_code)) echo ucfirst($getbasic_info->$attr_code); else echo "-"; ?>

                     <?php }else if($row->file_type==9){ ?>
                           
                        <?php if(!empty($getbasic_info) && !empty($getbasic_info->$attr_code)) echo ucfirst($getbasic_info->$attr_code); else echo "-"; ?>


                        <?php 
                           if(!empty(json_decode($row->attribute_value)) && !empty($getbasic_info->$attr_code)){ 
                              foreach (json_decode($row->attribute_value) as $key){
                                 if(!empty($getbasic_info->$attr_code) && $getbasic_info->$attr_code==$key){
                                    echo ucfirst($key);
                                 }else{
                                    echo "-";
                                 } 
                              } 
                           }
                        ?>
                           
                    <?php }else if($row->file_type==10){ ?>
                      
                        <?php if(!empty($getbasic_info) && !empty($getbasic_info->$attr_code)) echo ucfirst($getbasic_info->$attr_code); else echo "-"; ?>
                      
                     <?php } ?>

                     <span class="error"><?php echo form_error('basic_info['.$row->attribute_code.']'); ?> </span>
                  </div>
               </div>

            <?php } } } ?>
         
            <div class="form-actiosns fluid">
                <div class="form-btn-block">
                   <div class="col-md-12 text-center">
                      <a class="btn btn-danger" href="<?php echo base_url('backend/products/edit_product_category/'.$product_info_id.'/'.$product_variation_id.'/'.$type); ?>">Back</a>
                   </div>
                </div>
            </div>
         </form>
         <!-- END FORM--> 
         <?php }else{ ?>
         <div class="col-md-12 text-center">
            <h4><b><i class="fa fa-info-circle" aria-hidden="true"></i> We have not permitted you to edit the Product Basic Information</b></h4>
         </div>
         <?php } ?>
      </div>
   </div>
</div>

</div>
<script src="<?php echo BACKEND_THEME_URL ?>js/bootstrap3-typeahead.min.js"></script>
<script type="text/javascript">
   $('input.typeahead').typeahead({
      minLength: 0,
      maxItem: 15,
      order: "asc",
      hint: true,
      accent: true,
      searchOnFocus: true,
      source:  function (query, process) {
         var attr=this.$element.attr('main');
         return $.get('<?php echo base_url(); ?>backend/common/autocomplete', { query: query,attribute_code:attr }, function (data) {
            data = $.parseJSON(data);
               return process(data);
           });
       }
   });

   $(document).ready(function(){
      $('form').bValidator();
   });
</script>