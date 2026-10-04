<?php
// ## Kahn's algorithm -- Topological Sort
function kahn(array $graph, int $n): array {
    // 昇順以外のソートが必要なら Priority Queue を使う
    // 順番を問わないなら SplQueue にすると log 分速い
    $heap = new SplMinHeap();
    $in_deg = array_fill(0, $n, 0);
    foreach($graph as $i=>$arr) {
        foreach($arr as $j=>$bl) {
            $in_deg[$j] += 1;
        }
    }
    foreach($in_deg as $i=>$cnt) {
        if($cnt===0) {
            $heap->insert($i);
        }
    }
    $result = [];
    while(!$heap->isEmpty()) {
        $now = $heap->extract();
        $result[] = $now;
        if(!isset($graph[$now])) {
            continue;
        }
        foreach($graph[$now] as $next=>$bl) {
            $in_deg[$next] -= 1;
            if($in_deg[$next]===0) {
                $heap->insert($next);
            }
        }
    }
    return $result;
}



// 使い方
$n = 5;
$g = [];
$g[0][1] = true;
$g[0][2] = true;
$g[2][3] = true;
$g[4][2] = true;
$sort = kahn($g, $n);
var_dump('ソート結果： ' . implode(' ', $sort));
if(count($sort)===$n) {
    var_dump('閉路は存在しません');
}else{
    var_dump('閉路が存在します');
}
