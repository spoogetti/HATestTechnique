<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $users
    ) {
    }

    #[Route('/admin/users', name: 'admin_user_index', methods: ['GET'])]
    #[IsGranted(User::ROLE_ADMIN)]
    public function index(): Response
    {
        $allUsers = $this->users->findBy([], ['id' => 'ASC']);
        
        return $this->render('admin/user/index.html.twig', [
            'users' => $allUsers,
        ]);
    }
}