<?php
/**
 * 单链表的节点
 */

class Node
{
    /**
     * @var Node 指针指向下一个节点
     */
    public $next;

    /**
     * @var string 节点的数据域
     */
    public $data;

    /**
     * 初始化一个节点
     * 
     * Node constructor.
     * @param string|null $data
     */
    public function __construct(?string $data = null)
    {
        $this->data = $data;
        $this->next = null;
    }
}
