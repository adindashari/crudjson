<?php

namespace App\Repository;

use App\Entity\Identity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Identity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Identity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Identity[]    findAll()
 * @method Identity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IdentityRepository extends ServiceEntityRepository
{
    public $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Identity::class);
        $this->manager = $manager;
    }

    public function simpanIdentity($Nama, $Telp, $Email, $Alamat){
        $newIdentity = new Identity();

        $newIdentity
        ->setNama($Nama)
        ->setTelp($Telp)
        ->setEmail($Email)
        ->setAlamat($Alamat);

        $this->manager->persist($newIdentity);
        $this->manager->flush();
    }


    public function revisiIdentity(Identity $identity, $data)
    {
        empty($data['nama']) ? true : $identity->setNama($data['nama']);
        empty($data['telp']) ? true : $identity->setTelp($data['telp']);
        empty($data['email']) ? true : $identity->setEmail($data['email']);
        empty($data['alamat']) ? true : $identity->setAlamat($data['alamat']);

        $this->manager->flush();
    }

    public function hapusIdentity(Identity $identity)
    {
        $this->manager->remove($identity);
        $this->manager->flush();
    }
        
    // /**
    //  * @return Identity[] Returns an array of Identity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Identity
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
