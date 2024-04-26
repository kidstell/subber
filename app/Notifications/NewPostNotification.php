<?php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewPostNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Article $article)
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
        $article = $this->article->author->toArray();
        $author = $article->author->toArray();
        
        return (new MailMessage)
                    ->subject('You have a new post notification from '.$author['website'])
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line("You are receiving this notification because you are subscribed to {$author['website']}. If you do wish to unsubscribe, please call the customer service.\n")
                    ->line('')
                    ->line('<blockquote style="margin: 0 0 0 40px; border-left: 2px solid #ccc; padding-left: 10px;">')
                    ->line("*Title*: {$article->title}")
                    ->line("*Text*: {$article->body}")
                    ->line('</blockquote>')
                    // ->action('Notification Action', url('/'))
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
