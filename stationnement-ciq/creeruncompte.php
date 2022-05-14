<?php

session_start();

try {
    $dsn = 'mysql:dbname=stationnementciq_bdd;dbport=3306;host=mysql-stationnementciq.alwaysdata.net';
    $user = 'XXXXXXX';
    $mdp = 'XXXXXXX';
    $conn = new PDO($dsn, $user, $mdp);
} catch (Exception $e) {

    echo 'erreur de connexion à la base de données ',  $e->getMessage(), "\n";
}


//personne
$nom = valid_donnees($_POST["nom"]);
$prenom = valid_donnees($_POST["prenom"]);
$phone = valid_donnees($_POST["phone"]);
$email = valid_donnees($_POST["email"]);
$adresse = valid_donnees($_POST["adresse"]);
$qualite = valid_donnees($_POST["qualite"]);
///////////////

//vehicule
$modele = valid_donnees($_POST["modele"]);
$marque = valid_donnees($_POST["marque"]);
$numero = valid_donnees($_POST["numero"]);
$type = valid_donnees($_POST["type"]);
$couleur = valid_donnees($_POST["couleur"]);
/////////////

//autorisation
$date = $_POST["date"];
////////////


function valid_donnees($donnees)
{
    $donnees = trim($donnees); //supprime les espaces à la fin et au début 
    $donnees = stripslashes($donnees); // supprime les slash
    $donnees = htmlspecialchars($donnees); // remplace les guillemets, <,> 
    return $donnees;
}

//insertion dans la table personne
$sqlin = "INSERT INTO personne (nom, prenom, email, adresse, qualite, telephone)
          VALUES(:nom, :prenom, :email, :adresse, :qualite, :phone)";

//insertion dans la table vehicule
$sqlin1 = "INSERT INTO vehicule (personne_id, modele, marque, type, couleur, immatriculation)
           VALUES(:value, :modele, :marque, :type, :couleur, :numero)";

//insertion dans la table autorisation
$sqlin2 = "INSERT INTO autorisation (vehicule_id, date_fin)
           VALUES(:value1, :date)";

//récupération de l' id de la table personne
$sql = "SELECT id FROM personne WHERE email = :email";

//voir si il y a déjà un mail dans la BDD
$sql1 = "SELECT COUNT(email) as nb FROM personne WHERE email = :email";

//récupération de l' id de la table vehicule
$sql2 = "SELECT id FROM vehicule WHERE immatriculation = :numero";

$table2 = ['$nom', '$prenom', '$email', '$phone', '$adresse', '$qualite', '$modele', '$marque', '$numero', '$type', '$couleur', '$date'];

$length = count($table2);

if (isset($_POST['creer'])) {


    if (!empty($nom) and !empty($prenom) and !empty($email) and !empty($phone) and !empty($adresse) and !empty($qualite) and !empty($modele) and !empty($marque) and !empty($numero) and !empty($type) and !empty($couleur) and !empty($date)) {

        /*$sql1 = "SELECT COUNT(email) as nb FROM personne WHERE email = :email";
        $verif = $conn->prepare($sql1);
        $verif->bindValue(':email', $email);
        $verif->execute();
        $userinfo = $verif->fetchAll();
        $verif1 = $userinfo['nb'];

        if ($verif1 == 0) {*/


            /*$sqlin = "INSERT INTO personne (nom, prenom, email, adresse, qualite, telephone)
                VALUES(:nom, :prenom, :email, :adresse, :qualite, :phone)";

                insertion dans la table personne*/

            $sth = $conn->prepare($sqlin);
            $sth->bindParam(':nom', $nom);
            $sth->bindParam(':prenom', $prenom);
            $sth->bindParam(':email', $email);
            $sth->bindParam(':adresse', $adresse);
            $sth->bindParam(':qualite', $qualite);
            $sth->bindParam(':phone', $phone);
            $sth->execute();


            //$sql = "SELECT id FROM personne WHERE email = :email";
            //récupération de l'id de personne avec l'adresse mail pour insertion dans la table vehicule
            //Autre solution LastInsertedId

            $search = $conn->prepare($sql);
            $search->bindParam(':email', $email);
            $search->execute();
            $table = $search->fetch();
            $value = $table['id'];


            /*$sqlin1 = "INSERT INTO vehicule (personne_id, modele, marque, type, couleur, immatriculation)
                VALUES(:value, :modele, :marque, :type, :couleur, :numero)";
                insertion dans la table vehicule*/

            $sth1 = $conn->prepare($sqlin1);
            $sth1->bindParam(':value', $value);
            $sth1->bindParam(':modele', $modele);
            $sth1->bindParam(':marque', $marque);
            $sth1->bindParam(':type', $type);
            $sth1->bindParam(':couleur', $couleur);
            $sth1->bindParam(':numero', $numero);
            $sth1->execute();


            /*$sql2 = "SELECT id FROM vehicule WHERE immatriculation = :numero";
                récupération de l'id de vehicule pour insertion dans la table autorisation */



            $search1 = $conn->prepare($sql2);
            $search1->bindParam(':numero', $numero);
            $search1->execute();
            $table1 = $search1->fetch();
            $value1 = $table1['id'];

            /* $sqlin2 = "INSERT INTO autorisation (vehicule_id, date_fin)
                VALUES(:value1, :date)";
                
                isertion dans la table autorisation*/

            $sth2 = $conn->prepare($sqlin2);
            $sth2->bindParam(':value1', $value1);
            $sth2->bindParam(':date', $date);
            $sth2->execute();

            if (isset($sth2)) {

                header("location:mdp.php");
                $stat = "valide";
                $_SESSION['email'] = $email;

            }
        /*} else {
            $erreur = 'Un compte existe déjà avec cette adresse email';
        }*/
    } else {
        $erreur = 'Veuillez remplir tout les champs';
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Creer un compte</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <script src="script.js" defer></script>
</head>

<body onload="SetDate();">

    <header>
        <h1>Stationnement CIQ</h1>
    </header>

    <section id="contact">

        <h2>Formulaire d'inscription</h2>
        <p><?php echo "$erreur"; ?></p>

        <div id="contact1">

            <form action="" method="post">

                <div class="a2">

                    <div class="a3">


                        <div class="a7">
                            <label for="nom">Votre nom :</label><br>
                            <input id="nom" name="nom" type="text" onkeypress="return verif1(event)" placeholder="Votre nom" required>
                        </div>

                        <div class="a7">
                            <label for="prenom">Votre prénom :</label><br>
                            <input id="prenom" name="prenom" type="text" onkeypress="return verif1(event)" ; placeholder="Votre prenom" required>
                        </div>



                    </div>


                    <div class="a3">

                        <div class="a7">

                            <label for="qualité">Qualité :</label><br>
                            <select name="qualite" id="qualite" required>
                                <option value="propriétaire">propriétaire</option>
                                <option value="locataire">locataire</option>
                                <option value="professionnel">professionnel</option>
                                <option value="visiteur">visiteur</option>
                            </select>
                        </div>
                    </div>


                    <div class="a7">

                        <label for="phone">numéro de téléphone :</label><br>

                        <input type="tel" id="phone" name="phone" pattern="[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}" required placeholder="06 XX XX XX XX">

                    </div>

                </div>

                <div class="a7">
                    <label for="email">Email :</label><br>
                    <input id="email" name="email" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="Votre email" required>

                </div>

                <div class="a3">

                    <div class="a7">
                        <label for="adresse">N° et nom de voie et code postal:</label><br>
                        <input id="adresse" name="adresse" onkeypress="return verif(event)" pattern="[0-9]+ {a-z}+ {A-Z}" title="XX nom de la rue XXXXX" type="text" placeholder="Votre adresse" required>
                    </div>


                </div>


                <div class="a3">

                    <div class="a7">
                        <label for="marque">Marque du véhicule :</label><br>
                        <input id="marque" name="marque" onkeypress="return verif1(event)" ; type="text" placeholder="Marque" required>
                    </div>

                    <div class="a7">
                        <label for="modele">Modèle du véhicule :</label><br>
                        <input id="modele" name="modele" type="text" onkeypress="return verif(event)" ; placeholder="Modele" required>
                    </div>


                </div>

                <div class="a3">

                    <div class="a7">

                        <div>
                            <label for="type">type du véhicule :</label><br>
                            <input id="type" name="type" onkeypress="return verif1(event)" ; type="text" placeholder="type" required>
                        </div>
                    </div>

                    <div class="a7">
                        <label for="couleur">couleur du véhicule :</label><br>
                        <input id="couleur" name="couleur" onkeypress="return verif1(event)" ; type="text" placeholder="couleur" required>
                    </div>

                </div>
        </div>

        <div class="a3">

            <div>
                <label for="date">Date de validité :</label><br>
                <input type="date" id="date" name="date" required>
            </div>

            <div>
                <label for="numero">Immatriculation :</label><br>
                <input id="numero" name="numero" onkeypress="return verif(event)" ; type="text" placeholder="AA-123-BB" required>
            </div>
        </div>

        </div>

        <div id="a5">
            <input id="btn" type="submit" name="creer" value="Soumettre le formulaire" />
        </div>


        </form>

        </div>


        <a href="seconnecter.php">Se connecter</a>

    </section>

    <footer>

        <h3>© 2021 Simplon & Cerema</h3>

    </footer>

</body>

</html>