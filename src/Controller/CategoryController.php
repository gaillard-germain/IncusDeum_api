<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CategoryType;

class CategoryController extends ApiController
{
    /**
     * @Route("/category", name="app_category", methods={"GET"})
     */
     public function index(CategoryRepository $categoryRepository): Response
     {
       $categories = $categoryRepository->findAll();
       return $this->normalizeData($categories, ['cards_list']);
     }

     /**
     * @Route("/category", name="app_category_create", methods={"POST"})
     */
     public function create(Request $request, EntityManagerInterface $manager)
     {
       $category = new Category();
       $form = $this->createForm(CategoryType::class, $category);

       $form->submit(json_decode($request->getContent(), true));

       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()) {
         $manager->persist($category);
         $manager->flush();
         return $this->normalizeData($category, ['card_detail'], 201);
       }

       return $this->normalizeData(['errors' => $this->formErrors($form)], [], 401);
     }
}
