<?php

namespace App\Entity;

use App\Entity\Traits\Image1Trait;
use App\Entity\Traits\LegacyIdTrait;
use App\Entity\Traits\PositionTrait;
use App\Enum\NewsletterTypeEnum;
use App\Repository\NewsletterPostRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: NewsletterPostRepository::class)]
#[ORM\Table]
#[Vich\Uploadable]
class NewsletterPost extends AbstractBase
{
    use Image1Trait;
    use LegacyIdTrait;
    use PositionTrait;

    #[Assert\NotBlank]
    #[ORM\Column(type: Types::STRING, length: 255, nullable: false)]
    private string $title;

    #[Assert\File(maxSize: '10M', mimeTypes: ['image/gif', 'image/jpeg', 'image/pjpeg', 'image/png'])]
    #[Vich\UploadableField(mapping: 'newsletter', fileNameProperty: 'image1FileName')]
    private ?File $image1File = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $shortDescription = null;

    #[ORM\Column(type: Types::TEXT, length: 4000, nullable: true)]
    private ?string $description = null;

    #[Assert\Url]
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $link = null;

    #[ORM\ManyToOne(targetEntity: Newsletter::class, inversedBy: 'posts')]
    private Newsletter $newsletter;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $endDate = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $intervalDateText = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $type = NewsletterTypeEnum::NEWS;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getNewsletter(): Newsletter
    {
        return $this->newsletter;
    }

    public function setNewsletter(Newsletter $newsletter): self
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEndDate(): ?DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getIntervalDateText(): ?string
    {
        return $this->intervalDateText;
    }

    public function setIntervalDateText(?string $intervalDateText): self
    {
        $this->intervalDateText = $intervalDateText;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function getTypeTransString(): ?string
    {
        return NewsletterTypeEnum::getEnumArray()[$this->getType() ?? 0];
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function __toString(): string
    {
        return $this->id ? $this->getTitle() : AbstractBase::DEFAULT_EMPTY_STRING;
    }
}
