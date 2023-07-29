<?php
/**
 * Url entity.
 */

namespace App\Entity;

use App\Repository\UrlRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Url class.
 */
#[ORM\Entity(repositoryClass: UrlRepository::class)]
class Url
{
    /**
     * Id.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Short url.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $shortUrl = null;

    /**
     * Long url.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $longUrl = null;

    /**
     * Creation date.
     *
     * @var \DateTimeImmutable|null
     */
    #[ORM\Column]
    private ?\DateTimeImmutable $creationDate = null;

    /**
     * Modification date.
     *
     * @var \DateTimeImmutable|null
     */
    #[ORM\Column]
    private ?\DateTimeImmutable $modDate = null;

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
     * Getter for short URL.
     *
     * @return string|null
     */
    public function getShortUrl(): ?string
    {
        return $this->shortUrl;
    }

    /**
     * Setter for short URL.
     *
     * @param string $shortUrl Short URL
     */
    public function setShortUrl(string $shortUrl): void
    {
        $this->shortUrl = $shortUrl;
    }

    /**
     * Getter
     *
     * @return string|null
     */
    public function getLongUrl(): ?string
    {
        return $this->longUrl;
    }

    public function setLongUrl(string $longUrl): static
    {
        $this->longUrl = $longUrl;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeImmutable
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeImmutable $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getModDate(): ?\DateTimeImmutable
    {
        return $this->modDate;
    }

    public function setModDate(\DateTimeImmutable $modDate): static
    {
        $this->modDate = $modDate;

        return $this;
    }
}
