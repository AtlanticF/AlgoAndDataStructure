<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 2019/12/30
 * Time: 上午11:23
 */

class HttpServer
{
    protected $host;
    protected $port;
    // 静态文件目录的绝对路径
    protected $webRoot;

    public function __construct(string $host, int $port, string $webRoot)
    {
        $this->host = $host;
        $this->port = $port;
        $this->webRoot = $webRoot;
    }

    public function start()
    {
        // 创建 socket
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        if ($socket < 0) {
            echo "Error: create socket, " . socket_strerror(socket_last_error($socket)) . "\n";
            exit();
        }
        // 绑定
        if (!socket_bind($socket, $this->host, $this->port)) {
            echo "Error: bind socket, " . socket_strerror(socket_last_error($socket)) . "\n";
            exit();
        }
        // 监听
        if (!socket_listen($socket)) {
            echo "Error: listen socket, " . socket_strerror(socket_last_error($socket)) . "\n";
            exit();
        }

        echo "{$this->host}:{$this->port} server start\n";

        while (true) {
            $client = null;
            try {
                // 阻塞，等待客户端连接
                $client = socket_accept($socket);
            } catch (Exception $e) {
                echo $e->getMessage();
                echo "Error: accept socket, " . socket_strerror(socket_last_error($socket)) . "\n";
            }

            try {
                // 从 socket 读数据
                $request = socket_read($client, 1024);
                // 处理读取的数据
                $response = $this->requestHandler($request);
                // 响应写回 socket
                socket_write($client, $response);
                // 关闭 socket
                socket_close($client);
            } catch (Exception $e) {
                echo $e->getMessage();
                echo "Error: socket read, " . socket_strerror(socket_last_error($socket)) . "\n";
            }
        }
    }

    public function requestHandler($request)
    {
        file_put_contents('/var/log/php-server/debug.log', $request . "\n", FILE_APPEND);
        // 解析请求，获取静态文件数据响应
        $requestArr = explode(" ", $request);
        // 没有请求参数
        if (count($requestArr) < 2) {
            return '';
        }

        $uri = $requestArr[1];
        if ($uri == '/favicon.ico') {
            return $this->addHeader('favicon');
        }
        if ($uri == '/') {
            $uri = '/index.html';
        }
        // 读取请求的静态文件
        $filename = $this->webRoot . $uri;
        echo "request: {$filename}\n";
        if (file_exists($filename)) {
            // 读取静态文件内容
            $content = file_get_contents($filename);
            return $this->addHeader($content);
        } else {
            return $this->notFound();
        }
    }

    protected function addHeader($content)
    {
        $header = "HTTP/1.1 200 OK\r\nContent-type: text/html; charset=utf-8\r\n\r\n";
        return $header . $content;
    }

    protected function notFound()
    {
        $content = '<h1> File Not Found </h1>';
        return "HTTP/1.1 404 File Not Found\r\nContent-type: text/html; charset=utf-8\r\n\r\n" . $content;
    }
}