<?php

namespace App\Service;

use App\Entity\Clients;
use App\Repository\ClientsRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class ClientsService
{

    /**
     * @var ClientsRepository
     */
    private $clientsDao;

    /**
     * UserService constructor.
     * @param ClientsRepository $ClientRepository
     */
    public function __construct(ClientsRepository $ClientRepository)
    {
        $this->clientsDao=$ClientRepository;
    }

    /**
     * @param string $name
     * @param string $surname
     * @param string $dateOfBirth
     * @param string $email
     * @param string $password
     * @param string $phoneNumber
     * @return array|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addClient(string $name,string $surname, \DateTime $dateOfBirth, string $email, string $password,
                            string $phoneNumber): ?array
    {
        return $this->clientsDao->addClient($name, $surname, $dateOfBirth, $email,$password, $phoneNumber);
    }



}