<?php
 session_start(); 

 session_unset(); 
 session_destroy();

 setcookie(session_name(), '', strtotime('-1 day'));

//  echo ("<a href='seconnecter.php'>Se reconnecter</a>");
 header("location:seconnecter.php");
