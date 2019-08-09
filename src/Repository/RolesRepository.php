<?php

namespace App\Repository;

use App\Entity\Roles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Roles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Roles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Roles[]    findAll()
 * @method Roles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RolesRepository extends ServiceEntityRepository
{
    const ROLE_ADMIN='ROLE_ADMIN';

    const ROLE_USER='ROLE_USER';

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Roles::class);
    }

    /**
     * @return Roles|null
     */
    public function findAdminRole()
    {
        return  $this->findOneBy(array('name'=>self::ROLE_ADMIN));
    }

    /**
     * @return Roles|null
     */
    public function findUserRole()
    {
        return  $this->findOneBy(array('name'=>elf::ROLE_USER));
    }
}
