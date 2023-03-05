<?php

namespace App\Repository;

use App\Entity\Robot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Robot>
 *
 * @method Robot|null find($id, $lockMode = null, $lockVersion = null)
 * @method Robot|null findOneBy(array $criteria, array $orderBy = null)
 * @method Robot[]    findAll()
 * @method Robot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RobotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Robot::class);
    }

    public function save(Robot $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Robot $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
