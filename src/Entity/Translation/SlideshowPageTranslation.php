<?php

namespace App\Entity\Translation;

use App\Entity\SlideshowPage;
use App\Repository\SlideshowPageTranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

#[ORM\Entity(repositoryClass: SlideshowPageTranslationRepository::class)]
#[ORM\Table]
#[ORM\UniqueConstraint(name: 'lookup_slideshow_page_unique_idx', columns: ['locale', 'object_id', 'field'])]
class SlideshowPageTranslation extends AbstractPersonalTranslation
{
    #[ORM\JoinColumn(name: 'object_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: SlideshowPage::class, inversedBy: 'translations')]
    protected $object;
}
