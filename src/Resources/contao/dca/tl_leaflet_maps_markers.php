<?php

/*
 * Copyright 2019 LEIERS//design.
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$GLOBALS['TL_DCA']['tl_leaflet_maps_markers'] = [
    // Config
    'config' => [
        'dataContainer' => 'Table',
        'ptable' => 'tl_leaflet_maps',
        'sql' => [
            'keys' => [
                'id' => 'primary'
            ]
        ],
        'onsubmit_callback' => [
            //['tl_leaflet_maps_markers', 'generateMarkerAlias'],
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
            'format' => '%s'
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
            'edit' => [
                'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps_markers']['edit'],
                'href' => 'act=edit',
                'icon' => 'edit.svg'
            ],
            'delete' => [
                'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps_markers']['delete'],
                'href' => 'act=delete',
                'icon' => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ],
            'copy' => [
                'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps_markers']['copy'],
                'href' => 'act=copy',
                'icon' => 'copy.gif'
            ],
            'toggle' => [
                'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps_markers']['toggle'],
                'icon' => 'visible.gif',
                'attributes' => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback' => array('tl_leaflet_maps_markers', 'toggleIcon')
            ],
            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps_markers']['show'],
                'href' => 'act=show',
                'icon' => 'show.gif',
            ],
        ]
    ],
    // Palettes
    'palettes' => [
        '__selector__' => ['add_popup'],
        'default' => 'title;'
        . 'center_address, center_country, center;'
        . '{popup_legend}, add_popup;'
        . 'published;'
    ],
    'subpalettes' => [
        'add_popup' => 'popup_content, popup_open'
    ],
    // Fields
    'fields' => [
        'id' => [
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ],
        'pid' => [
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ],
        'title' => [
            'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps_markers']['title'],
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
        'center' => [
            'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps_markers']['center'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => [
                'maxlength' => 64,
                'tl_class' => 'w50'
            ],
            'sql' => "varchar(64) NOT NULL default ''"
        ],
        'center_address' => [
            'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps_markers']['center_address'],
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
        'add_popup' => [
            'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps_markers']['add_popup'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => [
                'tl_class' => 'w50 m12',
                'submitOnChange' => true
            ],
            'sql' => "char(1) NOT NULL default ''"
        ],
        'popup_content' => [
            'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps_markers']['popup_content'],
            'inputType' => 'textarea',
            'exclude' => true,
            'sorting' => false,
            'flag' => 1,
            'search' => false,
            'eval' => [
                'mandatory' => true,
                'maxlength' => 500,
                'tl_class' => 'clr',
                'rte' => 'tinyMCE'
            ],
            'sql' => "TEXT NULL"
        ],
        'popup_open' => [
            'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps_markers']['popup_open'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => [
                'tl_class' => 'w50 m12',
                'submitOnChange' => false
            ],
            'sql' => "char(1) NOT NULL default ''"
        ],
        'published' => [
            'label' => &$GLOBALS['TL_LANG']['tl_leaflet_maps_markers']['published'],
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => [
                'tl_class' => 'w50',
                'submitOnChange' => false
            ],
            'sql' => "char(1) NOT NULL default ''"
        ],
    ]
];

Class tl_leaflet_maps_markers extends Backend {

    function generateMarkerAlias(DataContainer $dc) {
        $id = $dc->id;
        $objParentMap = $this->Database->prepare("SELECT alias FROM tl_leaflet_maps WHERE id = '{$dc->activeRecord->pid}'")->execute();

        $arrParentMap = $objParentMap->row();
        $strParentMap = $arrParentMap['alias'];
        
        $markerAlias = $strParentMap . '_marker_' . $dc->id;

        $sql = "UPDATE tl_leaflet_maps_markers SET alias = '$markerAlias' WHERE id = '$id'";

        $this->Database->prepare($sql)->execute();
    }

    /**
     * 
     * @param string $strValue
     * @return string
     */
    private function replaceSpecialChars($strValue) {
        $arrSearch = ["Ä", "Ö", "Ü", "ä", "ö", "ü", "ß", "´", "-"];
        $arrReplace = ["Ae", "Oe", "Ue", "ae", "oe", "ue", "ss", "", "_"];

        return str_replace($arrSearch, $arrReplace, $strValue);
    }

    /**
     * Ändert das Aussehen des Toggle-Buttons.
     * @param $row
     * @param $href
     * @param $label
     * @param $title
     * @param $icon
     * @param $attributes
     * @return string
     */
    public function toggleIcon($row, $href, $label, $title, $icon, $attributes) {
        $this->import('BackendUser', 'User');

        if (strlen($this->Input->get('tid'))) {
            $this->toggleVisibility($this->Input->get('tid'), ($this->Input->get('state') == 0));
            $this->redirect($this->getReferer());
        }

        // Check permissions AFTER checking the tid, so hacking attempts are logged
        if (!$this->User->isAdmin && !$this->User->hasAccess('tl_leaflet_maps_markers::published', 'alexf')) {
            return '';
        }

        $href .= '&amp;id=' . $this->Input->get('id') . '&amp;tid=' . $row['id'] . '&amp;state=' . $row[''];

        if (!$row['published']) {
            $icon = 'invisible.gif';
        }

        return '<a href="' . $this->addToUrl($href) . '" title="' . specialchars($title) . '"' . $attributes . '>' . $this->generateImage($icon, $label) . '</a> ';
    }

    public function toggleVisibility($intId, $blnPublished) {

        // Check permissions to publish
        if (!$this->User->isAdmin && !$this->User->hasAccess('tl_leaflet_maps_markers::published', 'alexf')) {
            $this->log('Not enough permissions to show/hide record ID "' . $intId . '"', 'tl_leaflet_maps_markers toggleVisibility', TL_ERROR);
            $this->redirect('contao/main.php?act=error');
        }

        $this->createInitialVersion('tl_leaflet_maps_markers', $intId);

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_leaflet_maps_markers']['fields']['published']['save_callback'])) {
            foreach ($GLOBALS['TL_DCA']['tl_leaflet_maps_markers']['fields']['published']['save_callback'] as $callback) {
                $this->import($callback[0]);
                $blnPublished = $this->$callback[0]->$callback[1]($blnPublished, $this);
            }
        }

        // Update the database
        $this->Database->prepare("UPDATE tl_leaflet_maps_markers SET tstamp=" . time() . ", published='" . ($blnPublished ? '' : '1') . "' WHERE id=?")
                ->execute($intId);
    }

}
