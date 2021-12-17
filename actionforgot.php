<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

require_once ("vendor/autoload.php");
require_once ("tokenlogin.php");
require_once ('config/MysqliDb.php');
include_once ("config/db.php");
$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);

{
    $user_email = trim($_POST['user_email']);
    $tgl = (new \DateTime())->format('Y-m-d H:i:s');

      $data = Array (
                        "user_email" => $user_email,
      );

      $hasil_eksekusi = false;

    if(isset($_POST['user_email']))
    {    

        $db->where ('user_id', $user_id);
        $hasil_eksekusi = $db->update ('users', $data);
        $message = "Delete Success !!";
        
        if ($hasil_eksekusi)
        {   
          echo json_encode( array("status" => true,"info" => $mode_status,"messages" => $message ) );
        }//$db->count . ' records were updated';
        else
        {   
          echo json_encode( array("status" => false,"info" => 'update failed: ' . $db->getLastError(),"messages" => $message ) );

        }

      }
      else
      {  
          if($mode_status!=0)
          {
            $data += array("user_id" => null);
            $data += array('user_created_at' => $tgl);
            if($db->insert ('users', $data))
            {
            echo json_encode( array("status" => true,"info" => $mode_status,"messages" => $message ) );
            }
            else
            {
            echo json_encode( array("status" => false,"info" => $db->getLastError(),"messages" => $message ) );
            }
          }
          else
          {
            $db->where ('user_name', $user);
            $db->where ('user_pass', $pass);
            $results = $db->get('users');
            if(count($results)>0)
            {

                $secret = "B15m1ll4#";
                $otl = new TokenLogin($secret);
                // var_dump($results);
                // $uid = $results[0]['user_id'];
                $_SESSION['i']=$results[0]["user_id"]; //id
				$_SESSION['u']=$results[0]["user_name"]; //username
				$_SESSION['e']=$results[0]["user_email"]; //email
				$_SESSION['t']=$results[0]["user_tipe"]; //tipe
				$_SESSION['f']=$results[0]["user_foto"]; //tipe
                $_SESSION['nama']=$results[0]["user_nama"];
                $data = array($results[0]["user_id"]
                             ,$results[0]["user_name"]
                             ,$results[0]["user_nama"]
                             ,$results[0]["user_email"]
                             ,$results[0]["user_tipe"]
                             ,$results[0]["user_foto"]);
                            //  $i=0;
                $token = $otl->create_login_token($data[0],$data[1],$data[2],$data[3],$data[4],$data[5]);
                $_SESSION['token']=$token; //id
                echo json_encode( array("status" => true,"info" => $token,"messages" => "Login Success!" ) );

            }
            else
            {
                echo json_encode( array("status" => false,"info" => $db->getLastError(),"messages" => "Username Or Password Not Found!" ) );
            }
          }
            
      }
  
  }//end else
?>