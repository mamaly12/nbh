<?php

namespace App\Controller;

use App\Entity\Clients;
use App\Entity\Users;
use App\Form\ClientFormType;
use App\Form\UserFormType;
use App\Security\LoginFormAuthenticator;
use App\Service\ClientsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Service\UsersService;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RegistrationController extends AbstractController
{

    /**
     * @var UsersService
     */
    private $usersService;

    /**
     * @var ClientsService
     */
    private $clientsService;

    /**
     * RegistrationController constructor.
     * @param UsersService $usersService
     * @param ClientsService $clientsService
     */
    public function __construct(UsersService $usersService,ClientsService $clientsService)
    {
        $this->usersService = $usersService;
        $this->clientsService = $clientsService;
    }

    /**
     * @param Request $request
     * @param GuardAuthenticatorHandler $guardHandler
     * @param LoginFormAuthenticator $authenticator
     * @Route("/register", name="app_register")
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function register(Request $request, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        $users=$this->usersService->findAllUsers();
        if(sizeof($users)==0) {
            $usersDto = new Users();
            $form = $this->createForm(UserFormType::class, $usersDto);
        }else{
            $clientsDto= new Clients();
            $form = $this->createForm(ClientFormType::class, $clientsDto);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            if(sizeof($users)==0) {
                $result =$this->usersService->addUser($form->get('email')->getData(),
                    $form->get('email')->getData(),$form->get('password')->getData());
            }else {
                $result = $this->clientsService->addClient($form->get('name')->getData(), $form->get('surname')->getData(),
                    $form->get('dateOfBirth')->getData(), $form->get('email')->getData(),
                    $form->get('email')->getData(), $form->get('password')->getData(),
                    $form->get('phoneNumber')->getData());
            }
            $user = $result['user'];
            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}