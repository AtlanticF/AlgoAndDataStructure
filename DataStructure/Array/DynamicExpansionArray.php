<?php
/**
 * 支持动态扩容的数组
 * 
 * 1. 插入数据时, 如果数组已满, 申请 1.5 倍大小的内存存放新数据
 */

class DynamicExpansionArray
{
    /**
     * @var integer 数组容量
     */
    private $size;

    /**
     * @var integer 数组当前长度
     */
    private $len;

    /**
     * @var array 存放数组的数据
     */
    private $data;

    /**
     * 初始化数组
     * 
     * DynamicExpansionArray constructor.
     * @param int $size
     * @throws Exception
     */
    public function __construct(int $size)
    {
        if ($size <= 0) {
            throw new Exception('Invalid param $size');
        }
        
        $this->size = $size;
        $this->len = 0;
        $this->data = array();
    }

    /**
     * 是否超出索引下标
     * 
     * @param int $index
     * @return bool
     */
    private function outOfRange(int $index): bool
    {
        if ($index < 0 || $index >= $this->size) {
            return true;
        }
        
        return false;
    }

    /**
     * 数组是否已满
     * 
     * @return bool
     */
    private function full(): bool
    {
        if ($this->len === $this->size) {
            return true;
        }
        
        return false;
    }

    /**
     * 获取当前数组长度
     * 
     * @return int
     */
    public function getLen(): int
    {
        return $this->len;
    }

    /**
     * 查找第 k 个元素
     * 
     * @param int $position
     * @return string|null
     * @throws Exception
     */
    public function find(int $position): ?string 
    {
        $index = $position - 1;
        if (true === $this->outOfRange($index)) {
            throw new Exception('Index out of range');
        }
        
        return $this->data[$index];
    }

    /**
     * 在第 k 个位置插入数据
     * 
     * @param int $position
     * @param string|null $value
     * @return int|null
     * @throws Exception
     */
    public function insert(int $position, ?string $value): ?int 
    {
        if ($this->full()) {
            $this->expanse();
        }
        
        $index = $position - 1;
        if ($this->outOfRange($index)) {
            throw new Exception('Index out of range');
        }
        
        for ($i = $this->len - 1; $i >= $index; $i--) {
            $this->data[$i + 1] = $this->data[$i];
        }
        $this->data[$index] = $value;
        $this->len++;
        
        return $value;
    }

    /**
     * 扩容
     */
    private function expanse()
    {
        // 容量扩大为原来的 2 倍
        $this->size = 2 * $this->size;
        // 复制原数组中的数据到新数组
        $newData = array();
        for ($i = 0; $i < $this->len; $i++) {
            $newData[$i] = $this->data[$i]; 
        }
        unset($this->data);
        $this->data = $newData;
    }

    /**
     * 删除第 k 个位置的元素
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
}

$obj = new DynamicExpansionArray(5);
$obj->insert(1, 1);
$obj->insert(2, 2);
$obj->insert(3, 3);
$obj->insert(4, 4);
$obj->insert(5, 5);
$obj->insert(6, 6);

$res = $obj->find(4);
var_dump($res);
var_dump($obj);
