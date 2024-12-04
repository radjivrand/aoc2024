<?php

namespace Aoc2024\Ex04;

use Aoc2024\Main\Exercise;

/**
 * 
 */
class Ex04 extends Exercise
{
    public function __construct()
    {
        $inputArr = $this->getFileContents();
        print_r($this->run($inputArr));
    }

    public function run($arr)
    {
        $horizontal = 0;
        foreach ($arr as $hor) {
            $horizontal += $this->countMatches($hor);
        }

        $splat = [];
        foreach ($arr as $row) {
            $splat[] = str_split($row);
        }

        $verticalArr = [];
        foreach (range(0, count($splat[0]) - 1) as $index) {
            $verticalArr[] = array_column($splat, $index);
        }

        $vertical = 0;
        foreach ($verticalArr as $inner) {
            $vertical += $this->countMatches(implode('', $inner));
        }

        $this->outputArr($arr);

        $res = [];
        foreach ($splat as $rowKey => &$row) {
            foreach ($row as $colKey => &$value) {
                print_r("at: $rowKey, $colKey" . PHP_EOL);

                if ($value != '.') {
                    print_r($value . PHP_EOL);
                    $row[$colKey] = '.';

                    $counter = 1;

                    while (isset($splat[$rowKey - $counter][$colKey + $counter])) {
                        print_r($splat[$rowKey - $counter][$colKey + $counter]);
                        die(PHP_EOL . 'dead 2');



                    }





                }

            }

            // print_r($row);
        }

        die(PHP_EOL . 'dead');

        // print_r($res);

        $slash = [];

        // for ($i= 0; $i < count($splat) - 1; $i++) {
        //     for ($j = 0; $j <= $i; $j++) { 
        //         print_r('i:' . ($i - $j) . ', j: ' . $j);
        //         print_r(PHP_EOL);
        //     }

        //     print_r(PHP_EOL);
        // }

        // print_r($splat);

        // foreach (range(0, count($arr)) as $columnIndex) {
        //     print_r($columnIndex);
        //     $col = array_column($arr, $columnIndex);
        //     $test = preg_match_all('/XMAS|SAMX/', implode('', $col), $matches);
        //     $vertical += count($matches[0]);
        //     print_r($matches[0]);
        //     print_r($col);
        //     // print_r(array_column($arr, $columnIndex));

        // }

        // print_r($vertical);


        // return $arr;
    }

    public function countMatches($inputString)
    {
        preg_match_all('/XMAS|SAMX/', $inputString, $matches);
        return count($matches[0]);
    }

    public function outputArr($arr)
    {
        // print_r($arr);
        foreach ($arr as $row) {
            print_r($row);
            print_r(PHP_EOL);
        }
    }


// 00

// 10 01

// 20 11 02

// 30 21 12 03

// 40 31 22 13 04

// 50 41 32 23 14 05
// 
// 


}
