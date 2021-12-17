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

$target_dir = "uploads/user/";
$mode = isset($_POST['mode']) ? $_POST['mode'] : ""; 
$type = isset($_POST['type']) ? $_POST['type'] : ""; 
$tgl = (new \DateTime())->format('Y-m-d H:i:s');
// switch($mode)
// {
//   case "submit" : {$user_status = 1;}break;
//   case "save" : {$user_status = 2;}break;
//   // case "delete" : {$user_status = 3;}break;
//   default : {$user_status = 0;}break;
// }

            $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : ""; 
            $user_name = isset($_POST['user_name']) ? $_POST['user_name'] : ""; 
            $user_pass = isset($_POST['user_pass']) ? $_POST['user_pass'] : ""; 
            $user_nama = isset($_POST['user_nama']) ? $_POST['user_nama'] : ""; 
            $user_status = isset($_POST['user_status']) ? $_POST['user_status'] : ""; 
            $user_company = isset($_POST['user_company']) ? $_POST['user_company'] : ""; 
            $user_email = isset($_POST['user_email']) ? $_POST['user_email'] : ""; 
            $user_hp = isset($_POST['user_hp']) ? $_POST['user_hp'] : ""; 
            $user_is_wa = isset($_POST['user_is_wa']) ? $_POST['user_is_wa'] : ""; 
            $user_is_tele = isset($_POST['user_is_tele']) ? $_POST['user_is_tele'] : ""; 
            $user_tipe = isset($_POST['user_tipe']) ? $_POST['user_tipe'] : ""; 
            $user_foto = isset($_FILES["user_foto"]["name"]) ? $_FILES["user_foto"]["name"] : ""; 
            $picture_error = isset($_POST['picture_error']) ? $_POST['picture_error'] : ""; 
            $picture_updated = isset($_POST['picture_updated']) ? $_POST['picture_updated'] : ""; 

            if($picture_error == 0 && $picture_updated == 1)
            {
              $user_foto = isset($_FILES["user_foto"]["name"]) ? $_FILES["user_foto"]["name"] : ""; 
            }
            else
            {
              $user_foto = "";
            }
      
          $delete_user_photo = isset($_POST['delete_user_photo']) ? $_POST['delete_user_photo'] : ""; 


          $message = "Insert Sukses!!";
          $tgl = (new \DateTime())->format('Y-m-d H:i:s');
          $hasil_upload1 = null;
          
          $uploadOk =1 ;
       

  $data = Array (  );
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
  if($user_tipe!="")
  {
      $data += array('user_tipe' => $user_tipe);
  }
  if($user_is_wa=="on")
  {
      $data += array('user_is_wa' => 1);
  }
  else{
      $data += array('user_is_wa' => 0);
  }

  if($user_is_tele=="on")
  {
      $data += array('user_is_tele' => 1);
  }
  else{
      $data += array('user_is_tele' => 0);
  }

  if($user_company!="")
  {
      $data += array('user_company' => $user_company);
  }
  if($user_status!="")
  {
      $data += array('user_status' => $user_status);
  }

  if($user_foto != "")
  { //echo 1;
    $hasil_upload1 = upload_files("user","user_foto",0);
    $uploadOk .= "<br>".$hasil_upload1["uploadOk"];
    $message .= "<br>".$hasil_upload1["message"];
    $user_foto = $hasil_upload1["file_name"];
    $data += array('user_foto' => $hasil_upload1["file_name"]);
  }



if(isset($_POST['delete_user_photo1']))
{
  $data += array('user_foto' => null);
  $path_file = $target_dir.$filename1;
  if (file_exists($path_file)) {     unlink ( $path_file);   }

}

// var_dump($data);
  $hasil_eksekusi = false;

if(isset($_POST['user_id']))
{    
  if($mode == "delete" && $tipe_session=="ADMIN")
    {
      $db->where('user_id', $user_id);
      $hasil_eksekusi = $db->delete('users');
      $message = "Delete Success !!";
    }
    else
    {
      $data += array('user_modified_by' => $id_session);
      $data += array('user_modified_at' => $tgl);
      $data += array('user_is_deleted' => 0);
      if( $tipe_session=="ADMIN")
      {
        $db->where ('user_id', $user_id);
      }
      else
      {
        $db->where ('user_id', $id_session);
      }
      // var_dump($data);
      $hasil_eksekusi = $db->update ('users', $data);
      $message = "Update Success !!";

    }
    
    if ($hasil_eksekusi)
    {   
      echo json_encode( array("status" => true,"info" => $user_status,"messages" => $message ) );
    }//$db->count . ' records were updated';
    else
    {   
      echo json_encode( array("status" => false,"info" => 'update failed: ' . $db->getLastError(),"messages" => $message ) );

    }

  }
  else
  {  
    $message = "Insert Success";
      $data += array("user_id" => null);
      $data += array('user_created_by' => $id_session);
      $data += array('user_created_at' => $tgl);
    if($db->insert ('users', $data))
    {
      echo json_encode( array("status" => true,"info" => $user_status,"messages" => $message ) );
  
      // $message = 1;//"Insert berhasil!";
    }
    else
    {
      $message = "Insert Fail";
      // echo 0;
      echo json_encode( array("status" => false,"info" => $db->getLastError(),"messages" => $message ) );
  
  
    }
  }
  

?>