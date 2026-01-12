<?php


namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TestEvent implements ShouldBroadcast
{
    use SerializesModels;

    public $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    // canal público
    public function broadcastOn()
    {
        return new Channel('test-channel');
    }

    // nombre del evento (en frontend escucharás '.test-event')
    public function broadcastAs()
    {
        return 'test-event';
    }

    // opcional: datos enviados
    public function broadcastWith()
    {
        return ['message' => $this->message];
    }
}
