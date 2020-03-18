<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    /**
     * @Route("/book", name="book")
     */
    public function show()
    {
        $user = $this->getUser();
        
        return $this->render('book/show.html.twig',[
            'user' => $user
        ]);
    }
}
