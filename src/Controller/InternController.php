<?php

namespace App\Controller;

use App\Entity\Intern;
use App\Repository\InternRepository;
use App\Repository\SessionRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InternController extends AbstractController
{

    // Méthode liste tout les Interns
    #[Route('intern', name: 'list_intern')]
    public function list(InternRepository $internRepository): Response
    {
        $interns = $internRepository->findAll();

        return $this->render('intern/list.html.twig', [
            'interns' => $interns,
        ]);
    }


    // Méthode détails d'un Intern
    #[Route('intern/{id}', name: 'detail_intern')]
    public function detail(Intern $intern): Response
    {
        
        // Distingue les session passées et à venir
        $now = new DateTime();
        $pastSessions = [];
        $futureSessions = [];

        foreach ($intern->getSessions() as $session)
        {
            if ($session->getStartDate() > $now)
            {
                $futureSessions[] = $session;
            }
            else 
            {
                $pastSessions[] = $session;
            }
        }

        return $this->render('intern/detail.html.twig', [
            'intern' => $intern,
            'pastSessions' => $pastSessions,
            'futureSessions' => $futureSessions,
        ]);
    }

}
