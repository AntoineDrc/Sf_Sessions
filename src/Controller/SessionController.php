<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

}
