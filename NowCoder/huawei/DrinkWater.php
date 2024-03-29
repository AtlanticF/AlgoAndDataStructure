<?php
/**
 * Class DrinkWater
 * 喝汽水[华为]
 *
 * 有这样一道智力题：“某商店规定：三个空汽水瓶可以换一瓶汽水。
 * 小张手上有十个空汽水瓶，她最多可以换多少瓶汽水喝？”答案是5瓶，
 * 方法如下：先用9个空瓶子换3瓶汽水，喝掉3瓶满的，喝完以后4个空瓶子，用3个再换一瓶，喝掉这瓶满的，这时候剩2个空瓶子。
 * 然后你让老板先借给你一瓶汽水，喝掉这瓶满的，喝完以后用3个空瓶子换一瓶满的还给老板。如果小张手上有n个空汽水瓶，最多可以换多少瓶汽水喝？
 *
 * 输入文件最多包含10组测试数据，每个数据占一行，仅包含一个正整数n（1<=n<=100），表示小张手上的空汽水瓶数。n=0表示输入结束，你的程序不应当处理这一行。
 *
 * 对于每组测试数据，输出一行，表示最多可以喝的汽水瓶数。如果一瓶也喝不到，输出0。
 */

class DrinkWater
{
    public function main()
    {
        while ($n = fgets(STDIN)) {
            $n = intval($n);
            if ($n == 0) {
                break;
            } else {
                echo $this->f($n) . PHP_EOL;
            }
        }
    }

    private function f($n)
    {
        if ($n <= 0) {
            return 0;
        }
        if ($n == 1) {
            return 0;
        }
        if ($n == 2) {
            return 1;
        }

        // $n / 3 = 本次能换多少个瓶子
        // $n / 3 + $n % 3 = 本次换的瓶子 + 本次换剩下的瓶子个数
        // todo 2 -> 1
        return floor($n / 3) + $this->f(floor($n / 3) + $n % 3);

//        $drink = 0;
//        while ($n > 2) {
//            $drink += floor($n / 3); // 当前的能换多少瓶可以喝的
//            $remain = $drink % 3; // 当前换后还有的瓶数
//            $n = floor($n / 3) + $remain; // 换完了之后手上现有的瓶数
//            // 如果刚好是 2 个，++
//            if ($n == 2) {
//                ++$drink;
//            }
//        }
//
//        return $drink;
    }
}

(new DrinkWater())->main();