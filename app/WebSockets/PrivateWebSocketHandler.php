<?php

namespace App\WebSockets;

use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;
use BeyondCode\LaravelWebSockets\WebSockets\WebSocketHandler;

class PrivateWebSocketHandler extends WebSocketHandler {
    public function onClose(ConnectionInterface $connection) {
        parent::onClose($connection);
    }
}
