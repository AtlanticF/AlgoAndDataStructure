<?php
//require_once 'HttpServer.php';

//(new HttpServer('127.0.0.1', '9888', __DIR__))->start();

//require_once 'DynamicHttpServer.php';
//
//(new DynamicHttpServer('127.0.0.1', '9111', __DIR__, __DIR__, 'php'))->start();

require_once 'WebSocket.php';

(new WebSocket('127.0.0.1', '12345'))->start();