<?php
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
$db->orderBy("id","Desc");
$db->pageLimit = $limit;
// $results_pressure = $db->get ('pressure');
$page = 1;
// set page limit to 2 results per page. 20 by default
$results_pressure = $db->arraybuilder()->paginate("pressure", $page);
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
  $formatted[$i]['S'.++$j] = floatval($value['s6']);
  $formatted[$i]['S'.++$j] = floatval($value['s7']);
  $formatted[$i]['S'.++$j] = floatval($value['s8']);
  $formatted[$i]['yaxis'] = (string)($value['created_at']);
  $j=0;
  $dataTraining[$i] = array(floatval($value['s1']) , floatval($value['s2']) , floatval($value['s3']) , floatval($value['s4']) , floatval($value['s5']) , floatval($value['s6']) , floatval($value['s7']) , floatval($value['s8']));

  $i++;
  
  if(floatval($value['s1']) < 0)
  {
    $Anomaly['s1'] = false;  
    if(++$countAnomaly['s1'] > 5)
    {
        $Anomaly['s1'] = floatval($value['s1']);
    }
  }
  if(floatval($value['s2']) < 0)
  {
    $Anomaly['s2'] = false;  
    if(++$countAnomaly['s2'] > 5)
    {
        $Anomaly['s2'] = floatval($value['s2']);
    }
  }
  if(floatval($value['s3']) < 0)
  {
    $Anomaly['s3'] = false;  
    if(++$countAnomaly['s3'] > 5)
    {
        $Anomaly['s3'] = floatval($value['s3']);
    }
  }
  if(floatval($value['s4']) < 0)
  {
    $Anomaly['s4'] = false;  
    if(++$countAnomaly['s4'] > 5)
    {
        $Anomaly['s4'] = floatval($value['s4']);
    }
  }
  if(floatval($value['s5']) < 0)
  {
    $Anomaly['s5'] = false;  
    if(++$countAnomaly['s5'] > 5)
    {
        $Anomaly['s5'] = floatval($value['s5']);
    }
  }
  if(floatval($value['s6']) < 0)
  {
    $Anomaly['s6'] = false;  
    if(++$countAnomaly['s6'] > 5)
    {
        $Anomaly['s6'] = floatval($value['s6']);
    }
  }
  if(floatval($value['s7']) < 0)
  {
    $Anomaly['s7'] = false;  
    if(++$countAnomaly['s7'] > 5)
    {
        $Anomaly['s7'] = floatval($value['s7']);
    }
  }
  if(floatval($value['s8']) < 0)
  {
    $Anomaly['s8'] = false;  
    if(++$countAnomaly['s8'] > 5)
    {
        $Anomaly['s8'] = floatval($value['s8']);
    }
  }
}
$json_hasil1 = json_encode($formatted);
// var_dump($json_hasil);
////==========================================
$db2->orderBy("id","Desc");
$db2->where("remark", "esp1");
$db2->pageLimit = $limit;
$page = 1;
$results_esp1 = $db2->arraybuilder()->paginate("flowrate", $page);

$i=0;
foreach($results_esp1 as $key => $value)
{
  $formatted2[$i]['S1'] = floatval($value['con']);
  $formatted3[$i]['S1'] = floatval($value['flow']);
  $formatted2[$i]['yaxis'] = (string)($value['created_at']);
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
  $formatted2[$i]['S2'] = floatval($value['con']);
  $formatted3[$i]['S2'] = floatval($value['flow']);
  $formatted3[$i]['yaxis'] = (string)($value['created_at']);
  $i++;
}
$json_hasil3 = json_encode($formatted3);

echo json_encode(array($formatted,$formatted2,$formatted3,$Anomaly,$dataTraining));

// return array($json_hasil1,$json_hasil2,$json_hasil3);
?>