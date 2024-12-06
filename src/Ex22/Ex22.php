<?php

namespace Aoc2024\Ex22;

use Aoc2024\Main\Exercise;

/**
 * 
 */
class Ex22 extends Exercise
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
