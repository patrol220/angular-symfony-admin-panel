<?php

namespace App\Transformer;

use App\Entity\Product\Product;
use App\Entity\User\UserSettings;
use DateTime;
use League\Fractal\TransformerAbstract;

class UserSettingsTransformer extends TransformerAbstract
{
    public function transform(UserSettings $userSettings)
    {
        return [
            'notifications_subscriptions' => $userSettings->getNotificationsSubscriptions()
        ];
    }
}
