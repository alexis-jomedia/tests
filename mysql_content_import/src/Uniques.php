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
     * Main function that decide which tables to call, and in which order.
     */
    public function process()
    {
        $this->logger->addInfo("*** Processing uniques tables ***");
        $this->processContentStatus();
        $this->processLicensors();
        $this->processMaLanguage();
        $this->processSites();
        $this->processMediaTypes();
        $this->processSitesMediaTypes();
        $this->processDeviceTypes();
        $this->processSiteContentFilterExclusions();
        $this->processMembershipTypeSiteContentFilterExclusions();
        $this->processBookAvailabilityRegions();
        $this->processBookScores();
        $this->processBookExternalMetadatas();
        $this->logger->addInfo("*** Processing uniques tables done ***");
    }

    /**
     * Process content_status table
     */
    private function processContentStatus()
    {
        $this->logger->addInfo("*** Content_status ***");
        $sql = "SELECT name, date_added, date_updated FROM content_status";
        /** @var \mysqli_result */
        $res = $this->conn->query($sql);
        $this->writeToFile('content_status', $res);
        $this->logger->addInfo("*** Content_status done ***");
    }

    /**
     * Process licensors table
     */
    private function processLicensors()
    {
        $this->logger->addInfo("*** licensors ***");
        $sql = "SELECT * FROM licensors ORDER BY id ASC";
        /** @var \mysqli_result */
        $res = $this->conn->query($sql);
        $this->writeToFile('licensors', $res);
        $this->logger->addInfo("*** licensors done ***");
    }

    /**
     * Process ma_language table
     */
    private function processMaLanguage()
    {
        $this->logger->addInfo("*** ma_language ***");
        $sql = "SELECT * FROM ma_language ORDER BY id ASC";
        /** @var \mysqli_result */
        $res = $this->conn->query($sql);
        $this->writeToFile('ma_language', $res);
        $this->logger->addInfo("*** ma_language done ***");
    }

    /**
     * Process sites table
     */
    private function processSites()
    {
        $this->logger->addInfo("*** sites ***");
        $sql = "SELECT * FROM sites ORDER BY id ASC";
        /** @var \mysqli_result */
        $res = $this->conn->query($sql);
        $this->writeToFile('sites', $res);
        $this->logger->addInfo("*** sites done ***");
    }

    /**
     * Process media_types table
     */
    private function processMediaTypes()
    {
        $this->logger->addInfo("*** media_types ***");
        $sql = "SELECT * FROM media_types";
        /** @var \mysqli_result */
        $res = $this->conn->query($sql);
        $this->writeToFile('media_types', $res);
        $this->logger->addInfo("*** media_types done ***");
    }

    /**
     * Process site_media_types table
     */
    private function processSitesMediaTypes()
    {
        $this->logger->addInfo("*** site_media_types ***");
        $sql = "SELECT * FROM site_media_types";
        /** @var \mysqli_result */
        $res = $this->conn->query($sql);
        $this->writeToFile('site_media_types', $res);
        $this->logger->addInfo("*** site_media_types done ***");
    }

    /**
     * Process device_types table
     */
    private function processDeviceTypes()
    {
        $this->logger->addInfo("*** device_types ***");
        $sql = "SELECT * FROM device_types";
        /** @var \mysqli_result */
        $res = $this->conn->query($sql);
        $this->writeToFile('device_types', $res);
        $this->logger->addInfo("*** device_types done ***");
    }

    /**
     * Process site_content_filter_exclusions table
     */
    private function processSiteContentFilterExclusions()
    {
        $this->logger->addInfo("*** site_content_filter_exclusions ***");
        $sql = "SELECT * FROM site_content_filter_exclusions";
        /** @var \mysqli_result */
        $res = $this->conn->query($sql);
        $this->writeToFile('site_content_filter_exclusions', $res);
        $this->logger->addInfo("*** site_content_filter_exclusions done ***");
    }

    /**
     * Process membership_type_site_content_filter_exclusions table
     */
    private function processMembershipTypeSiteContentFilterExclusions()
    {
        $this->logger->addInfo("*** membership_type_site_content_filter_exclusions ***");
        $sql = "SELECT * FROM membership_type_site_content_filter_exclusions";
        /** @var \mysqli_result */
        $res = $this->conn->query($sql);
        $this->writeToFile('membership_type_site_content_filter_exclusions', $res);
        $this->logger->addInfo("*** membership_type_site_content_filter_exclusions done ***");
    }

    /**
     * Process book_availability_regions table
     */
    private function processBookAvailabilityRegions()
    {
        $this->logger->addInfo("*** book_availability_regions ***");
        $sql = "SELECT * FROM book_availability_regions";
        /** @var \mysqli_result */
        $res = $this->conn->query($sql);
        $this->writeToFile('book_availability_regions', $res);
        $this->logger->addInfo("*** book_availability_regions done ***");
    }

    /**
     * Process book_scores table
     */
    private function processBookScores()
    {
        $this->logger->addInfo("*** book_scores ***");
        $sql = "SELECT * FROM book_scores";
        /** @var \mysqli_result */
        $res = $this->conn->query($sql);
        $this->writeToFile('book_scores', $res);
        $this->logger->addInfo("*** book_scores done ***");
    }

    /**
     * Process book_external_metadatas table
     */
    private function processBookExternalMetadatas()
    {
        $this->logger->addInfo("*** book_external_metadatas ***");
        $sql = "SELECT * FROM book_external_metadatas";
        /** @var \mysqli_result */
        $res = $this->conn->query($sql);
        $this->writeToFile('book_external_metadatas', $res);
        $this->logger->addInfo("*** book_external_metadatas done ***");
    }
}