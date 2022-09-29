<?php

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

$label = ["s1","s2","s3","s4","s5","s6","s7","s8"];
$i=-1;
if($id!="")
{
    $data = Array ();
    $data += array('data_id' => $id);
    $data += array('s'.($i+2) => floatval($predict[++$i]) );
    $data += array('s'.($i+2) => floatval($predict[++$i]) );
    $data += array('s'.($i+2) => floatval($predict[++$i]) );
    $data += array('s'.($i+2) => floatval($predict[++$i]) );
    $data += array('s'.($i+2) => floatval($predict[++$i]) );
    $data += array('s'.($i+2) => floatval($predict[++$i]) );
    $data += array('s'.($i+2) => floatval($predict[++$i]) );
    $data += array('s'.($i+2) => floatval($predict[++$i]) );
    $data += array('s'.($i+2) => floatval($predict[++$i]) );

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