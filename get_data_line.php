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

$range = '2021!A'.$start.':L'.($jml+1);

$params = array(
  'ranges' => $range
);
$result = $service->spreadsheets_values->batchGet($spreadsheetId, $params);
$hasil = $result->getValueRanges();

$formatted = [];
$formatted2 = [];
$formatted3 = [];
$i=0;
foreach($hasil[0]['values'] as $key => $value)
{
  $formatted[$i]['yaxis'] = (string)($i+1);
  $formatted2[$i]['yaxis'] = (string)($i+1);
  $formatted3[$i]['yaxis'] = (string)($i+1);
  $j=0;
  $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
  $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
  $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
  $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
  $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
  $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
  $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
  $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
  $j = 9;
  $formatted2[$i]['S1'] = floatval($value[$j-1]);
  $j = 10;
  $formatted2[$i]['S2'] = floatval($value[$j-1]);
  $j = 11;
  $formatted3[$i]['S1'] = floatval($value[$j-1]);
  $j = 12;
  $formatted3[$i]['S2'] = floatval($value[$j-1]);
  $i++;
}
echo json_encode(array($formatted,$formatted2,$formatted3));
?>