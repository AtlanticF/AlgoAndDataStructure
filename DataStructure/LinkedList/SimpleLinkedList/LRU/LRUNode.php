<?php

class LRUNode
{
    public $data;
    public $next;
    public $maritime;

    public function __construct($data)
    {
        $this->data = $data;
        $this->maritime = microtime(true) * 1000;
        $this->next = null;
    }
}