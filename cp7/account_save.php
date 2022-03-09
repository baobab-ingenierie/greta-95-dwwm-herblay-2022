<?php
// Debug
// var_dump($_POST);
// var_dump($_FILES);

// Assainit les données saisie dans le formulaire
foreach ($_POST as $key => $val) {
    $_POST[$key] = htmlspecialchars($val);
}

// Teste si une photo a été choisie
$picture = null;
if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
    // Caractéristiques du fichier
    $file_name = $_FILES['picture']['name'];
    $file_ext = strtolower(substr($file_name, strpos($file_name, '.') + 1));
    $file_size = $_FILES['picture']['size'];
    $file_type = $_FILES['picture']['type'];
    $file_temp = $_FILES['picture']['tmp_name'];
    $allowed_ext = array('gif', 'jpg', 'jpeg', 'png', 'webp');

    // Vérifie si le fichier respecte les contraintes : taille et type
    $errors = array();

    // Test 1 : validité extension
    if (!in_array($file_ext, $allowed_ext)) {
        $errors[] = '<p class="alert alert-warning">Extension non autorisée : ' . implode(',', $allowed_ext) . '</p>';
    }

    // Test 2 : taille du fichier
    if ($file_size > (int) $_POST['MAX_FILE_SIZE']) {
        $errors[] = '<p class="alert alert-warning">Fichier trop lourd : ' . ((int) $_POST['MAX_FILE_SIZE'] / 1024 / 1024) . 'Mo maximum</p>';
    }

    // Traitement
    if (empty($errors)) {
        // Si pas d'erreurs
        // Process 1 : Conversion de l'image en base64
        $binary = file_get_contents($file_temp);
        $picture = 'data:' . $file_type . ';base64,' . base64_encode($binary);
        // Process 2 : Téléversement du fichier
        $status = move_uploaded_file($file_temp, 'uploads/' . $file_name);
        // traiter si $status TRUE ou FALSE
    } else {
        // Si erreurs
        foreach ($errors as $error) {
            echo $error;
        }
        echo '<a class="btn btn-info" href="index.php">Retour à l\'accueil</a>';
        exit();
    }
}

// Supprime MAX_FILE_SIZE de $_POST et ajoute picture + crypte le mdp
unset($_POST['MAX_FILE_SIZE']);
$_POST['picture'] = $picture;
$_POST['password'] = password_hash($_POST['password'] . strtolower($_POST['email']), PASSWORD_DEFAULT);
// var_dump($_POST);

// Met à jour le user en BDD
session_start();
include_once 'includes/constants.inc.php';
include_once 'classes/model.class.php';
$table = new Model(HOST, PORT, BASE, USER, PASS, 'users');
$status = $table->update($_POST, 'id_user', $_SESSION['id_user']);

// Redirige vers accueil si pas erreur 
if ($status) {
    header('location:index.php');
} else {
    echo '<p class="alert alert-danger">La mise à jour de l\'utilisateur a échoué : <a href="index.php">Retour à l\'accueil</a></p>';
}
