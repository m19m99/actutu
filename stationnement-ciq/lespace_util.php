<?php

$dsn = 'mysql:dbname=stationnementciq_bdd;dbport=3306;host=mysql-stationnementciq.alwaysdata.net';
$user = 'XXXXXXX';
$mdp = 'XXXXXXX';
$conn = new PDO($dsn, $user, $mdp);

session_start();

if (!isset($_SESSION['username'])) {

    header('location:seconnecter.php');
}

$mail = $_SESSION['username'];

$sql = "SELECT nom, prenom, adresse, valide, immatriculation, date_fin FROM personne join vehicule on vehicule.personne_id = personne.id join autorisation on autorisation.vehicule_id = vehicule.id  WHERE email = :mail";

$sth = $conn->prepare($sql);
$sth->bindParam(':mail', $mail);
$sth->execute();
$info = $sth->fetch();


$valide = $info['valide'];

if($valide == 1){
    $valide1 = 'VALIDE';
}else {
    $valide1 ='NON VALIDE';
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main4.css">
    <title>Document</title>
</head>

<body>

    <header>
        <p id="hello">bonjour <b><?php echo $info['prenom'] ?></b></p>
        <h1>Stationnement CIQ</h1>
        <button><a id="btn1" href="deconnexion.php">Se deconnecter</a></button>
    </header>

    <main>
        <h2>Votre espace personnel</h2>

        <section>
            <ul>
                <li>nom : <b><?php echo $info['nom'] ?></b></li>
                <li>prénom : <b><?php echo $info['prenom'] ?> </b></li>
                <li>adresse : <b><?php echo $info['adresse'] ?> </b></li>
            </ul>

            <span class="ligne"></span>

            <ul>
                <li>Votre autorisation est : <b><?php echo $valide1 ?></b></li>
                <li>immatriculation : <b><?php echo $info['immatriculation'] ?></b></li>
                <li>jusqu'au : <b><?php echo $info['date_fin'] ?></b></li>
                <li>Télecharger le document ici :</li>
                <div id="vert">
                    <li><button id="btn"><a id="btn2" href="espace.php">Télécharger le document</a></button></li>
                </div>
            </ul>


        </section>

    </main>

    <footer>
        <h3>© 2021 Simplon & Cerema</h3>
    </footer>

</body>

</html>