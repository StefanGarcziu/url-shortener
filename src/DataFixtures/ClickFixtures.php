<?php
/**
 * Click fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Click;
use App\Entity\Url;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class ClickFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class ClickFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     */
    public function loadData(): void
    {
        $this->createMany(500, 'clicks', function (int $i) {
            $click = new Click();
            $click->setDate(
                DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );
            $click->setIp($this->faker->ipv4());
            /** @var Url $url */
            $url = $this->getRandomReference('urls');
            $click->setUrl($url);

            return $click;
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
        return [UrlFixtures::class];
    }
}
