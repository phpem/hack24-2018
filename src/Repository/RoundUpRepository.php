<?php

namespace App\Repository;

use App\Entity\RoundUp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RoundUp|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoundUp|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoundUp[]    findAll()
 * @method RoundUp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoundUpRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RoundUp::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('r')
            ->where('r.something = :value')->setParameter('value', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
