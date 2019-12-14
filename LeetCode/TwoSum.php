<?php
/**
 * 两数之和 leetcode: 1
 */

class TwoSum
{
    /**
     * 两数之和，利用 hashMap
     *
     * 时间复杂度 O(n) 空间复杂度 O(n)
     *
     * @param array $arr
     * @param int $target
     * @return array
     */
    public function towSum(array $arr, int $target): array
    {
        $len = count($arr) - 1;
        $map = array();
        for ($i = 0; $i < $len; $i++) {
            $need = $target - $arr[$i];
            if (isset($map[$need])) {
                return [$map[$need], $i];
            }
            $map[$arr[$i]] = $i;
        }

        return [-1, -1];
    }

    /**
     * 两数之和，暴力法
     *
     * 时间复杂度 O(n^2) 空间复杂度 O(1)
     *
     * @param array $arr
     * @param int $target
     * @return array
     */
    public function twoSum2(array $arr, int $target): array
    {
        $len = count($arr);
        for ($i = 0; $i < $len; $i++) {
            for ($j = 1; $j < $len; $j++) {
                if (($arr[$i] + $arr[$j]) == $target) {
                    return [$i, $j];
                }
            }
        }

        return [-1, -1];
    }
}