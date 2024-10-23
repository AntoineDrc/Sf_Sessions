<?php

namespace App\Controller;

use App\Repository\ModuleRepository;
use App\Repository\SessionModuleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ModuleController extends AbstractController
{
    #[Route('module', name: 'list_module')]
    public function list(ModuleRepository $moduleRepository, SessionModuleRepository $sessionModuleRepository): Response
    {
        $modules = $moduleRepository->findAll();
        $sessionsModules = $sessionModuleRepository->findAll();

        return $this->render('module/list.html.twig', [
            'modules' => $modules,
            'sessionsModules' => $sessionsModules,
        ]);
    }
}
