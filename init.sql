CREATE TABLE Role(
   id_role INT NOT NULL AUTO_INCREMENT,
   role_name ENUM('student','tutor','administrator') NOT NULL,
   PRIMARY KEY(id_role)
);

INSERT INTO Role (role_name) VALUES
('student'),
('tutor'),
('administrator');

CREATE TABLE Profil(
   id_profil INT NOT NULL AUTO_INCREMENT,
   first_name VARCHAR(50),
   name VARCHAR(50),
   birth_date VARCHAR(50),
   creation_date VARCHAR(50),
   PRIMARY KEY(id_profil)
);


CREATE TABLE User_(
   id_user INT NOT NULL AUTO_INCREMENT,
   email VARCHAR(255),
   password VARCHAR(255),
   active TINYINT(1),
   id_tutor INT,
   id_role INT NOT NULL,
   id_profil INT NOT NULL,
   PRIMARY KEY(id_user),
   UNIQUE(id_profil),
   FOREIGN KEY(id_tutor) REFERENCES User_(id_user),
   FOREIGN KEY(id_role) REFERENCES Role(id_role),
   FOREIGN KEY(id_profil) REFERENCES Profil(id_profil)
);

CREATE TABLE Domain(
   id_domain INT NOT NULL AUTO_INCREMENT,
   label VARCHAR(100) NOT NULL,
   PRIMARY KEY(id_domain)
);


CREATE TABLE Adress(
   id_adress INT NOT NULL AUTO_INCREMENT,
   city VARCHAR(50),
   street_number VARCHAR(50),
   street_name VARCHAR(50),
   region VARCHAR(50),
   PRIMARY KEY(id_adress)
);


CREATE TABLE Entreprise(
   id_entreprise INT NOT NULL AUTO_INCREMENT,
   name VARCHAR(50),
   description VARCHAR(255),
   email VARCHAR(255),
   id_adress INT NOT NULL,
   PRIMARY KEY(id_entreprise),
   FOREIGN KEY(id_adress) REFERENCES Adress(id_adress)
);

CREATE TABLE Offer(
   id_offer INT NOT NULL AUTO_INCREMENT,
   title VARCHAR(50),
   description VARCHAR(255),
   duration enum('3 mois','6 mois','12 mois'),
   level VARCHAR(50),
   type VARCHAR(50),
   remuneration varchar(50),
   publication_date DATE,
   skill VARCHAR(255),
   id_entreprise INT NOT NULL,
   id_domain INT,
   PRIMARY KEY(id_offer),
   FOREIGN KEY(id_entreprise) REFERENCES Entreprise(id_entreprise),
   FOREIGN KEY(id_domain) REFERENCES Domain(id_domain)
);

CREATE TABLE apply(
   id_user INT,
   id_offer INT,
   cv VARCHAR(255),
   motivation_letter VARCHAR(255),
   message VARCHAR(255),
   PRIMARY KEY(id_user, id_offer),
   FOREIGN KEY(id_user) REFERENCES User_(id_user),
   FOREIGN KEY(id_offer) REFERENCES Offer(id_offer)
);


CREATE TABLE whishlist( 
   id_user INT,
   id_offer INT,
   PRIMARY KEY(id_user, id_offer),
   FOREIGN KEY(id_user) REFERENCES User_(id_user),
   FOREIGN KEY(id_offer) REFERENCES Offer(id_offer)
);


CREATE TABLE grade(
   id_user INT,
   id_entreprise INT,
   note INT,
   notice VARCHAR(255),
   PRIMARY KEY(id_user, id_entreprise),
   FOREIGN KEY(id_user) REFERENCES User_(id_user),
   FOREIGN KEY(id_entreprise) REFERENCES Entreprise(id_entreprise)
); 
