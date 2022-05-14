<?php        
session_start();  
//session_destroy sert à detruire la session  
$_SESSION['name'] = $userinfo;
session_unset();
session_destroy();  

setcookie(session_name(), '', strtotime('-1 day'));

echo" Vous êtes  déconnecté";    

echo <<<html
<html>
<body><a href="seconnecter.php">se reconnecter </a></body>
</html>
html;

?>  