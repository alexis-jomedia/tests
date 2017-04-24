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
    public function process()
    {

        echo "\n\ninside the job\n\n\n";
    }
}