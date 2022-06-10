<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FxRepository;
use App\Entity\Fx;
use App\Form\FxType;

class FxController extends ApiController
{
    /**
     * @Route("/fx", name="app_fx", methods={"GET"})
     */
     public function index(FxRepository $fxRepository): Response
     {
       $fxs = $fxRepository->findAll(['name' => 'ASC']);
       return $this->normalizeData($fxs, ['card_detail']);
     }

     /**
     * @Route("/fx", name="app_fx_create", methods={"POST"})
     */
     public function create(Request $request, FxRepository $fxRepository)
     {
       $fx = new Fx();
       $form = $this->createForm(FxType::class, $fx);

       $form->submit(json_decode($request->getContent(), true));

       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()) {
         $fxRepository->add($fx);

         return $this->normalizeData($fx, ['card_detail'], 201);
       }

       return $this->normalizeData(['errors' => $this->formErrors($form)], [], 401);
     }

}
