<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PriceChangedNotification extends Notification
{
    use Queueable;

    protected $price;
    protected $link;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($price, $link)
    {
        $this->price = $price;
        $this->link = $link;
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
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->line('Ціна на оголошенні змінилася!')
            ->line('Нова ціна: ' . $this->price)
            ->action('Переглянути оголошення', $this->link)
            ->line('Дякуємо за використання нашого сервісу!');
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
