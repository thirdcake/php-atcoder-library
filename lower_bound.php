<?php
// ## lower_bound(ソート済みのときのみ利用可)
function lower_bound(array $arr, int $val):int {
    $ng = -1;
    $ok = count($arr);
    while($ok-$ng>1) {
        $mid = intdiv($ng + $ok, 2);
        if($arr[$mid] >= $val) {
            // upper にしたいときは >= を > に変える
            $ok = $mid;
        }else{
            $ng = $mid;
        }
    }
    return $ok;
}

// 実行例(LIS/最長増加部分列)
$arr = [2, 3, 1, 6, 4, 5];
$ans = [];
foreach($arr as $ai) {
    $lb = lower_bound($ans, $ai);
    $ans[$lb] = $ai;
}
echo count($ans).PHP_EOL;  // 2,3,4,5 が最長となり、4が答え

