<?php

$dsn = 'mysql:dbname=stationnementciq_bdd;dbport=3306;host=mysql-stationnementciq.alwaysdata.net';
$user = 'XXXXXXX';
$mdp = 'XXXXXXXX';
$conn = new PDO($dsn, $user, $mdp);

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
    $donnees = trim($donnees);
    $donnees = stripslashes($donnees);
    $donnees = htmlspecialchars($donnees);
    return $donnees;
}


/*while ($mdp != $confmdp) {

    echo ("Les mots de passes sont différents,");
    echo <<<html
                <html>
                    <body>
                        <a href="creeruncompte.php">réessayer</a>
                    </body>
                </html>
                html;
    exit;
}*/

$sqlin = "INSERT INTO personne (nom, prenom, email, adresse, qualite, telephone)
          VALUES(:nom, :prenom, :email, :adresse, :qualite, :phone)";

$sqlin1 = "INSERT INTO vehicule (personne_id, modele, marque, type, couleur, immatriculation)
           VALUES(:value, :modele, :marque, :type, :couleur, :numero)";

$sqlin2 = "INSERT INTO autorisation (vehicule_id, date_fin)
           VALUES(:value1, :date)";

$sql = "SELECT id FROM personne WHERE nom = :nom";

$sql2 = "SELECT id FROM vehicule WHERE immatriculation = :numero";

$table2 = array("$nom", "$prenom", "$email", "$phone", "$adresse", "$qualite", "$modele", "$marque", "$numero", "$type", "$couleur", "$date");

$length = count($table2);


for ($i = 0; $i < $length; $i++) {

    if (empty($table2[$i])) {
        echo "veuillez remplir tout les champs";
        $vide = 1;
        break;
    }
}


if (!isset($vide)) {
    $sth = $conn->prepare($sqlin);
    $sth->bindParam(':nom', $nom);
    $sth->bindParam(':prenom', $prenom);
    $sth->bindParam(':email', $email);
    $sth->bindParam(':adresse', $adresse);
    $sth->bindParam(':qualite', $qualite);
    $sth->bindParam(':phone', $phone);
    $sth->execute();


    if (isset($sth)) {

        $search = $conn->prepare($sql);
        $search->bindParam(':nom', $nom);
        $search->execute();
        $table = $search->fetch();
        $value = $table['id'];

        $sth1 = $conn->prepare($sqlin1);
        $sth1->bindParam(':value', $value);
        $sth1->bindParam(':modele', $modele);
        $sth1->bindParam(':marque', $marque);
        $sth1->bindParam(':type', $type);
        $sth1->bindParam(':couleur', $couleur);
        $sth1->bindParam(':numero', $numero);
        $sth1->execute();

        if (isset($sth1)) {

            $search1 = $conn->prepare($sql2);
            $search1->bindParam(':numero', $numero);
            $search1->execute();
            $table1 = $search1->fetch();
            $value1 = $table1['id'];

            $sth2 = $conn->prepare($sqlin2);
            $sth2->bindParam(':value1', $value1);
            $sth2->bindParam(':date', $date);
            $sth2->execute();

            if (isset($sth2)) {

                header("location:seconnecter.php");
            }
        }
    }
}
