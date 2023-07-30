<?php
/**
 * Url entity.
 */

namespace App\Entity;

use App\Repository\UrlRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

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
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * Long url.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Assert\Url]
    #[Assert\NotBlank]
    private ?string $longUrl = null;

    #[ORM\OneToMany(mappedBy: 'url', targetEntity: Click::class, fetch: 'EXTRA_LAZY')]
    private Collection $clicks;

    /**
     * Creation date.
     *
     * @var \DateTimeImmutable|null
     */
    #[ORM\Column(type: 'datetime_immutable')]
    #[Gedmo\Timestampable(on: 'create')]
    #[Assert\Type(\DateTimeImmutable::class)]
    private ?\DateTimeImmutable $creationDate = null;

    /**
     * Modification date.
     *
     * @var \DateTimeImmutable|null
     */
    #[ORM\Column(type: 'datetime_immutable')]
    #[Gedmo\Timestampable(on: 'update')]
    #[Assert\Type(\DateTimeImmutable::class)]
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
     * Getter for long URL.
     *
     * @return string|null
     */
    public function getLongUrl(): ?string
    {
        return $this->longUrl;
    }

    /**
     * Setter for long URL.
     *
     * @param string $longUrl Long URL
     */
    public function setLongUrl(string $longUrl): void
    {
        $this->longUrl = $longUrl;
    }

    /**
     * Getter for creation date.
     *
     * @return \DateTimeImmutable|null
     */
    public function getCreationDate(): ?\DateTimeImmutable
    {
        return $this->creationDate;
    }

    /**
     * Setter for creation date.
     *
     * @param \DateTimeImmutable $creationDate
     */
    public function setCreationDate(\DateTimeImmutable $creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    /**
     * Getter for modification date.
     *
     * @return \DateTimeImmutable|null
     */
    public function getModDate(): ?\DateTimeImmutable
    {
        return $this->modDate;
    }

    /**
     * Setter for modification date.
     *
     * @param \DateTimeImmutable $modDate
     */
    public function setModDate(\DateTimeImmutable $modDate): void
    {
        $this->modDate = $modDate;
    }

    /**
     * @return Collection
     */
    public function getClicks(): Collection
    {
        return $this->clicks;
    }

    /**
     * @param Collection $clicks
     */
    public function setClicks(Collection $clicks): void
    {
        $this->clicks = $clicks;
    }


}
