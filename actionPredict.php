<?php

require_once ('config/MysqliDb.php');
include_once ("config/db.php");
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
$db2 = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
include("config/functions.php");    

$tgl = (new \DateTime())->format('Y-m-d H:i:s');
$user_status = 0;

$predict = isset($_POST['predict']) ? $_POST['predict'] : 0; 

$message = "Update Sukses!!";
$tgl = (new \DateTime())->format('Y-m-d H:i:s');   
  try
  {

$i=-1;

$db->orderBy("id","Desc");
$hasil_query = $db->getOne("pressure",['id','DATE_FORMAT(created_at, "%d %M %Y") as created_at']);
$created_at = $hasil_query["created_at"];
$id = $hasil_query["id"];

$nextMaintenance = date('Y-m-d H:i:s', strtotime( $created_at .' +'.$predict.' days'));

    $data2 = Array ();
    $data2 += array('remark' => $nextMaintenance);
    $db2->where ('id', $id);

    if(!$db2->update ('pressure', $data2))
    {
        $message = 'Update failed. Error: '. $db2->getLastError();
    }

    
echo json_encode( array("status" => true,"info" => "Update Data Success","messages" => $message ) );
}
  //catch exception
catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
  }
          


?>