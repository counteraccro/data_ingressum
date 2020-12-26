Categorie = {};

/**
 * Objet JS qui va gérer les events pour les catégories
 */
Categorie.Launch = function (params) {

    Categorie.astuce = '';
    Categorie.id = -1;
    Categorie.disabled = false;
    Categorie.currentIcon = $('#categorie-icon-fa').data('fa');
    Categorie.currentTxt = '';
    Categorie.currentOrder = '';
    Categorie.new_cat_appercu = '<li id="new" class="text-primary"><i class="fas fa-plane" id="cat-apercu-icon"></i> <span\n' +
        '                                            id="cat-apercu-txt">Mes voyages</span></li>';

    /**
     * Event sur l'ajout d'une catégorie
     * @constructor
     */
    Categorie.EventManagement = function () {

        Categorie.astuce = $('#categorie-liste-fa').html();

        var options = {
            // or like a jQuery css object. Note that css object settings can't be removed
            hintClass: 'hint',
            maxLevels: 1,
            complete: function (currEl) {
                Categorie.currentOrder = $('#liste-categorie-apercu').sortableListsToArray();
            }
        }

        /**
         * Event sur le click d'une icone
         */
        $('#categorie-change-icon').click(function () {
            Categorie.Ajax($(this).data('url'), '#categorie-liste-fa');
        });

        /**
         * Event au changement de texte d'une catégorie
         */
        $('#titre-categorie').change(function () {
            Categorie.currentTxt = $(this).val();

            if (Categorie.id == -1) {
                $('#cat-apercu-txt').html($(this).val());
            } else {
                $('#cat-apercu-txt-' + Categorie.id).html($(this).val());
            }

            if (Categorie.currentTxt == '') {
                $('#titre-categorie').addClass('is-invalid');
            } else {
                $('#titre-categorie').removeClass('is-invalid');
            }
        });

        /**
         * Event checkbok
         */
        $('#disabled-categorie').change(function() {
            Categorie.disabled = false;
            if($(this).is(':checked')) {
                Categorie.disabled = true;
            }
        });

        /**
         * Permet de charger les données d'une catégorie
         */
        $('#select-categorie').change(function () {

            if ($(this).val() == -1) {
                $('#titre-categorie').val('');
                $('#categorie-icon-fa').removeClass().addClass('fas fa-plane');
                $('#tips-icon').removeClass().addClass('fas fa-plane');
                $('#checkbox-disabled').addClass('invisible');
                Categorie.id = -1;
                Categorie.currentTxt = '';
                $('#submit-categorie').html('Créer ma catégorie');

                $('#liste-categorie-apercu li').each(function () {
                    $(this).removeClass('text-primary');
                });

                $('#liste-categorie-apercu').append(Categorie.new_cat_appercu);

                return false;
            }

            var url = $(this).data('url');

            url = url.slice(0, -2) + $(this).val();

            $.ajax({
                method: "GET",
                url: url,
            })
                .done(function (msg) {
                    if (msg.response === true) {
                        $('#titre-categorie').val(msg.categorie.name);
                        Categorie.currentTxt = msg.categorie.name;
                        $('#categorie-icon-fa').removeClass().addClass(msg.categorie.icon)
                        $('#tips-icon').removeClass().addClass(msg.categorie.icon);
                        $('#checkbox-disabled').removeClass('invisible');
                        $('#disabled-categorie').prop("checked", msg.categorie.disabled);
                        $('#cat-apercu-icon-' + msg.categorie.id).removeClass().addClass(msg.categorie.icon);
                        Categorie.id = msg.categorie.id;
                        $('#submit-categorie').html('Modifier ma catégorie');

                        $('#liste-categorie-apercu li').each(function () {
                            if ($(this).attr('id') == msg.categorie.id) {
                                $(this).addClass('text-primary');
                            } else {
                                $(this).removeClass('text-primary');
                            }
                        });

                        $('#liste-categorie-apercu #new').remove();
                    }
                });
        });


        /**
         * Gestion du trie
         */
        $('#liste-categorie-apercu').sortableLists(options);
        Categorie.currentOrder = $('#liste-categorie-apercu').sortableListsToArray();

        $('#submit-categorie').click(function () {

            if (Categorie.currentTxt == '') {
                $('#titre-categorie').addClass('is-invalid');
                return false;
            } else {
                $('#titre-categorie').removeClass('is-invalid');
            }

            $('#submit-categorie').prop('disabled', true);

            Categorie.currentOrder = $('#liste-categorie-apercu').sortableListsToArray();

            let data = {
                "id": Categorie.id, "disabled": Categorie.disabled,
                "name": Categorie.currentTxt, "icon": Categorie.currentIcon, "order": Categorie.currentOrder
            };

            $.ajax({
                method: "POST",
                url: $(this).data('url'),
                data: JSON.stringify(data)
            })
                .done(function (msg) {

                    if (msg.response === true) {
                        $('#msg-categorie-success').removeClass('text-hide');

                        setTimeout(function () {
                            $('#modal-add-categorie').modal('hide');
                        }, 2500);

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
        });

        // Au click sur une nouvelle icone
        $('#content-icon-fa i.fas').click(function () {
            $('#categorie-icon-fa').removeClass().addClass('fa ' + $(this).data('fa')).attr('data-fa', $(this).data('fa'));

            if (Categorie.id == -1) {
                $('#cat-apercu-icon').removeClass().addClass('fa ' + $(this).data('fa'));
            } else {
                $('#cat-apercu-icon-' + Categorie.id).removeClass().addClass('fa ' + $(this).data('fa'));
            }
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