<?php
/**
 * Class PackageProblem
 * 0 - 1 背包问题
 *
 * 有一个背包，他的承载重量是 Wkg。现在有 n 个不同同重量的物品，每个物品不可分割，在背包不超重的情况下，如何使背包中的物品总重量最大？
 */

class PackageProblem
{
    private $max = 0; // 背包可以存储总量的最大值
    private $mem = [[]]; // 已求解的存储

    public function main()
    {
        while ($input = trim(fgets(STDIN))) {
            $data = explode(" ", $input);
            $w = $data[0];
            $cnt = count($data);
            $data = array_slice($data, 1, $cnt - 1);
//            $this->calc2(0, 0, $data, count($data), $w);
            echo $this->calc3($data, $cnt - 1, $w) . PHP_EOL;
//            echo $this->max . PHP_EOL;
        }
    }

    /**
     * 递归 | 回溯解法
     * @param $i int 考察的第 i 个物品
     * @param $cw int 当前背包重量
     * @param $items array 要装的物品
     * @param $n int 物品个数
     * @param $w int 背包承重
     */
    private function calc(int $i, int $cw, array $items, int $n, int $w)
    {
        if ($cw == $w || $i == $n) {
            // 装满了、考察完所有的物品
            if ($cw > $this->max) {
                $this->max = $cw;
            }
            return;
        }
        // 不考虑当前物品直接进行下一个选择
        $this->calc($i + 1, $cw, $items, $n, $w);
        // 装入当前物品进入背包
        if ($cw + $items[$i] <= $w) {
            // 如果没有超过背包的承重，把当前的装入背包
            $this->calc($i + 1, $cw + $items[$i], $items, $n, $w);
        }
    }

    /**
     * 递归 ｜ 回溯解法 优化
     * @param int $i
     * @param int $cw
     * @param array $items
     * @param int $n
     * @param int $w
     */
    private function calc2(int $i, int $cw, array $items, int $n, int $w)
    {
        if ($cw == $w || $i == $n) {
            if ($cw > $this->max) $this->max = $cw;
            return;
        }
        // 如果已经处理过
        if (isset($this->mem[$i][$cw])) return;
        // 写入已处理
        $this->mem[$i][$cw] = true;

        // 不装第 i 个物品
        $this->calc2($i + 1, $cw, $items, $n, $w);
        if ($cw + $items[$i] <= $w) { // 如果装入不超重
            // 装第 i 个物品
            $this->calc2($i + 1, $cw + $items[$i], $items, $n, $w);
        }
    }

    /**
     * 动态规划 ｜ 状态转移
     * @param array $items 物品，元素值为重量
     * @param int $n n 个物品处理
     * @param int $w 背包最大容量
     * @return int
     */
    private function calc3(array $items, int $n, int $w): int
    {
        // [n][w]
        // n 表示第几个物品的决策
        // w 表示决策完第 n 个物品后当前背包的重量
        $states = [[]]; // 二维数组保存选择 "放/不放" 的状态，合并相同状态
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $w + 1; $j++) {
                $states[$i][$j] = false;
            }
        }
        // 特殊处理第一行数据，哨兵简化
        $states[0][0] = true; // 第 0 个物品不放入背包
        if ($items[0] <= $w) {
            $states[0][$items[0]] = true; // 第 0 个物品放入背包
        }
        // 动态规划状态转移
        for ($i = 1; $i < $n; $i++) {
            for ($j = 0; $j <= $w; $j++) { // 不放入第 i 个物品进入背包，那么每次都是 <= w 遍历
                // 上个阶段可达的状态为 [i - 1][j] ，如果可达，那么这个阶段可达 j 的不放置也可达
                if ($states[$i - 1][$j] == true) $states[$i][$j] = $states[$i - 1][$j];
            }
            for ($j = 0; $j <= $w - $items[$i]; $j++) { // 放入第 i 个物品进入背包
                if ($states[$i - 1][$j] == true) $states[$i][$j+$items[$i]] = true;
            }
        }
        // 输出结果，最后一个位置达到的重量
        for ($i = $w; $i > 0; $i--) {
            if ($states[$n - 1][$i] == true) return $i;
        }
        return 0;
    }
}

//(new PackageProblem())->main();

//$input = trim(fgets(STDIN));
$input = "183 bacad ad cda a dcccd aab bb cb cbd bacd dcbb dda b adcb dca ab adbd ab caa bbaba adad dc cbd ccddb cdc ab ad cb ddb bc bcdb cdcc bcbb dd abdd bda bad cdbb d dcb bc badcb cacc bbacb da dbadd cada bcbdc ddbca db ca ca d ad d ddcb bb ba bab adaca aba cbca aaddd cbccc c c bcdbb cdd dcabd d dd db dabad d acddc a ddcb daba daca b bba adb db c a accb aa dcab bdccc adbb a bacb cbdba aa ad cab cada bcba ccadc cba bd dad cc bcda dcaac acaad abada a cb c d ddac acb a ba acaa bdb cdb cada bc cccac d dcaa bd bcada dab ad dacb aaada dc dcccd acac dbdb cd acdac bbdbc caad cbc bdab dd abaa bc ada ba cbda a dbaa dabd cd aacdc bdcb bbcc ccca cac ddba cdcd dc aab b bbad bbdd bc adc cdab bba acad ca cbc a c c addbd caadb cbaa ab d bbbd c dcc ab c ba ccbb adad 1";
$input = explode(" ", $input);
$cnt = $input[0];
$words = [];
$k = end($input);

for($i = 1; $i <= $cnt; $i++) {
    $words[] = strtolower($input[$i]);
}

$target = strtolower($input[count($input) - 2]);
$e = [];
foreach($words as $word) {
    if ($word != $target) {
        $a = str_split($word);
        $b = str_split($target);
        sort($a);
        sort($b);
        if ($a == $b) {
            var_dump($word, $target);
            $e[] = $word;
        }
    }
}
if (!empty($e)) {
    sort($e);
    echo count($e) . PHP_EOL;
    echo $e[$k - 1] . PHP_EOL;
}