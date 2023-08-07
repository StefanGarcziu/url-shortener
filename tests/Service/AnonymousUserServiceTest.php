<?php
/**
 * AnonymousUserService tests.
 */

namespace App\Tests\Service;

use App\Entity\AnonymousUser;
use App\Service\AnonymousUserService;
use App\Service\AnonymousUserServiceInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class AnonymousUserServiceTest.
 */
class AnonymousUserServiceTest extends KernelTestCase
{
    /**
     * AnonymousUser repository.
     */
    private ?EntityManagerInterface $entityManager;

    /**
     * AnonymousUser service.
     */
    private ?AnonymousUserServiceInterface $userService;

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
        $this->userService = $container->get(AnonymousUserService::class);
    }

    /**
     * Test save.
     *
     * @throws ORMException
     */
    public function testSave(): void
    {
        // given
        $expectedUser = new AnonymousUser();
        $expectedUser->setEmail('email@test.com');

        // when
        $this->userService->save($expectedUser);

        // then
        $expectedUserId= $expectedUser->getId();

        /** @var AnonymousUser $resultUser */
        $resultUser = $this->entityManager->createQueryBuilder()
            ->select('anonymous_user')
            ->from(AnonymousUser::class, 'anonymous_user')
            ->where('anonymous_user.id = :id')
            ->setParameter(':id', $expectedUserId, Types::INTEGER)
            ->getQuery()
            ->getSingleResult();

        $this->assertEquals($expectedUser, $resultUser);
        $this->assertEquals($expectedUser->getEmail(), $resultUser->getEmail());
    }
}
