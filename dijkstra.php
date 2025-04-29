<?php
// ## dijkstra
function dijkstra(array $graph, int $start) {
	$dist = array_fill(0, count($graph), PHP_INT_MAX);
	$dist[$start] = 0;
	$que = new SplPriorityQueue();
	$que->insert([0, $start], 0);
	while(!$que->isEmpty()) {
		[$d, $v] = $que->extract();
		if($d > $dist[$v]) {
			continue;
		}
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
$dist = dijkstra($g, 0); // 0からの距離
echo implode(' ', $dist).PHP_EOL;


