<?php

namespace App\Entity;

use App\Entity\Traits\TranslationsTrait;
use App\Entity\Translation\VisitingHoursTranslation;
use App\Repository\VisitingHoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VisitingHoursRepository::class)]
#[ORM\Table]
#[Gedmo\TranslationEntity(class: VisitingHoursTranslation::class)]
class VisitingHours extends AbstractBase
{
    use TranslationsTrait;

    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::STRING, length: 255, unique: true)]
    private ?string $name = null;

    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $textLine1 = null;

    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $textLine2 = null;

    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: VisitingHoursTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'])]
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

    public function getTextLine1(): ?string
    {
        return $this->textLine1;
    }

    public function setTextLine1(string $textLine1): self
    {
        $this->textLine1 = $textLine1;

        return $this;
    }

    public function getTextLine2(): ?string
    {
        return $this->textLine2;
    }

    public function setTextLine2(?string $textLine2): self
    {
        $this->textLine2 = $textLine2;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId() && $this->getName() ? $this->getName() : self::DEFAULT_EMPTY_STRING;
    }
}
