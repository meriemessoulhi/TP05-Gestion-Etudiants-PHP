<?php
/**
 * Paramètres de connexion à la base de données (FOURNI).
 * Valeurs par défaut de MySQL sous XAMPP / WAMP :
 *   hôte "localhost", port 3306, utilisateur "root", mot de passe vide.
 *
 * Si vous utilisez MAMP : DB_PASS = 'root' et DB_PORT = '8889'.
 */
const DB_HOST    = 'localhost';
const DB_PORT    = '3306';
const DB_NAME    = 'gestion_etudiants';
const DB_USER    = 'root';
const DB_PASS    = '';
const DB_CHARSET = 'utf8mb4';

/** Liste des filières proposées dans le formulaire */
const FILIERES = ['Informatique', 'Mathématiques', 'Physique', 'Chimie', 'Biologie'];
