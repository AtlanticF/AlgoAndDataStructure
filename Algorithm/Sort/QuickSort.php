<?php
/**
 * 快速排序
 * 
 * 1. 子集划分，pivot 的选择，极端情况下元素都相同是否交换？
 * 2. 最坏情况下时间复杂度 O(n^2), 最好情况时间复杂度 O(nlogn)
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
            while ($i < $rEnd - 1 && $arr[++$i] < $pivot) {}
            while ($j > $l && $arr[--$j] > $pivot) {}
            
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