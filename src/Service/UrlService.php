<?php
/**
 * Url service.
 */

namespace App\Service;

use App\Entity\Url;
use App\Repository\UrlRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class UrlService.
 */
class UrlService implements UrlServiceInterface
{
    /**
     * Url repository.
     */
    private UrlRepository $urlRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param UrlRepository      $urlRepository  Url repository
     * @param PaginatorInterface $paginator      Paginator
     */
    public function __construct(UrlRepository $urlRepository, PaginatorInterface $paginator)
    {
        $this->urlRepository = $urlRepository;
        $this->paginator = $paginator;
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->urlRepository->queryAll(),
            $page,
            UrlRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Url $url Url entity
     */
    public function save(Url $url): void
    {
        $this->urlRepository->save($url);
    }

    /**
     * Delete entity.
     *
     * @param Url $url Url
     */
    public function delete(Url $url): void
    {
        $this->urlRepository->delete($url);
    }
}
