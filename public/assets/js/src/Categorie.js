Categorie = {};

/**
 * Objet JS qui va gérer les events pour les catégories
 */
Categorie.Launch = function (params) {

    Categorie.astuce = '';
    Categorie.currentIcon = $('#categorie-icon-fa').data('fa');

    /**
     * Event sur l'ajout d'une catégorie
     * @constructor
     */
    Categorie.EventAdd = function () {

        Categorie.astuce = $('#categorie-liste-fa').html();

        $('#categorie-change-icon').click(function () {
            Categorie.Ajax($(this).data('url'), '#categorie-liste-fa');
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