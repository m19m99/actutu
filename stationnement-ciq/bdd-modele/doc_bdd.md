## quick DBD

Personne
-
PersonneID PK int
Nom VARCHAR(255)
prenom VARCHAR(255)
adresse VARCHAR(255)
qualite VARCHAR(255)
email VARCHAR(255)
mdp VARCHAR(255)
telephone INT

Vehicule
-
VehiculeID PK int
PersonneID int FK >- Personne.PersonneID
Marque VARCHAR(255)
Modele VARCHAR(255)
Immatriculation VARCHAR(255)
type VARCHAR(255)
couleur VARCHAR(255)

Autorisation as ol
----
VehiculeID int FK >- Vehicule.VehiculeID
Date_debut DATE
Date_fin DATE
Valide CHAR

## Mocodo

personne: id, nom, prenom, adresse, qualite, email, mdp, telephone
attribuer, 0n vehicule, 11 autorisation
autorisation: date_debut, date_fin, valide

utilise, 0N personne, 11 vehicule
vehicule: id, marque, modele, immatriculation, type, couleur
:

## Mocodo 2 

vehicule: id, marque, modele, immatriculation, type, couleur
attribuer, 11 vehicule, 11 autorisation
autorisation: date_debut, date_fin, valide

utilise, 01 personne, 11 vehicule
personne: id, nom, prenom, adresse, qualite, email, mdp, telephone
:

## mysql

mysql -u 244062 -p'bddsciq1@' \
    -h mysql-stationnementciq.alwaysdata.net -P 3306 \
    -D stationnementciq_bdd
