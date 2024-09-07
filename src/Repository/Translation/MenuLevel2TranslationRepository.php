<?php

namespace App\Repository\Translation;

use App\Entity\Translation\MenuLevel2Translation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MenuLevel2Translation|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuLevel2Translation|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuLevel2Translation[]    findAll()
 * @method MenuLevel2Translation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class MenuLevel2TranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuLevel2Translation::class);
    }
}
