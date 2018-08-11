<section class="admin-background admin-page">
	<div class="container-fluid">
		<div class="row dashboard">
		    <div class="clearfix dashboard-width-wrap">
			    <?php $this->load->view('frontend/account/left_menus'); ?>
			    <div class="col-md-10 col-sm-9 dashboard-right-warp">
			    	<?php msg_alert(); ?> 
			        <div class="col-lg-12 col-md-12">
			         	<div class="dashboaed-breadcrumb-wrapper">
			         		<nav aria-label="breadcrumb">
							  <ul class="breadcrumb">
							    <li class="breadcrumb-item">
							    	<a href="<?php echo base_url('account/dashboard'); ?>">Dashboard</a>
							    </li>
							    <li class="breadcrumb-item active" aria-current="page">Transaction</li>
							  </ul>
							</nav>
			         	</div>
			         	<div class="clearfix"></div>
		      		</div>
		      		<div class="clearfix"></div>
               		<?php msg_alert(); ?>
			    	<div class="dashboard-right section-white no-padding-top">
			    		<div class="col-lg-12 col-md-12">
				            <div class="heading">
				            	<img src="<?php echo FRONTEND_THEME_URL ?>img/icons/dashboard-icons/verification-gray.svg" width="25"> 
				            	Transaction History
				         	</div>
				         	<div class="clearfix"></div>
			      		</div>
			      		
					    <div class="col-lg-12 col-md-12">
                             <div class="adv-table table-responsive" id="tab1">
                             	<?php if(!empty($orders)){ ?>
                                <table id="datatable_example" class="transaction-table table-bordered responsive table table-striped table-hover">
                                   <thead class="thead_color">
                                      <tr>
                                         <th class="jv no_sort" width="6%">
                                         	#
                                         </th>
                                         <th>Order No.</th>
                                         <th width="15%">Transaction Method</th>
                                         <th>Total Amount</th>
                                         <th>Payment Date</th>
                                         <th width="6%">Action</th>
                                      </tr>
                                   </thead>
                                   <tbody>
                                   	  <?php $i=1; foreach ($orders as $row) {
                                   	   ?>
	                                      <tr>
	                                      	<td><?php echo $i; ?>.</td>
	                                      	<?php
	                                      		$o_id = base64_encode($row->o_id);
			        							$orderDetailIDs = base64_encode($row->orderDetailIDs);
			        						?>
	                                      	<td><a class="link-text" href="<?php echo base_url('account/order_details/'.$o_id.'/'.$orderDetailIDs); ?>"><?php echo $row->order_id; ?></a></td>
	                                      	<td>
	                                      		<?php 
	                                      			if(!empty($row->currency_type))
	                                      		 		echo ucfirst(getCurrency($row->currency_type));
	                                      		 	else 
	                                      		 		echo "-"; 
	                                      		?>
	                                      	</td>
	                                      	<td>
	                                      		<?php
                                                    $price = getOrderNamePrice($row->orderDetailIDs)['price'];
                                                    if($price){
                                                      if($row->currency_type==1){
                                                        $totalGross = $price * $row->currency_amount_in_ethereum;
                                                      }else if($row->currency_type==2){
                                                        $totalGross = $price * $row->currency_amount_in_bitcoin;
                                                      }else{
                                                        $totalGross = $price * $row->currency_amount_in_dollor;
                                                      }
                                                      echo getCurrencyIcon($row->currency_type).''.number_format($totalGross, 8); 
                                                    }else{
                                                      echo "0.00";
                                                    }  
                                                ?>
	                                      	</td>
	                                      	<td><?php echo date('d M Y',strtotime($row->created)); ?></td>
	                                      	<td>
	                                      		<a class="btn btn-info btn-xs tooltips" href="<?php echo base_url('account/order_details/'.$o_id.'/'.$orderDetailIDs); ?>" rel="tooltip" data-placement="top" data-original-title="View Transaction Details">
	                                      			<i class="icofont icofont-eye-alt"></i>
	                                      		</a>
	                                      	</td>
	                                      </tr>
                                      <?php $i++; } ?>
                                   </tbody>
                                </table>
                                <div class="row-fluid  control-group mt15">
                                   <div class="span12">
                                      <?php if(!empty($pagination))  echo $pagination; ?>
                                   </div>
                                </div>
                                <?php }else{ ?>
                                <div class="col-md-12">
			                        <br><br><br>
			                        <div class="noresult-block text-center">
			                          <div class="noresult-img">
			                            <img src="<?php echo base_url('assets/frontend/img/empty-icon/bank-building.svg'); ?>">
			                          </div>
			                          <div class="noresult-content">
			                            <h4>No Transactions found</h4>
			                          </div>
			                        </div>
				                </div>
                              <?php } ?>
                             </div>
                           </div>
				    </div>
			    </div>
			</div>
	    </div>
	</div>
</section>

<script>
if($('.dashboard').length != 0){
	$(window).on("load resize", function () {
	winWidthnew = $('body').width();
	if(winWidthnew >=768){
		var dashboard_left = $('.dashboard-left').outerHeight();
		var dashboard_right  = $('.dashboard-right').outerHeight();
		if(dashboard_left <= dashboard_right){
			$('.dashboard-left').css('height' , dashboard_right);
		}
		else{
			$('.dashboard-left').css('height' , '400px;');
		}
	}
	}).resize();
}
</script>
