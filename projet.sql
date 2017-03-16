CREATE TABLE categorie(
    id int PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    description TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE utilisateur(
    id int PRIMARY KEY AUTO_INCREMENT,
    usager VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_general_ci UNIQUE NOT NULL,
    mdp VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    email VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    typeusager INT DEFAULT 0 NOT NULL,
    adresse VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	tokenemail VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci
) ENGINE=INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE produit(
    id INT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    description TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    prix FLOAT NOT NULL,
    fk_categorieid INT NOT NULL,
	FOREIGN KEY (fk_categorieid) REFERENCES categorie(id)
) ENGINE=INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE panier(
    id INT PRIMARY KEY AUTO_INCREMENT,
    qte INT NOT NULL,
    fk_produitid INT NOT NULL,
    fk_utilisateurid INT NOT NULL,
	FOREIGN KEY (fk_utilisateurid) REFERENCES utilisateur(id),
	FOREIGN KEY (fk_produitid) REFERENCES produit(id)
) ENGINE=INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE logachat(
    id INT PRIMARY KEY AUTO_INCREMENT,
    qte INT NOT NULL,
    fk_produitid INT NOT NULL,
    fk_utilisateurid INT NOT NULL,
    dateachat DATETIME NOT NULL,
	FOREIGN KEY (fk_utilisateurid) REFERENCES utilisateur(id),
	FOREIGN KEY (fk_produitid) REFERENCES produit(id)
) ENGINE=INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE image(
	id INT PRIMARY KEY AUTO_INCREMENT,
	nom VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	fk_produitid INT NOT NULL,
	FOREIGN KEY (fk_produitid) REFERENCES produit(id)
) ENGINE=INNODB CHARACTER SET utf8 COLLATE utf8_general_ci;