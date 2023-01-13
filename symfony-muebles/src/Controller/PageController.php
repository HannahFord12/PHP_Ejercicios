<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Team;
use App\Entity\Producto;
use App\Form\ContactFormType;
use App\Entity\Contact;

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
    public function index(ManagerRegistry $doctrine): Response{
        $repository = $doctrine->getRepository(Producto::class);
        $product =$repository->findAll();
        return $this->render('page/index.html.twig', compact('product'));
    }
    #[Route('/product', name: 'product')]
    public function product(ManagerRegistry $doctrine): Response{
        $repository = $doctrine->getRepository(Producto::class);
        $product =$repository->findAll();
        return $this->render('page/product.html.twig', compact('product'));
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
    public function contact(ManagerRegistry $doctrine, Request $request): Response{
        $contact = new Contact();
        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contacto = $form->getData();    
            $entityManager = $doctrine->getManager();    
            $entityManager->persist($contacto);
            $entityManager->flush();
            return $this->redirectToRoute('index', []);
        }
        return $this->render('page/contact.html.twig', array(
            'form' => $form->createView()    
        ));
    }
}
