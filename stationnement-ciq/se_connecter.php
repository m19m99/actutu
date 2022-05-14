<?php

$dsn = 'mysql:dbname=stationnementciq_bdd;dbport=3306;host=mysql-stationnementciq.alwaysdata.net';
$user = '244062';
$mdp = 'bddsciq1@';
$conn = new PDO($dsn, $user, $mdp);

session_start();

$nom = valid_donnees($_POST["nom"]);
$prenom = valid_donnees($_POST["prenom"]);
$email = valid_donnees($_POST["email"]);
$mdp = valid_donnees($_POST["mdp"]);

$sql = "SELECT * FROM personne WHERE nom = :nom and prenom = :prenom";

function valid_donnees($donnees)
{
   $donnees = trim($donnees);
   $donnees = stripslashes($donnees);
   $donnees = htmlspecialchars($donnees);
   return $donnees;
}


if (isset($_POST[''])) {

   if (!empty($nom) and !empty($prenom) and !empty($email) and !empty($mdp)) {

      $requser = $conn->prepare($sql);
      $requser->bindParam(':nom', $nom);
      $requser->bindParam(':prenom', $prenom);
      $requser->execute();

      $userinfo = $requser->fetch();
      $tablecount = count($userinfo);

      /*echo $tablecount;
      print_r($userinfo);*/

      if (isset($userinfo)) {

         $hash = $userinfo["mdp"];
         if (!password_verify($mdp, $hash)) {

            $erreur = 'Mauvais mail ou mot de passe !';
            echo ($erreur);
            echo <<<html
                              <html>
                                 <body>
                                       <a href="seconnecter.php">Retour à la page de connexion</a>
                                 </body>
                              </html>
                              html;
         } else {

            $_SESSION['username'] = $userinfo['nom'];
            echo "Félicitations vous êtes connecté(e)";
            exit();
         }
      } else {
         $erreur = 'veuillez inserer un mot de passe ou un nom d\'utilisateur valide !!!';
         echo ($erreur);
      }
   } else {
      echo ("Veuillez remplir tout les champs !");
   }
}
