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

        $answer = isset($_POST['answer']) ? $_POST['answer'] : ""; 
        $hash = isset($_POST['hash']) ? $_POST['hash'] : ""; 
        $id = CustomHelper::unhash($hash);
        $token = isset($_POST['token']) ? $_POST['token'] : ""; 
        $mode = isset($_POST['mode']) ? $_POST['mode'] : "update"; 
        $message = "Insert Sukses!!";
        $tgl = (new \DateTime())->format('Y-m-d H:i:s');   

        $request = $_POST;
        // var_dump($request);

        $arr_question = [];
        foreach($request as $key => $value)
        {
            // echo " key= ".$key;
            // echo " value= ".$value;
            $pos = strpos($key, 'question');
            if ($pos !== false) {
                $arr_question[] = $value;
                // echo "The string '$findme' was found in the string '$mystring'";
                //     echo " and exists at position $pos";
           } 

        }
        $question = implode(",",$arr_question);

  try
  {
    $vtoken = json_decode( verify_token($token) );
    // $vtoken = json_decode( verify_token($token. "1") ); //trial token error
    if($vtoken->status)
    {
        if($mode == "update" )
        {
            // $db->where("b.bot_owner", $vtoken->data->uid);
            $answer =  preg_replace( "/\r|\n/", "", nl2br( $answer) );

            $data = Array (
                "question" => $question,
                "response" => $answer,
                "created_at" => (new \DateTime())->format('Y-m-d H:i:s'),
                "created_by" => $vtoken->data->uid,
                "modified_at" => (new \DateTime())->format('Y-m-d H:i:s'),
                "modified_by" => $vtoken->data->uid,
            );
            $db->where ('id', $id);
            $hasil_eksekusi = $db->update ('bot_setting', $data);

            if($hasil_eksekusi)
            {
                echo json_encode( array("status" => true,"info" =>  'success update detail',"messages" => "sukses update detail bot" ) );
            }
            else
            {
                echo json_encode( array("status" => false,"info" => 'Error update detail',"messages" => "gagal update detail bot!" ) );
            }
     
        }
        else
        {
            // 
            // echo json_encode( array("status" => true,"info" =>  'success get answer',"messages" => "mode = ".$mode." , bot_id = ".$bot_id ) );
            // $db->where('id',$id);
            // $hasil_eksekusi = $db->delete('bot_setting');

            
            // if($hasil_eksekusi)
            // {
               
            //     echo json_encode( array("status" => true,"info" =>  'success delete topic',"messages" => "sukses menghapus topic" ) );
            // }
            // else
            // {
                echo json_encode( array("status" => false,"info" => 'Error delete topic',"messages" => "gagal menghapus topic!" ) );
            // }
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
        
  

function stripStr($str, $ini, $fin)
{
    while(($pos = mb_stripos($str, $ini)) !== false)
    {
        $aux = mb_substr($str, $pos + mb_strlen($ini));
        $str = mb_substr($str, 0, $pos).mb_substr($aux, mb_stripos($aux, $fin) + mb_strlen($fin));
    }

    return $str;
}

?>