<?php 
namespace App\Services;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class SaveArticle
{
    private $client;
    private $em;

    public function __construct(HttpClientInterface $client, EntityManagerInterface $em)
    {
        $this->client = $client;
        $this->em = $em;
    }

    public function saveArticle()   {
        $URL = 'https://newsapi.org/v2/everything?q=tesla&sortBy=publishedAt&apiKey=aa62cf1ce56e43efae2b7ce966c8d563';
        $response = $this->client->request(
            'GET',
            $URL
        );
        $content = $response->toArray();              
        $count = 0;
        $news = [];
        while($count <= count($content)){                        
            //save to Articles
            $article = new Article();
            $title = $article->getTitle(strtolower($content['articles'][$count]['title']));
            if($title == null){
                $article->setTitle($content['articles'][$count]['title']);
                $article->setShortDescription($content['articles'][$count]['description']);
                $article->setPicture($content['articles'][$count]['urlToImage']);
                $article->setDateAdded($content['articles'][$count]['publishedAt']);
                
                $this->em->persist($article);
                $this->em->flush();
            }else{
                "Article Exists \n created at: ".$article->getDateAdded([], ["title" => $title])."";
            }
                 
            
            $count++;
        }

        
    }
}