


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
          <div class="col-md-3">

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
                  
                  
                </ul>
              

                <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

         
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <!-- <li class="nav-item"><a class="nav-link active" href="#view" data-toggle="tab">View</a></li> -->
                  <!-- <li class="nav-item"><a class="nav-link active" href="#update" data-toggle="tab">Update</a></li> -->
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  

                  <div class="active tab-pane" id="update">
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
                        <label for="user_tipe" class="col-sm-2 col-form-label">Tipe</label>
                        <div class="col-sm-10">
                            <select class="form-control select2bs4" id="user_tipe" name="user_tipe">
                            <?php
                            if($tipe_user == "ADMIN") {
                                $arr_tipe_user = array("SOCSO" => "SOCSO","NGO" => "NGO","VZ" => "VISION ZERO","MAINTENANCE" => "MAINTENANCE","HQ" => "HQ","ADMIN" => "ADMIN");
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
                      

                      <div class="form-group row">
                        <label for="user_foto" class="col-sm-2 col-form-label">Foto</label>
                        <div class="col-sm-10">
                        <?php if($result[0]['user_foto'] != null) {  $maxfile--;$filecount++; $foto = "uploads/user/".$result[0]['user_foto']; } ?>
                        <input type="file" id="input-file-now" class="dropify" data-default-file="<?php echo $foto; ?>" data-max-file-size="2M" data-allowed-file-extensions="jpg png jpeg" />
                        </div>
                      </div>
                      
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit"  id="btnSubmit" name="btnSubmit" class="btn btn-primary">Submit</button>
                          <a href="home"><button type="button"  name="cancel" class="btn btn-secondary">Cancel</button></a>
                        </div>
                      </div>

                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  
<input type="hidden" id="maxfile" value="<?=$maxfile?>"/>
<input type="hidden" id="filecount" value="<?=$filecount?>"/>
<input type="hidden" id="filestatus1" value="1"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="vendors/dropify/dist/js/dropify.min.js"></script>
<script>
    $(document).ready(function(){
        // Basic
        $('.dropify').dropify();

        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove:  'Supprimer',
                error:   'Désolé, le fichier trop volumineux'
            }
        });

        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function(event, element){
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element){
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function(event, element){
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e){
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });
</script>


<script>

(function($) {
  'use strict';
  $('.dropify').dropify();
})(jQuery);

// (function($) {
//   'use strict';
//   $("my-awesome-dropzone").dropzone({
//     url: "bootstrapdash.com/"
//   });
// })(jQuery);

// function hidden_div(filename,div_id)
// {
//   Swal.fire({
//   title: 'Are you sure?',
//   text: "Delete file ",
//   html:
//     '<p class="text text-danger">'+filename+'</p>',
//   icon: 'warning',
//   showCancelButton: true,
//   confirmButtonColor: '#3085d6',
//   cancelButtonColor: '#d33',
//   confirmButtonText: 'Yes, delete it!'
// }).then((result) => {
//   if (result.value) {
//     document.getElementById("preview"+div_id).style="display:none;";
 
//  --document.getElementById("filecount").value;
//  ++document.getElementById("maxfile").value;
//  document.getElementById("filestatus"+div_id).value = 0;

//  console.log(document.getElementById("filecount").value,document.getElementById("maxfile").value);
//  //  $("div#my-awesome-dropzone").dropzone.options.maxFiles = 5;//document.getElementById("maxfile").value ;
//     Swal.fire(
//       'Deleted!',
//       'Your file has been deleted.',
//       'success'
//     )
//   }
// })
 
// }


// // Dropzone.autoDiscover = false;
// // 	jQuery(document).ready(function() {

// // 	  $("div#my-awesome-dropzone").dropzone({
// //             url: "#",
// //            // Prevents Dropzone from uploading dropped files immediately
// //            autoProcessQueue: false,
// //            addRemoveLinks: true,
// //            uploadMultiple: false,
// //             parallelUploads: 1,
// //             maxFiles: 1,
// //             maxFilesize: 5,
// //             acceptedFiles: "image/*",//,.doc,.docx,.xls,.xlsx,.csv,.tsv,.ppt,.pptx,.pages,.odt,.rtf",

// //           init: function() {
// //             var submitButton = document.querySelector("#btnSubmit")
// //                 myDropzone = this; // closure

// //             submitButton.addEventListener("click", function() {
// //               myDropzone.processQueue(); // Tell Dropzone to process all queued files.
// //             });

// //             // You might want to show the submit button only when 
// //             // files are dropped here:
// //             this.on("addedfile", function(file) {
// //               // let str = JSON.stringify(file);

// //               console.log("addedfile",file);
// //               var ext = file.name.split('.').pop();

// //             if (ext == "pdf") {
// //                 $(file.previewElement).find(".dz-image img").attr("src", "dist/img/pdf.png");
// //             } else if (ext.indexOf("doc") != -1) {
// //                 $(file.previewElement).find(".dz-image img").attr("src", "dist/img/word.png");
// //             } else if (ext.indexOf("xls") != -1) {
// //                 $(file.previewElement).find(".dz-image img").attr("src", "dist/img/excel.png");
// //             }
// //               // Show submit button here and/or inform user to click it.
// //             });
// //             this.on("error", function(file){if (!file.accepted) this.removeFile(file);});


// //           }
// // 	  });

// //   });


//    $(document).ready(function () {

// $.validator.setDefaults({
// submitHandler: function () {
//   console.log( "Form successful submitted!" );
// }
// });

// $('#userform').validate({
//     rules: {
//               user_nama: {   required: true,  }
//               ,user_email: {   required: true, email: true, }         
//               ,user_name: {   required: true  }
//               // ,user_tempat: {   required: true,  }
//               // ,user_agency: {   required: true,  }
//               // ,user_program: {   required: true,  }
//               // ,user_bil_peserta: {   required: true ,  number:true, }
//     },
//     messages: {
//               user_nama: {  required: "Enter Name ", }
//               ,user_email: {  required: "Enter Email " ,}
//               ,user_name: {  required: "Enter Username ", }
//               // ,user_tempat: {  required: "Enter Place First" ,}
//               // ,user_agency: {  required: "Enter Agency First", }
//               // ,user_program: {  required: "Enter Program First", }
//               // ,user_bil_peserta: {  required: "Enter Participant First",}
//     },
//     errorElement: 'span',
//     errorPlacement: function (error, element) {
//       error.addClass('invalid-feedback');
//       element.closest('.form-group').append(error);
//     },
//     highlight: function (element, errorClass, validClass) {
//       $(element).addClass('is-invalid');
//     },
//     unhighlight: function (element, errorClass, validClass) {
//       $(element).removeClass('is-invalid');
//     },
//     submitHandler: submitForm
//   });

// function submitForm()
// {
//   $("#btnSubmit").html('<span class="fa fa-sync fa-spin"></span> Processing');
// var form = $('#userform')[0];
// // Create an FormData object
// var data = new FormData(form);
// if(!isEmpty($('#my-awesome-dropzone')[0].dropzone.getAcceptedFiles()[0]))
//   {
//     data.append("user_foto", $('#my-awesome-dropzone')[0].dropzone.getAcceptedFiles()[0]);
//   }
//   data.append("user_id","<?=$user_id?>");
// // disabled the submit button
// $("#btnSubmit").prop("disabled", true);
//       $.ajax({
//         type: "POST",
//         enctype: 'multipart/form-data',
//         url: "actionuser.php",
//         data: data,
//         processData: false,
//         contentType: false,
//         cache: false,
//         timeout: 600000,
//         success: function (data) {
//       var rv;
//       try {
//         rv = JSON.parse(data);
//         if(isEmpty(rv))
//         {
//                 Swal.fire(
//                 'Info!',
//                 'No Data!',
//                 'info'
//                 );
//             console.log("NO DATA : ", data);
//             $("#btnLoadMore").html('Load More');
//         }
//         else
//         {
//           if(rv.status==true)
//           {
//             Swal.fire(
//                 'Success!',
//                 'Success Input Data!',
//                 'success'
//                 );
//             console.log("SUCCESS : ", data);
//             // setTimeout(function(){ window.location="users"; }, 1000);
//               // $('#my-awesome-dropzone')[0].dropzone.removeAllFiles(true); 
//             $("#btnSubmit").html('<span class="fa fa-paper-plane"></span> Submit');
//             // $("#userform")[0].reset();

//           }
//           else 
//           {
//             Swal.fire(
//                 'error!',
//                 'Error Input Data, '+data,
//                 'error'
//                 );
            
//             console.log("ERROR : ", data);
//             $("#btnSubmit").html('<span class="fa fa-paper-plane"></span> Submit');

//           }

//         }
//       } catch (e) {
//         //error data not json
//         Swal.fire(
//                 'error!',
//                 'Error Input Data, '+data,
//                 'error'
//                 );
            
//             console.log("ERROR : ", data);
//             $("#btnSave").html('<span class="fa fa-save"></span> Save');
//       } 

       
//         $("#btnSubmit").prop("disabled", false);
//         // $("#result").text(data);
        

//     },
//     error: function (e) {

//         // $("#result").text(e.responseText);
//         console.log("ERROR : ", e);
//         $("#btnSubmit").prop("disabled", false);
//         $("#btnSubmit").html('<span class="fa fa-paper-plane"></span> Submit');

//     }
//     }); //end of ajax
// }

// });


</script>
