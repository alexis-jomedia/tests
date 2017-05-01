<?php

namespace workers;

use workers\Base as Base;
/**
 * Created by PhpStorm.
 * User: alexis
 * Date: 4/24/17
 * Time: 1:46 PM
 */
class Movies extends Base
{
    /**
     * holder for the IDs to work with;
     * @var array
     */
    protected $arrID = [];

    private $arrTables = [
        [
            'tableName' => 'movie',
            'options' => 'WHERE id IN (%s)'
        ],
        [
            'tableName' => 'media_geo_restrict',
            'options' => 'WHERE media_type = 3 AND media_id IN (%s)'
        ],
        [
            'tableName' => 'media_language',
            'options' => ' WHERE media_type = \'movies\' AND media_id in (%s)'
        ],
        [
            'tableName' => 'brightcove',
            'options' => 'WHERE id IN (%s)'
        ],
        [
            'tableName' => 'movie_actors',
            'options' => 'WHERE movie_id IN (%s)'
        ],
        [
            'tableName' => 'actors',
            'options' => ' JOIN movie_actors ma ON ma.actor_id = actors.id AND ma.movie_id IN (%s)'
        ],
        [
            'tableName' => 'movie_directors',
            'options' => 'WHERE movie_id IN (%s)'
        ],
        [
            'tableName' => 'directors',
            'options' => ' JOIN movie_directors md ON md.director_id = directors.id AND md.movie_id IN (%s)'
        ],
        [
            'tableName' => 'movie_producers',
            'options' => 'WHERE movie_id IN (%s)'
        ],
        [
            'tableName' => 'producers',
            'options' => ' JOIN movie_producers mp ON mp.producer_id = producers.id AND mp.movie_id IN (%s)'
        ],
        [
            'tableName' => 'movie_writers',
            'options' => 'WHERE movie_id IN (%s)'
        ],
        [
            'tableName' => 'writers',
            'options' => ' JOIN movie_writers mw ON mw.writer_id = writers.id AND mw.movie_id IN (%s)'
        ],
        [
            'tableName' => 'movie_external_metadatas',
            'options' => ' WHERE movie_id IN (%s)'
        ],
        [
            'tableName' => 'movie_ratings_override',
            'options' => ' WHERE movie_id IN (%s)'
        ],
        [
            'tableName' => 'content_filters_medias',
            'options' => ' WHERE media_type = \'movies\' AND media_id IN (%s)'
        ],
        [
            'tableName' => 'movie_tmdb_metadatas',
            'options' => ' WHERE movie_id IN (%s)'
        ],
        [
            'tableName' => 'tmdb_metadatas',
            'options' => ' JOIN movie_tmdb_metadatas mtm ON mtm.tmdb_id = tmdb_metadatas.id AND mtm.movie_id IN (%s)'
        ],
        [
            'tableName' => 'movie_scores',
            'options' => 'WHERE id IN (%s)'
        ],
        [
            'tableName' => 'movie_availability_regions',
            'options' => ' WHERE media_id IN (%s)'
        ],
        [
            'tableName' => 'movie_cdn_path',
            'options' => ' WHERE movie_id IN (%s)'
        ],
        [
            'tableName' => '_biz__ma_serie',
            'options' => ' WHERE movie_id IN (%s)'
        ],
        [
            'tableName' => 'movie_tag',
            'options' => 'WHERE movie_id IN (%s)'
        ],
        [
            'tableName' => 'tag',
            'options' => 'JOIN movie_tag mt ON mt.tag_id = tag.id AND mt.movie_id IN (%s)'
        ],
        [
            'tableName' => 'movie_genres',
            'options' => ' WHERE movie_id IN (%s)'
        ],
        [
            'tableName' => 'genre_movie',
            'options' => ' JOIN movie_genres gg ON genre_movie.id = gg.genre_id AND gg.movie_id IN (%s)'
        ]
    ];

    public function process()
    {
        $this->logger->addInfo("*** Processing Movies ***");
        $arrID = $this->getIDs('movie');
        foreach ($this->arrTables as $tableDefinition) {
            $tableName = $tableDefinition['tableName'];
            $options = sprintf($tableDefinition['options'], implode(',', $arrID));
            $this->processTable($tableName, $options);
        }

        $this->logger->addInfo("*** Processing Movies done ***");
    }
}