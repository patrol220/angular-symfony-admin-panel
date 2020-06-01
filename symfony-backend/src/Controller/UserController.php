<?php

namespace App\Controller;

use App\Dto\Request\Factory\IncludesDtoFactory;
use App\Dto\User\Factory\UserDtoFactory;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("api/user", name="get_user", methods={"GET"})
     */
    public function getCurrentlyLoggedUser(Request $request, UserService $userService)
    {
        $includesDto = IncludesDtoFactory::createFromRequest($request);
        return new JsonResponse(
            $userService->getUser($this->getUser()->getUsername(), $includesDto)
        );
    }

    /**
     * @Route("api/user", name="update_user", methods={"PATCH"})
     */
    public function updateCurrentlyLoggedUser(Request $request, UserService $userService) {

        $user = UserDtoFactory::createFromUpdateCurrentlyLoggedUserRequest(
            $this->getUser()->getUsername(),
            $request
        );

        return new JsonResponse($userService->updateUser($user));
    }
}
