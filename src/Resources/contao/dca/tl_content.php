<?php

/* 
 * Copyright 2020 leiers//DESIGN.
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/* Palettes */
$GLOBALS['TL_DCA']['tl_content']['palettes']['leaflet_map'] = '{type_legend},type,headline;'
        . '{map_legend},leaflet_map;'
        . 'cssID;'
        . '{invisible_legend:hide},invisible,start,stop;';

$GLOBALS['TL_DCA']['tl_content']['fields']['leaflet_map'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_content']['leaflet_map'],
    'exclude' => true,
    'inputType' => 'select',
    'foreignKey' => "tl_leaflet_maps.title",
    'eval' => [
        'tl_class' => 'w50',
        'mandatory' => true
    ],
    'sql' => "int(10) NOT NULL default '0'"
];
