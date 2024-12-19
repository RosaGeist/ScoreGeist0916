<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class CustomResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(Lang::get('Notificación de restablecimiento de contraseña')) // Personaliza el asunto
            ->greeting(Lang::get('¡Hola!'))
            ->line(Lang::get('Has recibido este correo porque se solicitó un restablecimiento de contraseña para tu cuenta en ScoreGeist.'))
            ->action(Lang::get('Restablecer Contraseña'), url(config('app.url').route('password.reset', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()], false)))
            ->line(Lang::get('Este enlace de restablecimiento de contraseña expirará en :count minutos.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
            ->line(Lang::get('Si no solicitaste un restablecimiento de contraseña, no es necesario que hagas nada.'))
            ->salutation(Lang::get('Saludos,') . "\n" . Lang::get('Equipo de ScoreGeist')); // Personaliza la despedida
    }
}
