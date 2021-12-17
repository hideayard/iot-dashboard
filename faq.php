<div class="content-wrapper">
    <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Pengaturan FAQ</h4>

                  <!-- <form class="pt-3" id="faq_form" method="POST">
                    <p class="card-description">
                      Pengaturan Pesan
                    </p>
                    <div class="row">

                      <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label" for="pesanPembuka">Pesan Pembuka</label>
                            <div class="col-sm-10">
                                <textarea rows="4"  name="pesanPembuka" id="pesanPembuka"  class="form-control form-control-lg" placeholder="Masukkan Pesan Pembuka"></textarea>
                            </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label" for="pesanError">Pesan Error</label>
                            <div class="col-sm-10">
                                <textarea rows="4"  name="pesanError" id="pesanError"  class="form-control form-control-lg" placeholder="Masukkan Pesan Error"></textarea>
                            </div>                        
                        </div>
                      </div>

                    </div>
                    <div class="mt-3">
                      <button type="submit" name="btn-faq" id="btn-faq" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Simpan</button>
                    </div>
                  </form> -->

                  <form class="form-sample">
                    <hr>
                    
                    <p class="card-description">
                      Import Data
                    </p>
                    <!-- hr>
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-sm-12 col-form-label" for="jmlMenu">Jumlah Menu </label>
                            <div class="col-sm-10">
                                <select class="form-control form-control-lg" id="jmlMenu" onchange="gantiMenu()">
                                    <?php
                                    $i=1;$j=20;
                                    for($i;$i<=$j;$i++)
                                    {
                                        echo "<option>$i</option>";
                                    } 
                                    ?>
                                </select>
                            </div>                        
                        </div>
                      </div>
                    </div>   -->

                    <div class="row" >

                      <div class="col-md-6">

                          <div class="btn-group">
                            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-toggle="dropdown">Download File CSV</button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item">Template csv</a>
                              <!-- <a class="dropdown-item">Import Csv</a> -->
                              <a class="dropdown-item">Export csv</a>
                            </div>                          
                          </div>
                          
                        <!-- <div class="form-group row">
                            <label class="col-sm-12 col-form-label" for="tipeMenu<?=$i?>">Download Template CSV</label>
                            <div class="col-sm-10">
                                <button type="button" class="btn btn-primary mr-2">Download</button>
                            </div>                        
                        </div> -->
                      </div> 

                     

                    </div> 
                    <br>
                    <div class="row" >

                        <div class="col-md-10">

                            <div class="form-group row">
                            <label for="user_foto" class="col-sm-2 col-form-label">Import excel/csv</label>
                            <div class="col-sm-10">
                              <input type="file" id="user_foto" name="user_foto" class="file-upload-default">
                              <div class="input-group col-xs-12">
                                <input type="text" class="form-control file-upload-info" disabled placeholder="Upload file csv">
                                <span class="input-group-append">
                                  <button class="file-upload-browse btn btn-primary" type="button">Upload File Csv</button>
                                </span>
                              </div>
                            </div>
                          </div>  

                        </div>  

                    </div>  


                    
                  <?php
                        $i=1;
                        for($i;$i<=$j;$i++)
                        {
                          if($i<=1){ $menu_status = ' style="display:inline;"';}
                            else{ $menu_status = ' style="display:none;"';}
                           
                    ?>
                    <!-- <div id="menu<?=$i?>" <?=$menu_status?> >
                    <hr>
                      <div class="row" >

                        <div class="col-md-6">
                          <div class="form-group row">
                              <label class="col-sm-12 col-form-label" for="tipeMenu<?=$i?>">Tipe Menu <?=$i?></label>
                              <div class="col-sm-10">
                                  <select class="form-control form-control-lg" id="tipeMenu<?=$i?>" onchange="">
                                  <option>Info</option>
                                  <option>Input Text</option>
                                  <option>Input Number</option>
                                  <option>Input File</option>
                                  </select>
                              </div>                        
                          </div>
                        </div>
                        <hr>
                        <div class="col-md-6">
                          <div class="form-group row">
                              <label class="col-sm-12 col-form-label" for="command<?=$i?>">Perintah <?=$i?></label>
                              <div class="col-sm-10">
                                  <textarea class="form-control" id="command<?=$i?>" rows="4"></textarea>
                              </div>
                          </div>
                        </div> 

                      </div>

                      <div class="row" >

                        <div class="col-md-4">
                          <div class="form-group row">
                              <label class="col-sm-12 col-form-label" for="judulMenu<?=$i?>">Judul Menu <?=$i?></label>
                              <div class="col-sm-10">
                                  <textarea class="form-control" id="judulMenu<?=$i?>" rows="4"></textarea>
                              </div>                        
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group row">
                              <label class="col-sm-12 col-form-label" for="jawabanMenu<?=$i?>">Jawaban Bot<?=$i?></label>
                              <div class="col-sm-10">
                                  <textarea class="form-control" id="jawabanMenu<?=$i?>" rows="4"></textarea>
                              </div>                        
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group row">
                              <label class="col-sm-12 col-form-label" for="parentMenu<?=$i?>">Parent Menu <?=$i?></label>
                              <div class="col-sm-10">
                              <select class="form-control form-control-lg" id="parentMenu<?=$i?>" onchange="">
                                  <?php
                                  $ii = 1;
                                  for($ii;$ii<$i;$ii++)
                                  {
                                    echo "<option value='$ii'>Menu $ii</option>";
                                  }
                                  ?>
                                  </select>
                              </div>                        
                          </div>
                        </div>

                      </div>
                    </div> -->
                    <?php } ?>
                    <hr>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>      
                  </form>
                </div>
              </div>
            </div>
</div>

<script>
console.log("cookie = "+getCookie('token'));
function gantiMenu()
{
    let jml = document.getElementById("jmlMenu").value;
    console.log("ganti Menu = ",jml);
    let a = 1;
    for(a;a<=<?=$j?>;a++)
    {
        if(a<=jml)
        {
            document.getElementById("menu"+a).style.display = "inline";
        }
        else
        {
            document.getElementById("menu"+a).style.display = "none";
        }
    }
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
      submitHandler: submitForm    
    });  
    /* validation */
    
    /* faq submit */
    function submitForm()
    {        
      console.log("submit form");
        var data = $("#faq_form").serialize();
        // console.log("data= ",data);
        // data.append("token", getCookie('token'));

        $.ajax({
            
        type : 'POST',
        url  : 'actionfaq.php',
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
                        setTimeout(function(){ window.location="faq"; }, 1000);
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

});


    
</script>