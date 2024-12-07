<?php

namespace Aoc2024\Ex06;

use Aoc2024\Main\Exercise;

/**
 * 
 */
class Ex06 extends Exercise
{
    public $map = [];
    public function __construct()
    {
        $inputArr = $this->getFileContents();
        $this->run($inputArr);
    }

    public function run($arr)
    {
        foreach ($arr as $line) {
            $this->map[] = str_split($line);
        }

        $guardLocation = $this->findGuard();
        $next = [$this->findGuard(), '^'];

        $visited = [];
        $visited[$guardLocation[0] . ':' . $guardLocation[1]] = 'x';

        while ($next) {
            $next = $this->findNextLocation($next);
            if ($next) {
                $visited[$next[0][0] . ':' . $next[0][1]] = 'x';
            }
        }

        array_shift($visited);

        // part 2
        $failCounter = [];

        foreach ($visited as $key => $value) {
            $coords = explode(':', $key);
            $this->map[$coords[0]][$coords[1]] = '#';

            $revisited = [];
            $revisited[$guardLocation[0] . ':' . $guardLocation[1]] = 'x';
            $next = [$this->findGuard(), '^'];

            $loopCounter = 0;

            while ($next) {
                $coords = explode(':', $key);

                $next = $this->findNextLocation($next);

                if ($loopCounter > 10000) {
                    $next = false;
                    $failCounter[] = $key;
                }

                if ($next) {
                    $revisited[$next[0][0] . ':' . $next[0][1]] = 'x';
                }

                $loopCounter++;
            }

            $this->map[$coords[0]][$coords[1]] = '.';
        }

        print_r(count($failCounter));
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

    public function findGuard()
    {
        foreach ($this->map as $rowKey => $row) {
            foreach ($row as $colKey => $place) {
                if ($place == '^') {
                    return [$rowKey, $colKey];
                }
            }
        }
    }

    public function findNextLocation(array $curLoc)
    {
        switch ($curLoc[1]) {
            case '^':
                $newLocation = [$curLoc[0][0] - 1, $curLoc[0][1]];
                break;
            
            case '>':
                $newLocation = [$curLoc[0][0], $curLoc[0][1] + 1];
                break;
            
            case 'v':
                $newLocation = [$curLoc[0][0] + 1, $curLoc[0][1]];
                break;
            
            case '<':
                $newLocation = [$curLoc[0][0], $curLoc[0][1] - 1];
                break;
            
            default:
                break;
        }

        if (!isset($this->map[$newLocation[0]][$newLocation[1]])) {
            return false;
        }

        if ($this->map[$newLocation[0]][$newLocation[1]] == '#') {
            return $this->findNextLocation(
                [
                    [
                        $curLoc[0][0],
                        $curLoc[0][1]
                    ],
                    $this->getNextDirection($curLoc[1])
                ]
            );
        }

        return [$newLocation, $curLoc[1]];
    }

    public function getNextDirection(string $dir)
    {
        $dirs = ['^', '>', 'v', '<'];
        $index = array_search($dir, $dirs);

        if ($index == 3) {
            return $dirs[0];
        }

        return $dirs[$index + 1];
    }
}
