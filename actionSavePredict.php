<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once ('config/MysqliDb.php');
include_once ("config/db.php");
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
$db2 = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
include("config/functions.php");    

$tgl = (new \DateTime())->format('Y-m-d H:i:s');
$user_status = 0;

$predict = isset($_POST['predict']) ? explode(",",$_POST['predict']) : []; 
$id = isset($_POST['id']) ? $_POST['id'] : ""; 

$token = isset($_POST['token']) ? $_POST['token'] : ""; 
$message = "Insert Sukses!!";
$tgl = (new \DateTime())->format('Y-m-d H:i:s');   
  try
  {

$label = ["s1","s2","s3","s4","s5","s6","s7","s8","s9"];
$i=-1;
if($id!="")
{
    $data = Array ();
    $data += array('data_id' => $id);
    $data += array('s1' => floatval($predict[0]) );
    $data += array('s2' => floatval($predict[1]) );
    $data += array('s3' => floatval($predict[2]) );
    $data += array('s4' => floatval($predict[3]) );
    $data += array('s5' => floatval($predict[4]) );
    $data += array('s6' => floatval($predict[5]) );
    $data += array('s7' => floatval($predict[6]) );
    $data += array('s8' => floatval($predict[7]) );
    $data += array('s9' => floatval($predict[8]) );

    $data += array('remark' => $label[$i]);
    $data += array('created_by' => 0);
    $data += array('modified_by' => 0);
    $data += array('status' => 1);
    if(!$db->insert ('prediction', $data))
    {
        $message = 'Insert failed. Error: '. $db->getLastError();

    }

    $data2 = Array ();
    $data2 += array('status' => 1);
    $db2->where ('id', $id);

    if(!$db2->update ('data_sensors', $data2))
    {
        $message = 'Update failed. Error: '. $db2->getLastError();
    }
}
    
echo json_encode( array("status" => true,"info" => "Insert Data Success","messages" => $message ) );
}
  //catch exception
catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
  }
          


?>