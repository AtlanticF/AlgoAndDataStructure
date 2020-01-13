<?php
/**
 * Created by PhpStorm.
 * User: matt
 * Date: 2019/12/30
 * Time: 下午4:33
 */

include 'HttpServer.php';

class DynamicHttpServer extends HttpServer
{
    // cgi 程序根目录
    protected $cgiRoot;
    // cgi 程序后缀
    protected $cgiExtension = 'php';
    
    public function __construct(string $host, int $port, string $webRoot, string $cgiRoot, string $cgiExtension)
    {
        parent::__construct($host, $port, $webRoot);
        $this->cgiRoot = $cgiRoot;
        $this->cgiExtension = $cgiExtension;
    }

    public function requestHandler($request)
    {
        // 解析请求
        $requestArr = explode(' ', $request);
        if (count($requestArr) < 2) {
            return '';
        }
        $uri = $requestArr[1];
        if ($uri == '/favicon.ico') {
            return '';
        }
        // http://localhost:9111/user.php?id=1
        $queryString = '';
        if (strpos($uri, '?')) {
            $uriArr = explode('?', $uri);
            // 请求的 cgi 文件
            $uri = $uriArr[0];
            $queryString = isset($uriArr[1]) ? $uriArr[1] : '';
        }
        $filename = $this->webRoot . $uri;
        if ($this->cgiCheck($uri)) {
            if (!file_exists($filename)) {
                return $this->notFound();
            }
            // 请求参数写入环境变量让 cgi 程序读取
            $this->setEnv($queryString);
            // 扩展成一个二进制?
            echo 'request file: '. $filename . "\n";
            $response = exec('/usr/bin/php ' . $filename);
//            $response = pcntl_exec('/usr/bin/php', [$filename]);
            return $this->addHeader($response);
        } elseif (file_exists($filename)) {
            return $this->addHeader(file_get_contents($filename));
        } else {
            return $this->notFound();
        }
    }
    
    protected function cgiProcess($filename)
    {
        if (empty($filename)) {
            return false;
        }
        
        $pid = pcntl_fork();
        if ($pid == 0) {
            // 子进程
            if (!pcntl_exec('/usr/bin/php', [$filename])) {
                echo "Error: cgi run error.\n";
            }
            // 退出子进程
            exit();
        } elseif ($pid > 0) {
            // 父进程，返回子进程的 pid
        } else {
            echo "Error: fork error.\n";
            exit();
        }
        
        return true;
    }
    
    protected function setEnv($queryString)
    {
        if (empty($queryString)) {
            return false;
        }
        
        if (strpos($queryString, '=')) {
            putenv("QUERY_STRING=" . $queryString);
        }
        
        return true;
    }
    
    protected function cgiCheck($uri)
    {
        $info = pathinfo($uri);
        $extension = isset($info['extension']) ? $info['extension'] : null;
        if ($this->cgiExtension == $extension) {
            return true;
        }
        
        return false;
    }
}