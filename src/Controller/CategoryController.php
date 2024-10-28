<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('category', name: 'list_category')]
    public function list(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('category/list.html.twig', [
            'categories' => $categories,
        ]);
    }

    // Méthode de suppression d'une Catégorie
    #[Route('category/delete/{id}', name: 'delete_category')]
    public function delete(Category $category, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('list_category', [
            'category' => $category,
        ]);
    }

    // Méthode pour ajouter une catégorie 
    #[Route('category/new', name: 'new_category')]
    #[Route('category{category}/edit', name: 'edit_category')]
    public function new_edit(Category $category = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$category)
        {
            $category = new Category();
        }

        // Crée le formulaire sur le modele de la classe Category généré par la console
        $form = $this->createForm(CategoryFormType::class, $category);

        // Gère la requete pour remplir le formulaire avec les données soumises
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // Récupère les données
            $category = $form->getData();
            
            // Persiste les données de la classe Intern dans la BDD
            $entityManager->persist($category);

            // Sauvegarde les changements en BDD
            $entityManager->flush();

            // Redirige apres soumission
            return $this->redirectToRoute('list_category');
        }

        // Si le formulaire n'a pas encore été soumis, affiche le formulaire
        return $this->render('category/new.html.twig', [
            'formAddCategory' => $form,
        ]);
    }
}
