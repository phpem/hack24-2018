<?php

namespace App\Repository;

use App\Entity\Customer;
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

    public function save(RoundUp $roundup)
    {
        $this->_em->persist($roundup);
        $this->_em->flush();
    }

    public function getMonthlyTotalForCustomer(Customer $customer)
    {
        /*
         *
            SELECT SUM(value_value)

            FROM round_up as r

            INNER JOIN transaction as t
            ON r.transaction_id = t.id

            INNER JOIN customer as c
            ON t.customer_id = c.id

            WHERE t.transaction_date >= '2018-03-10 00:00:00'

            GROUP BY c.id
            ;
         */
    }
}
