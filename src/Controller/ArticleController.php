<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article')]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/dashbord', name: 'app_dashboard')]
    public function dashbord(): Response
    {
        return $this->render('dashbord/index.html.twig',);
    }
    
    #[Route('/create',name:'add_article')]
    public function createArticle(ManagerRegistry $manager, Request $request){

        $article = new Article();
        $articleForm = $this->createForm(ArticleType::class,$article);
        $articleForm->handleRequest($request);

        if($articleForm->isSubmitted() && $articleForm->isValid()){
            $article->setCreatedAt(new DateTime('now'));
            $manager->getManager()->persist($article);
            $manager->getManager()->flush();
            return $this->redirectToRoute('app_article');
        }

        return $this->render('article/new.html.twig',[
            'dataForm' => $articleForm->createView(),
            'formName' => 'Nouveau article',
        ]);
    }

    #[Route('/update{articleId}',name:'update_article')]
    public function updateArticle($articleId,Request $request, ManagerRegistry $manager)
    {
        $article= $manager->getManager()->getRepository(Article::class)->find($articleId);
        $articleForm = $this->createForm(ArticleType::class,$article);
        $articleForm->handleRequest($request);

        if (!$article) {
            return $this->redirectToRoute('app_article');
        }

        if ($articleForm->isSubmitted() && $articleForm->isValid()) {
            $manager->getManager()->persist($article);
            $manager->getManager()->flush();
            return $this->redirectToRoute('app_article');
        }

        return $this->render('index/dataform.html.twig',[
            "dataForm" => $articleForm->createView(),
            'formName' => 'Modifier article',
        ]);
    }

    #[Route('/delete/{articleId}', name:'delete_article')]
    public function deleteArticle(ManagerRegistry $manager, $articleId){
        $article = $manager->getManager()->getRepository(Article::class)->find($articleId);
        if (!$article) {
            return $this->redirectToRoute('app_article');
        }
        $manager->getManager()->remove($article);
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_article');
    }
}
