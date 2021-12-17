


<?php
$id_session = isset($_SESSION['i']) ? $_SESSION['i'] : "";

$maxfile = 1;
$filecount = 0;

$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : ""; 

if($user_id!="" && $tipe_user=="ADMIN")
{
  $sql = "SELECT * FROM users WHERE user_id = '$user_id' "; 
  $result = $db->rawQuery($sql);//@mysql_query($sql);
}


if ($user_id=="")
{
  $user_id = $id_session;
}

?>
<link rel="stylesheet" href="vendors/dropify/dist/css/dropify.min.css">

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4 grid-margin stretch-card">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="uploads/user/<?=$result[0]['user_foto']?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?=$result[0]['user_nama']?></h3>

                <p class="text-muted text-center"><?=$result[0]['user_tipe']?></p>

                <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>Username</b> <a class="float-right"><?=$result[0]['user_name']?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Email</b> <a class="float-right"><?=$result[0]['user_email']?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Phone</b> <a class="float-right"><?=$result[0]['user_hp']?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Whatsapp</b> <a class="float-right">
                      <div class="icheck-primary">                  
                          <p>
                            <input onclick="this.checked=!this.checked;" type="checkbox" class="checkbox" <?php if($result[0]['user_is_wa']){echo "checked";}?> >
                          </p>
                      </div>
                    </a>
                  </li>
                  <li class="list-group-item">
                    <b>Telegram</b> <a class="float-right">
                    <div class="icheck-primary">                  
                          <p>
                            <input onclick="this.checked=!this.checked;" type="checkbox" class="checkbox" <?php if($result[0]['user_is_tele']){echo "checked";}?> >
                          </p>
                      </div>
                      </a>
                  </li>
                  
                </ul>
              

                <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

         
          </div>
          <!-- /.col -->
          <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">User Profile</h4>
                  <p class="card-description">
                    form untuk melakukan perubahan data profil
                  </p>
                  <form class="form-horizontal" id="userform" action="#"  enctype="multipart/form-data" method="post">

                      <div class="form-group row">
                        <label for="user_name" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                          <input type="text" disabled class="form-control" id="user_name" name="user_name" placeholder="username" value="<?=$result[0]['user_name']?>">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="user_pass" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="user_pass" name="user_pass" placeholder="password">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="user_nama" class="col-sm-2 col-form-label">Full Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="user_nama" name="user_nama" placeholder="Nama" value="<?=$result[0]['user_nama']?>">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="user_email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                        <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Email" value="<?=$result[0]['user_email']?>">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="user_nama" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" id="user_hp" name="user_hp" placeholder="Phone" value="<?=$result[0]['user_hp']?>">
                        </div>
                      </div>

                      <div class="form-group row">
                          <div class="col-2">
                                <div class="icheck-primary">                  
                                    <p>
                                      <input type="checkbox" class="checkbox" id="is_wa" name="user_is_wa"  <?php if($result[0]['user_is_wa']){echo "checked";}?>>
                                      <label for="is_wa">Whatsapp</label>
                                      <br>
                                      <label for="is_wa" class="error block"></label>
                                    </p>
                                  
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="icheck-primary">                  
                                    <p>
                                      <input type="checkbox" class="checkbox" id="is_tele" name="user_is_tele"  <?php if($result[0]['user_is_tele']){echo "checked";}?>>
                                      <label for="is_tele">Telegram</label>
                                      <br>
                                      <label for="is_tele" class="error block"></label>
                                    </p>
                                  
                                </div>
                            </div>
                      </div>

                      <div class="form-group row">
                        <label for="user_tipe" class="col-sm-2 col-form-label">Tipe</label>
                        <div class="col-sm-10">
                            <select class="form-control select2bs4" id="user_tipe" name="user_tipe">
                            <?php
                            if($tipe_user == "ADMIN") {
                                $arr_tipe_user = array("USER" => "user","ADMIN" => "ADMIN");
                            }
                            else
                            {
                              $arr_tipe_user = array($tipe_user);
                            }

                                foreach ($arr_tipe_user as $key => $value)
                                {
                                  $selected = " ";
                                    if($result[0]['user_tipe'] == $value )
                                    {
                                      $selected = 'selected="selected"';
                                    }
                                    echo "<option value='".$key."' ".$selected ." >".$value."</option>" ;
                                }
                                ?>
                            
                            </select>
                        </div>
                      </div>

                      <?php
                          if($tipe_user == "ADMIN") {
                                $arr_tipe_user = array("0" => "nonaktif","1" => "aktif");
                      ?>
                      <div class="form-group row">
                        <label for="user_nama" class="col-sm-2 col-form-label">Status user</label>
                        <div class="col-sm-10">
                        <select class="form-control select2bs4" id="user_status" name="user_status">
                          <?php
                          foreach ($arr_tipe_user as $key => $value)
                          {
                            $selected = " ";
                              if($result[0]['user_status'] == $key )
                              {
                                $selected = 'selected="selected"';
                              }
                              echo "<option value='".$key."' ".$selected ." >".$value."</option>" ;
                          }
                          ?>
                          </select>
                        </div>
                      </div>
                        <?php } ?>  
                      
                      <!-- <div class="form-group row">
                        <label for="user_foto" class="col-sm-2 col-form-label">Foto</label>
                        <div class="col-sm-10">
                          <input type="file" id="user_foto" name="user_foto" class="file-upload-default">
                          <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                            <span class="input-group-append">
                              <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                          </div>
                        </div>
                      </div> -->

                      <div class="form-group row">
                        <label for="user_foto" class="col-sm-2 col-form-label">Foto</label>
                        <div class="col-sm-10">
                        <?php if($result[0]['user_foto'] != null) {  $maxfile--;$filecount++; $foto = "uploads/user/".$result[0]['user_foto']; } ?>
                        <input type="file" id="user_foto" name="user_foto" class="dropify-id text-white" data-default-file="<?php echo $foto; ?>" data-max-file-size="2M" data-allowed-file-extensions="jpg png jpeg" />
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="button" onclick="submitForm()" id="btnSubmit" name="btnSubmit" class="btn btn-primary">Submit</button>
                          <a href="home"><button type="button"  name="cancel" class="btn btn-secondary">Cancel</button></a>
                        </div>
                      </div>
                    
                      <input type="hidden" name="picture_removed" id="picture_removed" value="0">
                      <input type="hidden" name="picture_updated" id="picture_updated" value="0">
                      <input type="hidden" name="picture_error" id="picture_error" value="0">
                    </form>
                </div>
              </div>
            </div>
  
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>



  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="vendors/dropify/dist/js/dropify.min.js"></script>
  <script type="text/javascript">

(function($) {
  'use strict';

  var drEvent = $('.dropify-id').dropify({
        messages: {
            default: 'Geser dan Lepas file disini atau klik',
            replace: 'Geser dan Lepas file untuk mengganti',
            remove:  'hapus',
            error:   'terjadi kesalahan'
        }
    });
    
    $("#user_foto").on('change',function (event) {
      if( $("#picture_error").val() == 0)
      {
        $("#picture_updated").val("1");
        $("#picture_removed").val("0");
        console.log('on change no error');
      }
      else
      {
        $("#picture_error").val("0");
        console.log('on change error');
      }
      
    });

    drEvent.on('dropify.afterClear', function(event, element){
        $("#picture_removed").val("1");
    });

    drEvent.on('dropify.errors', function(event, element){
      $("#picture_updated").val("0");
      $("#picture_removed").val("0");
      $("#picture_error").val("1");
      console.log('Has Errors!');
});


})(jQuery);



  function submitForm()
  {
    $("#btnSubmit").html('<span class="fa fa-sync fa-spin"></span> Processing');
    var form = $('#userform')[0];
    // Create an FormData object
    var data = new FormData(form);
    // if(!isEmpty($('#my-awesome-dropzone')[0].dropzone.getAcceptedFiles()[0]))
    //   {
    //     data.append("user_foto", $('#my-awesome-dropzone')[0].dropzone.getAcceptedFiles()[0]);
    //   }
      // data.append('user_foto', $('#user_foto')[0].files[0]);
      data.append("user_id","<?=$user_id?>");
    // disabled the submit button
    $("#btnSubmit").prop("disabled", true);
          $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "actionuser.php",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
          var rv;
          try {
            rv = JSON.parse(data);
            console.log("rv=",rv);
            if(isEmpty(rv))
            {
                    Swal.fire(
                    'Info!',
                    'No Data!',
                    'info'
                    );
                console.log("NO DATA : ", data);
                $("#btnLoadMore").html('Load More');
            }
            else
            {
              console.log("rv.status = ",rv.status);
              if(rv.status==true || rv.status=='true')
              {
                Swal.fire(
                    'Success!',
                    'Success Input Data!',
                    'success'
                    );
                console.log("SUCCESS : ", data);
                // setTimeout(function(){ window.location="users"; }, 1000);
                $("#btnSubmit").html('<span class="fa fa-paper-plane"></span> Submit');
                // $("#userform")[0].reset();

              }
              else 
              {
                Swal.fire(
                    'error!',
                    'Error Input Data, '+data,
                    'error'
                    );
                
                console.log("ERROR : ", data);
                $("#btnSubmit").html('<span class="fa fa-paper-plane"></span> Submit');

              }

            }
          } catch (e) {
            //error data not json
            Swal.fire(
                    'error!',
                    'Error Input Data, '+data,
                    'error'
                    );
                
                console.log("data : ", data);
                console.log("ERROR : ", e);
                $("#btnSave").html('<span class="fa fa-save"></span> Save');
          } 

          
            $("#btnSubmit").prop("disabled", false);
            // $("#result").text(data);
            

        },
        error: function (e) {

            // $("#result").text(e.responseText);
            console.log("ERROR : ", e);
            $("#btnSubmit").prop("disabled", false);
            $("#btnSubmit").html('<span class="fa fa-paper-plane"></span> Submit');

        }
        }); //end of ajax
  }
</script>