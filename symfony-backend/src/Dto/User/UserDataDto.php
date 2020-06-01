<?php

namespace App\Dto\User;

class UserDataDto
{
    private $username;
    private $roles;
    private $email;
    private $settings;

    public function __construct(
        ?string $username,
        ?array $roles,
        ?string $email,
        ?UserSettingsDto $settings
    ) {
        $this->username = $username;
        $this->roles = $roles;
        $this->email = $email;
        $this->settings = $settings;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return array|null
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return UserSettingsDto|null
     */
    public function getSettings(): ?UserSettingsDto
    {
        return $this->settings;
    }
}
