<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once ('config/MysqliDb.php');
include_once ("config/db.php");
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
include("config/functions.php");    

$id_session = isset($_SESSION['i']) ? $_SESSION['i'] : "";
$tipe_session = isset($_SESSION['t']) ? $_SESSION['t'] : "";

$mode = isset($_POST['mode']) ? $_POST['mode'] : ""; 

$node_id = isset($_POST['node_id']) ? $_POST['node_id'] : ""; 
$node_name = isset($_POST['node_name']) ? $_POST['node_name'] : ""; 
$node_remark = isset($_POST['node_remark']) ? $_POST['node_remark'] : ""; 
$node_status = isset($_POST['node_status']) ? intval($_POST['node_status']) : 1; 
            
$message = "-";
$hasil_eksekusi = false;
$data = Array (  );
$data += array("node_name" => $node_name);
$data += array("node_remark" => $node_remark);
$data += array("node_status" => $node_status);

if(isset($_POST['node_id']))
{    

      if($mode == "edit" &&  $tipe_session=="ADMIN")
      {
        $db->where ('node_id', $node_id);
        $hasil_eksekusi = $db->update ('node', $data);
        $message = "Update Success !!";
      }
      else if($mode == "delete" &&  $tipe_session=="ADMIN")
      {
        $db->where ('node_id', $node_id);
        $hasil_eksekusi = $db->delete ('node');
        $message = "Delete Success !!";
      }
      else
      {
        $db->where ('node_id', $node_id);
      }
      
     

    
    if ($hasil_eksekusi)
    {   
      echo json_encode( array("status" => true,"info" => "Update Data Success","messages" => $message ) );
    }
    else
    {   
      echo json_encode( array("status" => false,"info" => 'update failed: ' . $db->getLastError(),"messages" => $message ) );

    }

  }
  else
  {  
    $message = "Insert Success";
    $data += array("node_id" => null);
    
    if($db->insert ('node', $data))
    {
      echo json_encode( array("status" => true,"info" => $mode . " Berhasil.!","messages" => $message ) );
      }
    else
    {
      $message = "Insert Fail";
      echo json_encode( array("status" => false,"info" => $db->getLastError(),"messages" => $message ) );
  
  
    }
  }
  

?>