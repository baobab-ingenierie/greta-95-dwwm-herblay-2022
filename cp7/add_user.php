<?php
// Imports pour connexion à la BDD
include_once 'includes/constants.inc.php';
include_once 'classes/database.class.php';
include_once 'classes/model.class.php';

// Assainit les données venant du formulaire
foreach ($_POST as $key => $val) {
    $_POST[$key] = htmlspecialchars($val);
}

// Crypte le mdp
$_POST['password'] = password_hash($_POST['password'] . strtolower($_POST['email']), PASSWORD_DEFAULT);

try {
    // Teste si l'adresse mail existe déjà
    $db = new Database(HOST, PORT, BASE, USER, PASS);
    $data = $db->getResult(
        'SELECT * FROM users WHERE email=?',
        array($_POST['email'])
    );
    if (empty($data)) {
        $table = new Model(HOST, PORT, BASE, USER, PASS, 'users');
        $status = $table->insert($_POST);
        if ($status) {
            // Inscription OK
            header('location:index.php');
            // Envoie un mail
        } else {
            // Inscription KO
            header('location:register.php?status=2');
        }
    } else {
        header('location:register.php?status=1');
    }
} catch (Exception $err) {
    echo '<p class="alert alert-danger">' . $err->getMessage() . ' : <a href="index.php">Retour à l\'accueil</a></p>';
}
