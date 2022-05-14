<?php

session_start();

$dsn = 'mysql:dbname=stationnementciq_bdd;dbport=3306;host=mysql-stationnementciq.alwaysdata.net';
$user = '244062';
$mdp = 'bddsciq1@';
$conn = new PDO($dsn, $user, $mdp);

//récupération des données HTML
// $email = valid_donnees($_POST["email"]);
$mdp = valid_donnees($_POST["mdp"]);
$confmdp = valid_donnees($_POST["confmdp"]);

function valid_donnees($donnees)
{
    $donnees = trim($donnees);
    $donnees = stripslashes($donnees);
    $donnees = htmlspecialchars($donnees);
    return $donnees;
}

//demande d'une session qui sera indispensable pour créer son mdp
if (!isset($_SESSION['email'])) {

    header('location:index.html');
}

$mail  = $_SESSION['email'];

//requête SQL pour voir si le mail est effectivement dans la bdd
$sql1 = "SELECT email FROM personne WHERE email = :email";

//requête SQL création de MDP
$sql2 = "UPDATE personne SET mdp = :mdp WHERE email = :email";

//hashage du mdp
$password = $mdp;
$hash = password_hash($password, PASSWORD_DEFAULT);



if (isset($_POST['btn1'])) { //on lui dit que quand il appuie sur le btn "envoyer" on commence la suite 

    if (!empty($mdp) and (!empty($confmdp))) { //si les champs email et mdp ne sont pas vide alors on continue

        $requser = $conn->prepare($sql1); //on prepare la première requête 
        $requser->bindParam(':email', $mail);
        $requser->execute(); //on l'execute
        $userinfo = $requser->fetch(); //on le stock dans un tableau
        $table = count($userinfo); // on compte les éléments du tableau 

        if ($mdp = $confmdp) { // si il y a un élément dans le tableau et que les MDP concorde alors on continue

            $requser1 = $conn->prepare($sql2); //preparation de la requête 
            $requser1->bindParam(':mdp', $hash); // récupération du mdp hasher
            $requser1->bindParam(':email', $mail); //___________du l'adresse mail
            $requser1->execute(); //exécution de la requête 

            echo "Votre mot de passe à été creer avec succés !";
            header('location: seconnecter.php');
            session_unset();
            session_destroy();
        } else {
            echo 'L\' adresse email est invalide ou les mots de passe ne correspondent pas !';
        }
    } else {

        echo "Veuillez remplir tout les champs !";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main3.css">
    <title>Document</title>
</head>

<body>

    <header>
        <h1>Stationnement CIQ</h1>
    </header>

    <main>

        <section id="contact">

            <h2 id="second">Création de mot de passe</h2>

            <section id="contact2">
                <form action="" method="post">
                    <!-- <section>
                        <label for="email">Mail :</label><br>
                        <input type="email" name="email" id="email">
                    </section> -->

                    <section>
                        <label for="mdp">Mot de passe :</label><br>
                        <input type="password" name="mdp" id="mdp">
                    </section>

                    <section>
                        <label for="confmdp">confirmation de mot de passe :</label><br>
                        <input type="password" name="confmdp" id="confmdp">
                    </section>

                    <article id="btn2">
                        <button type="submit" name="btn1" id="seco">envoyer</button>
                    </article>

                </form>
            </section>



        </section>
    </main>

    <footer>
        <h3>© 2021 Simplon & Cerema</h3>
    </footer>




</body>

</html>