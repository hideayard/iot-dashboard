<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once ("jwt_token.php");

require_once ('config/MysqliDb.php');
include_once ("config/db.php");
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
include("config/functions.php");    

$tgl = (new \DateTime())->format('Y-m-d H:i:s');
$user_status = 0;

            $pesanPembuka = isset($_POST['pesanPembuka']) ? $_POST['pesanPembuka'] : ""; 
            $pesanError = isset($_POST['pesanError']) ? $_POST['pesanError'] : ""; 
            $token = isset($_POST['token']) ? $_POST['token'] : ""; 
          $message = "Insert Sukses!!";
          $tgl = (new \DateTime())->format('Y-m-d H:i:s');   

  try
  {
    $vtoken = json_decode( verify_token($token) );
    // $vtoken = json_decode( verify_token($token. "1") ); //trial token error

    if($vtoken->status)
    {

        $data = Array ();
        if($pesanPembuka!="")
        {
            $data += array('user_opening' => $pesanPembuka);
        }
        if($pesanError!="")
        {
            $data += array('user_error' => $pesanError);
        }


        $hasil_eksekusi = false;

        

            $data += array('user_modified_by' => $vtoken->data->uid);
            $data += array('user_modified_at' => $tgl);

            $db->where ('user_id', 1);
            $hasil_eksekusi = $db->update ('users', $data);
            $message = "Update Success !!";

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
        echo json_encode($vtoken);
    }
  }
  //catch exception
catch(Exception $e) {
    echo 'Message: ' .$e->getMessage();
  }
          


?>