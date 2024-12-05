<?php

namespace Aoc2024\Ex05;

use Aoc2024\Main\Exercise;

/**
 * 
 */
class Ex05 extends Exercise
{
    protected array $rules = [];
    protected array $pages = [];

    public function __construct()
    {
        $inputArr = $this->getFileContents();

        $flag = false;

        foreach ($inputArr as $line) {
            if (null == $line) {
                $flag = true;
                continue;
            }

            if (!$flag) {
                $this->rules[] = explode('|', $line);
            } else {
                $this->pages[] = explode(',', $line);
            }
        }

        print_r($this->run());
    }

    public function run()
    {   
        $valid = [];
        $inValid = [];

        foreach ($this->pages as $set) {
            for ($i=0; $i < count($set) - 1; $i++) { 
                if (!$this->isValidPair([$set[$i], $set[$i + 1]])) {
                    $inValid[] = $set;
                    continue 2;
                }
            }

            $valid[] = $set;
        }

        $res = 0;

        // part 2
        foreach ($inValid as $invalidSet) {
            $shuffled[] = $this->checkAndSwitch($invalidSet);
        }

        foreach ($shuffled as $values) {
            $res += $values[(count($values) - 1) / 2];
        }

        // part 1
        // foreach ($valid as $values) {
        //     $res += $values[(count($values) - 1) / 2];
        // }

        return $res;
    }

    public function isValidPair(array $pair): bool
    {
        foreach ($this->rules as $rule) {
            if ($rule[0] == $pair[0] && $rule[1] == $pair[1]) {
                return true;
            }
        }

        return false;
    }

    public function checkAndSwitch($arr)
    {
        for ($i=0; $i < count($arr) - 1; $i++) { 
            if (!$this->isValidPair([$arr[$i], $arr[$i + 1]])) {
                $temp = $arr[$i];
                $arr[$i] = $arr[$i + 1];
                $arr[$i + 1] = $temp;

                return $this->checkAndSwitch($arr);
            }
        }

        return $arr;
    }
}
