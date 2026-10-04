<?php
// ## Strongly connected component -- 強連結成分分解
class Scc {
    public int $size = -1;
    private int $n;
    private array $edges = [];

    public function __construct(int $n) {
        $this->n = $n;
        $this->edges = array_fill(0, $n, []);
    }
    
    public function add_edge(int $from, int $to): void {
        $this->edges[$from][] = $to;
    }

    public function scc(): array {
        $groups = [];
        $now = 0;
        $ord = array_fill(0, $this->n, -1);
        $min = array_fill(0, $this->n, -1);
        $visited = [];
        $visited_flag = array_fill(0, $this->n, false);

        $dfs = function(int $v) use (&$dfs, &$now, &$ord, &$min, &$visited, &$visited_flag, &$groups): void {
            $ord[$v] = $now;
            $min[$v] = $now;
            $now += 1;
            $visited[] = $v;
            $visited_flag[$v] = true;

            foreach($this->edges[$v] as $to) {
                if($ord[$to]===-1) {
                    $dfs($to);
                    $min[$v] = min($min[$v], $min[$to]);
                }elseif($visited_flag[$to]){
                    $min[$v] = min($min[$v], $ord[$to]);
                }
            }

            if($min[$v]===$ord[$v]) {
                $group = [];
                while(true) {
                    $u = array_pop($visited);
                    $visited_flag[$u] = false;
                    $group[] = $u;
                    if($u===$v) {
                        break;
                    }
                }
                sort($group);
                $groups[] = $group;
            }
        };

        for($i=0; $i<$this->n; $i++) {
            if($ord[$i]===-1) {
                $dfs($i);
            }
        }
        $groups = array_reverse($groups);
        $this->size = count($groups);

        return $groups;
    }
}



// 使い方
$n = 6;
$g = [];
// [0,3) は強連結成分
$g[0][1] = true;
$g[1][2] = true;
$g[2][0] = true;

// [3,4) は強連結成分(2-3, 3-4をつなぐだけ)
$g[2][3] = true;
$g[3][4] = true;

// [4,6)は強連結成分
$g[4][5] = true;
$g[5][4] = true;

$scc = new Scc($n);
foreach($g as $u=>$gu) {
    foreach($gu as $v=>$bl) {
        $scc->add_edge($u, $v);
    }
}
$result = $scc->scc();
var_dump($scc->size);  // 3
var_dump($result);  // [[0,1,2],[3],[4,5]]



