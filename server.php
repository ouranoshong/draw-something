<?php
use Workerman\Worker;
require_once './vendor/autoload.php';

// Create a Websocket server
$ws_worker = new Worker("websocket://0.0.0.0:2346");

// 4 processes
$ws_worker->count = 4;

// Emitted when new connection come
$ws_worker->onConnect = function($connection)
{
	echo var_export($connection, true) . PHP_EOL;
    echo "New connection\n";
};

// Emitted when data received
$ws_worker->onMessage = function($connection, $data)
{
    // Send hello $data
    $connection->send('hello ' . $data . " " . date("Y-m-d h:i:s"));
};

// Emitted when connection closed
$ws_worker->onClose = function($connection)
{
    echo "Connection closed\n";
};

// Run worker
Worker::runAll();
