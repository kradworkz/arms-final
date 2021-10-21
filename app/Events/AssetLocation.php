<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AssetLocation implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $event;
   
    public function __construct($event)
    {
        $this->event= $event;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('public-channel');
    }

    public function broadcastWith()
    {   
        // $json = \json_decode($this->event->value);
        // $array = \json_decode($json);
      
        return [
            'id' => $this->event->id,
            'code' => $this->event->code,
            'coordinates' => $this->event->coordinates,
            'status' => $this->event->status,
            'created_at' => $this->event->created_at,
        ];
    }
}
