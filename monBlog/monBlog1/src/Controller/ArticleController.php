<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Form\AjoutArticleFormType;
use App\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * Class ArticleController
 * @package App\Controller
 * @Route("/actualites", name="actualites_")
 */

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="articles")
     */
    public function index()
    {
         //dd($articles); la funcion dd me perimite ver si el metodo funciona
        $articles = $this->getDoctrine()->getRepository(Article::class)->findBy([], ['created_at' => 'desc']);
        return $this->render('article/index.html.twig', ['article' => $articles,]);
       
    }


    /**
     * @IsGranted("ROLE_USER")
     * @Route("/nouveau", name="nouveau")
     */

    public function ajoutArticle(Request $request)
    {
        $article = new Article();
        // nous créons l'objet formulaire
        $form = $this->createForm(AjoutArticleFormType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUser($this->getUser());
            $doctrine = $this->getDoctrine()->getManager();
            $doctrine->persist($article);
            $doctrine->flush();

            $this->addFlash('message', 'Votre article été bien publié');
            return $this->redirectToRoute('actualites_articles');
        }
        return $this->render('article/ajout-article.html.twig', [
            'articleForm' => $form->createView()
        ]);
    }


    /**
     * @Route("/{slug}", name="article")
     */
    public function article($slug, Request $request) //nos permite recibir los données dans notre formulaire
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->findOneBy(['slug' => $slug]);
        // On récupère les commentaires actifs de l'article 
        $commentaires = $this->getDoctrine()->getRepository(Commentaire::class)->findBy([
            'article' => $article,
            'actif' => 1
        ], ['created_at' => 'desc']);

        if (!$article) {
            throw $this->createNotFoundException('L\'article n\'existe pas');
        }

        // Nous créons l'instance de "Commentaires
        $commentaire = new Commentaire();
        // Nous créons le formulaire en utilisant "CommentairesType" et on lui passe l'instance 
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handLeRequest($request); // recuperer les données

        // on verifier si le formulairea été envoyer et si le données sont valides 
        if ($form->isSubmitted() && $form->isValid()) {
            //ici le formulaire été envoyer et les données validé
            $commentaire->setArticle($article);
            $commentaire->setCreatedAt(new \DateTime('now'));
            // on instance Doctrine pour aller chercher et hydraté notre basse de données
            $doctrine = $this->getDoctrine()->getManager();
            // Hydraté= metre en place les données
            $doctrine->persist($commentaire);
            $doctrine->flush();

            $this->addFlash('message', 'Votre article été publié');
            return $this->redirectToRoute('actualites_articles');
        }

        return $this->render('article/article.html.twig', [
            'article' => $article,
            'commentaire' => $commentaires,
            'CommentaireForm' => $form->createView()
        ]);
    }
}
