<?php

namespace App\Entity\Translation;

use App\Entity\MenuLevel1;
use App\Repository\MenuLevel1TranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

#[ORM\Entity(repositoryClass: MenuLevel1TranslationRepository::class)]
#[ORM\Table]
#[ORM\UniqueConstraint(name: 'lookup_menu_level_1_unique_idx', columns: ['locale', 'object_id', 'field'])]
class MenuLevel1Translation extends AbstractPersonalTranslation
{
    #[ORM\JoinColumn(name: 'object_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: MenuLevel1::class, inversedBy: 'translations')]
    protected $object;
}
