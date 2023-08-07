<?php
/**
 * Tag service tests.
 */

namespace App\Tests\Service;


use App\Entity\AnonymousUser;
use App\Entity\Tag;
use App\Service\AnonymousUserService;
use App\Service\AnonymousUserServiceInterface;
use App\Service\TagService;
use App\Service\TagServiceInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class TagServiceTest.
 */
class TagServiceTest extends KernelTestCase
{
    /**
     * Tag repository.
     */
    private ?EntityManagerInterface $entityManager;

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
        $expectedTag = new Tag();
        $expectedTag->setTitle('testTagTitle');

        // when
        $this->tagService->save($expectedTag);

        // then
        $expectedTagId = $expectedTag->getId();

        /** @var Tag $resultTag */
        $resultTag = $this->entityManager->createQueryBuilder()
            ->select('tag')
            ->from(Tag::class, 'tag')
            ->where('tag.id = :id')
            ->setParameter(':id', $expectedTagId, Types::INTEGER)
            ->getQuery()
            ->getSingleResult();

        $this->assertEquals($expectedTag, $resultTag);
        $this->assertEquals($expectedTag->getTitle(), $resultTag->getTitle());
    }

    /**
     * Test delete.
     *
     * @throws ORMException
     */
    public function testDelete(): void
    {
        // given
        $expectedTag = new Tag();
        $expectedTag->setTitle('testTagTitle');

        // when
        $this->tagService->delete($expectedTag);

        // then
        $expectedTagId = $expectedTag->getId();

        /** @var Tag $resultTag */
        $resultTag = $this->entityManager->createQueryBuilder()
            ->select('tag')
            ->from(Tag::class, 'tag')
            ->where('tag.id = :id')
            ->setParameter(':id', $expectedTagId, Types::INTEGER)
            ->getQuery()
            ->getOneOrNullResult();

        $this->assertNull($resultTag);
    }

    /**
     * Test find one by id.
     */
    public function testFindOneById(): void
    {
        // given
        $expectedTag = new Tag();
        $expectedTag->setTitle('testTagTitle2');
        $this->tagService->save($expectedTag);
        $expectedTagId = $expectedTag->getId();

        // when
        $resultTagId = $this->tagService->findOneById($expectedTagId)->getId();

        // then
        $this->assertEquals($expectedTagId, $resultTagId);
    }

    /**
     * Test find one by title.
     */
    public function testFindOneByTitle(): void
    {
        // given
        $expectedTag = new Tag();
        $expectedTag->setTitle('testTagTitle2');
        $this->tagService->save($expectedTag);
        $expectedTagTitle = $expectedTag->getTitle();

        // when
        $resultTagTitle = $this->tagService->findOneByTitle($expectedTagTitle)->getTitle();

        // then
        $this->assertEquals($expectedTagTitle, $resultTagTitle);
    }
}
