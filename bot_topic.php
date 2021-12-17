<?php
$str = $_SERVER['REQUEST_URI'];
$text = (explode('=', $str))[1];
$bot_id = CustomHelper::unhash($text);
$db->where ('bot_id', $bot_id);
$result_bot0 = $db->get('bot');

$db->where ('bot_id', $bot_id);
$result_bot = $db->get('bot_setting');

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
<link rel="stylesheet" href="vendors/dropify/dist/css/dropify.min.css">

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">TOPIC for <?=$result_bot0[0]["bot_name"]?> BOT</h4>

        <form class="pt-3" id="faq_form" method="POST">
                    <p class="card-description">
                      Pengaturan Pesan
                    </p>
                    <div class="row">

                      <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label" for="pesanPembuka">Pesan Pembuka</label>
                            <div class="col-sm-10">
                                <textarea rows="4"  name="pesanPembuka" id="pesanPembuka"  class="form-control form-control-lg" placeholder="Masukkan Pesan Pembuka"><?=preg_replace('#<br\s*/?>#i', "\n", $result_bot0[0]["bot_opening"] )?></textarea>
                            </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label" for="pesanError">Pesan Error</label>
                            <div class="col-sm-10">
                                <textarea rows="4"  name="pesanError" id="pesanError"  class="form-control form-control-lg" placeholder="Masukkan Pesan Error"><?=preg_replace('#<br\s*/?>#i', "\n", $result_bot0[0]["bot_error"] )?></textarea>
                            </div>                        
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-12 col-form-label" for="bot_foto">Bot Foto</label>
                          <div class="col-sm-10">
                          <?php if($result_bot0[0]['bot_foto'] != null) {  $bot_foto = "uploads/bot/".$result_bot0[0]['bot_foto']; } else { $bot_foto = "images/chat2.png"; }?>
                          <input type="file" id="bot_foto" name="bot_foto" class="bot_foto dropify-id text-white" data-default-file="<?php echo $bot_foto; ?>" data-max-file-size="2M" data-allowed-file-extensions="jpg png jpeg" />
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group row">
                        <label class="col-sm-12 col-form-label" for="bot_wall">Bot background</label>
                          <div class="col-sm-10">
                          <?php if($result_bot0[0]['bot_wall'] != null) {  $bot_wall = "images/whatsapp.jpg"; } ?>
                          <input type="file" id="bot_wall" name="bot_wall" class="bot_wall text-white" data-default-file="<?php echo $bot_wall; ?>" data-max-file-size="2M" data-allowed-file-extensions="jpg png jpeg" />
                          </div>
                        </div>
                      </div>
                      
                      <input type="hidden" name="bot_foto_removed" id="bot_foto_removed" value="0">
                      <input type="hidden" name="bot_foto_updated" id="bot_foto_updated" value="0">
                      <input type="hidden" name="bot_foto_error" id="bot_foto_error" value="0">

                      <input type="hidden" name="bot_wall_removed" id="bot_wall_removed" value="0">
                      <input type="hidden" name="bot_wall_updated" id="bot_wall_updated" value="0">
                      <input type="hidden" name="bot_wall_error" id="bot_wall_error" value="0">

                    </div>
                    <div class="mt-3">
                      <button type="submit" name="btn-faq" id="btn-faq" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Simpan</button>
                    </div>
                  </form>

                  <hr>
        <p class="card-description">
          <!-- Add class <code>.table-hover</code> -->
          <button type="button" class="btn btn-outline-primary" id="addnewbot">
            <i class="ti-plus"></i> Tambah Topic
          </button>
        </p>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Topic</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              
                foreach($result_bot as $key => $value)
                {
                  // $time_start = round(microtime(true) * 1000);
                  echo '<tr>
                    <td>'.$value["topic"].'</td>
                    <td>'.cekStatusBot($value["status"]).'</td>
                    <td><div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Action</button>
                    <div class="dropdown-menu">
                      <a href="bot_detail?hash='.CustomHelper::hash($value["id"], 6).'" class="dropdown-item"><i class="ti-list"></i> Detail</a>
                      '.cekEnDisBot($value["status"]).'
                      <button id="deleteButton'.$value["id"].'" class="dropdown-item" onclick="deletebot('.$value["id"].',\''.$value["topic"].'\');"><i class="ti-trash"></i> Delete</button>
                    </div>                          
                  </div></td>
                  </tr>';
                }
              ?>
              
            </tbody>
          </table>
          <br>
          <button type="button" class="btn btn-outline-secondary" id="kembali">
            <i class="ti-close"></i> Kembali
          </button>
        </div>
      </div>
    </div>
  </div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="vendors/dropify/dist/js/dropify.min.js"></script>

<script>
  
(function($) {
  'use strict';

  // var drEvent = $('.dropify-id').dropify({
  var drEvent = $("#bot_foto").dropify({
        messages: {
            default: 'Geser dan Lepas file disini atau klik',
            replace: 'Geser dan Lepas file untuk mengganti',
            remove:  'hapus',
            error:   'terjadi kesalahan'
        }
    });
    
  $("#bot_foto").on('change',function (event) {
    if( $("#bot_foto_error").val() == 0)
    {
      $("#bot_foto_updated").val("1");
      $("#bot_foto_removed").val("0");
      console.log('on change no error');
    }
    else
    {
      $("#bot_foto_error").val("0");
      console.log('on change error');
    }
    
  });

  drEvent.on('dropify.afterClear', function(event, element){
      $("#bot_foto_removed").val("1");
  });

  drEvent.on('dropify.errors', function(event, element){
    $("#bot_foto_updated").val("0");
    $("#bot_foto_removed").val("0");
    $("#bot_foto_error").val("1");
    console.log('Bot Foto Has Errors!');
  });

  /////////////
  var drEvent2 = $("#bot_wall").dropify({
        messages: {
            default: 'Geser dan Lepas file disini atau klik',
            replace: 'Geser dan Lepas file untuk mengganti',
            remove:  'hapus',
            error:   'terjadi kesalahan'
        }
    });
  $("#bot_wall").on('change',function (event) {
    if( $("#bot_wall_error").val() == 0)
    {
      $("#bot_wall_updated").val("1");
      $("#bot_wall_removed").val("0");
      console.log('on change no error');
    }
    else
    {
      $("#bot_wall_error").val("0");
      console.log('on change error');
    }
    
  });

  drEvent2.on('dropify.afterClear', function(event, element){
      $("#bot_wall_removed").val("1");
  });

  drEvent2.on('dropify.errors', function(event, element){
    $("#bot_wall_updated").val("0");
    $("#bot_wall_removed").val("0");
    $("#bot_wall_error").val("1");
    console.log(' Background Has Errors!');
  });

})(jQuery);
function deletebot(x,nama)
{
  console.log("x=",x);
  Swal.fire({
    title: 'Are you sure?',
    text: "Delete file ",
    html:
      '<p class="text text-danger">delete topic '+nama+'</p>',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.value) {
     
      const postCall = async () => {
          
        const location = window.location.hostname;
        const settings = {
            method: 'POST',
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",

            },
            body: 'mode=delete&id='+x+ '&token=' + getCookie('token')

        };
        try {
            const fetchResponse = await fetch(`actiontopic.php`, settings);
            const data = await fetchResponse.json();
            console.log("hasil = ",data)
            Swal.fire(
                'Deleted!',
                'Your Topic has been deleted.',
                'success'
              );
            console.log("SUCCESS : ", data);
            setTimeout(function(){ window.location.reload(true); }, 100);

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


    var form = $(".faq-form");

        form.css({
            opacity: 1,
            "-webkit-transform": "scale(1)",
            "transform": "scale(1)",
            "-webkit-transition": ".5s",
            "transition": ".5s"
        });

    $.validator.setDefaults({
    errorClass: 'form_error',
    errorElement: 'div'
    });
        /* validation */
    $("#faq_form").validate({
      rules:
      {
          pesanPembuka: {
                          required: true,
          },
          pesanError: {
                          required: true,
          },
      },
      messages:
      {
        pesanPembuka:{ required: "Mohon Masukkan Pesan Pembuka"  },
        pesanError: { required: "Mohon Masukkan Pesan Error"      }
      },
      submitHandler: submitFormFaq    
    });  
    /* validation */
    
    /* faq submit */
    function submitFormFaq()
    {        
      console.log("submit form");
        // var data = $("#faq_form").serialize();
        // console.log("data= ",data);
        // data.append("token", getCookie('token'));
        var form = $('#faq_form')[0];
        // Create an FormData object
        var data = new FormData(form);
        data.append("hash","<?=$text?>");
        data.append("mode","update");
        data.append("token",getCookie('token'));

        $.ajax({
            
        type : 'POST',
        enctype: 'multipart/form-data',
        url  : 'actionbot.php',
        data : data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
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
                          'Error NO DATA, '+rv.messages,
                          'error'
                          );
                        console.log("NO DATA : ", response);
                        // $("#error").fadeIn(500, function(){                        
                        // $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Username Or Password is Wrong !</div>');});
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
                        // setTimeout(function(){ window.location="faq"; }, 1000);
                        // window.location="index.php";
                        $("#btn-faq").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Simpan');

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
    $('faq_form').submit(function(e){

    //prevent default
    e.preventDefault();

    //do something here

    //continue submitting
    // e.currentTarget.submit();
    console.log(e);
    });

    ////=====================================================

    $("#addnewbot").click(newbot);

    $("#kembali").click(back);

    function back()
    {
        setTimeout(function(){ window.location="bot_setting"; }, 100);
    }

    function newbot()
      {
        Swal.fire({
          title: '<strong>Tambah Topik Baru</strong>',
          icon: 'info',
          html:
            '<form class="pt-3" id="newbot_form">'+
                '<div class="form-group row">'+
                  '<div class="col-md-4"> <label class=" col-form-label" for="topic_name">Nama Topik</label> </div><div class="col-md-8"> <input  name="topic_name" id="topic_name"  class="form-control form-control-lg" placeholder="Input topik baru"></div>'+
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
          console.log("topic_name = ",$("#topic_name").val());
          
          if( ($("#topic_name").val()!= '' ) )
          {
            submitForm();
          }
        } 
      });

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
url  : 'actiontopic.php',
data : data+ '&hash=<?=$text?>&token=' + getCookie('token'),
beforeSend: function()
{   
    // $("#error").fadeOut();
    // $("#btn-faq").html('<i class="fa fa-sync fa-spin"></i> &nbsp; Processing');
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
                // $("#btn-faq").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Simpan');
                        
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
                setTimeout(function(){ location.reload(); }, 1000);
                
              }

            }
      }   
      catch (e) {
        
        Swal.fire(
                  'error!',
                  'Error Input Data, '+e,
                  'error'
                  );
                  // $("#btn-faq").html('<i class="fa fa-sync fa-spin"></i> &nbsp; Simpan');
      
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