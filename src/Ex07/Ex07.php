<?php

namespace Aoc2024\Ex07;

use Aoc2024\Main\Exercise;

/**
 * 
 */
class Ex07 extends Exercise
{
    public array $eqs = [];

    public function __construct()
    {
        $inputArr = $this->getFileContents();
        print_r($this->run($inputArr));
    }

    public function run($arr)
    {
        foreach ($arr as $line) {
            $splat = preg_split('/(:?\s)/', $line);
            $index = $splat[0];
            array_shift($splat);
            $this->eqs[$index] = $splat;
        }

        $calibration = 0;
        foreach ($this->eqs as $result => $values) {
            if ($this->findResultWithValues($result, $values)) {
                $calibration += $result;
            }
        }

        return $calibration;
    }

    public function findResultWithValues($result, $values): bool
    {
        $possibilities = $this->getOperatorOptions($values);

        foreach ($possibilities as $operators) {
            $product = $values[0];

            foreach (str_split($operators) as $key => $sign) {
                eval('$product = $product' . $sign . $values[$key + 1] . ';');

                if ($product > $result) {
                    continue 2;
                }
            }

            if ($result == $product) {
                return true;
            }
        }


        return false;
    }

    public function getOperatorOptions($values)
    {
        $amount = 2 ** (count($values) - 1);
        $len = base_convert($amount, 10, 2);

        $options = [];

        for ($i=0; $i < $amount; $i++) {
            $val = base_convert($i, 10, 2);
            $options[] = str_pad($val, strlen($len - 1), '0', STR_PAD_LEFT);
        }

        foreach ($options as &$option) {
            $option = str_replace(['0' , '1'], ['+', '*'], $option);
        }

        return $options;
    }
}
