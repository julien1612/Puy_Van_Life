<?php

namespace App\Repository;

use App\Entity\FavoriteLocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FavoriteLocation>
 */
class FavoriteLocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavoriteLocation::class);
    }

    public function findByFavoriteLocation(int $limit = null): array {

        $qb = $this->createQueryBuilder('fav')
            ->leftJoin('fav.user', 'user')
            ->leftJoin('fav.location', 'location')
            ->groupBy('fav.location')
            ->orderBy('fav.location', 'ASC')
            ->distinct();


if ($limit !== null) {
    $qb->setMaxResults($limit);
}
        return $qb->getQuery()->getResult();

    }




}
