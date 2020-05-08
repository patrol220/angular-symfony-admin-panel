<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("user/{id}", name="user")
     */
    public function index(
        int $id
    ) {

    }

    /**
     * @Route("user/hi", name="user_hi")
     */
    public function hi(): Response
    {
        return new Response('<p>elo</p>');
    }
}