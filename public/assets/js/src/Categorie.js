Categorie = {};

/**
 * Objet JS qui va gérer les events pour les catégories
 */
Categorie.Launch = function (params) {

    Categorie.astuce = '';
    Categorie.currentIcon = $('#categorie-icon-fa').data('fa');
    Categorie.currentTxt = '';
    Categorie.currentOrder = '';

    /**
     * Event sur l'ajout d'une catégorie
     * @constructor
     */
    Categorie.EventAdd = function () {

        Categorie.astuce = $('#categorie-liste-fa').html();

        $('#categorie-change-icon').click(function () {
            Categorie.Ajax($(this).data('url'), '#categorie-liste-fa');
        });

        $('#titre-categorie').change(function () {
            Categorie.currentTxt = $(this).val();
            $('#new-cat-apercu-txt').html($(this).val());

            if(Categorie.currentTxt == '')
            {
                $('#titre-categorie').addClass('is-invalid');
            }
            else {
                $('#titre-categorie').removeClass('is-invalid');
            }
        });

        var options = {
            // or like a jQuery css object. Note that css object settings can't be removed
            hintClass: 'hint',
            maxLevels: 1,
            complete: function (currEl) {
                Categorie.currentOrder = $('#liste-categorie-apercu').sortableListsToArray();
            }
        }
        $('#liste-categorie-apercu').sortableLists(options);
        Categorie.currentOrder = $('#liste-categorie-apercu').sortableListsToArray();

        $('#submit-categorie').click(function () {

            if(Categorie.currentTxt == '')
            {
                $('#titre-categorie').addClass('is-invalid');
                return false;
            }
            else {
                $('#titre-categorie').removeClass('is-invalid');
            }

            data = {"name": Categorie.currentTxt, "icon" : Categorie.currentIcon, "order" : Categorie.currentOrder};

            $.ajax({
                method: "POST",
                url: $(this).data('url'),
                data: JSON.stringify(data)
            })
                .done(function( msg ) {

                    if(msg.response === true)
                    {
                        $('#msg-categorie-success').removeClass('text-hide');

                        setTimeout(function () {
                            $('#modal-add-categorie').modal('hide');
                        }, 5000);

                    }
                });
        });

    };

    /**
     * Event sur la liste des icone FA
     * @constructor
     */
    Categorie.EventIconFa = function () {

        // Détermine l'icone courante
        $('#content-icon-fa i.fas').each(function () {
            if ($(this).data('fa') == Categorie.currentIcon) {
                $(this).addClass('selected');
            }
        })

        // Au click sur une nouvelle icone
        $('#content-icon-fa i.fas').click(function () {
            $('#categorie-icon-fa').removeClass().addClass('fa ' + $(this).data('fa')).attr('data-fa', $(this).data('fa'));
            $('#new-cat-apercu').removeClass().addClass('fa ' + $(this).data('fa'));
            $('#content-icon-fa i.fas').each(function () {
                $(this).removeClass('selected');
            });

            $(this).addClass('selected');
            Categorie.currentIcon = $(this).data('fa');
        });

        // Au click sur le bouton masquer
        $('#content-icon-fa #btn-close-liste-fa').click(function () {
            Categorie.ShowTips();
        });
    };

    /**
     * Permet d'afficher les astuces
     * @constructor
     */
    Categorie.ShowTips = function () {
        $('#categorie-liste-fa').html(Categorie.astuce);
        $('#categorie-liste-fa #tips-icon').removeClass().addClass('fa ' + Categorie.currentIcon);
    }

    /**
     * Méthode Ajax qui va charger l'element présent dans l'URL
     */
    Categorie.Ajax = function (url, id_done, loader = true, method = 'GET') {
        if (loader) {
            $(id_done).loader();
        }

        $.ajax({
            method: method,
            url: url,
        })
            .done(function (html) {
                $(id_done).html(html);
            });
    }
}