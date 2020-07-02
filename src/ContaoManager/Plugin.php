<?php

namespace LeiersDesign\LeafletMaps\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use LeiersDesign\LeafletMaps\LeafletMapsBundle;

class Plugin implements BundlePluginInterface {

    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser) {
        return [
                    BundleConfig::create(LeafletMapsBundle::class)
                    ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }

}
