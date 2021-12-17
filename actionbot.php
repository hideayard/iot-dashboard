<?php
error_reporting(E_ALL ^ E_NOTICE);

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
session_start();
require_once ("jwt_token.php");
require_once ("customhelper.php");

require_once ('config/MysqliDb.php');
include_once ("config/db.php");
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);
$db2 = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);

include("config/functions.php");    

$tgl = (new \DateTime())->format('Y-m-d H:i:s');
$user_status = 0;

        $bot_name = isset($_POST['bot_name']) ? $_POST['bot_name'] : ""; 
        $bot_title = isset($_POST['bot_title']) ? $_POST['bot_title'] : ""; 
        $token = isset($_POST['token']) ? $_POST['token'] : ""; 
        $mode = isset($_POST['mode']) ? $_POST['mode'] : "insert"; 
        $bot_id = isset($_POST['bot_id']) ? $_POST['bot_id'] : ""; 
        $message = "Insert Sukses!!";
        $tgl = (new \DateTime())->format('Y-m-d H:i:s');   
        $pesanPembuka = isset($_POST['pesanPembuka']) ? $_POST['pesanPembuka'] : ""; 
        $pesanError = isset($_POST['pesanError']) ? $_POST['pesanError'] : ""; 
        $hash = isset($_POST['hash']) ? $_POST['hash'] : ""; 
        $id = CustomHelper::unhash($hash);
        /////////////////////////
        // $bot_foto = isset($_FILES["bot_foto"]["name"]) ? $_FILES["bot_foto"]["name"] : ""; 
        $bot_foto_error = isset($_POST['bot_foto_error']) ? $_POST['bot_foto_error'] : ""; 
        $bot_foto_updated = isset($_POST['bot_foto_updated']) ? $_POST['bot_foto_updated'] : ""; 

        if($bot_foto_error == 0 && $bot_foto_updated == 1)
        {
          $bot_foto = isset($_FILES["bot_foto"]["name"]) ? $_FILES["bot_foto"]["name"] : ""; 
        }
        else
        {
          $bot_foto = "";
        }
  
        $delete_bot_foto = isset($_POST['delete_bot_foto']) ? $_POST['delete_bot_foto'] : ""; 

        //////////////////////////

        // $bot_wall = isset($_FILES["bot_wall"]["name"]) ? $_FILES["bot_wall"]["name"] : ""; 
        $bot_wall_error = isset($_POST['bot_wall_error']) ? $_POST['bot_wall_error'] : ""; 
        $bot_wall_updated = isset($_POST['bot_wall_updated']) ? $_POST['bot_wall_updated'] : ""; 

        if($bot_wall_error == 0 && $bot_wall_updated == 1)
        {
            $bot_wall = isset($_FILES["bot_wall"]["name"]) ? $_FILES["bot_wall"]["name"] : ""; 
        }
        else
        {
            $bot_wall = "";
        }

        $delete_bot_wall = isset($_POST['delete_bot_wall']) ? $_POST['delete_bot_wall'] : "";
        $data = Array (  );
        $upload_bot_foto =1 ;
        $upload_bot_wall =1 ;
  try
  {

    $vtoken = json_decode( verify_token($token) );
    // $vtoken = json_decode( verify_token($token. "1") ); //trial token error
    if($vtoken->status)
    {
        if($mode == "insert" )
        {
            $db->where ('bot_owner', $vtoken->data->uid);
            // $count = $db->getValue ("bot", "count(*)");
            $results = $db->get ('bot');
            $count = count($results);

            if($count<2)
            {
                $data = Array ("bot_id" => null,
                "bot_name" => $bot_name,
                "bot_title" => $bot_title,
                "bot_opening" => null,
                "bot_error" => null,
                "bot_setting" => null,
                "bot_owner" => $vtoken->data->uid,
                "bot_status" => 1,
                "created_at" => (new \DateTime())->format('Y-m-d H:i:s'),
                "created_by" => $vtoken->data->uid,
                "modified_at" => (new \DateTime())->format('Y-m-d H:i:s'),
                "modified_by" => $vtoken->data->uid,
                );
                /////insert foto
                if($bot_foto != "")
                { //echo 1;
                    $hasil_upload1 = upload_files("bot","bot_foto",0);
                    $upload_bot_foto .= "<br>".$hasil_upload1["uploadOk"];
                    $message .= "<br>".$hasil_upload1["message"];
                    $bot_foto = $hasil_upload1["file_name"];
                    $data += array('bot_foto' => $hasil_upload1["file_name"]);
                }

                if($bot_wall != "")
                { //echo 1;
                    $hasil_upload2 = upload_files("bot","bot_wall",0);
                    $upload_bot_wall .= "<br>".$hasil_upload2["uploadOk"];
                    $message .= "<br>".$hasil_upload2["message"];
                    $bot_foto = $hasil_upload2["file_name"];
                    $data += array('bot_wall' => $hasil_upload2["file_name"]);
                }
                ///cek if delete foto
                if(isset($_POST['delete_bot_foto']))
                {
                    $data += array('bot_foto' => null);
                    $path_file = $target_dir.$filename1;
                    if (file_exists($path_file)) {     unlink ( $path_file);   }
                }

                if(isset($_POST['delete_bot_wall']))
                {
                    $data += array('bot_wall' => null);
                    $path_file = $target_dir.$filename1;
                    if (file_exists($path_file)) {     unlink ( $path_file);   }
                }


                $hasil = $db->insert ('bot', $data);
            
                if($hasil)
                {
                    echo json_encode( array("status" => true,"info" =>  'success get answer',"messages" => "sukses menambahkan bot baru" ) );
                }
                else
                {
                    echo json_encode( array("status" => false,"info" => 'Error Create New Bot',"messages" => "gagal menambahkan bot baru!" ) );
                }
            }
            else
            {
                echo json_encode( array("status" => false,"info" => 'Error Create New Bot',"messages" => "Jumlah maksimal BOT untuk versi gratis adalah 2" ) );

            }

        }
        else if($mode == "update" )
        {
            $data = Array ();
            if($pesanPembuka!="")
            {
                $pesanPembuka =  preg_replace( "/\r|\n/", "", nl2br( $pesanPembuka) );
                $data += array('bot_opening' => $pesanPembuka);
            }
            if($pesanError!="")
            {
                $pesanError =  preg_replace( "/\r|\n/", "", nl2br( $pesanError) );
                $data += array('bot_error' => $pesanError);
            }
            /////insert foto
            if($bot_foto != "")
            { //echo 1;
                $hasil_upload1 = upload_files("bot","bot_foto",0);
                $upload_bot_foto .= "<br>".$hasil_upload1["uploadOk"];
                $message .= "<br>".$hasil_upload1["message"];
                $bot_foto = $hasil_upload1["file_name"];
                $data += array('bot_foto' => $hasil_upload1["file_name"]);
            }

            if($bot_wall != "")
            { //echo 1;
                $hasil_upload2 = upload_files("bot","bot_wall",0);
                $upload_bot_wall .= "<br>".$hasil_upload2["uploadOk"];
                $message .= "<br>".$hasil_upload2["message"];
                $bot_foto = $hasil_upload2["file_name"];
                $data += array('bot_wall' => $hasil_upload2["file_name"]);
            }
            ///cek if delete foto
            if(isset($_POST['delete_bot_foto']))
            {
                $data += array('bot_foto' => null);
                $path_file = $target_dir.$filename1;
                if (file_exists($path_file)) {     unlink ( $path_file);   }
            }

            if(isset($_POST['delete_bot_wall']))
            {
                $data += array('bot_wall' => null);
                $path_file = $target_dir.$filename1;
                if (file_exists($path_file)) {     unlink ( $path_file);   }
            }

            $data += array('modified_by' => $vtoken->data->uid);
            $data += array('modified_at' => $tgl);

            $db->where ('bot_id', $id);
            $hasil_eksekusi = $db->update ('bot', $data);
            $message = "Update Success !!";
            if ($hasil_eksekusi)
            {   
                echo json_encode( array("status" => true,"info" => "Update Data Success","messages" => $message ) );
            }
            else
            {   
                echo json_encode( array("status" => false,"info" => 'update failed: ' . $db->getLastError(),"messages" => $message ) );
        
            }
            // echo json_encode( array("status" => false,"info" => 'Error Update Bot',"messages" => "gagal Update Bot!" ) );

        }
        else
        {
            // 
            // echo json_encode( array("status" => true,"info" =>  'success get answer',"messages" => "mode = ".$mode." , bot_id = ".$bot_id ) );
            $db->where('bot_owner',$vtoken->data->uid);
            $db->where('bot_id',$bot_id);
            $hasil_eksekusi = $db->delete('bot');

            
            if($hasil_eksekusi)
            {
                $db2->where('bot_id',$bot_id);
                $hasil_eksekusi2 = $db2->delete('bot_setting');
                if($hasil_eksekusi2)
                {
                    echo json_encode( array("status" => true,"info" =>  'success delete bot',"messages" => "sukses menghapus bot" ) );
                }
                else
                {
                    echo json_encode( array("status" => false,"info" => 'Error delete Bot',"messages" => "gagal menghapus bot!" ) );
                }
            }
            else
            {
                echo json_encode( array("status" => false,"info" => 'Error delete Bot',"messages" => "gagal menghapus bot!" ) );
            }
        }
        

        
    }
    else
    {
        echo json_encode($vtoken);
    }

}
//   catch exception
catch(Exception $e) {
    $message =  'Message: ' .$e->getMessage();
    echo json_encode( array("status" => false,"info" => 'failed: ' . $db->getLastError(),"messages" => $message ) );
  }
          

?>