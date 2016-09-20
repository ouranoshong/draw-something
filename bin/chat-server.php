<?php
/**
 * Created by PhpStorm.
 * User: hong
 * Date: 8/24/16
 * Time: 10:29 AM
 */

require dirname(__DIR__) . '/vendor/autoload.php';

use Ratchet\Server\IoServer;
use Ace\Chat;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

//$server = IoServer::factory(
//    new Chat(),
//    8080
//);


$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8080
);


$server->run();
