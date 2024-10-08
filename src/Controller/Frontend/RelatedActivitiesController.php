<?php

namespace App\Controller\Frontend;

use App\Repository\PageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RelatedActivitiesController extends AbstractController
{
    #[Route('/related-activities/page/{id}', name: 'front_app_related_activities_by_page', priority: 10)]
    public function relatedActivitiesByPage(int $id, PageRepository $pr): Response
    {
        $page = $pr->find($id);
        if (!$page) {
            throw $this->createNotFoundException();
        }

        return $this->render(
            'frontend/related_activities/by_page.html.twig',
            [
                'related_activities' => $pr->getActiveItemsRelatedByMenuLevel2OrMenuLeve1SortedByPublishDate($page)->getQuery()->getResult(),
                'show_related_activities_if_there_are_no_related_previous_editions' => 0 === count($page->getPreviousEditions()),
            ]
        );
    }

    #[Route('/previous-editions/page/{id}', name: 'front_app_previous_editions_by_page', priority: 10)]
    public function previousEditionsByPage(int $id, PageRepository $pr): Response
    {
        $page = $pr->find($id);
        if (!$page) {
            throw $this->createNotFoundException();
        }

        return $this->render(
            'frontend/related_activities/previous_editions.html.twig',
            [
                'previous_editions' => $page->getPreviousEditions(),
            ]
        );
    }
}
