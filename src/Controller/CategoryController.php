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
       $content = $request->getContent();

       $category = new Category();
       $category->setName($content);
       $manager->persist($category);
       $manager->flush();

       return $this->json($content);
     }
}
