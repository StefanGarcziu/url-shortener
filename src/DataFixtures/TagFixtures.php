<?php
/**
 * Tag fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Tag;

/**
 * Class TagFixtures.
 */
class TagFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     */
    public function loadData(): void
    {
        $this->createMany(10, 'tags', function (int $i) {
            $tag = new Tag();
            $tag->setTitle($this->faker->unique()->word);

            return $tag;
        });

        $this->manager->flush();
    }
}
