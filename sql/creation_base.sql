-- =====================================================================
-- TP PDO - Gestion des étudiants
-- Script de création de la base de données (FOURNI)
--
-- Utilisation dans phpMyAdmin (http://localhost/phpmyadmin) :
--   1. Cliquer sur l'onglet « Importer » (ou « SQL »)
--   2. Choisir ce fichier (ou coller son contenu dans l'onglet SQL)
--   3. Cliquer sur « Importer » / « Exécuter »
--
-- Le script peut être relancé sans risque : il supprime puis recrée la base.
-- =====================================================================

-- 1) Création de la base de données (utf8mb4 pour gérer les accents)
DROP DATABASE IF EXISTS gestion_etudiants;
CREATE DATABASE gestion_etudiants
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

-- 2) Sélection de la base
USE gestion_etudiants;

-- 3) Création de la table des étudiants
CREATE TABLE etudiants (
    id               INT UNSIGNED  NOT NULL AUTO_INCREMENT,
    cne              VARCHAR(20)   NOT NULL,
    nom              VARCHAR(50)   NOT NULL,
    prenom           VARCHAR(50)   NOT NULL,
    email            VARCHAR(100)  NOT NULL,
    filiere          VARCHAR(50)   NOT NULL,
    date_naissance   DATE          NULL,
    date_inscription DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uk_etudiants_cne   (cne),
    UNIQUE KEY uk_etudiants_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4) Jeu de données de test
INSERT INTO etudiants (cne, nom, prenom, email, filiere, date_naissance) VALUES
    ('R130456789', 'Alaoui',     'Salma',   'salma.alaoui@etu.uca.ma',    'Informatique',  '2004-03-15'),
    ('D140987654', 'Bennani',    'Youssef', 'youssef.bennani@etu.uca.ma', 'Informatique',  '2003-11-02'),
    ('J120112233', 'El Idrissi', 'Hajar',   'hajar.elidrissi@etu.uca.ma', 'Mathématiques', '2004-07-21');
