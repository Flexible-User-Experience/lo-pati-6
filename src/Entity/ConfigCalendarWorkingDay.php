<?php

namespace App\Entity;

use App\Entity\Traits\LegacyIdTrait;
use App\Entity\Traits\NameTrait;
use App\Repository\ConfigCalendarWorkingDayRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ConfigCalendarWorkingDayRepository::class)]
#[ORM\Table]
#[ORM\UniqueConstraint(name: 'unique_config_calendar_working_day_index', columns: ['working_day_number'])]
#[UniqueEntity('workingDayNumber')]
class ConfigCalendarWorkingDay extends AbstractBase
{
    use LegacyIdTrait;
    use NameTrait;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $workingDayNumber;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: false)]
    private string $name;

    public function getWorkingDayNumber(): int
    {
        return $this->workingDayNumber;
    }

    public function setWorkingDayNumber(int $workingDayNumber): self
    {
        $this->workingDayNumber = $workingDayNumber;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getId() ? $this->getName() : self::DEFAULT_EMPTY_STRING;
    }
}
