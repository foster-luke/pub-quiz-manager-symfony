<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Score;
use Symfony\Component\HttpFoundation\Response;

class ScoreController extends AbstractController
{
    /**
     * @Route("/score", name="score")
     */
    public function index()
    {
        $scores = $this->getDoctrine()
        ->getRepository(Score::class)
        ->findAll();
        $scores = $this->container->get('serializer')->serialize($scores, 'json');
        $response = new Response($scores);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
