<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\HtmlString;

class ResetPassword extends \Illuminate\Auth\Notifications\ResetPassword
{
    /**
     * @inheritdoc
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject(__("auth.emailText.reset-password.subject"))
            ->greeting(__("auth.emailText.reset-password.greeting"))
            ->line(__("auth.emailText.reset-password.intro"))
            ->action(__("auth.emailText.reset-password.action"), $url)
            ->line(__("auth.emailText.reset-password.expire", ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(__("auth.emailText.reset-password.end"))
            ->salutation(new HtmlString(__("general.mail.salutation")));
    }
}