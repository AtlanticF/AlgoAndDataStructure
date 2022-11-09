<?php
/**
 * Leetcode 28
 * 实现 strStr()

给定一个 haystack 字符串和一个 needle 字符串，在 haystack 字符串中找出 needle 字符串出现的第一个位置 (从0开始)。如果不存在，则返回 -1。

示例 1:

输入: haystack = "hello", needle = "ll"
输出: 2
示例 2:

输入: haystack = "aaaaa", needle = "bba"
输出: -1
说明:

对于本题而言，当 needle 是空字符串时我们应当返回 0 。
 */
class MyStrStr
{
    function solution1($haystack, $needle) {
        if (empty($needle)) return -1;
        $len = $haystack;
        $len2 = $needle;
        if ($len < $len2) return -1;
        if ($len == $len2) {
            if ($haystack == $needle) return 0;
            return -1;
        }
        for($i = 0; $i < $len; $i++) {
            // 如果要匹配的字符串个数 > 后面还没有找的字符串，退出
            if ($len - $i < $len2) return -1;
            // 防止越界
            $last = $i + $len2;
            if ($last >= $len) {
                $last = $len;
            }
            $ss = "";
            for($j = $i; $j < $last; $j++) {
                $ss .= $haystack[$j];
            }
            if ($ss == $needle) return $i;
        }

        return -1;
    }
}