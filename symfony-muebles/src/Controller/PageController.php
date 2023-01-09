<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Team;

class PageController extends AbstractController
{
    /*#[Route('/', name: 'app_page')]
    public function index(): Response
    {
        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }*/
    #[Route('/', name: 'index')]
    public function index():Response{
        return $this->render('page/index.html.twig', []);
    }
    #[Route('/product', name: 'product')]
    public function product(): Response{
        return $this->render('page/product.html.twig', []);
    }
    #[Route('/single', name: 'single')]
    public function single(): Response{
        return $this->render('page/single.html.twig', []);
    }
    #[Route('/about', name: 'about')]
    public function about(ManagerRegistry $doctrine):Response{
        
        return $this->render('page/about.html.twig', []);
    }
    #[Route('/teamTemplate', name:'teamTemplate')]
    public function teamTemplate(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Team::class);
        $team = $repository->findAll();
        return $this->render('partials/_team.html.twig',compact('team'));
    }

    #[Route('/service', name: 'service')]
    public function service(): Response{
        return $this->render('page/service.html.twig', []);
    }
    #[Route('/contact', name: 'contact')]
    public function contact(): Response{
        return $this->render('page/contact.html.twig', []);
    }
}
