<?php
/**
 * AnonymousUser fixtures.
 */

namespace App\DataFixtures;

use App\Entity\AnonymousUser;

/**
 * Class AnonymousUserFixtures.
 */
class AnonymousUserFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     */
    public function loadData(): void
    {
        $this->createMany(10, 'anonymous_users', function (int $i) {
            $anonymousUser = new AnonymousUser();
            $anonymousUser->setEmail($this->faker->email);

            return $anonymousUser;
        });

        $this->manager->flush();
    }
}
