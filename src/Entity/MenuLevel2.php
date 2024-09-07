<?php

namespace App\Entity;

use App\Entity\Traits\LegacyIdTrait;
use App\Entity\Traits\PositionTrait;
use App\Entity\Traits\SlugTrait;
use App\Entity\Traits\TranslationsTrait;
use App\Entity\Translation\MenuLevel2Translation;
use App\Enum\SortOrderTypeEnum;
use App\Repository\MenuLevel2Repository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MenuLevel2Repository::class)]
#[ORM\Table]
#[ORM\UniqueConstraint(name: 'unique_menu_level2_name_level1_index', columns: ['name', 'menu_level1_id'])]
#[UniqueEntity(fields: ['name', 'menuLevel1'], errorPath: 'name')]
#[Gedmo\TranslationEntity(class: MenuLevel2Translation::class)]
class MenuLevel2 extends AbstractBase
{
    use LegacyIdTrait;
    use PositionTrait;
    use SlugTrait;
    use TranslationsTrait;

    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $name = null;

    #[Gedmo\Slug(fields: ['name'], unique: false)]
    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $slug;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $isList = false;

    #[ORM\JoinColumn(name: 'menu_level1_id', referencedColumnName: 'id', nullable: false)]
    #[ORM\ManyToOne(targetEntity: MenuLevel1::class, inversedBy: 'menuLevel2items')]
    private MenuLevel1 $menuLevel1;

    #[ORM\OneToOne(targetEntity: Page::class)]
    private ?Page $page = null;

    #[ORM\OneToMany(targetEntity: Page::class, mappedBy: 'menuLevel2', cascade: ['persist', 'remove'])]
    #[ORM\OrderBy(['publishDate' => SortOrderTypeEnum::ASC])]
    private ?Collection $pages;

    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: MenuLevel2Translation::class, mappedBy: 'object', cascade: ['persist', 'remove'])]
    private ?Collection $translations;

    public function __construct()
    {
        $this->pages = new ArrayCollection();
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

    public function isList(): bool
    {
        return $this->isList;
    }

    public function isListString(): string
    {
        return AbstractBase::transformBooleanAsString($this->isList());
    }

    public function getIsList(): bool
    {
        return $this->isList();
    }

    public function setIsList(bool $isList): self
    {
        $this->isList = $isList;

        return $this;
    }

    public function getMenuLevel1(): MenuLevel1
    {
        return $this->menuLevel1;
    }

    public function setMenuLevel1(MenuLevel1 $menuLevel1): self
    {
        $this->menuLevel1 = $menuLevel1;

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

    public function getPages(): ?Collection
    {
        return $this->pages;
    }

    public function setPages(?Collection $pages): self
    {
        $this->pages = $pages;

        return $this;
    }

    public function addPage(Page $page): self
    {
        if (!$this->pages->contains($page)) {
            $this->pages->add($page);
        }

        return $this;
    }

    public function removePage(Page $page): self
    {
        if ($this->pages->contains($page)) {
            $this->pages->removeElement($page);
        }

        return $this;
    }

    public function getHierarchyName(): string
    {
        return $this->getMenuLevel1()->getName().AbstractBase::DEFAULT_HIERARCHY_SEPARATOR.$this->getName();
    }

    public function __toString(): string
    {
        return $this->getId() && $this->getName() ? $this->getName() : self::DEFAULT_EMPTY_STRING;
    }
}
