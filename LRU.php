<?php

class LRUNode
{
    public $value;
    public $key;
    public $next;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
        $this->next = null;
    }
}

class LRUCache {
    public $capacity;
    public $head;
    public $len;
    /**
     * @param Integer $capacity
     */
    function __construct($capacity) {
        $this->capacity = $capacity;
        $this->head = new LRUNode(null, null);
        $this->len = 0;
    }

    /**
     * 缓存是否已满
     * @return bool
     */
    public function full(): bool
    {
        return $this->len == $this->capacity;
    }

    /**
     * 返回最热的数据
     * @return null
     */
    public function get($key)
    {
        $p = $this->head->next;
        while($p) {
            if ($p->key == $key) {
                return $p->value;
            }
            $p = $p->next;
        }
        return -1;
    }

    public function getNode($key)
    {
        $p = $this->head->next;
        while($p) {
            if ($p->key == $key) {
                return $p;
            }
            $p = $p->next;
        }
        return null;
    }

    /**
     * @param Integer $key
     * @param Integer $value
     * @return NULL
     */
    function put($key, $value) {
        $node = $this->getNode($key);
        if ($node != null) {
            // 在缓存中 update
            $node->value = $value;
        } else {
            // 不在缓存中
            if ($this->isFull()) {
                var_dump(123);
                // 缓存满，淘汰头部数据，插入尾部
                $this->head->next = $this->head->next->next;
                $pre = $this->head;
                $cur = $this->head->next;
                while(null != $cur) {
                    $pre = $cur;
                    $cur = $cur->next;
                }
                $pre->next = new LRUNode($key, $value);
            } else {
                // 缓存未满，放入尾部
                $pre = $this->head;
                $cur = $this->head->next;
                while(null != $cur) {
                    $pre = $cur;
                    $cur = $cur->next;
                }
                $pre->next = new LRUNode($key, $value);
                $this->len++;
            }
        }
    }

    function isFull() {
        return $this->len == $this->capacity;
    }
}

var_dump($ob = new LRUCache(2));
var_dump($ob->put(1, 1));
var_dump($ob->put(2, 2));
var_dump($ob->get(1));
var_dump($ob->put(3, 3));
var_dump($ob->get(2));
