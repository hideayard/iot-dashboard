<?php
error_reporting(E_ERROR | E_PARSE);

$s1 = isset($_GET['s1'])?$_GET['s1']:0;
$s2 = isset($_GET['s2'])?$_GET['s2']:0;
$s3 = isset($_GET['s3'])?$_GET['s3']:0;
$s4 = isset($_GET['s4'])?$_GET['s4']:0;
$s5 = isset($_GET['s5'])?$_GET['s5']:0;
$s6 = isset($_GET['s6'])?$_GET['s6']:0;
$s7 = isset($_GET['s7'])?$_GET['s7']:0;
$s8 = isset($_GET['s8'])?$_GET['s8']:0;
$s9 = isset($_GET['s9'])?$_GET['s9']:0;
$s10 = isset($_GET['s10'])?$_GET['s10']:0;
$s11 = isset($_GET['s11'])?$_GET['s11']:0;
$s12 = isset($_GET['s12'])?$_GET['s12']:0;
if($s1 > 0 || $s2 > 0 || $s3 > 0 || $s4 > 0 || $s5 > 0 || $s6 > 0 || $s7 > 0 || $s8 > 0 )
{
    $s11 = $s12 = 10;
}
else{
    $s11 = $s12 = 4;
}
$s10 = $s9 = 2.5;

require __DIR__ . '/vendor/autoload.php';

$client = new Google_Client();
$client->setApplicationName('Google Sheets API PHP Quickstart');
$client->setScopes(Google_Service_Sheets::SPREADSHEETS);
$client->setAuthConfig('tvet.json');
$client->setAccessType('offline');
$client->setPrompt('select_account consent');
$service = new Google_Service_Sheets($client);
$spreadsheetId = '1HZ-lVFx6TenJiFlFEv0R3d9w3FpuRXeXwZAEirHdtpU';

//read
// $response = $service->spreadsheets_values->get($spreadsheetId, $range);
// $values = $response->getValues();
// var_dump($values);

$rangeJumlah = '2021!Z1:Z1';
$response = $service->spreadsheets_values->get($spreadsheetId, $rangeJumlah);
$values = $response->getValues();
$jml = $values[0][0];
// var_dump($values);
$range = '2021!A'.($jml+1).':L'.($jml+1);

//======================== append / insert
// $values = [ [ generateRandomString(),generateRandomString(),generateRandomString()], ];

// $values = [ [ rand_float(0,100),rand_float(0,100),rand_float(0,100)], ];
$values = [ [ $s1,$s2,$s3,$s4,$s5,$s6,$s7,$s8,$s9,$s10,$s11,$s12 ], ];

// echo rand_float(0,20)."\n";

$body = new Google_Service_Sheets_ValueRange([
    'values' => $values
]);
$params = [
    'valueInputOption' => 'RAW'
];
$insert = [
    'valueInputOption' => 'INSERT_ROWS'
];
$result = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params, $insert);
printf("%d cells appended.", $result->getUpdates()->getUpdatedCells());
//-------------------------------

//====================update jumlah
$valuesJumlah = [
    [ ($jml+1) ],
    // Additional rows ...
];
$body = new Google_Service_Sheets_ValueRange([
    'values' => $valuesJumlah
]);
$params = [
    'valueInputOption' => 'RAW'
];
$result = $service->spreadsheets_values->update($spreadsheetId, $rangeJumlah,
$body, $params);
printf("Jumlah cells updated.");

//------------------------


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function rand_float($st_num=0,$end_num=1,$mul=1000000)
{
if ($st_num>$end_num) return false;
return mt_rand($st_num*$mul,$end_num*$mul)/$mul;
}

?>