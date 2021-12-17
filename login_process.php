<?php

	session_start();
	require_once ('config/MysqliDb.php');
	include("config/db.php");
	$db = new MysqliDb ('localhost', $dbuser, $dbpass, $dbname);

 
	if(isset($_POST['username']))
	{
		//$user_name = $_POST['user_name'];
		$u = trim($_POST['username']);
		$p = trim($_POST['password']);
		
		$pass = md5($p);
		
		//try
		//{	
			$sql = "SELECT * FROM users where user_name='$u' and user_pass='$pass' and user_status=1"; 
			//echo "$sql;";
			$data = $db->rawQuery($sql);
			$jml = count($data);
			//var_dump($data);
			if($jml>0)
			{
				$_SESSION['i']=$data[0]["user_id"]; //id
				$_SESSION['u']=$data[0]["user_name"]; //username
				$_SESSION['e']=$data[0]["user_email"]; //email
				$_SESSION['t']=$data[0]["user_tipe"]; //tipe
				$_SESSION['f']=$data[0]["user_foto"]; //tipe
			    $_SESSION['nama']=$data[0]["user_nama"]; //$data2[0][4]; //tipe
			    $_SESSION['sql']=$sql;
				echo "ok"; // log in
				//$_SESSION['user_session'] = $row['user_id'];
			}
			else{
				
				echo "username or password does not exist."; // wrong details 
			}
				
		//}
		//catch(PDOException $e){
		//	echo $e->getMessage();
		//}
	}

?>