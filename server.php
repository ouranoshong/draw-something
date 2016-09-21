<?php
use Workerman\Worker;
require_once './vendor/autoload.php';

// Create a Websocket server
$ws_worker = new Worker("websocket://0.0.0.0:2346");

// 4 processes
$ws_worker->count = 1;

// Emitted when new connection come
$ws_worker->onConnect = function($connection)
{
    $connection->id = $connection->worker->id.$connection->id;

    echo "New connection, id: {$connection->id}\n" ;
};

// Emitted when data received
$ws_worker->onMessage = function($connection, $data)
{
    // Send hello $data
    // $connection->send($data);

    foreach($connection->worker->connections as $conn) {

    	if ($connection->id === $conn->id) continue;

    	echo 'Send connection '.$conn->id .' with message: '.$data. ' from connection '.$connection->id.PHP_EOL;

    	$conn->send($data);
    }

};

// Emitted when connection closed
$ws_worker->onClose = function($connection)
{
    echo "Connection {$connection->id} closed\n";
};

// Run worker
Worker::runAll();
