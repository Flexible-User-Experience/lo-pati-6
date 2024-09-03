<?php

namespace App\Controller\Frontend;

use App\Entity\Archive;
use App\Entity\MenuLevel1;
use App\Entity\MenuLevel2;
use App\Entity\Page;
use App\Enum\LocalesEnum;
use App\Repository\ArchiveRepository;
use App\Repository\ArtistRepository;
use App\Repository\PageRepository;
use App\Repository\SlideshowPageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Meilisearch\Bundle\SearchService;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Attribute\Route;

final class DefaultController extends AbstractController
{
    private const int HIGHLIGHTED_HOMEPAGE_ITEMS = 9;

    #[Route('/', name: 'front_app_homepage')]
    public function index(Request $request, SlideshowPageRepository $spr, PageRepository $pr, PaginatorInterface $pi): Response
    {
        $slides = $spr->getEnabledSortedByPositionAndName()->getQuery()->getResult();
        $highlightedPages = $pi->paginate(
            $pr->getHomepageHighlighted()->getQuery(),
            $request->query->getInt('page', 1),
            self::HIGHLIGHTED_HOMEPAGE_ITEMS,
            [
                'align' => 'center',
            ]
        );

        return $this->render(
            'frontend/homepage.html.twig',
            [
                'slides' => $slides,
                'highlighted_pages' => $highlightedPages,
            ]
        );
    }

    #[Route('/search', name: 'front_app_search')]
    public function search(Request $request, EntityManagerInterface $entityManager, SearchService $searchService): Response
    {
        return $this->render(
            'frontend/partials/full_text_search_results.html.twig',
            [
                'pages' => $searchService->search($entityManager, Page::class, $request->query->get('q')),
            ]
        );
    }

    #[Route('/json-search-results/', name: 'front_app_json_search_results')]
    public function jsonSearchResults(Request $request, EntityManagerInterface $entityManager, SearchService $searchService): JsonResponse
    {
        $result = [];
        $result['results'] = [
            /*[
                'value' => '1',
                'text' => 'Pizza',
            ],
            [
                'value' => '2',
                'text' => $request->query->get('query') ?: '---',
            ],
            [
                'value' => '3',
                'text' => 'Banana',
            ],*/
        ];
        if (strlen((string) $request->query->get('query')) > 3) {
            $pagesObtained = $searchService->search($entityManager, Page::class, $request->query->get('query'));
            foreach ($pagesObtained as $index => $pageObtained) {
                $result['results'][] = [
                    'value' => $index + 1,
                    'text' => $pageObtained->getName(),
                ];
            }
        }

        return JsonResponse::fromJsonString(json_encode($result));
    }

    #[Route(path: [
        LocalesEnum::CA => '/canviar-a-idioma/{locale}',
        LocalesEnum::ES => '/cambiar-idioma/{locale}',
    ], name: 'front_app_language_switcher')]
    public function languageSwitcher(Request $request, string $locale): Response
    {
        $request->getSession()->set('_locale', $locale);

        return $this->redirectToRoute('front_app_homepage', ['_locale' => $locale]);
    }

    #[Route('/{menu}', name: 'front_app_menu_level_1')]
    public function menuLevel1(
        #[MapEntity(mapping: ['menu' => 'slug'])] MenuLevel1 $menu,
        ArchiveRepository $ar,
        KernelInterface $kernel
    ): Response {
        if (!$menu->getPage() && $menu->getMenuLevel2items() && !$menu->getMenuLevel2items()->isEmpty()) {
            $firstSubmenu = $menu->getMenuLevel2items()[0];

            return $this->redirectToRoute('front_app_menu_level_2', [
                'menu' => $menu->getSlug(),
                'submenu' => $firstSubmenu->getSlug(),
            ]);
        }
        if ($menu->isArchive()) {
            $archives = $ar->getEnabledSortedByYear()->getQuery()->getResult();
            if (count($archives) > 0) {
                /** @var Archive $last */
                $last = $archives[0];

                return $this->redirectToRoute('front_app_archive_year_list', [
                    'menu' => $menu->getSlug(),
                    'year' => $last->getYear(),
                ]);
            }

            return $this->render(
                'frontend/archive/archives.html.twig',
                [
                    'menu' => $menu,
                    'archives' => $archives,
                    'show_debug_page_info' => $kernel->isDebug(),
                ]
            );
        }

        return $this->render(
            'frontend/menu_level_1.html.twig',
            [
                'menu' => $menu,
                'show_debug_page_info' => $kernel->isDebug(),
            ]
        );
    }

    #[Route('/{menu}/{submenu}', name: 'front_app_menu_level_2')]
    public function menuLevel2(
        #[MapEntity(mapping: ['menu' => 'slug'])] MenuLevel1 $menu,
        #[MapEntity(expr: 'repository.getByMenuAndSubmenuSlugs(menu, submenu)')] MenuLevel2 $submenu,
        ArtistRepository $ar,
        PageRepository $pr,
        KernelInterface $kernel,
        int $idPageIrradiador
    ): Response {
        if ($submenu->getPage() && $idPageIrradiador === $submenu->getPage()->getId()) {
            $artists = $ar->getEnabledSortedByName()->getQuery()->getResult();

            return $this->render(
                'frontend/artist/artists.html.twig',
                [
                    'menu' => $menu,
                    'submenu' => $submenu,
                    'page' => $submenu->getPage(),
                    'artists' => $artists,
                    'show_debug_page_info' => $kernel->isDebug(),
                    'is_irradiador' => true,
                ]
            );
        }
        if (!$submenu->getPage()) {
            $pages = $pr->getActiveItemsFromMenuLevel2SortedByPublishDate($submenu)->getQuery()->getResult();

            return $this->render(
                'frontend/menu_level_2_pages_list.html.twig',
                [
                    'menu' => $menu,
                    'submenu' => $submenu,
                    'pages' => $pages,
                    'show_debug_page_info' => $kernel->isDebug(),
                    'is_irradiador' => false,
                ]
            );
        }

        return $this->render(
            'frontend/menu_level_2.html.twig',
            [
                'menu' => $menu,
                'submenu' => $submenu,
                'show_debug_page_info' => $kernel->isDebug(),
                'is_irradiador' => false,
            ]
        );
    }

    #[Route('/{menu}/{submenu}/{date}/{page}', name: 'front_app_page_detail')]
    public function pageDetail(
        #[MapEntity(mapping: ['menu' => 'slug'])] MenuLevel1 $menu,
        #[MapEntity(expr: 'repository.getByMenuAndSubmenuSlugs(menu, submenu)')] MenuLevel2 $submenu,
        #[MapEntity(expr: 'repository.getByDateAndSlug(date, page)')] Page $page,
        KernelInterface $kernel
    ): Response {
        return $this->render(
            'frontend/page_detail.html.twig',
            [
                'menu' => $menu,
                'submenu' => $submenu,
                'page' => $page,
                'show_debug_page_info' => $kernel->isDebug(),
            ]
        );
    }
}
