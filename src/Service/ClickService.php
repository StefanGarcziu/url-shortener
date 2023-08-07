<?php
/**
 * Url service.
 */

namespace App\Service;

use App\Entity\Click;
use App\Entity\Url;
use App\Repository\ClickRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class UrlService.
 */
class ClickService implements ClickServiceInterface
{
    /**
     * Click repository.
     */
    private ClickRepository $clickRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param ClickRepository    $clickRepository Click repository
     * @param PaginatorInterface $paginator       Paginator
     */
    public function __construct(ClickRepository $clickRepository, PaginatorInterface $paginator)
    {
        $this->clickRepository = $clickRepository;
        $this->paginator = $paginator;
    }

    /**
     * Register click.
     *
     * @param Url    $url URL
     * @param string $ip  IP
     *
     * @return Click Click
     */
    public function registerClick(Url $url, string $ip): Click
    {
        $click = new Click();
        $click->setIp($ip);
        $click->setUrl($url);
        $this->clickRepository->save($click);

        return new Click();
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
            $this->clickRepository->queryAll(),
            $page,
            ClickRepository::PAGINATOR_ITEMS_PER_PAGE,
            ['wrap-queries' => true],
        );
    }

    /**
     * Get paginated list by url.
     *
     * @param int $page Page number
     * @param Url $url  Url
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedListByUrl(int $page, Url $url): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->clickRepository->queryByUrl($url),
            $page,
            ClickRepository::PAGINATOR_ITEMS_PER_PAGE,
            ['wrap-queries' => true],
        );
    }
}
