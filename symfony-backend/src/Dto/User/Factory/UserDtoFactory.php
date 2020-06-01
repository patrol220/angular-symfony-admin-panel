<?php

namespace App\Dto\User\Factory;

use App\Dto\User\UserDataDto;
use App\Dto\User\UserDto;
use App\Dto\User\UserSettingsDataDto;
use App\Dto\User\UserSettingsDto;
use Symfony\Component\HttpFoundation\Request;

class UserDtoFactory
{
    public static function createFromRequest(Request $request): UserDto
    {
        $requestContent = json_decode($request->getContent(), true);

        $userData = $requestContent['data'];

        if (array_key_exists('settings', $userData)) {
            $settingsData = $userData['settings']['data'];

            $userSettingsDataDto = new UserSettingsDataDto(
                $settingsData['notifications_subscriptions']
            );

            $userSettingsDto = new UserSettingsDto($userSettingsDataDto);
        } else {
            $userSettingsDto = null;
        }

        $userDataDto = new UserDataDto(
            $userData['username'],
            $userData['roles'],
            $userData['email'],
            $userSettingsDto
        );

        return new UserDto($userDataDto);
    }

    public static function createFromUpdateCurrentlyLoggedUserRequest(string $username, Request $request)
    {
        $requestContent = json_decode($request->getContent(), true);

        $userData = $requestContent['data'];

        if (array_key_exists('settings', $userData)) {
            $settingsData = $userData['settings']['data'];

            $userSettingsDataDto = new UserSettingsDataDto(
                $settingsData['notifications_subscriptions']
            );

            $userSettingsDto = new UserSettingsDto($userSettingsDataDto);
        } else {
            $userSettingsDto = null;
        }

        $userDataDto = new UserDataDto(
            $username,
            $userData['roles'],
            $userData['email'],
            $userSettingsDto
        );

        return new UserDto($userDataDto);
    }
}
