<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title><?php echo $title; ?></title>
  
  
  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Open+Sans:600'>

      <style>
      html,body{
  width: 100%;
  height: 100%;
}
body{
    margin: 0;
    color: #6a6f8c; 
    background: #c8c8c8;
    font: 600 16px/18px 'Open Sans',sans-serif;
    width: 100%;
    height: 100%;
    background-size: cover;
}
*,:after,:before{box-sizing:border-box}
.clearfix:after,.clearfix:before{content:'';display:table}
.clearfix:after{clear:both;display:block}
a{color:inherit;text-decoration:none}

.login-wrap{
    width: 100%;
    margin: auto;
    height: 100%;
    position: relative;
    box-shadow: 0 12px 15px 0 rgba(0,0,0,.24), 0 17px 50px 0 rgba(0,0,0,.19);
    background-size: cover;
    background: rgba(40, 57, 101, 0.4);
  -webkit-box-shadow: 0px 0px 53px 18px rgb(68, 61, 61);
    -moz-box-shadow: 0px 0px 53px 18px rgb(68, 61, 61);
    box-shadow: 0px 0px 53px 18px rgb(68, 61, 61);
}
.login-html {
    width: 400px;
    height: 405px;
    position: absolute;
    padding: 73px 60px 50px 60px;
    background: rgba(255, 255, 255, 0.24);
    margin: 0 auto;
    left: 50%;
    top: 50%;
    transform: translate(-50%,-50%);
}
.login-html .sign-in-htm,
.login-html .sign-up-htm{
  top:0;
  left:0;
  right:0;
  bottom:0;
  position:absolute;
  -webkit-transform:rotateY(180deg);
          transform:rotateY(180deg);
  -webkit-backface-visibility:hidden;
          backface-visibility:hidden;
  -webkit-transition:all .4s linear;
  transition:all .4s linear;
}
.login-html .sign-in,
.login-html .sign-up,
.login-form .group .check{
  display:none;
}
.login-html .tab,
.login-form .group .label,
.login-form .group .button{
  text-transform:uppercase;
}
.login-html .tab{
    font-size: 22px;
    padding-bottom: 5px;
    margin: 0 auto;
    display: block;
    border-bottom: 2px solid transparent;
    width: 85px;
    margin-bottom: 15px;
}
.login-html .sign-in:checked + .tab,
.login-html .sign-up:checked + .tab{
  color:#fff;
  border-color:#1161ee;
}
.login-form{
  min-height:345px;
  position:relative;
  -webkit-perspective:1000px;
          perspective:1000px;
  -webkit-transform-style:preserve-3d;
          transform-style:preserve-3d;
}
.login-form .group{
  margin-bottom:15px;
}
.login-form .group .label,
.login-form .group .input,
.login-form .group .button{
  width:100%;
  color:rgb(68, 61, 61);
  display:block;
}
.login-form .group .input,
.login-form .group .button{
  border:none;
  padding:15px 20px;
  border-radius:25px;
  background:rgba(255, 255, 255, 0.70);
}
.login-form .group input[data-type="password"]{
  text-security:circle;
  -webkit-text-security:circle;
}
.login-form .group .label{
  color: rgb(255, 255, 255);
    font-size: 16px;
    margin-bottom: 13px;
    margin-left: 10px;
}
.login-form .group .button{
  background:#1161ee;
  cursor: pointer;
}
.login-form .group .button:focus{outline: none;}
.login-form .group label .icon{
  width:15px;
  height:15px;
  border-radius:2px;
  position:relative;
  display:inline-block;
  background:rgba(255,255,255,.1);
}
.login-form .group label .icon:before,
.login-form .group label .icon:after{
  content:'';
  width:10px;
  height:2px;
  background:#fff;
  position:absolute;
  -webkit-transition:all .2s ease-in-out 0s;
  transition:all .2s ease-in-out 0s;
}
.login-form .group label .icon:before{
  left:3px;
  width:5px;
  bottom:6px;
  -webkit-transform:scale(0) rotate(0);
          transform:scale(0) rotate(0);
}
.login-form .group label .icon:after{
  top:6px;
  right:0;
  -webkit-transform:scale(0) rotate(0);
          transform:scale(0) rotate(0);
}
.login-form .group .check:checked + label{
  color:#fff;
}
.login-form .group .check:checked + label .icon{
  background:#1161ee;
}
.login-form .group .check:checked + label .icon:before{
  -webkit-transform:scale(1) rotate(45deg);
          transform:scale(1) rotate(45deg);
}
.login-form .group .check:checked + label .icon:after{
  -webkit-transform:scale(1) rotate(-45deg);
          transform:scale(1) rotate(-45deg);
}
.login-html .sign-in:checked + .tab + .sign-up + .tab + .login-form .sign-in-htm{
  -webkit-transform:rotate(0);
          transform:rotate(0);
}
.login-html .sign-up:checked + .tab + .login-form .sign-up-htm{
  -webkit-transform:rotate(0);
          transform:rotate(0);
}

.hr{
  height:2px;
  margin:60px 0 50px 0;
  background:rgba(255,255,255,.2);
}
.foot-lnk{
  text-align:center;
}
.theme-alert-danger,.alert-danger{
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
   
    margin-bottom: 15px;
    border: 1px solid transparent;
    border-radius: 4px;
    padding-left: 14px;

}
.theme-alert-danger{
padding: 12px;
}
.theme-alert-danger button{
display:none;
}
      </style>

  
</head>

<body>
  <div class="login-wrap">
  <div class="login-html">
    <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
    <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab"></label> 
    <div class="login-form">
      <div class="sign-in-htm">
          <?php echo msg_alert(); ?>
              <form action="" method="post">
        <!-- <div class="group">
          <label for="user" class="label">Username</label>
          <input id="user"  type="text" class="input">
        </div> -->
        <div class="group">
          <label for="pass" class="label">Password</label>
          <input id="pass" name="password" type="password" class="input" data-type="password">
          <?php echo form_error('password'); ?>
        </div>
        <!-- <div class="group">
          <input id="check" type="checkbox" class="check" checked>
          <label for="check"><span class="icon"></span> Keep me Signed in</label>
        </div> -->
        <div class="group">
          <input type="submit" name="auth" class="button" value="Sign In">
        </div>
        <div class="hr"></div>
      <!--  <div class="foot-lnk">
          <a href="#forgot">Forgot Password?</a>
        </div> -->
      </form> 
      </div>
      <!-- <div class="sign-up-htm">
        <div class="group">
          <label for="user" class="label">Username</label>
          <input id="user" type="text" class="input">
        </div>
        <div class="group">
          <label for="pass" class="label">Password</label>
          <input id="pass" type="password" class="input" data-type="password">
        </div>
        <div class="group">
          <label for="pass" class="label">Repeat Password</label>
          <input id="pass" type="password" class="input" data-type="password">
        </div>
        <div class="group">
          <label for="pass" class="label">Email Address</label>
          <input id="pass" type="text" class="input">
        </div>
        <div class="group">
          <input type="submit" class="button" value="Sign Up">
        </div>
        <div class="hr"></div>
        <div class="foot-lnk">
          <label for="tab-1">Already Member?</a>
        </div>
      </div> -->
    </div>
  </div>
</div>
  
  
</body>
</html>
