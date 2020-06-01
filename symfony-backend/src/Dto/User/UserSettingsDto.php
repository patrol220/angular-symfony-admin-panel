<?php

namespace App\Dto\User;

class UserSettingsDto {
    private $data;

    public function __construct(UserSettingsDataDto $settingsDataDto)
    {
        $this->data = $settingsDataDto;
    }

    /**
     * @return UserSettingsDataDto
     */
    public function getData(): UserSettingsDataDto
    {
        return $this->data;
    }
}
