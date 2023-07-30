<?php
/**
 * Url fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Url;
use DateTimeImmutable;

/**
 * Class UrlFixtures.
 */
class UrlFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     */
    public function loadData(): void
    {
        $this->createMany(100, 'urls', function (int $i) {
            $url = new Url();
            $url->setLongUrl($this->faker->url());
            $url->setCreationDate(
                DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $url->setModDate(
                DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            return $url;
        });

        $this->manager->flush();
    }
}
