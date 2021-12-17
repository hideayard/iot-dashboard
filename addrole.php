

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
                    <form id="roleform" class="form-horizontal" action="#"  enctype="multipart/form-data" method="post">
                          <!-- <input type="hidden" class="form-control" id="role_userid" name="role_userid" placeholder=""> -->

                    <?php
                        // $sqlp = "SELECT user_id, user_name, user_nama FROM users order by user_id "; 
                        // $resultuser = $db->rawQuery($sqlp);
                        ?>
                        

                    <!-- <div class="form-group row">
                        <label for="role_userid" class="col-sm-2 col-form-label">USER</label>
                        <div class="col-sm-10">
                          <select  id="role_userid" name="role_userid"  class="form-control select2bs4"   > 
                              <?php
                            //   foreach ($resultuser as $key => $value)
                            //   {
                            //       echo "<option value='".$value["user_id"]."'>(".$value["user_name"].") ".$value["user_nama"]."</option>" ;
                            //   }
                              ?>                               
                              </select>
                        </div>
                      </div> -->
                      <div class="form-group row">
                        <label for="role_user_tipe" class="col-sm-2 col-form-label">Role User Tipe</label>
                        <div class="col-sm-10">
                        <!-- <input type="text"  class="form-control" id="role_action" name="role_action" value="" placeholder="" > -->
                        <select class="form-control select2bs4" id="role_user_tipe" name="role_user_tipe">
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
                                 
                                  echo "<option value='".$key."' ".$selected ." >".$value."</option>" ;
                              }
                                ?>
                            </select>
                        </div>
                      </div>
                      
                     

                      <div class="form-group row">
                        <label for="role_url" class="col-sm-2 col-form-label">URL</label>
                        <div class="col-sm-10">

                          <input type="text" class="form-control" id="role_url" name="role_url" placeholder="ex. newoshe">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="role_action" class="col-sm-2 col-form-label">Action</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="role_action" name="role_action" placeholder="ex. actioncreate">

                        </div>
                      </div> 

                      <div class="form-group row">
                        <label for="role_status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                        <select class="form-control select2bs4" id="role_status" name="role_status">
                            <option value='1'>Aktif</option>
                            <option value='0'>Nonaktif</option>
                            </select>                        </div>
                      </div>    

                      
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                        <button type="submit"  id="btnSubmit" name="btnSubmit" class="btn btn-primary">Submit</button>
                        <a href="role"><button type="button"  name="cancel" class="btn btn-secondary">Cancel</button></a>
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

<script>



   $(document).ready(function () {

$.validator.setDefaults({
submitHandler: function () {
  console.log( "Form successful submitted!" );
}
});

$('#roleform').validate({
    rules: {
        role_user_tipe: {   required: true,  }
              ,role_url: {   required: true, }         
              ,role_action: {   required: true  }
              // ,user_bil_peserta: {   required: true ,  number:true, }
    },
    messages: {
        role_user_tipe: {  required: "Enter User Type", }
              ,role_url: {  required: "Enter Url Name" ,}
              ,role_action: {  required: "Enter Action Name ", }
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
var form = $('#roleform')[0];
// Create an FormData object
var data = new FormData(form);

// disabled the submit button
$("#btnSubmit").prop("disabled", true);
      $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "actionrole.php",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function (data) {
      var rv;
      try {
        rv = JSON.parse(data);
        console.log(rv.status,rv.info,rv);
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
          if(rv.status==true)
          {
            Swal.fire(
                'Success!',
                'Success Input Data!',
                'success'
                );
            console.log("SUCCESS : ", data);
            // setTimeout(function(){ window.location="users"; }, 1000);
            $("#btnSubmit").html('<span class="fa fa-paper-plane"></span> Submit');
            // $("#roleform")[0].reset();

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
