<?php
error_reporting(0);
require __DIR__ . '/vendor/autoload.php';

require_once ('config/MysqliDb.php');
include_once ("config/db.php");
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
include("config/functions.php");
require_once ("jwt_token.php");
require_once ("customhelper.php");

$formatted = [];
$formatted2 = [];
$formatted3 = [];
$formatted4 = [];
$limit = 1;

$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
$db->autoReconnect = false;

$db2 = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
$db2->autoReconnect = false;
// $db->where ('remark', '');
// $count = $db->getValue ("bot", "count(*)");
$db->orderBy("created_at","Desc");
$db->pageLimit = $limit;
// $results_pressure = $db->get ('pressure');
$page = 1;
// set page limit to 2 results per page. 20 by default
$results_pressure = $db->arraybuilder()->paginate("data_sensors", $page);
// echo "showing $page out of " . $db->totalPages;
// var_dump($results_pressure);
$i=0;
foreach($results_pressure as $key => $value)
{
    $formatted[] = floatval($value['s1']);
    $formatted[] = floatval($value['s2']);
    $formatted[] = floatval($value['s3']);
    $formatted[] = floatval($value['s4']);

    $formatted2[] = floatval($value['s5']);
    // $formatted2[] = floatval($value['s6']);
    // $formatted2[] = floatval($value['s7']);
    // $formatted2[] = floatval($value['s8']);
    $i++;
}
$json_hasil = json_encode($formatted);
// var_dump($json_hasil);
////==========================================
$db2->orderBy("created_at","Desc");
$db2->where("remark", "esp1");
$db2->pageLimit = $limit;
$page = 1;
$results_esp1 = $db2->arraybuilder()->paginate("data_sensors", $page);

$i=0;
foreach($results_esp1 as $key => $value)
{
    $formatted3[] = floatval($value['con']);
    $formatted3[] = floatval($value['flow']);
  $i++;
}
$json_hasil2 = json_encode($formatted2);
////==========================================
$db2->orderBy("created_at","Desc");
// $db2->where("remark", "esp2");
$db2->pageLimit = $limit;
$page = 1;
$results_esp2 = $db2->arraybuilder()->paginate("data_sensors", $page);

$i=0;
foreach($results_esp2 as $key => $value)
{
    $formatted4[] = floatval($value['con']);
    $formatted4[] = floatval($value['flow']);
  $i++;
}


echo json_encode(array($formatted,$formatted2,$formatted3,$formatted4));
?>