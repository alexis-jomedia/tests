<?php

namespace workers;

use workers\Base as Base;
/**
 * Created by PhpStorm.
 * User: alexis
 * Date: 4/24/17
 * Time: 1:46 PM
 */
class Games extends Base
{
    /**
     * holder for the IDs to work with;
     * @var array
     */
    protected $arrID = [];

    private $arrTables = [
        [
            'tableName' => 'game',
            'options' => 'WHERE id IN (%s)'
        ],
        [
            'tableName' => 'developer',
            'options' => ''
        ],
        [
            'tableName' => 'game_yummy',
            'options' => 'WHERE game_id IN (%s)'
        ],
        [
            'tableName' => 'game_types',
            'options' => 'WHERE game_id IN (%s)'
        ],
        [
            'tableName' => 'types',
            'options' => ''
        ],
        [
            'tableName' => 'media_geo_restrict',
            'options' => 'WHERE media_type = 2 AND media_id IN (%s)'
        ],

        [
            'tableName' => 'content_filters_medias',
            'options' => ' WHERE media_type = \'games\' AND media_id IN (%s)'
        ],
        [
            'tableName' => 'media_language',
            'options' => 'WHERE media_type = \'games\' AND media_id IN (%s)'
        ],
        [
            'tableName' => 'game_external_metadatas',
            'options' => 'WHERE game_id IN (%s)'
        ],
        [
            'tableName' => 'game_scores',
            'options' => 'WHERE id IN (%s)'
        ],
        [
            'tableName' => 'game_tag',
            'options' => 'WHERE game_id IN (%s)'
        ],
        [
            'tableName' => 'tag',
            'options' => 'JOIN game_tag gt ON gt.tag_id = tag.id AND gt.game_id IN (%s)'
        ],
        [
            'tableName' => 'game_genres',
            'options' => ' WHERE game_id IN (%s)'
        ],
        [
            'tableName' => 'genre',
            'options' => ' JOIN game_genres gg ON genre.id = gg.genre_id AND gg.game_id IN (%s)'
        ],
        [
            'tableName' => 'studio',
            'options' => ''
        ],
        [
            'tableName' => 'game_availability_regions',
            'options' => ''
        ],
        [
            'tableName' => 'game_ratings_override',
            'options' => ' WHERE game_id IN (%s)'
        ]
    ];

    public function process()
    {
        $this->logger->addInfo("*** Processing Games ***");
        $arrID = $this->getIDs('game');
        foreach ($this->arrTables as $tableDefinition) {
            $tableName = $tableDefinition['tableName'];
            $options = sprintf($tableDefinition['options'], implode(',', $arrID));
            $this->processTable($tableName, $options);
        }

        $this->logger->addInfo("*** Processing Games done ***");
    }
}