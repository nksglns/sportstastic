<?php

namespace App\Interfaces;

interface BaseRepositoryInterface
{
    public function save(array $data): bool;
    public function saveImage(string $imageUrl, int $entityId): bool;
    public function validate(array $data): array;
}
