<?php

try {
    $dsn = 'mysql:dbname=stationnementciq_bdd;dbport=3306;host=mysql-stationnementciq.alwaysdata.net';
    $user = '244062';
    $mdp = 'bddsciq1@';
    $conn = new PDO($dsn, $user, $mdp);
} catch (Exception $e) {

    echo 'erreur de connexion à la base de données ',  $e->getMessage(), "\n";
}

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


if (isset($_SESSION["username"])) {
    $erreur = "Vous êtes déja connecté(e) !";
}



if (isset($_POST['seco'])) {

    if (!empty($nom) and !empty($prenom) and !empty($email) and !empty($mdp)) {

        $requser = $conn->prepare($sql);
        $requser->bindParam(':nom', $nom);
        $requser->bindParam(':prenom', $prenom);
        $requser->execute();

        $userinfo = $requser->fetch();
        $tablecount = $requser->rowCount($userinfo);


        if ($tablecount == "1") {

            $hash = $userinfo["mdp"];

            if (password_verify($mdp, $hash)) {

                //$erreur = 'Mauvais mail ou mot de passe !';
                $_SESSION['username'] = $userinfo['email'];
                //$erreur = 'Connecter';
                header('location:lespace_util.php');
                //echo '<a href="deconnexion.php">Se déconnecter</a>';
                exit();
            } else {

                $erreur = "mot de passe incorrect";
            }
        } else {
            $erreur = 'veuillez inserer un mot de passe ou un nom d\'utilisateur valide !!!';
        }
    } else {
        $erreur = "Veuillez remplir tout les champs !";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Se connecter</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main3.css">

</head>

<body>


    <header>
        <h1>Stationnement CIQ</h1>
    </header>

    <main>
    <p id="erreur"><?php echo ($erreur); ?></p>

        <section id="contact">

            <h2>Se connecter</h2>

            <section id="contact2">
                <form action="" method="post">

                    <div>
                        <label for="nom">Votre nom :</label><br>
                        <input id="nom" name="nom" type="text" placeholder="Votre nom" required>
                    </div>

                    <div>
                        <label for="prenom">Votre prénom :</label><br>
                        <input id="prenom" name="prenom" type="text" placeholder="Votre prenom" required>
                    </div>

                    <div>
                        <label for="email">Votre email :</label><br>
                        <input id="email" name="email" type="mail" placeholder="Votre email" required>
                    </div>


                    <div>
                        <label for="mdp">Mot de passe :</label><br>
                        <input id="mdp" name="mdp" type="password" placeholder="mot de passe" required>
                    </div>

                    <div id="btn">
                        <input type="submit" id="seco" name="seco" value="Se connecter" />
                    </div>


                </form>
            </section>
            <p id="copy"><a href="creeruncompte.php">Creer un compte</a></p>

        </section>

    </main>

    <footer>
        <h3>© 2021 Simplon & Cerema</h3>
    </footer>

</body>

</html>