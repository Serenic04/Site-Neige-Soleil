drop database if exists BDD_ppe; 
create database BDD_ppe; 
use BDD_ppe;


CREATE TABLE User (
    idUser INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL, 
    adresse VARCHAR(200) NOT NULL,
    tel VARCHAR(11) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    mdp VARCHAR(255) NOT NULL,
    role enum('locataire','propio','both','admin') NOT NULL
);

create table panierHab(
    idUser INT NOT NULL,
    FOREIGN KEY (idUser) REFERENCES User(idUser),

    idHabitation int not null,
    FOREIGN key (idHabitation) REFERENCES habitation(idHabitation),

    PRIMARY key (iduser,idHabitation)
);

create table panierEqp(
    qte int not null,
    idUser INT NOT NULL,
    FOREIGN KEY (idUser) REFERENCES User(idUser),

    idEquipement int not null,
    FOREIGN key (idEquipement) REFERENCES habitation(idEquipement),

    PRIMARY key (iduser,idEquipement)
);

CREATE TABLE Reservation(
    refR INT AUTO_INCREMENT PRIMARY KEY,
    dateR DATE NOT NULL,
    dateHeureDebut DATETIME NOT NULL,   
    dateHeureFin DATETIME NOT NULL,
    nbPersonne INT NOT NULL,
    idUser INT NOT NULL,
    FOREIGN KEY (idUser) REFERENCES User(idUser)
);

CREATE TABLE ContratLoc(
    refC INT AUTO_INCREMENT PRIMARY KEY,
    dureeC INT NOT NULL,
    dateDebutC DATE NOT NULL,
    dateFinC DATE NOT NULL,
    nbPersonneC INT NOT NULL,
    idUser INT NOT NULL,
    FOREIGN KEY (idUser) REFERENCES User(idUser),
    idHabitation INT NOT NULL,
    FOREIGN KEY (idHabitation) REFERENCES habitation(idHabitation)
);

CREATE TABLE TypeEquipement(
    idTypeEquipement INT AUTO_INCREMENT PRIMARY KEY,
    nomType VARCHAR(100) NOT NULL,
    description VARCHAR(500) NOT NULL
);

CREATE TABLE Equipement(
    idEquipement INT AUTO_INCREMENT PRIMARY KEY,
    nomEquipement VARCHAR(100) NOT NULL,
    prix DECIMAL(10,2) not null,
    lienImage varchar(100) not null,
    qteEquipement INT NOT NULL,
    idTypeEquipement INT NOT NULL,
    FOREIGN KEY (idTypeEquipement) REFERENCES typeEquipement(idTypeEquipement)
);

CREATE TABLE Habitation(
    idHabitation INT AUTO_INCREMENT PRIMARY KEY,
    adresse VARCHAR(200) NOT NULL,
    taille INT NOT NULL,
    lienImage varchar(50),
    idProprietaire INT NOT NULL,
    FOREIGN KEY (idProprietaire) REFERENCES User(idUser),
    codeR VARCHAR(100) NOT NULL,
    FOREIGN KEY (codeR) REFERENCES Region(codeR),
    etat enum('louable','occupe') default 'occupe'
);

CREATE TABLE Region(
    codeR VARCHAR(100) PRIMARY KEY,
    departement INT NOT NULL,
    villeR VARCHAR(50) NOT NULL,
    nomRegion varchar(50) not null
    
);

CREATE TABLE Station (
    codeS INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    nomS VARCHAR(50) NOT NULL,
    etoiles INT NOT NULL,
    codeR VARCHAR(100)NOT NULL, 
    FOREIGN KEY (codeR) REFERENCES Region(codeR)
);

CREATE TABLE Activite(
    codeA INT AUTO_INCREMENT PRIMARY KEY,
    nomActivite VARCHAR(50) NOT NULL,
    tarifA DECIMAL(6,2) NOT NULL
);

CREATE TABLE ContratMandatLocatif(
    idContrat INT AUTO_INCREMENT PRIMARY KEY,
    prix DECIMAL(10,2) not null,
    etatContrat enum('Actif','Inactif','En attente') NOT NULL,
    dateSignature DATE,
    idUser INT NOT NULL,
    FOREIGN KEY (idUser) REFERENCES User(idUser),
    idHabitation INT NOT NULL,
    FOREIGN KEY (idHabitation) REFERENCES Habitation(idHabitation)
);


INSERT INTO Region (codeR, departement, villeR, nomRegion) VALUES
('R001', 75, 'Paris', 'Île-de-France'),
('R002', 69, 'Lyon', 'Auvergne-Rhône-Alpes'),
('R003', 13, 'Marseille', 'Provence-Alpes-Côte dAzur');

INSERT INTO Habitation (adresse, taille, lienImage, idProprietaire, codeR, etat) VALUES
('10 rue de Paris', 120, 'chalet1.png', 1, 'R001','louable'),
('25 avenue Lyon', 90, 'chalet2.png',2, 'R002','occupe'),
('50 boulevard Marseille', 150, 'chalet3.png',3, 'R003','louable'),
('5 rue de la Montagne', 80, 'chalet4.png',1, 'R002','louable'),
('18 chemin des Sapins', 110, 'chalet5.png',2, 'R003','louable'),
('32 allée des Neiges', 95, 'chalet6.png',3, 'R001','louable'),
('8 place du Soleil', 130, 'chalet7.png',1, 'R002','occupe'),
('45 route des Alpes', 140, 'chalet8.png',2, 'R003','louable');

INSERT INTO Station (nomS, etoiles, codeR) VALUES
('Station D', 4, 'R001'),
('Station E', 5, 'R002'),
('Station A', 3, 'R001'),
('Station B', 4, 'R002'),
('Station C', 5, 'R003');


INSERT INTO TypeEquipement (nomType, description) VALUES
('Randonnée', 'Equipement de randonnée'),
('Ski', 'Equipement de ski');


INSERT INTO Equipement (nomEquipement, prix, lienImage, qteEquipement, idTypeEquipement) VALUES
('chaussures', 10.50, 'eqpt1.png', 2, 1), 
('Gant', 7.70, 'eqpt2.png', 5, 2),
('Bâtons de ski', 16, 'eqpt3.png', 10, 2),
('Casque de ski', 20, 'eqpt4.png', 8, 2),
('Raquettes de neige', 13.30, 'eqpt5.png', 6, 1),
('Sac à dos de randonnée', 35, 'eqpt6.png', 4, 1),
('Lunettes de ski', 23, 'eqpt7.png', 12, 2);


INSERT INTO Activite (nomActivite, tarifA) VALUES
('Ski', 50.00),
('Randonnée', 20.00);


INSERT INTO ContratMandatLocatif (etatContrat, prix, dateSignature, iduser, idHabitation) VALUES
('Actif', 200, '2024-01-01', 1, 1),
('Inactif', 300, '2023-05-15', 2, 2),
('En attente', 550, '2024-02-20', 3, 3),
('Actif', 730, '2024-03-01', 1, 4),
('Inactif', 1200, '2023-07-10', 2, 5),
('En attente', 435, '2024-02-25', 3, 6),
('Actif', 600, '2024-01-15', 1, 7),
('Actif', 999, '2024-02-05', 2, 8);


INSERT INTO user (nom, prenom, adresse, tel, email, role) VALUES
('Dupont', 'Jean', '12 rue des Lilas, Paris', '0612345678', 'jean.dupont@gmail.com', 'both'),
('Martin', 'Sophie', '34 avenue des Champs, Lyon', '0623456789', 'sophie.martin@gmail.com','both'),
('Lemoine', 'Paul', '56 boulevard Haussmann, Marseille', '0634567890', 'paul.lemoine@gmail.com','both');


INSERT INTO User (nom, prenom, email, mdp, role) 
VALUES ('abc', 'efg', 'a@gmail.com', '123', 'admin');