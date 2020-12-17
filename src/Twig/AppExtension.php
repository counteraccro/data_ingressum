<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // the logic of this filter is now implemented in a different class
            new TwigFilter('dataRender', [DataRender::class, 'htmlRender']),
            new TwigFilter('OptionRender', [OptionRender::class, 'htmlRender']),
            new TwigFilter('AssetRender', [AssetRender::class, 'htlmRender']),
            new TwigFilter('IconFaRender', [IconFaRender::class, 'htmlRender']),
        ];
    }
}