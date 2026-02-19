<?php
// ## segment tree
class SegmentTree {
    public array $tree;
    public int $n;
    public Closure $func;
    public mixed $e;
    public function __construct (array $arr, Closure $func, mixed $e) {
        $this->func = $func;
        $this->e = $e;
        $size = count($arr);

        $this->n = 1;
        while($this->n < $size) {
            $this->n <<= 1;
        }
        // tree も 0-index
        $this->tree = array_fill(0, 2 * $this->n, $this->e);
        for($i=0; $i<$size; $i++) {
            $this->tree[$this->n - 1 + $i] = $arr[$i];
        }
        for($i=$this->n-2; $i>=0; $i--) {
            $this->tree[$i] = ($this->func)(
                $this->tree[2*$i+1],
                $this->tree[2*$i+2]
            );
        }
    }
    public function update(int $idx, mixed $x):void {
        $idx += $this->n - 1;
        $this->tree[$idx] = $x;
        while($idx > 0) {
            $idx = intdiv($idx - 1, 2);
            $this->tree[$idx] = ($this->func)(
                $this->tree[2*$idx+1],
                $this->tree[2*$idx+2]
            );
        }
    }
    // [$a, $b) 半開区間であることに注意する
    public function query(int $a, int $b): mixed {
        return $this->query_recurse($a, $b, 0, 0, $this->n);
    }
    private function query_recurse(int $a, int $b, int $k, int $l, int $r): mixed {
        if($r <= $a || $b <= $l) {
            return $this->e;
        }elseif($a <= $l && $r <= $b) {
            return $this->tree[$k];
        }else{
            $mid = intdiv($l + $r, 2);
            $ar = $this->query_recurse($a, $b, 2 * $k + 1, $l, $mid);
            $br = $this->query_recurse($a, $b, 2 * $k + 2, $mid, $r);
            return ($this->func)($ar, $br);
        }
    }
}

// 使い方 - min がほしい場合
$arr = [1, 4, 9, -1];
$func = fn(int $a, int $b) => min($a, $b);
$e = PHP_INT_MAX;
$seg = new SegmentTree($arr, $func, $e);
$seg->update(3, 5);
echo 'seg 木: '.$seg->query(1, 3).PHP_EOL;



