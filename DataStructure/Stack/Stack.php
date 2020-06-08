<?php
/**
 * 栈的简单实现
 *
 * 栈是一种操作受限的线性表, 只能在同一端执行 入栈 和 出栈操作
 *
 * 1. 将指定元素入栈 O(1)
 * 2. 将栈顶元素出栈 O(1)
 * 3. 查询栈中值 等于给定值的数据 O(n)
 */

class Stack
{
    /**
     * @var int 栈的容量
     */
    private $size;

    /**
     * @var int 当前栈的长度
     */
    private $len;

    /**
     * @var array 保存栈的数据 (数组)
     */
    private $data;

    /**
     * Stack constructor.
     * @param int $size
     * @throws Exception
     */
    public function __construct(int $size)
    {
        if ($size <= 0) {
            throw new Exception('Invalid param $size');
        }

        $this->size = $size;
        $this->data = [];
        $this->len = 0;
    }

    /**
     * 是否栈满
     *
     * @return bool
     */
    private function full(): bool
    {
        if ($this->size === $this->len) {
            return true;
        }

        return false;
    }

    /**
     * 是否为空栈
     *
     * @return bool
     */
    private function isEmpty(): bool
    {
        if ($this->len === 0) {
            return true;
        }

        return false;
    }

    /**
     * 入栈
     *
     * @param string|null $value
     * @return string|null
     * @throws Exception
     */
    public function push(?string $value): ?string
    {
        if (true === $this->full()) {
            throw new Exception('Stack is full');
        }

        $this->data[$this->len] = $value;
        $this->len++;
        return $value;
    }

    /**
     * 出栈
     *
     * @return string|null
     */
    public function pop(): ?string
    {
        if (true === $this->isEmpty()) {
            return null;
        }

        $value = $this->data[$this->len - 1];
        unset($this->data[$this->len - 1]);
        $this->len--;

        return $value;
    }
}

// some test
$obj = new Stack(4);
$obj->push(1);
$obj->push(2);
var_dump($obj);
$res = $obj->pop();
var_dump($res);
var_dump($obj);
$res = $obj->pop();
var_dump($res);
var_dump($obj);
$res = $obj->pop();
var_dump($res);