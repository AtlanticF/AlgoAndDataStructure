<?php
/**
 * 二分查找的扩展
 * 
 * 1. 查找第一个值等于给定值的元素
 * 2. 查找最后一个值等于给定值的元素
 * 3. 查找大于等于给定值的第一个元素
 * 4. 查找小于等于给定值的最后一个元素
 */

class BinarySearchExtend
{
    /**
     * 查找第一个值等于给定值的元素
     * 
     * @param array $arr
     * @param int $value
     * @return int
     */
    public function searchV1(array $arr, int $value): int
    {
        $low = 0;
        $high = count($arr) - 1;
        
        while ($low <= $high) {
            $mid = $low + (($high - $low) >> 1);
            if ($value > $arr[$mid]) {
                $low = $mid + 1;
            } elseif ($value < $arr[$mid]) {
                $high = $mid - 1;
            } else {
                if ($mid == 0 || $arr[$mid - 1] != $value) return $mid;
                $high = $mid - 1;
            }
        }
        
        return -1;
    }

    /**
     * 查找最后一个值等于给定值的元素
     * 
     * @param array $arr
     * @param int $value
     * @return int
     */
    public function searchV2(array $arr, int $value): int
    {
        $low = 0;
        $high = count($arr) - 1;
        
        while ($low <= $high) {
            $mid = $low + (($high - $low) >> 1);
            if ($value > $arr[$mid]) {
                $low = $mid + 1;
            } elseif ($value < $arr[$mid]) {
                $high = $mid - 1;
            } else {
                if ($mid == count($arr) - 1 || $arr[$mid + 1] != $value) return $mid;
                $low = $mid + 1;
            }
        }
        
        return -1;
    }


    /**
     * 查找大于等于给定值的第一个元素
     * 
     * @param array $arr
     * @param int $value
     * @return int
     */
    public function searchV3(array $arr, int $value): int
    {
        $low = 0;
        $high = count($arr) - 1;
        
        while ($low <= $high) {
            $mid = $low + (($high - $low) >> 1);
            if ($arr[$mid] >= $value) {
                if ($mid == 0 || $arr[$mid - 1] < $value) return $mid;
                $high = $mid - 1;
            } else {
                $low = $mid + 1;
            }
        }
        
        return -1;
    }

    /**
     * 查找小于等于给定值的最后一个元素
     * 
     * @param array $arr
     * @param int $value
     * @return int
     */
    public function searchV4(array $arr, int $value): int
    {
        $low = 0;
        $high = count($arr) - 1;
        
        while ($low <= $high) {
            $mid = $low + (($high - $low) >> 1);
            if ($arr[$mid] <= $value) {
                if ($mid == count($arr) - 1 || $arr[$mid + 1] > $value) return $mid;
                $low = $mid + 1;
            } else {
                $high = $mid - 1;
            }
        }
        
        return -1;
    }
}