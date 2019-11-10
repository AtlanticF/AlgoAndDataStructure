<?php
/**
 * 冒泡排序
 * 
 * 1. 最好情况时间复杂度 O(n), 最坏情况时间复杂度 O(n^2), 平均情况时间复杂度 O(n^2)
 * 2. 原地排序, 空间复杂度 O(1)
 * 3. 稳定排序, 当遇到想的数据不做交换
 * 
 * 思路: 每一趟都要从头开始遍历, 每一趟遍历完成后有序度 +1
 */

class BubbleSort
{
    public function sort(array &$arr): void
    {
        if (count($arr) <= 1) {
            return;
        }
        
        for ($i = 0; $i < count($arr); $i++) {
            $flag = false;
            for ($j = 0; $j < count($arr) - $i - 1; $j++) {
                if ($arr[$j] > $arr[$j + 1]) {
                    $tmp = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $tmp;
                    $flag = true;
                }
            }
            if (false === $flag) {
                break;
            }
        }
    }
}

$bubbleSort = new BubbleSort();
$arr = [4,5,6,7,1,2,3,3];
$bubbleSort->sort($arr);
var_dump($arr);die;