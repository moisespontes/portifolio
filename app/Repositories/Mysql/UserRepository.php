<?php

namespace App\Repositories\Mysql;

use App\Entities\User;
use App\Repositories\Mappers\UserMapper;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected string $table = 'users';

    public function findByEmail(string $email): ?User
    {
        $builder = $this->builder()
            ->select()
            ->where('email = :email', ['email' => $email]);

        $row = $this->executor->one($builder);

        return $row ? UserMapper::toEntity($row) : null;
    }

    public function findById(int $id): ?User
    {
        $builder = $this->builder()
            ->select()
            ->where('id = :id', ['id' => $id]);

        $row = $this->executor->one($builder);

        return $row ? UserMapper::toEntity($row) : null;
    }

    public function findAll(): array
    {
        $builder = $this->builder();
        $users   = $this->executor->all($builder);

        return UserMapper::toEntities($users);
    }

    public function updateLastLogin(User $user): bool
    {
        $user->registerLogin();

        return $this->update(
            $user->id,
            ['last_login_at' => $user->lastLoginAt->format('Y-m-d H:i:s')]
        );
    }

    public function save(User $user): User
    {
        if ($user->id === null) {
            $id = $this->insert(UserMapper::toDatabase($user));

            $user->setId($id);

            return $user;
        }

        $this->update($user->id, UserMapper::toDatabase($user));

        return $user;
    }

    public function destroy(User $user): bool
    {
        return $this->delete('id = :id', ['id' => $user->id]);
    }
}
