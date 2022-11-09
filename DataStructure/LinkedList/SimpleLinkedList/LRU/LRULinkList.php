<?php
/**
 * 单链表实现 LRU 缓存淘汰算法
 */
require_once "LRUNode.php";

class LRULinkList
{
    public $capacity;
    public $head;
    public $len;

    public function __construct(int $capacity = 10)
    {
        $this->capacity = $capacity;
        $this->head = new LRUNode(null);
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
    public function get()
    {
        return $this->head->next;
    }

    /**
     * 获取值为 data 的前驱节点
     * @param $data
     * @return false|LRUNode
     */
    private function findPreNode($data)
    {
        $curNode = $this->head->next;
        $preNode = $this->head;
        while ($curNode !== null) {
            if ($curNode->data == $data) {
                return $preNode;
            }
            $preNode = $curNode;
            $curNode = $curNode->next;
        }
        return false;
    }

    /**
     * 向缓存表中添加数据
     * 1. 在链表中
     * 2. 不在链表中
     *  a) 缓存满了
     *  b) 缓存未满
     * @param $data
     */
    public function add($data)
    {
        // 在链表中
        $dataPreNode = $this->findPreNode($data);
        if (false !== $dataPreNode) {
            $dataNode = $dataPreNode->next;
            $dataPreNode->next = $dataNode->next;
            $dataNode->next = $this->head->next;
            $this->head->next = $dataNode;
        } else {
            // 不在链表中
            if ($this->full()) {
                // 1. 缓存满了
                // 删除最后一个节点，放入第一个节点
                $curNode = $this->head->next;
                $preNode = $this->head;
                while ($curNode->next != null) {
                    $preNode = $curNode;
                    $curNode = $curNode->next;
                }
                $preNode->next = null;
            }
            // 放入第一个节点 或 缓存没有满
            $remain = $this->head->next;
            $newNode = new LRUNode($data);
            $this->head->next = $newNode;
            $newNode->next = $remain;
            $this->len++;
        }
    }

    /**
     * 打印链表
     */
    public function printLinkList()
    {
        $curNode = $this->head;
        while ($curNode !== null) {
            if ($curNode->data == null) {
                echo "NULL->";
            } else {
                echo $curNode->data . "->";
            }
            $curNode = $curNode->next;
        }
        echo "NULL\n";
    }
}

$link = new LRULinkList(5);
$link->add(1);
$link->add(2);
$link->add(3);
$link->add(4);
$link->add(5);
$link->add(6);
$link->printLinkList();