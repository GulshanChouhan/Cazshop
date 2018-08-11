<div class="">
<div class="theme-container">
   <div class="knowledge-header-block text-center">
      <div class="knowledge-head">
         <h1 class="main-head no-margin">Frequently Asked <span class="text-light">Question</span></h1>
         <img src="<?php echo FRONTEND_THEME_URL ?>img/icons/Icon_KnowledgeBase_Red.svg" width="40">
      </div>
   </div>
   <div class="knowledge-content-block">
      <div class="row">
        <?php if(!empty($question_ans)) { ?>
        <div class="col-sm-12 knowledge-tile-bg knowledge-rightsidebar-tile">
           <div class="heading">
              <h3>
              	<?php if(!empty($category->category_name)){ echo $category->category_name; }?>
                <!-- <span class="text-light">Usage Conditions</span> -->
              </h3>
           </div>
           <div class="panel-group" id="<?php echo $category->category_slug; ?>" role="tablist" aria-multiselectable="true">
              <?php $i=0; foreach($question_ans as $row){ ?>
              <div class="panel panel-default">
                 <div class="panel-heading" role="tab" id="heading<?php  echo $row->faq_id; ?>">
                    <h4 class="panel-title">
                       <a role="button" data-toggle="collapse" data-parent="#<?php echo $category->category_slug; ?>" href="#collapse<?php echo  $row->faq_id; ?>" aria-expanded="true" aria-controls="collapseOne" class="collapsed<?php //if($i!=0) echo 'collapsed'; ?>">
                       <i class="fa fa-angle-down" aria-hidden="true"></i>
                       <?php echo $row->question; ?>
                       </a>
                    </h4>
                 </div>
                 <div id="collapse<?php echo $row->faq_id; ?>" class="panel-collapse collapse<?php //if($i==0) echo 'in'; $i++; ?>in" role="tabpanel" aria-labelledby="heading<?php  echo $row->faq_id; ?>">
                    <div class="panel-body">
                       <?php echo $row->answer; ?>
                    </div>
                 </div>
              </div>
              <?php } ?>  
           </div>
        </div>
        <?php   } ?>
        <div class="col-sm-12 knowledge-tile-bg knowledge-rightsidebar-tile">
            <?php if(!empty($sub_category)) {
               $ii=0;
    			foreach($sub_category as $sub){
     			if(!empty($sub_question_ans[$sub->faq_sub_category_id]))
     			{ 
          	?>
          		<?php if($ii==0){ ?><div class="row"><?php } ?>
	               <div class="col-md-6 quest-catg-<?php echo $sub->sub_category_name; ?>">
	                  <div class="a-row">
	                     <div class="col-md-12">
	                        <h4 class="topic-name" style="font-weight: 600;"><?php echo $sub->sub_category_name; ?></h4>
	                     </div>
	                  </div>
	                  <div class="a-row">
	                     <div class="col-sm-12">
	                        <div class="panel-group" id="<?php echo $sub->faq_sub_category_slug; ?>" role="tablist" aria-multiselectable="true">
	                           <?php $i=0; foreach($sub_question_ans[$sub->faq_sub_category_id] as $row){ ?>
	                           <div class="panel panel-default">
	                              <div class="panel-heading" role="tab" id="heading<?php echo $row->faq_id; ?>">
	                                 <h4 class="panel-title">
	                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#<?php echo $sub->faq_sub_category_slug; ?>" href="#collapse<?php echo $row->faq_id; ?>" aria-expanded="false" aria-controls="collapseTwo" class="collapsed<?php //if($i!=0) echo 'collapsed'; ?>">
	                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
	                                    <?php echo $row->question;?>
	                                    </a>
	                                 </h4>
	                              </div>
	                              <div id="collapse<?php echo $row->faq_id; ?>" class="panel-collapse collapse <?php //if($i==0) echo 'in'; $i++; ?>" role="tabpanel" aria-labelledby="heading<?php  echo $row->faq_id; ?>">
	                                 <div class="panel-body">
	                                    <?php echo $row->answer;?>
	                                 </div>
	                              </div>
	                           </div>
	                           <?php } ?>
	                        </div>
	                     </div>
	                  </div>
	               </div>
	            <?php if($ii==1){ ?></div><?php } ?>
               <?php } $ii++; if($ii==2) $ii=0; } } ?>
        </div>
      </div>
   </div>
</div>
