<?php

namespace workers;

use workers\Base as Base;
/**
 * Created by PhpStorm.
 * User: alexis
 * Date: 4/24/17
 * Time: 1:46 PM
 */
class Albums extends Base
{
    /**
     * holder for the IDs to work with;
     * @var array
     */
    protected $arrID = [];

    private $arrTables = [
        [
            'tableName' => 'music_album',
            'options' => 'WHERE id IN (%s)'
        ],
        [
            'tableName' => 'media_geo_restrict',
            'options' => 'WHERE media_type = 4 AND media_id IN (%s)'
        ],
        [
            'tableName' => 'media_language',
            'options' => ' WHERE media_type = \'albums\' AND media_id in (%s)'
        ],
        [
            'tableName' => 'music_album_external_metadatas',
            'options' => ' WHERE music_album_id IN (%s)'
        ],
        [
            'tableName' => 'music_album_ratings_override',
            'options' => ' WHERE music_album_id IN (%s)'
        ],
        [
            'tableName' => 'rovi_releases',
            'options' => ' WHERE album_id IN (%s)'
        ],
        [
            'tableName' => 'rovi_ratings',
            'options' => ' JOIN rovi_releases rl ON rl.rovi_id = rovi_ratings.rovi_id AND rl.album_id IN (%s)'
        ],
        [
            'tableName' => 'music_scores',
            'options' => 'WHERE id IN (%s)'
        ],
        [
            'tableName' => 'music_album_availability_regions',
            'options' => ' WHERE media_id IN (%s)'
        ],
        [
            'tableName' => 'CNT_music_album_genres',
            'options' => ' WHERE album_id IN (%s)'
        ],
        [
            'tableName' => 'CNT_genre_music',
            'options' => ''
        ],
        [
            'tableName' => 'content_filters_medias',
            'options' => ' WHERE media_type = \'movies\' AND media_id IN (%s)'
        ],
        [
            'tableName' => 'music_album_tag',
            'options' => 'WHERE music_album_id IN (%s)'
        ],
        [
            'tableName' => 'tag',
            'options' => 'JOIN music_album_tag mat ON mat.tag_id = tag.id AND mat.music_album_id IN (%s)'
        ],
        [
            'tableName' => 'music_label',
            'options' => ' WHERE id IN (%s)'
        ],
        [
            'tableName' => 'music_album_artists',
            'options' => ' WHERE album_id IN (%s)'
        ],
        [
            'tableName' => 'music_artist',
            'options' => ' JOIN music_album_artists maa ON maa.artist_id = music_artist.id AND maa.album_id IN (%s)'
        ]
    ];

    public function process()
    {
        $this->logger->addInfo("*** Processing Albums ***");
        $arrID = $this->getIDs('music_album');
        foreach ($this->arrTables as $tableDefinition) {
            $tableName = $tableDefinition['tableName'];
            $options = sprintf($tableDefinition['options'], implode(',', $arrID));
            $this->processTable($tableName, $options);
        }

        $this->logger->addInfo("*** Processing Albums done ***");
    }
}