<?php

namespace Aoc2024\Ex17;

use Aoc2024\Main\Exercise;

/**
 * 
 */
class Ex17 extends Exercise
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
