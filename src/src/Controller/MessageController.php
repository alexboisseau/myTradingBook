<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessageController extends AbstractController
{
    /**
     * @Route("/message", name="message")
     */
    public function index()
    {
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }
    
    /**
     * @Route("/contact", name="contact")
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $message = new Message();

        $form = $this->createForm(MessageType::class,$message);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($message);
            $manager->flush();

            $this->addFlash(
                "success",
                "Votre message a bien été envoyé, il sera envoyé dans les plus brefs delais !"
            );

            return $this->redirectToRoute("home");
        }
        return $this->render('message/create.html.twig',[
            "form" => $form->createView()
        ]);
    }
}
