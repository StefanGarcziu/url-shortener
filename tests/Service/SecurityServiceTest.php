<?php
/**
 * User service tests.
 */

namespace App\Tests\Service;

use App\Entity\User;
use App\Service\UserService;
use App\Service\UserServiceInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class SecurityServiceTest.
 */
class SecurityServiceTest extends KernelTestCase
{
    /**
     * User repository.
     */
    private ?EntityManagerInterface $entityManager;

    /**
     * User service.
     */
    private ?UserServiceInterface $userService;

    /**
     * Password hasher.
     *
     * @var UserPasswordHasherInterface|null
     */
    private ?UserPasswordHasherInterface $hasher;

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
        $this->userService = $container->get(UserService::class);
        $this->hasher = $container->get(UserPasswordHasherInterface::class);
    }

    /**
     * Test save.
     *
     * @throws ORMException
     */
    public function testSave(): void
    {
        // given
        $expectedUser = new User();
        $expectedUser->setName('Admin');
        $expectedUser->setSurname('Admin');
        $expectedUser->setEmail('admin@example.com');
        $expectedUser->setPassword('admin1234');

        // when
        $this->userService->save($expectedUser);

        // then
        $expectedUserId = $expectedUser->getId();
        $resultUser = $this->entityManager->createQueryBuilder()
            ->select('user')
            ->from(User::class, 'user')
            ->where('user.id = :id')
            ->setParameter(':id', $expectedUserId, Types::INTEGER)
            ->getQuery()
            ->getSingleResult();

        $this->assertEquals($expectedUser, $resultUser);
    }

    /**
     * Test upgrade password.
     */
    public function testUpgradePassword(): void
    {
        // given
        $expectedUser = new User();
        $expectedUser->setName('Admin');
        $expectedUser->setSurname('Admin');
        $expectedUser->setEmail('admin@example.com');
        $expectedUser->setPassword('admin1234');
        $plainPassword = 'user1234';

        // when
        $this->userService->save($expectedUser);
        $this->userService->upgradePassword($expectedUser, $this->hasher->hashPassword($expectedUser, $plainPassword));

        // then
        $this->assertTrue($this->hasher->isPasswordValid($expectedUser, $plainPassword));
    }
}
