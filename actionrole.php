<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once ('config/MysqliDb.php');
include_once ("config/db.php");
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
include("config/functions.php");       
$target_dir = "uploads/role/";
$id_user = isset($_SESSION['i']) ? $_SESSION['i'] : "";
$tipe = isset($_SESSION['t']) ? $_SESSION['t'] : "";

$mode = isset($_POST['mode']) ? $_POST['mode'] : ""; 
$type = isset($_POST['type']) ? $_POST['type'] : ""; 
switch($mode)
{
  case "submit" : {$role_status = 1;}break;
  // case "delete" : {$role_status = 3;}break;
  default : {$role_status = 1;}break;
}
          $role_id = isset($_POST['role_id']) ? $_POST['role_id'] : ""; 
          $role_user_tipe = isset($_POST['role_user_tipe']) ? $_POST['role_user_tipe'] : ""; 
          $role_url = isset($_POST['role_url']) ? $_POST['role_url'] : ""; 
          $role_action = isset($_POST['role_action']) ? $_POST['role_action'] : ""; 

          $message = "Insert Sukses!!";
          $tgl = (new \DateTime())->format('Y-m-d H:i:s');


          $data = Array ( );
          if($role_id!="")
          {
              $data += array('role_id' => $role_id);
          }
          if($role_user_tipe!="")
          {
              $data += array('role_user_tipe' => $role_user_tipe);
          }
          if($role_url!="")
          {
              $data += array('role_url' => $role_url);
          }
          if($role_action!="")
          {
              $data += array('role_action' => $role_action);
          }
   
$hasil_eksekusi = false;
if(isset($_POST['role_id']))
{   
    if($mode == "delete" && $tipe=="ADMIN")
    {
      $db->where('role_id', $role_id);
      $hasil_eksekusi = $db->delete('role');
      $message = "Delete Success !!";
    }
    else
    {
      
      $data += array('role_modified_by' => $id_user);
      $data += array('role_modified_at' => $tgl);
      
      $db->where ('role_id', $role_id);
      $hasil_eksekusi = $db->update ('role', $data);
      $message = "Delete Success !!";

    }
    

    
    
    if ($hasil_eksekusi)
    {   
      echo json_encode( array("status" => true,"info" => $role_status,"messages" => $message, "data" => $data  ) );
    }//$db->count . ' records were updated';
    else
    {   
      echo json_encode( array("status" => false,"info" => 'update failed: ' . $db->getLastError(),"messages" => $message, "data" => $data  ) );

    }
       
}
else
{  

  $data += array("role_id" => null);
  $data += array('role_created_by' => $id_user);
  $data += array('role_created_at' => $tgl);

  if($db->insert ('role', $data))
  {
    echo json_encode( array("status" => true,"info" => $role_status,"messages" => $message, "data" => $data  ) );

    // $message = 1;//"Insert berhasil!";
  }
  else
  {
    // echo 0;
    echo json_encode( array("status" => false,"info" => $db->getLastError(),"messages" => $message, "data" => $data  ) );


  }
}
        
  // $hasil = $db->rawQuery($sql);// or die(mysql_error());
  // echo "<script>alert('$hasil');</script>";
  // var_dump($hasil);
  

  
?>