<?php
// ## lazy segment tree
class LazySegTree {
    public array $tree;
    public array $lazy;
    public int $n;

    public Closure $func;
    public mixed $e;
    public Closure $mapping;
    public Closure $comp;
    public mixed $id;

    public function __construct(
        array $arr,
        Closure $func,
        mixed $e,
        Closure $mapping,
        Closure $comp,
        mixed $id
    ) {
        $this->func = $func;
        $this->e = $e;
        $this->mapping = $mapping;
        $this->comp = $comp;
        $this->id = $id;

        $size = count($arr);
        $this->n = 1;
        while($this->n < $size) {
            $this->n <<= 1;
        }

        $this->tree = array_fill(0, 2*$tihs->n, $this->e);
        $this->lazy = array_fill(0, 2*$this->n, $this->id);

        for($i=0; $i<$size; $i++) {
            $this->tree[$this->n-1+$i] = $arr[$i];
        }
        for($i=$this->n-2; $i>=0; $i--) {
            $this->tree[$i] = ($this->func)(
                $this->tree[2*$i+1],
                $this->tree[2*$i+2],
            );
        }
    }

    private function eval(int $k, int $l, int $r): void {
        if($this->lazy[$k] === $this->id) {
            return;
        }
        $this->tree[$k] = ($this->mapping)($this->lazy[$k], $this->tree[$k], $r-$l);
        if($r-$l > 1) {
            $this->lazy[2*$k+1] = ($this->comp)($this->lazy[$k], $this->lazy[2*$k+1]);
            $this->lazy[2*$k+2] = ($this->comp)($this->lazy[$k], $this->lazy[2*$k+2]);
        }
        $this->lazy[$k] = $this->id;
    }

    // [$a, $b) への更新であることに注意する
    public function update(int $a, int $b mixed $x):void {
        $this->update_recurse($a, $b, $x, 0, 0, $this->n);
    }

    private function update_recurse(int $a, int $b, mixed $x, int $k, int $l, int $r): void {
        $this->eval($k, $l, $r);

        if($r <= $a || $b <= $l) {
            return;
        }

        if($a <= $l && $r <= $b) {
            $this->lazy[$k] = ($this->comp)($x, $this->lazy[$k]);
            $this->eval($k, $l, $r);
        } else {
            $mid = intdiv($l + $r, 2);
            $this->update_recurse($a, $b, $x, 2*$k+1, $l, $mid);
            $this->update_recurse($a, $b, $x, 2*$k+2, $mid, $r);
            $this->tree[$k] = ($this->func)($this->tree[2*$k+1], $this->tree[2*$k+2]);
        }
    }

    // [$a, $b) 半開区間であることに注意する
    public function query(int $a, int $b): mixed {
        return $this->query_recurse($a, $b, 0, 0, $this->n);
    }
    private function query_recurse(int $a, int $b, int $k, int $l, int $r): mixed {
        $this->eval($k, $l, $r);

        if($r <= $a || $b <= $l) {
            return $this->e;
        }
        if($a <= $l && $r <= $b) {
            return $this->tree[$k];
        }
        $mid = intdiv($l + $r, 2);
        $ar = $this->query_recurse($a, $b, 2 * $k + 1, $l, $mid);
        $br = $this->query_recurse($a, $b, 2 * $k + 2, $mid, $r);
        return ($this->func)($ar, $br);
    }
}

// ## 使い方

