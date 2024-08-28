<?php

namespace App\Controller\Frontend;

use App\Entity\Archive;
use App\Entity\MenuLevel1;
use App\Entity\Page;
use App\Enum\LocalesEnum;
use App\Repository\ArchiveRepository;
use App\Repository\MenuLevel1Repository;
use App\Repository\PageRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Attribute\Route;

final class ArchiveController extends AbstractController
{
    #[Route(path: [
        LocalesEnum::CA => '/{menu}/any/{year}',
        LocalesEnum::ES => '/{menu}/ano/{year}',
    ], name: 'front_app_archive_year_list')]
    public function archiveYearList(
        #[MapEntity(mapping: ['menu' => 'slug'])] MenuLevel1 $menu,
        #[MapEntity(mapping: ['year' => 'slug'])] Archive $archive,
        ArchiveRepository $ar,
        PageRepository $pr,
        KernelInterface $kernel
    ): Response
    {
        return $this->render(
            'frontend/archive/archive_year_list.html.twig',
            [
                'menu' => $menu,
                'archives' => $ar->getEnabledSortedByYear()->getQuery()->getResult(),
                'archive' => $archive,
                'pages' => $pr->getActiveItemsFromArchive($archive)->getQuery()->getResult(),
                'show_debug_page_info' => $kernel->isDebug(),
            ]
        );
    }

    #[Route(path: [
        LocalesEnum::CA => '/{menu}/any/{year}/pagina/{slug}/{id}',
        LocalesEnum::ES => '/{menu}/ano/{year}/pagina/{slug}/{id}',
    ], name: 'front_app_archive_year_page_detail')]
    public function archiveYearPageDetail(
        #[MapEntity(mapping: ['menu' => 'slug'])] MenuLevel1 $menu,
        #[MapEntity(mapping: ['year' => 'year'])] Archive $archive,
        #[MapEntity(mapping: ['id' => 'id'])] Page $page,
        ArchiveRepository $ar,
        MenuLevel1Repository $ml1r,
        KernelInterface $kernel,
        int $idMenuArchive
    ): Response
    {
        return $this->render(
            'frontend/archive/archive_year_page_detail.html.twig',
            [
                'menu' => $menu,
                'menu_archive' => $ml1r->find($idMenuArchive),
                'archives' => $ar->getEnabledSortedByYear()->getQuery()->getResult(),
                'archive' => $archive,
                'page' => $page,
                'show_debug_page_info' => $kernel->isDebug(),
            ]
        );
    }
}
