<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back-Office : Liste</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>

<body class="container">
    <?php
    // Teste si nom table passé dans l'URL
    if (isset($_GET['t']) && !empty($_GET['t'])) {
        $table = $_GET['t'];
    } else {
        $table = '';
    }

    // Teste si nom pk passé dans l'URL
    if (isset($_GET['k']) && !empty($_GET['k'])) {
        $primary = $_GET['k'];
    } else {
        $primary = '';
    }

    // Teste si page en cours dans l'URL
    if (isset($_GET['p']) && !empty($_GET['p'])) {
        $page = (int) $_GET['p'];
    } else {
        $page = 0;
    }

    // Teste si nb lignes par page dans l'URL
    if (isset($_GET['n']) && !empty($_GET['n'])) {
        $nb = (int) $_GET['n'];
    } else {
        $nb = 10;
    }

    // Si table et pk vides alors on arrête
    if ($table === '' || $primary === '') {
        echo '<p class="alert alert-warning">Aucune table à exploiter : <a href="index.php">Retour à l\'accueil</a></p>';
        exit();
    } else {
        echo '<h1>Données de la table <strong>' . $table . '</strong></h1>';

        echo '<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
          <li class="breadcrumb-item active" aria-current="page">Liste</li>
        </ol>
        </nav>';
    }

    try {
        // 1. Includes
        include_once 'includes/constants.inc.php';
        include_once 'classes/database.class.php';

        // 2. Connexion à la BDD
        $cnx = new Database(HOST, PORT, BASE, USER, PASS);

        // 3. Requête SQL pour lister tous les clients
        $sql = 'SELECT * FROM ' . $table . ' LIMIT ' . $page . ',' . $nb;
        $cols = $cnx->getColumnsName($sql);
        $data = $cnx->getResult($sql);

        // 4. Affiche le résultat de la requête sous la forme d'un tableau HTML
        $html = '<table class="table table-dark table-striped">';

        // En-tête du tableau
        $html .= '<thead><tr>';
        foreach ($cols as $col) {
            $html .= '<th>' . $col . '</th>';
        }
        $html .= '</tr></thead>';

        // Données
        $html .= '<tbody>';
        foreach ($data as $row) {
            $html .= '<tr>';
            foreach ($row as $val) {
                $html .= '<td>' . $val . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';

        // Affiche le tableau HTML 
        echo $html;

        // 5. Pagination
        // Nb total de lignes 
        $sql2 = 'SELECT COUNT(*) AS total FROM ' . $table;
        $data2 = $cnx->getResult($sql2);
        $total = (int) $data2[0]['total'];
        $pages = ceil($total / $nb);

        // Liens vers pages
        $html = '<nav><ul class="pagination pagination-sm d-flex flex-wrap">';
        for ($i = 0; $i < $pages; $i++) {
            $link = $_SERVER['PHP_SELF'] . '?t=' . $table . '&k=' . $primary . '&p=' . ($i * $nb) . '&n=' . $nb;
            // Page active ou non ?
            if ($page === $i * $nb) {
                $html .= '<li class="page-item active"><span class="page-link">' . ($i + 1) . '</span></li>';
            } else {
                $html .= '<li class="page-item"><a class="page-link" href="' . $link . '">' . ($i + 1) . '</a></li>';
            }
        }
        $html .= '</ul></nav>';
        echo $html;
    } catch (Exception $err) {
        echo '<p class="alert alert-danger">' . $err->getMessage() . '<br><a href="index.php">Retour à l\'accueil</a></p>';
    }
    ?>
</body>

</html>