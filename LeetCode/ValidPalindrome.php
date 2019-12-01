<?php
/**
 * Class ValidPalindrome
 * 
 * leetcCode 125 | 验证回文串
 * 
 * 给定一个字符串，验证它是否是回文，只考虑字母和数字，可以忽略字母的大小写
 * 说明： 本题中，空字符串为有效的回文串
 */

class ValidPalindrome
{
    public function isPalindrome(string $str): bool 
    {
        $i = 0;
        $j = strlen($str) - 1;
        
        while ($i < $j) {
            while ($i < $j && !ctype_alnum($str[$i])) $i++;
            while ($i < $j && !ctype_alnum($str[$j])) $j--;
            if (strtolower($str[$i]) != strtolower($str[$j])) {
                return false;
            }
            $i++;
            $j--;
        }
        
        return true;
    }
}

$o = new ValidPalindrome();
var_dump($o->isPalindrome('aaccaa'));
var_dump($o->isPalindrome('aa bbaa'));