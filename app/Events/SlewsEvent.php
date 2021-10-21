<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SlewsEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $event;

    public function __construct($event)
    {
        $this->event= $event;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('public-channel');
    }

    public function broadcastWith()
    {   
        // $json = \json_decode($this->event->value);
        // $array = \json_decode($json);
        return [
            'event' => $this->event,
        ];
    }
}
