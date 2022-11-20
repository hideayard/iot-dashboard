

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
                    <form id="nodeform" class="form-horizontal" action="#"  enctype="multipart/form-data" method="post">

                      <div class="form-group row">
                        <label for="node_name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input  type="text" class="form-control" id="node_name" name="node_name" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="node_remark" class="col-sm-2 col-form-label">Remark</label>
                        <div class="col-sm-10">
                          <input  type="text" class="form-control" id="node_remark" name="node_remark" placeholder="Remark">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="node_status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <select class="form-control select2bs4" id="node_status" name="node_status">
                            <option value='1' >Active</option>
                            <option value='0' >Nonactive</option>
                            </select>
                        </div>
                      </div>

                      
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                        <button type="submit"  id="btnSubmit" name="btnSubmit" class="btn btn-primary">Submit</button>
                        <a href="nodes"><button type="button"  name="cancel" class="btn btn-secondary">Cancel</button></a>
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

$('#nodeform').validate({
    rules: {
              node_name: {   required: true  }
              ,node_remark: {   required: true }         
    },
    messages: {
                node_name: {  required: "Enter Name First" }
              ,node_remark: {  required: "Enter Remark First" }
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
var form = $('#nodeform')[0];
// Create an FormData object
var data = new FormData(form);
data.append("mode", "add");

// disabled the submit button
$("#btnSubmit").prop("disabled", true);
      $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "actionnodes.php",
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
            setTimeout(function(){ window.location="nodes"; }, 1000);
            $("#btnSubmit").html('<span class="fa fa-paper-plane"></span> Submit');
            // $("#nodeform")[0].reset();

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
