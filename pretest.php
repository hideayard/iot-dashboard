
<?php
 function toAlpha($num){
    return chr(substr("000".($num+64),-3));
}
?>

<div class="content-wrapper">
    <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Pengaturan Pre-Test</h4>
                  <form class="form-sample">
                    <p class="card-description">
                      Pengaturan Soal
                    </p>
                    <div class="row">

                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-sm-12 col-form-label" for="jmlSoal">Jumlah Soal </label>
                            <div class="col-sm-10">
                                <select class="form-control form-control-lg" id="jmlSoal" onchange="gantiSoal()">
                                    <?php
                                    $i=1;$j=10;
                                    for($i;$i<=10;$i++)
                                    {
                                        echo "<option>$i</option>";
                                    } 
                                    ?>
                                </select>
                            </div>                        
                        </div>
                      </div>

                     
                      <?php
                      $a = 1;
                      for($a;$a<=10;$a++)
                      {
                        if($a<=1){ $soal_status = ' style="display:inline;"';}
                        else{ $soal_status = ' style="display:none;"';}
                      ?>
                      <div id="soal<?=$a?>" <?=$soal_status?> class="col-md-12">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label" for="pesanPembuka">Pertanyaan <?=$a?></label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" id="pesanPembuka" rows="4"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label" for="jmlJawaban<?=$a?>">Jumlah Pilihan Ganda (alfabet) </label>
                                <div class="col-sm-10">
                                    <select class="form-control form-control-lg" id="jmljawaban<?=$a?>" onchange="gantiJawaban(<?=$a?>)">
                                        <?php
                                        $i=2;$j=10;
                                        for($i;$i<=10;$i++)
                                        {
                                            echo "<option>$i</option>";
                                        } 
                                        ?>
                                    </select>
                                </div>                        
                            </div>
                        </div>
                      

                   

                    <hr>
                    
                    <?php
               
                    $ij=1;$j=10;
                    $jawaban_status = ' style="display:none;"';
                    for($ij;$ij<=10;$ij++)
                    {
                        if($ij<=2){ $jawaban_status = ' style="display:inline;"';}
                        else{ $jawaban_status = ' style="display:none;"';}
                    ?>

                        <div id="jawaban<?=$a?>.<?=$ij?>" <?=$jawaban_status?> >
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for="txtJawaban<?=$a?>.<?=$ij?>">Text Jawaban (<?=toAlpha($ij)?>)</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" rows="4" id="txtJawaban<?=$a?>.<?=$ij?>"  name="txtJawaban<?=$a?>.<?=$ij?>"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-form-label" for="judulMenu">Kunci Jawaban?</label>
                                        <div class="col-sm-10">
                                            <label class="form-check-label">
                                            <input type="checkbox" class="form-check-input" id="kunciJawaban<?=$a?>.<?=$ij?>" name="kunciJawaban<?=$a?>.<?=$ij?>">
                                                Benar
                                            </label>
                                        </div>                        
                                    </div>
                                </div>

                            </div>
                        </div>

                    
                    <?php 
                    }   
                    ?>
                    </div>
                    <?php
                    }
                    ?>

                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>      
                  </form>
                </div>
              </div>
            </div>
</div>

<script>
function gantiSoal()
{
    let jml = document.getElementById("jmlSoal").value;
    console.log("ganti soal = ",jml);
    let a = 1;
    for(a;a<=10;a++)
    {
        if(a<=jml)
        {
            document.getElementById("soal"+a).style.display = "inline";
        }
        else
        {
            document.getElementById("soal"+a).style.display = "none";
        }
    }
}

function gantiJawaban(i)
{
    let a=1;
    let j = document.getElementById("jmljawaban"+i).value;
    for(a;a<=10;a++)
    {
        if(a<=j)
        {
            document.getElementById("jawaban"+i+"."+a).style.display = "inline";
        }
        else
        {
            document.getElementById("jawaban"+i+"."+a).style.display = "none";
        }
        
    }
    // let jml = document.getElementById("jmlSoal").value;
    console.log("gantiJawaban = ",i," j = ",j);
}
</script>
    