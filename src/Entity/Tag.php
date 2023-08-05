<?php
/**
 * Tag entity.
 */

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tag class.
 */
#[ORM\Entity(repositoryClass: TagRepository::class)]
#[ORM\Table(name: 'tags')]
class Tag
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
     * Title.
     *
     * @var string|null
     */
    #[ORM\Column(length: 45)]
    private ?string $title = null;

    /**
     * Getter for ID.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for title.
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for title.
     *
     * @param string $title Title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}
