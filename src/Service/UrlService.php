<?php
/**
 * Url service.
 */

namespace App\Service;

use App\Entity\Url;
use App\Repository\UrlRepository;
use Doctrine\ORM\NonUniqueResultException;
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
     * Tag service.
     */
    private TagService $tagService;

    /**
     * Constructor.
     *
     * @param UrlRepository      $urlRepository  Url repository
     * @param PaginatorInterface $paginator      Paginator
     * @param TagService         $tagService     Tag service
     */
    public function __construct(UrlRepository $urlRepository, PaginatorInterface $paginator, TagService $tagService)
    {
        $this->urlRepository = $urlRepository;
        $this->paginator = $paginator;
        $this->tagService = $tagService;
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     *
     * @throws NonUniqueResultException
     */
    public function getPaginatedList(int $page, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->urlRepository->queryAll($filters),
            $page,
            UrlRepository::PAGINATOR_ITEMS_PER_PAGE,
            ['wrap-queries' => true],
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

    /**
     * Prepare filters for the tasks list.
     *
     * @param array<string, int> $filters Raw filters from request
     *
     * @return array<string, object> Result array of filters
     *
     * @throws NonUniqueResultException
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];

        if (!empty($filters['tag_id'])) {
            $tag = $this->tagService->findOneById($filters['tag_id']);
            if (null !== $tag) {
                $resultFilters['tag'] = $tag;
            }
        }

        return $resultFilters;
    }
}
