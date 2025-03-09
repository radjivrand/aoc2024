<?php

namespace Aoc2024\Ex11;

use Aoc2024\Main\Exercise;

/**
 * 
 */
class Ex11 extends Exercise
{
    protected array $stones;
    protected array $mem;

    public function __construct()
    {
        $inputArr = $this->getFileContents();
        $this->run($inputArr[0]);
    }

    public function run($arr)
    {
        $start = microtime(true);

        $this->stones = explode(' ', $arr);

        foreach (range(1, 20) as $blink) {
            $this->blink();
        }

        $end = microtime(true);

        print_r($this->stones);
        print_r([
            'result' => count($this->stones),
            'elapsed' => round(($end - $start), 3),
        ]);
    }

    public function blink()
    {
        $newStones = [];

        foreach ($this->stones as $stone) {
            if (isset($this->mem[$stone])) {
                $newStones = array_merge($newStones, $this->mem[$stone]);
                continue;
            }

            $newStone = null;

            if ($stone == 0) {
                $newStone = [1];
            } elseif (strlen((string)($stone)) % 2 == 0) {
                [$a, $b] = str_split((string)($stone), strlen((string)($stone)) / 2);
                $newStone = [(int)$a, (int)($b)];
            } else {
                $newStone = [$stone * 2024];
            }

            $newStones = array_merge($newStones, $newStone);
            $this->mem[$stone] = $newStone;
        }

        $this->stones = $newStones;
    }
}
