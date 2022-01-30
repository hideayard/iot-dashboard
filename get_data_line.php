<?php
error_reporting(0);
require __DIR__ . '/vendor/autoload.php';

require_once ('config/MysqliDb.php');
include_once ("config/db.php");
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
include("config/functions.php");
require_once ("jwt_token.php");
require_once ("customhelper.php");

$type = isset($_GET['type'])?$_GET['type']:'pressure';

$startColumn = "A";
$endColumn = "J";

if($type != "pressure" )
{
    $startColumn = "A";
    $endColumn = "D";
}

$client = new Google_Client();
$client->setApplicationName('Google Sheets API PHP for RO System');
$client->setScopes(Google_Service_Sheets::SPREADSHEETS);
$client->setAuthConfig('spreadsheet.json');
$client->setAccessType('online');
$client->setPrompt('select_account consent');
$service = new Google_Service_Sheets($client);
$spreadsheetId = '1HZ-lVFx6TenJiFlFEv0R3d9w3FpuRXeXwZAEirHdtpU';

$rangeJumlah = $type.'!Z1:Z1';
$response = $service->spreadsheets_values->get($spreadsheetId, $rangeJumlah);
$values = $response->getValues();
$jml = $values[0][0];

$start = 1;
$n = 30;
if($jml>$n)
{
  $start = $jml-$n;
}

// $range =  $type.'!A'.$start.':L'.($jml+1); // old
$range =  $type.'!'.$startColumn.$start.':'.$endColumn.($jml+1);
// $range = $type.'!'.$start.($jml+1).':'.$end.($jml+1);

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
  if($type == "pressure" )
  {
    // $formatted[$i]['yaxis'] = (string)($i+1);
    $j=0;
    $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
    $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
    $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
    $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
    $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
    $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
    $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
    $formatted[$i]['S'.++$j] = floatval($value[$j-1]);
    $formatted[$i]['yaxis'] = (string)($value[$j+1]);

  }
  else if($type == "esp1" )
  {
    // $formatted[$i]['yaxis'] = (string)($i+1);
    $j = 9;
    $formatted[$i]['S1'] = floatval($value[$j-1]);
    $j = 10;
    $formatted[$i]['S2'] = floatval($value[$j-1]);
    $formatted[$i]['yaxis'] = (string)($value[$j+1]);

  }
  else if($type == "esp2" )
  {
    // $formatted[$i]['yaxis'] = (string)($i+1);
    $j = 11;
    $formatted[$i]['S1'] = floatval($value[$j-1]);
    $j = 12;
    $formatted[$i]['S2'] = floatval($value[$j-1]);
    $formatted[$i]['yaxis'] = (string)($value[$j+1]);

  }
  $i++;
}
echo json_encode($formatted);
?>