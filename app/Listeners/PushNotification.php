<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use JPush\Client;

class PushNotification
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function handle($event)
    {
        //本地环境默认不推送
        if (app()->environment('local')) {
            return;
        }
        $user = $notification->notifiable;
        //没有registration_id的不推送
        if (!$user->registration_id) {
            return;
        }
        //推送消息
        $this->client->push()
            ->setPlatform('all')
            ->addRegistrationId($user->registration_id)
            ->setNotificationAlert(strip_tags($notification->data['reply_content']))
            ->send();
    }
}
