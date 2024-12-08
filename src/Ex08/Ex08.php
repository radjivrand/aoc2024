<?php

namespace Aoc2024\Ex08;

use Aoc2024\Main\Exercise;

/**
 * 
 */
class Ex08 extends Exercise
{
    public $map = [];
    public $input = [];
    public $locations = [];

    public function __construct()
    {
        $inputArr = $this->getFileContents();
        $this->run($inputArr);
    }

    public function run($arr)
    {
        $this->input = $arr;

        foreach ($arr as $rowkey => $row) {
            foreach (str_split($row) as $colkey => $val) {
                if ($val != '.') {
                    $this->map[$val][] = [$rowkey, $colkey];
                }
            }
        }

        foreach ($this->map as $antenna) {
            $pairs = $this->findPossiblePairs(count($antenna));

            foreach ($pairs as $pair) {
                $first = $antenna[$pair[0]];
                $second = $antenna[$pair[1]];

                $this->addAntinodes($first, $second);
            }
        }

        print_r(count($this->locations));
    }

    public function output($arr)
    {
        foreach ($arr as $line) {
            if (is_array($line)) {
                print_r(implode('', $line));
            } else {
                print_r($line);
            }
            print_r(PHP_EOL);
        }
    }

    public function findPossiblePairs(int $amount)
    {
        $pairs = [];
        for ($i=0; $i < $amount; $i++) {
            for ($j=$i + 1; $j < $amount; $j++) {
                $pairs[] = [$i, $j];
            }
        }

        return $pairs;
    }

    public function addAntinodes($a, $b)
    {
        $diffFirst = [
            $b[0] - $a[0],
            $b[1] - $a[1],
        ];

        $diffSecond = [
            $a[0] - $b[0],
            $a[1] - $b[1],
        ];

        $firstCounter = 0;

        while (true) {
            $firstCounter++;

            $newFirst = [
                $a[0] + $diffFirst[0] * $firstCounter,
                $a[1] + $diffFirst[1] * $firstCounter,
            ];

            $short = implode(':', $newFirst);

            if ($this->isInLimits($newFirst)) {
                $this->locations[$short] = 1;
            } else {
                break;
            }
        }

        $secondCounter = 0;
        while (true) {
            $secondCounter++;

            $newSecond = [
                $b[0] + $diffSecond[0] * $secondCounter,
                $b[1] + $diffSecond[1] * $secondCounter,
            ];

            $short = implode(':', $newSecond);

            if ($this->isInLimits($newSecond)) {
                $this->locations[$short] = 1;
            } else {
                break;
            }
        }
    }

    public function isInLimits($coord)
    {
        return $coord[0] >= 0
            && $coord[0] < strlen($this->input[0])
            && $coord[1] >= 0
            && $coord[1] < count($this->input);
    }
}
