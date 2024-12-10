<?php

namespace Aoc2024\Ex09;

use Aoc2024\Main\Exercise;

/**
 * 
 */
class Ex09 extends Exercise
{
    public $unpacked = [];
    public $res = [];
    public $short = [];

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

        $index = 0;

        while ($index < count($this->unpacked)) {
            $new = $this->getNextGroup($index);
            $this->short[] = $new;
            $index += $new['counter'];
        }

        $unvisited = [];

        foreach ($this->short as $value) {
            if ($value['val'] != '.') {
                array_unshift($unvisited, $value);
            }
        }

        $elem = $unvisited[0];

        while (!empty($unvisited)) {
            $element = array_shift($unvisited);
            $elementIndex = array_search($element, $this->short);

            print_r($elementIndex . PHP_EOL);

            $newIndex = $this->findSpace($element, $elementIndex);

            if ($newIndex) {
                $this->swapPlaces($newIndex, $elementIndex);
            }
        }

        $this->res = [];

        foreach ($this->short as $value) {
            for ($i=0; $i < $value['counter']; $i++) { 
                $this->res[] = $value['val'];
            }
        }

        // part 1
        // while (!empty($this->unpacked)) {
        //     $first = array_shift($this->unpacked);
        //     if ($first == '.') {
        //         $last = array_pop($this->unpacked);

        //         while ($last == '.') {
        //             $last = array_pop($this->unpacked);
        //         }

        //         $this->res[] = $last;
        //         continue;
        //     }

        //     $this->res[] = $first;
        // }

        $checksum = 0;

        foreach ($this->res as $key => $val) {
            if (is_int($val)) {
                $checksum += $key * $val;
            }
        }

        print_r($checksum);
    }

    public function findSpace($element, $currentIndex)
    {
        foreach ($this->short as $key => $value) {
            if ($key >= $currentIndex) {
                return false;
            }

            if ($value['val'] == '.' && $value['counter'] >= $element['counter']) {
                return $key;
            }
        }

        return false;
    }

    public function swapPlaces($dotIndex, $numberIndex)
    {
        $dots = $this->short[$dotIndex];
        $numbers = $this->short[$numberIndex];

        $dotCount = $dots['counter'];
        $numCount = $numbers['counter'];
        $number = $numbers['val'];

        $this->short[$numberIndex]['val'] = '.';
        $this->short[$dotIndex]['val'] = $number;
        $this->short[$dotIndex]['counter'] = $numCount;

        if ($dotCount > $numCount) {
            $diff = $dotCount - $numCount;

            $newElement = [
                'val' => '.',
                'counter' => $diff,
            ];
    
            $firstPart = array_slice($this->short, 0, $dotIndex + 1);
            $secondPart = array_slice($this->short, $dotIndex + 1);
            $this->short = array_merge($firstPart, [$newElement], $secondPart);
        }

        $this->cleanup();
    }

    public function cleanup()
    {
        $new = [];

        while (!empty($this->short)) {
            $current = array_shift($this->short);

            if (empty($new)) {
                $new[] = $current;
            } else {
                $lastIndex = array_key_last($new);

                if ($new[$lastIndex]['val'] == '.' && $current['val'] == '.') {
                    $new[$lastIndex]['counter'] += $current['counter'];

                } else {
                    $new[] = $current;
                }
            }
        }

        $this->short = $new;
    }

    public function getNextGroup($index)
    {
        $counter = 1;
        while (true) {
            if (
                !isset($this->unpacked[$index + $counter])
                || $this->unpacked[$index + $counter] != $this->unpacked[$index]
            ) {
                break;
            }

            $counter++;
        }

        return [ 
            'val' => $this->unpacked[$index],
            'counter' => $counter,
        ];
    }

    public function output()
    {
        foreach ($this->short as $key => $value) {
            print_r($value['counter'] . ' x ' . $value['val']);
            print_r(PHP_EOL);
        }
    }
}
