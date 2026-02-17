<?php
// ## binary trie
// 参考：https://kanpurin.hatenablog.com/entry/2021/09/05/163703
class BinaryTrie {
    public array $nodel;
    public array $noder;
    public array $cnt;
    public int $id = 0;
    public int $bitlen;

    public function __construct(int $max_query=200000, int $bitlen=30) {
        $n = $max_query * $bitlen;
        // $n が 8300000 を超える場合は要注意
        $this.nodel = array_fill(0, $n, -1);
        $this.noder = array_fill(0, $n, -1);
        $this.cnt = array_fill(0, $n, -1);
        $this.bitlen = $bitlen;
    }

    // 要素を挿入
    public function insert(int $x):void {
        $pt = 0;
        for($i=$this.bitlen-1, $i>=0; $i--) {
            $y = ($x>>$i) & 1;

        }
    }

    // k 番目の要素 1-index
    public function kth(int $k):int {
    }

    // x 以上で最小の要素
    public function lower_bound(int $x):int {
    }

    // x より大で最小の要素
    public function upper_bound(int $x):int {
    }
}

