<?php

namespace Aoc2024\Ex02;

use Aoc2024\Main\Exercise;

/**
 * 288: too low
 */
class Ex02 extends Exercise
{
    public function __construct()
    {
        $inputArr = $this->getFileContents();
        print_r($this->run($inputArr));
    }

    public function run($arr)
    {
        foreach ($arr as &$row) {
            $row = explode(' ', $row);
            if ($row[0] > $row[count($row) - 1]) {
                $row = array_reverse($row);
            }
        }

        $counter = 0;

        // part 1
        // foreach ($arr as $rr) {
        //     if ($this->isSafe($rr)) {
        //         $counter ++;
        //     }
        // }

        // part 2
        foreach ($arr as $line) {
            if ($this->isSafe($line)) {
                $counter++;
            } else {
                foreach ($line as $key => $value) {
                    $temp = $line;
                    unset($temp[$key]);

                    if ($this->isSafe(array_values($temp))) {
                        $counter++;
                        continue 2;
                    }
                }
            }
        }

        return $counter;
    }

    public function isSafe(array $input)
    {
        for ($i=0; $i < count($input) - 1; $i++) {
            if (($input[$i + 1] - $input[$i] < 1) || ($input[$i + 1] - $input[$i] > 3)) {
                return false;
            }
        }

        return true;
    }
}
