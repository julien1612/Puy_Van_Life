<?php

namespace App\Repository;

use App\Entity\Picture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Picture>
 */
class PictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Picture::class);
    }

    public function findByPictures(int $limit = null): array
    {

        $qb = $this->createQueryBuilder('p');


        if ($limit !== null) {
            $qb->setMaxResults($limit);

        }

        return $qb->getQuery()->getResult();

    }
}
