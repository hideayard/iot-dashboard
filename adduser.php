

<?php

if($mode!="modal")
{
  echo '<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
     <!-- Main content -->
     <section class="content">
      <div class="row">';
}

?>
  
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">

              <div class="card-body">
                <div class="tab-content">
                  
                 

                  <div class="active tab-pane" id="update">
                    <form id="userform" class="form-horizontal" action="#"  enctype="multipart/form-data" method="post">

                    <div class="form-group row">
                        <label for="user_nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="user_nama" name="user_nama" placeholder="Nama">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="user_name" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                        <input type="text"  class="form-control" id="user_name" name="user_name" value="" placeholder="Username" >
                        </div>
                      </div>
                      
                      <div class="form-group row">
                        <label for="user_pass" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="user_pass" name="user_pass" placeholder="Password">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="user_hp" class="col-sm-2 col-form-label">HP</label>
                        <div class="col-sm-10">
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input name="user_hp" id="user_hp" type="number" class="form-control"
                                data-inputmask="'mask': ['999-999-9999 [x99999]', '+099 99 99 9999[9]-9999']" data-mask>
                        </div>                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="user_email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                        <input type="email" id="user_email" name="user_email" class="form-control" placeholder="Email">                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="user_email" class="col-sm-2 col-form-label">Cawangan</label>
                        <div class="col-sm-10">
                        <input type="text" id="user_cawangan" name="user_cawangan" class="form-control" placeholder="Cawangan">                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="user_email" class="col-sm-2 col-form-label">Job Position</label>
                        <div class="col-sm-10">
                        <input type="text" id="user_job_position" name="user_job_position" class="form-control" placeholder="Job Position">                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="user_tipe" class="col-sm-2 col-form-label">Tipe</label>
                        <div class="col-sm-10">
                            <select class="form-control select2bs4" id="user_tipe" name="user_tipe">
                            <option value='SOCSO'>SOCSO</option>
                            <option value='NGO'>NGO</option>
                            <option value='VZ'>Vision Zero</option>
                            <option value='MAINTENANCE'>Maintenance</option>
                            <option value='HQ'>HQ</option>
                            <option value='ADMIN'>Admin</option>
                            </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="user_foto" class="col-sm-2 col-form-label">Foto</label>
                        <div class="col-sm-10">
                        <!-- <img src="dist/img/<?=$result[0]['user_foto']?>" alt="User Image"> -->
                        <div class="dropzone dropzone-previews" id="my-awesome-dropzone"></div>
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
<?php
if($mode!="modal")
{
  echo '</div>
  <!-- Main content -->
</section>
</div>';
}
?>

<input type="hidden" id="maxfile" value="1"/>
<input type="hidden" id="filecount" value="0"/>
<input type="hidden" id="filestatus1" value="1"/>

<script>

function hidden_div(filename,div_id)
{
  Swal.fire({
  title: 'Are you sure?',
  text: "Delete file ",
  html:
    '<p class="text text-danger">'+filename+'</p>',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.value) {
    document.getElementById("preview"+div_id).style="display:none;";
 
 --document.getElementById("filecount").value;
 ++document.getElementById("maxfile").value;
 document.getElementById("filestatus"+div_id).value = 0;

 console.log(document.getElementById("filecount").value,document.getElementById("maxfile").value);
 //  $("div#my-awesome-dropzone").dropzone.options.maxFiles = 5;//document.getElementById("maxfile").value ;
    Swal.fire(
      'Deleted!',
      'Your file has been deleted.',
      'success'
    )
  }
})
 
}

Dropzone.autoDiscover = false;
	jQuery(document).ready(function() {

	  $("div#my-awesome-dropzone").dropzone({
            url: "#",
           // Prevents Dropzone from uploading dropped files immediately
           autoProcessQueue: false,
           addRemoveLinks: true,
           uploadMultiple: false,
            parallelUploads: 1,
            maxFiles: 1,
            maxFilesize: 5,
            acceptedFiles: "image/*",//,.doc,.docx,.xls,.xlsx,.csv,.tsv,.ppt,.pptx,.pages,.odt,.rtf",

          init: function() {
            var submitButton = document.querySelector("#btnSubmit")
                myDropzone = this; // closure

            submitButton.addEventListener("click", function() {
              myDropzone.processQueue(); // Tell Dropzone to process all queued files.
            });

            // You might want to show the submit button only when 
            // files are dropped here:
            this.on("addedfile", function(file) {
              // let str = JSON.stringify(file);

              console.log("addedfile",file);
              var ext = file.name.split('.').pop();

            if (ext == "pdf") {
                $(file.previewElement).find(".dz-image img").attr("src", "dist/img/pdf.png");
            } else if (ext.indexOf("doc") != -1) {
                $(file.previewElement).find(".dz-image img").attr("src", "dist/img/word.png");
            } else if (ext.indexOf("xls") != -1) {
                $(file.previewElement).find(".dz-image img").attr("src", "dist/img/excel.png");
            }
              // Show submit button here and/or inform user to click it.
            });
            this.on("error", function(file){if (!file.accepted) this.removeFile(file);});


          }
	  });

  });


   $(document).ready(function () {

$.validator.setDefaults({
submitHandler: function () {
  console.log( "Form successful submitted!" );
}
});

$('#userform').validate({
    rules: {
              user_nama: {   required: true,  }
              ,user_email: {   required: true, email: true, }         
              // ,user_tarikh: {   required: true  }
              // ,user_bil_peserta: {   required: true ,  number:true, }
    },
    messages: {
              user_nama: {  required: "Enter Name First", }
              ,user_email: {  required: "Enter Email First" ,}
              // ,user_tarikh: {  required: "Enter Tarikh First", }
              // ,user_bil_peserta: {  required: "Enter Participant First",}
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    },
    submitHandler: submitForm
  });

function submitForm()
{
  $("#btnSubmit").html('<span class="fa fa-sync fa-spin"></span> Processing');
var form = $('#userform')[0];
// Create an FormData object
var data = new FormData(form);
if(!isEmpty($('#my-awesome-dropzone')[0].dropzone.getAcceptedFiles()[0]))
  {
    data.append("user_foto", $('#my-awesome-dropzone')[0].dropzone.getAcceptedFiles()[0]);
  }
  data.append("user_status", 1);

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
          if(rv.info==1)
          {
            Swal.fire(
                'Success!',
                'Success Input Data!',
                'success'
                );
            console.log("SUCCESS : ", data);
            // setTimeout(function(){ window.location="users"; }, 1000);
              $('#my-awesome-dropzone')[0].dropzone.removeAllFiles(true); 
            $("#btnSubmit").html('<span class="fa fa-paper-plane"></span> Submit');
            $("#userform")[0].reset();

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
            
            console.log("ERROR : ", data);
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

});
</script>
