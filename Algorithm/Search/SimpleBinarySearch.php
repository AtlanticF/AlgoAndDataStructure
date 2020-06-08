<?php
/**
 * 简单的二分查找
 * 时间复杂度 O(logN)
 *
 * 1. 依赖数据有序
 * 2. 依赖数组数据结构，链表查找复杂度很大
 * 3. 静态数据，没有频繁插入删除操作；一次排序，多次二分查找，排序的性能被均摊，二分查找的边际成本会很低
 * 4. 数据量太大不适合二分查找。底层依赖数组，数组是连续的，就需要大量的连续内存空间
 * 5. 数据量太小不适合二分查找。顺序遍历就足够了；如果数据之间的 “比较” 操作比较费时，尽量使用二分查找
 */

class SimpleBinarySearch
{
    /**
     * 数组中元素不重复的情况下二分查找
     *
     * @param array $arr
     * @param int|null $value
     * @return false|float|int
     */
    public function searchV1(array $arr, ?int $value): int
    {
        $low = 0;
        $high = count($arr) - 1;

        while ($low <= $high) {
            $mid = floor(($low + $high) / 2);
            if ($arr[$mid] == $value) {
                return $mid;
            } elseif ($arr[$low] < $arr[$mid]) {
                $low = $mid + 1;
            } else {
                $high = $mid - 1;
            }
        }

        return -1;
    }

    /**
     * 递归实现简单的二分查找
     *
     * @param array $arr
     * @param int|null $value
     * @return int|null
     */
    public function searchV2(array $arr, ?int $value)
    {
        return $this->searchV2Internally($arr, 0, count($arr) - 1, $value);
    }

    private function searchV2Internally(array $arr, int $low, int $high, ?int $value)
    {
        if ($low > $high) return -1;

        $mid = $low + (($high - $low) >> 1);
        if ($arr[$mid] == $value) {
            return $value;
        } elseif ($arr[$mid] > $low) {
            return $this->searchV2Internally($arr, $mid + 1, $high, $value);
        } else {
            return $this->searchV2Internally($arr, $low, $high - 1, $value);
        }
    }
}