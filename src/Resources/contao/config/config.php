<?php

/*
 * Copyright 2020 leiers//DESIGN.
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Back end modules
 */
$GLOBALS['BE_MOD']['leaflet_maps']['maps'] = [
    'tables' => ['tl_leaflet_maps', 'tl_leaflet_maps_markers']
];

/**
 * Fronted modules

  $GLOBALS['FE_MOD']['online_magazines']['list_online_magazine'] = LeiersDesign\OnlineMagazine\Modules\ModuleListOnlineMagazines::class;
  $GLOBALS['FE_MOD']['online_magazines']['magazine_reader'] = LeiersDesign\OnlineMagazine\Modules\ModuleMagazineReader::class;
 * */
/**
 * Frontend elements
 */
$GLOBALS['TL_CTE']['leaflet_maps']['leaflet_map'] = LeiersDesign\LeafletMaps\Elements\LeafletMap::class;


//Models

$GLOBALS['TL_MODELS']['tl_leaflet_maps'] = \LeiersDesign\LeafletMaps\Models\LeafletMapsModel::class;
$GLOBALS['TL_MODELS']['tl_leaflet_maps_markers'] = \LeiersDesign\LeafletMaps\Models\LeafletMapsMarkerModel::class;
