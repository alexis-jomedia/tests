<?php


/**
 * Created by PhpStorm.
 * User: alexis
 * Date: 4/24/17
 * Time: 3:12 PM
 */
class Base
{
    /**
     * @var mysqli
     */
    public $conn = null;

    public $limit = null;

    public function __construct($conn, $limit)
    {
        $this->conn = $conn;
        $this->limit = $limit;
    }
}