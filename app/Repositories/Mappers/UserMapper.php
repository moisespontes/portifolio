<?php

namespace App\Repositories\Mappers;

use App\Entities\User;
use App\Enums\UserRole;
use DateTimeImmutable;

class UserMapper
{
    public static function toEntity(object $row): User
    {
        return new User(
            id: (int) $row->id,
            firstName: $row->first_name,
            lastName: $row->last_name,
            email: $row->email,
            password: $row->password,
            image: $row->image,
            role: UserRole::from($row->role),
            lastLoginAt: $row->last_login_at
                ? new DateTimeImmutable($row->last_login_at)
                : null,
        );
    }

    public static function toEntities(array $rows): array
    {
        return array_map(fn ($row) => self::toEntity($row), $rows);
    }

    public static function toDatabase(User $user): array
    {
        return [
            'first_name'    => $user->firstName,
            'last_name'     => $user->lastName,
            'email'         => $user->email,
            'password'      => $user->password,
            'image'         => $user->image,
            'role'          => $user->role->value,
            'last_login_at' => $user->lastLoginAt?->format('Y-m-d H:i:s'),
        ];
    }
}
