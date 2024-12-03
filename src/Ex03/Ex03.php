<?php

namespace Aoc2024\Ex03;

use Aoc2024\Main\Exercise;

/**
 * too low: 26922215
 */
class Ex03 extends Exercise
{
    public function __construct()
    {
        $inputArr = $this->getFileContents();
        print_r($this->run($inputArr));
    }

    public function run($arr)
    {
        $str = implode('', $arr);

        // part 1
        $res = $this->getMultipliedFrom($str);

        // part 2
        $res = 0;

        preg_match_all('/(?:do\(\))|(?:don\'t\(\))/', $str, $dosAndDonts);
        $splat = preg_split('/(?:do\(\))|(?:don\'t\(\))/', $str);

        array_unshift($dosAndDonts[0], 'do()');

        foreach ($dosAndDonts[0] as $key => $value) {
            if ('do()' == $value) {
                $res += $this->getMultipliedFrom($splat[$key]);
            }
        }

        return $res;
    }

    public function getMultipliedFrom($inputString)
    {
        $res = 0;

        preg_match_all('/mul\(\d+,\d+\)/m', $inputString, $matches);

        foreach ($matches[0] as $match) {
            preg_match_all('/(\d+),(\d+)/', $match, $numbers);
            $res += ($numbers[1][0] * $numbers[2][0]);
        }

        return $res;
    }
}
