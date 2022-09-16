<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once ('config/MysqliDb.php');
include_once ("config/db.php");
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
include("config/functions.php");       


$s1 = (isset($_GET['s1']) && $_GET['s1'] > 0 )?$_GET['s1']:"";//pressure sensor
$s2 = (isset($_GET['s2']) && $_GET['s2'] > 0 )?$_GET['s2']:"";//pressure sensor
$s3 = (isset($_GET['s3']) && $_GET['s3'] > 0 )?$_GET['s3']:"";//pressure sensor
$s4 = (isset($_GET['s4']) && $_GET['s4'] > 0 )?$_GET['s4']:"";//pressure sensor
$s5 = (isset($_GET['s5']) && $_GET['s5'] > 0 )?$_GET['s5']:"";//pressure sensor
$s6 = (isset($_GET['s6']) && $_GET['s6'] > 0 )?$_GET['s6']:"";//pressure sensor
$s7 = (isset($_GET['s7']) && $_GET['s7'] > 0 )?$_GET['s7']:"";//pressure sensor
$s8 = (isset($_GET['s8']) && $_GET['s8'] > 0 )?$_GET['s8']:"";//pressure sensor

$con = isset($_GET['con'])?$_GET['con']:"";//conductivity sensor
$flow = isset($_GET['flow'])?$_GET['flow']:"";//flow sensor

$ip = isset($_GET['ip'])?$_GET['ip']:"";
$type = isset($_GET['type'])?$_GET['type']:'pressure';

$message = "Insert Sukses!!";
$tgl = (new \DateTime())->format('Y-m-d H:i:s');


$data = Array ( );

if($ip!="")
{
    $data += array('ip' => $ip);
}
   
$hasil_eksekusi = false;
if($type=="pressure")
{  
    if($s1!="")
    {
        $data += array('s1' => $s1);
    }
    if($s2!="")
    {
        $data += array('s2' => $s2);
    }
    if($s3!="")
    {
        $data += array('s3' => $s3);
    }
    if($s4!="")
    {
        $data += array('s4' => $s4);
    }
    if($s5!="")
    {
        $data += array('s5' => $s5);
    }
    if($s6!="")
    {
        $data += array('s6' => $s6);
    }
    if($s7!="")
    {
        $data += array('s7' => $s7);
    }
    if($s8!="")
    {
        $data += array('s8' => $s8);
    }
  $data += array('created_by' => 1234 );
  $data += array('created_at' => $tgl);

  if($db->insert ('pressure', $data))
  {
    echo json_encode( array("status" => true,"info" => $type,"messages" => $message, "data" => $data  ) );

    // $message = 1;//"Insert berhasil!";
  }
  else
  {
    // echo 0;
    echo json_encode( array("status" => false,"info" => $db->getLastError(),"messages" => $message, "data" => $data  ) );


  }
}
else 
{  
    if($type!="")
    {
        $data += array('remark' => $type);
    }
    if($con!="")
    {
        $data += array('con' => $con);
    }
    if($flow!="")
    {
        $data += array('flow' => $flow);
    }
  $data += array('created_by' => 1234 );
  $data += array('created_at' => $tgl);

  if($db->insert ('flowrate', $data))
  {
    echo json_encode( array("status" => true,"info" => $type,"messages" => $message, "data" => $data  ) );

    // $message = 1;//"Insert berhasil!";
  }
  else
  {
    // echo 0;
    echo json_encode( array("status" => false,"info" => $db->getLastError(),"messages" => $message, "data" => $data  ) );


  }
}
        
  
?>