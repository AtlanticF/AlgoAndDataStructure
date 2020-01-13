<?php
/**
 * Websocket server
 * Base RFC 6455
 */

class WebSocket
{
    protected $host;
    protected $port;
    protected $backLog;
    // websocket http 升级字段
    protected $upgrade = 'websocket';
    protected $httpProtocol = 'HTTP/1.1';
    protected $guid = '258EAFA5-E914-47DA-95CA-C5AB0DC85B11';
    protected $headerValuesSecAccepted;
    
    protected $hasHandshake = false;

    public function __construct(string $host, int $port, int $backLog = 10)
    {
        $this->host = $host;
        $this->port = $port;
        $this->backLog = $backLog;
    }
    
    public function start()
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (!$socket) {
            $this->log('Error: create_socket', $socket);
            exit();
        }
        if (!socket_bind($socket, $this->host, $this->port)) {
            $this->log('Error: bind_socket', $socket);
            exit();
        }
        if (!socket_listen($socket, $this->backLog)) {
            $this->log('Error: socket_listen', $socket);
            exit();
        }
        
        echo "{$this->host}:{$this->port} server start!\n";
        
        while (true) {
            $client = null;
            try {
                $client = socket_accept($socket);
            } catch (Exception $e) {
                echo $e->getMessage() . "\n";
                $this->log('Error: socket_accept', $client);
            }
            // handshake
            if (false === $this->hasHandshake) {
                if (true !== $this->handshake($client)) {
                    $this->log('handshake failed!');
                    exit();
                }
                $this->hasHandshake = true;
                $this->log('handshake succeeded! waiting for data recv');
            }
            $recv = socket_read($client, 1024);
            $this->log('server: received client data');
            echo $recv . PHP_EOL;
            socket_write($client, 'ok');
            socket_close($client);
//            $response = $this->handlerRequest($recv);
//            socket_write($client, $response);
//            socket_close($client);
        }
    }
    
    protected function handshake($socket)
    {
        $this->log("start handshake!");
        if (!socket_recv($socket, $buffer, 1024, 0)) {
            $this->log('Error: socket_recv', $socket);
            exit();
        }
        $reqArr = explode(PHP_EOL, $buffer);
        if (!$this->isHttp($reqArr[0])) {
            return '';
        }
        if (!$this->isUpgradeWebsocket($reqArr[6])) {
            return '';
        }
        // 获取 Sec-WebSocket-Key
        $key = $this->getWebsocketKey($reqArr[11]);
        $this->setWebsocketAccept($key);
        // 响应 client 完成 handshake
        /**
         * HTTP/1.1 101 Switching Protocols
         * Upgrade: websocket
         * Connection: Upgrade
         * Sec-Websocket-Accept:
         * Sec-Websocket-Location: ws://example.com/
         */
        $response = $this->addHeader();
        if (!socket_write($socket, $response)) {
            $this->log('Error: socket_write', $socket);
            exit();
        }
        
        return true;
    }
    
    protected function addHeader($content = '')
    {
        $header = "HTTP/1.1 101 Switching Protocols\r\nUpgrade: websocket\r\nConnection: Upgrade\r\nSec-WebSocket-Accept: {$this->headerValuesSecAccepted}\r\nSec-WebSocket-Version: 13\r\nSec-WebSocket-Location: ws://{$this->host}:{$this->port}/\r\n\r\n";
        return $header . $content;
    }
    
//    protected function handlerRequest($data)
//    {
//        $reqArr = explode(PHP_EOL, $data);
//        // header
//        if (!$this->isHttp($reqArr[0])) {
//            return '';
//        }
//        // upgrade
//        if (!$this->isUpgradeWebsocket($reqArr[1])) {
//            return '';
//        }
//        // 获取 Sec-WebSocket-Key
//        $key = $this->getWebsocketKey($reqArr[5]);
//        $accept = $this->getWebsocketAccept($key);
//    }
    
    protected function setWebsocketAccept($key)
    {
        $this->headerValuesSecAccepted = base64_encode(sha1($key.$this->guid, true));
    }
    
    protected function getWebsocketKey($keyLine)
    {
        $key = '';
        $keyArr = explode(':', $keyLine);
        if (!empty($keyArr[0]) && trim($keyArr[0]) == 'Sec-WebSocket-Key') {
            if (!empty($keyArr[1])) {
                $key = trim($keyArr[1]);
            }
        }

        return $key;
    }
    
    protected function isHttp($headerLine)
    {
        $headerArr = explode(' ', $headerLine);
        if (!empty($headerArr[2] && trim($headerArr[2]) == $this->httpProtocol)) {
            return true;
        }
        
        return false;
    }
    
    protected function isUpgradeWebsocket($upgradeLine)
    {
        $upgradeArr = explode(':', $upgradeLine);
        if (!empty($upgradeArr[0]) && trim($upgradeArr[0]) == 'Upgrade') {
            if (!empty($upgradeArr[1]) && trim($upgradeArr[1]) == $this->upgrade) {
                return true;
            }
        }
        
        return false;
    }
    
    protected function log($msg, $socket = null)
    {
        $content = $msg;
        if (null !== $socket) {
            $content = $msg . ' ' . socket_strerror(socket_last_error($socket));
        }
        echo $content . PHP_EOL;
    }
}