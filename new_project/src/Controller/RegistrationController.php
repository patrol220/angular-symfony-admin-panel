<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController
{

    /**
     * @Route("api/register", name="register_user", methods={"POST"})
     */
    public function register(UserService $userService, Request $request)
    {
        $userData = json_decode($request->getContent(), true);

        try {
            $newUser = $userService->createNewUser(
                trim($userData['username']),
                trim($userData['password']),
                trim($userData['email'])
            );
        } catch (HttpException $exception) {
            return new JsonResponse(
                [
                    'message' => empty($exception->getMessage()) ? 'error' : $exception->getMessage()
                ],
                $exception->getStatusCode()
            );
        }

        return new JsonResponse(
            [
                'id' => $newUser->getId()
            ],
            Response::HTTP_CREATED
        );
    }
}
