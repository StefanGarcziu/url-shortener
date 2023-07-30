<?php
/**
 * Tag service interface.
 */

namespace App\Service;

use App\Entity\Tag;

/**
 * Interface TagServiceInterface.
 */
interface TagServiceInterface
{
    /**
     * Find by title.
     *
     * @param string $title Tag title
     *
     * @return Tag|null Tag entity
     */
    public function findOneByTitle(string $title): ?Tag;

    /**
     * Find by id.
     *
     * @param int $id Tag ID
     *
     * @return Tag|null Tag entity
     */
    public function findOneById(int $id): ?Tag;
}
