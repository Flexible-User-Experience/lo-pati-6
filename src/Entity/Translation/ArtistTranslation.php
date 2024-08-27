<?php

namespace App\Entity\Translation;

use App\Entity\Artist;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

#[ORM\Entity(repositoryClass: ArtistTranslationRepository::class)]
#[ORM\Table]
#[ORM\UniqueConstraint(name: 'lookup_artist_unique_idx', columns: ['locale', 'object_id', 'field'])]
class ArtistTranslation extends AbstractPersonalTranslation
{
    #[ORM\JoinColumn(name: 'object_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    #[ORM\ManyToOne(targetEntity: Artist::class, inversedBy: 'translations')]
    protected $object;
}
