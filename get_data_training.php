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

$db->orderBy("id","Desc");
$db->pageLimit = $limit;
$page = 1;

$results_pressure = $db->arraybuilder()->paginate("pressure", $page);

$dataTraining = $lastData = [];
$i=0;
foreach($results_pressure as $key => $value)
{
    
    $dataTraining[$i] = array(floatval($value['s1']) , floatval($value['s2']) , floatval($value['s3']) , floatval($value['s4']) , floatval($value['s5']) , floatval($value['s6']) , floatval($value['s7']) , floatval($value['s8']));
    if($i==0)
    {
        $lastData = $dataTraining[$i];
    }
    $i++;
}

echo json_encode(array($dataTraining,$lastData));

// return array($json_hasil1,$json_hasil2,$json_hasil3);
?>