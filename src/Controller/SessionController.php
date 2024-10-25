<?php

namespace App\Controller;

use App\Entity\Intern;
use App\Entity\Session;
use App\Form\SessionFormType;
use App\Repository\InternRepository;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    // Méthode détail d'une Session
    #[Route('/session{id}', name: 'detail_session')]
    public function detail(Session $session, InternRepository $internRepository): Response
    {
        $nonInscrits = $internRepository->findNonInscrits($session->getId());

        return $this->render('session/detail.html.twig', [
            'session' => $session,
            'nonInscrits' => $nonInscrits,
        ]);
    }

    
    // Méthode d'ajout d'une session
    #[Route('session/new', name: 'new_session')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $intern = new Session();

        // Crée le formulaire sur le modele de la classe Intern généré par la console
        $form = $this->createForm(SessionFormType::class, $intern);

        // Gère la requete pour remplir le formulaire avec les données soumises
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // Persiste les données de la classe Intern dans la BDD
            $entityManager->persist($intern);

            // Sauvegarde les changements en BDD
            $entityManager->flush();

            // Redirige apres soumission
            return $this->redirectToRoute('list_formation');
        }

        // Si le formulaire n'a pas encore été soumis, affiche le formulaire
        return $this->render('session/new.html.twig', [
            'formAddSession' => $form,
        ]);
    }

    // Méthode de suppression d'une Session
    #[Route('session/delete/{id}', name: 'delete_session')]
    public function delete(Session $session, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($session);
        $entityManager->flush();

        return $this->redirectToRoute('list_formation', [
            'session' => $session,
        ]);
    }

    // Méthode d'ajout d'un stagiaire à une session spécifique
    #[Route('session{session}/intern{intern}/add', name: 'add_intern_session')]
    public function addInternSession(Session $session, Intern $intern, EntityManagerInterface $entityManager)
    {
        $session->addIntern($intern);

        $entityManager->persist($session);
        $entityManager->flush();

        return $this->redirectToRoute('detail_session', ['id' => $session->getId()]);
    }
}
