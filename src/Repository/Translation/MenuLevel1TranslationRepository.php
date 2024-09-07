<?php

namespace App\Repository\Translation;

use App\Entity\Translation\MenuLevel1Translation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MenuLevel1Translation|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuLevel1Translation|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuLevel1Translation[]    findAll()
 * @method MenuLevel1Translation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class MenuLevel1TranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuLevel1Translation::class);
    }
}
