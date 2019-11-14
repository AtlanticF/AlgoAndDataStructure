<?php
/**
 * 归并排序
 * 
 * 分治思想利用递归完成排序, 适合外部排序
 * 1. 时间复杂度 O(nlogn)
 * 2. 空间复杂 O(n) 不是原地排序
 * 3. 稳定排序算法
 */

class MergeSort
{
    public function sort(&$arr)
    {
        $tmp = array();
        $this->merge_sort($arr, $tmp, 0, count($arr) - 1);
        unset($tmp);
    }
    
    private function merge_sort(array &$arr, array &$tmp, int $l, int $rEnd): void
    {
        if ($l < $rEnd) {
            $center = intval($l + $rEnd) / 2;
            $this->merge_sort($arr, $tmp, $l, $center);
            $this->merge_sort($arr, $tmp, $center + 1, $rEnd);
            $this->merge($arr, $tmp, $l, $center + 1, $rEnd);
        }
    }
    
    private function merge(array &$arr, array &$tmp, int $l, int $r, int $rEnd): void
    {
        $lEnd = $r - 1;
        $tmpIndex = $l;
        $tmpElements = $rEnd - $l + 1;
        
        while ($l <= $lEnd && $r <= $rEnd) {
            if ($arr[$l] <= $arr[$r]) {
                $tmp[$tmpIndex] = $arr[$l];
                $tmpIndex++;
                $l++;
            } else {
                $tmp[$tmpIndex] = $arr[$r];
                $tmpIndex++;
                $r++;
            }
        }
        
        while ($l <= $lEnd) {
            $tmp[$tmpIndex] = $arr[$l];
            $tmpIndex++;
            $l++;
        }
        
        while ($r <= $rEnd) {
            $tmp[$tmpIndex] = $arr[$r];
            $tmpIndex++;
            $r++;
        }
        
        for ($i = 0; $i < $tmpElements; $i++, $rEnd--) {
            $arr[$rEnd] = $tmp[$rEnd];
        }
    }
}

$a = [3,5,1,2,7,44,3,223,5,6,8,9,33];
$obj = new MergeSort();
$obj->sort($a);
var_dump($a);