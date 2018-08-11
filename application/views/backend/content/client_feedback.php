<div class="bread_parent">
<div class="col-md-8">
<ul class="breadcrumb">
    <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard  </a></li>
    <li><a href="<?php echo base_url('backend/slider/sliders'); ?>">Home Page Setting</a></li>
    <li><a href="<?php echo base_url('backend/content/client_feedback'); ?>"><b>Client Feedback</b> </a></li>
</ul> 
</div> 
<div class="col-md-4">
  <div class="btn-group pull-right">
          <a class="btn btn-primary tooltips" href="<?php echo base_url()?>backend/content/client_feedback_add" rel="tooltip" data-placement="left" data-original-title="Click to add new feedback" >Add New Feedback
      <i class="icon-plus"></i></a>      
       </div>
</div>
<div class="clearfix"></div>
</div>

   <ul class="nav nav-tabs " role="tablist">
      <li class=""><a href="<?php echo base_url().'backend/slider/sliders' ?>"><b>Home Page slider</b></a></li>      
      <li class=""><a href="<?php echo base_url().'backend/content/open_store' ?>"><b>Free Online Stores for Everyone</b></a></li>       
      <li class=""><a href="<?php echo base_url().'backend/content/live_stores' ?>"><b>Live Online Stores</b></a></li>
      <li class=""><a href="<?php echo base_url().'backend/content/bulk_it' ?>"><b>Shop the stores</b></a></li>
      <li class=""><a href="<?php echo base_url().'backend/content/fund_it' ?>" ><b>Buy in Bulk and Save </b></a></li>
      <li ><a href="<?php echo base_url().'backend/content/we_love' ?>"><b>We love what we do</b></a></li>   
      <!-- <li class="active"><a href="<?php echo base_url().'backend/content/client_feedback' ?>"><b>Client feedback</b></a></li>    -->  
    </ul>

<div class="panel-body">
  <div class="adv-table">

    <table id="datatable_example" class="responsive table table-striped" >
      <thead>
        <tr>
          <th width="5%" class="jv no_sort">#</th>
          <th width="15%" class="no_sort">Client image</th> 
          <th width="50%" class="no_sort">Feedback</th>       
          <th>Order</th>           
          <th width="10%" class="to_hide_phone ue no_sort">Status</th>          
          <th width="10%" class="ms no_sort ">Actions</th>
        </tr>
      </thead>
      <tbody>
        <form role="" class="form-horizontal" action="<?php echo current_url()?>"  method="post">   
        <?php 
        if(!empty($feedback)):
          $i=$offset; foreach($feedback as $row): 
        $i++;?>
        <tr>
          <td><?php echo $i.".";?></td>
         
          <td> <img  class="img_size" src="<?php if(!empty($row->client_image)){ echo base_url().$row->client_image; } ?>"> </td>  

          <td class=""><?php if(!empty($row->feedback))  echo word_limiter( $row->feedback,50); ?></td>  
          <td>  <input class="form-control" type="text" name="order[<?php echo $row->id ?>]" value="<?php if(!empty($row->order)) echo $row->order; ?>"/>
              <?php echo form_error('order[]'); ?></td>
        

          <td class="to_hide_phone">
            <?php if($row->status==1){ ?>
            <a class="label label-success label-mini tooltips" href="<?php echo base_url('backend/content/changeuserstatus_t/'.$row->id.'/'.$row->status.'/'.$offset.'/cms_client_feedback')?>" rel="tooltip" data-placement="top" data-original-title="Click to Deactive">Active </a> 
            <?php } 
            else{ ?><a class="label label-warning label-mini tooltips"  href="<?php echo base_url('backend/content/changeuserstatus_t/'.$row->id.'/'.$row->status.'/'.$offset.'/cms_client_feedback')?>" rel="tooltip" data-placement="top" data-original-title="Click to Active" > Deactive </a> 
            <?php } ?>
          </td>
         
          <td class="ms">
           
              <a href="<?php echo base_url().'backend/content/client_feedback_edit/'.$row->id.'/'.$offset?>"  class="btn btn-primary btn-xs tooltips" rel="tooltip" data-placement="top" data-original-title=" Edit ">
                <i class="icon-pencil"></i> 
              </a> 
              <a href="<?php echo base_url().'backend/content/client_feedback_delete/'.$row->id.'/'.$offset?>" class="btn btn-danger btn-xs tooltips" rel="tooltip" rel="tooltip" data-placement="top" data-original-title="Delete" onclick="if(confirm('Do you want to delete it ?')){return true;} else {return false;}" >                        
                <i class="icon-trash "></i></a> 
             
            </td>           
          </tr> 
        <?php  endforeach; ?>
        <tr><td colspan="8">
            <button type="submit" class="btn btn-primary pull-right tooltips" rel="tooltip" data-placement="left" data-original-title="Update order Sequence" name="update">
            <i class="fa fa-repeat"></i> Update Order Sequence </button>
         </td></tr>
      
      <?php else: ?>
        <tr>
          <th colspan="6"  class="msg"> <center>No Feedback Found.</center></th>

        </tr>

      <?php endif; ?>
     </form> 
    </tbody>
  </table>

  <div class="row-fluid  control-group mt15">             

    <div class="span12">
      <?php if(!empty($pagination))  echo $pagination;?>              
    </div>

  </div>
</div>
</div>

<style type="text/css">
.img_size{
  max-width: 100px;
  max-height: 100px;
}
</style>
