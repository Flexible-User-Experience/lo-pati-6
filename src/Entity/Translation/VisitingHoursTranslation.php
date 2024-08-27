<?php

namespace App\Entity\Translation;

use App\Entity\VisitingHours;
use App\Repository\VisitingHoursTranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

#[ORM\Entity(repositoryClass: VisitingHoursTranslationRepository::class)]
#[ORM\Table]
#[ORM\UniqueConstraint(name: 'lookup_visiting_hours_unique_idx', columns: ['locale', 'object_id', 'field'])]
class VisitingHoursTranslation extends AbstractPersonalTranslation
{
    #[ORM\JoinColumn(name: 'object_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: VisitingHours::class, inversedBy: 'translations')]
    protected $object;
}
