<?php
/**
 * Url controller.
 */

namespace App\Controller;

use App\Entity\Click;
use App\Entity\Url;
use App\Repository\ClickRepository;
use App\Repository\UrlRepository;
use App\Service\ClickServiceInterface;
use App\Service\UrlServiceInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UrlController.
 */
#[Route('/url')]
class UrlController extends AbstractController
{
    /**
     * Url service.
     */
    private UrlServiceInterface $urlService;

    /**
     * Click service.
     */
    private ClickServiceInterface $clickService;

    /**
     * Constructor.
     */
    public function __construct(UrlServiceInterface $urlService, ClickServiceInterface $clickService)
    {
        $this->urlService = $urlService;
        $this->clickService = $clickService;
    }
    
    /**
     * Index action.
     *
     * @param UrlRepository $urlRepository Url repository
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'url_index',
        methods: 'GET'
    )]
    public function index(Request $request, UrlRepository $urlRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $this->urlService->getPaginatedList(
            $request->query->getInt('page', 1),
        );

        return $this->render(
            'url/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param Url $url Url entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'url_redirect',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET',
    )]
    public function show(Url $url): Response
    {
//        $click = new Click();
//        $click->setUrl($url);
//        $click->setIp('123.123.123.123');
//        $click->setDate(new \DateTimeImmutable('now'));
//        $this->clickService->registerClick($url);

        return $this->redirect($url->getLongUrl());
    }

    /**
     * Details action.
     *
     * @param Url $url Url entity
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}/details',
        name: 'url_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET',
    )]
    public function details(Url $url): Response
    {
        return $this->render(
            'url/show.html.twig',
            ['url' => $url]
        );
    }
}
