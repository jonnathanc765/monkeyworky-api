<?php

namespace App\Events;

use App\Http\Resources\Notification\NotificationResource;
use App\Http\Resources\Order\OrderResource;
use App\Models\Notification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $response;
    private $to;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($to, $order)
    {
        $this->queue = 'orders';
        $this->tries = 3;

        $notification = Notification::create(["user_id" => $to, "type" => 'newOrder', "description" => json_encode([
            "data" => $order,
            "message" => "{$order->user->people->firstname} {$order->user->people->lastname} realizó una orden"
        ])]);

        $this->response = [
            "data" => new OrderResource($order),
            "notification" => new NotificationResource($notification)
        ];

        $this->to = $to;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("new-order.{$this->to}");
    }
}
