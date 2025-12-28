<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class UnsubscribeConfirmation extends Notification
{
    use Queueable;

    private string $unsubscribeLink;
    private Subscription $subscription;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $unsubscribeLink, Subscription $subscription)
    {
        $this->unsubscribeLink = $unsubscribeLink;
        $this->subscription = $subscription;
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
            ->subject(__('subscription.unsubscribeConfirmation'))
            ->greeting(__('general.mail.greeting', ['nickname' => $this->subscription->nickname]))
            ->line(__('subscription.confirmUnsubscribe'))
            ->action(__('subscription.buttonUnsubscribe'), $this->unsubscribeLink)
            ->line(__('subscription.confirmUnsubscribeShiftInfo'))
            ->line(new HtmlString('<b>' . $this->subscription->shift->buildShiftInfoForEmail() . '</b>'))
            ->line(__('subscription.confirmUnsubscribeEnd'))
            ->salutation(new HtmlString(__('general.mail.salutation')))
        ;
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
