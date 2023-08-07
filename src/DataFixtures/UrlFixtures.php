<?php
/**
 * Url fixtures.
 */

namespace App\DataFixtures;

use App\Entity\AnonymousUser;
use App\Entity\Tag;
use App\Entity\Url;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class UrlFixtures.
 */
class UrlFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
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
                \DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );
            $url->setModDate(
                \DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days'))
            );

            /** @var array<array-key, Tag> $tags */
            $tags = $this->getRandomReferences(
                'tags',
                $this->faker->numberBetween(0, 5)
            );
            foreach ($tags as $tag) {
                $url->addTag($tag);
            }

            /** @var AnonymousUser $anonymousUser */
            $anonymousUser = $this->getRandomReference('anonymous_users');
            $url->setAnonymousUser($anonymousUser);

            return $url;
        });

        $this->manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return string[] of dependencies
     */
    public function getDependencies(): array
    {
        return [TagFixtures::class, AnonymousUserFixtures::class];
    }
}
