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

    /**
     * 单链表的反转
     * 
     * 1. 三个指针： 前驱节点，当前节点，暂存节点 (保证链表不丢失)
     * 2. 前驱节点为 null，当前节点为 head->next，暂存节点为 null
     * 3. 保存头节点，反转后指向新的链表，head = linkList->head
     * 4. 断开头节点，head->next = null
     * 5. 遍历当 curNode 不为 null
     * 6. 暂存下后面的链表，remainNode = curNode->next
     * 7. 反转，curNode->next = preNode
     * 8. 更新前驱节点，preNode = curNode
     * 9. 更新当前节点，curNode = remainNode
     * 10. 反转后的链表为 preNode，将头结点与反转后链表相连，head->next = preNode
     * 
     * @return bool
     */
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

    /**
     * 单链表环的判断 | 找到环的入口
     * 
     * 1. 快慢指针 fast, slow 从表头开始前进，快指针步长为 2，慢指针步长为 1
     * 2. 当快指针没有走到链表尾部，即 fast != null && fast->next != null，一直前进
     * 3. 当快慢指针相遇，即 fast === slow 链表中存在环
     * 4. 相遇点将一个指针移动到头结点，两指针步长都为 1，再次相遇的地方为环的入口
     * 
     * @return bool|Node|null
     */
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
                if ($fast === $slow) {
                    break;
                }
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

    /**
     * 删除链表中倒数第 k 个节点
     * 
     * 1. 快指针移动到正数第 k 个节点的位置
     * 2. 快慢指针同时开始移动，直到快指针到链表尾部
     * 3. 此时慢指针后的节点即倒数第 k 个节点 slow->next = slow->next->next
     * 
     * @param int $index
     * @return bool
     */
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