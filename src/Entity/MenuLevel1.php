<?php

namespace App\Entity;

use App\Entity\Traits\LegacyIdTrait;
use App\Entity\Traits\PositionTrait;
use App\Entity\Traits\SlugTrait;
use App\Entity\Traits\TranslationsTrait;
use App\Entity\Translation\MenuLevel1Translation;
use App\Enum\LabelColorEnum;
use App\Enum\SortOrderTypeEnum;
use App\Repository\MenuLevel1Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MenuLevel1Repository::class)]
#[ORM\Table]
#[ORM\UniqueConstraint(name: 'unique_menu_level1_name_index', columns: ['name'])]
#[UniqueEntity(fields: ['name'], errorPath: 'name')]
#[Gedmo\TranslationEntity(class: MenuLevel1Translation::class)]
class MenuLevel1 extends AbstractBase
{
    use LegacyIdTrait;
    use PositionTrait;
    use SlugTrait;
    use TranslationsTrait;

    public const string DEFAULT_COLOR = LabelColorEnum::TEAL;

    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::STRING, length: 255, unique: true)]
    private ?string $name = null;

    #[Gedmo\Slug(fields: ['name'])]
    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $slug;

    #[ORM\Column(type: Types::STRING, length: 255, options: ['default' => self::DEFAULT_COLOR])]
    private string $color = self::DEFAULT_COLOR;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $isArchive = false;

    #[ORM\OneToMany(targetEntity: MenuLevel2::class, mappedBy: 'menuLevel1')]
    #[ORM\OrderBy(['position' => SortOrderTypeEnum::ASC, 'name' => SortOrderTypeEnum::ASC])]
    private ?Collection $menuLevel2items;

    #[ORM\OneToOne(targetEntity: Page::class, cascade: ['persist', 'remove'])]
    private ?Page $page = null;

    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: MenuLevel1Translation::class, mappedBy: 'object', cascade: ['persist', 'remove'])]
    private ?Collection $translations;

    public function __construct()
    {
        $this->menuLevel2items = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getCssBackgroudClassColor(): string
    {
        return LabelColorEnum::getCssClassValueByHexColor($this->getColor());
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function isArchive(): bool
    {
        return $this->isArchive;
    }

    public function isArchiveString(): string
    {
        return AbstractBase::transformBooleanAsString($this->isArchive());
    }

    public function getIsArchive(): bool
    {
        return $this->isArchive();
    }

    public function setIsArchive(bool $isArchive): self
    {
        $this->isArchive = $isArchive;

        return $this;
    }

    public function getMenuLevel2items(): ?Collection
    {
        return $this->menuLevel2items;
    }

    public function setMenuLevel2items(?Collection $menuLevel2items): self
    {
        $this->menuLevel2items = $menuLevel2items;

        return $this;
    }

    public function addMenuLevel2Item(MenuLevel2 $menuLevel2Item): self
    {
        if (!$this->menuLevel2items->contains($menuLevel2Item)) {
            $this->menuLevel2items->add($menuLevel2Item);
            $menuLevel2Item->setMenuLevel1($this);
        }

        return $this;
    }

    public function removeMenuLevel2Item(MenuLevel2 $menuLevel2Item): self
    {
        $this->menuLevel2items->removeElement($menuLevel2Item);

        return $this;
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId() && $this->getName() ? $this->getName() : self::DEFAULT_EMPTY_STRING;
    }
}
