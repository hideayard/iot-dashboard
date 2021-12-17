<?php

require_once('vendors/autoload.php');
use \Firebase\JWT\JWT;

class TokenLogin {
   private $secret;

   function __construct($secret) {
      $this->secret = $secret;
   }

   function create_token($uid, $token_duration = 24 /* Hours */) {
      $uid = intval($uid);
      if (!($uid > 0)) return;

      $now = time();

      $data = array();
      $data['uid'] = $uid;
      $data['iat'] = $now;
      $data['exp'] = $now + $token_duration * (60 * 60);

      return JWT::encode($data, $this->secret);
   }

   function create_login_token($uid,$uname,$unama,$uemail,$utipe,$ufoto, $token_duration = 24 /* Hours */) {
      $uid = intval($uid);
      if (!($uid > 0)) return;

      $now = time();

      $data = array();
      $data['uid'] = $uid;
      $data['uname'] = $uname;
      $data['unama'] = $unama;
      $data['uemail'] = $uemail;
      $data['utipe'] = $utipe;
      $data['ufoto'] = $ufoto;
      $data['iat'] = $now;
      $data['exp'] = $now + $token_duration * (60 * 60);

      return JWT::encode($data, $this->secret);
   }


   function validate_token($token) {
      try {
         $payload = JWT::decode($token, $this->secret, array('HS256'));
         if (!$payload) return FALSE;
         return json_decode(json_encode($payload));
      } catch (Exception $e) {
         // echo "token tidak valid";
         // die(var_dump($e));
         return FALSE;
      }
   }
}

?>