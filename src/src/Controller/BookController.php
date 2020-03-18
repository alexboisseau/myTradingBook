<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\TradeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    /**
     * @Route("/book", name="book")
     */
    public function index()
    {
        $user = $this->getUser();
        
        return $this->render('book/index.html.twig',[
            'user' => $user
        ]);
    }
   
    /**
     * Method to delete book
     * 
     * @Route("/book/{slug}/delete", name="book_delete")
     *
     * @param Book $book
     * @param EntityManagerInterface $manager
     * 
     * @return RedirectResponse
     */
    public function delete(Book $book, EntityManagerInterface $manager){
        $manager->remove($book);
        $manager->flush();

        return $this->redirectToRoute('book');
    }


    
    /**
     * Method to create new book
     * 
     * @Route("/book/new", name="book_new") 
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function create(Request $request, EntityManagerInterface $manager){

        $book = new Book();

        $form = $this->createForm(BookType::class,$book);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $book->setAuthor($this->getUser());

            $manager->persist($book);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le cahier <strong>{$book->getTitle()}</strong> a bien été enregistrée !"
            );

            return $this->redirectToRoute('book',[
                'book' => $book
            ]);
        }
        
        return $this->render('book/new.html.twig',[
            "form" => $form->createView()
        ]);
    }

    /**
     * Method to update an existing book
     * 
     * @Route("/book/edit/{slug}", name="book_edit")
     *
     * @param Book $book
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function edit(Book $book, Request $request, EntityManagerInterface $manager){
        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // $book->setAuthor($this->getUser());

            $manager->persist($book);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le cahier <strong>{$book->getTitle()}</strong> a bien été modifiée !"
            );

            return $this->redirectToRoute('book',[
                'book' => $book
            ]);
        }
        return $this->render('book/edit.html.twig',[
            'form' => $form->createView(),
            'book' => $book
        ]);
    }


    /**
     * Method to show all Trade in a book
     * 
     * @Route("/book/show/{slug}", name="book_show")
     *
     * @param Book $book
     * @param TradeRepository $tradeRepo
     * @return void
     */
    public function show(Book $book, TradeRepository $tradeRepo){
        return $this->render('book/show.html.twig',[
            "book" => $book
        ]);
    }
}
