<?php

// Fenwick Tree
class Fenwick {
    public array $tree;
    public int $size;

    public function __construct(int $n) {
        $this->size = $n;
        $this->tree = array_fill(0, $n + 1, 0);
    }

    public function add(int $index, int $value): void {
        for ($i=$index; $i<$this->size; $i+=($i & -$i)) {
            $this->tree[$i] += $value;
        }
    }

    public function sum(int $index): int {
        $sum = 0;
        for($i=$index; $i>0; $i-=($i & -$i)) {
            $sum += $this->tree[$i];
        }
        return $sum;
    }
}


// 使い方
$fen = new Fenwick(5);
$fen->add(1, 1);
$fen->add(2, 1);
$fen->add(3, 1);
$fen->add(4, 1);
echo $fen->sum(1).PHP_EOL;
echo $fen->sum(2).PHP_EOL;
echo $fen->sum(3).PHP_EOL;
echo $fen->sum(4).PHP_EOL;

