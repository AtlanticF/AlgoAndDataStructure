<?php
/**
 * 选择排序
 * 找到剩余元素中最小的元素与当前元素做交换
 *
 * 1. 最好情况时间复杂度 O(n), 最坏情况时间复杂度 O(n^2), 平均情况时间复杂度 O(n^2)
 * 2. 原地排序, 空间复杂度 O(1)
 * 3. 不稳定排序, 产生了交换
 *
 * 思路: 假定第 1 个元素已有序, 从第二个元素开始向后遍历, 找到最小的元素, 与第 1 个元素进行交换. 以此类推
 */

class SelectSort
{
    public function sort(array &$arr): void
    {
        if (count($arr) <= 1) {
            return;
        }

        for ($i = 0; $i < count($arr) - 1; $i++) {
            $p = $i;
            $j = $i + 1;
            for (; $j < count($arr); $j++) {
                if ($arr[$j] < $arr[$p]) {
                    $p = $j;
                }
            }
            $tmp = $arr[$p];
            $arr[$p] = $arr[$i];
            $arr[$i] = $tmp;
        }
    }
}

$o = new SelectSort();
$arr = [1, 3, 5, 7, 3, 24, 2, 6, 9, 5, 3, 7, 1];
$o->sort($arr);
var_dump($arr);
die;