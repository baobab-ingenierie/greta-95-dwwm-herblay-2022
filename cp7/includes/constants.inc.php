<?php

/**
 * Environnements et constantes globaux pour gérer les différentes
 * infrastructures (TEST, PROD)
 */

// Si TEST
if ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1') {
    // Connexion via PDO
    define('HOST', 'localhost');
    define('PORT', 3306);
    define('BASE', 'herblay');
    define('USER', 'root');
    define('PASS', 'root');
    define('OPTS', array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ));
    // Gestion des erreurs (Apache)
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    // Connexion via PDO (Exemple OVH)
    define('HOST', 'foodtruck.mysql.db');
    define('PORT', 3306);
    define('BASE', 'foodtrucksql1');
    define('USER', 'foodtruc');
    define('PASS', 'z4R8M5eeL');
    define('OPTS', array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ));
}
