<?php

namespace App\Repository;

use App\Entity\ClientOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientOrder::class);
    }

    public function findAllApi(){
        $query = $this->createQueryBuilder('co')
            ->select('co.id, c.name AS client, p.name AS product, op.amount, co.cost')
            ->join('co.client', 'c')
            ->join('co.orders_products', 'op')
            ->join('op.products', 'p')
        ;

        return $query->getQuery()->getResult();
    }
}
