<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Ro-Chat | Log in</title>
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
                <!-- <img src="images/logo.svg" alt="logo"> -->
                <img src="images/rochat.png" alt="logo" />
              </div>
              <h4>Register new account.</h4>
              <h6 class="font-weight-light">just a few steps.</h6>
             
              
              <form action="#" method="post" id="register_form">
      <label for="user_nama" class="col-sm-12 col-form-label">Username :</label>
        <div class="form-group row">
            <div class="col-sm-12 input-group">
            <input type="text" id="user_name" name="user_name" class="form-control" placeholder="Username" aria-required="true">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user-circle"></span>
                </div>
              </div>
            </div>
         </div>

         <label for="user_pass" class="col-sm-12 col-form-label">Password : </label>
        <div class="form-group row">
            <div class="col-sm-12 input-group">
              <input type="password" class="form-control" id="user_pass" name="user_pass" placeholder="Password" aria-required="true">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
         </div>

         <label for="user_nama" class="col-sm-12 col-form-label">Nama Lengkap :</label>
         <div class="form-group row">
            <div class="col-sm-12 input-group">
            <input type="text" id="user_nama" name="user_nama" class="form-control" placeholder="Full Name" aria-required="true">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user-circle"></span>
                </div>
              </div>
            </div>
         </div>

        <label for="user_nama" class="col-sm-12 col-form-label">Email :</label>
        <div class="form-group row">
            <div class="col-sm-12 input-group">
            <input type="email" id="user_email" name="user_email" class="form-control" placeholder="Email" >
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
         </div>

        <label for="user_nama" class="col-sm-12 col-form-label">Nomer Telepon :</label>
        <div class="form-group row">
            <div class="col-sm-12 input-group">
            <input type="number" id="user_hp" name="user_hp" class="form-control" placeholder="Nomer Telepon" aria-required="true">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-phone"></span>
                </div>
              </div>
            </div>
         </div>

        <div class="form-group row">
            <div class="col-4">
                  <div class="icheck-primary">                  
                      <p>
                        <input type="checkbox" class="checkbox" id="is_wa" name="is_wa" >
                        <label for="is_wa">Whatsapp</label>
                        <br>
                        <label for="is_wa" class="error block"></label>
                      </p>
                    
                  </div>
              </div>
              <div class="col-4">
                  <div class="icheck-primary">                  
                      <p>
                        <input type="checkbox" class="checkbox" id="is_tele" name="is_tele" >
                        <label for="is_tele">Telegram</label>
                        <br>
                        <label for="is_tele" class="error block"></label>
                      </p>
                    
                  </div>
              </div>
        </div>

        
        
        
        <div class="row">
          <div class="col-8">
          
            <div class="icheck-primary">
            
                  <p>
                <label for="agree">Please agree to our policy</label>
                <input type="checkbox" class="checkbox" id="agree" name="agree" required="" aria-required="true">
                <br>
                <label for="agree" class="error block"></label>
                </p>
              
            </div>
          </div>
          <!-- <div class="col-4">
            <button id="btnSubmit" type="submit" class="btn btn-primary btn-block">Register</button>
          </div> -->
            <div class="mt-3">
                <button id="btnSubmit" type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Register</button>
            </div>
        </div>
        <div class="text-center mt-4 font-weight-light">
                  Already have an account? <a href="login.php" class="text-primary">Login here</a>
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
      function isEmpty(obj) {
        for(var prop in obj) {
            if(obj.hasOwnProperty(prop))
                return false;
        }
          return true;
      }

        $(function(){
            var form = $("#register_form");

            form.css({
                opacity: 1,
                "-webkit-transform": "scale(1)",
                "transform": "scale(1)",
                "-webkit-transition": ".5s",
                "transition": ".5s"
            });

            /* validation */
     $("#register_form").validate({
      rules:
      {
            user_nama: {  required: true },
            user_name: {  required: true },
            user_email: { required: true, email: true },
            user_pass: { required: true, },
            user_hp: { required: true, },
            agree: { required: true },
            
       },
       messages:
       {
          user_nama:{  required: "please enter your Full Name"    },
          user_name:{  required: "please enter your Username "    },
          user_email:{  required: "please enter your Email "    },
          user_pass:{  required: "please enter your password"            },
          user_hp:{  required: "please enter your Phone Number"            },
          agree:{     required: "please check terms of agreement"       },           

       },
       submitHandler: submitForm    
       });  
       /* validation */
       
       /* login submit */
       function submitForm()
      {
            $("#btnSubmit").html('<span class="fa fa-sync fa-spin"></span> Processing');
          var form = $('#register_form')[0];
          // Create an FormData object
          var data = new FormData(form);
          
          // disabled the submit button
          $("#btnSubmit").prop("disabled", true);
                $.ajax({
                  type: "POST",
                  enctype: 'multipart/form-data',
                  url: "actionregister.php",
                  data: data,
                  processData: false,
                  contentType: false,
                  cache: false,
                  timeout: 600000,
                  success: function (data) {
                var rv;
                try {
                  rv = JSON.parse(data);
                  if(isEmpty(rv))
                  {
                          Swal.fire(
                          'Info!',
                          'No Data!',
                          'info'
                          );
                      console.log("NO DATA : ", data);
                  }
                  else
                  {
                    if(rv.status==true || rv.status=="true")
                    {
                      Swal.fire(
                          'Success!',
                          'Success Input Data!',
                          'success'
                          );
                      console.log("SUCCESS : ", data);
                      setTimeout(function(){ window.location="login"; }, 2000);
                        $("#btnSubmit").html('Register');
                      $("#register_form")[0].reset();

                    }
                    else 
                    {
                      Swal.fire(
                          'error!',
                          'Error Input Data, '+rv.messages,
                          'error'
                          );
                      
                      console.log("ERROR : ", data);
                      $("#btnSubmit").html('Register');

                    }

                  }
                }
                catch (e) {
                  //error data not json
                  Swal.fire(
                          'error!',
                          'Error Input Data, '+e,
                          'error'
                          );
                      
                      console.log("catch ERROR : ", e);
                      $("#btnSubmit").html('Register');
                } 

                
                  $("#btnSubmit").prop("disabled", false);
                  // $("#result").text(data);
                  

              },
              error: function (e) {

                  // $("#result").text(e.responseText);
                  console.log("ERROR : ", e);
                  $("#btnSubmit").prop("disabled", false);
                  $("#btnSubmit").html('Register');

              },
              timeout: 4000 // sets timeout to 3 seconds
              }); //end of ajax
      }

        });
    </script>
</body>

</html>
