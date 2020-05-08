<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    const USER_USERNAME_LENGTH_MIN = 3;
    const USER_PASSWORD_LENGTH_MIN = 6;

    private $entityManager;
    private $passwordEncoder;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
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

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
