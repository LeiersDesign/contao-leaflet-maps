<?php

/*
 * Copyright 2020 leiers//DESIGN.
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LeiersDesign\LeafletMaps\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/*
 * Copyright 2020 leiers//DESIGN.
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Description of MagazineExtension
 *
 * @author LEIERS//design <info@leiers-design.de>
 */
class LeafletMapsExtension extends Extension {

    /**
     * {@inheritdoc}
     */
    public function load(array $mergedConfig, ContainerBuilder $container) {
        $loader = new YamlFileLoader(
                $container,
                new FileLocator(__DIR__ . '/../Resources/config')
        );

        $loader->load('listener.yml');
        $loader->load('services.yml');
    }

}
