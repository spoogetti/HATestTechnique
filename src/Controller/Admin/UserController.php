<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\NewUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/user')]
#[IsGranted(User::ROLE_ADMIN)]
class UserController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $users,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    #[Route('/', name: 'admin_user_index', methods: ['GET'])]
    public function index(): Response
    {
        $allUsers = $this->users->findBy([], ['id' => 'ASC']);
        
        return $this->render('admin/user/index.html.twig', [
            'users' => $allUsers,
        ]);
    }

    #[Route('/new', name: 'admin_user_new', methods: ['GET', 'POST'])]
    public function new(
        #[CurrentUser] User $user,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
    $newUser = new User();
    
    // See https://symfony.com/doc/current/form/multiple_buttons.html
    $form = $this->createForm(NewUserType::class, $newUser)
        ->add('saveAndCreateNew', SubmitType::class)
    ;

    $form->handleRequest($request);

    // The isSubmitted() call is mandatory because the isValid() method
    // throws an exception if the form has not been submitted.
    // See https://symfony.com/doc/current/forms.html#processing-forms
    if ($form->isSubmitted() && $form->isValid()) {
        // Hash the password before saving it in the database
        $newUser->setPassword(
            $this->passwordHasher->hashPassword($newUser, $newUser->getPassword())
        );

        $entityManager->persist($newUser);
        $entityManager->flush();

        // Flash messages are used to notify the user about the result of the
        // actions. They are deleted automatically from the session as soon
        // as they are accessed.
        // See https://symfony.com/doc/current/controller.html#flash-messages
        $this->addFlash('success', 'user.created_successfully');

        /** @var SubmitButton $submit */
        $submit = $form->get('saveAndCreateNew');

        if ($submit->isClicked()) {
            return $this->redirectToRoute('admin_user_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->redirectToRoute('admin_user_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('admin/user/new.html.twig', [
        'user' => $newUser,
        'form' => $form,
    ]);
    }
}
