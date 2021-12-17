<?php

require_once("tokenlogin.php");

function verify_token($token,$secret = "B15m1ll4#")
{   //$secret = "B15m1ll4#";
    $status = false;
    $data = "";
    $messages = "Please Input Token!";    
    $otl = new TokenLogin($secret);
    if($token!="")
    {
        $payload = $otl->validate_token($token);

        try {
            if ($payload) {
                $status = true;
                $messages =  "Valid Token!";
                $data = $payload;
                // You are user #{$payload->uid}";
            } else {
                $messages =  "Invalid Token!";
            }
        } catch (Exception $e) {
            $messages =  "Caught exception: ".  $e->getMessage()."\n";
        }
    }
    return json_encode( array("status" => $status,"data" => $data,"messages" => $messages ) );

}