<?php
/**
 * Anonymous user repository.
 */

namespace App\Repository;

use App\Entity\AnonymousUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * AnonymousUserRepository class.
 *
 * @extends ServiceEntityRepository<AnonymousUser>
 *
 * @method AnonymousUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnonymousUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnonymousUser[]    findAll()
 * @method AnonymousUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnonymousUserRepository extends ServiceEntityRepository
{
    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnonymousUser::class);
    }

    /**
     * Save entity.
     *
     * @param AnonymousUser $anonymousUser AnonymousUser entity
     */
    public function save(AnonymousUser $anonymousUser): void
    {
        $this->_em->persist($anonymousUser);
        $this->_em->flush();
    }
}
