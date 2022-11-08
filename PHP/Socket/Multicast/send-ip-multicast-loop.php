<?php

$opt = getopt('l');
$multicastLoopOpt = isset($opt['l']);
$socket = socket_create(AF_INET, SOCK_DGRAM, IPPROTO_IP);
if ($socket < 0) {
    echo "Error: create socket, " . socket_strerror(socket_last_error($socket)) . "\n";
    exit();
}
// open multicast loop set true
if (!socket_set_option($socket, IPPROTO_IP, IP_MULTICAST_LOOP, $multicastLoopOpt)) {
    echo "Error: socket set option, " . socket_strerror(socket_last_error($socket)) . "\n";
    exit();
}
// send data to group
$groupAddr = "234.2.3.4";
$groupPort = 7891;
if (!socket_sendto($socket, "test", strlen("test"), 0, $groupAddr, $groupPort)) {
    echo "Error: socket sendto, " . socket_strerror(socket_last_error($socket)) . "\n";
    exit();
}