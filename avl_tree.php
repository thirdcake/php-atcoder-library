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
        $this->nodes['n'.$num] = [
            $parent,  // 0 => parent index {string|null}
            null,     // 1 => left child index {string}
            null,     // 2 => right child index {string}
            $num,     // 3 => num {int}
            1,        // 4 => height {int}
        ];
        if($parent===null) {
            $this->root = 'n'.$num;
        }else{
            $parent_node = $this->nodes[$parent];
            if($num < $parent_node[3]) {
                $this->nodes[$parent][1] = 'n'.$num;
            }else{
                $this->nodes[$parent][2] = 'n'.$num;
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
    private function set_height(string|null $index):void {
        $node = $this->nodes[$index];
        $height = max(
            $this->get_height($node[1]),
            $this->get_height($node[2])
        )+1;
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
        $this->nodes[$index][1] = $left_upper_index;
        $this->nodes[$left_index][0] = $parent_index;
        $this->nodes[$left_index][2] = $index;
    }
    private function rotate_left(string $index):void {
        $node = $this->nodes[$index];
        $parent_index = $node[0];
        $upper_index = $node[2];
        $upper_node = $this->nodes[$upper_index];
        $upper_lower_index = $upper_node[1];
        if($upper_lower_index!==null) {
            $this->nodes[$upper_lower_index][0] = $index;
        }
        if($parent_index===null) {
            $this->root = $upper_index;
        }else{
            $parent_node = $this->nodes[$parent_index];
            if($node[3] < $parent_node[3]) {
                $this->nodes[$parent_index][1] = $upper_index;
            }else{
                $this->nodes[$parent_index][2] = $upper_index;
            }
        }
        $this->nodes[$index][0] = $upper_index;
        $this->nodes[$index][2] = $upper_lower_index;
        $this->nodes[$upper_index][0] = $parent_index;
        $this->nodes[$upper_index][1] = $index;
    }
    public function erase(int $num):void {
        if(!isset($this->nodes['n'.$num])) return;
        $index = 'n'.$num;
        $node = $this->nodes[$index];
        if($node[1]===null && $node[2]===null) {
            $parent_index = $node[0];
            $rebalance_index = $parent_index;
            if($parent_index===null) {
                $this->root = null;
            }else{
                $parent_node = $this->nodes[$parent_index];
                if($parent_node[1]===$index) {
                    $this->nodes[$parent_index][1] = null;
                }else{
                    $this->nodes[$parent_index][2] = null;
                }
            }
        }elseif($node[1]===null) {
            $parent_index = $node[0];
            $rebalance_index = $parent_index;
            if($parent_index===null) {
                $this->root = $node[2];
            }else{
                $parent_node = $this->nodes[$parent_index];
                if($parent_node[1]===$index) {
                    $this->nodes[$parent_index][1] = $node[2];
                }else{
                    $this->nodes[$parent_index][2] = $node[2];
                }
            }
        }elseif($node[2]===null) {
            $parent_index = $node[0];
            $rebalance_index = $parent_index;
            if($parent_index===null) {
                $this->root = $node[1];
            }else{
                $parent_node = $this->nodes[$parent_index];
                if($parent_node[1]===$index) {
                    $this->nodes[$parent_index][1] = $node[1];
                }else{
                    $this->nodes[$parent_index][2] = $node[1];
                }
            }
        }else{
            $parent_index = $node[0];
            $lower_index = $node[1];
            $upper_index = $node[2];
            $ub_index = 'n'.$this->next_greater($node[3]);
            $ub_node = $this->nodes[$ub_index];
            $ub_parent_index = $ub_node[0];
            $ub_upper_index = $ub_node[2];
            $rebalance_index = ($ub_parent_index===$index)
                ? $ub_index
                : $ub_parent_index;
            if($parent_index===null) {
                $this->root = $ub_index;
            }else{
                $parent_node = $this->nodes[$parent_index];
                if($parent_node[1]===$index) {
                    $this->nodes[$parent_index][1] = $ub_index;
                }else{
                    $this->nodes[$parent_index][2] = $ub_index;
                }
            }
            $this->nodes[$ub_index][0] = $parent_index;
            $this->nodes[$ub_index][1] = $lower_index;
            if($upper_index!==$ub_index) {
                $this->nodes[$ub_index][2] = $upper_index;
            }
            $this->nodes[$lower_index][0] = $ub_index;
            if($upper_index!==$ub_index) {
                $this->nodes[$upper_index][0] = $ub_index;
            }
            if($ub_parent_index!==$index) {
                $ub_parent_node = $this->nodes[$ub_parent_index];
                if($ub_parent_node[1]===$ub_index) {
                    $this->nodes[$ub_parent_index][1] = $ub_upper_index;
                }else{
                    $this->nodes[$ub_parent_index][2] = $ub_upper_index;
                }
            }
            if($ub_upper_index!==null) {
                $this->nodes[$ub_upper_index][0] = $ub_parent_index;
            }
        }
        unset($this->nodes[$index]);
        $this->rebalance($rebalance_index);
    }
    public function next_greater(int $num):int|null {
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
    public function prev_less(int $num):int|null {
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
var_dump($avl->next_greater(9));
var_dump($avl->next_greater(10));
var_dump($avl->next_greater(11));
$avl->erase(5);
var_dump($avl->prev_less(6));
var_dump($avl->prev_less(-5));

