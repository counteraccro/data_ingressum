<?php
namespace App\Twig;

use App\Twig\DataRender;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            // the logic of this filter is now implemented in a different class
            new TwigFilter('dataRender', [DataRender::class, 'htmlRender']),
        ];
    }
}