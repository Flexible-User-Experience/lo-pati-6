<?php

namespace App\Entity;

use App\Entity\Traits\LegacyIdTrait;
use App\Entity\Traits\SmallImage1Trait;
use App\Entity\Traits\SmallImage2Trait;
use App\Repository\ArchiveRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ArchiveRepository::class)]
#[ORM\Table]
#[ORM\UniqueConstraint(name: 'unique_archive_year_index', columns: ['year'])]
#[UniqueEntity(fields: ['year'], errorPath: 'year')]
#[Vich\Uploadable]
class Archive extends AbstractBase
{
    use LegacyIdTrait;
    use SmallImage1Trait;
    use SmallImage2Trait;

    #[ORM\Column(type: Types::INTEGER, unique: true)]
    private int $year;

    #[Assert\File(maxSize: '10M', mimeTypes: ['image/jpeg', 'image/pjpeg', 'image/png'])]
    #[Assert\Image(minWidth: 400, minHeight: 400, allowSquare: true, allowLandscape: false, allowPortrait: false)]
    #[Vich\UploadableField(mapping: 'image', fileNameProperty: 'smallImage1FileName')]
    private ?File $smallImage1File = null;

    #[Assert\File(maxSize: '10M', mimeTypes: ['image/jpeg', 'image/pjpeg', 'image/png'])]
    #[Assert\Image(minWidth: 400, minHeight: 400, allowSquare: true, allowLandscape: false, allowPortrait: false)]
    #[Vich\UploadableField(mapping: 'image', fileNameProperty: 'smallImage2FileName')]
    private ?File $smallImage2File = null;

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function __toString(): string
    {
        return $this->id ? (string) $this->getYear() : AbstractBase::DEFAULT_EMPTY_STRING;
    }
}
