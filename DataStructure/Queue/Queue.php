<?php
/**
 * 队列的简单实现
 * 
 * 队列是一种操作受限的线性表, 只允许在队尾入队, 在队头入队
 * 
 * 重点: 队头和队尾指针; 有限队列中保证内存空间的连续性, 合理利用队头指针解决空间不连续问题
 * 
 * 1. 入队
 * 2. 出队
 */

class Queue
{
    /**
     * @var int 队列容量
     */
    private $capacity;

    /**
     * @var int 当前队列长度
     */
    private $len;

    /**
     * @var array 保存队列数据
     */
    private $data;

    /**
     * @var int 队头下标
     */
    private $head;

    /**
     * @var int 队尾下标
     */
    private $tail;

    /**
     * Queue constructor.
     * @param int $capacity
     * @throws Exception
     */
    public function __construct(int $capacity)
    {
        if ($capacity <= 0) {
            throw new Exception('Invalid param $capacity');
        }
        
        $this->capacity = $capacity;
        $this->len = 0;
        $this->data = array();
        $this->head = 0;
        $this->tail = 0;
    }

    /**
     * @return int
     */
    public function getLen(): int 
    {
        return $this->len;
    }

    /**
     * 是否队满
     * 
     * @return bool
     */
    private function full(): bool
    {
        if ($this->tail === $this->capacity) {
            return true;
        }
        
        return false;
    }

    /**
     * 是否空队
     * 
     * @return bool
     */
    private function empty(): bool
    {
        if ($this->head === $this->tail) {
            return true;
        }
        
        return false;
    }

    /**
     * 入队
     * 
     * @param string|null $value
     * @return bool
     * @throws Exception
     */
    public function enQueue(?string $value): bool 
    {
        // 队尾后没有空间
        if ($this->tail === $this->capacity) {
            // 队列被占满
            if ($this->head === 0) {
                return false;
            }
            
            // 队列没有被占满, 搬移数据
            for ($i = $this->head; $i < $this->tail; $i++) {
                // [0,0,0,1,2,3] => [1,2,3]
                $this->data[$i - $this->head] = $this->data[$i];
            }
            // 更新 tail 和 head
            $this->tail -= $this->head;
            $this->head = 0;
        }
        
        // 数据写入
        $this->data[$this->tail] = $value;
        $this->tail++;
        $this->len++;
        return true;
    }

    /**
     * 出队
     * 
     * @return string|null
     * @throws Exception
     */
    public function deQueue(): ?string 
    {
        if ($this->empty()) {
            throw new Exception('Queue is empty');
        }
        
        $item = $this->data[$this->head];
        $this->head++;
        $this->len--;
        
        return $item;
    }
}

$obj = new Queue(3);
$obj->enQueue(1);
$res = $obj->deQueue();
var_dump($res);
$obj->enQueue(2);
$obj->enQueue(3);
$obj->enQueue(4);
var_dump($obj);