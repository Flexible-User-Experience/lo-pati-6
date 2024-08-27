<?php

namespace App\Repository;

use App\Entity\Translation\ArtistTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArtistTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArtistTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArtistTranslation[]    findAll()
 * @method ArtistTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ArtistTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArtistTranslation::class);
    }
}
