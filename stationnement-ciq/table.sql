CREATE TABLE personne 
(

    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    adresse VARCHAR(255) NOT NULL,
    qualite VARCHAR(20) NOT NULL,
    email VARCHAR(50) NOT NULL,
    telephone VARCHAR(10) NOT NULL,
    mdp VARCHAR(70)
);


CREATE TABLE vehicule 
(

    id INT AUTO_INCREMENT PRIMARY  KEY,
    personne_id int NOT NULL,
    CONSTRAINT FK_personne FOREIGN KEY (personne_id)
    REFERENCES personne(id),
    modele VARCHAR(50) NOT NULL,
    marque VARCHAR(50) NOT NULL,
    type VARCHAR(50) NOT NULL,
    couleur VARCHAR(50) NOT NULL,
    immatriculation VARCHAR(15)NOT NULL UNIQUE
);


CREATE TABLE autorisation 
(

    vehicule_id int NOT NULL,
    CONSTRAINT FK_vehicule FOREIGN KEY (vehicule_id)
    REFERENCES vehicule(id),
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    valide BOOL NOT NULL
);






