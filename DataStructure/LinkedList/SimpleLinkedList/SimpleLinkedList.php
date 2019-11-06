<?php
/**
 * 单链表的简单实现
 * 
 * 链表是一种线性表数据结构, 通过 "指针" 将林三的内存块串联起来
 * 
 * 1. 在指定节点前 / 后插入数据 默认头插法 (插入到头节点之前) O(1)
 * 2. 查询值等于给定值的第一个节点 O(n), 查询第 k 个节点
 * 3. 删除值等于给定值的节点 O(n)
 * 4. 删除已知节点 O(1)
 */

class SimpleLinkedList
{
    /**
     * @var Node 哨兵节点
     */
    private $head;

    /**
     * @var int 链表长度
     */
    private $len;
    
    public function __construct()
    {
        $this->head = new Node();
        $this->len = 0;
    }
    
    public function insert(string $data): ?string 
    {
        $node = new Node($data);
        // 默认头插法插入数据
        $this->insertBefore($this->head, $node);
        $this->len++;
        
        return $node->data;
    }

    /**
     * 查找第 k 个节点
     * 
     * @param int $position
     * @return Node
     */
    public function findByIndex(int $position): Node
    {
        $curNode = $this->head;
        $index = 1;
        while ($curNode->next != null) {
            $curNode = $curNode->next;
            if ($position === $index) {
                return $curNode;
            }
        }
        
        return null;
    }

    /**
     * 查找第一个值等于给定值的节点
     * 
     * @param string|null $val
     * @return Node
     */
    public function findByVal(?string $val): Node
    {
        $curNode = $this->head;
        while ($curNode->next != null) {
            $curNode = $curNode->next;
            if ($curNode->data == $val) {
                return $curNode;
            }
        }
        
        return null;
    }

    /**
     * 删除节点
     * 
     * @param Node $node
     * @return Node
     */
    public function delete(Node $node): Node
    {
        $beforeNode = $this->findBeforeNode($node);
        $beforeNode->next = $node->next;
        $this->len--;
        unset($node);
        
        return $this->head;
    }

    /**
     * 在已知节点后插入新节点
     * 
     * @param string $data
     * @param Node $node
     * @return string|null
     */
    public function insertAfter(string $data, Node $node): ?string 
    {
        $newNode = new Node($data);
        $newNode->next = $node->next;
        $node->next = $newNode;
        $this->len++;
        
        return $data;
    }

    /**
     * 在节点前插入新节点
     * 
     * @param Node $newNode
     * @param Node $node
     */
    private function insertBefore(Node $newNode, Node $node)
    {
        $beforeNode = $this->findBeforeNode($node);
        $newNode->next = $node;
        $beforeNode->next = $newNode;
    }

    /**
     * 找到节点的前驱节点
     * 
     * @param Node $node
     * @return Node
     */
    private function findBeforeNode(Node $node): Node
    {
        $curNode = $this->head;
        while ($curNode != null && $curNode !== $node) {
            $curNode = $curNode->next;
        }
        
        return $curNode;
    }
}