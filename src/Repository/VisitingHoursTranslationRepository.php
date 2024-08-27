<?php

namespace App\Repository;

use App\Entity\Translation\VisitingHoursTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VisitingHoursTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisitingHoursTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisitingHoursTranslation[]    findAll()
 * @method VisitingHoursTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class VisitingHoursTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisitingHoursTranslation::class);
    }
}
