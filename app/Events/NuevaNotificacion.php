<?php

namespace App\Events;

use App\Http\Resources\NotificacionResource;
use App\Models\Notificacion;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NuevaNotificacion implements ShouldBroadcast
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


    // public function broadcastWith(): array
    // {
    //     return [
    //         'id'           => $this->notificacion->id,
    //         'tipo'         => $this->notificacion->tipo,
    //         'titulo'       => $this->notificacion->titulo,
    //         'mensaje'      => $this->notificacion->mensaje,
    //         'leido'        => $this->notificacion->leido,
    //         'referencia_id'=> $this->notificacion->referencia_id,
    //         'referencia_type' => $this->notificacion->referencia_type,
    //         'referencia'   => $this->notificacion->referencia,
    //     ];
    // }
}
