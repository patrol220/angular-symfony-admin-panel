<?php

namespace App\Service;

use App\Dto\Request\IncludesDto;
use App\Dto\User\UserDto;
use App\Entity\User\User;
use App\Entity\User\UserInterface;
use App\Entity\User\UserSettings;
use App\Repository\User\UserRepository;
use App\Transformer\UserTransformer;
use Doctrine\ORM\EntityManagerInterface;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use phpDocumentor\Reflection\Types\This;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    const USER_USERNAME_LENGTH_MIN = 3;
    const USER_PASSWORD_LENGTH_MIN = 6;

    private $entityManager;
    private $passwordEncoder;
    private $fractal;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->fractal = new Manager();
    }

    public function createNewUser($username, $password, $email): User
    {
        if (empty($username) || empty($password) || empty($email)) {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, 'Value cannot be empty');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, 'Wrong email');
        }

        if (strlen($username) < self::USER_USERNAME_LENGTH_MIN) {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, 'Username too short');
        }

        if (strlen($password) < self::USER_PASSWORD_LENGTH_MIN) {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, 'Password too short');
        }

        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(
            [
                'email' => $email,
            ]
        );

        if ($existingUser !== null) {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, 'email already taken');
        }

        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(
            [
                'username' => $username,
            ]
        );

        if ($existingUser !== null) {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, 'username already taken');
        }

        $user = new User();
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, $password)
        );
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setRoles(['ROLE_ADMIN']);

        $settings = new UserSettings();
        $settings->setUser($user);
        $user->setSettings($settings);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function getUser(string $username, IncludesDto $includesDto): array
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(
            [
                'username' => $username
            ]
        );

        if ($includesDto->getIncludes() !== null) {
            $this->fractal->parseIncludes($includesDto->getIncludes());
        }
        $resource = new Item($user, new UserTransformer());

        return $this->fractal->createData($resource)->toArray();
    }

    public function updateUser(UserDto $user)
    {
        /** @var UserRepository $userRepository */
        $userRepository = $this->entityManager->getRepository(User::class);
        $userEntity = $userRepository->findOneBy([
            'username' => $user->getData()->getUsername()
        ]);

        $includes = [];

        if ($userSettingsData = $user->getData()->getSettings() !== null) {
            $includes = ['settings'];
            $userSettingsData = $user->getData()->getSettings()->getData();
            $settingsEntity = $userEntity->getSettings();

            $settingsEntity->setNotificationsSubscriptions($userSettingsData->getNotificationsSubscriptions());

            $userEntity->setSettings($settingsEntity);
        }

        $this->entityManager->flush();

        $this->fractal->parseIncludes($includes);
        $resource = new Item($userEntity, new UserTransformer());

        return $this->fractal->createData($resource)->toArray();
    }
}
