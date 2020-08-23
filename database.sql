CREATE DATABASE safepanda;
USE safepanda;
CREATE TABLE accounts(
   id_account int NOT NULL AUTO_INCREMENT,
   Title VARCHAR(50),
   Username VARCHAR(100),
   Passwd VARCHAR(100),
   Pin VARCHAR(15),
   Url VARCHAR(500),
   Icon VARCHAR(500),
   Notes VARCHAR(1000),
   Tag VARCHAR(15),
   Color VARCHAR(15),
   KeyC VARCHAR(100),
   PRIMARY KEY (id_account)
);
CREATE TABLE user(
   id_user int NOT NULL AUTO_INCREMENT,
   Username VARCHAR(100),
   Passwd VARCHAR(100),
   Question VARCHAR(100),
   Answer VARCHAR(100),
   ProfileImg VARCHAR(100),
   PRIMARY KEY (id_user)
);
