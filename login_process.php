<?php

	session_start();
	require_once ('config/MysqliDb.php');
	include("config/db.php");
	$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);

 
	if(isset($_POST['username']))
	{
		$u = trim($_POST['username']);
		$p = trim($_POST['password']);
		
		$pass = md5($p);
		

			$sql = "SELECT * FROM users where user_name='$u' and user_pass='$pass' and user_status=1"; 
			$data = $db->rawQuery($sql);
			$jml = count($data);

			if($jml>0)
			{
				$_SESSION['i']=$data[0]["user_id"]; //id
				$_SESSION['u']=$data[0]["user_name"]; //username
				$_SESSION['e']=$data[0]["user_email"]; //email
				$_SESSION['t']=$data[0]["user_tipe"]; //tipe
				$_SESSION['f']=$data[0]["user_foto"]; //foto
			    $_SESSION['nama']=$data[0]["user_nama"]; 
			    $_SESSION['sql']=$sql;
				echo "ok"; // log in
			}
			else{
				
				echo "username or password does not exist."; // wrong details 
			}

	}

?>