<?php

namespace App\Notifications\Frontend\User;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderThanksNotification extends Notification
{
    use Queueable;

    public $order;
    public $attachment;

    public function __construct($order, $attachment)
    {
        $this->order = $order;
        $this->attachment = $attachment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject(__('general.place-order-subject', ['name' => $this->order->userAddress->name]))
            ->greeting(__('general.dear', ['name' => $notifiable->full_name]))
            ->line(__('general.place-order-line-one'))
            ->line(__('general.place-order-line-two'))
            ->attach($this->attachment, [
                'as' => 'order-'.$this->order->ref_id.'.pdf',
                'mime' => 'application/pdf',
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
