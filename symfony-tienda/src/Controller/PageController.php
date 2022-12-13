<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Team;
use App\Entity\Product;
use App\Entity\Comment;
use App\Form\CommentFormType;
use Symfony\Component\HttpFoundation\Request;

class PageController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Team::class);
        $team = $repository->findAll();
        return $this->render('page/index.html.twig', compact('team'));
    }

    #[Route('/about', name: 'about')]
    public function about(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Team::class);
        $team = $repository->findAll();
        return $this->render('page/about.html.twig', compact('team'));
    }

     /**
     * @Route("/service", name="service")
     */
    public function service():Response{
        return $this->render('page/service.html.twig', []);
    }
     /**
     * @Route("/product", name="product")
     */
    public function product(ManagerRegistry $doctrine): Response{
        $repository = $doctrine->getRepository(Product::class);
        $product =$repository->findAll();
        return $this->render('page/product.html.twig', compact('product'));
    }
     /**
     * @Route("/price", name="price")
     */
    public function price():Response{
        return $this->render('page/price.html.twig', []);
    }
     /**
     * @Route("/team", name="team")
     */
    public function team(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Team::class);
        $team = $repository->findAll();
        return $this->render('page/team.html.twig', compact('team'));
    }
     /**
     * @Route("/testimonial", name="testimonial")
     */
    public function testimonial():Response{
        return $this->render('page/testimonial.html.twig', []);
    }
     /**
     * @Route("/detail", name="detail")
     */
    public function detail(ManagerRegistry $doctrine, Request $request): Response
    {
        $contact = new Comment();
        $form = $this->createForm(CommentFormType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contacto = $form->getData();    
            $entityManager = $doctrine->getManager();    
            $entityManager->persist($contacto);
            $entityManager->flush();
            return $this->redirectToRoute('index', []);
        }

        return $this->render('page/detail.html.twig', array(
            'form' => $form->createView()    
        ));
    }
     /**
     * @Route("/contact", name="contact")
     */
    public function contact():Response{
        return $this->render('page/contact.html.twig', []);
    }
}
