<?php
// ## AVL Tree
class AVL {
    public array $nodes;
    public string|null $root;
    public function __construct() {
        $this->nodes = [];
        $this->root = null;
    }
    private function create_node(int $num, string|null $parent=null):void {
        $index = 'n'.$num;
        $this->nodes[$index] = [
            $parent,  // 0 => parent index {string|null}
            null,     // 1 => left child index {string}
            null,     // 2 => right child index {string}
            $num,     // 3 => num {int}
            1,        // 4 => height {int}
        ];
        if($parent===null) {
            $this->root = $index;
        }else{
            $parent_node = $this->nodes[$parent];
            if($num < $parent_node[3]) {
                $this->nodes[$parent][1] = $index;
            }else{
                $this->nodes[$parent][2] = $index;
            }
        }
    }
    public function contain(int $num):bool {
        return isset($this->nodes['n'.$num]);
    }
    public function insert(int $num):void {
        if(isset($this->nodes['n'.$num])) return;
        if($this->root===null) {
            $this->create_node($num, null);
            return;
        }
        $parent_index = null;
        $child_index  = $this->root;
        while($child_index!==null) {
            $node = $this->nodes[$child_index];
            $parent_index = $child_index;
            if($num < $node[3]) {
                $child_index = $node[1];
            }else{
                $child_index = $node[2];
            }
        }
        $this->create_node($num, $parent_index);
        $this->rebalance($parent_index);
    }
    private function get_height(string|null $index):int {
        return ($index===null) ? 0 : $this->nodes[$index][4];
    }
    private function set_height(string $index):void {
        $node = $this->nodes[$index];
        $height = 1 + max(
            $this->get_height($node[1]),
            $this->get_height($node[2])
        );
        $this->nodes[$index][4] = $height;
    }
    private function rebalance(string|null $index):void {
        if($index===null) return;
        $node = $this->nodes[$index];
        $left_height = $this->get_height($node[1]);
        $right_height = $this->get_height($node[2]);
        if($left_height + 1 < $right_height) {
            $right_index = $node[2];
            $right_node = $this->nodes[$right_index];
            $right_left_height = $this->get_height($right_node[1]);
            $right_right_height = $this->get_height($right_node[2]);
            if($right_right_height < $right_left_height) {
                $right_left_index = $right_node[1];
                $this->rotate_right($right_index);
                $this->set_height($right_index);
                $this->set_height($right_left_index);
            }
            $this->rotate_left($index);
            $this->set_height($index);
            $this->set_height($right_index);
        }elseif($right_height + 1 < $left_height) {
            $left_index = $node[1];
            $left_node = $this->nodes[$left_index];
            $left_left_height = $this->get_height($left_node[1]);
            $left_right_height = $this->get_height($left_node[2]);
            if($left_left_height < $left_right_height) {
                $left_right_index = $left_node[2];
                $this->rotate_left($left_index);
                $this->set_height($left_index);
                $this->set_height($left_right_index);
            }
            $this->rotate_right($index);
            $this->set_height($index);
            $this->set_height($left_index);
        }else{
            $this->set_height($index);
        }
        $this->rebalance($node[0]);
    }
    private function rotate_right(string $index):void {
        $node = $this->nodes[$index];
        $parent_index = $node[0];
        $left_index = $node[1];
        $left_node = $this->nodes[$left_index];
        $left_right_index = $left_node[2];
        if($left_right_index!==null) {
            $this->nodes[$left_right_index][0] = $index;
        }
        if($parent_index===null) {
            $this->root = $left_index;
        }else{
            $parent_node = $this->nodes[$parent_index];
            if($node[3] < $parent_node[3]) {
                $this->nodes[$parent_index][1] = $left_index;
            }else{
                $this->nodes[$parent_index][2] = $left_index;
            }
        }
        $this->nodes[$index][0] = $left_index;
        $this->nodes[$index][1] = $left_right_index;
        $this->nodes[$left_index][0] = $parent_index;
        $this->nodes[$left_index][2] = $index;
    }
    private function rotate_left(string $index):void {
        $node = $this->nodes[$index];
        $parent_index = $node[0];
        $right_index = $node[2];
        $right_node = $this->nodes[$right_index];
        $right_left_index = $right_node[1];
        if($right_left_index!==null) {
            $this->nodes[$right_left_index][0] = $index;
        }
        if($parent_index===null) {
            $this->root = $right_index;
        }else{
            $parent_node = $this->nodes[$parent_index];
            if($node[3] < $parent_node[3]) {
                $this->nodes[$parent_index][1] = $right_index;
            }else{
                $this->nodes[$parent_index][2] = $right_index;
            }
        }
        $this->nodes[$index][0] = $right_index;
        $this->nodes[$index][2] = $right_left_index;
        $this->nodes[$right_index][0] = $parent_index;
        $this->nodes[$right_index][1] = $index;
    }
    public function erase(int $num):void {
        $index = 'n'.$num;
        if(!isset($this->nodes[$index])) return;
        $node = $this->nodes[$index];
        if($node[1]===null && $node[2]===null) {
            $parent_index = $node[0];
            $rebalance_index = $parent_index;
            $replace_index = null;
            if($parent_index===null) {
                $this->root = $replace_index;
            }else{
                $parent_node = $this->nodes[$parent_index];
                if($parent_node[1]===$index) {
                    $this->nodes[$parent_index][1] = $replace_index;
                }else{
                    $this->nodes[$parent_index][2] = $replace_index;
                }
            }
        }elseif($node[1]===null) {
            $parent_index = $node[0];
            $rebalance_index = $parent_index;
            $replace_index = $node[2];
            if($parent_index===null) {
                $this->root = $replace_index;
            }else{
                $parent_node = $this->nodes[$parent_index];
                if($parent_node[1]===$index) {
                    $this->nodes[$parent_index][1] = $replace_index;
                }else{
                    $this->nodes[$parent_index][2] = $replace_index;
                }
            }
            $this->nodes[$replace_index][0] = $parent_index;
        }elseif($node[2]===null) {
            $parent_index = $node[0];
            $rebalance_index = $parent_index;
            $replace_index = $node[1];
            if($parent_index===null) {
                $this->root = $replace_index;
            }else{
                $parent_node = $this->nodes[$parent_index];
                if($parent_node[1]===$index) {
                    $this->nodes[$parent_index][1] = $replace_index;
                }else{
                    $this->nodes[$parent_index][2] = $replace_index;
                }
            }
            $this->nodes[$replace_index][0] = $parent_index;
        }else{
            $parent_index = $node[0];
            $left_index = $node[1];
            $right_index = $node[2];
            $ma_index = 'n'.$this->min_above($node[3]);
            // $node に子要素があるので、min_above は null にならない
            $ma_node = $this->nodes[$ma_index];
            $ma_parent_index = $ma_node[0];
            $ma_right_index = $ma_node[2];
            $rebalance_index = ($ma_parent_index===$index)
                ? $ma_index
                : $ma_parent_index;
            $replace_index = $ma_index;
            if($parent_index===null) {
                $this->root = $replace_index;
            }else{
                $parent_node = $this->nodes[$parent_index];
                if($parent_node[1]===$index) {
                    $this->nodes[$parent_index][1] = $replace_index;
                }else{
                    $this->nodes[$parent_index][2] = $replace_index;
                }
            }
            $this->nodes[$replace_index][0] = $parent_index;
            $this->nodes[$replace_index][1] = $left_index;
            $this->nodes[$left_index][0] = $replace_index;
            if($right_index!==$ma_index) {
                $this->nodes[$replace_index][2] = $right_index;
                $this->nodes[$right_index][0] = $replace_index;
            }
            if($ma_parent_index!==$index) {
                $ma_parent_node = $this->nodes[$ma_parent_index];
                if($ma_parent_node[1]===$ma_index) {
                    $this->nodes[$ma_parent_index][1] = $ma_right_index;
                }else{
                    $this->nodes[$ma_parent_index][2] = $ma_right_index;
                }
            }
            if($ma_right_index!==null) {
                $this->nodes[$ma_right_index][0] = $ma_parent_index;
            }
        }
        unset($this->nodes[$index]);
        $this->rebalance($rebalance_index);
    }
    public function min_above(int $num):int|null {
        if($this->root===null) return null;
        $min = PHP_INT_MAX;
        $index = $this->root;
        while($index !== null) {
            $node = $this->nodes[$index];
            if($num < $node[3]) {
                $min = min($min, $node[3]);
                $index = $node[1];
            }else{
                $index = $node[2];
            }
        }
        return ($min===PHP_INT_MAX) ? null : $min;
    }
    public function max_below(int $num):int|null {
        if($this->root===null) return null;
        $max = PHP_INT_MIN;
        $index = $this->root;
        while($index !== null) {
            $node = $this->nodes[$index];
            if($node[3] < $num) {
                $max = max($max, $node[3]);
                $index = $node[2];
            }else{
                $index = $node[1];
            }
        }
        return ($max===PHP_INT_MIN) ? null : $max;
    }
}

// ### 実行
$avl = new AVL();
$avl->insert(0);
$avl->insert(10);
$avl->insert(5);
$avl->insert(8);
$avl->insert(11);
$avl->insert(5);
var_dump($avl->contain(3));
var_dump($avl->contain(5));
var_dump($avl->min_above(9));
var_dump($avl->min_above(10));
var_dump($avl->min_above(11));
$avl->erase(5);
var_dump($avl->max_below(6));
var_dump($avl->max_below(-5));

