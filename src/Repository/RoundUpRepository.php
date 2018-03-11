<?php

namespace App\Repository;

use App\Entity\RoundUp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
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

    public function save(RoundUp $roundup)
    {
        $this->_em->persist($roundup);
        $this->_em->flush();
    }

    public function calculateMonthEnd(string $customerID, $start, $end)
    {

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('total', 'total');

        $query = $this->_em->createNativeQuery("
          SELECT SUM(value_value) as total
          FROM round_up as r
          INNER JOIN transaction as t
          ON r.transaction_id = t.id
          INNER JOIN customer as c
          ON t.customer_id = c.id
          WHERE t.transaction_date >= :startDate
          AND t.transaction_date <= :endDate
          AND c.id = :customerID;",
        $rsm);

        $query->setParameters([
            'startDate' => $start,
            'endDate' => $end,
            'customerID' => $customerID
        ]);

        return $query->getSingleScalarResult();
    }

    /**
     * @return RoundUp[]
     */
    public function getList()
    {
        return $this->createQueryBuilder('r')
            ->join('r.transaction', 't')
            ->orderBy('t.transactionDate', 'DESC')->getQuery()->getResult();
    }
}
