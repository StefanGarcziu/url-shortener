<?php
/**
 * Click service tests.
 */

namespace App\Tests\Service;


use App\Entity\AnonymousUser;
use App\Entity\Tag;
use App\Entity\Click;
use App\Entity\Url;
use App\Repository\ClickRepository;
use App\Service\AnonymousUserService;
use App\Service\AnonymousUserServiceInterface;
use App\Service\TagService;
use App\Service\TagServiceInterface;
use App\Service\ClickService;
use App\Service\ClickServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class ClickServiceTest.
 */
class ClickServiceTest extends KernelTestCase
{
    /**
     * Click repository.
     */
    private ?EntityManagerInterface $entityManager;

    /**
     * Click service.
     */
    private ?ClickServiceInterface $clickService;

    /**
     * Tag service.
     */
    private ?TagServiceInterface $tagService;

    /**
     * Set up test.
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function setUp(): void
    {
        $container = static::getContainer();
        $this->entityManager = $container->get('doctrine.orm.entity_manager');
        $this->clickService = $container->get(ClickService::class);
        $this->tagService = $container->get(TagService::class);
    }

    /**
     * Test register click.
     */
    public function testRegisterClick(): void
    {
        // given
        $user = new AnonymousUser();
        $user->setEmail('testclick@url.com');
        $this->entityManager->persist($user);
        $expectedUrl = new Url();
        $expectedUrl->setLongUrl('https://www.google.com');
        $expectedUrl->setAnonymousUser($user);
        $expectedUrl->setCreationDate(new \DateTimeImmutable('now'));
        $expectedUrl->setModDate(new \DateTimeImmutable('now'));
        $expectedUrl->setClicks(new ArrayCollection());
        $this->entityManager->persist($expectedUrl);
        $this->entityManager->flush();

        // when
        $click = $this->clickService->registerClick($expectedUrl, '123.123.123.123');

        // then
        $this->assertNotNull($click);
    }


    /**
     * Test pagination list.
     */
    public function testGetPaginatedList(): void
    {
        // given
        $user = new AnonymousUser();
        $user->setEmail('testclick@url.com');
        $this->entityManager->persist($user);
        $expectedUrl = new Url();
        $expectedUrl->setLongUrl('https://www.google.com');
        $expectedUrl->setAnonymousUser($user);
        $expectedUrl->setCreationDate(new \DateTimeImmutable('now'));
        $expectedUrl->setModDate(new \DateTimeImmutable('now'));
        $expectedUrl->setClicks(new ArrayCollection());
        $this->entityManager->persist($expectedUrl);
        $this->entityManager->flush();
        $page = 1;
        $expectedResultSize = ClickRepository::PAGINATOR_ITEMS_PER_PAGE;

        // when
        for ($i = 0; $i < 50; $i++) {
            $click = $this->clickService->registerClick($expectedUrl, '123.123.123.123');
        }

        // when
        $result = $this->clickService->getPaginatedList($page);

        // then
        $this->assertEquals($expectedResultSize, $result->count());
    }

    /**
     * Test pagination list by url.
     */
    public function testGetPaginatedListByUrl(): void
    {
        // given
        $user = new AnonymousUser();
        $user->setEmail('testclick@url.com');
        $this->entityManager->persist($user);
        $expectedUrl = new Url();
        $expectedUrl->setLongUrl('https://www.google.com');
        $expectedUrl->setAnonymousUser($user);
        $expectedUrl->setCreationDate(new \DateTimeImmutable('now'));
        $expectedUrl->setModDate(new \DateTimeImmutable('now'));
        $expectedUrl->setClicks(new ArrayCollection());
        $this->entityManager->persist($expectedUrl);
        $expectedUrl2 = new Url();
        $expectedUrl2->setLongUrl('https://www.google.com');
        $expectedUrl2->setAnonymousUser($user);
        $expectedUrl2->setCreationDate(new \DateTimeImmutable('now'));
        $expectedUrl2->setModDate(new \DateTimeImmutable('now'));
        $expectedUrl2->setClicks(new ArrayCollection());
        $this->entityManager->persist($expectedUrl2);
        $this->entityManager->flush();
        $page = 1;
        $expectedResultSize = ClickRepository::PAGINATOR_ITEMS_PER_PAGE / 2;
        $urls = [$expectedUrl, $expectedUrl2];

        // when
        for ($i = 0; $i < 10; $i++) {
            $click = $this->clickService->registerClick($urls[$i%2], '123.123.123.123');
        }

        // when
        $result = $this->clickService->getPaginatedListByUrl($page, $expectedUrl);

        // then
        $this->assertEquals($expectedResultSize, $result->count());
    }
}
