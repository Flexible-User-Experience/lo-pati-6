<?php

namespace App\Entity;

use App\Enum\UserRolesEnum;
use App\Repository\UserRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table]
#[ORM\UniqueConstraint(name: 'unique_user_email_index', columns: ['email'])]
#[UniqueEntity(fields: ['email'], errorPath: 'email')]
class User extends AbstractBase implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Column(type: Types::STRING, length: 255, unique: true, nullable: false)]
    private string $email;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: false)]
    private string $password;

    #[ORM\Column(type: Types::JSON, nullable: false)]
    private array $roles = [];

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $lastLogin = null;

    #[ORM\Column(type: Types::INTEGER, nullable: false, options: ['unsigned' => true, 'default' => 0])]
    private int $loginCount = 0;

    private ?string $plainPassword = null;

    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->setUpdatedAt(new DateTimeImmutable());
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = UserRolesEnum::ROLE_USER;

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole(string $role): self
    {
        $roles = $this->roles;
        $roles[] = $role;
        $this->roles = array_unique($roles);

        return $this;
    }

    public function getLastLogin(): ?DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getLoginCount(): int
    {
        return $this->loginCount;
    }

    public function addLoginCount(): self
    {
        ++$this->loginCount;

        return $this;
    }

    public function setLoginCount(int $loginCount): self
    {
        $this->loginCount = $loginCount;

        return $this;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): self
    {
        $this->plainPassword = null;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->getEmail();
    }

    public function __toString(): string
    {
        return $this->id ? self::DEFAULT_ID_PREFIX.$this->getId().self::DEFAULT_SEPARATOR.$this->getEmail() : self::DEFAULT_EMPTY_STRING;
    }
}
