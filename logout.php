<?php
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
	unset($_SESSION['i']);
	unset($_SESSION['u']);
	unset($_SESSION['e']);
	unset($_SESSION['t']);
	
	if(session_destroy())
	{
		// header("Location: login.php");
		// exit(); //hentikan eksekusi kode di login_proses.php
		echo "<script>window.location='login.php';</script>";
	}
?>