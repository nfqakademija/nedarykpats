<?php

namespace App\Controller\api;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController
{

    /**
     * @Route("api/public/user", name="api_get_user", requirements={"GET"})
     * @return Response
     */
    public function getUser(): Response
    {
        return new Response('', Response::HTTP_FORBIDDEN);
    }

    /**
     * @Route("api/public/user/login", name="api_login", requirements={"GET"})
     * @return Response
     */
    public function login(): Response
    {
        return new Response('', Response::HTTP_FORBIDDEN);
    }

    /**
     * @Route("api/public/user/send_login_link", name="api_send_login_link", requirements={"GET"})
     * @return Response
     */
    public function sendLoginLink(): Response
    {
        return new Response('', Response::HTTP_FORBIDDEN);
    }

    /**
     * @Route("api/public/user", name="api_register", requirements={"POST"})
     * @return Response
     */
    public function register(): Response
    {
        return new Response('', Response::HTTP_FORBIDDEN);
    }
}
