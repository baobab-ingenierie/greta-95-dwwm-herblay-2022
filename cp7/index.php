<?php

// Redirige vers la bonne page selon qu'on est authentifié ou non
session_start();
var_dump($_COOKIE);
var_dump($_SESSION);

// Teste si une session est active
if (isset($_SESSION['is_auth']) && !empty($_SESSION['is_auth'])) {
    if ($_SESSION['is_auth']) {
        // Back-office
        header('location:bo.php');
    } else {
        // Accueil
        header('location:menu.php');
    }
} else {
    // Accueil
    header('location:menu.php');
}
