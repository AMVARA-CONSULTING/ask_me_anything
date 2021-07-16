create database linuga;

use linuga;

ALTER DATABASE linuga CHARACTER SET utf8 COLLATE utf8_general_ci;

CREATE TABLE IF NOT EXISTS usuaris (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255),
    pass VARCHAR(255),
    nom VARCHAR(255),
    idioma_natiu VARCHAR(255),
    idioma_aprendre VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)  ENGINE=INNODB;

insert into usuaris ( email, pass, nom, idioma_natiu, idioma_aprendre )
  values ("ralf@roeber.de", "foobar", "Ralf Roeber", "DE", "ES, EN, CA");


