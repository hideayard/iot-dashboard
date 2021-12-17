
<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ro-Chat | Log in</title>
  <link rel="icon" href="assets/img/rochat_icon.png" type="image/png" sizes="50x50">  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style type="text/css">
    #background {
    width: 100%; 
    height: 100%; 
    position: fixed; 
    left: 0px; 
    top: 0px; 
    z-index: -1; /* Ensure div tag stays behind content; -999 might work, too. */
}

.stretch {
    width:100%;
    height:100%;
}
  </style>
</head>
<body class="hold-transition login-page">
<div id="background">
    <img src="assets/img/carbon.jpg" class="stretch" alt="" />
</div>
<div class="login-box">
  <div class="login-logo">
    <!-- <a href="index2.html"><b>Admin</b>LTE</a> -->
    <img src="assets/img/rochat.png" />
    <p><strong class="text-white" style=" text-shadow: 1px 1px 2px black, 0 0 15px black, 0 0 5px black; ">Login</strong></p>

  </div>
  <!-- /.login-logo -->
  <div class="card" style=" box-shadow: 1px 1px 2px grey, 0 0 15px grey, 0 0 5px grey; ">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form  class="form-signin" id="login_form">
      <div id="error"><!-- error will be shown here ! --></div>
        <div class="input-group mb-3">
        <input name="username" id="username" class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input  name="password" id="password" type="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <a href="register.php">
                Register
              </a>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
          <button type="submit" name="btn-login" id="btn-login" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> -->
      <!-- /.social-auth-links -->

      <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script type="text/javascript" src="dist/js/validation.min.js"></script>

<script>
    $(function(){
        var form = $(".login-form");

        form.css({
            opacity: 1,
            "-webkit-transform": "scale(1)",
            "transform": "scale(1)",
            "-webkit-transition": ".5s",
            "transition": ".5s"
        });

        /* validation */
  $("#login_form").validate({
  rules:
  {
        password: {
        required: true,
        },
        username: {
        required: true,
        //email: true
        },
    },
    messages:
    {
        password:{
                  required: "please enter your password"
                  },
        username: "please enter your username address",
    },
    submitHandler: submitForm    
    });  
    /* validation */
    
    /* login submit */
    function submitForm()
    {        
        var data = $("#login_form").serialize();
            
        $.ajax({
            
        type : 'POST',
        url  : 'actionlogin.php',
        data : data,
        beforeSend: function()
        {   
            $("#error").fadeOut();
            $("#btn-login").html('<i class="fa fa-sync fa-spin"></i> &nbsp; Signing In');
        },
        success :  function(response)
            {          
              try{
                    rv = JSON.parse(response);
                    if(isEmpty(rv) || rv.status==false)
                    {
                        console.log("NO DATA : ", response);
                        $("#error").fadeIn(500, function(){                        
                        $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Username Or Password is Wrong !</div>');
                        $("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
                                });
                    }
                    else
                    {
                      if(rv.status==true)
                      {
                        console.log("SUCCESS : ", rv);
                        // setTimeout(function(){ window.location="index.php?token="+rv.info; }, 1000);
                        window.location="index.php";
                      }

                    }
              }   
              catch (e) {
                
              $("#error").fadeIn(500, function(){                        
                  $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Error :  '+e+' !</div>');
                  $("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
                          });
              
            console.log("ERROR : ", e);

              }           
                
          }
        });
            return false;
    }
    /* login submit */
    });

    function isEmpty(obj) {
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            return false;
    }
      return true;
  }
</script>
</body>
</html>
