<?php

class UnionFind {
  public $parents;
  public function __construct ($n) {
    $this->parents = range(0, $n - 1);
  }
  public function find ($x) {
    if ($this->parents[$x] === $x) {
      return $x;
    } else {
      $this->parents[$x] = $this->find($this->parents[$x]);
      return $this->parents[$x];
    }
  }
  public function union ($x, $y) {
    $px = $this->find($x);
    $py = $this->find($y);
    if ($px === $py) {
      return;
    }
    $this->parents[$px] = $py;
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

