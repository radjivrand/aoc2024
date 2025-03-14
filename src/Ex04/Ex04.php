<?php

namespace Aoc2024\Ex04;

use Aoc2024\Main\Exercise;

/**
 * part 2: 1885, too low
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
        $splat = [];
        foreach ($arr as $row) {
            $splat[] = str_split($row);
        }

        $score = 0;

        for ($i=1; $i < count($splat) - 1; $i++) { 
            for ($j=1; $j < count($splat[0]) - 1; $j++) {
                $subject = $splat[$i - 1][$j - 1] . $splat[$i - 1][$j + 1] . $splat[$i + 1][$j - 1] . $splat[$i + 1][$j + 1];

                if ($this->hasXmas($subject) && $splat[$i][$j] == 'A') {
                    $score++;
                }
            }
        }

        print_r($score . PHP_EOL);

    }

    public function hasXmas($str)
    {
        return in_array($str, ['SSMM', 'MSMS', 'MMSS', 'SMSM']);
    }


    public function runPartOne($arr)
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

        $originalSplat = $splat;

        $backslash = [];
        foreach ($splat as $rowKey => &$row) {
            foreach ($row as $colKey => &$value) {
                if ($value != '.') {
                    $diagonal = [];
                    $diagonal[] = $value;
                    $row[$colKey] = '.';

                    $counter = 1;

                    while (isset($splat[$rowKey + $counter][$colKey + $counter])) {
                        $diagonal[] = $splat[$rowKey + $counter][$colKey + $counter];
                        $splat[$rowKey + $counter][$colKey + $counter] = '.';
                        $counter++;
                    }

                    $backslash[] = $diagonal;
                }
            }
        }

        $backslashScore = 0;
        foreach ($backslash as $brow) {
            $backslashScore += $this->countMatches(implode('', $brow));
        }

        $splat = $originalSplat;

        $slash = [];
        foreach ($splat as $rowKey => &$row) {
            foreach ($row as $colKey => &$value) {
                if ($value != '.') {
                    $diagonal = [];
                    $diagonal[] = $value;
                    $row[$colKey] = '.';

                    $counter = 1;

                    while (isset($splat[$rowKey + $counter][$colKey - $counter])) {
                        $diagonal[] = $splat[$rowKey + $counter][$colKey - $counter];
                        $splat[$rowKey + $counter][$colKey - $counter] = '.';
                        $counter++;
                    }

                    $slash[] = $diagonal;
                }
            }
        }

        $slashScore = 0;
        foreach ($slash as $srow) {
            $slashScore += $this->countMatches(implode('', $srow));
        }

        return $horizontal + $vertical + $backslashScore + $slashScore;
    }

    public function countMatches($inputString)
    {
        preg_match_all('/(?=XMAS|SAMX)/', $inputString, $matches);
        return count($matches[0]);
    }

    public function outputArr($arr)
    {
        foreach ($arr as $row) {
            print_r(is_array($row) ? implode('', $row) : $row);
            print_r(PHP_EOL);
        }
    }
}
