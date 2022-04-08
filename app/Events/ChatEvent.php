<?php

namespace App\Events;

use App\Http\Resources\Message\ConversationResource;
use App\Http\Resources\Message\MessageResource;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $response;
    private $to;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->queue = 'message';
        $this->tries = 3;
        $this->response = [
            'message' => new MessageResource($data['message']),
            'conversation' => new ConversationResource($data['conversation']),
            "text" => "Nuevo mensaje"
        ];

        $this->to = $data['to'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("chat-message.{$this->to}");
    }
}
