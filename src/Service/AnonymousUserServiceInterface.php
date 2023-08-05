<?php
/**
 * AnonymousUser service interface.
 */

namespace App\Service;

use App\Entity\AnonymousUser;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface AnonymousUserServiceInterface.
 */
interface AnonymousUserServiceInterface
{
    /**
     * Save entity.
     *
     * @param AnonymousUser $anonymousUser AnonymousUser entity
     */
    public function save(AnonymousUser $anonymousUser): void;

    /**
     * Find user by email.
     *
     * @param string $email
     *
     * @return AnonymousUser|null
     */
    public function findOneByEmail(string $email): ?AnonymousUser;
}
