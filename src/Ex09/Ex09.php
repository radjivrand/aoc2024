<?php

namespace Aoc2024\Ex09;

use Aoc2024\Main\Exercise;

/**
 * 
 */
class Ex09 extends Exercise
{
    public $firstDotLeft = 0;
    public $lastNumberRight = 0;
    public $unpacked = [];
    public $res = [];

    public function __construct()
    {
        $inputArr = $this->getFileContents();
        print_r($this->run($inputArr));
    }

    public function run($arr)
    {
        $splat = str_split($arr[0]);

        foreach ($splat as $key => $value) {
            for ($i=0; $i < $value; $i++) { 
                $this->unpacked[] = $key % 2 == 0 ? $key / 2 : '.';
            }
        }
        $this->lastNumberRight = count($this->unpacked) - 1;

        while (!empty($this->unpacked)) {
            $first = array_shift($this->unpacked);
            if ($first == '.') {
                $last = array_pop($this->unpacked);

                while ($last == '.') {
                    $last = array_pop($this->unpacked);
                }

                $this->res[] = $last;
                continue;
            }

            $this->res[] = $first;
        }

        $checksum = 0;

        foreach ($this->res as $key => $val) {
            $checksum += $key * $val;
        }

        print_r($checksum);
    }
}
