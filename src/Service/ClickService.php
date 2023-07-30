<?php
/**
 * Url service.
 */

namespace App\Service;

use App\Entity\Click;
use App\Entity\Url;
use App\Repository\ClickRepository;
use App\Repository\UrlRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class UrlService.
 */
class ClickService implements ClickServiceInterface
{
    /**
     * Url repository.
     */
    private UrlRepository $urlRepository;

    /**
     * Click repository.
     */
    private ClickRepository $clickRepository;

    /**
     * Constructor.
     */
    public function __construct(UrlRepository $urlRepository, ClickRepository $clickRepository)
    {
        $this->urlRepository = $urlRepository;
        $this->clickRepository = $clickRepository;
    }

    /**
     * Register click.
     *
     * @param Url $url
     * @param string $ip
     *
     * @return Click
     */
    public function registerClick(Url $url, string $ip): Click
    {
        $click = new Click();
        $click->setIp($ip);
        $click->setUrl($url);
        $this->clickRepository->save($click);

        return new Click();
    }
}
