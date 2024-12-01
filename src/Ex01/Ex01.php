<?php

namespace Aoc2024\Ex01;

use Aoc2024\Main\Exercise;

/**
 * 
 */
class Ex01 extends Exercise
{
    public function __construct()
    {
        $inputArr = $this->getFileContents();
        print_r($this->run($inputArr));
    }

    public function run($arr)
    {
        $left = [];
        $right = [];
        foreach ($arr as $key => $value) {
            $res = preg_split('/\s+/', $value);
            $left[] = $res[0];
            $right[] = $res[1];
        }

        sort($left);
        sort($right);

        $sum = 0;

        // part 1
        // foreach ($left as $key => $value) {
        //     $sum += abs($value - $right[$key]);
        // }

        // return $sum;

        // part 2
        $leftHistogram = [];
        foreach ($left as $value) {
            if (!isset($leftHistogram[$value])) {
                $leftHistogram[$value] = 1;
            } else {
                $leftHistogram[$value] +=1;
            }
        }

        $rightHistogram = [];
        foreach ($right as $value) {
            if (!isset($rightHistogram[$value])) {
                $rightHistogram[$value] = 1;
            } else {
                $rightHistogram[$value] +=1;
            }
        }

        $intersect = array_intersect(array_keys($leftHistogram), array_keys($rightHistogram));

        foreach ($intersect as $value) {
            $sum += $value * $leftHistogram[$value] * $rightHistogram[$value];
        }

        return $sum;
    }
}
