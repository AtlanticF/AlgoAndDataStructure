<?php

$socket = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
if (!$socket) {
    die('create socket fail.');
}

$host = '127.0.0.1';
$port = 9999;
$bind_res = socket_bind($socket, $host, $port);
if (!$bind_res) {
    die('bind socket fail.');
}

// 阻塞
socket_set_block($socket);
// 监听
socket_listen($socket, 4);
echo "waiting for client to connect, {$host}:{$port}\n";

while (1) {
    $recv_socket = socket_accept($socket);
    if ($recv_socket) {
        $buffer = socket_read($recv_socket, 8192);
        echo "recv data: {$buffer}";
        socket_write($recv_socket, "OK\n");
        socket_close($recv_socket);
    } else {
        usleep(100);
    }
}

socket_close($socket);
