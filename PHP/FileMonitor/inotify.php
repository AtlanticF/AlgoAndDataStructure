<?php
/**
 * 文件监控 iNotify 方式
 * 需要扩展 iNotify
 */

$notify = inotify_init();
$path = realpath(__DIR__);
$watch = inotify_add_watch($notify, $path, IN_ALL_EVENTS);

while (1) {
    sleep(1);
    $events = inotify_read($notify);
    if (!empty($events)) {
        foreach ($events as $event) {
            echo "iNotify Events: {$event['name']}, mask: {$event['mask']}\n";
        }
    }
}

inotify_rm_watch($notify, $watch);
fclose($notify);