/*
Script de création de la base de données liée
au back-office
*/

-- Création de la BDD/Schéma
DROP DATABASE IF EXISTS herblay
;

CREATE DATABASE herblay
	DEFAULT CHARACTER SET utf8
    COLLATE utf8_general_ci
;

USE herblay
;

-- Création de la table SUPPLIERS
CREATE TABLE suppliers(
	id_sup SMALLINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    address VARCHAR(100),
    zip CHAR(5),
    city VARCHAR(100),
    email VARCHAR(100) NOT NULL
) ENGINE = InnoDB;

-- Création de la table PRODUCTS
CREATE TABLE products(
	id_prod SMALLINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    qty INT UNSIGNED NOT NULL,
    price DECIMAL(6,2),
    id_sup SMALLINT REFERENCES suppliers(id_sup)
);





