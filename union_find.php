<?php
// union find
class UnionFind {
    public array $parents;
    public array $size;
    public function __construct (int $n) {
        $this->parents = range(0, $n - 1);
        $this->size = array_fill(0, $n, 1);
    }
    public function find (int $x): int {
        if ($this->parents[$x] === $x) {
            return $x;
        } else {
            $this->parents[$x] = $this->find($this->parents[$x]);
            return $this->parents[$x];
        }
    }
    public function union (int $x, int $y):void {
        $px = $this->find($x);
        $py = $this->find($y);
        if ($px === $py) {
            return;
        }
        if($this->size[$px] < $this->size[$py]) {
            $this->parents[$px] = $py;  // $pyが親になる
            $this->size[$py] = $this->size[$px];
        } else {
            $this->parents[$py] = $px;
            $this->size[$px] = $this->size[$py];
        }
    }
    public function getsize(int $x): int {
        $px = $this->find($x);
        return $this->size[$px];
    }
}

// 使い方
$li = [0, 1, 2, 3, 4];
$uf = new UnionFind(count($li));
var_dump($uf->parents);
$uf->union(0, 3);
var_dump($uf->parents);
$uf->union(0, 1);
var_dump($uf->parents);
$uf->union(1, 2);
var_dump($uf->parents);
$uf->find(3);
var_dump($uf->parents);

