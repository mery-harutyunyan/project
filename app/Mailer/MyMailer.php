<?php
namespace App\Mailer;

use App\Models\User;
use Illuminate\Contracts\Mail\Mailer;

class MyMailer
{

    protected $mailer;

    protected $from = 'admin@example.com';

    protected $to;

    protected $view;

    protected $data = [];

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }


    public function sendMail()
    {
        $this->mailer->send($this->view, $this->data, function ($message) {
            $message->from($this->from, 'Administrator')
                ->to($this->to);
        });
    }

    public function emailVerification(User $user)
    {
        $this->to = $user->email;
        $this->view = 'emails.user_verification';
        $this->data = compact('user');
        $this->sendMail();
    }
}