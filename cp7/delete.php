<?php
try {
    // Teste si table, pk et value sont dans l'URL
    $t = isset($_GET['t']) && !empty($_GET['t']) ? $_GET['t'] : '';
    $k = isset($_GET['k']) && !empty($_GET['k']) ? $_GET['k'] : '';
    $v = isset($_GET['v']) && !empty($_GET['v']) ? $_GET['v'] : '';

    // Si les 3 paramètres sont non vides
    if ($t !== '' && $k !== '' && $v !== '') {
        // Imports d'usage
        include_once 'includes/constants.inc.php';
        include_once 'classes/model.class.php';

        // Instancie la classe Model et supprime la ligne
        $table = new Model(HOST, PORT, BASE, USER, PASS, $t);
        if ($table->delete($k, $v)) {
            header('location:list.php?' . $_SERVER['QUERY_STRING']);
        } else {
            echo '<p class="alert alert-danger">La suppression de la ligne a échoué : <a href="index.php">Retour à l\'accueil</a></p>';
        }
    }
} catch (Exception $err) {
    echo '<p class="alert alert-danger">' . $err->getMessage() . ' : <a href="index.php">Retour à l\'accueil</a></p>';
}
