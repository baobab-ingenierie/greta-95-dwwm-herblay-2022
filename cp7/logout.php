<?php

// Démarre ou restaure une session
session_start();

// Détruit toutes les variables de session
session_unset();

// Détruit la session en cours
session_destroy();

// Redirige vers l'accueil
header('location:index.php');
