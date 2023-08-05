<?php
/**
 * Click service interface.
 */

namespace App\Service;

use App\Entity\Click;
use App\Entity\Url;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface ClickServiceInterface.
 */
interface ClickServiceInterface
{
    /**
     * Register click.
     *
     * @param Url $url Url
     * @param string $ip IP
     *
     * @return Click
     */
    public function registerClick(Url $url, string $ip): Click;

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;

    /**
     * Get paginated list by url.
     *
     * @param int $page Page number
     * @param Url $url  Url
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedListByUrl(int $page, Url $url): PaginationInterface;
}
