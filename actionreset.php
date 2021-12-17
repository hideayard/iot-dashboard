<?php

require_once ('config/MysqliDb.php');
include_once ("config/db.php");
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
include("config/functions.php");

if(isset($_POST['sesi_id']))
{ 
    $sesi_id = isset($_POST['sesi_id']) ? $_POST['sesi_id'] : ""; 

    $data = Array (
        'sesi_start' => null,
        'sesi_stop' => null,
        'sesi_status' => 0,
    );
    $db->where ('sesi_id', $sesi_id);
    $hasil = $db->update('sesi', $data);
    //jika sesi start belum ada maka d isi dulu startnya, kalau sudah ada tinggal d select 
    if($hasil)
    {   $status = true;
        $info = "Reset Success!";
    }
    else
    {   $status = false;
        $info = "Reset Error".$db->getLastError();
    }

    }

    echo json_encode( array('status'=> $status,'msg' => $info ) );

///////////////////////////////////////////////


?>