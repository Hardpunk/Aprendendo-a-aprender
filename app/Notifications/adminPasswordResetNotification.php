<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class adminPasswordResetNotification extends Notification
{
    use Queueable;

    /**
     * @var $token
     */
    private $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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
        return (new MailMessage)
            ->subject('Solicitação de alteração de senha')
            ->line(__('You are receiving this email because we received a password reset request for your account.'))
            ->action(
                'Alterar senha',
                url(config('app.url').route('admin.password.reset', ['token' => $this->token], false))
            )
            ->line(__("This password reset link will expire in :count minutes.", ['count' => config('auth.passwords.admins.expire')]))
            ->line(__("If you did not request a password reset, no further action is required."));
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
