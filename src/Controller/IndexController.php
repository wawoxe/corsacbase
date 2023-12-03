<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'app_index_')]
class IndexController extends AbstractController
{
    #[Route(
        path: '/',
        name: 'index',
    )]
    public function index(): Response
    {
        return $this->render('pages/index.html.twig');
    }
}
