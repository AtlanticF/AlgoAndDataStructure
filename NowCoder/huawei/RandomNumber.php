<?php
/**
 * Class RandomNumber
 * 明明的随机数[华为]
 *
 * 明明想在学校中请一些同学一起做一项问卷调查，为了实验的客观性，他先用计算机生成了N个1到1000之间的随机整数（N≤1000），
 * 对于其中重复的数字，只保留一个，把其余相同的数去掉，不同的数对应着不同的学生的学号。然后再把这些数从小到大排序，按照排好的顺序去找同学做调查。
 * 请你协助明明完成“去重”与“排序”的工作(同一个测试用例里可能会有多组数据，希望大家能正确处理)。
 *
 * 输入文件最多包含10组测试数据，每个数据占一行，仅包含一个正整数n（1<=n<=100），表示小张手上的空汽水瓶数。n=0表示输入结束，你的程序不应当处理这一行。
 *
 * 输入例子：三个数，[2, 2, 1]
 * 3
 * 2
 * 2
 * 1
 *
 * 输出: [1, 2]
 * 1
 * 2
 */

class RandomNumber
{
    public function main() {
        while ($cnt = fgets(STDIN)) {
            if (empty($cnt)) {
                break;
            }
            if ($cnt == 0) {
                break;
            }
            $cnt = intval($cnt);
            $tmp = [];
            while ($num = fgets(STDIN)) {
                $num = intval($num);
                // 保存数组
                $tmp[] = $num;
                $cnt--;
                if ($cnt <= 0) {
                    break;
                }
            }
            // 去重，排序，输出
            $tmp = array_unique($tmp);
            asort($tmp);
            foreach ($tmp as $item) {
                echo $item . PHP_EOL;
            }
        }
    }
}

//(new RandomNumber())->main();

//subs
//$a = [1, 2, 3];
//var_dump(array_chunk($a, 8));
//substr