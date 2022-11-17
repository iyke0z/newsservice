<?php 
namespace App\Services;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler()]
class SaveArticleHandler
{
   
   public function __invoke(SaveArticleNotification $article)
   {
      // 1. Get data from url
      echo "Fetching data from api...\n";  
      
      // 2. Saved
      echo "Data saved...";
   }
}