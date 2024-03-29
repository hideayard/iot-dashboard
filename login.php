<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Flow | Log in</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/rochat_icon.png" />
  <link rel="stylesheet" href="vendors/sweetalert2/sweetalert2.min.css">

</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
              </div>
              <!-- <h4>Hello! let's get started</h4> -->
              <h2 class="font-weight-light">Sign in to continue.</h2>
              <form class="pt-3" id="login_form">
                <div class="form-group">
                  <input  name="username" id="username"  class="form-control form-control-lg" placeholder="Input Username">
                </div>
                <div class="form-group">
                  <input name="password" id="password" type="password" class="form-control form-control-lg" placeholder="Input Password">
                </div>
                <div class="mt-3">
                  <button type="submit" name="btn-login" id="btn-login" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Sign In</button>

                  <!-- <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" href="index.html">SIGN IN</a> -->
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="forgot.php" class="auth-link text-black">Lupa password?</a>
                </div>
                <!-- <div class="mb-2">
                  <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                    <i class="ti-facebook mr-2"></i>Connect using facebook
                  </button>
                </div> -->
                <div class="text-center mt-4 font-weight-light">
                  Don't have an account? <a href="register.php" class="text-primary">Create</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  <!-- jQuery -->
<script src="js/jquery/jquery.min.js"></script>

  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <script type="text/javascript" src="js/validation.min.js"></script>
  <!-- SweetAlert2 -->
  <script src="vendors/sweetalert2/sweetalert2.min.js"></script>

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
            $("#btn-login").html('<i class="fa fa-sync fa-spin"></i> &nbsp; Signing In');
        },
        success :  function(response)
            {          
              try{
                    rv = JSON.parse(response);
                    if(isEmpty(rv) || rv.status==false)
                    {
                      Swal.fire(
                          'error!',
                          'Error NO DATA, '+rv.messages,
                          'error'
                          );
                        console.log("NO DATA : ", response);
                        $("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
                                
                    }
                    else
                    {
                      if(rv.status==true)
                      {
                        Swal.fire(
                          'Success!',
                          'Success Login!',
                          'success'
                          );
                        console.log("SUCCESS : ", rv);
                        document.cookie = "token="+rv.info;
                        setTimeout(function(){ window.location="index.php?token="+rv.info; }, 1000);
                        // window.location="index.php";
                      }

                    }
              }   
              catch (e) {
                
                Swal.fire(
                          'error!',
                          'Error Input Data, '+e,
                          'error'
                          );
                          $("#btn-login").html('<i class="fa fa-sync fa-spin"></i> &nbsp; Sign In');
              
            console.log("ERROR : ", e);

              }           
                
          },
        timeout: 3000 // sets timeout to 3 seconds
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
