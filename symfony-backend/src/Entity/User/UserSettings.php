<?php

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="users_settings", schema="users")
 * @ORM\Entity(repositoryClass="App\Repository\User\UserSettingsRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class UserSettings
{
    /**
     * @var $user User
     * @ORM\Id()
     * @ORM\OneToOne(targetEntity="User", inversedBy="settings", fetch="LAZY")
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

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
