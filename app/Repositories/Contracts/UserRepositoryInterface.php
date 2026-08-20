<?php

namespace App\Repositories\Contracts;

use App\Entities\User;

interface UserRepositoryInterface
{
    public function findAll(): ?array;

    public function findById(int $id): ?User;

    public function findByEmail(string $email): ?User;

    public function updateLastLogin(User $user): bool;

    public function save(User $user): User;

    public function destroy(User $id): bool;
}
