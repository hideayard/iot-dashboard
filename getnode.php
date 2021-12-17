<?php

require_once ('config/MysqliDb.php');
include_once ("config/db.php");
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
include("config/functions.php");
$info = "";
$tgl = new DateTime('now', new DateTimeZone('Asia/Jakarta')); 
$sql = "select * from node order by node_tgl desc limit 1";
$hasil = $db->rawQuery($sql);
if($hasil)
{   $status = true;
    $info = "Get Berat Success!";
}
else
{
    $status = false;
    $info = "Get Berat Error".$db->getLastError();
}

    echo json_encode( array('status'=> $status,'berat' => $hasil[0]['node_berat'] ,'msg' => $info,'tgl' => $tgl->format('Y-m-d H:i:s')) );
      /*

$db->where ('id', 1);
if ($db->update ('users', $data))
    echo $db->count . ' records were updated';
else
    echo 'update failed: ' . $db->getLastError();
      */

// $hasil = $db->insert ('participant', $data);

///////////////////////////////////////////////


?>