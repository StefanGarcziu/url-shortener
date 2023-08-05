<?php
/**
 * Anonymous user entity.
 */

namespace App\Entity;

use App\Repository\AnonymousUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AnonymousUser class.
 */
#[ORM\Entity(repositoryClass: AnonymousUserRepository::class)]
#[ORM\Table(name: 'anonymous_users')]
class AnonymousUser
{
    /**
     * Id.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * Email.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Assert\Email]
    #[Assert\NotBlank]
    private ?string $email = null;

    /**
     * Getter for id.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for email.
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Setter for email.
     *
     * @param string $email Email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
