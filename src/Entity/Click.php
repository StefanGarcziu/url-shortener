<?php
/**
 * Click entity.
 */

namespace App\Entity;

use App\Repository\ClickRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Click class.
 */
#[ORM\Entity(repositoryClass: ClickRepository::class)]
class Click
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
     * Click date.
     *
     * @var \DateTimeImmutable|null
     */
    #[ORM\Column(type: 'datetime_immutable')]
    #[Gedmo\Timestampable(on: 'create')]
    #[Assert\Type(\DateTimeImmutable::class)]
    private ?\DateTimeImmutable $date = null;

    /**
     * Ip.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Assert\Ip]
    private ?string $ip = null;

    #[ORM\ManyToOne(targetEntity: Url::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Url $url = null;

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
     * Getter for click date.
     *
     * @return \DateTimeImmutable|null
     */
    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * Setter for click date.
     *
     * @param \DateTimeImmutable $date Date
     */
    public function setDate(\DateTimeImmutable $date): void
    {
        $this->date = $date;
    }

    /**
     * Getter for IP.
     *
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * Setter for IP.
     *
     * @param string $ip IP
     */
    public function setIp(string $ip): void
    {
        $this->ip = $ip;
    }

    public function getUrl(): ?Url
    {
        return $this->url;
    }

    public function setUrl(?Url $url): static
    {
        $this->url = $url;

        return $this;
    }
}
