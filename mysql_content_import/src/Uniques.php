<?php

namespace workers;

use workers\Base as Base;
/**
 * Created by PhpStorm.
 * User: alexis
 * Date: 4/24/17
 * Time: 3:11 PM
 */
class Uniques extends Base
{
    /**
     * Tables to process here
     *
     * @var array
     */
    private $arrTables = [
        'content_status',
        'licensors',
        'ma_language',
        'sites',
        'media_types',
        'site_media_types',
        'device_types',
        'site_content_filter_exclusions',
        'membership_type_site_content_filter_exclusions',
        'book_availability_regions',
        'book_scores',
        'book_external_metadatas',
        'content_filters_v4',
        'CNT_genre_book',
        'publishers'
    ];

    /**
     * Main function that decide which tables to call, and in which order.
     */
    public function process()
    {
        $this->logger->addInfo("*** Processing uniques tables ***");
        foreach ($this->arrTables as $tableName) {
            $this->processTable($tableName);
        }

        $this->logger->addInfo("*** Processing uniques tables done ***");
    }
}