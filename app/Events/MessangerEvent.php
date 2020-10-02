<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessangerEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $type;
    protected $message;
    protected $to;

    public function __construct($type, $message, $to) {
        $this->type = $type;
        $this->message = $message;
        $this->to = $to;
    }
    
    public function broadcastOn() {
        return new PrivateChannel('messanger.'.$this->to);
    }

    public function broadcastWith() {
        return [
            'type'      =>      $this->type,
            'message'   =>      $this->message
        ];
    }
}
