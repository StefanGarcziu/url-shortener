<?php
/**
 * AnonymousUser service interface.
 */

namespace App\Service;

use App\Entity\AnonymousUser;

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
     * @param string $email Email
     *
     * @return AnonymousUser|null User
     */
    public function findOneByEmail(string $email): ?AnonymousUser;
}
