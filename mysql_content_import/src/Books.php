<?php

namespace workers;

use workers\Base as Base;
/**
 * Created by PhpStorm.
 * User: alexis
 * Date: 4/24/17
 * Time: 1:46 PM
 */
class Books extends Base
{
    /**
     * holder for the IDs to work with;
     * @var array
     */
    protected $arrID = [];

    private $arrTables = [
        [
            'tableName' => 'book',
            'options' => 'WHERE id IN (%s)'
        ],
        [
            'tableName' => 'media_geo_restrict',
            'options' => 'WHERE media_type = 1 AND media_id IN (%s)'
        ],
        [
            'tableName' => 'media_language',
            'options' => 'WHERE media_type = 1 AND media_id IN (%s)'
        ],
        [
            'tableName' => 'book_authors',
            'options' => 'WHERE book_id IN (%s)'
        ],
        [
            'tableName' => 'author',
            'options' => 'JOIN book_authors ba ON ba.author_id = author.id AND ba.book_id IN (%s)'
        ],
        [
            'tableName' => 'book_artists',
            'options' => 'WHERE book_id IN (%s)'
        ],
        [
            'tableName' => 'artists',
            'options' => 'JOIN book_artists ba ON ba.artist_id = artists.id AND ba.book_id IN (%s)'
        ],
        [
            'tableName' => 'CNT_book_genres',
            'options' => 'WHERE book_id IN (%s)'
        ],
        [
            'tableName' => 'book_tag',
            'options' => 'WHERE book_id IN (%s)'
        ],
        [
            'tableName' => 'tag',
            'options' => 'JOIN book_tag bt ON bt.tag_id = tag.id AND bt.book_id IN (%s)'
        ],
        [
            'tableName' => 'book_publishers',
            'options' => 'WHERE book_id IN (%s)'
        ],
        [
            'tableName' => 'book_bowker_datas',
            'options' => 'JOIN book ON book_bowker_datas.isbn_13 = book.isbn AND book.id IN (%s)'
        ],
        [
            'tableName' => 'book_librarything_datas',
            'options' => ' JOIN book_bowker_datas AS bbd '
                         . ' ON book_librarything_datas.isbn_10 = bbd.isbn_10 '
                         . ' JOIN book ON bbd.isbn_13 = book.isbn AND book.id IN (%s)'
        ],
        [
            'tableName' => 'librarything_ratings',
            'options' => ' JOIN book_librarything_datas AS bld '
                         . ' ON librarything_ratings.workcode = bld.workcode '
                         . ' JOIN book_bowker_datas AS bbd ON bld.isbn_10 = bbd.isbn_10 '
                         . ' JOIN book ON bbd.isbn_13 = book.isbn AND book.id IN (%s)'
        ],
        [
            'tableName' => 'librarything_tags',
            'options' => ' JOIN book_librarything_datas AS bld '
                         . ' ON librarything_tags.workcode = bld.workcode '
                         . ' JOIN book_bowker_datas AS bbd ON bld.isbn_10 = bbd.isbn_10 '
                         . ' JOIN book ON bbd.isbn_13 = book.isbn AND book.id IN (%s)'
        ],
        [
            'tableName' => 'book_ratings_override',
            'options' => 'WHERE book_id IN (%s)'
        ],
        [
            'tableName' => 'content_filters_medias',
            'options' => ' WHERE media_type = 1 AND media_id IN (%s)'
        ]
    ];

    public function process()
    {
        $this->logger->addInfo("*** Processing books ***");
        $this->getBookIDs();
        foreach ($this->arrTables as $tableDefinition) {
            $tableName = $tableDefinition['tableName'];
            $options = sprintf($tableDefinition['options'], implode(',', $this->arrID));
            $this->processTable($tableName, $options);
        }

        $this->logger->addInfo("*** Processing books done ***");
    }

    /**
     * Get a list of $limit book IDs
     */
    private function getBookIDs()
    {
        $this->logger->addInfo("*** book IDS ***");
        $sql = "SELECT id FROM book WHERE file_format_type_id = 2 AND batch_id <> 0 ORDER BY rand() LIMIT "
            . $this->limit;
        /** @var \mysqli_result */
        $res = $this->conn->query($sql);
        while ($row = $res->fetch_assoc()) {
            $this->arrID[] = $row['id'];
        }

        $this->logger->addInfo("*** book IDS done ***");
    }
}