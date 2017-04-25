<?php

namespace workers;

use Monolog\Logger;


/**
 * Created by PhpStorm.
 * User: alexis
 * Date: 4/24/17
 * Time: 3:12 PM
 */
class Base
{
    /**
     * @var logger
     */
    public $logger;

    /**
     * @var mysqli
     */
    public $conn = null;

    public $limit = null;

    public function __construct($conn, $limit)
    {
        $this->logger = new Logger('mysql_import');
        $this->conn = $conn;
        $this->limit = $limit;
    }

    /**
     * Enclose the given data in quote, for putting the data into a csv file.
     *
     * @param Mixed $data
     * @return string
     */
    public function encloseInQuotes($data)
    {
        $quote = chr(34); // quote " character from ASCII table
        return $quote . addslashes(strval($data)) . $quote;
    }

    /**
     * Common function called by all others to write results to CSV
     *
     * @param string         $fileName
     * @param \mysqli_result $data
     * @return void
     */
    protected function writeToFile($fileName, \mysqli_result $data)
    {
        $fp = fopen($fileName . '.sql', 'w');
        while ($row = $data->fetch_assoc()) {
            $arrValues = [];
            $arrKeys = [];
            foreach ($row as $key => $value) {
                $arrValues[] = $this->encloseInQuotes($value);
                $arrKeys[] = $key;
            }

            $sql = "INSERT INTO $fileName (" . implode(',', $arrKeys) . ") VALUES (";
            $sql .= implode(',', $arrValues) . ');' . PHP_EOL;
            fwrite($fp, $sql);
        }

        fclose($fp);
    }
}