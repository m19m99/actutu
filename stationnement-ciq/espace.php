<?php

session_start();
$id = $_SESSION['username'];

if (!isset($_SESSION['username'])) {

  header('location:seconnecter.php');
}

$nomqr = $id . '.' . 'png';

include('phpqrcode/qrlib.php'); //On inclut la librairie au projet
$lien='http://stationnementciq.alwaysdata.net/index.html/espace.php/pdf/' . $id . '.' . 'pdf'; // ajout du lien
QRcode::png($lien, $nomqr ); // On crée notre QR Code



$dsn = 'mysql:dbname=stationnementciq_bdd;dbport=3306;host=mysql-stationnementciq.alwaysdata.net';
$user = '244062';
$mdp = 'bddsciq1@';
$conn = new PDO($dsn, $user, $mdp);

$sql = "SELECT * FROM personne WHERE email = :id";
$sql1 = "SELECT * FROM autorisation JOIN vehicule ON autorisation.vehicule_id = vehicule.id JOIN personne ON personne.id = vehicule.personne_id  WHERE email = :id";
$sql2 = "SELECT * FROM vehicule JOIN personne ON personne.id = vehicule.personne_id WHERE email = :id";


$sth = $conn->prepare($sql);
$sth->bindParam(':id', $id);
$sth->execute();
$info = $sth->fetch();

$sth1 = $conn->prepare($sql1);
$sth1->bindParam(':id', $id);
$sth1->execute();
$info1 = $sth1->fetch();

$sth2 = $conn->prepare($sql2);
$sth2->bindParam(':id', $id);
$sth2->execute();
$info2 = $sth2->fetch();

// $nompdf = $info['nom'] . '.' . 'pdf';

if (empty($info1['valide'])) {

  $statut = 'non valide';
} else {

  $statut = 'valide';
}

require("fpdf183/fpdf.php");

// Création de la class PDF
class PDF extends FPDF
{
  // Header
  function Header()
  {
    $id = $_SESSION['username'];
    $nomqr = $id . '.' . 'png';

    $this->Image($nomqr,8,2,50,"PNG");
    // Saut de ligne 20 mm
    $this->Ln(50);

    // Titre gras (B) police Helbetica de 11
    $this->SetFont('Helvetica', 'B', 11);
    //couleur du texte blanche
    $this->SetTextColor(255, 255, 255);
    // fond de couleur bleu (valeurs en RGB)
    $this->setFillColor(7, 49, 111);
    // position du coin supérieur gauche par rapport à la marge gauche (mm)
    $this->SetX(10);
    // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok  
    $this->Cell(190, 8, 'Autorisation de stationnement', 0, 1, 'C', 1);
    // Saut de ligne 10 mm
    $this->Ln(80);
  }
  // Footer
  function Footer()
  {
    // Positionnement à 1,5 cm du bas
    $this->SetY(-15);
    // Police Arial italique 8
    $this->SetFont('Helvetica', 'I', 9);
    // Numéro de page, centré (C)
    $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
  }
}

// On active la classe une fois pour toutes les pages suivantes
// Format portrait (>P) ou paysage (>L), en mm (ou en points > pts), A4 (ou A5, etc.)
$pdf = new PDF('P', 'mm', 'A4');

// Nouvelle page A4 (incluant ici logo, titre et pied de page)
$pdf->AddPage();
// Polices par défaut : Helvetica taille 9
$pdf->SetFont('Helvetica', '', 9);
// Couleur par défaut : noir
$pdf->SetTextColor(0);

// Compteur de pages {nb}
$pdf->AliasNbPages();

// Sous-titre calées à gauche, texte gras (Bold), police de caractère 11
$pdf->SetFont('Helvetica', 'B', 11);
// couleur de fond de la cellule : gris clair
$pdf->setFillColor(1, 139, 208);
// Cellule avec les données du sous-titre sur 2 lignes, pas de bordure mais couleur de fond grise
$pdf->Cell(100, 6, strtoupper(utf8_decode('Date de validitÈ du ' . $info1['date_debut'] . ' AU ' . $info1['date_fin'])), 0, 1, 'L', 1);
$pdf->Cell(100, 6, strtoupper(utf8_decode($statut)), 0, 1, 'L', 1);
$pdf->Cell(100, 6, strtoupper(utf8_decode($info['prenom'] . ' ' . $info['nom'])), 0, 1, 'L', 1);
$pdf->Ln(10); // saut de ligne 10mm

// Fonction en-tête des tableaux en 3 colonnes de largeurs variables
function entete_table($position_entete)
{
  global $pdf;
  $pdf->SetDrawColor(183); // Couleur du fond RVB
  $pdf->SetFillColor(221); // Couleur des filets RVB
  $pdf->SetTextColor(0); // Couleur du texte noir
  $pdf->SetY($position_entete);
  // position de colonne 1 (10mm à gauche)  
  $pdf->SetX(30);
  $pdf->Cell(60, 8, 'Adresse', 1, 0, 'C', 1);  // 60 >largeur colonne, 8 >hauteur colonne
  // position de la colonne 2 (70 = 10+60)
  $pdf->SetX(90);
  $pdf->Cell(60, 8, 'Immatriculation', 1, 0, 'C', 1);
  // position de la colonne 3 (130 = 70+60)
  $pdf->SetX(150);
  $pdf->Cell(30, 8, 'Modele voiture', 1, 0, 'C', 1);

  $pdf->Ln(); // Retour à la ligne
}
// AFFICHAGE EN-TÊTE DU TABLEAU
// Position ordonnée de l'entête en valeur absolue par rapport au sommet de la page (70 mm)
$position_entete = 90;
// police des caractères
$pdf->SetFont('Helvetica', '', 9);
$pdf->SetTextColor(0);
// on affiche les en-têtes du tableau
entete_table($position_entete);

$position_detail = 98; // Position ordonnée = $position_entete+hauteur de la cellule d'en-tête (60+8)

// position abcisse de la colonne 1 (10mm du bord)
$pdf->SetY($position_detail);
$pdf->SetX(30);
$pdf->MultiCell(60, 8, utf8_decode($info['adresse']), 1, 'C');
// position abcisse de la colonne 2 (70 = 10 + 60)  
$pdf->SetY($position_detail);
$pdf->SetX(90);
$pdf->MultiCell(60, 8, utf8_decode($info2['immatriculation']), 1, 'C');
// position abcisse de la colonne 3 (130 = 70+ 60)
$pdf->SetY($position_detail);
$pdf->SetX(150);
$pdf->MultiCell(30, 8, $info2['modele'], 1, 'C');

// on incrémente la position ordonnée de la ligne suivante (+8mm = hauteur des cellules)  
$position_detail += 8;

function entete_table1($position_entete1)
{
  global $pdf;
  $pdf->SetDrawColor(183); // Couleur du fond RVB
  $pdf->SetFillColor(221); // Couleur des filets RVB
  $pdf->SetTextColor(0); // Couleur du texte noir
  $pdf->SetY($position_entete1);
  // position de colonne 1 (10mm à gauche)  
  $pdf->SetX(30);
  $pdf->Cell(60, 8, utf8_decode('Type de véhicule'), 1, 0, 'C', 1);  // 60 >largeur colonne, 8 >hauteur colonne
  // position de la colonne 2 (70 = 10+60)
  $pdf->SetX(90);
  $pdf->Cell(60, 8, utf8_decode('Couleur du véhicule'), 1, 0, 'C', 1);


  $pdf->Ln(); // Retour à la ligne
}

$position_entete1 = 110;
// police des caractères
$pdf->SetFont('Helvetica', '', 9);
$pdf->SetTextColor(0);
// on affiche les en-têtes du tableau
entete_table1($position_entete1);

$position_detail1 = 118;

$pdf->SetY($position_detail1);
$pdf->SetX(30);
$pdf->MultiCell(60, 8, utf8_decode($info2['type']), 1, 'C');
// position abcisse de la colonne 2 (70 = 10 + 60)  
$pdf->SetY($position_detail1);
$pdf->SetX(90);
$pdf->MultiCell(60, 8, utf8_decode($info2['couleur']), 1, 'C');

// on incrémente la position ordonnée de la ligne suivante (+8mm = hauteur des cellules)  
$position_detail1 += 8;

$pdf->Ln(10); // saut de ligne 10mm


//affichage écran
//$pdf->Output('I',$nompdf,'I');

$pdf->SetDisplayMode('fullpage');
$pdf->Output($id, 'I');
$pdf->Output('pdf/' . $id .'.'.'pdf', 'F');
