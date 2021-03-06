<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>

<body class="container">

    <!-- Modal -->
    <div class="modal fade" id="login" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="loginLabel" aria-hidden="true">
        <div class="modal-dialog">

            <?php
            // Si status est passé en paramètre
            if (isset($_GET['status']) && !empty($_GET['status'])) {
                // Selon la valeur de status
                switch ($_GET['status']) {
                    case '2':
                    case '1':
                        $msg = 'Courriel ou mot de passe incorrect.';
                        break;
                    default:
                }
                // Affiche message
                if (isset($msg)) {
                    echo '<p class="alert alert-warning">' . $msg . '.</p>';
                }
            }
            ?>

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginLabel">Connexion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="connect_user.php" method="post" id="formLogin">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="email">Courriel</label>
                            <input type="email" inputmode="email" name="email" id="email" class="form-control" minlength="1" maxlength="100" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control" minlength="8" maxlength="20" pattern="((?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[_=]).{8,20})" title="8 à 20 caractères requis : A à Z, a à z, 0 à 9, _ et =" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Se connecter" class="btn btn-info">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

    <script src="js/login.js"></script>
</body>

</html>