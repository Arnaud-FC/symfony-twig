<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManager;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route("/admin/category", name: 'admin.category.')]
class CategoryController extends AbstractController {

    #[Route("/", name: "index")]
    public function index(CategoryRepository $repository){

        return $this->render('admin/category/index.html.twig', [
            'categories' => $repository->findAll()
        ]);

    }

    #[Route("/create", name: "create")]
    public function create(Request $request, EntityManagerInterface $em){
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();
            $this->addFlash('success', 'categorie créée');
            return $this->redirectToRoute('admin.category.index');
        }

        return $this->render('admin/category/create.html.twig', [
            'form' => $form 
        ]);

    }

    #[Route("/{id}", name: "edit", requirements : ['id' => Requirement::DIGITS], methods : ['GET', 'POST'])]
    public function edit(Category $category, Request $request, EntityManagerInterface $em){
        
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'categorie modifiée');
            return $this->redirectToRoute('admin.category.index');
        }

        return $this->render('admin/category/edit.html.twig', [
            'category' => $category,
            'form' => $form 
        ]);
    }

    #[Route("/{id}", name: "delete", requirements : ['id' => Requirement::DIGITS], methods : ['DELETE'])]
    public function remove(Category $category, EntityManagerInterface $em){
        // je supprime
        $em->remove($category);
        //je porte les modifs en bdd
        $em->flush();
        $this->addFlash('success', 'categorie supprimée');
        return $this->redirectToRoute('admin.category.delete');
    }

}