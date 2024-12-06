<?php

namespace Aoc2024\Ex10;

use Aoc2024\Main\Exercise;

/**
 * 
 */
class Ex10 extends Exercise
{
    public function __construct()
    {
        $inputArr = $this->getFileContents();
        print_r($this->run($inputArr));
    }

    public function run($arr)
    {
        return $arr;
    }
}
