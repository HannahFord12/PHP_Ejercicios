<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContactFormType;
use App\Entity\Contact;
use App\Entity\Puntos;

class PageController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
    #[Route('/mapa', name: 'mapa')]
    public function mapa(ManagerRegistry $doctrine): Response{
        $repository = $doctrine->getRepository(Puntos::class);
        $puntos =$repository->findAll();
        return $this->render('page/mapa.html.twig', compact('puntos'));
    }
    #[Route('/points', name: 'points')]
    public function points(ManagerRegistry $doctrine): JsonResponse{
        $repository = $doctrine->getRepository(Puntos::class);
        $puntos =$repository->findAll();
        $data = [];
        foreach($puntos as $punto){
            $item = [
                "id"=> $punto->getId(),
                "latitud"=>$punto->getLatitud(),
                "longitud"=>$punto->getLongitud()
            ];
            $data[] = $item;
        }
        return new JsonResponse($data, Response::HTTP_OK);
    }
    #[Route('/contact', name: 'contact')]
    public function contact(ManagerRegistry $doctrine, Request $request): Response
    {
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
