<?php

namespace App\Controller;

use App\Repository\InternRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InternController extends AbstractController
{
    #[Route('intern', name: 'list_intern')]
    public function list(InternRepository $internRepository): Response
    {
        $interns = $internRepository->findAll();

        return $this->render('intern/list.html.twig', [
            'interns' => $interns,
        ]);
    }
}
