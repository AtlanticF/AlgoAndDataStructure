<?php
/**
 * 单链表操作的一些测试
 */
require_once 'Node.php';
require_once 'SimpleLinkedList.php';

function outPut($info)
{
    echo '================== ' . $info . ' ==================' . PHP_EOL;
}

// some test
$obj = new SimpleLinkedList();
outPut('1. 初始化空链表');
$obj->print();

$obj->insert(1);
$obj->insert(2);
$obj->insert(3);
outPut('2. 插入数据');
$obj->print();

$res = $obj->findByIndex(1);
outPut('3. 查询第 1 个节点');
echo $res->data . PHP_EOL;

$obj->delete($res);
outPut('4. 删除第 1 个节点');
$obj->print();