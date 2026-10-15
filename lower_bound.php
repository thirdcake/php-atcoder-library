<?php
/**
 * lower bound
 * 
 * ソート済みの配列で、ある値以上の最初の要素のインデックス
 * 
 * @link https://github.com/thirdcake/php-atcoder-library
 * @license CC0-1.0
 */
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

/**
 * upper bound
 * 
 * ソート済みの配列で、ある値より大きい最初の要素のインデックス
 * 
 * @link https://github.com/thirdcake/php-atcoder-library
 * @license CC0-1.0
 */
function upper_bound(array $arr, int $val):int {
    $ng = -1;
    $ok = count($arr);
    while($ok-$ng>1) {
        $mid = intdiv($ng + $ok, 2);
        if($arr[$mid] > $val) {
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

