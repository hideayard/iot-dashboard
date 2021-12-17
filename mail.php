<?php
include "vendors/phpmailer/classes/class.phpmailer.php";
$mail = new PHPMailer;
$mail->IsSMTP();
$mail->SMTPSecure = 'ssl';
$mail->Host = "localhost"; //hostname masing-masing provider email
$mail->SMTPDebug = 2;
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->Username = "no-reply@rochat.id"; //user email
$mail->Password = "H45bun4ll4#"; //password email
$mail->SetFrom("no-reply@rochat.id","ROCHAT"); //set email pengirim
$mail->Subject = "Pemberitahuan Email dari Website"; //subyek email
$mail->AddAddress("gundulpacul1@gmail.com","Gundul Pacul1"); //tujuan email
$mail->MsgHTML("Pengiriman Email Dari Website");
if($mail->Send()) echo "Message has been sent";
else echo "Failed to sending message";
?>