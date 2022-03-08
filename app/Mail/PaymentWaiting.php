<?php

namespace App\Mail;

use App\Payment;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentWaiting extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->to($this->user->email, $this->user->name)
            ->replyTo(config('app.email_reply_to'))
            ->subject('Aguardando confirmação de pagamento')
            ->view('vendor.mail.html.payment_waiting')
            ->with(['user' => $this->user]);
    }
}
