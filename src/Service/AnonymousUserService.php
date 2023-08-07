<?php
/**
 * AnonymousUser service.
 */

namespace App\Service;

use App\Entity\AnonymousUser;
use App\Repository\AnonymousUserRepository;

/**
 * Class AnonymousUserService.
 */
class AnonymousUserService implements AnonymousUserServiceInterface
{
    /**
     * AnonymousUser repository.
     */
    private AnonymousUserRepository $anonymousUserRepository;

    /**
     * Constructor.
     *
     * @param AnonymousUserRepository $anonymousUserRepository AnonymousUser repository
     */
    public function __construct(AnonymousUserRepository $anonymousUserRepository)
    {
        $this->anonymousUserRepository = $anonymousUserRepository;
    }

    /**
     * Save entity.
     *
     * @param AnonymousUser $anonymousUser AnonymousUser entity
     */
    public function save(AnonymousUser $anonymousUser): void
    {
        $this->anonymousUserRepository->save($anonymousUser);
    }

    /**
     * Find user by email.
     *
     * @param string $email Email
     *
     * @return AnonymousUser|null User
     */
    public function findOneByEmail(string $email): ?AnonymousUser
    {
        return $this->anonymousUserRepository->findOneByEmail($email);
    }
}
