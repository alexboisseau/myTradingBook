<?php

namespace App\Controller;

use App\Entity\Message;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminMessageController extends AbstractController
{
    /**
     * @Route("/admin/messages", name="admin_message")
     */
    public function index(MessageRepository $message)
    {
        $messages = $message->findAll();
        return $this->render('admin/messages/index.html.twig',[
            'messages' => $messages
        ]);
    }

    /**
     * Permet d'afficher le contenu d'un message
     * 
     * @Route("/admin/message/{id}", name="show_message")
     *
     * @param Message $message
     * @return void
     */
    public function show(Message $message){
        return $this->render('admin/messages/show.html.twig',[
            'message' => $message
        ]);
    }

    /**
     * Permet de supprimer un message
     * @Route("/admin/message/{id}/delete", name="delete_message")
     *
     * @return void
     */
    public function delete(Message $message, EntityManagerInterface $manager){
        $manager->remove($message);
        $manager->flush();

        $this->addFlash(
            'success',
            'Le message a bien été supprimé !'
        );

        return $this->redirectToRoute('admin_message');
    }
}
