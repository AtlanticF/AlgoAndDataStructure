<?php

$opt = getopt('l');
$multicastLoopOpt = isset($opt['l']);
$host = '0.0.0.0';
$port = 7891;
$socket = socket_create(AF_INET, SOCK_DGRAM, IPPROTO_IP);
if ($socket < 0) {
    echo "Error: create socket, " . socket_strerror(socket_last_error($socket)) . "\n";
    exit();
}
if (!socket_bind($socket, $host, $port)) {
    echo "Error: bind socket, " . socket_strerror(socket_last_error($socket)) . "\n";
    exit();
}
// join group
if (!socket_set_option($socket, IPPROTO_IP, MCAST_JOIN_GROUP, ['group' => '234.2.3.4', 'interface' => 0])) {
    echo "Error: socket set option, " . socket_strerror(socket_last_error($socket)) . "\n";
    exit();
}
// close multicast loop
if (!socket_set_option($socket, IPPROTO_IP, IP_MULTICAST_LOOP, $multicastLoopOpt)) {
    echo "Error: socket set option, " . socket_strerror(socket_last_error($socket)) . "\n";
    exit();
}

// read data
$res = socket_read($socket, strlen("test"));
echo "Receive $res\n";