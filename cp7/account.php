<?php
include_once 'test_session.php';
include_once 'includes/constants.inc.php';
include_once 'classes/model.class.php';
$table = new Model(HOST, PORT, BASE, USER, PASS, 'users');
$user = $table->getRow('id_user', $_SESSION['id_user']);
// var_dump($user);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion du compte</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>

<body class="container">
    <h1>Gérer mon compte</h1>
    <form action="account_save.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="fname">Prénom</label>
            <input type="text" name="fname" id="fname" class="form-control" minlength="1" maxlength="30" pattern="[A-Za-z\u00c0-\u00ff\- ']{1,30}" required value="<?php echo $user[0]['fname']; ?>">
        </div>
        <div class="form-group">
            <label for="email">Courriel</label>
            <input type="email" inputmode="email" name="email" id="email" class="form-control" minlength="1" maxlength="100" required value="<?php echo $user[0]['email']; ?>">
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" class="form-control" minlength="8" maxlength="20" pattern="((?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[_=]).{8,20})" title="8 à 20 caractères requis : A à Z, a à z, 0 à 9, _ et =" required>
        </div>
        <div class="form-group">
            <label for="picture">Photo</label>
            <input type="file" name="picture" id="picture" class="form-control" accept="image/*">
            <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
        </div>
        <?php
        // Affiche l'image si elle est stockée en BDD
        $html = '<div class="form-group"><img src="%s" style="height:15rem"></div>';
        if ($user[0]['picture'] !== '') {
            echo sprintf($html, $user[0]['picture']);
        }
        ?>
        <input type="submit" value="Mettre à jour mon compte" class="btn btn-info">
    </form>
</body>

</html>