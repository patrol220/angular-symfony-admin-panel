<?php

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="users_settings", schema="users")
 * @ORM\Entity(repositoryClass="App\Repository\User\UserSettingsRepository")
 */
class UserSettings
{
    /**
     * @var $user User
     * @ORM\Id()
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\Column(name="user_id", nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="json")
     */
    private $notificationsSubscriptions = [];

    /**
     * @param array $notificationsSubscriptions
     */
    public function setNotificationsSubscriptions(array $notificationsSubscriptions): void
    {
        $this->notificationsSubscriptions = $notificationsSubscriptions;
    }

    /**
     * @return array
     */
    public function getNotificationsSubscriptions(): array
    {
        $notificationsSubscriptions = $this->notificationsSubscriptions;

        return array_unique($notificationsSubscriptions);
    }
}
