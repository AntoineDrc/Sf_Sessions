<?php

namespace App\Controller;

use App\Entity\Module;
use App\Entity\SessionModule;
use App\Form\ModuleFormType;
use App\Repository\ModuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SessionModuleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleController extends AbstractController
{
    #[Route('module', name: 'list_module')]
    public function list(SessionModuleRepository $sessionModuleRepository): Response
    {
        $sessionsModules = $sessionModuleRepository->findAll();

        return $this->render('module/list.html.twig', [
            'sessionsModules' => $sessionsModules,
        ]);
    }

    // Méthode d'ajout de module
    #[Route('module/new', name: 'new_module')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $module = new Module();

       // Crée le formulaire sur le modele de la classe Intern généré par la console
       $form = $this->createForm(ModuleFormType::class, $module);

       // Gère la requete pour remplir le formulaire avec les données soumises
       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid())
       {
           // Persiste les données de la classe Intern dans la BDD
           $entityManager->persist($module);

           // Sauvegarde les changements en BDD
           $entityManager->flush();

           // Redirige apres soumission
           return $this->redirectToRoute('list_module');
       }

        // Si le formulaire n'a pas encore été soumis, affiche le formulaire
        return $this->render('module/new.html.twig', [
            'formAddModule' => $form,
        ]);
    }
}
