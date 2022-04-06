<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FulljausNotification extends Notification
{
    use Queueable;

    /**
     * The module requesting the notification
     *
     * @var string
     */
    private $module;

    /**
     * The notification title
     *
     * @var string
     */
    private $title;

    /**
     * The notification description
     *
     * @var string
     */
    private $description;

    /**
     * The notification content
     *
     * @var string
     */
    private $content;

    /**
     * The notification url
     *
     * @var string
     */
    private $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($module, $title, $description, $content, $url)
    {
        $this->module = $module;
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->url = $url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'/*, 'mail'*/];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'module' => $this->module,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'url' => $this->url,
            'user_id' => auth()->user()->id,
            'user_name' => auth()->user()->name,
        ];
    }
}
