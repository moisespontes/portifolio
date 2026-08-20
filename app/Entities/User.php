<?php

namespace App\Entities;

use App\Enums\UserRole;
use DateTimeImmutable;
use InvalidArgumentException;

class User
{
    public string $fullName {
        get => trim($this->firstName . ' ' . ($this->lastName ?? ''));
    }

    public bool $isAdmin {
        get => $this->role === UserRole::ADMIN;
    }

    /**
     * @param string $password Hash da senha
     */
    public function __construct(
        public private(set) ?int $id,
        public private(set) string $firstName,
        public private(set) ?string $lastName,
        public private(set) string $email,
        public private(set) string $password,
        public private(set) ?string $image,
        public private(set) UserRole $role,
        public private(set) ?DateTimeImmutable $lastLoginAt,
    ) {
        $this->setEmail($this->email);
        $this->setPassword($this->password);
        $this->setFirstName($this->firstName);
        $this->setLastName($this->lastName);
    }

    // --- Métodos de Autenticação e Segurança ---

    public function verifyPassword(string $password): bool
    {
        // implementar
        return true;
    }

    /**
     * @param string $password Hash da senha
     */
    public function changePassword(string $password): void
    {
        $this->setPassword($password);
    }

    // --- Métodos de Domínio e Alteração de Estado ---

    public function changeEmail(string $email): void
    {
        $this->setEmail($email);
    }

    public function changeName(string $firstName, ?string $lastName): void
    {
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
    }

    public function updateImage(string $imagePath): void
    {
        $imagePath = trim($imagePath);

        if ($imagePath === '') {
            throw new InvalidArgumentException('O caminho da imagem não pode ser vazio');
        }

        $this->image = $imagePath;
    }

    public function changeRole(UserRole $newRole): void
    {
        $this->role = $newRole;
    }

    public function registerLogin(): void
    {
        $this->lastLoginAt = new DateTimeImmutable();
    }

    public function setId(int $id): void
    {
        if ($this->id !== null) {
            throw new InvalidArgumentException('O ID desta entidade já foi definido e não pode ser alterado');
        }

        $this->id = $id;
    }

    // --- Validações e Sanitização Internas ---

    private function setFirstName(string $firstName): void
    {
        $firstName = trim($firstName);

        if ($firstName === '') {
            throw new InvalidArgumentException('O primeiro nome não pode ser vazio');
        }

        $this->firstName = $firstName;
    }

    private function setLastName(?string $lastName): void
    {
        $lastName = trim($lastName ?? '');

        $this->lastName = $lastName === '' ? null : $lastName;
    }

    private function setEmail(string $email): void
    {
        $email = strtolower(trim($email));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(sprintf('E-mail inválido: "%s"', $email));
        }

        $this->email = $email;
    }

    private function setPassword(string $password): void
    {
        $password = trim($password);

        if ($password === '') {
            throw new InvalidArgumentException('A senha não pode ser vazia');
        }

        $this->password = $password;
    }
}
