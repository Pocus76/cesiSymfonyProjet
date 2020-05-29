<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\service\MailTestServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/articles", name="articles")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $repository = $this->getDoctrine()->getRepository(Articles::class)->findAll();
        $articles = $paginator->paginate(
            $repository,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('articles/index.html.twig', [
            'controller_name' => 'ArticlesController', 'repository' => $articles
        ]);
    }
    /**
     * @Route("/produits/search/", name="produit.search")
     * @return Response
     */
    public function search(Request $request, PaginatorInterface $paginator): Response
    {
        $data = $request->request->get('search');
        if ($data==""||$data==null)
        {
            $liste_produits = $this->getDoctrine()->getRepository(Articles::class)->findAll();
        }
        else
        {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery(
                'SELECT articles.id FROM App:Articles articles
                    WHERE articles.Titre LIKE :data
                    OR articles.Description LIKE :data')
                ->setParameter('data',$data);
            $res = $query->getResult();
            foreach ($res as $id)
            {
                $liste_produits[] = $this->getDoctrine()->getRepository(Articles::class)->find($id);
            }
        }

        if (!isset($liste_produits))
        {
            $liste_produits = $this->getDoctrine()->getRepository(Articles::class)->findAll();
        }
        $articles = $paginator->paginate(
            $liste_produits,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('articles/index.html.twig', [
            'controller_name' => 'ArticlesController', 'repository' => $articles
        ]);
    }

    /**
     * @Route("/produits/details/{produit}", name="produit.detail")
     * @return Response
     */
    public function detail($produit): Response
    {
        $produitsRepository= $this->getDoctrine()->getRepository(Articles::class)->find($produit);
        return $this->render('Articles/details.html.twig',['current_menu' => 'produits','produit' => $produitsRepository]);
    }

    /**
     * @Route("/mail/{produit}", name="mail")
     */
    public function mail(MailTestServices $email, $produit)
    {
        $produitsRepository= $this->getDoctrine()->getRepository(Articles::class)->find($produit);
        $email->notify($produitsRepository);
        return $this->redirectToRoute('articles');
    }

    /**
     * @Route("/articles/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Articles();
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('articles');
        }

        return $this->render('articles/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/articles/{id}/edit", name="articles_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Articles $article): Response
    {
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('articles');
        }

        return $this->render('articles/edit.html.twig', [
            'articles' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/articles/{id}", name="articles_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Articles $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('articles');
    }

}
