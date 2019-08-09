<?php

namespace App\Repository;

use App\Entity\Clients;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\DateType;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Clients|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clients|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clients[]    findAll()
 * @method Clients[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientsRepository extends ServiceEntityRepository
{

    const ADDRESS = 'address';

    const COUNTRY = 'country';

    const TRADING_ACCOUNT_NUMBER= 'tradingAccountNumber';

    const BALANCE = 'balance';

    const OPEN_TRADES = 'openTrades';

    const CLOSE_TRADES= 'closeTrades';

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Clients::class);
    }

    /**
     * @param string $name
     * @param string $surname
     * @param \DateTime $dateOfBirth
     * @param string $email
     * @param string $password
     * @param string $phoneNumber
     * @return array|null
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addClient(string $name,string $surname, \DateTime $dateOfBirth, string $email, string $password,
                            string $phoneNumber): ? array
    {
        $clientsDto = new Clients();

        $clientsDto->setName($name);
        $clientsDto->setSurname($surname);
        $clientsDto->setDateOfBirth($dateOfBirth);
        $clientsDto->setEmail($email);
        $clientsDto->setPhoneNumber($phoneNumber);
        $clientsDto->setPassword(md5($password));
        $clientsDto=$this->createClientRandomData($clientsDto);
        $this->getEntityManager()->persist($clientsDto);
        $this->getEntityManager()->flush();
        return array('user'=>$clientsDto,'error'=>false, 'message'=>'Client registered successfully');
    }

    /**
     * @param Clients $clientsDto
     * @return Clients
     */
    public function createClientRandomData(Clients $clientsDto)
    {
        $clientsDto->setAddress($this->createRandomData(self::ADDRESS));
        $clientsDto->setCountry($this->createRandomData(self::COUNTRY));
        $clientsDto->setTradingAccountNumber($this->createRandomData(self::TRADING_ACCOUNT_NUMBER));
        $clientsDto->setBalance($this->createRandomData(self::BALANCE));
        $clientsDto->setOpenTrades($this->createRandomData(self::OPEN_TRADES));
        $clientsDto->setCloseTrades($this->createRandomData(self::CLOSE_TRADES));
        return $clientsDto;
    }
    /**
     * @param string $question
     * @return int|string
     */
    private function createRandomData(string $question)
    {
        switch ($question)
        {
            case self::ADDRESS :
                return $this->generateRandomString(256);
                break;
            case self::COUNTRY:
                return $this->generateRandomString(100);
                break;
            case self::TRADING_ACCOUNT_NUMBER:
                return $this->generateRandomString(256);
                break;
            case self::BALANCE:
                return rand(1, 100000);
                break;
            case self::OPEN_TRADES:
                return $this->generateRandomString(256);
                break;
            case self::CLOSE_TRADES:
                return $this->generateRandomString(256);
                break;
        }
    }


    /**
     * @param int $length
     * @param string $characters
     * @return string
     */
    public function generateRandomString($length = 16, $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
