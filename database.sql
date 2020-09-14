CREATE USER 'panda'@'localhost' IDENTIFIED BY 'qss-s3E-IH9_Khz';
CREATE DATABASE safepanda;
USE safepanda;
CREATE TABLE accounts(
   id_account INT NOT NULL AUTO_INCREMENT,
   Title VARCHAR(50),
   Username VARCHAR(50),
   Passwd VARCHAR(50),
   Pin VARCHAR(50),
   KeyC VARCHAR(100),
   Url VARCHAR(500),
   Icon VARCHAR(500),
   Notes VARCHAR(1000),
   Tag VARCHAR(15),
   Color VARCHAR(15),
   CreationDate DATETIME,
   UpdateDate DATETIME,
   Favorites INT(1),
   Deleted INT(1),
   PRIMARY KEY (id_account)
);
CREATE TABLE contacts(
   id_contact INT NOT NULL AUTO_INCREMENT,
   Name VARCHAR(200),
   Surname VARCHAR(200),
   Number VARCHAR(20),
   Email VARCHAR(50),
   Address VARCHAR(200),
   Birthday DATETIME,
   PRIMARY KEY (id_contact)
);
CREATE TABLE notes(
   id_note INT NOT NULL AUTO_INCREMENT,
   Ttitle VARCHAR(200),
   Te_xt TEXT,
   PRIMARY KEY (id_note)
);
CREATE TABLE user(
   id_user INT NOT NULL AUTO_INCREMENT,
   Username VARCHAR(100),
   Passwd VARCHAR(100),
   Question VARCHAR(100),
   Answer VARCHAR(100),
   ProfileImg VARCHAR(100),
   Timeout INT(3),
   PRIMARY KEY (id_user)
);
GRANT ALL PRIVILEGES ON safepanda.* TO 'panda'@'localhost';
