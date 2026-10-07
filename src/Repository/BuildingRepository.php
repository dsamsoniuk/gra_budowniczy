<?php

namespace App\Repository;

use App\Entity\Building;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Schema\DefaultExpression\CurrentDate;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineExtensions\Query\Mysql\TimestampDiff;
use DoctrineExtensions\Query\Mysql\UtcTimestamp;

/**
 * @extends ServiceEntityRepository<Building>
 */
class BuildingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Building::class);
    }

   public function findAllasArray(): array
   {
    
       return $this->createQueryBuilder('b')
           ->getQuery()
           ->getArrayResult()
       ;
   }
   
   public function findBuildings(User $user, $status = 'finished'){
    // UtcTimestamp
    // TimestampDiff
    return $this->createQueryBuilder('b')
        ->select([
            'b.id', 'ub.id ub_id', 'b.name', 'b.buildTime', 'b.goldCost', 'ub.finishTime', 'b.avatar',
            'TIMESTAMPDIFF(SECOND, CURRENT_TIMESTAMP(), ub.finishTime) timeLeft'])
        ->leftJoin('b.userBuildings', 'ub', 'ub.building_id = b.id')
        ->where('ub.user = :user')
        ->andWhere('ub.status = :status')
        ->setParameter('user', $user)
        ->setParameter('status', $status)
        ->orderBy('ub.id', 'asc')
        ->getQuery()
        ->getArrayResult()
    ;
   }

//    public function findOneBySomeField($value): ?Building
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
