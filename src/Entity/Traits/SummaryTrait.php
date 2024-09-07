<?php

namespace App\Entity\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait SummaryTrait
{
    #[Gedmo\Translatable]
    #[ORM\Column(type: Types::STRING, length: 300, nullable: true)]
    private ?string $summary = null;

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }
}
