<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class CreateOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return [
            // 'mail',
            'database'
        ]; // Send via Email and store in Database
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail($notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->subject('New Order Created - Order #' . $this->order->id)
    //         ->greeting('Hello ' . $notifiable->name . ',')
    //         ->line('A new order has been placed.')
    //         ->line('Order ID: ' . $this->order->id)
    //         ->line('Total Amount: $' . $this->order->final_total)
    //         ->action('View Order', url('/orders/' . $this->order->id))
    //         ->line('Thank you for using our service!');
    // }

    /**
     * Get the array representation of the notification (for database storage).
     */
    public function toArray($notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'message' => 'A new order <span class="text-gray-700">'. $this->order->order_code. '</span> has been placed ',
            'total_price' => $this->order->final_total,
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
