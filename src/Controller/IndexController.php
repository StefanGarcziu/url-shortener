<?php
/**
 * Index controller.
 */

namespace App\Controller;

use App\Entity\Click;
use App\Entity\Url;
use App\Form\Type\UrlType;
use App\Repository\ClickRepository;
use App\Repository\UrlRepository;
use App\Service\ClickServiceInterface;
use App\Service\TagServiceInterface;
use App\Service\UrlServiceInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class IndexController.
 */
#[Route('/')]
class IndexController extends AbstractController
{
    
    /**
     * Index action.
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'index',
        methods: 'GET'
    )]
    public function index(Request $request): Response
    {
        return $this->render(
            'index.html.twig',
        );
    }
}
