<?php

namespace App\Controller;

use App\Entity\Intern;
use App\Entity\Module;
use App\Entity\Session;
use App\Entity\SessionModule;
use App\Form\SessionFormType;
use App\Form\SessionModuleFormType;
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
    #[Route('session{session}/edit', name: 'edit_session')]
    public function new_edit(Session $session = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$session)
        {
            $session = new Session();
        }

        // Crée le formulaire sur le modele de la classe Session généré par la console
        $form = $this->createForm(SessionFormType::class, $session);

        // Gère la requete pour remplir le formulaire avec les données soumises
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // Persiste les données de la classe Intern dans la BDD
            $entityManager->persist($session);

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

    // Méthode de retrait d'un stagiaire à une session spécifique 
    #[Route('session{session}/intern{intern}/remove', name: 'remove_intern_session')]
    public function removeInternSession(Session $session, Intern $intern, EntityManagerInterface $entityManager)
    {
        $session->removeIntern($intern);

        $entityManager->persist($session);
        $entityManager->flush();

        return $this->redirectToRoute('detail_session', ['id' => $session->getId()]);
    }

    // Métode pour ajouter un module à une session 
    #[Route('/session{session}/add_module', name: 'add_module_session')]
    public function addModule(Request $request, Session $session, EntityManagerInterface $entityManager): Response
    {
        $sessionModule = new SessionModule();
        $sessionModule->setSession($session);

        // Crée le formulaire sur le modele de la classe SessionModule généré par la console
        $form = $this->createForm(SessionModuleFormType::class, $sessionModule);

        // Gère la requete pour remplir le formulaire avec les données soumises
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // Persiste les données de la classe Intern dans la BDD
            $entityManager->persist($sessionModule);

            // Sauvegarde les changements en BDD
            $entityManager->flush();

            // Redirige apres soumission
            return $this->redirectToRoute('detail_session', ['id' => $session->getId()]);
        }

        // Si le formulaire n'a pas encore été soumis, affiche le formulaire
        return $this->render('session_module/add_module.html.twig', [
            'formAddSessionModule' => $form,
            'session' => $session,
        ]);
    }
    
    // Méthode de retrait d'un module à une session spécifique 
    #[Route('session{session}/module{module}/remove', name: 'remove_module_session')]
    public function removeModuleSession(Session $session, Module $module, EntityManagerInterface $entityManager)
    {
        $sessionModule = $entityManager->getRepository(SessionModule::class)->findOneBy([
            'session' => $session,
            'module' => $module,
        ]);

        $entityManager->remove($sessionModule);
        $entityManager->flush();

        return $this->redirectToRoute('detail_session', ['id' => $session->getId()]);
    }
}
