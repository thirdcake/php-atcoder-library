<?php
// ## warshall floyd
function warshall_floyd(array $dist):array {
    $len = count($dist);
    for($mid=0; $mid<$len; $mid++) {  // 中間点
        for($st=0; $st<$len; $st++) {  // start
            for($te=0; $te<$len; $te++) {  // terminal
                $dist[$st][$te] = min($dist[$st][$te], $dist[$st][$mid]+$dist[$mid][$te]);
            }
        }
    }
    return $dist;
}

// ## 使い方
$dist = [];
$n = 5;
for($i=0; $i<$n; $i++) {
    for($j=0; $j<$n; $j++) {
        if($i===$j) {
            $dist[$i][$j] = 0;
        }else {
            $dist[$i][$j] = PHP_INT_MAX;
        }
    }
}
$dist[1][3] = $dist[3][1] = 5;
$dist[1][2] = $dist[2][1] = 4;
$dist[0][4] = $dist[4][0] = 2;
$dist = warshall_floyd($dist);
var_dump($dist);
