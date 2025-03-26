<?php

// manacher 
// https://snuke.hatenablog.com/entry/2014/12/02/235837

function manacher (string $str):array {
    $r = [];
    $len = strlen($str);
    $i=0;
    $j=0;
    while($i<$len){
        while(0<=$i-$j && $i+$j<$len && $str[$i-$j]===$str[$i+$j]) {
            $j += 1;
        }
        $r[$i] = $j;
        $k = 1;
        while(0<=$i-$k && $k+$r[$i-$k]<$j) {
            $r[$i+$k] = $r[$i-$k];
            $k += 1;
        }
        $i += $k;
        $j -= $k;
    }
    return $r;
}
function manacherEven(string $str):array {
    $div = '$';  // $strに'$'を含む場合は別の文字列にする
    $str2 = $div;
    $str2 .= implode($div, str_split($str));
    $str2 .= $div;
    $arr = manacher($str2);
    $r = [];
    for($i=1; $i<strlen($str); $i++) {
        $r[] = intdiv($arr[$i*2]-1, 2);
    }
    return $r;
}

// 使い方
$str = 'abaaaababa';
echo implode(' ', str_split($str)).PHP_EOL;
echo implode(' ', manacher($str)).PHP_EOL;

// 偶数の回文abbaが欲しい場合は、manacherEvenを使う
echo implode(' ', str_split($str)).PHP_EOL;
echo ' '.implode(' ', manacherEven($str)).PHP_EOL;


