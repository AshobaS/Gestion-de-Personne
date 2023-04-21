drop database if exists db_test;

create database if not exists db_test;

use db_test ;



create table
    t_genre
    (
        id_genre int AUTO_INCREMENT PRIMARY KEY,
        glibelle VARCHAR(2) NOT NULL
    );

create table
    t_role
    (
        id_role int AUTO_INCREMENT PRIMARY KEY,
        rlibelle VARCHAR(3) NOT NULL
    );

create table
    t_personne 
    (
        id_personne bigint AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(50) NOT NULL,
        prenom VARCHAR(50) NOT NULL,
        mail VARCHAR(50) NOT NULL,
        age SMALLINT NOT NULL,
        identifiant varchar(50) UNIQUE NOT NULL,
        pass varchar(50) NOT NULL,
        idgenre INT NOT NULL,
        idrole INT NOT NULL,
        FOREIGN KEY (idgenre) REFERENCES t_genre(id_genre),
        FOREIGN KEY (idrole) REFERENCES t_role(id_role)
    );

create table
    t_connection
    (
        id_connection bigint AUTO_INCREMENT PRIMARY KEY,
        ip varchar(50) not NULL,
        pseudo varchar(50),
        connected int not NULL,
        essais int not null,
        derniere_co datetime not null
    );



insert into t_genre
values (1,"ho");
insert into t_genre
values (2,"fe");

insert into t_role
values (1,"usr");
insert into t_role
values (2,"adm");

insert into t_personne
values (1,"ZANCHETTA","Enzo","sardaneenzo@hotmail.fr","23","Ashoba","362e266aa5e615aaad10b0eb2537ec4e","1","2");

create view personne as 
select id_personne, nom, prenom, mail, age, identifiant, pass, idgenre, glibelle, idrole, rlibelle
from t_personne, t_genre, t_role
where idgenre = id_genre
and idrole = id_role;