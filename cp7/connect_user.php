<?php

// Affiche le contenu du formulaire
// var_dump($_POST);

// Assainit les données saisies dans le formulaire
foreach ($_POST as $key => $val) {
    $_POST[$key] = htmlspecialchars($val);
}

try {
    // Imports
    include_once 'includes/constants.inc.php';
    include_once 'classes/database.class.php';

    // Teste si l'adresse mail est correcte
    $db = new Database(HOST, PORT, BASE, USER, PASS);
    $sql = 'SELECT * FROM users WHERE LOWER(email)=?';
    $params = array(strtolower($_POST['email']));
    $user = $db->getResult($sql, $params);
    if (empty($user)) {
        header('location:login.php?status=2');
    } else {
        // Teste si le mdp est correct
        if (password_verify($_POST['password'] . strtolower($_POST['email']), $user[0]['password'])) {
            // Valide l'authentification via une session
            session_start();
            $_SESSION['is_auth'] = true;
            $_SESSION['id_session'] = session_id();
            $_SESSION['id_user'] = (int) $user[0]['id_user'];
            $_SESSION['fname'] = $user[0]['fname'];
            $_SESSION['picture'] = $user[0]['picture'];
            // var_dump($_SESSION);
            header('location:index.php');
        } else {
            header('location:login.php?=status=1');
        }
    }
} catch (Exception $err) {
    echo '<p class="alert alert-danger">' . $err->getMessage() . ' : <a href="index.php">Retour à l\'accueil</a></p>';
}
