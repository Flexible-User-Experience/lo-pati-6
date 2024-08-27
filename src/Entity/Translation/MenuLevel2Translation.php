<?php

namespace App\Entity\Translation;

use App\Entity\MenuLevel2;
use App\Repository\MenuLevel2TranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

#[ORM\Entity(repositoryClass: MenuLevel2TranslationRepository::class)]
#[ORM\Table]
#[ORM\UniqueConstraint(name: 'lookup_menu_level_2_unique_idx', columns: ['locale', 'object_id', 'field'])]
class MenuLevel2Translation extends AbstractPersonalTranslation
{
    #[ORM\JoinColumn(name: 'object_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: MenuLevel2::class, inversedBy: 'translations')]
    protected $object;
}
