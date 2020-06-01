<?php

namespace App\Transformer;

use App\Entity\User\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract {

    protected $availableIncludes = [
        'settings'
    ];

    public function transform(User $user)
    {
        return [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'roles' => $user->getRoles(),
            'email' => $user->getEmail()
        ];
    }

    public function includeSettings(User $user) {
        if ($user->getSettings() === null) {
            return null;
        }

        return $this->item($user->getSettings(), new UserSettingsTransformer());
    }
}
