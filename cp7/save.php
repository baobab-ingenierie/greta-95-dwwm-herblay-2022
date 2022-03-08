<?php
try {
    // Teste si table, pk et value sont dans l'URL
    $t = isset($_GET['t']) && !empty($_GET['t']) ? $_GET['t'] : '';
    $k = isset($_GET['k']) && !empty($_GET['k']) ? $_GET['k'] : '';
    $v = isset($_GET['v']) ? $_GET['v'] : '';

    // Imports d'usage
    include_once 'includes/constants.inc.php';
    include_once 'classes/model.class.php';

    // Instanciation de la classe Model
    $table = new Model(HOST, PORT, BASE, USER, PASS, $t);

    if ($v === '') {
        // Insertion
        $table->insert($_POST);
    } else {
        // Mise à jour
        $table->update($_POST, $k, $v);
    }

    // Route vers la liste de départ
    header('location:list.php?' . $_SERVER['QUERY_STRING']);
} catch (Exception $err) {
    echo '<p class="alert alert-danger">' . $err->getMessage() . '</p> : <a href="index.php">Retour à l\'accueil</a>';
}
