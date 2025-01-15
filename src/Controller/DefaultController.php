<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/default/{id}', name: 'app_default', requirements: ['id'=>'\d+'], defaults: ['id'=> 1], methods: ['GET'])]
    public function index(Request $request, int $id): Response
    {
        dump($request->query->all());exit;
        return $this->render('index.html.twig', ['id' => $id]);
    }
}
