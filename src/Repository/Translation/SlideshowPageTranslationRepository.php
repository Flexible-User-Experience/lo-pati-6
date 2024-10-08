<?php

namespace App\Repository\Translation;

use App\Entity\Translation\SlideshowPageTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SlideshowPageTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method SlideshowPageTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method SlideshowPageTranslation[]    findAll()
 * @method SlideshowPageTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class SlideshowPageTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SlideshowPageTranslation::class);
    }
}
