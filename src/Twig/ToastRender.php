<?php

namespace App\Twig;

use Twig\Extension\RuntimeExtensionInterface;

/**
 * Class qui va gérer la génération des toasts
 * Class ToastRender
 * @package App\Twig
 * @author Aymeric
 */
class ToastRender implements RuntimeExtensionInterface
{
    /**
     * Délai d'apparition du toast
     * @var string
     */
    private $delay = '1500';

    /**
     * Texte dans le header
     * @var string
     */
    private $head_txt = 'titre du toast';

    /**
     * Texte dans le small du header
     * @var string
     */
    private $head_time = 'A l\'instant';

    /**
     * Texte dans le body du toast
     * @var string
     */
    private $body_txt = 'Mettre ici un message qui s\'affiche dans le corps';

    /**
     * Affiche ou masque le bouton fermer
     * @var bool
     */
    private $close_btn = true;


    /**
     * @param array $params
     * @return string
     */
    public function htmlRender(array $toats): string
    {


        $html = '<div style="position: absolute; top: 50px; right: 50px;">';

        foreach($toats as $toast) {
            $this->initParams($toast);

            $html .= '<div class="toast ml-auto" data-delay="' . $this->delay . '">';
            $html .= $this->header();
            $html .= $this->body();
            $html .= '</div>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Génère le header du toast
     * @return string
     */
    private function header(): string
    {
        $html = '<div class="toast-header bg-primary">
            <strong class="mr-auto">' . $this->head_txt . '</strong>
            <small>' . $this->head_time . '</small>';

        if ($this->close_btn) {
            $html .= '<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>';
        }

        $html .= '</div>';
        return $html;
    }

    /**
     * Génère le body du toast
     * @return string
     */
    private function body(): string
    {
        return '<div class="toast-body">' . $this->body_txt . '</div>';
    }


    /**
     * Permet de mettre à jour les propriétés de la class avec les paramètres choisi
     * @param $params
     */
    private function initParams($params)
    {
        foreach ($params as $key => $value) {
            $this->{$key} = $value;
        }
    }
}