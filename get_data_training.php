<?php
error_reporting(0);

require __DIR__ . '/vendor/autoload.php';

require_once ('config/MysqliDb.php');
include_once ("config/db.php");
$limit = 30;
$countAnomaly = array();
$Anomaly = array();
$countAnomaly['s1'] = $countAnomaly['s2'] = $countAnomaly['s3'] = $countAnomaly['s4'] = $countAnomaly['s5'] = $countAnomaly['s6'] = $countAnomaly['s7'] = $countAnomaly['s8'] = 0;
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
$db2 = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
$db->autoReconnect = false;
$db2->autoReconnect = false;

$db->orderBy("id","Desc");
$db->pageLimit = $limit;
$page = 1;

$db->where ('(status is NULL or status <> 0)');
$results_pressure = $db->arraybuilder()->paginate("data_sensors", $page);

$dataTraining = $lastData = $lastTrainingData = [];
$i=0;
foreach($results_pressure as $key => $value)
{
    
    $dataTraining[$i] = array(floatval($value['s1']) , floatval($value['s2']) , floatval($value['s3']) , floatval($value['s4']) , floatval($value['s5']) );
    if($i==0)
    {
        $lastData = $dataTraining[$i];
    }
    $i++;
}


$db2->where ('status is NULL');
$db2->where ("DATE(created_at) = CURDATE()");
$db2->orderBy("id","Asc");
//DATE(created_at)
// $results_pressure2 = $db2->arraybuilder()->paginate("data_sensors", $page);
$results_pressure2 = $db2->getOne("data_sensors",["id","s1","s2","s3","s4","s5","created_at","remark","status"]);
// $results_pressure2 = $db2->getOne ("pressure", "DATE(created_at), CURDATE()");
$i=0;

$lastTrainingData = array(floatval($results_pressure2['s1']) , floatval($results_pressure2['s2']) , floatval($results_pressure2['s3']) , floatval($results_pressure2['s4']) , floatval($results_pressure2['s5']) );



echo json_encode(array($dataTraining,$lastData,$results_pressure2["id"],$lastTrainingData));

// return array($json_hasil1,$json_hasil2,$json_hasil3);
?>