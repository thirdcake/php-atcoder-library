<?php
// ## trie tree
class Node {
    public array $children = [];
    public bool $isEnd = false;
}
class Trie {
    public Node $root;
    public function __construct() {
        $this->root = new Node();
    }
    public function insert(string $word):void {
        $node = $this->root;
        foreach(str_split($word) as $char) {
            if(!isset($node->children[$char])) {
                $node->children[$char] = new Node();
            }
            $node = $node->children[$char];
        }
        $node->isEnd = true;
    }
    public function contains(string $word):bool {
        $node = $this->root;
        foreach(str_split($word) as $char) {
            if(!isset($node->children[$char])) {
                return false;
            }
            $node = $node->children[$char];
        }
        return $node->isEnd;
    }
    public function prefix(string $prefix): bool {
        $node = $this->root;
        foreach(str_split($prefix) as $char) {
            if(!isset($node->children[$char])) {
                return false;
            }
            $node = $node->children[$char];
        }
        return true;
    }
}

// ### 使い方
$trie = new Trie();
$trie->insert('apple');
var_dump($trie->prefix('app'));
var_dump($trie->contains('app'));
var_dump($trie->contains('apple'));
