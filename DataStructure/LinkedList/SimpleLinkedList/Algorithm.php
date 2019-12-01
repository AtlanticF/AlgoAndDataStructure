<?php
/**
 * 单链表的算法
 * 
 * 1. 单链表的反转
 * 2. 链表环的判断 (返回链表环的入口)
 * 3. 单链表实现 LRU 缓存淘汰算法
 * 4. 单链表实现回文判断
 * 5. 合并两个有序链表(归并)
 * 6. 删除倒数第 n 个节点
 */

require_once 'Node.php';
require_once 'SimpleLinkedList.php';

class Algorithm
{
    /**
     * @var SimpleLinkedList
     */
    public $linkedList;
    
    public function __construct(SimpleLinkedList $linkedList = null)
    {
        $this->linkedList = $linkedList;
    }

    public function reverse()
    {
        if (null === $this->linkedList) {
            return true;
        }
        $len = $this->linkedList->getLen();
        if ($len <= 1) {
            return true;
        }
        
        // 前驱节点指针
        $preNode = null;
        // 当前节点指针
        $curNode = $this->linkedList->head->next;
        // 暂存节点指针，保证链表不丢失
        $remainNode = null;
        
        // 暂存头节点，反转后指向反转链表
        $headNode = $this->linkedList->head;
        // 断开头节点
        $this->linkedList->head->next = null;
        
        while ($curNode != null) {
            // 保证后面的节点不丢失
            $remainNode = $curNode->next;
            // 反转
            $curNode->next = $preNode;
            // 前驱节点指针移动
            $preNode = $curNode;
            // 当前节点指针移动
            $curNode = $remainNode;
        }
        
        // 头节点指向反转后的链表
        $headNode->next = $preNode;
        
        return true;
    }
    
    public function circle()
    {
        if (null === $this->linkedList) {
            return false;
        }
        $len = $this->linkedList->getLen();
        if ($len <= 0) {
            return false;
        }
        
        $slow = $this->linkedList->head->next;
        $fast = $this->linkedList->head->next;
        
        $flag = false;
        while ($fast != null && $fast->next != null) {
            $slow = $slow->next;
            $fast = $fast->next->next;
            // 快慢指针相遇，链表中存在环
            if ($slow === $fast) {
                $flag = true;
                break;
            }
        }
        
        if (true === $flag) {
            // 环存在，返回链表环入口
            // 快指针移到 head, 慢指针在相遇点, 同时以步长为 1 前进, 相遇时为环的起点
            $fast = $this->linkedList->head;
            while ($fast != null && $fast !== $slow) {
                $fast = $fast->next;
                $slow = $slow->next;
            }
            
            return $fast;
        }
        
        return false;
    }

    /**
     * 1. 维护一个有序链表，越靠近链表尾部的时间越小
     * 2. 当有新的数据需要缓存的时候，判断是否已经在链表中 O(n)
     * 3. 如果在，将节点插入到链表头部，删除原本的节点
     * 4. 如果不在
     *    a) 链表满了，淘汰最后的节点，将新节点插入链表头部
     *    b) 链表未满，直接将新的节点插入链表头部
     */
    public function lru(){}

    /**
     * 合并两个有序链表
     * 
     * @param SimpleLinkedList $linkedListA
     * @param SimpleLinkedList $linkedListB
     * @return SimpleLinkedList
     */
    public function mergeSortedLinkedList(SimpleLinkedList $linkedListA, SimpleLinkedList $linkedListB): SimpleLinkedList
    {
        if (null == $linkedListA) {
            return $linkedListB;
        }
        if (null == $linkedListB) {
            return $linkedListA;
        }
        
        $mergedList = new SimpleLinkedList();
        
        $curMergedList = $mergedList->head;
        $curNodeA = $linkedListA->head->next;
        $curNodeB = $linkedListB->head->next;
        
        while ($curNodeA != null && $curNodeB != null) {
            if ($curNodeA->data <= $curNodeB->data) {
                $curMergedList->next = $curNodeA;
                $curNodeA = $curNodeA->next;
            } else {
                $curMergedList->next = $curNodeB;
                $curNodeB = $curNodeB->next;
            }
            
            $curMergedList = $curMergedList->next;
        }
        
        while (null != $curNodeA) {
            $curMergedList->next = $curNodeA;
        }
        
        while (null != $curNodeB) {
            $curMergedList->next = $curNodeB;
        }
        
        return $mergedList;
    }
    
    public function delLastKth(int $index)
    {
        if ($index <= 0) {
            return false;
        }
        
        if (null === $this->linkedList) {
            return false;
        }
        
        // 双指针指向要删除节点的前和后
        $slow = $this->linkedList->head;
        $fast = $this->linkedList->head;
        
        for ($i = 0; $i < $index; $i++) {
            $fast = $fast->next;
        }
        
        while ($fast != null) {
            $fast = $fast->next;
            $slow = $slow->next;
        }
        
        $slow->next = $slow->next->next;
        
        return true;
    }
}