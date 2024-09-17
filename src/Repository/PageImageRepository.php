<?php

namespace App\Repository;

use App\Entity\Page;
use App\Entity\PageImage;
use App\Enum\SortOrderTypeEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PageImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageImage[]    findAll()
 * @method PageImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class PageImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageImage::class);
    }

    public function getValidImagesSortedByPositionForPageQB(Page $page): QueryBuilder
    {
        return $this->createQueryBuilder('pi')
            ->where('pi.page = :page')
            ->andWhere('pi.image1FileName IS NOT NULL')
            ->setParameter('page', $page)
            ->orderBy('pi.position', SortOrderTypeEnum::ASC);
    }

    public function getValidImagesSortedByPositionForPageQ(Page $page): Query
    {
        return $this->getValidImagesSortedByPositionForPageQB($page)->getQuery();
    }

    public function getValidImagesSortedByPositionForPage(Page $page): array
    {
        return $this->getValidImagesSortedByPositionForPageQ($page)->getResult();
    }
}
