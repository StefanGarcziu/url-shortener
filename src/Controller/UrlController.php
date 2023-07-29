<?php
/**
 * Url controller.
 */

namespace App\Controller;

use App\Entity\Url;
use App\Repository\UrlRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UrlController.
 */
#[Route('/url')]
class UrlController extends AbstractController
{
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
    public function index(UrlRepository $urlRepository): Response
    {
        $urls = $urlRepository->findAll();

        return $this->render(
            'url/index.html.twig',
            ['urls' => $urls]
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
