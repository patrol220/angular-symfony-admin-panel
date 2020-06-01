<?php

namespace App\Dto\User;

class UserDto {
    private $data;

    public function __construct(UserDataDto $userDataDto)
    {
        $this->data = $userDataDto;
    }

    /**
     * @return UserDataDto
     */
    public function getData(): UserDataDto
    {
        return $this->data;
    }
}
