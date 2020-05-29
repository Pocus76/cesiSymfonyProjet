<?php

namespace App\Controller;

use App\Entity\Articles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminProduitsController extends AbstractController
{
    /***@Route("/admin/produits/list", name="admin_produits.list")*/
    public function index()
    {
        $produitsRepository= $this->getDoctrine()->getRepository(Articles::class);
        $produits= $produitsRepository->findAll();
        return $this->render('admin_produits/index.html.twig',['produits' => $produits]);
    }

    /*** @Route("/admin/{id}", name="admin.produit.edit")*/
    public function edit()
    {
        return $this->render('admin_produits/edit.html.twig');
    }

    /*** @Route  ("/admin/produit/add", name="admin.produit.add")*/
    public function delete(Request $request)
    {
        return $this->render('admin_produits/add.html.twig');
    }

    /*** @Route("/admin/produit/delete/{id}", name="admin.produit.delete", methods="DELETE")*/
    public function add(Articles$produit,Request$request)
    {
        return $this->redirectToRoute('admin.produit.list');
    }
}
