/**
 * A la fin du chargement de la page, branche un écouteur d'événement
 * sur tous les boutons de suppression rouge !
 */

// A la fin du chargement de la page
document.addEventListener(
    'DOMContentLoaded',
    function () {
        let aBtns = document.querySelectorAll('.btn-danger');
        for (let i = 0; i < aBtns.length; i++) {
            // Au clic sur un bouton rouge
            aBtns[i].addEventListener(
                'click',
                function (evt) {
                    evt.preventDefault(); // interdit d'atteindre href
                    let iResp = confirm('Voulez-vous vraiment supprimer cette ligne ?');
                    if (iResp) {
                        window.location = evt.target.href;
                    }
                }
            );
        }
    }
);