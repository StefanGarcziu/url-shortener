<?php
/**
 * Url controller.
 */

namespace App\Controller;

use App\Entity\AnonymousUser;
use App\Entity\Click;
use App\Entity\Url;
use App\Form\Type\UrlType;
use App\Repository\ClickRepository;
use App\Repository\UrlRepository;
use App\Service\AnonymousUserServiceInterface;
use App\Service\ClickServiceInterface;
use App\Service\TagServiceInterface;
use App\Service\UrlServiceInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

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
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Tag service.
     */
    private TagServiceInterface $tagService;

    /**
     * Anonymous user service.
     */
    private AnonymousUserServiceInterface $anonymousUserService;

    /**
     * Constructor.
     *
     * @param UrlServiceInterface           $urlService           Url service
     * @param ClickServiceInterface         $clickService         Click service
     * @param TranslatorInterface           $translator           Translator
     * @param TagServiceInterface           $tagService           Tag service
     * @param AnonymousUserServiceInterface $anonymousUserService Anonymous user service
     */
    public function __construct(UrlServiceInterface $urlService, ClickServiceInterface $clickService, TranslatorInterface $translator, TagServiceInterface $tagService, AnonymousUserServiceInterface $anonymousUserService)
    {
        $this->urlService = $urlService;
        $this->clickService = $clickService;
        $this->translator = $translator;
        $this->tagService = $tagService;
        $this->anonymousUserService = $anonymousUserService;
    }
    
    /**
     * Index action.
     *
     * @return Response HTTP response
     */
    #[Route(
        name: 'url_index',
        methods: 'GET'
    )]
    public function index(Request $request): Response
    {
        $filters = $this->getFilters($request);
        $tagFilterTitle = $this->tagService->findOneById($filters['tag_id']);

        $pagination = $this->urlService->getPaginatedList(
            $request->query->getInt('page', 1),
            $filters
        );

        return $this->render(
            'url/index.html.twig',
            ['pagination' => $pagination, 'filter' =>  $tagFilterTitle ]
        );
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route(
        '/create',
        name: 'url_create',
        methods: 'GET|POST',
    )]
    public function create(Request $request): Response
    {
        $url = new Url();
        $form = $this->createForm(UrlType::class, $url);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $anonymousUserEmail = $form->get('anonymousUser')->getData();
            $user = $this->anonymousUserService->findOneByEmail($anonymousUserEmail);

            if (null === $user) {
                $user = new AnonymousUser();
                $user->setEmail($anonymousUserEmail);
                $this->anonymousUserService->save($user);
            }

            $url->setAnonymousUser($user);
            $this->urlService->save($url);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('url_index');
        }

        return $this->render(
            'url/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request  $request  HTTP request
     * @param Url $url Url entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'url_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Url $url): Response
    {
        $form = $this->createForm(
            UrlType::class,
            $url,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('url_edit', ['id' => $url->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $anonymousUserEmail = $form->get('anonymousUser')->getData();
            $user = $this->anonymousUserService->findOneByEmail($anonymousUserEmail);

            if (null === $user) {
                $user = new AnonymousUser();
                $user->setEmail($anonymousUserEmail);
                $this->anonymousUserService->save($user);
            }

            $url->setAnonymousUser($user);
            $this->urlService->save($url);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('url_index');
        }

        return $this->render(
            'url/edit.html.twig',
            [
                'form' => $form->createView(),
                'url' => $url,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request  $request  HTTP request
     * @param Url $url Url entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'url_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Url $url): Response
    {
        $form = $this->createForm(FormType::class, $url, [
            'method' => 'DELETE',
            'action' => $this->generateUrl('url_delete', ['id' => $url->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->urlService->delete($url);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('url_index');
        }

        return $this->render(
            'url/delete.html.twig',
            [
                'form' => $form->createView(),
                'url' => $url,
            ]
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
    public function show(Request $request, Url $url): Response
    {
        $this->clickService->registerClick($url, $request->getClientIp());

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
    public function details(Request $request, Url $url): Response
    {
        $pagination = $this->clickService->getPaginatedListByUrl(
            $request->query->getInt('page', 1),
            $url
        );

        return $this->render(
            'url/show.html.twig',
            ['url' => $url, 'pagination' => $pagination]
        );
    }

    /**
     * Get filters from request.
     *
     * @param Request $request HTTP request
     *
     * @return array<string, int> Array of filters
     */
    private function getFilters(Request $request): array
    {
        $filters = [];
        $filters['tag_id'] = $request->query->getInt('filters_tag_id');

        return $filters;
    }
}
