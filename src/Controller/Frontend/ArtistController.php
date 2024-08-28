<?php

namespace App\Controller\Frontend;

use App\Entity\Artist;
use App\Entity\MenuLevel1;
use App\Entity\MenuLevel2;
use App\Enum\LocalesEnum;
use App\Repository\ArtistRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Attribute\Route;

final class ArtistController extends AbstractController
{
    #[Route(path: [
        LocalesEnum::CA => '/{menu}/{submenu}/artista/{slug}',
        LocalesEnum::ES => '/{menu}/{submenu}/artista/{slug}',
    ], name: 'front_app_artist_detail')]
    public function artistDetail(
        #[MapEntity(mapping: ['menu' => 'slug'])] MenuLevel1 $menu,
        #[MapEntity(expr: 'repository.getByMenuAndSubmenuSlugs(menu, submenu)')] MenuLevel2 $submenu,
        string $slug,
        ArtistRepository $ar,
        KernelInterface $kernel
    ): Response
    {
        $artists = $ar->getEnabledSortedByName()->getQuery()->getResult();
        $found = false;
        /** @var Artist $artist */
        foreach ($artists as $artist) {
            if ($artist->getSlug() === $slug) {
                $found = true;
                break;
            }
        }
        if (!$found) {
            $this->createNotFoundException();
        }

        return $this->render(
            'frontend/artist/artist_detail.html.twig',
            [
                'menu' => $menu,
                'submenu' => $submenu,
                'artists' => $artists,
                'artist' => $artist,
                'show_debug_page_info' => $kernel->isDebug(),
            ]
        );
    }
}
