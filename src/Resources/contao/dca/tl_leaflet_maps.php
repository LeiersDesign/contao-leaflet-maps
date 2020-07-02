<?php

/*
 * Copyright 2019 LEIERS//design.
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$GLOBALS['TL_DCA']['tl_leaflet_maps'] = [
    // Config
    'config' => [
        'dataContainer' => 'Table',
        'sql' => [
            'keys' => [
                'id' => 'primary'
            ]
        ],
    ],
    // List
    'list' => [
        'sorting' => [
            'mode' => 1,
            'fields' => ['title'],
            'flag' => 1,
            'panelLayout' => 'search, limit; filter;'
        ],
        'label' => [
            'fields' => ['title'],
            'format' => '%s',
            'label_callback' => ['tl_leaflet_maps', 'mapLabelCallback']
        ],
        'global_operations' => [
            'all' => [
                'label' => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            ]
        ],
        'operations' => [
            'markers' => [
                'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps']['markers'],
                'href' => 'table=tl_leaflet_maps_markers',
                'icon' => '/bundles/leafletmaps/images/icons/backend/markers.svg'
            ],
            'edit' => [
                'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps']['edit'],
                'href' => 'act=edit',
                'icon' => 'header.svg'
            ],
            'delete' => [
                'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ],
            'copy' => [
                'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps']['copy'],
                'href' => 'act=copy',
                'icon' => 'copy.gif'
            ],
            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps']['show'],
                'href' => 'act=show',
                'icon' => 'show.gif',
            ],
        ]
    ],
    // Palettes
    'palettes' => [
        '__selector__' => ['controls_zoom'],
        'default' => 'title, alias;'
        . 'center_address, center_country, center;'
        . 'map_zoom;'
        . 'map_size_width, map_size_height;'
        . '{controls_legend}, controls_zoom;'
        . '{map_settings_legend}, disable_mouse_wheel_zoom;'
        //TODO . '{cluster_settings_legend}, enable_marker_cluster,fit_markers;'
    ],
    'subpalettes' => [
        'controls_zoom' => 'controls_zoom_position'
    ],
    // Fields
    'fields' => [
        'id' => [
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ],
        'title' => [
            'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps']['title'],
            'inputType' => 'text',
            'exclude' => true,
            'sorting' => true,
            'flag' => 1,
            'search' => true,
            'eval' => [
                'mandatory' => true,
                'maxlength' => 100,
                'tl_class' => 'w50',
            ],
            'sql' => "varchar(100) NOT NULL default ''"
        ],
        'alias' => [
            'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps']['alias'],
            'inputType' => 'text',
            'exclude' => true,
            'search' => false,
            'eval' => [
                'unique' => true,
                'maxlength' => 128,
                'tl_class' => 'w50',
                'disabled' => false,
                'doNotCopy' => true,
                'rgxp' => 'alias'
            ],
            'sql' => "varchar(128) NOT NULL default ''"
        ],
        'center' => [
            'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps']['center'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => [
                'maxlength' => 64,
                'tl_class' => 'w50'
            ],
            'sql' => "varchar(64) NOT NULL default ''",
            'save_callback' => [
                //['LeiersDesign\\ContaoLeafletMaps\\Classes\\HelperClass', 'generateGeoCoords'],
            ],
        ],
        'center_address' => [
            'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps']['center_address'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => [
                'maxlength' => 255,
                'tl_class' => 'w50',
                'mandatory' => false
            ],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'map_size_width' => [
            'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps']['map_size_width'],
            'exclude' => true,
            'inputType' => 'inputUnit',
            'options' => $GLOBALS['TL_CSS_UNITS'],
            'eval' => [
                'includeBlankOption' => false,
                'maxlength' => 20,
                'tl_class' => 'w50',
                'mandatory' => true,
            ],
            'default' => '320',
            'sql' => "varchar(64) NOT NULL default ''"
        ],
        'map_size_height' => [
            'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps']['map_size_height'],
            'exclude' => true,
            'inputType' => 'inputUnit',
            'options' => $GLOBALS['TL_CSS_UNITS'],
            'eval' => [
                'includeBlankOption' => false,
                'maxlength' => 20,
                'tl_class' => 'w50',
                'mandatory' => true
            ],
            'default' => '280',
            'sql' => "varchar(64) NOT NULL default ''"
        ],
        'map_zoom' => [
            'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps']['map_zoom'],
            'exclude' => true,
            'inputType' => 'select',
            'options' => ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18'],
            'default' => '10',
            'eval' => [
                'mandatory' => true,
                'tl_class' => 'w50'
            ],
            'sql' => "int(10) unsigned NOT NULL default '10'",
        ],
        'controls_zoom' => [
            'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps']['controls_zoom'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => [
                'tl_class' => 'w50 m12',
                'submitOnChange' => true
            ],
            'sql' => "char(1) NOT NULL default ''"
        ],
        'controls_zoom_position' => [
            'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps']['controls_zoom_position'],
            'exclude' => true,
            'inputType' => 'select',
            'options' => [
                'topleft' => $GLOBALS['TL_LANG']['tl_leaflet_maps']['controls_zoom']['topleft'],
                'bottomleft' => $GLOBALS['TL_LANG']['tl_leaflet_maps']['controls_zoom']['bottomleft'],
                'topright' => $GLOBALS['TL_LANG']['tl_leaflet_maps']['controls_zoom']['topright'],
                'bottomright' => $GLOBALS['TL_LANG']['tl_leaflet_maps']['controls_zoom']['bottomright']
            ],
            'eval' => [
                'tl_class' => 'w50'
            ],
            'sql' => "varchar(25) NOT NULL default ''"
        ],
        'disable_mouse_wheel_zoom' => [
            'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps']['disable_mouse_wheel_zoom'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => [
                'tl_class' => 'w50 m12',
                'submitOnChange' => false
            ],
            'sql' => "char(1) NOT NULL default ''"
        ],
        'enable_marker_cluster' => [
            'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps']['enable_marker_cluster'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => [
                'tl_class' => 'w50 m12',
                'submitOnChange' => true
            ],
            'sql' => "char(1) NOT NULL default ''"
        ],
        'fit_markers' => [
            'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps']['fit_markers'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => [
                'tl_class' => 'w50 m12 clr',
                'submitOnChange' => false
            ],
            'sql' => "char(1) NOT NULL default ''"
        ],
    ]
];

Class tl_leaflet_maps extends Backend {

    /**
     * Show a hint if a JavaScript library needs to be included in the page layout
     *
     * @param object
     */
    public function showJsLibraryHint(DataContainer $dc) {
        if (Input::get('act') != 'edit') {
            return;
        }

        Message::addInfo($GLOBALS['TL_LANG']['leaflet_maps']['includeJquery']);
    }

    /**
     * @param $row
     * @param $label
     * @return string
     */
    public function mapLabelCallback($row, $label) {
        $countMarkers = \LeiersDesign\LeafletMaps\Models\LeafletMapsMarkerModel::countBy('pid', $row['id']);

        $newLabel = sprintf($GLOBALS['TL_LANG']['leaflet_maps']['labels']['maps_label'], $label, $countMarkers);

        return $newLabel;
    }

}
