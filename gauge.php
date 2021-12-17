<?php

$client = new Google_Client();
$client->setApplicationName('Google Sheets API PHP for RO System');
$client->setScopes(Google_Service_Sheets::SPREADSHEETS);
$client->setAuthConfig('spreadsheet.json');
$client->setAccessType('online');
$client->setPrompt('select_account consent');
$service = new Google_Service_Sheets($client);
$spreadsheetId = '1HZ-lVFx6TenJiFlFEv0R3d9w3FpuRXeXwZAEirHdtpU';

$rangeJumlah = '2021!Z1:Z1';
$response = $service->spreadsheets_values->get($spreadsheetId, $rangeJumlah);
$values = $response->getValues();
$jml = $values[0][0];

$start = 1;
$n = 30;
if($jml>$n)
{
  $start = $jml-$n;
}

$range = '2021!A'.($jml+1).':L'.($jml+1);

$params = array(
  'ranges' => $range
);
$result = $service->spreadsheets_values->batchGet($spreadsheetId, $params);
$hasil = $result->getValueRanges();
// printf("%d ranges retrieved.", count($hasil) );
$formatted = [];
$formatted2 = [];
$formatted3 = [];
$formatted4 = [];
$i=0;
// var_dump($hasil[0]['values']);
foreach($hasil[0]['values'] as $key => $value)
{

  $j=-1;
  
  $formatted[] = floatval($value[++$j]);
  $formatted[] = floatval($value[++$j]);
  $formatted[] = floatval($value[++$j]);
  $formatted[] = floatval($value[++$j]);

  $formatted2[] = floatval($value[++$j]);
  $formatted2[] = floatval($value[++$j]);
  $formatted2[] = floatval($value[++$j]);
  $formatted2[] = floatval($value[++$j]);


  $formatted3[] = floatval($value[++$j]);
  $formatted3[] = floatval($value[++$j]);

  $formatted4[] = floatval($value[++$j]);
  $formatted4[] = floatval($value[++$j]);

  $i++;
}
$json_hasil = json_encode($formatted);
$json_hasil2 = json_encode($formatted2);
$json_hasil3 = json_encode($formatted3);
$json_hasil4 = json_encode($formatted4);

?>
<div class="row">
    <div class="col-lg-6 grid-margin stretch-card ex1">
        <div class="card">
        <div class="card-body">
            <h4 class="card-title">Pressure</h4>
            <iframe width="100%" height="100%" frameborder="0" src="gauge_charts.php?i=1&data=<?=$json_hasil?>" scrolling="no"></iframe>
        </div>
        </div>
    </div>

    <div class="col-lg-6 grid-margin stretch-card ex1">
        <div class="card">
        <div class="card-body">
            <h4 class="card-title">Pressure</h4>
            <iframe width="100%"  height="100%" frameborder="0" src="gauge_charts.php?i=5&data=<?=$json_hasil2?>" scrolling="no"></iframe>            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 grid-margin stretch-card ex1">
        <div class="card">
        <div class="card-body">
            <h4 class="card-title">Conductivity</h4>
                <iframe width="100%"   height="100%" frameborder="0" src="gauge_charts.php?i=9&data=<?=$json_hasil3?>" scrolling="no"></iframe>            </div>
        </div>
    </div>

    <div class="col-lg-6 grid-margin stretch-card ex1">
        <div class="card">
        <div class="card-body">
            <h4 class="card-title">Flow Rate</h4>
                <iframe width="100%"  width="100%"  height="100%" frameborder="0" src="gauge_charts.php?i=11&data=<?=$json_hasil4?>" scrolling="no"></iframe>            </div>
        </div>
    </div>
</div>



