<?php

namespace App\Entity;

use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\Document1Trait;
use App\Entity\Traits\Image1Trait;
use App\Entity\Traits\LegacyIdTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\SummaryTrait;
use App\Entity\Traits\TranslationsTrait;
use App\Entity\Translation\ArtistTranslation;
use App\Repository\ArtistRepository;
use Cocur\Slugify\Slugify;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
#[ORM\Table]
#[ORM\UniqueConstraint(name: 'unique_artist_name_index', columns: ['name'])]
#[UniqueEntity(fields: ['name'], errorPath: 'name')]
#[Gedmo\TranslationEntity(class: ArtistTranslation::class)]
#[Vich\Uploadable]
class Artist extends AbstractBase
{
    use DescriptionTrait;
    use Document1Trait;
    use Image1Trait;
    use LegacyIdTrait;
    use NameTrait;
    use SummaryTrait;
    use TranslationsTrait;

    #[ORM\Column(type: Types::STRING, length: 255, unique: true)]
    private string $name;

    private string $slug;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $city;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $year;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $category;

    #[Assert\Url]
    #[ORM\Column(type: Types::STRING, length: 1024, nullable: true)]
    private ?string $webpage;

    #[Assert\File(maxSize: '10M', mimeTypes: ['image/jpeg', 'image/pjpeg', 'image/png'])]
    #[Vich\UploadableField(mapping: 'artist', fileNameProperty: 'image1FileName')]
    private ?File $image1File = null;

    #[Assert\File(maxSize: '10M', mimeTypes: ['image/jpeg', 'image/pjpeg', 'image/png'])]
    #[Vich\UploadableField(mapping: 'artist', fileNameProperty: 'image2FileName')]
    private ?File $image2File = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $image2FileName = null;

    #[Assert\File(maxSize: '10M', mimeTypes: ['image/jpeg', 'image/pjpeg', 'image/png'])]
    #[Vich\UploadableField(mapping: 'artist', fileNameProperty: 'image3FileName')]
    private ?File $image3File = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $image3FileName = null;

    #[Assert\File(maxSize: '10M', mimeTypes: ['image/jpeg', 'image/pjpeg', 'image/png'])]
    #[Vich\UploadableField(mapping: 'artist', fileNameProperty: 'image4FileName')]
    private ?File $image4File = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $image4FileName = null;

    #[Assert\File(maxSize: '10M', mimeTypes: ['image/jpeg', 'image/pjpeg', 'image/png'])]
    #[Vich\UploadableField(mapping: 'artist', fileNameProperty: 'image5FileName')]
    private ?File $image5File = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $image5FileName = null;

    #[Assert\File(maxSize: '20M', mimeTypes: ['application/pdf'])]
    #[Vich\UploadableField(mapping: 'artist_cv', fileNameProperty: 'document1FileName')]
    private ?File $document1File = null;

    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: ArtistTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'])]
    private ?Collection $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getSlug(): string
    {
        return $this->name ? $this->slug = (new Slugify())->slugify($this->getName()) : AbstractBase::DEFAULT_EMPTY_STRING;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getWebpage(): ?string
    {
        return $this->webpage;
    }

    public function setWebpage(?string $webpage): self
    {
        $this->webpage = $webpage;

        return $this;
    }

    public function getImage2File(): ?File
    {
        return $this->image2File;
    }

    public function setImage2File(?File $image2File): self
    {
        $this->image2File = $image2File;
        if (null !== $image2File) {
            $this->updatedAt = new DateTimeImmutable();
        }

        return $this;
    }

    public function getImage2FileName(): ?string
    {
        return $this->image2FileName;
    }

    public function setImage2FileName(?string $image2FileName): self
    {
        $this->image2FileName = $image2FileName;

        return $this;
    }

    public function getImage3File(): ?File
    {
        return $this->image3File;
    }

    public function setImage3File(?File $image3File): self
    {
        $this->image3File = $image3File;
        if (null !== $image3File) {
            $this->updatedAt = new DateTimeImmutable();
        }

        return $this;
    }

    public function getImage3FileName(): ?string
    {
        return $this->image3FileName;
    }

    public function setImage3FileName(?string $image3FileName): self
    {
        $this->image3FileName = $image3FileName;

        return $this;
    }

    public function getImage4File(): ?File
    {
        return $this->image4File;
    }

    public function setImage4File(?File $image4File): self
    {
        $this->image4File = $image4File;
        if (null !== $image4File) {
            $this->updatedAt = new DateTimeImmutable();
        }

        return $this;
    }

    public function getImage4FileName(): ?string
    {
        return $this->image4FileName;
    }

    public function setImage4FileName(?string $image4FileName): self
    {
        $this->image4FileName = $image4FileName;

        return $this;
    }

    public function getImage5File(): ?File
    {
        return $this->image5File;
    }

    public function setImage5File(?File $image5File): self
    {
        $this->image5File = $image5File;
        if (null !== $image5File) {
            $this->updatedAt = new DateTimeImmutable();
        }

        return $this;
    }

    public function getImage5FileName(): ?string
    {
        return $this->image5FileName;
    }

    public function setImage5FileName(?string $image5FileName): self
    {
        $this->image5FileName = $image5FileName;

        return $this;
    }

    public function __toString(): string
    {
        return $this->id ? $this->getName() : AbstractBase::DEFAULT_EMPTY_STRING;
    }
}
