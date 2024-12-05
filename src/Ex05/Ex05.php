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

        $this->run();
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

        // part 1
        // $res = 0;

        // foreach ($valid as $values) {
        //     $res += $values[(count($values) - 1) / 2];
        // }

        // print_r($inValid);

        sort($this->rules);
        print_r($this->rules);

        // return $res;
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
}
