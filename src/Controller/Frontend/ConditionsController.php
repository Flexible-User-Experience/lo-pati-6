<?php

namespace App\Controller\Frontend;

use App\Enum\LocalesEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ConditionsController extends AbstractController
{
    #[Route(path: [
        LocalesEnum::CA => '/politica-de-privacitat',
        LocalesEnum::ES => '/politica-de-privacidad',
    ], name: 'front_app_privacy_policy')]
    public function privacyPolicy(): Response
    {
        return $this->render('frontend/terms/privacy_policy.html.twig');
    }

    #[Route(path: [
        LocalesEnum::CA => '/accessibilitat',
        LocalesEnum::ES => '/accesibilidad',
    ], name: 'front_app_accessibility_statement')]
    public function accessibilityStatement(): Response
    {
        return $this->render('frontend/terms/accessibility_statement.html.twig');
    }
}
