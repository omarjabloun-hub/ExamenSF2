<?php

namespace App\Controller;

use App\Entity\Pfe;
use App\Form\PfeType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PfeController extends AbstractController
{


    #[Route('/pfe/{id<\d+>}', name: 'app_pfe')]
    public function index($id): Response
    {


        return $this->render('pfe/index.html.twig', [
            'controller_name' => 'Hani',
            'Identifier'=> $id ,
            'Name' => 'Omar'
        ]);
    }


    #[Route('/pfe', name: 'app_pfe1')]
    public function index2(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Pfe::class) ;
        $pfes = $repo->findAll();
        return $this->render('pfe/index.html.twig',[
            'pfes' => $pfes
        ]);
    }

    #[Route('/pfe/add', name: 'app_add_pfe')]
    public function index3(Request $request , ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $pfe = new Pfe();

        $form = $this->createForm(PfeType::class, $pfe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $pfe = $form->getData();
            $entityManager->persist($pfe);
            $entityManager->flush();
            $pfe = null ;
            $this->addFlash('success' , 'Ajout avec succes');
            return $this->redirectToRoute('app_pfe1');
        } else {
            return $this->renderForm('pfe/addPfe.html.twig', [
                'form' => $form,
            ]);
        }


    }
}
