<?php

namespace workers;

use workers\Base as Base;
/**
 * Created by PhpStorm.
 * User: alexis
 * Date: 4/24/17
 * Time: 1:46 PM
 */
class Audiobooks extends Base
{
    /**
     * holder for the IDs to work with;
     * @var array
     */
    protected $arrID = [];

    private $arrTables = [
        [
            'tableName' => 'audio_book',
            'options' => 'WHERE id IN (%s)'
        ],
        [
            'tableName' => 'media_geo_restrict',
            'options' => 'WHERE media_type = 7 AND media_id IN (%s)'
        ],
        [
            'tableName' => 'content_filters_medias',
            'options' => ' WHERE media_type = 7 AND media_id IN (%s)'
        ],
        [
            'tableName' => 'audio_book_awards',
            'options' => ' WHERE audio_book_awards.audio_book_id IN (%s)'
        ],
        [
            'tableName' => 'award_audio_book',
            'options' => ' JOIN audio_book_awards aba ON award_audio_book.id = aba.award_id '
                         . ' AND aba.audio_book_id IN (%s)'
        ],
        [
            'tableName' => 'serie_audio_book',
            'options' => ''
        ],
        [
            'tableName' => 'audio_book_series',
            'options' => 'WHERE audio_book_id IN (%s)'
        ],
        [
            'tableName' => 'media_language',
            'options' => 'WHERE media_type = 7 AND media_id IN (%s)'
        ],
        [
            'tableName' => 'author_audio_book',
            'options' => ''
        ],
        [
            'tableName' => 'audiobook_external_metadatas',
            'options' => 'WHERE audiobook_id IN (%s)'
        ],
        [
            'tableName' => 'audio_book_authors',
            'options' => ' WHERE audio_book_id IN (%s)'
        ],
        [
            'tableName' => 'narrator_audio_book',
            'options' => ''
        ],
        [
            'tableName' => 'audio_book_narrators',
            'options' => 'WHERE audio_book_id IN (%s)'
        ],
        [
            'tableName' => 'publisher_audio_book',
            'options' => ''
        ],
        [
            'tableName' => 'audio_book_publishers',
            'options' => 'WHERE audio_book_id IN (%s)'
        ],
        [
            'tableName' => 'data_source_provider',
            'options' => ''
        ],
        [
            'tableName' => 'audio_book_products',
            'options' => 'WHERE audio_book_id IN (%s)'
        ],
        [
            'tableName' => 'product_audio_book',
            'options' => 'JOIN audio_book_products AS abp ON product_audio_book.id = abp.product_id '
                         . ' AND abp.audio_book_id IN (%s)'
        ],
        [
            'tableName' => 'CNT_audio_book_genres',
            'options' => 'WHERE audio_book_id IN (%s)'
        ],
        [
            'tableName' => 'audio_book_tag',
            'options' => 'WHERE audio_book_id IN (%s)'
        ],
        [
            'tableName' => 'tag',
            'options' => 'JOIN audio_book_tag abt ON abt.tag_id = tag.id AND abt.audio_book_id IN (%s)'
        ],
        [
            'tableName' => 'audio_book_bowker_datas',
            'options' => ' JOIN book_librarything_datas as bld ON bld.isbn_10 = audio_book_bowker_datas.isbn_10 '
                         . ' JOIN product_audio_book AS pabs ON pabs.isbn = audio_book_bowker_datas.isbn_13 '
                         . ' JOIN audio_book_products as abps ON abps.product_id = pabs.id '
                         . ' AND abps.audio_book_id IN (%s)'
        ],
        [
            'tableName' => 'book_librarything_datas',
            'options' => ' JOIN audio_book_bowker_datas AS abbd ON book_librarything_datas.isbn_10 = abbd.isbn_10 '
                         . ' JOIN product_audio_book AS pabs ON pabs.isbn = abbd.isbn_13 '
                         . ' JOIN audio_book_products as abps ON abps.product_id = pabs.id '
                         . ' AND abps.audio_book_id IN (%s)'
        ],
        [
            'tableName' => 'librarything_ratings',
            'options' => ' JOIN book_librarything_datas AS bld ON librarything_ratings.workcode = bld.workcode '
                         . ' JOIN audio_book_bowker_datas AS abbd ON bld.isbn_10 = abbd.isbn_10 '
                         . ' JOIN product_audio_book AS pabs ON pabs.isbn = abbd.isbn_13 '
                         . ' JOIN audio_book_products as abps ON abps.product_id = pabs.id '
                         . ' AND abps.audio_book_id IN (%s)'
        ],
        [
            'tableName' => 'librarything_tags',
            'options' => ' JOIN book_librarything_datas AS bld ON librarything_tags.workcode = bld.workcode '
                         . ' JOIN audio_book_bowker_datas AS abbd ON bld.isbn_10 = abbd.isbn_10 '
                         . ' JOIN product_audio_book AS pabs ON pabs.isbn = abbd.isbn_13 '
                         . ' JOIN audio_book_products as abps ON abps.product_id = pabs.id '
                         . ' AND abps.audio_book_id IN (%s)'
        ],
        [
            'tableName' => 'audiobook_ratings_override',
            'options' => 'WHERE audiobook_id IN (%s)'
        ]
    ];

    public function process()
    {
        $this->logger->addInfo("*** Processing Audiobooks ***");
        $this->getAudiobookIDs();
        foreach ($this->arrTables as $tableDefinition) {
            $tableName = $tableDefinition['tableName'];
            $options = sprintf($tableDefinition['options'], implode(',', $this->arrID));
            $this->processTable($tableName, $options);
        }

        $this->logger->addInfo("*** Processing Audiobooks done ***");
    }

    /**
     * Get a list of $limit book IDs
     */
    private function getAudiobookIDs()
    {
        $this->logger->addInfo("*** audiobook IDS ***");
        $sql = "SELECT id FROM audio_book ORDER BY rand() LIMIT " . $this->limit;
        /** @var \mysqli_result */
        $res = $this->conn->query($sql);
        while ($row = $res->fetch_assoc()) {
            $this->arrID[] = $row['id'];
        }

        $this->logger->addInfo("*** audiobook IDS done ***");
    }
}