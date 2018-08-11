<div class="bread_parent">
  <div class="col-md-8">
    <ul class="breadcrumb">
        <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
        <li><a href="<?php echo base_url('backend/email_template/email_templates'); ?>"><b>Email & SMS Template</b> </a></li>
    </ul>
  </div>
  <div class="col-md-4">
    <div class="btn-group pull-right">
       <a class="btn btn-primary tooltips" href="<?php echo base_url()?>backend/email_template/email_template_add" rel="tooltip" data-placement="top" data-original-title=" Click to add new email & sms template "><i class="icon-plus"></i> Add New Email & SMS Template</a>
    </div>
  </div>
  <div class="clearfix"></div>
</div>

<div class="panel-body no-padding-top">
   <header class="tabel-head-section">
      <form action="<?php echo base_url('backend/email_template/email_templates') ?>" method="get" role="form" class="form-horizontal">
         <div class="no-padding-top">
            <table class="responsive table_head" cellpadding="5">          
               <thead>
                  <tr>
                     <th>Template Name</th>
                     <th></th>
                  </tr>
               </thead>
            <tbody>
              <tr>
               <td>
                  <div class="">                
                     <input type="text" placeholder="Template Name" class="form-control" name="template_name" value="<?php if(!empty($_GET['template_name'])) echo $_GET['template_name']; ?>">
                  </div> 
               </td>
               <td width="110"> 
                  <button class="btn btn-primary tooltips" rel="tooltip" data-placement="top" data-original-title="Search" type="submit"><i class="icon icon-search"></i></button>
                  <a class="btn btn-danger tooltips" rel="tooltip" data-placement="top" data-original-title="Reset your email template search" type="submit" href="<?php echo base_url('backend/email_template/email_templates'); ?>"> <i class="icon icon-refresh"></i></a>
               </td>
              </tr> 
              </tbody>
            </table>
         </div>
      </form>
   </header>  

  <div class="no-padding-top">
    <div class="adv-table" id="tab1">
      <table id="datatable_example" class="table-bordered responsive table table-striped table-hover">
        <thead>
          <tr>
            <th width="5%">S.No</th>
            <th width="8%">ID</th>
            <th width="30%">Template name</th>
            <th width="30%">Subject</th>
            <th wid th="10%">Created </th>
            <th wi dth="8%">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            if(!empty($templates)):
            $i=0; foreach($templates as $row){ $i++;
          ?>
            <tr>
              <td><?php echo $offset+$i."." ; ?></td>
              <td>ID - <?php echo $row->id;?></td>
              <td><a href="<?php echo base_url().'backend/email_template/email_template_edit/'.$row->id?>" class="" ><?php echo $row->template_name; ?></a></td>
              <td ><?php  echo substr($row->template_subject,0,50); ?></td>

              <td><i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo date('d M Y,h:i  A',strtotime($row->template_created)); ?></td>
              <td>
                  <a href="<?php echo base_url().'backend/email_template/email_template_edit/'.$row->id?>" class="btn btn-success btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" Edit ">
                 <i class="icon-pencil"></i> 
                  </a> 
                  <!-- <a href="javascript:void(0)" class="btn btn-danger btn-xs tooltips" rel="tooltip" rel="tooltip" data-placement="top" data-original-title="Remove" onclick="return confirmBox('Do you want to delete it ?','<?php echo base_url().'backend/email_template/templates_delete/'.$row->id; ?>')" >                        
                  <i class="icon-trash "></i></a> -->
                </td>
            </tr> 
            <?php } ?>
          <?php else: ?>
            <tr>
              <th colspan="7"> <center>No Email Template Found.</center></th>

            </tr>

          <?php endif; ?>
        </tbody>
      </table>

      <div class="row-fluid  control-group mt15 pull-right">             
        <div class="span12">
          <?php if(!empty($pagination))  echo $pagination;?>

        </div>
      </div>
    </div>
    <!-- End .content --> 
  </div>

</div>
