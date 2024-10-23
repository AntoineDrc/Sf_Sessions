<?php

namespace App\Controller;

use App\Entity\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    #[Route('/session{id}', name: 'detail_session')]
    public function detail(Session $session): Response
    {

        return $this->render('session/detail.html.twig', [
            'session' => $session,
        ]);
    }
}
