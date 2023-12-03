<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use DateTimeImmutable;

interface TimestampEntity
{
    public function getCreatedAt(): DateTimeImmutable;

    public function setCreatedAt(DateTimeImmutable $createdAt): static;

    public function getUpdatedAt(): DateTime;

    public function setUpdatedAt(DateTime $updatedAt): static;
}
