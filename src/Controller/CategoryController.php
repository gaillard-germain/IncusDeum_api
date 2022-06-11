<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Entity\Category;
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
     public function create(Request $request,
                            CategoryRepository $categoryRepository)
     {
       $category = new Category();
       $form = $this->createForm(CategoryType::class, $category);

       $form->submit(json_decode($request->getContent(), true));

       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()) {
         try {
           $categoryRepository->add($category);
         } catch (\Exception $e) {
           return new Response("This category already exists!", 409);
         }

         return $this->normalizeData($category, ['card_detail'], 201);
       }

       return $this->normalizeData(['errors' => $this->formErrors($form)], [], 401);
     }
}
