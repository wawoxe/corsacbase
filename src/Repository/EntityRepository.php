<?php

declare(strict_types=1);

namespace App\Repository;

interface EntityRepository
{
    /**
     * @param object $entity Entity, which should be saved
     * @param bool $flush Flush execution after removing
     */
    public function save(object $entity, bool $flush = false): void;

    /**
     * @param object $entity Entity, which should be removed
     * @param bool $flush Flush execution after removing
     */
    public function remove(object $entity, bool $flush = false): void;
}
