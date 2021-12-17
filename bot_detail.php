<?php
$str = $_SERVER['REQUEST_URI'];
$text = (explode('=', $str))[1];
$id = CustomHelper::unhash($text);

$db->where ('id', $id);
$result_bot = $db->get('bot_setting');
// var_dump($result_bot);
?>

<style>
    .buttonTextarea{
 position:absolute;
 bottom:10px;
 right:20px;
}
    </style>
<div class="content-wrapper">
    <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Pengaturan FAQ TOPIC </h4>

                  <form class="pt-3" id="botDetail_form" autocomplete="off" method="post" action="#">
                    <!-- <p class="card-description"> Pengaturan Pesan </p> -->
                    <div class="row">
                        <table class="col-md-12">
                            <tr><td class="col-md-6">
                                <div class="data-question">
                                <?php
                                $pertanyaan = explode(",",$result_bot[0]["question"]);
                                $i=0;
                                foreach($pertanyaan as $value)
                                {
                                    ++$i;
                                    if($i<=1)
                                    {
                                        $htmltxt = '<div class="form-group row">';
                                        $htmltxt .= '<label class="col-sm-12 col-form-label" for="question">Pertanyaan</label>
                                                    <div class="col-sm-10">
                                                        <textarea rows="4"  name="question0" id="question0"  class="form-control form-control-lg" placeholder="Masukkan Pertanyaan">'.$value.'</textarea>
                                                    </div>';
                                    }
                                    else
                                    {
                                        $htmltxt = '<div class="form-group row" id="divquestion'.$i.'">';
                                        $htmltxt .= '<label class="col-sm-12 col-form-label" for="question">Pertanyaan '.($i).'</label>
                                                    <div class="col-sm-10">
                                                                    <textarea rows="4"  name="question'.$i.'" id="question'.$i.'"  class="form-control form-control-lg" placeholder="Masukkan Pertanyaan">'.$value.'</textarea>
                                                                    <button onclick="hapusSimilar('.$i.');" class="buttonTextarea btn btn-danger btn-rounded btn-icon"><i class="ti-close"></i></button>
                                                                </div>';
                                    }
                                    $htmltxt .= '</div>';
                                    echo $htmltxt;
                                }
                                ?>
                                </div>
                                <input type="hidden" id="countsimilar" value="<?=$i?>" />
                                <div>
                                    <button type="button" class="btn btn-outline-primary" id="addnewsimilar">  <i class="ti-plus"></i> Tambah Pertanyaan </button>
                                </div>
                            </td>
                            <td class="col-md-6" style="vertical-align: top;">
                                <div >
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for="answer">Jawaban FAQ</label>
                                        <div class="col-sm-10">
                                            <textarea rows="4"  name="answer" id="answer"  class="form-control form-control-lg" placeholder="Masukkan Pesan Jawaban"><?=preg_replace('#<br\s*/?>#i', "\n", $result_bot[0]["response"] )?></textarea>
                                        </div>                        
                                    </div>
                                </div>
                            </td></tr>
                        </table>
                     

                     

                    </div>
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" name="btn-detail" id="btn-detail" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Simpan</button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-block btn-outline-secondary btn-lg font-weight-medium auth-form-btn" id="kembali">
                                    <i class="ti-close"></i> Kembali
                                </button>
                            </div>
                        </div>
                    </div>

                  </form>

                  
                </div>
              </div>
            </div>
</div>

<script>
console.log("cookie = "+getCookie('token'));
// setCookie
function logSubmit(event) {
  event.preventDefault();
}

const form = document.getElementById('botDetail_form');
form.addEventListener('submit', logSubmit);


function hapusSimilar(x)
{
    console.log("hapus pertanyaan = ",x)
    $('#divquestion'+x).remove();
}
// $(function(){
$(document).ready(function () {

    $("#kembali").click(back);

    function back()
    {
        setTimeout(function(){ window.history.back(); }, 100);
    }
     // Utils
     function get(selector, root = document) {
      return root.querySelector(selector);
    }

    const dataQuestion = get(".data-question");
    $("#addnewsimilar").click(newsimilar);
    $("#btn-detail").click(submitForm);

    function newsimilar()
    {
        let jml = ++document.getElementById("countsimilar").value;
        console.log("jml = ",jml);
        console.log("countsimilar = ",document.getElementById("countsimilar").value);
        const msgHTML = `
        <div class="form-group row" id="divquestion${jml}">
            <label class="col-sm-12 col-form-label" for="question">Pertanyaan ${jml}</label>
            <div class="col-sm-10">
                <textarea rows="4"  name="question${jml}" id="question${jml}"  class="form-control form-control-lg" placeholder="Masukkan Pertanyaan"></textarea>
                <button onclick="hapusSimilar(${jml});" class="buttonTextarea btn btn-danger btn-rounded btn-icon"><i class="ti-close"></i></button>
            </div>
        </div>
      `;

      dataQuestion.insertAdjacentHTML("beforeend", msgHTML);
      dataQuestion.scrollTop += 500;
    //   document.getElementById("countsimilar").value++;
      console.log("countsimilar++ = ",document.getElementById("countsimilar").value);

    }

    /* validation */
    function cekSubmitForm()
    {
        var data = $("#botDetail_form").serialize();
        console.log("data= ",data);

    }
    /* faq submit */
    function submitForm()
    {        
      console.log("submit form");
        var data = $("#botDetail_form").serialize();
        // console.log("data= ",data);
        // data.append("token", getCookie('token'));

        $.ajax({
            
        type : 'POST',
        url  : 'actionbotdetail.php',
        data : data+ '&hash=<?=$text?>&token=' + getCookie('token'),
        beforeSend: function()
        {   
            // $("#error").fadeOut();
            $("#btn-detail").html('<i class="fa fa-sync fa-spin"></i> &nbsp; Processing');
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
                        $("#btn-detail").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Simpan');
                                
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
                          $("#btn-detail").html('<i class="fa fa-sync fa-spin"></i> &nbsp; Simpan');
              
            console.log("ERROR : ", e);

              }           
                
          },
        timeout: 3000 // sets timeout to 3 seconds
        });
            return false;
    }
    /* faq submit */
    $('botDetail_form').submit(function(e){

    //prevent default
    e.preventDefault();

    //do something here

    //continue submitting
    // e.currentTarget.submit();
    console.log(e);
    });

});


    
</script>