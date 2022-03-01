<?php
// Importe les constantes de connexion
include_once 'includes/constants.inc.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back-Office</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>

<body class="container">

    <div class="jumbotron">
        <h1 class="display-4">Back-Office</h1>
        <p class="lead">Ce projet fil rouge permet de mettre en avant les compétences acquises dans le module 7. Il permet d'accéder à la base de données <?php echo strtoupper(BASE); ?> en tant qu'utilisateur <?php echo strtoupper(USER); ?> sous la forme d'un CRUD.</p>
        <hr class="my-4">
        <p>Pour plus d'aide sur PHP, cliquer sur le bouton ci-dessous.</p>
        <a class="btn btn-primary btn-lg" href="https://www.php.net" role="button">Aide PHP</a>
    </div>

    <section id="tables">
        <?php
        $card = '<div class="card" style="width: 18rem;">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title"></h5>
          <p class="card-text"></p>
          <a href="#" class="btn btn-primary"></a>
        </div>
      </div>';

        $sql = 'SELECT t.table_name, t.table_type, t.table_rows, t.create_time, c.column_name
        FROM information_schema.tables t
        JOIN information_schema.columns c
        ON t.table_schema = c.table_schema
        AND t.table_name = c.table_name
        WHERE t.table_schema = :db
        AND c.column_key = :pk
        AND t.table_name NOT IN (SELECT table_name
        FROM information_schema.columns
        WHERE ordinal_position > 1
        AND column_key = :pk)';
        ?>
    </section>

</body>

</html>