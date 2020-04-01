<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/user/{page<\d+>?1}", name="admin_user")
     */
    public function index(UserRepository $userRepo, $page, EntityManagerInterface $manager)
    {

        $users = $userRepo->findAll();

        return $this->render('admin/user/index.html.twig', [
            "users" => $users
        ]);
    }

    /**
     * Permet de supprimer un user
     * @Route("admin/delete/user/{id}", name="delete_user")
     *
     * @param User $user
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function delete(User $user, EntityManagerInterface $manager){
        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            'L\'utilisateur a bien été supprimé !'
        );

        return $this->redirectToRoute('admin_user');
    }
}
