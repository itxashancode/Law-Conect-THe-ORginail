<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LawyerRegistrationStatus extends Notification implements ShouldQueue
{
    use Queueable;

    public $status;
    public $lawyer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($lawyer, $status)
    {
        $this->lawyer = $lawyer;
        $this->status = $status;
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
        $mail = (new MailMessage)
                    ->subject('LegalCounsel — Application Status Update')
                    ->greeting('Hello ' . $this->lawyer->user->name . ',');

        if ($this->status === 'approved') {
            $mail->line('We are pleased to inform you that your Expert Counsel application has been approved.')
                 ->line('Your profile is now active on the LegalCounsel network.')
                 ->action('Access Your Dashboard', url('/login'));
        } elseif ($this->status === 'rejected') {
            $mail->line('We regret to inform you that your Expert Counsel application was not approved at this time.')
                 ->line('If you believe this is an error, please contact our support team.');
        } elseif ($this->status === 'suspended') {
            $mail->line('This is a formal notice that your Expert Counsel account has been temporarily suspended.')
                 ->line('Please contact LegalCounsel administration for further details regarding this action.');
        }

        $mail->line('Thank you for choosing LegalCounsel.')
             ->salutation('Best Regards, The LegalCounsel Team');

        return $mail;
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
