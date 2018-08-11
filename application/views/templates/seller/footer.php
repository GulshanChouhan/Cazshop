<footer class="footer py-5 bg-dark">
  <div class="container">
    <p class="m-0 text-center text-white">Copyright © <?php echo SITE_NAME; ?> <?php echo date('Y'); ?></p>
  </div>
  <!-- /.container -->
</footer>
<script src="<?php echo SELLER_THEME_URL; ?>js/bootstrap.min.js"></script> 
<script type="text/javascript">
  $(".tooltips").tooltip();
</script>
<?php if ($this->uri->segment(2)=='seller_information' || $this->uri->segment(2)=='seller_interview' || $this->uri->segment(2)=='products') : ?> 
<link href="<?php echo base_url(); ?>assets/seller/css/chosen.min.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/seller/js/chosen.jquery.min.js"></script>  
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/backend/admin/css/jquery-ui.css">
<script src="<?php echo base_url(); ?>assets/backend/admin/js/jquery-ui.js"></script> 

<script type="text/javascript">

jQuery(document).ready(function($){
    $(".chosen-select").chosen();
    $(".date").datepicker({
      dateFormat: 'dd-mm-yy', 
    });
    $("#dpd1").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy', 
        minDate: 'dateToday',
        numberOfMonths: 1,             
        onClose: function( selectedDate ) {
        $( "#dpd2" ).datepicker( "option", "minDate", selectedDate );
        }
    });
    $("#dpd2").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'dd-mm-yy', 
        numberOfMonths: 1,
        onClose: function( selectedDate ) {
        $( "#dpd1" ).datepicker( "option", "maxDate", selectedDate );
        }
    });
});
</script>
<?php endif; ?>


<link href="<?php echo BACKEND_THEME_URL; ?>css/sweetalert.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo BACKEND_THEME_URL; ?>js/sweetalert.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/seller/js/custom.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>validator/bvalidator/jquery.bvalidator.js"></script>
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>validator/bvalidator/themes/presenters/default.min.js"></script>
<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>validator/bvalidator/themes/gray/gray.js"></script>
<link href="<?php echo BACKEND_THEME_URL ?>validator/bvalidator/themes/gray/gray.css" rel="stylesheet" type="text/css" />

<script>
  $('.carousel').carousel({
      interval: 5000 //changes the speed
  });

  
  function confirmBox(msg, url) {
    swal({
        title: msg,
        type: "warning",
        padding: 0,
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        background: '#f1f1f1',
        buttonsStyling: false,
        confirmButtonClass: 'btn btn-confirm',
        cancelButtonClass: 'btn btn-cancle',
        confirmButtonText: 'Ok',
        cancelButtonText: 'Cancel',
        animation: false
    }, function() {
        window.location.href = url;
    });
  }
</script>


<script type="text/javascript" src="<?php echo BACKEND_THEME_URL ?>tinymce/tinymce.min.js"></script>
<script type="text/javascript">
  tinymce.init({
      selector: ".tinymce_edittor",
      relative_urls : false,
      remove_script_host : false,
      convert_urls : true,
      menubar: false,
      height:150,
      resize: false,
      plugins: [
          "advlist autolink lists link image charmap print preview anchor media",
          "searchreplace visualblocks code fullscreen",
          "insertdatetime table contextmenu paste textcolor directionality",
      ],
      image_advtab: true,
      //toolbar: "insertfile undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | preview code ", 
      toolbar: "styleselect | bold italic | bullist | link image media | preview ",    
       file_browser_callback : elFinderBrowser,  
  });
function elFinderBrowser (field_name, url, type, win) {
tinymce.activeEditor.windowManager.open({
  file: '<?php echo base_url("elfinders/index") ?>',// use an absolute path!
  title: 'File Manager',
  width: 900,
  height: 450,
  resizable: 'yes'
}, {
  setUrl: function (url) {
    win.document.getElementById(field_name).value = url;
  }
});
return false;
}

$("[data-toggle=popover]").popover({
   html: true, 
    content: function() {
    return $('#popover-content').html();
  }
});

//tool tips
$('[data-toggle="tooltip"]').tooltip();
//    popovers
$('[data-toggle="popover"]').popover();

$('body').on("touchstart", function(e){

$('[data-toggle="tooltip"]').each(function () {
        if($(this).is(e.target)){
            $(this).tooltip('show');
        }
        else{
            $(this).tooltip('hide');
        }
        
    });

    $('[data-toggle="popover"]').each(function () {
        if($(this).is(e.target)){
            $(this).popover('show');
        }
        else{
            $(this).popover('hide');
        }
    });
});
</script>

</body>
</html>