<?php

namespace App\Events;

use App\Http\Resources\NotificacionResource;
use App\Models\Notificacion;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NuevaNotificacion implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
   

    public function __construct(public Notificacion $notificacion) {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
       return [
            new PrivateChannel('usuario.' . $this->notificacion->user_id),
        ];
    }

    public function broadcastAs()
{
    return 'nueva-notificacion';
}

    public function broadcastWith()
{
    return (new NotificacionResource(
        $this->notificacion->load('referencia')
    ))->resolve();

    
}



}
