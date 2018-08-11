<div class="bread_parent">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="<?php echo base_url('backend/superadmin/dashboard');?>"><i class="icon-home"></i> Dashboard </a></li>
         <li><a href="<?php echo base_url('backend/products/index'); ?>">Products</a></li>
         <li> Product Categories</li>
      </ul>
   </div>
   <div class="clearfix"></div>
</div>
<div class="superadmin-body panel-body partners">
   
   <?php $this->load->view('backend/products/tabMenus'); ?>

   <div class="adv-table">
      <div class="panel-body">
        
         <header class="panel-heading colum"><i class="fa fa-angle-double-right"></i> Product Categories</header>

         <div class="col-md-12">
            <div class="info-view">
               <table class="table">

               <?php 
                  if(!empty($product_info)){
                    $category_id = explode(',', $product_info->category_id);
                     if(!empty($category_id)){
                        $index=0;
                        foreach ($category_id as $row) {
               ?>
                  <tr>
                     <th><?php if($index==0){ echo "Category :"; }else{ echo "Subcategory :"; } ?></th>
                     <td> 
                        <?php 
                           $catName = getData('category',array('category_id',$row));
                           if(!empty($catName)){
                              echo $catName->category_name;
                           }else{
                              echo "-";
                           }
                        ?>
                     </td>
                  </tr>
               <?php 
                     $index++; }
                     }
                  }
               ?>
               </table>
            </div>
         </div>

      </div>
   </div>
</div>