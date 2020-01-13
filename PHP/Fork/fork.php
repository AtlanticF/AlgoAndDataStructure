<?php
$childIds = [];
$fork_num = 3;

for ($i = 0; $i < $fork_num; $i++) {
    $pid = pcntl_fork();
    
    if ($pid == 0) {
        // 返回 0 进入子进程
        $childId = getmypid();
        echo "========= 子进程: {$childId} 开始 =========\n";
        sleep(3);
        echo "========= 子进程: {$childId} 完毕 =========\n";
        exit();
    } elseif ($pid > 0) {
        // 父进程得到子进程的 pid
        array_push($childIds, $pid);
    } else {
        echo "fork error\n";
    }
}

while (count($childIds) > 0) {
    foreach ($childIds as $key => $pid) {
        $res = pcntl_waitpid($pid, $status, WNOHANG);
        
        if ($res == -1 || $res > 0) {
            unset($childIds[$key]);
        }
    }
    
    sleep(1);
}