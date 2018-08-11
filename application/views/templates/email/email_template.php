<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>Welcome to <?php echo SITE_NAME; ?></title>
      <style type="text/css">
         body {margin: 0; padding: 0; min-width: 100%!important;line-height: 100%;}
         .content {width: 100%; max-width: 600px;}
      </style>
   </head>
   <body yahoo bgcolor="#ececec" style="font-family: arial,sans-serif, sans-serif;color: #373d3f;    text-shadow: 0 0 1px rgba(0, 0, 0, 0.2);background-color: #ececec;-padding-top: 30px;">
      <div style="background-color: #ececec;">
         <table width="600" align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" style="font-family: arial,sans-serif, sans-serif;width: 600px;margin:0 auto;">
            <tr bgcolor="#ececec">
               <td align="center" style="font-family: arial,sans-serif, sans-serif;padding-top: 20px;"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/frontend/img/copico-logo-black.png" style="width:200px"></a></td>
            </tr> 
            <!-- Body start -->
            <tr style="background:#fff;color:#000!important;">
               <td colspan="2">

                  <?php echo $email_message; ?>

               </td>
            </tr>
            <!-- Body end -->
            <tr>
               <td>
                  <table width="100%" cellpadding="" style="font-size:14px;padding:20px 0px;table-layout: fixed;background-color: #fafafa;">
                     <tr>
                        <td style="vertical-align: middle;font-family: arial,sans-serif, sans-serif;text-align: center;" >
                           <span>&nbsp;&nbsp;&nbsp;
                           <a href="mailto:<?php echo get_option_url('EMAIl'); ?>" style="text-decoration: none;color: #373d3f;font-size: 12px;"><?php echo get_option_url('EMAIl'); ?></a>
                           &nbsp;&nbsp;&nbsp;|</span>
                           <span>&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('page/contact'); ?>" style="text-decoration: none;color: #373d3f;font-size: 12px;">Contact Us</a></span>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>

            <tr>
               <td>
                  <table width="100%" style="background-color: #ececec;" cellpadding="5">
                     <tr>
                        <td style="text-align: center;border-collapse: collapse;padding-top: 20px;">              
                           <span style="text-align: right;display: inline-block;vertical-align: middle;">
                           <span style="font-size: 12px;font-family: arial,sans-serif, sans-serif;">Follow Us:</span>
                           <a href="<?php  echo get_option_url('FACEBOOK_URL') ?>" style="text-decoration: none;vertical-align: middle;"><img src="<?php echo base_url(); ?>assets/frontend/img/email/email-facebook.png"></a>
                           <a href="<?php echo get_option_url('INSTAGRAM_URL') ?>" style="text-decoration: none;vertical-align: middle;"><img src="<?php echo base_url(); ?>assets/frontend/img/email/email-insta.png"></a>
                           <a href="<?php echo get_option_url('TWITTER_URL') ?>" style="text-decoration: none;vertical-align: middle;"><img src="<?php echo base_url(); ?>assets/frontend/img/email/email-twitter.png"></a>
                           <a href="<?php echo get_option_url('PINTEREST_URL') ?>" style="text-decoration: none;vertical-align: middle;"><img src="<?php echo base_url(); ?>assets/frontend/img/email/email-pintrest.png"></a>
                           <a href="<?php echo get_option_url('LINKEDIN_URL') ?>" style="text-decoration: none;vertical-align: middle;"><img src="<?php echo base_url(); ?>assets/frontend/img/email/email-linkedin.png"></a>
                           <a href="<?php echo get_option_url('YOUTUBE_URL') ?>" style="text-decoration: none;vertical-align: middle;"><img src="<?php echo base_url(); ?>assets/frontend/img/email/email-youtube.png"></a>
                           </span>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr>
               <td style="font-size: 10px;text-align: center;padding-bottom: 15px;background-color: #ececec;line-height: 15px;font-family: arial,sans-serif, sans-serif;">
                  <div>Copyright &copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>, All rights reserved.</div>
               </td>
            </tr>
         </table>
      </div>
   </body>
</html>