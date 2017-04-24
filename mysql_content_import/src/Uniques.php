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
    public function process()
    {
        echo "\n\n*** Processing uniques tables ***\n\n";
        $this->processLicensors();
        $this->processMaLanguage();
        $this->processSites();
        $this->processSiteContentFilterExclusions();
        $this->processMembershipTypeSiteContentFilterExclusions();
        $this->processBookAvailabilityRegions();
        $this->processBookScores();
        $this->processBookExternalMetadatas();
    }

    private function processLicensors()
    {
        echo "*** Licensors ***\n";
        $sql = "SELECT id,name,days_in_trial,status,media_type,is_public,is_on_mobile,contract_start,contract_end, ";
        $sql .= " contract_under,term, renewal_process, notes, reminder_delay, items_in_contract ";
        $sql .= " FROM licensors ORDER BY id ASC";
        $res = $this->conn->query($sql);
        $csv = fopen('licensors.csv', 'w');
        foreach ($data as $res->fetch_array()) {
            fputcsv($csv, $data);
        }

        fclose($csv);
        echo "*** Licensors done ***\n\n\n";
    }
}