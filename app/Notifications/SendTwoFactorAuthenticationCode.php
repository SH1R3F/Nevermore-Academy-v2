<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;
use Illuminate\Notifications\Messages\MailMessage;

class SendTwoFactorAuthenticationCode extends Notification
{
    use Queueable;

    public $via;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($via)
    {
        $this->via = in_array($via, ['mail', 'sms']) ? $via : 'mail'; // Set mail as default
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [$this->via === 'sms' ? TwilioChannel::class : 'mail'];
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
            ->line('This is your two factor authentication code.')
            ->line('Please don\'t share it with anyone.')
            ->line($notifiable->two_fa_code);
    }

    /**
     * Get the sms representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \NotificationChannels\Twilio\TwilioSmsMessage
     */
    public function toTwilio($notifiable)
    {
        return (new TwilioSmsMessage)
            ->content("Your 2fa code for Nevermore is: {$notifiable->two_fa_code}");
    }
}
