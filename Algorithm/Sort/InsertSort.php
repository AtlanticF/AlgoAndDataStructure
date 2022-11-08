<?php
/**
 * 插入排序
 * 找到元素在有序数列的插入位置，插入
 *
 * 1. 最好情况时间复杂度 O(n), 最坏情况时间复杂度 O(n^2), 平均情况时间复杂度 O(n^2)
 * 2. 原地排序, 空间复杂度 O(1)
 * 3. 稳定排序算法, 当遇比较到相同元素的时候, 插入之前排好序的元素之后
 */

class InsertSort
{
    public function sort(array &$arr): void
    {
        if (count($arr) <= 1) {
            return;
        }

        for ($i = 1; $i < count($arr); $i++) {
            $item = $arr[$i];
            $j = $i - 1;
            for (; $j >= 0; $j--) {
                if ($arr[$j] > $item) {
                    $arr[$j + 1] = $arr[$j];
                } else {
                    break;
                }
            }
            $arr[$j + 1] = $item;
        }
    }
}

$o = new InsertSort();
$arr = [5, 2, 1, 4, 6, 7, 1, 4, 6];
$o->sort($arr);
var_dump($arr);
die;