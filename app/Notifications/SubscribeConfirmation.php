<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class SubscribeConfirmation extends Notification
{
    use Queueable;

    private Subscription $subscription;

    /**
     * Create a new notification instance.
     */
    public function __construct(Subscription $subscription)
    {
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
        $message = (new MailMessage)
            ->subject(__('subscription.subscribeConfirmation'))
            ->greeting(__('general.mail.greeting', ['nickname' => $this->subscription->nickname]))
            ->line(__('subscription.subscribeConfirmationText'))
            ->line(new HtmlString('<b>' . $this->subscription->shift->buildShiftInfoForEmail() . '</b>'))
            ->salutation(new HtmlString(__('general.mail.salutation')))
        ;
        
        // Add contact info if the shift has it
        if ($this->subscription->shift->hasContactInfo()) {
            if ($this->subscription->shift->contact_name) {
                $message->line(__('subscription.subscribeConfirmationContactInfo_withName', ['contact_info' => $this->subscription->shift->getContactInfo()]));
            } else {
                $message->line(__('subscription.subscribeConfirmationContactInfo_withoutName', ['contact_info' => $this->subscription->shift->getContactInfo()]));
            }
        }

        return $message;
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
