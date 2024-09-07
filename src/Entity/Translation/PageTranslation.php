<?php

namespace App\Entity\Translation;

use App\Entity\Page;
use App\Repository\Translation\PageTranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

#[ORM\Entity(repositoryClass: PageTranslationRepository::class)]
#[ORM\Table]
#[ORM\UniqueConstraint(name: 'lookup_page_unique_idx', columns: ['locale', 'object_id', 'field'])]
class PageTranslation extends AbstractPersonalTranslation
{
    #[ORM\JoinColumn(name: 'object_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: Page::class, inversedBy: 'translations')]
    protected $object;
}
