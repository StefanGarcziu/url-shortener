<?php
/**
 * Click service interface.
 */

namespace App\Service;

use App\Entity\Click;
use App\Entity\Url;

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
}
