<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use SerializesModels;

    public $resetUrl;
    public $token;  

    public function __construct($resetUrl, $token)
    {
        $this->resetUrl = $resetUrl;
        $this->token = $token;
    }

    public function build()
    {
        return $this->view('auth.passwords.password-reset')
                    ->with([
                        'resetUrl' => $this->resetUrl,
                        'token' => $this->token,    
                    ])
                    ->subject('Aethir 비밀번호 재설정 링크입니다.');
    }
}
