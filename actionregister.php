<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once ('config/MysqliDb.php');
include_once ("config/db.php");
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
include("config/functions.php");    

$tgl = (new \DateTime())->format('Y-m-d H:i:s');
$user_status = 0;

            $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : ""; 
            $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : ""; 
            $user_pass = isset($_POST['user_pass']) ? $_POST['user_pass'] : ""; 
            $user_nama = isset($_POST['user_nama']) ? $_POST['user_nama'] : ""; 
            $user_email = isset($_POST['user_email']) ? $_POST['user_email'] : ""; 
            $user_hp = isset($_POST['user_hp']) ? $_POST['user_hp'] : ""; 

            if( (isset($_POST['is_wa']) && $_POST['is_wa'] == 'on') ) {  $user_is_wa = true; } else { $user_is_wa = false; }
            if( (isset($_POST['is_tele']) && $_POST['is_tele'] == 'on') ) {  $user_is_tele = true; } else { $user_is_tele = false; }


          $message = "Insert Sukses!!";
          $tgl = (new \DateTime())->format('Y-m-d H:i:s');          
  
$sql = "SELECT * FROM users where user_name='$user_name' ";
$data = $db->rawQuery($sql);
if(count($data)>0)
{
	echo json_encode( array("status" => false,"info" => "error","messages" => "Username Already Exist" ) );
}
else
{
		  
  $data = Array ();
  if($user_name!="")
  {
	  $data += array('user_name' => $user_name);
  }
  if($user_pass!="")
  {
      $data += array('user_pass' => md5($user_pass));
  }
  if($user_nama!="")
  {
      $data += array('user_nama' => $user_nama);
  }
  if($user_email!="")
  {
      $data += array('user_email' => $user_email);
  }
  if($user_hp!="")
  {
      $data += array('user_hp' => $user_hp);
  }
  if($user_is_wa!="")
  {
      $data += array('user_is_wa' => $user_is_wa);
  }
  if($user_is_tele!="")
  {
      $data += array('user_is_tele' => $user_is_tele);
  }

  $hasil_eksekusi = false;

  
      $data += array("user_id" => null);
      $data += array('user_status' => 0);
      $data += array('user_foto' => "avatar5.png");
      $data += array('user_created_by' => null);
      $data += array('user_created_at' => $tgl);
    if($db->insert ('users', $data))
    {
      echo json_encode( array("status" => true,"info" => "success","messages" => $message ) );
      }
    else
    {
      echo json_encode( array("status" => false,"info" => $db->getLastError(),"messages" => $message ) );
    }
  
} 

?>