<?php
/**
 * 数组的实现
 * 
 * 数组是一种线性表数据结构, 用一组连续的内存空间, 存储相同数据类型的数据
 * 
 * 1. 初始化数组
 * 2. 在第 k 个位置插入数据 O(n)
 * 3. 删除第 k 个位置的数据 O(n)
 * 4. 查询第 k 个位置的数据 O(1)
 */

class MyArray
{
    /**
     * @var integer 数组容量
     */
    private $size;

    /**
     * @var array 存储数组中的数据
     */
    private $data;

    /**
     * @var integer 数组当前长度
     */
    private $len;

    /**
     * 初始化数组
     * 
     * MyArray constructor.
     * @param int $size
     * @throws Exception
     */
    public function __construct(int $size)
    {
        if ($size <= 0) {
            throw new  Exception('Invalid param $size');
        }
        $this->data = array();
        $this->size = $size;
        $this->len = 0;
    }

    /**
     * @return int
     */
    public function getLen(): int
    {
        return $this->len;
    }

    /**
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
     * @param $index
     * @return bool
     */
    private function outOfRange($index): bool
    {
        if ($index < 0 || $index >= $this->size) {
            return true;
        }
        
        return false;
    }

    /**
     * 在指定位置插入数据
     * 
     * @param int $position
     * @param int|null $value
     * @return bool|null
     * @throws Exception
     */
    public function insert(int $position, ?int $value): ?bool
    {
        if ($this->full()) {
            throw new Exception('Array is full');
        }
        $index = $position - 1;
        if ($this->outOfRange($index)) {
            throw new Exception('Index out of range');
        }
        
        for ($i = $this->len; $i > $index; $i--) {
            $this->data[$i] = $this->data[$i - 1];
        }
        
        $this->data[$index] = $value;
        $this->len++;
        
        return $value;
    }

    /**
     * 删除第 k 个元素
     * 
     * @param int $position
     * @return string|null
     * @throws Exception
     */
    public function delete(int $position): ?string
    {
        $index = $position - 1;
        if ($this->outOfRange($index)) {
            throw new Exception('Index out of range');
        }
        
        $value = $this->data[$index];
        for ($i = $index; $i < $this->len - 1; $i++) {
            $this->data[$i] = $this->data[$i + 1];
        }
        $this->len--;
        unset($this->data[$this->len - 1]);
        
        return $value;
    }

    /**
     * 查询第 k 个位置的数据
     * 
     * @param $position
     * @return string|null
     * @throws Exception
     */
    public function find($position): ?string
    {
        $index = $position - 1;
        if ($this->outOfRange($index)) {
            throw new Exception('Index out of range');
        }
        
        return $this->data[$index];
    }
}

$obj = new MyArray(5);
$obj->insert(1, 9);
$obj->insert(1, 10);
var_dump($obj);
$obj->delete(1);
var_dump($obj);
