<?php

namespace App\Dto\User;

class UserSettingsDataDto
{
    private $notificationsSubscriptions;

    public function __construct(
        array $notificationsSubscriptions
    ) {
        $this->notificationsSubscriptions = $notificationsSubscriptions;
    }

    /**
     * @return array
     */
    public function getNotificationsSubscriptions(): array
    {
        return $this->notificationsSubscriptions;
    }
}
