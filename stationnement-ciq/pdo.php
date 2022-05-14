<?php

$dsn = 'mysql:dbname=stationnementciq_bdd;dbport=3306;host=mysql-stationnementciq.alwaysdata.net';
$user = 'XXXXXXX';
$mdp = 'XXXXXXX';
$conn = new PDO($dsn, $user, $mdp);

/*$date = htmlspecialchars($_POST['date_debut']);
$valide = htmlspecialchars($_POST['valide']);*/

$sql1 = "UPDATE autorisation set date_debut = :datedebut, valide = :valide";
$sql2 = "SELECT personne.id, nom from personne JOIN vehicule on personne.id = vehicule.personne_id JOIN autorisation ON autorisation.vehicule_id = vehicule.id WHERE valide = 0";
$sql3 = "SELECT COUNT(nom) as nb from personne JOIN vehicule on personne.id = vehicule.personne_id JOIN autorisation ON autorisation.vehicule_id = vehicule.id WHERE valide = 0";

$sth = $conn->prepare($sql3);
$sth->execute();
$info = $sth->fetch();

$bbb = $info['nb'];

$sth2 = $conn->prepare($sql2);
$sth2->execute();
$info2 = $sth2->fetchAll();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="admin.css">
    <script src="invisible.js" defer></script>
    <style>
        .cache1{
            display: none;
        }.cache1.visible{
            display: block;
        }
    </style>
</head>

<body>

    <?php

    for ($i = 0;$i<$bbb; $i++) {

    ?>

    <!--option caché -->
    <button class="show"><?php echo $info2[$i]['nom']  ?></button>
    <div class="cache1" id=<?php echo "a" . $info2[$i]['id']  ?>>

    <p><?php echo $info2[$i]['nom'] ?></p>
        <form action="" method="post">
            <input type="hidden" name="blabla" value="<?php echo $info2[$i]['id'] . "\n"; ?>">
            <label for="date1">date_debut</label>
            <input type="date" name="date_debut" id="date1">

            <input type="radio" id="oui" name="valide" value="1" checked>
            <label for="oui">oui</label>

            <input type="radio" id="non" name="valide" value="0" checked>
            <label for="non">non</label>

            <button type="submit">modifier</button>

        </form>
    </div>
    <!--________________ -->

    <?php
    }
    ?>

</body>

</html>