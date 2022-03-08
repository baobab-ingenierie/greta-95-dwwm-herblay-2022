<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back-Office : Ajout/Modification</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>

<body class="container">
    <?php
    // Teste si table, pk et value sont dans l'URL
    $t = isset($_GET['t']) && !empty($_GET['t']) ? $_GET['t'] : '';
    $k = isset($_GET['k']) && !empty($_GET['k']) ? $_GET['k'] : '';
    $v = isset($_GET['v']) ? $_GET['v'] : '\'\'';

    // Si table et pk vides alors on arrête
    if ($t === '' || $k === '') {
        echo '<p class="alert alert-warning">Aucune ligne à modifier : <a href="index.php">Retour à l\'accueil</a></p>';
        exit();
    } else {
        // Affiche le titre de la page
        echo '<h1>Edition de la table <strong>' . $t . '</strong></h1>';

        // Affiche le fil d'Ariane (ou Breadcrumbs)
        echo '<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
        <li class="breadcrumb-item"><a href="list.php?t=' . $t . '&k=' . $k . '">Liste</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edition</li>
        </ol>
        </nav>';

        // Se connecte à la BDD puis exécute requête SQL
        include_once 'includes/constants.inc.php';
        include_once 'classes/database.class.php';
        $cnx = new Database(HOST, PORT, BASE, USER, PASS);
        $res = $cnx->getCnx()->prepare('SELECT * FROM ' . $t . ' WHERE ' . $k . '=?');
        $res->execute(array($v));

        // Récupère le nom et le type de chaque colonne
        for ($i = 0; $i < $res->columnCount(); $i++) {
            $row[$res->getColumnMeta($i)['name']] = '';
            $types[$res->getColumnMeta($i)['name']] = $res->getColumnMeta($i)['native_type'];
        }

        // Teste si INSERT ou UPDATE
        if ($res->rowCount() === 0) {
            $submit = 'Ajouter';
        } else {
            $row = $res->fetch();
            $submit = 'Mettre à jour';
        }

        // Affiche le formulaire
        $html = '<form action="save.php?' . $_SERVER['QUERY_STRING'] . '" method="post">';
        $input = '<div class="form-group">
        <label for="%s">%s</label>
        <input type="%s" class="form-control" id="%s" name="%s" value="%s">
        </div>'; // TODO : readonly ou disabled pour ID
        foreach ($row as $key => $val) {
            // Type de l'INPUT vs type de la COLONNE
            switch ($types[$key]) {
                case 'SHORT':
                    $type = 'number';
                    break;
                case 'DATE':
                    $type = 'date';
                    break;
                default:
                    $type = 'text';
            }
            $html .= sprintf($input, $key, strtoupper($key), $type, $key, $key, $val);
        }
        $html .= '<input type="submit" class="btn btn-info" value="' . $submit . '">';
        $html .= '</form>';
        echo $html;
    }
    ?>
</body>

</html>