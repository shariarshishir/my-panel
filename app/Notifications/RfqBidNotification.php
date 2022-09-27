<?php



namespace App\Notifications;



use Illuminate\Bus\Queueable;

use Illuminate\Notifications\Notification;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Messages\MailMessage;



class RfqBidNotification extends Notification

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

        return ['database'];

    }



    /**

     * Get the mail representation of the notification.

     *

     * @param  mixed  $notifiable

     * @return \Illuminate\Notifications\Messages\MailMessage

     */



    /**

     * Get the array representation of the notification.

     *

     * @param  mixed  $notifiable

     * @return array

     */

    public function toDatabase($notifiable)

    {

        return [

            'title'=>"New bid has created",
            'notification_data'=>$this->notification_data['bidData'],
            'url'=>$this->notification_data['url'],

        ];

    }

}

