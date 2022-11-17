<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    public function __construct(ManagerRegistry $doctrine, EntityManagerInterface $em)
    {
        $this->repository = $doctrine->getRepository(Article::class);
        $this->em = $em;
    }
    #[Route('/article', methods: ['GET'],  name: '_articles')]
    public function index(): Response
    {        
        $articles = $this->repository->findAll();

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/article/delete/{id}', methods:['GET', 'DELETE'], name: '_delete_article')]
    public function deleteArticle($id){
        $article = $this->repository->find($id);
        $this->em->remove($article);
        $this->em->flush();

        return $this->redirectToRoute('_articles');
    }  
}
