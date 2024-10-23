<?php

namespace App\Controller;

use App\Repository\FormationRepository;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FormationController extends AbstractController
{
    #[Route('formation', name: 'list_formation')]
    public function list(FormationRepository $formationRepository, SessionRepository $sessionRepository): Response
    {
        $formations = $formationRepository->findAll();
        $sessions = $sessionRepository->findAll();

        return $this->render('formation/list.html.twig', [
            'formations' => $formations,
            'sessions' => $sessions,
        ]);
    }
}
