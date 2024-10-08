<?php

namespace App\Entity;

use App\Entity\Traits\Document1Trait;
use App\Entity\Traits\Document2Trait;
use App\Entity\Traits\LegacyIdTrait;
use App\Entity\Traits\SlugTrait;
use App\Entity\Traits\SmallImage1Trait;
use App\Entity\Traits\SmallImage2Trait;
use App\Entity\Traits\TranslationsTrait;
use App\Entity\Translation\PageTranslation;
use App\Enum\PageTemplateTypeEnum;
use App\Enum\SortOrderTypeEnum;
use App\Repository\PageRepository;
use App\Validator\UrlVimeoConstraint;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: PageRepository::class)]
#[ORM\Table]
#[ORM\UniqueConstraint(name: 'unique_page_published_date_name_index', columns: ['name', 'publish_date'])]
#[UniqueEntity(fields: ['name', 'publishDate'], errorPath: 'name')]
#[Gedmo\TranslationEntity(class: PageTranslation::class)]
#[Vich\Uploadable]
class Page extends AbstractBase
{
    use Document1Trait;
    use Document2Trait;
    use LegacyIdTrait;
    use SlugTrait;
    use SmallImage1Trait;
    use SmallImage2Trait;
    use TranslationsTrait;

    public const int DEFAULT_PAGE_TEMPLATE = PageTemplateTypeEnum::DEFAULT;

    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $name = null;

    #[Gedmo\Slug(fields: ['name'])]
    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $slug;

    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::STRING, length: 300, nullable: true)]
    private ?string $summary = null;

    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::TEXT, length: 4000)]
    private ?string $description = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $isFrontCover = false;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private \DateTimeInterface $publishDate;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $showPublishDate = false;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $keepAsPageEvenIfItsArchive = false;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $alwaysShowOnCalendar = false;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $expirationDate;

    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $realizationDateString = null;

    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $place = null;

    #[ORM\Column(type: Types::TEXT, length: 4000, nullable: true)]
    private ?string $links = null;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $showSocialNetworksSharingButtons = false;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $video = null;

    #[Assert\Url]
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    #[UrlVimeoConstraint]
    private ?string $urlVimeo = null;

    #[Assert\Url]
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $urlFlickr = null;

    #[Assert\File(maxSize: '10M', mimeTypes: ['image/jpeg', 'image/pjpeg', 'image/png'])]
    #[Vich\UploadableField(mapping: 'image', fileNameProperty: 'smallImage1FileName')]
    private ?File $smallImage1File = null;

    #[Assert\File(maxSize: '10M', mimeTypes: ['image/jpeg', 'image/pjpeg', 'image/png'])]
    #[Vich\UploadableField(mapping: 'image', fileNameProperty: 'smallImage2FileName')]
    private ?File $smallImage2File = null;

    #[Assert\File(maxSize: '10M', mimeTypes: ['image/jpeg', 'image/pjpeg', 'image/png'])]
    #[Vich\UploadableField(mapping: 'image', fileNameProperty: 'imageFileName')]
    private ?File $imageFile = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $imageFileName = null;

    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $imageCaption = null;

    #[Assert\File(maxSize: '20M', mimeTypes: ['application/pdf'])]
    #[Vich\UploadableField(mapping: 'document', fileNameProperty: 'document1FileName')]
    private ?File $document1File = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $titleDocument1 = null;

    #[Assert\File(maxSize: '20M', mimeTypes: ['application/pdf'])]
    #[Vich\UploadableField(mapping: 'document', fileNameProperty: 'document2FileName')]
    private ?File $document2File = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $titleDocument2 = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startDate;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['default' => self::DEFAULT_PAGE_TEMPLATE])]
    private int $templateType = self::DEFAULT_PAGE_TEMPLATE;

    #[ORM\ManyToOne(targetEntity: MenuLevel1::class)]
    private ?MenuLevel1 $menuLevel1 = null;

    #[ORM\JoinColumn(referencedColumnName: 'id', nullable: true)]
    #[ORM\ManyToOne(targetEntity: MenuLevel2::class, inversedBy: 'pages')]
    private ?MenuLevel2 $menuLevel2 = null;

    #[ORM\JoinTable(name: 'page_previous_editions')]
    #[ORM\JoinColumn(name: 'page_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'page_previous_edition_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Page::class)]
    #[ORM\OrderBy(['publishDate' => SortOrderTypeEnum::DESC])]
    private ?Collection $previousEditions;

    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: PageImage::class, mappedBy: 'page', cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[ORM\OrderBy(['position' => SortOrderTypeEnum::ASC])]
    private ?Collection $images;

    #[Assert\Valid]
    #[ORM\OneToMany(targetEntity: PageTranslation::class, mappedBy: 'object', cascade: ['persist', 'remove'])]
    private ?Collection $translations;

    public function __construct()
    {
        $this->previousEditions = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    public function __clone()
    {
        $this
            ->setImageFileName(null)
            ->setSmallImage1FileName(null)
            ->setSmallImage2FileName(null)
            ->setDocument1FileName(null)
            ->setDocument2FileName(null)
        ;
    }

    #[Groups(['searchable'])]
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    #[Groups(['searchable'])]
    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    #[Groups(['searchable'])]
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isFrontCover(): bool
    {
        return $this->isFrontCover;
    }

    public function isFrontCoverString(): string
    {
        return self::transformBooleanAsString($this->isFrontCover());
    }

    public function setIsFrontCover(bool $isFrontCover): self
    {
        $this->isFrontCover = $isFrontCover;

        return $this;
    }

    public function getPublishDate(): \DateTimeInterface
    {
        return $this->publishDate;
    }

    public function getPublishDateString(): string
    {
        return AbstractBase::transformDateAsString($this->getPublishDate());
    }

    public function setPublishDate(\DateTimeInterface $publishDate): self
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    public function isShowPublishDate(): bool
    {
        return $this->showPublishDate;
    }

    public function showPublishDateString(): string
    {
        return self::transformBooleanAsString($this->isShowPublishDate());
    }

    public function setShowPublishDate(bool $showPublishDate): self
    {
        $this->showPublishDate = $showPublishDate;

        return $this;
    }

    public function isKeepAsPageEvenIfItsArchive(): bool
    {
        return $this->keepAsPageEvenIfItsArchive;
    }

    public function keepAsPageEvenIfItsArchiveString(): string
    {
        return self::transformBooleanAsString($this->isKeepAsPageEvenIfItsArchive());
    }

    public function setKeepAsPageEvenIfItsArchive(bool $keepAsPageEvenIfItsArchive): self
    {
        $this->keepAsPageEvenIfItsArchive = $keepAsPageEvenIfItsArchive;

        return $this;
    }

    public function isAlwaysShowOnCalendar(): bool
    {
        return $this->alwaysShowOnCalendar;
    }

    public function alwaysShowOnCalendarString(): string
    {
        return self::transformBooleanAsString($this->isAlwaysShowOnCalendar());
    }

    public function setAlwaysShowOnCalendar(bool $alwaysShowOnCalendar): self
    {
        $this->alwaysShowOnCalendar = $alwaysShowOnCalendar;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expirationDate;
    }

    public function getExpirationDateString(): string
    {
        return AbstractBase::transformDateAsString($this->getExpirationDate());
    }

    public function setExpirationDate(?\DateTimeInterface $expirationDate): self
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    #[Groups(['searchable'])]
    public function getRealizationDateString(): ?string
    {
        return $this->realizationDateString;
    }

    public function setRealizationDateString(?string $realizationDateString): self
    {
        $this->realizationDateString = $realizationDateString;

        return $this;
    }

    #[Groups(['searchable'])]
    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(?string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getLinks(): ?string
    {
        return $this->links;
    }

    public function setLinks(?string $links): self
    {
        $this->links = $links;

        return $this;
    }

    public function isShowSocialNetworksSharingButtons(): bool
    {
        return $this->showSocialNetworksSharingButtons;
    }

    public function showSocialNetworksSharingButtonsString(): string
    {
        return self::transformBooleanAsString($this->isShowSocialNetworksSharingButtons());
    }

    public function setShowSocialNetworksSharingButtons(bool $showSocialNetworksSharingButtons): self
    {
        $this->showSocialNetworksSharingButtons = $showSocialNetworksSharingButtons;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getUrlVimeo(): ?string
    {
        return $this->urlVimeo;
    }

    public function getUrlVimeoCode(): string
    {
        $result = '';
        if ($this->getUrlVimeo() && strlen($this->getUrlVimeo()) > 18) {
            $result = substr($this->getUrlVimeo(), 18);
        }

        return $result;
    }

    public function getUrlVimeoIframeString(): string
    {
        return '<iframe src="https://player.vimeo.com/video/'.$this->getUrlVimeoCode().'" width="100%" height="450" style="border:0;margin-bottom:-30px" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';
    }

    public function setUrlVimeo(?string $urlVimeo): self
    {
        $this->urlVimeo = $urlVimeo;

        return $this;
    }

    public function getUrlFlickr(): ?string
    {
        return $this->urlFlickr;
    }

    public function setUrlFlickr(?string $urlFlickr): self
    {
        $this->urlFlickr = $urlFlickr;

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
            $this->updatedAt = new \DateTimeImmutable();
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

    public function getImageCaption(): ?string
    {
        return $this->imageCaption;
    }

    public function setImageCaption(?string $imageCaption): self
    {
        $this->imageCaption = $imageCaption;

        return $this;
    }

    public function getTitleDocument1(): ?string
    {
        return $this->titleDocument1;
    }

    public function setTitleDocument1(?string $titleDocument1): self
    {
        $this->titleDocument1 = $titleDocument1;

        return $this;
    }

    public function getTitleDocument2(): ?string
    {
        return $this->titleDocument2;
    }

    public function setTitleDocument2(?string $titleDocument2): self
    {
        $this->titleDocument2 = $titleDocument2;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function getStartDateString(): string
    {
        return AbstractBase::transformDateAsString($this->getStartDate());
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function getEndDateString(): string
    {
        return AbstractBase::transformDateAsString($this->getEndDate());
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getTemplateType(): int
    {
        return $this->templateType;
    }

    public function getTemplateTypeTransString(): string
    {
        $result = self::DEFAULT_EMPTY_STRING;
        if (array_key_exists($this->getTemplateType(), PageTemplateTypeEnum::getEnumArray())) {
            $result = PageTemplateTypeEnum::getEnumArray()[$this->getTemplateType()];
        }

        return $result;
    }

    public function getTemplateTypeString(): string
    {
        return array_key_exists($this->getTemplateType(), PageTemplateTypeEnum::getTemplateTypeArray()) ? PageTemplateTypeEnum::getTemplateTypeArray()[$this->getTemplateType()] : PageTemplateTypeEnum::getTemplateTypeArray()[0];
    }

    public function setTemplateType(int $templateType): self
    {
        $this->templateType = $templateType;

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

    public function getPreviousEditions(): ArrayCollection|Collection|null
    {
        return $this->previousEditions;
    }

    public function setPreviousEditions(ArrayCollection|Collection|null $previousEditions): self
    {
        $this->previousEditions = $previousEditions;

        return $this;
    }

    public function addPreviousEdition(Page $previousEdition): self
    {
        if (!$this->previousEditions->contains($previousEdition)) {
            $this->previousEditions->add($previousEdition);
        }

        return $this;
    }

    public function removePreviousEdition(Page $previousEdition): self
    {
        if ($this->previousEditions->contains($previousEdition)) {
            $this->previousEditions->removeElement($previousEdition);
        }

        return $this;
    }

    public function humanReadableIdentifier(): string
    {
        return $this->getId() ? '#'.$this->getId().AbstractBase::DEFAULT_SEPARATOR.$this->getPublishDateString().AbstractBase::DEFAULT_SEPARATOR.$this->getName() : self::DEFAULT_EMPTY_STRING;
    }

    public function getImages(): ?Collection
    {
        return $this->images;
    }

    public function setImages(?Collection $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function addImage(PageImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setPage($this);
        }

        return $this;
    }

    public function removeImage(PageImage $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId() && $this->getName() ? $this->getName() : self::DEFAULT_EMPTY_STRING;
    }
}
