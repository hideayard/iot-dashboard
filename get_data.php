<?php
error_reporting(0);
require __DIR__ . '/vendor/autoload.php';

require_once ('config/MysqliDb.php');
include_once ("config/db.php");
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
include("config/functions.php");
require_once ("jwt_token.php");
require_once ("customhelper.php");


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
// $json_hasil = json_encode($formatted);
// $json_hasil2 = json_encode($formatted2);
// $json_hasil3 = json_encode($formatted3);
// $json_hasil4 = json_encode($formatted4);

echo json_encode(array($formatted,$formatted2,$formatted3,$formatted4));
?>