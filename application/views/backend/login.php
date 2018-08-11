<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="">

    <title><?php echo SITE_NAME ?> | Admin login</title>
    <link rel="icon" href="/assets/admin/images/favicon.ico" type="image/x-icon" />

     <link href='https://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo BACKEND_THEME_URL?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo BACKEND_THEME_URL?>css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo BACKEND_THEME_URL?>plugin/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="<?php echo BACKEND_THEME_URL?>css/style.css" rel="stylesheet">
    <link href="<?php echo BACKEND_THEME_URL?>css/style-responsive.css" rel="stylesheet" />
</head>

<body class="lock-screen" onload="startTime()">
        <div id="time"></div>
        <?php echo form_open(current_url(), array('class'=>'form-signin')); ?>
	
		<div class="login-logo">  
			<a href="<?php echo base_url()?>">
				<img src="<?php echo BACKEND_THEME_URL ?>images/superadmin-logo.png" class="logo">
			</a>
		</div>	
         <?php if($this->session->flashdata('msg_error')): ?>
         <div class="text-center">
                                  
        <span class="help-block btn btn-danger" style="width: 90%;">
        <?php echo $this->session->flashdata('msg_error'); ?></span>
                 
    </div>
    <?php endif; ?>
    <div class="login-wrap">
            
            <input type="text" class="form-control" placeholder="Email" autofocus  name="email">
            <?php echo form_error('email')?>
            <input  name="password" type="password" class="form-control" placeholder="Password">
           <?php echo form_error('password')?>
            <button class="btn btn-lock" type="submit">Sign in
                        <i class="icon-arrow-right"></i>
                    </button>
         
        </div>
      </form>
    </div>
   

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo BACKEND_THEME_URL?>js/jquery.js"></script>
    <script src="<?php echo BACKEND_THEME_URL?>js/bootstrap.min.js"></script>

  <script>
        function startTime()
        {
            var today=new Date();
            var h=today.getHours();
            var m=today.getMinutes();
            var s=today.getSeconds();
            // add a zero in front of numbers<10
            m=checkTime(m);
            s=checkTime(s);
            document.getElementById('time').innerHTML=h+":"+m+":"+s;
            t=setTimeout(function(){startTime()},500);
        }

        function checkTime(i)
        {
            if (i<10)
            {
                i="0" + i;
            }
            return i;
        }
    </script>
<style type="text/css" media="screen">
.logo{
	margin: 12px;
}
.login-logo img.logo {
    width: 190px;
}
span{
    color: #0C0C0C;
	font-size: 16px;
	font-weight: bold;
	padding: 0px;
	margin: 0px;
}
</style>
  </body>
</html>
