CREATE TABLE Role(
   id_role INT,
   role_name ENUM('student', 'entreprise', 'tutor') NOT NULL,
   PRIMARY KEY(id_role)
);


CREATE TABLE Profil(
   id_profil INT,
   first_name VARCHAR(50),
   name VARCHAR(50),
   birth_date VARCHAR(50),
   creation_date VARCHAR(50),
   PRIMARY KEY(id_profil)
);


CREATE TABLE User_(
   id_user INT,
   email VARCHAR(50),
   password VARCHAR(50),
   active BOOLEAN,
   id_tutor INT NOT NULL,
   id_role INT NOT NULL,
   id_profil INT NOT NULL,
   PRIMARY KEY(id_user),
   UNIQUE(id_profil),
   FOREIGN KEY(id_tutor) REFERENCES User_(id_user),
   FOREIGN KEY(id_role) REFERENCES Role(id_role),
   FOREIGN KEY(id_profil) REFERENCES Profil(id_profil)
);


CREATE TABLE offer(
   id_offer INT,
   title VARCHAR(50),
   description VARCHAR(50),
   duration VARCHAR(50),
   level VARCHAR(50),
   type VARCHAR(50),
   remuneration VARCHAR(50),
   publication_date VARCHAR(50),
   skill VARCHAR(50),
   PRIMARY KEY(id_offer)
);


CREATE TABLE Adress(
   id_adress INT,
   city VARCHAR(50),
   street_number VARCHAR(50),
   street_name VARCHAR(50),
   region VARCHAR(50),
   PRIMARY KEY(id_adress)
);


CREATE TABLE Entreprise(
   id_entreprise VARCHAR(50),
   name VARCHAR(50),
   description VARCHAR(50),
   email VARCHAR(50),
   id_offer INT NOT NULL,
   id_adress INT NOT NULL,
   PRIMARY KEY(id_entreprise),
   FOREIGN KEY(id_offer) REFERENCES offer(id_offer),
   FOREIGN KEY(id_adress) REFERENCES Adress(id_adress)
);


CREATE TABLE apply(
   id_user INT,
   id_offer INT,
   cv VARCHAR(50),
   motivation_letter VARCHAR(50),
   message VARCHAR(255),
   PRIMARY KEY(id_user, id_offer),
   FOREIGN KEY(id_user) REFERENCES User_(id_user),
   FOREIGN KEY(id_offer) REFERENCES offer(id_offer)
);


CREATE TABLE whishlist(
   id_user INT,
   id_offer INT,
   PRIMARY KEY(id_user, id_offer),
   FOREIGN KEY(id_user) REFERENCES User_(id_user),
   FOREIGN KEY(id_offer) REFERENCES offer(id_offer)
);


CREATE TABLE grade(
   id_user INT,
   id_entreprise VARCHAR(50),
   note INT,
   notice VARCHAR(255),
   PRIMARY KEY(id_user, id_entreprise),
   FOREIGN KEY(id_user) REFERENCES User_(id_user),
   FOREIGN KEY(id_entreprise) REFERENCES Entreprise(id_entreprise)
); 


-- Procédure 1 : postuler à une offre (transactionnel)
DELIMITER $$
CREATE PROCEDURE sp_apply(
    IN p_user_id INT,
    IN p_offer_id INT,
    IN p_cv VARCHAR(50),
    IN p_lm VARCHAR(50),
    IN p_msg VARCHAR(255)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;
        -- Vérifie que l'offre existe
        IF NOT EXISTS (SELECT 1 FROM offer WHERE id_offer = p_offer_id) THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Offre introuvable';
        END IF;

        INSERT INTO apply (id_user, id_offer, cv, motivation_letter, message)
        VALUES (p_user_id, p_offer_id, p_cv, p_lm, p_msg)
        ON DUPLICATE KEY UPDATE cv = p_cv, motivation_letter = p_lm, message = p_msg;

        -- Retire de la wishlist si présent
        DELETE FROM whishlist WHERE id_user = p_user_id AND id_offer = p_offer_id;
    COMMIT;
END$$
DELIMITER ;

-- Procédure 2 : noter une entreprise (upsert)
DELIMITER $$
CREATE PROCEDURE sp_grade_entreprise(
    IN p_user_id INT,
    IN p_entreprise_id VARCHAR(50),
    IN p_note INT,
    IN p_notice VARCHAR(255)
)
BEGIN
    IF p_note < 1 OR p_note > 5 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Note invalide (1-5)';
    END IF;

    INSERT INTO grade (id_user, id_entreprise, note, notice)
    VALUES (p_user_id, p_entreprise_id, p_note, p_notice)
    ON DUPLICATE KEY UPDATE note = p_note, notice = p_notice;
END$$
DELIMITER ;