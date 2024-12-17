<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Employe;
use App\Form\EmployeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EmployeController extends AbstractController
{
    #[Route('/employe', name: 'app_employe')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Employe::class);
        $employes = $repository->findAll();
        /* dd($employes); */
        return $this->render('employe/index.html.twig', [
            "mpls" => $employes
        ]);
    }
    #[Route('/employe/edit{id}', name: 'edit_employe')]
    #[Route('/employe/add', name: 'add_employe')]
    public function add(ManagerRegistry $doctrine, Request $request, Employe $employe=null)
    {
        if(!$employe){
            $employe = new Employe();
        }
        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($employe);
            $manager->flush();
            return $this->redirectToRoute('app_employe');
        }
        $vrai = false;
    if($employe->getId() != null){
        $vrai = true;
    }
        return $this->render('employe/add.html.twig', [
            "formulaire" => $form->createView(),
            "vrai" => $vrai
        ]);
    }

    // modification d'un employe

    /* #[Route('/employe/edit/{id}', name: 'edit_employe')]
    public function edit(ManagerRegistry $doctrine, Request $request, Employe $employe)
    { */
        /* dd($employe); */
       /*  $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $doctrine->getManager();
            $manager->persist($employe);
            $manager->flush();
            return $this->redirectToRoute("app_employe");
        }
        return $this->render("employe/edit.html.twig", [
            "formulaireEdit" => $form->createView()
        ]);
    } */

    #[Route('/employe/supprimer/{id}', name: 'remove_employe')]
    public function supprimer(ManagerRegistry $doctrine, Employe $employe)
    {
        $repository = $doctrine->getManager();
        $repository->remove($employe);
        $repository->flush();
        return $this->redirectToRoute("app_employe");
    }
}
