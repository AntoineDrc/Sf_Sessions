<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SessionModuleController extends AbstractController
{
    #[Route('/session/module', name: 'app_session_module')]
    public function index(): Response
    {
        return $this->render('session_module/index.html.twig', [
            'controller_name' => 'SessionModuleController',
        ]);
    }
}
