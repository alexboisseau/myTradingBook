<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Trade;
use App\Form\TradeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TradeController extends AbstractController
{
    /**
     * @Route("/trade/new/{slug}", name="trade_new")
     */
    public function create(Request $request, EntityManagerInterface $manager, Book $book)
    {         
        $trade = new Trade();

        $form = $this->createForm(TradeType::class,$trade);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $trade->setBook($book);

            $manager->persist($trade);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le trade <strong>{$trade->getAction()}</strong> a bien été enregistrée !"
            );

            return $this->redirect('/book/show/'.$book->getId());
        }
        
        return $this->render('trade/new.html.twig',[
            "form" => $form->createView(),
            "book" => $book
        ]);
    }

    /**
     * @Route("/trade/delete/{id}", name="trade_delete")
     *
     * @param Trade $trade
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function delete(Trade $trade, EntityManagerInterface $manager){
        $manager->remove($trade);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le trade <strong>{$trade->getAction()}</strong> a bien été supprimé!"
        );

        return $this->redirect('/book/show/'.$trade->getBook()->getId());
    }

    /**
     * Method to update an existing book
     * 
     * @Route("/trade/edit/{id}", name="trade_edit")
     *
     * @param Trade $trade
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function edit(Trade $trade, Request $request, EntityManagerInterface $manager){
        $form = $this->createForm(TradeType::class, $trade);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // $book->setAuthor($this->getUser());

            $manager->persist($trade);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le trade <strong>{$trade->getAction()}</strong> a bien été modifié !"
            );

            return $this->redirect('/book/show/'.$trade->getBook()->getId());
        }
        return $this->render('trade/edit.html.twig',[
            'form' => $form->createView(),
            'trade' => $trade
        ]);
    }
}
