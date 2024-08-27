<?php

namespace App\Entity;

use App\Entity\Traits\Image1Trait;
use App\Entity\Traits\PositionTrait;
use App\Repository\PageImageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: PageImageRepository::class)]
#[ORM\Table]
#[Vich\Uploadable]
class PageImage extends AbstractBase
{
    use Image1Trait;
    use PositionTrait;

    #[Assert\File(maxSize: '10M', mimeTypes: ['image/jpeg', 'image/pjpeg', 'image/png'])]
    #[Vich\UploadableField(mapping: 'image', fileNameProperty: 'image1FileName')]
    private ?File $image1File = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $imageAltName;

    #[ORM\JoinColumn(nullable: false)]
    #[ORM\ManyToOne(targetEntity: Page::class, inversedBy: 'images')]
    private Page $page;

    public function __construct()
    {
        $this->position = 1;
    }

    public function getImageAltName(): ?string
    {
        return $this->imageAltName;
    }

    public function setImageAltName(?string $imageAltName): self
    {
        $this->imageAltName = $imageAltName;

        return $this;
    }

    public function getPage(): Page
    {
        return $this->page;
    }

    public function setPage(Page $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function __toString(): string
    {
        return $this->id ? (string) $this->getId() : AbstractBase::DEFAULT_EMPTY_STRING;
    }
}
