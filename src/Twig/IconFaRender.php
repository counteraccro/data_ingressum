<?php

namespace App\Twig;

use Twig\Extension\RuntimeExtensionInterface;

class IconFaRender implements RuntimeExtensionInterface
{
    private $tabIcon = ['angle-down', 'angle-up', 'angle-right', 'angle-left', 'angry', 'home', 'campground', 'plane', 'helicopter',
        'caravan', 'car-side', 'truck', 'route', 'tree', 'mountain', 'subway', 'train',
        'laptop-code', 'laptop', 'desktop', 'database', 'headphones', 'comments'];

    public function htmlRender(): string
    {
        $html = '';

        foreach ($this->tabIcon as $icon) {
            $html .= '<i class="fa-border fas fa-' . $icon . ' fa-2x" data-fa="fa-' . $icon . '"></i>';
        }

        return $html;
    }
}