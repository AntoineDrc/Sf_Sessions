<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Repository\SessionRepository;
use App\Repository\FormationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{
    #[Route('formations', name: 'list_formation')]
    public function list(FormationRepository $formationRepository): Response
    {
        $formations = $formationRepository->findBy([], ['name' => 'ASC']);

        return $this->render('formation/list.html.twig', [
            'formations' => $formations,
        ]);
    }

    #[Route('formation/{id}', name: 'listById_formation')]
    public function listByIdFormation($id, SessionRepository $sessionRepository, FormationRepository $formationRepository): Response
    {
    

        $formation = $formationRepository->find($id);

        $sessions = $sessionRepository->findBy(['formation' => $formation]);

        return $this->render('formation/listByIdFormation.html.twig', [
            'formation' => $formation,
            'sessions' => $sessions,
        ]);
    }
}
