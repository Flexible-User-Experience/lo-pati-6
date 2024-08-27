<?php

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait LegacyIdTrait
{
    #[ORM\Column(type: Types::INTEGER, unique: true, nullable: true)]
    private ?int $legacyId = null;

    public function getLegacyId(): ?int
    {
        return $this->legacyId;
    }

    public function setLegacyId(?int $legacyId): self
    {
        $this->legacyId = $legacyId;

        return $this;
    }
}
