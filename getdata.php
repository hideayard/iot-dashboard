<?php
$page=isset($_GET['page']) ? $_GET['page'] : "home"; 

if (file_exists("".$page.".php")) 
              {
                  include("".$page.".php");
              }
              else 
              {
                  include("error.php");
              }
?>
