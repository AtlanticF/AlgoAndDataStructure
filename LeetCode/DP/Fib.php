<?php

/**
 * 斐波那契数列
 * f(0) = 0 f(1) = 1 f(n)=f(n-1)+f(n-2)
 */

class Fib
{
    public function solution1($n)
    {
        if ($n == 0) {
            return 0;
        }
        if ($n == 1) {
            return 1;
        }

        return $this->solution1($n - 1) + $this->solution1($n - 2);
    }

    public function solution2($n)
    {
        $dp = [];
        $dp[0] = 0;
        $dp[1] = 1;
        for ($i = 2; $i <= $n; $i++) {
            $dp[$i] = $dp[$i - 1] + $dp[$i - 2];
        }

        return $dp[$n];
    }
}

$obj = new Fib();
echo "递归：" . $obj->solution1(10) . "\n";
echo "DP：" . $obj->solution2(45) . "\n";