<?php

namespace App\Twig;

use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Asset\VersionStrategy\StaticVersionStrategy;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\KernelInterface;
use Twig\Extension\RuntimeExtensionInterface;

class AssetRender implements RuntimeExtensionInterface
{
    /**
     * @var Packages
     */
    private $asset;

    /**
     * @var Finder
     */
    private $finder;

    /**
     * @var KernelInterface
     */
    private $appKernel;

    /**
     * AssetRender constructor.
     * @param KernelInterface $appKernel
     */
    public function __construct(KernelInterface $appKernel)
    {
        $this->asset = new Package(new StaticVersionStrategy('v1', '%s?version=%s'));
        $this->finder = new Finder();
        $this->appKernel = $appKernel;
    }

    /**
     * Permet de générer les Assets en fonction de $asset
     * @param String $asset
     */
    public function htlmRender(string $asset): string
    {
        switch ($asset) {
            case "js" :
                return $this->assetJs();
        }

        //echo $this->asset->getUrl('assets/js/Menu.js');
    }

    /**
     * Permet de créer les URL pour les assets de type JS
     */
    private function assetJs(): string
    {
        $html = '';
        $path_asset = 'assets/js/src/';
        $path = $this->appKernel->getProjectDir() . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'src';
        $this->finder->files()->in($path);

        foreach ($this->finder as $file) {

            $html .= '<script type="text/javascript" src="' . $this->asset->getUrl($path_asset . $file->getRelativePathname()) . '"></script>';
        }
        return $html;
    }
}