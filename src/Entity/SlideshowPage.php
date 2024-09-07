<?php

namespace App\Entity;

use App\Entity\Traits\PositionTrait;
use App\Entity\Traits\SummaryTrait;
use App\Entity\Traits\TranslationsTrait;
use App\Entity\Translation\SlideshowPageTranslation;
use App\Repository\SlideshowPageRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: SlideshowPageRepository::class)]
#[ORM\Table]
#[Gedmo\TranslationEntity(class: SlideshowPageTranslation::class)]
#[Vich\Uploadable]
class SlideshowPage extends AbstractBase
{
    use PositionTrait;
    use SummaryTrait;
    use TranslationsTrait;

    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::STRING, length: 255, nullable: false)]
    private ?string $name = null;

    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::TEXT, length: 4000, nullable: true)]
    private ?string $description = null;

    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $realizationDateString = null;

    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $place = null;

    #[ORM\Column(type: Types::TEXT, length: 4000, nullable: true)]
    private ?string $link = null;

    #[Assert\File(maxSize: '10M', mimeTypes: ['image/jpeg', 'image/pjpeg', 'image/png'])]
    #[Vich\UploadableField(mapping: 'image', fileNameProperty: 'imageFileName')]
    private ?File $imageFile = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $imageFileName = null;

    #[ORM\ManyToOne(targetEntity: MenuLevel1::class)]
    private ?MenuLevel1 $menuLevel1 = null;

    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity: MenuLevel2::class)]
    private ?MenuLevel2 $menuLevel2 = null;

    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: SlideshowPageTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'])]
    private ?Collection $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRealizationDateString(): ?string
    {
        return $this->realizationDateString;
    }

    public function setRealizationDateString(?string $realizationDateString): self
    {
        $this->realizationDateString = $realizationDateString;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(?string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;
        if (null !== $imageFile) {
            $this->updatedAt = new DateTimeImmutable();
        }

        return $this;
    }

    public function getImageFileName(): ?string
    {
        return $this->imageFileName;
    }

    public function setImageFileName(?string $imageFileName): self
    {
        $this->imageFileName = $imageFileName;

        return $this;
    }

    public function getMenuLevel1(): ?MenuLevel1
    {
        return $this->menuLevel1;
    }

    public function setMenuLevel1(?MenuLevel1 $menuLevel1): self
    {
        $this->menuLevel1 = $menuLevel1;

        return $this;
    }

    public function getMenuLevel2(): ?MenuLevel2
    {
        return $this->menuLevel2;
    }

    public function setMenuLevel2(?MenuLevel2 $menuLevel2): self
    {
        $this->menuLevel2 = $menuLevel2;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId() && $this->getName() ? $this->getName() : self::DEFAULT_EMPTY_STRING;
    }
}
