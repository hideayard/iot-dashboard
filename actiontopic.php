<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

        $topic_name = isset($_POST['topic_name']) ? $_POST['topic_name'] : ""; 
        $hash = isset($_POST['hash']) ? $_POST['hash'] : ""; 
        $bot_id = CustomHelper::unhash($hash);
        $token = isset($_POST['token']) ? $_POST['token'] : ""; 
        $mode = isset($_POST['mode']) ? $_POST['mode'] : "insert"; 
        $id = isset($_POST['id']) ? $_POST['id'] : ""; 
        $message = "Insert Sukses!!";
        $tgl = (new \DateTime())->format('Y-m-d H:i:s');   

  try
  {
    $vtoken = json_decode( verify_token($token) );
    // $vtoken = json_decode( verify_token($token. "1") ); //trial token error
    if($vtoken->status)
    {
        if($mode == "insert" )
        {
            $db->join("bot b", "b.bot_id=bs.bot_id", "LEFT");
            $db->where("b.bot_owner", $vtoken->data->uid);

            // $db->where ('bot_id', $vtoken->data->uid);
            // $count = $db->getValue ("bot", "count(*)");
            // $results = $db->get ('bot_setting');
            $results = $db->get ("bot_setting bs", null, "b.bot_name, bs.topic");

            $count = count($results);

            if($count<=10)
            {
                $data = Array ("id" => null,
                "bot_id" => $bot_id,
                "topic" => $topic_name,
                "status" => 1,
                "created_at" => (new \DateTime())->format('Y-m-d H:i:s'),
                "created_by" => $vtoken->data->uid,
                "modified_at" => (new \DateTime())->format('Y-m-d H:i:s'),
                "modified_by" => $vtoken->data->uid,
                );

                $hasil = $db->insert ('bot_setting', $data);
            
                if($hasil)
                {
                    echo json_encode( array("status" => true,"info" =>  'success get answer',"messages" => "sukses menambahkan topic baru" ) );
                }
                else
                {
                    echo json_encode( array("status" => false,"info" => 'Error Create New Topic',"messages" => "gagal menambahkan topic baru!" ) );
                }
            }
            else
            {
                echo json_encode( array("status" => false,"info" => 'Error Create New Topic',"messages" => "Jumlah maksimal topic untuk versi gratis adalah 10" ) );

            }

        }
        else
        {
            // 
            // echo json_encode( array("status" => true,"info" =>  'success get answer',"messages" => "mode = ".$mode." , bot_id = ".$bot_id ) );
            $db->where('id',$id);
            $hasil_eksekusi = $db->delete('bot_setting');

            
            if($hasil_eksekusi)
            {
               
                echo json_encode( array("status" => true,"info" =>  'success delete topic',"messages" => "sukses menghapus topic" ) );
            }
            else
            {
                echo json_encode( array("status" => false,"info" => 'Error delete topic',"messages" => "gagal menghapus topic!" ) );
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