/**
 * Lance le modal au chargement de la page
 */

$(document).ready(
    $('#register').modal()
);

/**
 * Teste si les mots de passe sont équivalents avant de soumettre le formulaire
 */

document.getElementById('formRegister').addEventListener(
    'submit',
    function (evt) {
        // Stoppe l'événement submit pour tester les mdp
        evt.preventDefault();

        // Teste les mdp
        if (document.getElementById('password').value === document.getElementById('password2').value) {
            evt.target.submit();
        } else {
            alert('Les mots de passe ne correspondent pas.')
        }
    }
);