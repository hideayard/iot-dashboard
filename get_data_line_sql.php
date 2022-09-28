<?php
ini_set('display_errors', 0);

require __DIR__ . '/vendor/autoload.php';

require_once ('config/MysqliDb.php');
include_once ("config/db.php");
$limit = 30;
$countAnomaly = array();
$Anomaly = array();
$countAnomaly['s1'] = $countAnomaly['s2'] = $countAnomaly['s3'] = $countAnomaly['s4'] = $countAnomaly['s5'] = $countAnomaly['s6'] = $countAnomaly['s7'] = $countAnomaly['s8'] = 0;
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
$db->autoReconnect = false;

$db2 = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
$db2->autoReconnect = false;
// $db->where ('remark', '');
// $count = $db->getValue ("bot", "count(*)");
$db->where ('(status is NULL or status <> 0)');
$db->orderBy("id","Desc");
$db->pageLimit = $limit;
// $results_pressure = $db->get ('pressure');
$page = 1;
// set page limit to 2 results per page. 20 by default
$results_pressure = $db->arraybuilder()->paginate("data_sensors", $page);
// echo "showing $page out of " . $db->totalPages;
// var_dump($results_pressure);
$dataTraining = [];
$i=0;
foreach($results_pressure as $key => $value)
{
  $j=0;
  $formatted[$i]['S'.++$j] = floatval($value['s1']);
  $formatted[$i]['S'.++$j] = floatval($value['s2']);
  $formatted[$i]['S'.++$j] = floatval($value['s3']);
  $formatted[$i]['S'.++$j] = floatval($value['s4']);
  $formatted[$i]['S'.++$j] = floatval($value['s5']);
  $formatted[$i]['yaxis'] = (string)($value['created_at']);
  $j=0;
  $dataTraining[$i] = array(floatval($value['s1']) , floatval($value['s2']) , floatval($value['s3']) , floatval($value['s4']) , floatval($value['s5']) );
  $i++;
  
  if((floatval($value['s1']) < 3) || (floatval($value['s1']) > 10))
  {
    $Anomaly['s1'] = false;  
    if(++$countAnomaly['s1'] > 5)
    {
        $Anomaly['s1'] = floatval($value['s1']);
    }
  }
  if((floatval($value['s2']) < 3) || (floatval($value['s2']) > 10))
  {
    $Anomaly['s2'] = false;  
    if(++$countAnomaly['s2'] > 5)
    {
        $Anomaly['s2'] = floatval($value['s2']);
    }
  }
  if((floatval($value['s3']) < 3) || (floatval($value['s3']) > 10))
  {
    $Anomaly['s3'] = false;  
    if(++$countAnomaly['s3'] > 5)
    {
        $Anomaly['s3'] = floatval($value['s3']);
    }
  }
  if((floatval($value['s4']) < 3) || (floatval($value['s4']) > 10))
  {
    $Anomaly['s4'] = false;  
    if(++$countAnomaly['s4'] > 5)
    {
        $Anomaly['s4'] = floatval($value['s4']);
    }
  }
  if((floatval($value['s5']) < 3) || (floatval($value['s5']) > 10))
  {
    $Anomaly['s5'] = false;  
    if(++$countAnomaly['s5'] > 5)
    {
        $Anomaly['s5'] = floatval($value['s5']);
    }
  }

}

foreach ($Anomaly as $key => $value)
    if ($value == FALSE)
        unset($Anomaly[$key]);

$json_hasil1 = json_encode($formatted);
// var_dump($json_hasil);
////==========================================
$db2->orderBy("id","Desc");
// $db2->where("remark", "esp1");
$db2->pageLimit = $limit;
$page = 1;
$results_esp1 = $db2->arraybuilder()->paginate("data_sensors", $page);

$i=0;
foreach($results_esp1 as $key => $value)
{
  //6 & 7 -> flow
  // 8 & 9 -> con
  $formatted2[$i]['S1'] = floatval($value['s8']);
  $formatted3[$i]['S1'] = floatval($value['s6']);
  $formatted2[$i]['yaxis'] = (string)($value['created_at']);

  if((floatval($value['s8']) < 0.7 ) || (floatval($value['s8']) > 0.9 ))
  {
    $Anomaly['con1'] = false;  
    if(++$countAnomaly['con1'] > 5)
    {
        $Anomaly['con1'] = floatval($value['s8']);
    }
  }
  if((floatval($value['s6']) < 0) || (floatval($value['s6']) > 8))
  {
    $Anomaly['flow1'] = false;  
    if(++$countAnomaly['flow1'] > 5)
    {
        $Anomaly['flow1'] = floatval($value['s6']);
    }
  }
  
  $i++;
}
$json_hasil2 = json_encode($formatted2);
////==========================================
$db2->orderBy("id","Desc");
$db2->where("remark", "esp2");
$db2->pageLimit = $limit;
$page = 1;
$results_esp2 = $db2->arraybuilder()->paginate("flowrate", $page);

$i=0;
foreach($results_esp2 as $key => $value)
{
  $formatted2[$i]['S2'] = floatval($value['s8']);
  $formatted3[$i]['S2'] = floatval($value['s6']);
  $formatted3[$i]['yaxis'] = (string)($value['created_at']);

  if((floatval($value['s8']) < 0.7 ) || (floatval($value['s8']) > 0.9 ))
  {
    $Anomaly['con2'] = false;  
    if(++$countAnomaly['con2'] > 5)
    {
        $Anomaly['con2'] = floatval($value['s8']);
    }
  }
  if((floatval($value['s6']) < 0) || (floatval($value['s6']) > 8))
  {
    $Anomaly['flow2'] = false;  
    if(++$countAnomaly['flow2'] > 5)
    {
        $Anomaly['flow2'] = floatval($value['s6']);
    }
  }

  $i++;
}
$json_hasil3 = json_encode($formatted3);

echo json_encode(array($formatted,$formatted2,$formatted3,$Anomaly));

// return array($json_hasil1,$json_hasil2,$json_hasil3);
?>