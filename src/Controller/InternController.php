<?php

namespace App\Controller;

use DateTime;
use App\Entity\Intern;
use App\Form\InternFormType;
use App\Repository\InternRepository;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    // Méthode d'ajout de stagiaire
    #[Route('intern/new', name: 'new_intern')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $intern = new Intern();

        // Crée le formulaire sur le modele de la classe Intern généré par la console
        $form = $this->createForm(InternFormType::class, $intern);

        // Gère la requete pour remplir le formulaire avec les données soumises
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // Persiste les données de la classe Intern dans la BDD
            $entityManager->persist($intern);

            // Sauvegarde les changements en BDD
            $entityManager->flush();

            // Redirige apres soumission
            return $this->redirectToRoute('list_intern');
        }

        // Si le formulaire n'a pas encore été soumis, affiche le formulaire
        return $this->render('intern/new.html.twig', [
            'formAddIntern' => $form,
        ]);
    }

    // Méthode de suppression d'un Intern 
    #[Route('intern/delete/{id}', name: 'delete_intern')]
    public function delete(Intern $intern, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($intern);
        $entityManager->flush();

        return $this->redirectToRoute('list_intern', [
            'intern' => $intern,
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
