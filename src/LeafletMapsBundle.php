<?php

namespace LeiersDesign\LeafletMaps;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use LeiersDesign\LeafletMaps\DependencyInjection\LeafletMapsExtension;

/**
 * This is the Bundle Class
 */
class LeafletMapsBundle extends Bundle {

    /**
     * {@inheritdoc}
     */
    public function getContainerExtension() {
        return new LeafletMapsExtension();
    }

}
