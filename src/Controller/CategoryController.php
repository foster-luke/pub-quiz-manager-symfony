<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index()
    {
        $categories = $this->getDoctrine()
        ->getRepository(Category::class)
        ->findAll();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getName();
            },
        ];
        $serializer = new Serializer([new ObjectNormalizer(null, null, null, null, null, null, $defaultContext)], [new JsonEncoder()]);
        $categories = $serializer->serialize($categories, 'json');
        // $categories = $this->container->get('serializer')->normalize($categories, null);
        $response = new Response($categories);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
