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
    public function list(ModuleRepository $moduleRepository): Response
    {
        $modules = $moduleRepository->findBy([], ['name' => 'ASC']);

        return $this->render('module/list.html.twig', [
            'modules' => $modules,
        ]);
    }

    // Méthode d'ajout de module
    #[Route('module/new', name: 'new_module')]
    #[Route('module{module}/edit', name: 'edit_module')]
    public function new_edit(Module $module = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$module)
        {
            $module = new Module();
        }


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
    
    
    // Méthode de suppression d'un Module 
    #[Route('module/delete/{id}', name: 'delete_module')]
    public function delete(Module $module, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($module);
        $entityManager->flush();

        return $this->redirectToRoute('list_module', [
            'module' => $module,
        ]);
    }
}
