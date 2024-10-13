<?php

function next_permutation(array $arr, int $n): Generator {
    while (true) {
        yield $arr;
        $target = -1;
        for ($i = $n - 2; $i >= 0; $i--) {
            if ($arr[$i] < $arr[$i + 1]) {
                $target = $i;
                break;
            }
        }
        if ($target == -1) {
            return;
        }

        for ($i = 0; $target + 1 + $i < $n - 1 - $i; $i++) {
            $temp = $arr[$target + 1 + $i];
            $arr[$target + 1 + $i] = $arr[$n - 1 - $i];
            $arr[$n - 1 - $i] = $temp;
        }
        for ($j = $target + 1; $j < $n; $j++) {
            if ($arr[$j] > $arr[$target]) {
                $temp = $arr[$j];
                $arr[$j] = $arr[$target];
                $arr[$target] = $temp;
                break;
            }
        }
    }
}

// 使い方
$arr = range(1,10);
$n = count($arr);
$ans = 0;
foreach (next_permutation($arr, $n) as $perm) {
    $ans += 1;
}

echo ($ans === (int) gmp_fact(10))?'true':'false' . PHP_EOL;


