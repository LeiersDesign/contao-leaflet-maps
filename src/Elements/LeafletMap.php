<?php

/*
 * Copyright 2020 leiers//DESIGN.
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LeiersDesign\LeafletMaps\Elements;

use LeiersDesign\LeafletMaps\Models\LeafletMapsModel;
use LeiersDesign\LeafletMaps\Models\LeafletMapsMarkerModel;
use Contao\Input;

/**
 * Description of LeafletMap
 *
 * @author LEIERS//design <info@leiers-design.de>
 */
class LeafletMap extends \ContentElement {

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_leaflet_map';

    /**
     * Generate content element
     */
    public function generate() {
        if (TL_MODE == 'BE') {
            // get map data
            $objMap = LeafletMapsModel::findByPk($this->leaflet_map);

            return '<span>Map: <em>' . $objMap->title . '</em></span>';
        }

        return parent::generate();
    }

    /**
     * Compile the content element
     */
    protected function compile() {

        $objMap = LeafletMapsModel::findByPk($this->leaflet_map);

        if (!$objMap) {
            $this->Template->map = null;
            return;
        }

        $opt_in_needed = true;
        if (Input::cookie('leaflet_map')) {
            $opt_in_needed = null;
            if (empty($GLOBALS['TL_JAVASCRIPT']['leaflet_main_js'])) {
                $GLOBALS['TL_JAVASCRIPT']['leaflet_main_js'] = '/bundles/leafletmaps/leaflet/leaflet.js|static';
            }
            if (empty($GLOBALS['TL_CSS']['leaflet_main_css'])) {
                $GLOBALS['TL_CSS']['leaflet_main_css'] = '/bundles/leafletmaps/leaflet/leaflet.css|static';
            }
        }

        $objMarkers = LeafletMapsMarkerModel::findBy(
                        ['pid=?', 'published=?'],
                        [$objMap->id, '1']
        );

        $openedMarkers = 0;
        if ($objMarkers) {
            $arrMarkers = [];

            while ($objMarkers->next()) {
                $arrMarker = $objMarkers->row();
                $arrMarkers[] = $arrMarker;
                $openedMarkers += ($arrMarker['popup_open'] ? 1 : 0);
            }
        }

        $this->Template->opt_in_needed = $opt_in_needed;
        $this->Template->map = $objMap->row();
        $this->Template->markers = ($objMarkers ? $arrMarkers : null);
        $this->Template->multi_open_markers = ($openedMarkers > 1 ? true : null);
        
        $this->Template->mapWidth = \Contao\StringUtil::deserialize($objMap->map_size_width);
        $this->Template->mapHeight = \Contao\StringUtil::deserialize($objMap->map_size_height);
    }

}
