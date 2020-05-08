<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("api/logout", name="app_logout")
     */
    public function logout()
    {
        $lexikJwtCookieName = $this->getParameter('lexik_jwt_cookie_name');
        $response = new Response();
        $response->headers->clearCookie($lexikJwtCookieName);
        $response->setStatusCode(Response::HTTP_OK);

        return $response;
    }
}
