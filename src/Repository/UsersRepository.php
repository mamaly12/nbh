<?php

namespace App\Repository;

use App\Entity\Roles;
use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class UsersRepository extends ServiceEntityRepository
{
    /**
     * @var RolesRepository $rolesRepository
     */
    private $rolesRepository;

    /**
     * UsersRepository constructor.
     * @param RegistryInterface $registry
     * @param \App\Repository\RolesRepository $rolesRepository
     */
    public function __construct(RegistryInterface $registry, RolesRepository $rolesRepository)
    {
        parent::__construct($registry, Users::class);
        $this->rolesRepository=$rolesRepository;
    }

    /**
     * @param string $email
     * @param string $password
     * @return array|null
     * @throws \Doctrine\DBAL\DBALException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addUser(string $email, string $password): ? array
    {
        $usersDto = new Users();
        $adminRole=$this->rolesRepository->findAdminRole();
        $usersDto->setEmail($email);
        if($this->findAdminUser($adminRole)==null)
        {
            $usersDto->setRole($adminRole);
        }else{
            $userRole=$this->rolesRepository->findUserRole();
            $usersDto->setRole($userRole);
        }
        $usersDto->setPassword(md5($password));
        $this->getEntityManager()->persist($usersDto);
        $this->getEntityManager()->flush();
        return array('user'=>$usersDto,'error'=>false, 'message'=>'User registered successfully');
    }


    /**
     * @param $id
     * @return bool|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteUserById($id): ?array
    {

        $user =$this->find($id);
        if (!isset($user)) {
            return array('result'=>false,'error'=>true, 'message'=>'User cannot be deleted');
        }
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
        return array('result'=>true,'error'=>false, 'message'=>'User deleted successfully');
    }

    /**
     * @param Roles $roles
     * @return Users|null
     */
    public function findAdminUser(Roles $roles)
    {
      return $this->findOneBy(array('role'=>$roles));
    }
}
