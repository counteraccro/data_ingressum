Menu = {};

/**
 * Objet JS qui va gérer le menu gauche
 */
Menu.Launch = function (params) {

    Menu.url_ajax_menu = params.url_ajax_menu;

    /**
     * Charge le menu
     */
    Menu.Load = function () {
        Menu.Ajax(Menu.url_ajax_menu, '#sidebar-content');
    };

    /**
     *
     */
    Menu.Event = function () {

        $('.collapse.list-unstyled li a').click(function () {

            $('.collapse.list-unstyled li a').each(function () {
                $(this).removeClass('active');
            })

            $(this).addClass('active');
            Menu.Ajax($(this).attr('href'), '#page-content', false);
            return false;
        });

        /** Lien ajout nouvelle catégorie **/
        $('.list-unstyled #new-categorie').click(function () {

            Menu.Ajax($(this).attr('href'), '#content-modal', false, 'GET');
            return false;
        });
    };

    /**
     * Méthode Ajax qui va charger l'element présent dans l'URL
     */
    Menu.Ajax = function (url, id_done, loader = true, method = 'GET') {
        if (loader) {
            $(id_done).loader();
        }

        $.ajax({
            method: method,
            url: url,
        })
            .done(function (html) {
                console.log(html);
                $(id_done).html(html);
            });
    };
}