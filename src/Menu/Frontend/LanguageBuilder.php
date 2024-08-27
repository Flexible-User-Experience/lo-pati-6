<?php

namespace App\Menu\Frontend;

use App\Enum\LocalesEnum;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final readonly class LanguageBuilder
{
    public function __construct(
        private FactoryInterface $factory,
        private RequestStack $requestStack
    ) {}

    public function createLanguageMenu(): ItemInterface
    {
        $currentLocale = LocalesEnum::CA;
        if ($this->requestStack->getCurrentRequest()) {
            $currentLocale = $this->requestStack->getCurrentRequest()->getLocale();
        }
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'navbar-nav ms-auto me-5 h-100 language');
        if (LocalesEnum::CA === $currentLocale) {
            $catalan = $menu->addChild(
                LocalesEnum::CA,
                [
                    'label' => 'CAT',
                    'uri' => '#',
                ]
            );
            $catalan->setLinkAttribute('class', 'nav-link active disabled');
            $catalan->setLinkAttribute('aria-current', 'page');
            $catalan->setLinkAttribute('aria-disabled', 'true');
        } else {
            $catalan = $menu->addChild(
                LocalesEnum::CA,
                [
                    'label' => 'CAT',
                    'route' => 'front_app_language_switcher',
                    'routeParameters' => [
                        'locale' => LocalesEnum::CA,
                    ],
                ]
            );
            $catalan->setLinkAttribute('class', 'nav-link');
        }
        $catalan->setAttribute('class', 'nav-item');
        if (LocalesEnum::ES === $currentLocale) {
            $spanish = $menu->addChild(
                LocalesEnum::ES,
                [
                    'label' => 'ESP',
                    'uri' => '#',
                ]
            );
            $spanish->setLinkAttribute('class', 'nav-link active disabled');
            $spanish->setLinkAttribute('aria-current', 'page');
            $spanish->setLinkAttribute('aria-disabled', 'true');
        } else {
            $spanish = $menu->addChild(
                LocalesEnum::ES,
                [
                    'label' => 'ESP',
                    'route' => 'front_app_language_switcher',
                    'routeParameters' => [
                        'locale' => LocalesEnum::ES,
                    ],
                ]
            );
            $spanish->setLinkAttribute('class', 'nav-link');
        }
        $spanish->setAttribute('class', 'nav-item');

        return $menu;
    }
}
