<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Pais;
use App\Entity\Image;
use App\Form\PaisFormType;
use App\Form\ImageFormType;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminControlelrController extends AbstractController
{
    #[Route('/admin/controlelr', name: 'app_admin_controlelr')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminControlelrController',
        ]);
    }

    #[Route('/admin/pais', name: 'app_pais')]
    public function pais(ManagerRegistry $doctrine, Request $request): Response
    {
        $repositorio = $doctrine->getRepository(Pais::class);

        $paises = $repositorio->findAll();
        $pais = new Pais();
        $form = $this->createForm(PaisFormType::class, $pais);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pais = $form->getData();    
            $entityManager = $doctrine->getManager();    
            $entityManager->persist($pais);
            $entityManager->flush();
        }
        return $this->render('admin/pais.html.twig', array(
            'form' => $form->createView(),
            'paises' => $paises  
        ));
    }

    #[Route('/admin/images', name: 'app_images')]
    public function images(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger): Response
    {
        $repository = $doctrine->getRepository(Image::class);
        $images = $repository->findAll();

        $image = new Image();
        $form = $this->createForm(ImageFormType::class, $image);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('ciudad')->getData();
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                // Move the file to the directory where images are stored
                try {

                    $file->move(
                        $this->getParameter('images_directory'), $newFilename
                    );
                    $filesystem = new Filesystem();
                    

                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'file$filename' property to store the PDF file name
                // instead of its contents
                $image->setCiudad($newFilename);
            }
            $image = $form->getData();   
            $entityManager = $doctrine->getManager();    
            $entityManager->persist($image);
            $entityManager->flush();
                }
            return $this->render('admin/images.html.twig', array(
                'form' => $form->createView(),
                'images' => $images 
            ));
        
    }


}
