<?php


namespace App\Controller;
use App\Repository\RolesRepository;
use App\Service\ClientsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UsersService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UsersController extends AbstractController
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
     * UsersController constructor.
     * @param UsersService $usersService
     * @param ClientsService $clientsService
     */
    public function __construct(UsersService $usersService,ClientsService $clientsService)
    {
        $this->usersService = $usersService;
        $this->clientsService = $clientsService;
    }
    /**
     * @return Response
     * @Route("user/dashboard", name="home_url", methods={"GET"})
     */
    public function index(){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user= $this->getUser();
        $isManager = $this->usersService->isUserManager($user);
        if($isManager)
        {
            $dashboardData = $this->usersService->prepareDashboardData($user);
            return $this->render('users/dashboard.html.twig', array('$dashboardData' => $dashboardData));
        }
        else {
            return $this->render('clients/dashboard.html.twig', array('client' => $user));
        }
    }

    /**
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @param $request
     * @Route("/user/delete", name="delete_user", methods={"DELETE"})
     */
    public function deleteUserAjax(Request $request){
        $id = $request->get('id');
        $result= $this->userService->deleteUserById($id);
        exit(json_encode($result));
    }

}