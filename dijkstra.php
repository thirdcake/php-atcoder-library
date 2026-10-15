<?php
/**
 * dijkstra ダイクストラ法
 * 
 * スタート地点からの最短距離を求める
 * 負の重みには使えない
 * 
 * @link https://github.com/thirdcake/php-atcoder-library
 * @license CC0-1.0
 */
function dijkstra(array $graph, int $n, int $start) {
	$dist = array_fill(0, $n, PHP_INT_MAX);
	$dist[$start] = 0;
	$que = new SplPriorityQueue();
	$que->insert([0, $start], 0);
	while(!$que->isEmpty()) {
		[$d, $v] = $que->extract();
		if($d > $dist[$v]) {
			continue;
		}
        if(!isset($graph[$v])) continue;
		foreach($graph[$v] as $u => $weight) {
			$newd = $d + $weight;
			if($dist[$u] > $newd) {
				$dist[$u] = $newd;
				$que->insert([$newd, $u], -$newd);
			}
		}
	}
	return $dist;
}


// 使い方
$g = [];
$g[0][1] = 1;
$g[1][0] = 1;
$g[0][2] = 6;
$g[2][0] = 6;
$g[1][2] = 2;
$g[2][1] = 2;
$dist = dijkstra($g, count($g), 0); // 0からの距離
echo implode(' ', $dist).PHP_EOL;


