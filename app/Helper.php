<?php

use Swoole\Websocket\Frame;
use Hyperf\Server\ServerFactory;
use Hyperf\Utils\ApplicationContext;
use Swoole\WebSocket\Server as WebSocketServer;

if (!function_exists('redis')) {
    function redis()
    {
        return ApplicationContext::getContainer()->get(\Redis::class);
    }
}
if (!function_exists('server')) {
    function server()
    {
        return ApplicationContext::getContainer()->get(ServerFactory::class)->getServer()->getServer();
    }
}
if (!function_exists('frame')) {
    function frame()
    {
        return ApplicationContext::getContainer()->get(Frame::class);
    }
}
if (!function_exists('websocket')) {
    function websocket()
    {
        return ApplicationContext::getContainer()->get(WebSocketServer::class);
    }
}