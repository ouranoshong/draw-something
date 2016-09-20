<?php
/**
 * Created by PhpStorm.
 * User: hong
 * Date: 8/24/16
 * Time: 10:25 AM
 */

namespace Ace;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage();
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})".PHP_EOL;
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;

        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . PHP_EOL
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }

    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected".PHP_EOL;
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}".PHP_EOL;

        $conn->close();
    }

}
