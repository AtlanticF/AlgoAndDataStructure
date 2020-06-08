<?php
/**
 * 单链表的简单实现
 *
 * 链表是一种线性表数据结构, 通过 "指针" 将零散的内存块串联起来
 *
 * 1. 在指定节点前 / 后插入数据 默认头插法 (插入到头节点之后) O(1)
 * 2. 查询值等于给定值的第一个节点 O(n), 查询第 k 个节点
 * 3. 删除值等于给定值的节点 O(n)
 * 4. 删除已知节点 O(1)
 */
require_once 'Node.php';

class SimpleLinkedList
{
    /**
     * @var Node 哨兵节点
     */
    public $head;

    /**
     * @var int 链表长度
     */
    private $len;

    public function __construct()
    {
        $this->head = new Node();
        $this->len = 0;
    }

    /**
     * @param string $data
     * @return string|null
     * @throws Exception
     */
    public function insert(string $data): ?string
    {
        // 默认头插法插入数据
        $this->insertAfter($data, $this->head);

        return $data;
    }

    /**
     * 查找第 k 个节点
     *
     * @param int $position
     * @return Node
     * @throws Exception
     */
    public function findByIndex(int $position): Node
    {
        $index = $position - 1;
        if ($index < 0 || $index >= $this->len) {
            throw new Exception('Index out of range');
        }

        $curNode = $this->head;
        for ($i = 0; $i <= $index; $i++) {
            $curNode = $curNode->next;
        }

        return $curNode;
    }

    /**
     * 查找第一个值等于给定值的节点
     *
     * @param string|null $val
     * @return Node|null
     */
    public function findByVal(?string $val): ?Node
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
     * @throws Exception
     */
    public function delete(Node $node): Node
    {
        $beforeNode = $this->getBeforeNode($node);
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
     * @throws Exception
     */
    public function insertAfter(string $data, Node $node): ?string
    {
        if (null === $node) {
            throw new Exception('Invalid null param $node');
        }

        $newNode = new Node($data);
        $newNode->next = $node->next;
        $node->next = $newNode;
        $this->len++;

        return $data;
    }

    /**
     * 获取链表长度
     *
     * @return int
     */
    public function getLen(): int
    {
        return $this->len;
    }

    /**
     * 在节点前插入新节点
     *
     * @param Node $newNode
     * @param Node $node
     * @throws Exception
     */
    private function insertBefore(Node $newNode, Node $node)
    {
        $beforeNode = $this->getBeforeNode($node);
        $newNode->next = $node;
        $beforeNode->next = $newNode;
    }

    /**
     * 找到节点的前驱节点
     *
     * @param Node $node
     * @return Node
     * @throws Exception
     */
    private function getBeforeNode(Node $node): Node
    {
        if (null === $node) {
            throw new Exception('Invalid null param $node');
        }

        $curNode = $this->head;
        $prevNode = $this->head;
        while (null !== $curNode && $curNode !== $node) {
            $prevNode = $curNode;
            $curNode = $curNode->next;
        }

        return $prevNode;
    }

    /**
     * 输出单链表
     */
    public function print()
    {
        $curNode = $this->head;
        while (null !== $curNode) {
            if ($curNode->data == null) {
                echo 'head --> ';
            } else {
                echo $curNode->data . ' --> ';
            }
            $curNode = $curNode->next;
        }
        echo 'null' . PHP_EOL;
    }
}
