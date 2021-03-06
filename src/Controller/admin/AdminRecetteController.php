<?php

namespace App\Controller\admin;

use App\Entity\Categorie;
use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminRecetteController extends AbstractController
{

    private EntityManagerInterface $em;
    private RecetteRepository $repository; 

    public function __construct(EntityManagerInterface $em, RecetteRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     *@Route("/admin", name="admin_index")
     */
    public function index() : Response
    {
        $recettes = $this->repository->findAll();

        return $this->render('admin/index.html.twig', [
            'recettes' => $recettes,
            'menu' => 'admin'
        ]);
    }

    /**
     * @Route("/admin/create", name="admin_create")
     */
    public function create(Request $request)
    {
        $recette = new Recette();
        $form = $this->createForm(RecetteType::class, $recette);
        $form ->handleRequest($request);
        if ($form -> isSubmitted() && $form -> isValid()) 
        {
            $this->em->persist($recette);
            $this->em->flush();
            return $this->redirectToRoute('admin_index', [], 301);
        }
        return $this->render('admin/create.html.twig', [
            'formRecette' => $form->createView(),
            'menu' => 'admin'
        ]);
    }

    /**
     * @Route("/admin/edit/{id}", name="admin_edit")
     */
    public function edit(Request $request, int $id)
    {
        $recette = $this->repository->find($id);
        $form = $this->createForm(RecetteType::class, $recette);
        $form ->handleRequest($request);
        if ($form -> isSubmitted() && $form -> isValid()) 
        {
            $this->em->flush();
            return $this->redirectToRoute('admin_index', [], 301);
        }
        return $this->render('admin/edit.html.twig', [
            'formRecette' => $form->createView(),
            'menu' => 'admin',
            
        ]);
    }
}