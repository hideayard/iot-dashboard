<?php
 $dateTime = new DateTime('now', new DateTimeZone('Asia/Jakarta')); 
echo $dateTime->format("H:i A");
?>