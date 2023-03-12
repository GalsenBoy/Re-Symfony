<?php
// src/Controller/DefaultController.php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
   
    #[Route("/api/helloword/{name}", name:"api_helloword")]
    public function apiHelloword(string $name): Response
    {
      return new JsonResponse('hello ' . $name);
    }
}