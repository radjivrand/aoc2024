<?php

namespace Aoc2024\Ex10;

use Aoc2024\Main\Exercise;

/**
 * 
 */
class Ex10 extends Exercise
{
    protected array $map;
    protected array $chains;

    public function __construct()
    {
        $inputArr = $this->getFileContents();
        $this->run($inputArr);
    }

    public function run($arr)
    {
        $this->map = array_map('str_split', $arr);

        $starts = $this->findStartingPoints();
        $value = 0;

        foreach ($starts as $point) {
            $result = $this->recursiveNexts($point, $value, []);
        }

        $results = [];

        foreach ($this->chains as $chain) {
            $results[] = $chain[0]['x'] . ':' .  $chain[0]['y'] . '-' . $chain[9]['x'] . ':' . $chain[9]['y'];
        }

        print_r(array_unique($results));
        print_r([count(array_unique($results))]);
        print_r([count($this->chains)]);
    }

    public function recursiveNexts($point, $value, $chain)
    {
        $chain[$value] = $point;

        if ($value == 9) {
            $this->chains[] = $chain;
        }

        $nexts = $this->findNexts($point, $value);

        if (empty($nexts)) {
            return [];
        }

        foreach ($nexts as $point) {
            $this->recursiveNexts($point, $value + 1, $chain);
        }
    }

    public function findStartingPoints()
    {
        $startingPoints = [];

        foreach ($this->map as $rowkey => $row) {
            foreach ($row as $colkey => $value) {
                if ($value == '0') {
                    $startingPoints[] = ['x' => $colkey, 'y' => $rowkey];
                }
            }
        }

        return $startingPoints;
    }

    public function findNexts($point, $val): array
    {
        $places = [];
        $places[] = ['x' => $point['x'], 'y' => $point['y'] - 1];
        $places[] = ['x' => $point['x'], 'y' => $point['y'] + 1];
        $places[] = ['x' => $point['x'] - 1, 'y' => $point['y']];
        $places[] = ['x' => $point['x'] + 1, 'y' => $point['y']];

        $res = [];

        foreach ($places as $place) {
            if (
                $this->inBounds($place)
                && $this->map[$place['y']][$place['x']] == $val + 1
            ) {
                $res[] = $place;
            }
        }

        return $res;
    }

    public function inBounds($point): bool
    {
        $ymax = count($this->map);
        $xmax = count($this->map[0]);

        return $point['x'] < $xmax
            && $point['x'] >= 0
            && $point['y'] < $ymax
            && $point['y'] >= 0;
    }
}
