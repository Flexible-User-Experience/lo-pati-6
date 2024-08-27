<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

abstract class AbstractBase
{
    public const string DATABASE_IMPORT_DATE_FORMAT = 'Y-m-d';
    public const string DATABASE_IMPORT_DATETIME_FORMAT = 'Y-m-d H:i:s';
    public const string DATE_FORMAT = 'd/m/Y';
    public const string DATETIME_FORMAT = 'd/m/Y H:i';
    public const string FORM_TYPE_DATE_FORMAT = 'd/M/y';
    public const string FORM_TYPE_DATETIME_FORMAT = 'd/M/y H:mm';
    public const string DATA_GRID_TYPE_DATE_FORMAT = 'd-m-Y';
    public const string DATA_GRID_WIDGET_DATE_FORMAT = 'dd-MM-yyyy';
    public const string DEFAULT_ID_PREFIX = '#';
    public const string DEFAULT_HIERARCHY_SEPARATOR = ' → ';
    public const string DEFAULT_SEPARATOR = ' · ';
    public const string DEFAULT_EMPTY_STRING = '---';
    public const string DEFAULT_EMPTY_DATE = '--/--/----';
    public const string DEFAULT_EMPTY_DATETIME = '--/--/---- --:--';

    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    #[ORM\GeneratedValue]
    protected ?int $id = null;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    protected DateTimeInterface $createdAt;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    protected DateTimeInterface $updatedAt;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => true])]
    protected bool $active = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdString(): string
    {
        return self::DEFAULT_ID_PREFIX.$this->getId();
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getCreatedAtString(): string
    {
        return self::transformDateTimeAsString($this->getCreatedAt());
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getUpdatedAtString(): string
    {
        return self::transformDateTimeAsString($this->getUpdatedAt());
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getActive(): bool
    {
        return $this->isActive();
    }

    public function getActiveString(): string
    {
        return self::transformBooleanAsString($this->isActive());
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    protected static function transformFloatAsEuroString(?float $value): string
    {
        return $value ? number_format($value, 2, '\'', '.').' €' : self::DEFAULT_EMPTY_STRING.' €';
    }

    protected static function transformBooleanAsString(bool $value): string
    {
        return $value ? 'sí' : 'no';
    }

    protected static function transformDateAsString(?DateTimeInterface $date): string
    {
        return $date ? $date->format(self::DATE_FORMAT) : self::DEFAULT_EMPTY_DATE;
    }

    protected static function transformDateTimeAsString(?DateTimeInterface $datetime): string
    {
        return $datetime ? $datetime->format(self::DATETIME_FORMAT) : self::DEFAULT_EMPTY_DATETIME;
    }

    public function __toString(): string
    {
        return $this->id ? $this->getId().self::DEFAULT_SEPARATOR.$this->getCreatedAtString() : self::DEFAULT_EMPTY_STRING;
    }
}
