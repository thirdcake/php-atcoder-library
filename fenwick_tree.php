<?php
// Fenwick Tree
class Fenwick {
    public array $tree;
    public int $size;

    public function __construct(int $n) {
        $this->size = $n;
        $this->tree = array_fill(0, $n, 0);
    }
	// $index は、0-index
    public function add(int $index, int $value): void {
        for ($i=$index; $i<$this->size; $i|=$i + 1) {
            $this->tree[$i] += $value;
        }
    }
	// [0, $a) の区間和。0-index, 0は含む、$aは含まない
	// [$a, $b) は、$this->sum($b) - $this->sum($a);
    public function sum(int $a): int {
		$sum = 0;
        for($i=$a-1; $i>=0; $i=($i & ($i+1))-1) {
            $sum += $this->tree[$i];
        }
        return $sum;
    }
}


// 使い方
$fen = new Fenwick(5);
$fen->add(0, 1);
$fen->add(1, 1);
$fen->add(2, 1);
$fen->add(3, 1);
$fen->add(4, 1);
echo '[1, 1, 1, 1, 1], 0-index'.PHP_EOL;
echo '[0,1)の和: '. $fen->sum(1).PHP_EOL;
echo '[0,2)の和: '. $fen->sum(2).PHP_EOL;
echo '[0,4)の和: '. $fen->sum(4).PHP_EOL;
echo '[0,5)の和: '. $fen->sum(5).PHP_EOL;

