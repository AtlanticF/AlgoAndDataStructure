<?php
/**
 * 文件监控 检查 mtime 方式
 */

$monitor_dir = __DIR__ ;
$last_mtime = time();
function check()
{
    global $last_mtime;
    global $monitor_dir;
    $dir_iterator = new RecursiveDirectoryIterator($monitor_dir);
    $iterator = new RecursiveIteratorIterator($dir_iterator);
    foreach ($iterator as $file) {
        // 检查 php 文件
        if (pathinfo($file, PATHINFO_EXTENSION) != 'php') {
            continue;
        }
        if ($last_mtime < $file->getMTime()) {
            echo $file . " update and reload\n";
            $last_mtime = $file->getMTime();
            // 重启相关服务
            exit('reload serve');
        }
    }
}

while (true) {
    sleep(1);
    check();
}
