<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PaginationController extends AbstractController
{
    /**
     * @Route("/pagination", name="pagination")
     */
    public function index()
    {
        return $this->render('pagination/index.html.twig', [
            'controller_name' => 'PaginationController',
        ]);
    }
}
