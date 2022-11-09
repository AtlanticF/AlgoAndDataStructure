<?php
/**
 * Class Conversion
 * 进制转换[华为]
 *
 * 写出一个程序，接受一个十六进制的数，输出该数值的十进制表示。
 *
 * 输入一个十六进制的数值字符串。注意：一个用例会同时有多组输入数据.输出该数值的十进制字符串。不同组的测试用例用\n隔开。
 */

class Conversion
{
    public function main() {
        while ($str = fgets(STDIN)) {
            echo hexdec($str) . PHP_EOL;
        }
    }
}

(new Conversion())->main();