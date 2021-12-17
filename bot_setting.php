<?php
// ti-arrow-up
$db->where ('bot_owner', $id_user);
$result_bot = $db->get('bot');
// var_dump($result_bot);

function cekStatusBot($x)
{
  switch($x)
  {
    case 0 : {
                return '<label class="badge badge-danger">Disabled</label>';
              }break;
    case 1 : {
                return '<label class="badge badge-success">Enabled</label>';
              }break;
    default : {
                return '<label class="badge badge-danger">Disabled</label>';
              }break;
  }
}

//
function cekEnDisBot($x)
{
  switch($x)
  {
    case 0 : {
                return '<a class="dropdown-item"><i class="ti-check"></i> Enable</a>';
              }break;
    case 1 : {
                return '<a class="dropdown-item"><i class="ti-power-off"></i> Disable</a>';
              }break;
    default : {
                return '<a class="dropdown-item"><i class="ti-check"></i> Enable</a>';
              }break;
  }
}
?>

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">BOT List</h4>
        <p class="card-description">
          <!-- Add class <code>.table-hover</code> -->
          <button type="button" class="btn btn-outline-primary" id="addnewbot">
            <i class="ti-plus"></i> Tambah BOT
          </button>
        </p>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Judul</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              
                foreach($result_bot as $key => $value)
                {
                  // $time_start = round(microtime(true) * 1000);
                  echo '<tr>
                    <td>'.$value["bot_name"].'</td>
                    <td>'.$value["bot_title"].'</td>
                    <td>'.cekStatusBot($value["bot_status"]).'</td>
                    <td><div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button>
                    <div class="dropdown-menu">
                      <a href="../bot/'.$value["bot_name"].'" class="dropdown-item"><i class="ti-share"></i> share</a>
                      <a href="bot_topic?hash='.CustomHelper::hash($value["bot_id"], 6).'" class="dropdown-item"><i class="ti-list"></i> Detail</a>
                    '.cekEnDisBot($value["bot_status"]).'
                      <button id="deleteButton'.$value["bot_id"].'" class="dropdown-item" onclick="deletebot('.$value["bot_id"].',\''.$value["bot_name"].'\');"><i class="ti-trash"></i> Delete</button>
                    </div>                          
                  </div></td>
                  </tr>';
                }
              ?>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  

<script>
function deletebot(x,nama)
{
  console.log("x=",x);
  Swal.fire({
    title: 'Are you sure?',
    text: "Delete file ",
    html:
      '<p class="text text-danger">delete bot '+nama+'</p>',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.value) {
     
      const postCall = async () => {
      let formData = new FormData();
      formData.append('mode', 'delete');
      formData.append('bot_id', x);
      formData.append('token', getCookie('token'));

      const location = window.location.hostname;
      const settings = {
          method: 'POST',
          headers: {
              // Accept: 'application/json',
              // 'Content-Type': 'application/json',
              "Content-Type": "application/x-www-form-urlencoded",

          },
          body: 'mode=delete&bot_id='+x+ '&token=' + getCookie('token')

      };
      try {
          const fetchResponse = await fetch(`actionbot.php`, settings);
          const data = await fetchResponse.json();
          console.log("hasil = ",data)
          Swal.fire(
              'Deleted!',
              'Your Bot has been deleted.',
              'success'
            );
          console.log("SUCCESS : ", data);
          setTimeout(function(){ window.location="bot_setting"; }, 1000);
          return data;
      } catch (e) {
          return e;
          console.log("error = ",data);
          Swal.fire(
              'error!',
              'Error Delete Data.',
              'error'
            );
      }   
    } 
    postCall();
      
    }
  })
  

  // var xhttp = new XMLHttpRequest();
  // xhttp.open("POST", "actionbot.php", true); 
  // xhttp.setRequestHeader("Content-Type", "application/json");
  // xhttp.onreadystatechange = function() {
  //   if (this.readyState == 4 && this.status == 200) {
  //     // Response
  //     var response = this.responseText;
  //   }
  // };
  // var data = {  mode: "delete", bot_id:x, token: getCookie('token') };
  // xhttp.send(formData);

}

// $(function(){
  $(document).ready(function () {
    console.log( "ready!" );
    $("#addnewbot").click(newbot);

    function newbot()
      {
        Swal.fire({
          title: '<strong>Add New BOT</strong>',
          icon: 'info',
          html:
            '<form class="pt-3" id="newbot_form">'+
                '<div class="form-group row">'+
                  '<div class="col-md-4"> <label class=" col-form-label" for="bot_name">Nama Bot</label> </div><div class="col-md-8"> <input  name="bot_name" id="bot_name"  class="form-control form-control-lg" placeholder="Input Nama Bot"></div>'+
                '</div>'+
                '<div class="form-group row">'+
                 '<div class="col-md-4"> <label class="col-form-label" for="bot_title">Nama Bisnis</label> </div><div class="col-md-8"> <input name="bot_title" id="bot_title" type="text" class="form-control form-control-lg" placeholder="Input Nama Bisnis"></div>'+
                '</div>'+
              '  <div class="mt-3">'+
                //  ' <button type="submit" name="btn-login" id="btn-login" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Sign In</button>'+
              '</form>',
          showCloseButton: true,
          showCancelButton: true,
          focusConfirm: false,
          confirmButtonText:
            '<i class="ti-plus"></i> Submit',
          confirmButtonAriaLabel: 'Submit!',
          cancelButtonText:
            '<i class="ti-close"></i> Cancel',
          cancelButtonAriaLabel: 'Cancel'
        }).then((result) => {
          console.log("result = ",result);
        /* Read more about isConfirmed, isDenied below */
        if (result.value) {
          console.log("bot_name = ",$("#bot_name").val());
          console.log("bot_title = ",$("#bot_title").val());
          console.log("whitespaces = ",hasWhiteSpace( $("#bot_name").val() ) );

          if( ( $("#bot_name").val()!= '' ) && ($("#bot_title").val() != '') )
          {
            if( hasWhiteSpace($("#bot_name").val()) )
            {
              Swal.fire("Nama Bot tidak boleh ada spasi.");
            }
            else{
              submitForm();
            }
          }
          else{
            Swal.fire("Nama Bot dan Nama Bisnis harus di isi");
          }
        } 
      });

      }

// Use includes method on string
function hasWhiteSpace(s) {
  const whitespaceChars = [' ', '\t', '\n'];
  return whitespaceChars.some(char => s.includes(char));
}

// Use character comparison
function hasWhiteSpace(s) {
  const whitespaceChars = [' ', '\t', '\n'];
  return Array.from(s).some(char => whitespaceChars.includes(char));
}

/* faq submit */
function submitForm()
{        
  console.log("submit form");
  var data = $("#newbot_form").serialize();
  // console.log("data= ",data);
  // data.append("token", getCookie('token'));

  $.ajax({
      
  type : 'POST',
  url  : 'actionbot.php',
  data : data+ '&token=' + getCookie('token'),
  beforeSend: function()
  {   
      // $("#error").fadeOut();
      $("#btn-faq").html('<i class="fa fa-sync fa-spin"></i> &nbsp; Processing');
  },
  success :  function(response)
      {          
        try{
              rv = JSON.parse(response);
              if(isEmpty(rv) || rv.status==false)
              {
                Swal.fire(
                    'error!',
                    'Error, '+rv.messages,
                    'error'
                    );
                  console.log("Error : ", response);
                  $("#btn-faq").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Simpan');
                          
              }
              else
              {
                if(rv.status==true)
                {
                  Swal.fire(
                    'Success!',
                    'Success Submit Data!',
                    'success'
                    );
                  console.log("SUCCESS : ", rv);
                  setTimeout(function(){ window.location="bot_setting"; }, 1000);
                }

              }
        }   
        catch (e) {
          
          Swal.fire(
                    'error!',
                    'Error Input Data, '+e,
                    'error'
                    );
                    $("#btn-faq").html('<i class="fa fa-sync fa-spin"></i> &nbsp; Simpan');
        
      console.log("ERROR : ", e);

        }           
          
    },
  timeout: 3000 // sets timeout to 3 seconds
  });
    return false;
}

/* faq submit */
$('newbot_form').submit(function(e){

//prevent default
e.preventDefault();

//do something here

//continue submitting
// e.currentTarget.submit();
console.log(e);
});

});

</script>