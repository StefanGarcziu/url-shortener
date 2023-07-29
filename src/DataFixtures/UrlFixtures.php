<?php
/**
 * Url fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Url;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;

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
        for ($i = 0; $i < 100; ++$i) {
            $url = new Url();
            $url->setLongUrl($this->faker->url());
            $url->setCreationDate(
                DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $url->setModDate(
                DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $this->manager->persist($url);
        }

        $this->manager->flush();
    }
}
