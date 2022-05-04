<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

abstract class ApiController extends AbstractController
{
    /**
     * @var NormalizerInterface
     */
    protected $normalizer;

    /**
     * ApiController constructor.
     * @param NormalizerInterface $normalizer
     */
    public function __construct(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function normalizeData($data, $groups = [], $status = 200, $headers = [], $context = [])
    {
        return $this->json($this->normalizer->normalize($data, 'json', ['groups'=>$groups]), $status, $headers, $context);
    }
}
