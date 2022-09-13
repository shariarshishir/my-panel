<?php



namespace App\Notifications;



use Illuminate\Bus\Queueable;

use Illuminate\Notifications\Notification;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Messages\MailMessage;



class BuyerWantToContactFromProduct extends Notification

{

    use Queueable;



    public $notification_data;



    /**

     * Create a new notification instance.

     *

     * @return void

     */

    public function __construct($data)

    {

        $this->notification_data=$data;

    }



    /**

     * Get the notification's delivery channels.

     *

     * @param  mixed  $notifiable

     * @return array

     */

    public function via($notifiable)

    {

        return ['database', 'mail'];

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

            ->greeting('Hello!')

            ->line('Buyer want to contact with you regarding your product named'.$this->notification_data['title'])

            ->action('Show Message', url($this->notification_data['url']))

            ->line('Thank you for using our application!');

    }



    /**

     * Get the array representation of the notification.

     *

     * @param  mixed  $notifiable

     * @return array

     */

    public function toDatabase($notifiable)

    {

        return [

            'title' => 'Buyer want to contact with you',

            'url' => $this->notification_data['url'],

        ];

    }

}

