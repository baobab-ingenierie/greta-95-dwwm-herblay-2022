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
    email VARCHAR(100) NOT NULL,
    -- CONSTRAINT ck_suppliers_zip CHECK (zip BETWEEN '01000' AND '98800'),
    CONSTRAINT uq_suppliers_email UNIQUE(email)
) ENGINE = InnoDB;

-- Création de la table PRODUCTS
CREATE TABLE products(
	id_prod SMALLINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    qty INT UNSIGNED NOT NULL,
    price DECIMAL(6,2),
    id_sup SMALLINT,
    CONSTRAINT FOREIGN KEY fk_prod_sup (id_sup) REFERENCES suppliers(id_sup)
) ENGINE = InnoDB;

-- Création de la table MENUS
CREATE TABLE menus(
	id_menu SMALLINT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(4,2) UNSIGNED,
    picture MEDIUMBLOB
) ENGINE = InnoDB;

-- Création de la table CUSTOMERS
CREATE TABLE customers(
	id_cust SMALLINT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(30) NOT NULL,
    dob DATE
) ENGINE = InnoDB;

-- Création de la table COMPOSE
CREATE TABLE compose(
	id_prod SMALLINT,
    id_menu SMALLINT,
    CONSTRAINT fk_comp_prod FOREIGN KEY (id_prod) REFERENCES products(id_prod),
    CONSTRAINT fk_comp_menu FOREIGN KEY (id_menu) REFERENCES menus(id_menu),
    CONSTRAINT pk_compose PRIMARY KEY (id_prod, id_menu)
) ENGINE = InnoDB;

-- Création de la table BUY
CREATE TABLE buy(
	id_menu SMALLINT,
    id_cust SMALLINT,
    date DATE,
    qty INT UNSIGNED NOT NULL,
    CONSTRAINT fk_buy_menu FOREIGN KEY (id_menu) REFERENCES menus(id_menu),
    CONSTRAINT fk_buy_cust FOREIGN KEY (id_cust) REFERENCES customers(id_cust),
    CONSTRAINT pk_buy PRIMARY KEY (id_menu, id_cust)
);