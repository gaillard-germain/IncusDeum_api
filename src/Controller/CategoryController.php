<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;

class CategoryController extends ApiController
{
    /**
     * @Route("/category", name="app_category")
     */
     public function index(CategoryRepository $categoryRepository): Response
     {
       $categories = $categoryRepository->findAll();
       return $this->normalizeData($categories, ['cards_list']);
     }
}
