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

$settings_id = isset($_POST['settings_id']) ? $_POST['settings_id'] : ""; 
$settings_type = isset($_POST['settings_type']) ? $_POST['settings_type'] : ""; 
$settings_name = isset($_POST['settings_name']) ? $_POST['settings_name'] : ""; 
$settings_value = isset($_POST['settings_value']) ? $_POST['settings_value'] : ""; 
$settings_status = isset($_POST['settings_status']) ? intval($_POST['settings_status']) : 1; 
            
$message = "-";
     
$hasil_eksekusi = false;
$data = Array (  );
$data += array("settings_type" => $settings_type);
    $data += array("settings_name" => $settings_name);
    $data += array("settings_value" => $settings_value);
    $data += array("settings_status" => $settings_status);
if(isset($_POST['settings_id']))
{    

      if($mode == "edit" &&  $tipe_session=="ADMIN")
      {
        $db->where ('settings_id', $settings_id);
        $hasil_eksekusi = $db->update ('settings', $data);
        $message = "Update Success !!";
      }
      else if($mode == "delete" &&  $tipe_session=="ADMIN")
      {
        $db->where ('settings_id', $settings_id);
        $hasil_eksekusi = $db->delete ('settings');
        $message = "Delete Success !!";
      }
      else
      {
        $db->where ('settings_id', $settings_id);
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
    $data += array("settings_id" => null);
    
    if($db->insert ('settings', $data))
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