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

    /**
     * @var int|null
     */
    public $limit = null;

    /**
     * Base constructor.
     * @param \mysqli $conn
     * @param int     $limit Number of results, if needed. Default to 1000.
     */
    public function __construct($conn, $limit = 1000)
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

            $sql = "INSERT IGNORE INTO $fileName (" . implode(',', $arrKeys) . ") VALUES (";
            $sql .= implode(',', $arrValues) . ');' . PHP_EOL;
            fwrite($fp, $sql);
        }

        fclose($fp);
    }

    /**
     * Process a given table
     *
     * @param string $tableName Name of the table to process.
     * @param string $options   Specific options to pass to the sql string. Default to empty string.
     */
    protected function processTable($tableName, $options = '')
    {
        $this->logger->addInfo("*** $tableName ***");
        $sql = "SELECT $tableName.* FROM $tableName $options";
        /** @var \mysqli_result */
        $res = $this->conn->query($sql);
        if (!($res instanceof \mysqli_result)) {
            var_dump($sql);
        }
        $this->writeToFile($tableName, $res);
        $this->logger->addInfo("*** $tableName done ***");
    }

    /**
     * go grab up to $limit random IDs for the given table name
     *
     * @param string $tableName Name of the table whose IDs are needed
     * @param string $options   Options to be passed to the query. Default to ''
     * @return array
     */
    protected function getIDs($tableName, $options = '')
    {
        $this->logger->addInfo("*** Movies IDS ***");
        $sql = "SELECT id FROM $tableName $options ORDER BY rand() LIMIT " . $this->limit;
        /** @var \mysqli_result */
        $res = $this->conn->query($sql);
        $return = [];
        while ($row = $res->fetch_assoc()) {
            $return[] = $row['id'];
        }

        $this->logger->addInfo("*** $tableName IDS done ***");
        return $return;
    }
}