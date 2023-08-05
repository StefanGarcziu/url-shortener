<?php
/**
 * Security controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\ChangeUserDataType;
use App\Service\UserServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * SecurityController class.
 */
class SecurityController extends AbstractController
{
    /**
     * User service.
     *
     * @var UserServiceInterface User service
     */
    private UserServiceInterface $userService;

    /**
     * Translator interface.
     *
     * @var TranslatorInterface Translator
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param UserServiceInterface $userService User service
     * @param TranslatorInterface  $translator  Translator
     */
    public function __construct(UserServiceInterface $userService, TranslatorInterface $translator)
    {
        $this->userService = $userService;
        $this->translator = $translator;
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    /**
     * Change password action.
     *
     * @param Request                     $request            Request
     * @param UserPasswordHasherInterface $userPasswordHasher Hasher
     *
     * @return Response Response
     */
    #[Route(
        '/user-edit',
        name: 'user_edit',
        methods: 'GET|POST'
    )]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(ChangeUserDataType::class);
        $form->get('name')->setData($user->getName());
        $form->get('surname')->setData($user->getSurname());


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get('oldPassword')->getData();
            if (!$userPasswordHasher->isPasswordValid($user, $oldPassword)) {
                $this->addFlash(
                    'danger',
                    $this->translator->trans('message.wrong_password')
                );

                return $this->redirectToRoute('user_edit');
            }

            $encodedPassword = $userPasswordHasher->hashPassword(
                $user,
                $form->get('password')->getData()
            );

            $this->userService->upgradePassword($user, $encodedPassword);
            $user->setName($form->get('name')->getData());
            $user->setSurname($form->get('surname')->getData());
            $this->userService->save($user);

            $this->addFlash(
                'success',
                $this->translator->trans('message.user_data_updated')
            );

            return $this->redirectToRoute('user_edit');
        }

        return $this->render(
            'security/change_user_data.html.twig',
            [
                'form' => $form->createView(),
                'user' => $user,
            ]
        );
    }

}
