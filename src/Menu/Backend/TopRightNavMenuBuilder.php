<?php

namespace App\Menu\Backend;

use App\Entity\User;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class TopRightNavMenuBuilder
{
    public function __construct(
        private FactoryInterface $mf,
        private Security $ss
    ) {
    }

    public function createRightTopNavMenu(): ItemInterface
    {
        $username = '';
        $user = $this->ss->getUser();
        if ($user instanceof User) {
            $username = $user->getEmail();
        }
        $menu = $this->mf->createItem('topnav');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');
        $menu
            ->addChild(
                'homepage',
                [
                    'label' => '<i class="fas fa-link fa-fw"></i>',
                    'route' => 'front_app_homepage',
                ]
            )
            ->setExtras(
                [
                    'safe_label' => true,
                ]
            )
        ;

        if ($username) {
            $menu
                ->addChild(
                    'username',
                    [
                        'label' => sprintf('<i class="far fa-user fa-fw margin-r-5"></i> %s', $username),
                        'uri' => '#',
                    ]
                )
                ->setExtras(
                    [
                        'safe_label' => true,
                    ]
                )
            ;
        }
        $menu
            ->addChild(
                'logout',
                [
                    'label' => '<i class="fa fa-power-off fa-fw"></i>',
                    'route' => 'admin_app_logout',
                ]
            )
            ->setExtras(
                [
                    'safe_label' => true,
                ]
            )
        ;

        return $menu;
    }
}
