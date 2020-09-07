CREATE USER 'panda'@'localhost' IDENTIFIED BY 'qss-s3E-IH9_Khz';
CREATE DATABASE safepanda;
USE safepanda;
CREATE TABLE accounts(
   id_account int NOT NULL AUTO_INCREMENT,
   Title VARCHAR(50),
   Username VARCHAR(50),
   Passwd VARCHAR(50),
   Pin VARCHAR(50),
   Url VARCHAR(500),
   Icon VARCHAR(500),
   Notes VARCHAR(1000),
   Tag VARCHAR(15),
   Color VARCHAR(15),
   KeyC VARCHAR(100),
   CreationDate DATETIME,
   UpdateDate DATETIME,
   Favorites INT(1),
   Deleted INT(1),
   PRIMARY KEY (id_account)
);
CREATE TABLE user(
   id_user int NOT NULL AUTO_INCREMENT,
   Username VARCHAR(100),
   Passwd VARCHAR(100),
   Question VARCHAR(100),
   Answer VARCHAR(100),
   ProfileImg VARCHAR(100),
   Timeout INT(3),
   PRIMARY KEY (id_user)
);
GRANT ALL PRIVILEGES ON safepanda.* TO 'panda'@'localhost';
