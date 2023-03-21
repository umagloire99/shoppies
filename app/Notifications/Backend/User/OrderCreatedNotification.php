<?php

namespace App\Notifications\Backend\User;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    public Order $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [ 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(__('general.place-order-subject', ['name' => $this->order->userAddress->name]))
            ->line('A new order has been placed. Status: '.$this->order->status())
            ->action('View Order', route('admin.orders.show', $this->order->id))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable): array
    {
        return $this->data();
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'data' => $this->data()
        ]);
    }

    protected function data(): array
    {
        return [
            'user_id' => $this->order->user_id,
            'user_name' => $this->order->user->full_name,
            'order_id' => $this->order->id,
            'amount' => $this->order->total,
            'order_url' => route('admin.orders.show', $this->order->id),
            'created_date' => $this->order->created_at->format('M d, Y'),
        ];
    }
}
