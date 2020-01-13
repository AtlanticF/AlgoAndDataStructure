<?php
/**
 * 位图
 * 有限域中的稠密集合，每个元素至少出现一次，没有其他的数据和元素相关联
 * 通常使用一个 bit 位来表示集合中的数据是否出现
 */

class BitMap
{
    protected $bytes;
    // 申请的 bitmap 位数
    protected $length;
    protected $intSize;
    public $bitmap;

    public function __construct($length)
    {
        $this->length = $length;
        $this->bytes = ($length % 8) ? ($length / 8) : ceil($length / 8);
        $this->intSize = ceil($this->bytes / PHP_INT_SIZE);
        $this->bitmap = array_fill(0, $this->intSize, 0);
    }

    /**
     * 将 value 对应的 bit 位置为 1
     * 
     * @param int $value
     */
    public function set(int $value): void
    {
        // 计算 int 数据在的 bytePos
        $bytePos = floor($value / (PHP_INT_SIZE * 8));
        // 计算 int 数据在的 byte 中的 bit 位
        $bitPos = $value % (PHP_INT_SIZE * 8);
        $position = 1 << $bitPos;
        $this->bitmap[$bytePos] |= $position;
    }

    /**
     * value 对应的 bit 位是否已存在
     * 
     * @param int $value
     * @return bool
     */
    public function get(int $value): bool
    {
        $bytePos = floor($value / (PHP_INT_SIZE * 8));
        $bitPos = $value % (PHP_INT_SIZE * 8);
        $bin = decbin($this->bitmap[$bytePos]);
        // PHP 中一个 int 的 bit 位是 8 * 8 = 64
        if ($bin[strlen($bin) - $bitPos - 1] == 1) {
            return true;
        }
        
        return false;
    }
}

$obj = new BitMap(256);
$obj->set(100);
$obj->set(101);
var_dump($obj->get(102));
var_dump($obj->bitmap);