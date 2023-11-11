<?php

namespace App\Repository;

use App\Entity\FriendChat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FriendChat>
 *
 * @method FriendChat|null find($id, $lockMode = null, $lockVersion = null)
 * @method FriendChat|null findOneBy(array $criteria, array $orderBy = null)
 * @method FriendChat[]    findAll()
 * @method FriendChat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FriendChatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FriendChat::class);
    }

//    /**
//     * @return FriendChat[] Returns an array of FriendChat objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FriendChat
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
