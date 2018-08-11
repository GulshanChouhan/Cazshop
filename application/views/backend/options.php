<div class="bread_parent">
   <ul class="breadcrumb">
      <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
      <li><a href="<?php echo base_url('backend/settings'); ?>"><b>Setting</b> </a></li>
   </ul>
</div>
<div class="col-md-12 ">
   <div class="portlet box green">
      <div class="portlet-body form">
         <div class="panel-body">
            <div class="">
               <form action="<?php echo current_url(''); ?>" method="post" class ="form-horizontal">
                  <div class="form-body">
                     <header class="panel-heading colum"><i class="fa fa-gear fa-lg"></i> Setting</header>
                     <br>
                     <?php if (!empty($options)): ?>
                     <?php foreach ($options as $row): ?>
                     <div class="form-group">
                        <label class="col-md-3 control-label"><?php echo $row->option_name ?> <?php if($row->option_id==33) echo " (In Percentage)"; ?><span class="error">*</span></label>
                        <div class="col-md-8">
                           <?php if($row->option_value != strip_tags($row->option_value)) { ?>
                           <textarea name="<?php echo trim($row->option_name) ?>" placeholder="Enter short about us" class="form-control" rows="5"><?php echo $row->option_value ?></textarea>
                           <?php }else{ ?>
                           <input type="text" name="<?php echo trim($row->option_name) ?>" placeholder="<?php echo $row->option_name ?>" class="form-control"  value="<?php echo $row->option_value?>">
                           <?php  } ?>
                           <?php echo form_error(trim($row->option_name)); ?>
                        </div>
                     </div>
                     <?php endforeach ?>
                     <?php endif ?>
                  </div>
                  <!--form-body -->
                  <div class="form-btn-block">
                     <div class="col-md-10 center-block">
                        <div class="form-group text-center">
                           <button class="btn btn-primary" type="submit"> Update </button>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
</div>
