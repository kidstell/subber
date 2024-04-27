<?php

namespace App\Notifications;

use Exception;
use App\Models\ContentLog;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Markdown;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewPostNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public ContentLog $article)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('You have a new post notification from '.$notifiable->website)
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line("You are receiving this notification because you are subscribed to {$notifiable->website}. If you do wish to unsubscribe, please call the customer service.\n")
                    ->line('')
                    ->line(Markdown::parse("> **_Title_**: {$notifiable->title}  \n**_Text_**: {$notifiable->body}"))
                    ->line('')
                    ->line('Thank you for using our Subber!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
