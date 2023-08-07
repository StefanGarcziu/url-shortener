<?php
/**
 * Url service tests.
 */

namespace App\Tests\Service;

use App\Entity\AnonymousUser;
use App\Entity\Tag;
use App\Entity\Url;
use App\Repository\UrlRepository;
use App\Service\TagService;
use App\Service\TagServiceInterface;
use App\Service\UrlService;
use App\Service\UrlServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class UrlServiceTest.
 */
class UrlServiceTest extends KernelTestCase
{
    /**
     * Url repository.
     */
    private ?EntityManagerInterface $entityManager;

    /**
     * Url service.
     */
    private ?UrlServiceInterface $urlService;

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
        $this->urlService = $container->get(UrlService::class);
        $this->tagService = $container->get(TagService::class);
    }

    /**
     * Test save.
     *
     * @throws ORMException
     */
    public function testSave(): void
    {
        // given
        $user = new AnonymousUser();
        $user->setEmail('testsave@url.com');
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $expectedUrl = new Url();
        $expectedUrl->setLongUrl('https://www.google.com');
        $expectedUrl->setAnonymousUser($user);
        $expectedUrl->setCreationDate(new \DateTimeImmutable('now'));
        $expectedUrl->setModDate(new \DateTimeImmutable('now'));
        $expectedUrl->setClicks(new ArrayCollection());

        // when
        $this->urlService->save($expectedUrl);

        // then
        $expectedUrlId = $expectedUrl->getId();

        /** @var Url $resultUrl */
        $resultUrl = $this->entityManager->createQueryBuilder()
            ->select('Url')
            ->from(Url::class, 'Url')
            ->where('Url.id = :id')
            ->setParameter(':id', $expectedUrlId, Types::INTEGER)
            ->getQuery()
            ->getSingleResult();

        $this->assertEquals($expectedUrl, $resultUrl);
        $this->assertEquals($expectedUrl->getLongUrl(), $resultUrl->getLongUrl());
        $this->assertEquals($expectedUrl->getClicks(), $resultUrl->getClicks());
        $this->assertEquals($expectedUrl->getCreationDate(), $resultUrl->getCreationDate());
        $this->assertEquals($expectedUrl->getModDate(), $resultUrl->getModDate());
        $this->assertEquals($expectedUrl->getAnonymousUser(), $resultUrl->getAnonymousUser());
    }

    /**
     * Test delete.
     *
     * @throws ORMException
     */
    public function testDelete(): void
    {
        // given
        $user = new AnonymousUser();
        $user->setEmail('testsave@url.com');
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $expectedUrl = new Url();
        $expectedUrl->setLongUrl('https://www.google.com');
        $expectedUrl->setAnonymousUser($user);
        $expectedUrl->setCreationDate(new \DateTimeImmutable('now'));
        $expectedUrl->setModDate(new \DateTimeImmutable('now'));
        $expectedUrl->setClicks(new ArrayCollection());

        // when
        $this->urlService->delete($expectedUrl);

        // then
        $expectedUrlId = $expectedUrl->getId();

        /** @var Url $resultUrl */
        $resultUrl = $this->entityManager->createQueryBuilder()
            ->select('url')
            ->from(Url::class, 'url')
            ->where('url.id = :id')
            ->setParameter(':id', $expectedUrlId, Types::INTEGER)
            ->getQuery()
            ->getOneOrNullResult();

        $this->assertNull($resultUrl);
    }

    /**
     * Test prepare filters.
     * @throws \ReflectionException
     */
    public function testPrepareFilters(): void
    {
        // given
        $expectedTag = new Tag();
        $expectedTag->setTitle('testTagTitle2');
        $this->tagService->save($expectedTag);
        $expectedTagId = $expectedTag->getId();
        $expectedFilters = ['tag' => $expectedTag];
        $givenFiltersArray = ['tag_id' => $expectedTagId];

        // when
        $fn = self::getMethod('prepareFilters');
        $resultFilters = $fn->invokeArgs($this->urlService, [$givenFiltersArray]);

        // then
        $this->assertEquals($expectedFilters, $resultFilters);
    }

    /**
     * @throws \ReflectionException
     */
    protected static function getMethod($name): \ReflectionMethod
    {
        $class = new ReflectionClass('App\Service\UrlService');
        return $class->getMethod($name);
    }


    /**
     * Test pagination list.
     */
    public function testGetPaginatedList(): void
    {
        // given
        $user = new AnonymousUser();
        $user->setEmail('testsave@url.com');
        $this->entityManager->persist($user);
        $this->entityManager->flush();


        $page = 1;
        $expectedResultSize = UrlRepository::PAGINATOR_ITEMS_PER_PAGE;

        for ($i = 0; $i < 50; $i++) {
            $url = new Url();
            $url->setLongUrl('https://www.google.com');
            $url->setAnonymousUser($user);
            $url->setCreationDate(new \DateTimeImmutable('now'));
            $url->setModDate(new \DateTimeImmutable('now'));
            $url->setClicks(new ArrayCollection());

            $this->urlService->save($url);
        }

        // when
        $result = $this->urlService->getPaginatedList($page);

        // then
        $this->assertEquals($expectedResultSize, $result->count());
    }
}
