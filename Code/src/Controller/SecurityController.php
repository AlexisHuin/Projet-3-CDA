<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    /**
     * This controller allow us to login
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    #[Route('/login', name: 'security.login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('pages/security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    /**
     * This controller allow us to logout
     *
     * @return void
     */
    #[Route('/logout', 'security.logout')]
    public function logout()
    {
        // Nothing to do here..
    }

    /**
     * This controller allow us to register 
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/register', 'security.registration', methods: ['GET', 'POST'])]
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_USER'])
            ->setAvatarUrl('default.webp')
            ->setGiftPoints(0);

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));

            $manager->persist($user);
            try {
                $manager->flush();
            } catch (\Exception $e) {
                $errorMessage = 'An error occurred while creating the account.';
                if ($e->getCode() === '1062') {
                    $errorMessage = 'This email address is already registered.';
                }
                $this->addFlash('error', $errorMessage);
                return $this->redirectToRoute('security.registration');
            }

            $this->authenticateUser($user);

            $this->addFlash(
                'success',
                'Votre compte a bien été créé.'
            );
            return $this->redirectToRoute('user.index');
        }

        return $this->render('pages/security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function authenticateUser(User $user)
    {
        $token = new UsernamePasswordToken(
            $user,
            'main',
            $user->getRoles()
        );

        $this->container->get("security.token_storage")->setToken($token);
    }
}