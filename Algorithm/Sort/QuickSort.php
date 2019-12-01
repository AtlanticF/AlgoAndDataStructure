<?php
/**
 * 快速排序
 * 
 * 1. 子集划分，pivot 的选择 (三位取中法，pivot 的位置调整)
 *    极端情况下元素都相同是否交换 ? : 
 *    - 交换会产生不必要的交换代价，因为每个元素是相同的，但每次可以基本均匀地划分两个子集，时间复杂度 O(nlogn)；
 *    - 不交换则每次的子集都被划分在一断，时间复杂度降为 O(n^2)
 * 2. 最坏情况下时间复杂度 O(n^2), 最好情况时间复杂度 O(nlogn)
 * 3. 优化，快速排序在 cutoff 比较小的时候优先使用简单排序算法（插入排序，选择排序）
 * 4. 快的根本原因是什么？每次子集划分都将 pivot 放到了有序序列最终的一个位置
 * 5. 不稳定排序，存在交换；是原地排序算法，空间复杂度 O(1)
 */

class QuickSort
{
    public function sort(array &$arr): void
    {
        $this->quick_sort($arr, 0, count($arr) - 1);
    }
    
    private function quick_sort(array &$arr, int $l, int $rEnd): void
    {
        if ($l < $rEnd) {
            $partition = $this->partition($arr, $l, $rEnd);
            $this->quick_sort($arr, $l, $partition - 1);
            $this->quick_sort($arr, $partition + 1, $rEnd);
        }
    }
    
    private function partition(array &$arr, int $l, int $rEnd): int
    {
        $pivot = $this->mid3($arr, $l, $rEnd);
        $i = $l;
        $j = $rEnd - 1;
        
        for (;;) {
            while ($i < $rEnd - 1 && $arr[++$i] < $pivot) {
                continue;
            }
            while ($j > $l && $arr[--$j] > $pivot) {
                continue;
            }
            
            if ($i < $j) {
                $this->swap($arr, $i, $j);
            } else {
                break;
            }
        }
        
        $this->swap($arr, $i, $rEnd - 1);
        
        return $i;
    }
    
    private function mid3(array &$arr, int $l, int $rEnd): int
    {
        $center = intval(($l + $rEnd) / 2);
        if ($arr[$l] > $arr[$center]) {
            $this->swap($arr, $l, $center);
        }
        if ($arr[$l] > $arr[$rEnd]) {
            $this->swap($arr, $l, $rEnd);
        }
        if ($arr[$center] > $arr[$rEnd]) {
            $this->swap($arr, $center, $rEnd);
        }
        
        $this->swap($arr, $center, $rEnd - 1);
        
        return $arr[$rEnd - 1];
    }
    
    private function swap(array &$arr, int $i, int $j): void
    {
        $tmp = $arr[$j];
        $arr[$j] = $arr[$i];
        $arr[$i] = $tmp;
    }
}

$obj = new QuickSort();
$arr = [4,5,1,3,8,4,12,5,7,1,34,67,43,23,78,44];
$obj->sort($arr);
var_dump($arr);