<?php

namespace App\Service;

use App\Entity\Users;
use App\Repository\UsersRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UsersService
{

    /**
     * @var UsersRepository
     */
    private $usersDao;

    /**
     * UserService constructor.
     * @param UsersRepository $UsersRepository
     */
    public function __construct(UsersRepository $UsersRepository)
    {
        $this->usersDao=$UsersRepository;
    }


    /**
     * @return array|null
     */
    public function findAllUsers(): ?array
    {
        return $this->usersDao->findAll();
    }

    /**
     * @return mixed
     */
    public function getAdmin()
    {
        return $this->usersDao->getAdmin();
    }

    /**
     * @param string $email
     * @param string $password
     * @return array|null
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addUser(string $email, string $password): ?array
    {
        return $this->usersDao->addUser($email,$password);
    }

    /**
     * @param $id
     * @return array|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteUserById($id): ?array
    {
        return $this->usersDao->deleteUserById($id);
    }

    /**
     * @param $user
     * @return bool
     */
    public function isUserManager($user)
    {
        $managerRoles=array(RolesRepository::ROLE_ADMIN,RolesRepository::ROLE_USER);
        if(in_array($user->getRoles(),$managerRoles))
        {
            return true;
        }
        return false;
    }

    public function prepareDashboardData($user)
    {

    }
}