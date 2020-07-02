<?php

/*
 * Copyright 2020 leiers//DESIGN.
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LeiersDesign\LeafletMaps\EventListener;

use Contao\DataContainer;
use LeiersDesign\LeafletMaps\Models\LeafletMapsModel;
use LeiersDesign\LeafletMaps\Models\LeafletMapsMarkerModel;

/**
 * Description of BackendCallbacks
 *
 * @author LEIERS//design <info@leiers-design.de>
 */
class BackendCallbacks {

    /**
     * 
     * @param mixed $varValue
     * @param DataContainer $dc
     */
    public function generateAlias($varValue, DataContainer $dc) {
        if (!$dc->id) {
            throw new \Exception("Der Funktion generateAlias wurde kein Datensatz übergeben.");
        }

        $autoAlias = false;

        // Generiere einen Alias wenn es keinen gibt
        if ($varValue == '') {
            $autoAlias = true;

            $slugOptions = (object) [
                        'setValidChars' => '0-9a-z',
                        'setLocale' => 'de',
                        'setDelimiter' => '-'
            ];

            $varValue = \Contao\System::getContainer()->get('contao.slug')->generate($dc->activeRecord->title, $slugOptions);
        }

        $objAlias = LeafletMapsModel::findBy(['alias=?', 'id!=?'], [$varValue, $dc->id]);

        if ($objAlias !== null && !$autoAlias) {
            throw new \Exception("Der angegebene Alias existiert bereits");
        }

        if ($objAlias !== null && $autoAlias) {
            $varValue .= '-' . $dc->id;
        }

        return $varValue;
    }

    /**
     * 
     * @param mixed $varValue
     * @param DataContainer $dc
     */
    public function getCenterCoords($varValue, DataContainer $dc) {
        if (!$dc->id) {
            throw new \Exception("Der Funktion getCenterCoords wurde kein Datensatz übergeben.");
        }

        if ($varValue != '') {
            return $varValue;
        }
        
        if($dc->activeRecord->center_address == '') {
            return null;
        }

        $objMap = LeafletMapsModel::findByPk($dc->id);
        $strAddress = $objMap->center_address;

        $strQuery = sprintf('https://nominatim.openstreetmap.org/search?q=%s&format=json', urlencode($strAddress));

        $referer = \Idna::decode(\Environment::get('url'));
        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => [
                    'Accept: application/json\r\n',
                    'Referer: ' . $referer . '\r\n'
                ]
            ]
        ];
        $context = stream_context_create($opts);
        $strJson = file_get_contents($strQuery, false, $context);
        
        if(!$strJson) {
            return null;
        }
        
        $objJson = json_decode($strJson)[0];
        
        /**
         * mögliche regex:
         * ^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$
         * https://stackoverflow.com/questions/3518504/regular-expression-for-matching-latitude-longitude-coordinates/18690202#18690202
         * https://stackoverflow.com/a/18690202
         */
        
        $strCoords = implode(',', [$objJson->lat, $objJson->lon]);

        return ($strCoords == ',' ? null : $strCoords);
    }
    
    /**
     * 
     * @param mixed $varValue
     * @param DataContainer $dc
     */
    public function getCenterCoordsMarker($varValue, DataContainer $dc) {
        if (!$dc->id) {
            throw new \Exception("Der Funktion getCenterCoords wurde kein Datensatz übergeben.");
        }

        if ($varValue != '') {
            return $varValue;
        }
        
        if($dc->activeRecord->center_address == '') {
            return null;
        }

        $objMarker = LeafletMapsMarkerModel::findByPk($dc->id);
        $strAddress = $objMarker->center_address;

        $strQuery = sprintf('https://nominatim.openstreetmap.org/search?q=%s&format=json', urlencode($strAddress));

        $referer = \Idna::decode(\Environment::get('url'));
        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => [
                    'Accept: application/json\r\n',
                    'Referer: ' . $referer . '\r\n'
                ]
            ]
        ];
        $context = stream_context_create($opts);
        $strJson = file_get_contents($strQuery, false, $context);
        
        if(!$strJson) {
            return null;
        }
        
        $objJson = json_decode($strJson)[0];
        
        /**
         * mögliche regex:
         * ^[-+]?([1-8]?\d(\.\d+)?|90(\.0+)?),\s*[-+]?(180(\.0+)?|((1[0-7]\d)|([1-9]?\d))(\.\d+)?)$
         * https://stackoverflow.com/questions/3518504/regular-expression-for-matching-latitude-longitude-coordinates/18690202#18690202
         * https://stackoverflow.com/a/18690202
         */
        
        $strCoords = implode(',', [$objJson->lat, $objJson->lon]);

        return ($strCoords == ',' ? null : $strCoords);
    }

}
