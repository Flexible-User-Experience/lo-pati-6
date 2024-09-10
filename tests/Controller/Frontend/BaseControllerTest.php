<?php

namespace App\Tests\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class BaseControllerTest extends WebTestCase
{
    /**
     * @dataProvider provideUrls
     */
    public static function testSuccessfulPages(string $url): void
    {
        $client = static::createClient();
        $client->request('GET', $url);
        self::assertResponseIsSuccessful();
    }

    public static function provideUrls(): array
    {
        return [
            ['/sitemap/sitemap.default.xml'],
            ['/'],
            ['/menu-1/submenu-1-1'],
            ['/menu-1/submenu-1-2'],
            ['/menu-2/submenu-2-1'],
            ['/menu-2/submenu-2-2'],
            ['/menu-1/submenu-1-1/01-08-2021/page-1'],
            ['/archive/any/2020'],
            ['/politica-de-galetes'],
            ['/politica-de-privacitat'],
            ['/accessibilitat'],
            ['/es/'],
            ['/es/menu-1/submenu-1-1'],
            ['/es/menu-1/submenu-1-2'],
            ['/es/menu-2/submenu-2-1'],
            ['/es/menu-2/submenu-2-2'],
            ['/es/menu-1/submenu-1-1/01-08-2021/page-1'],
            ['/es/politica-de-cookies'],
            ['/es/politica-de-privacidad'],
            ['/es/accesibilidad'],
            ['/es/archive/ano/2020'],
        ];
    }

    /**
     * @dataProvider provideNotFoundUrls
     */
    public static function testNotFoundPages(string $url): void
    {
        $client = static::createClient();
        $client->request('GET', $url);
        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public static function provideNotFoundUrls(): array
    {
        return [
            ['/not-found-page'],
            ['/not-found-page/inside'],
            ['/menu-1/submenu-1-3'],
            ['/menu-3'],
        ];
    }

    /**
     * @dataProvider provideRedirectUrls
     */
    public static function testRedirectPages(string $url): void
    {
        $client = static::createClient();
        $client->request('GET', $url);
        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public static function provideRedirectUrls(): array
    {
        return [
            ['/menu-1'],
            ['/menu-2'],
            ['/es/menu-1'],
            ['/es/menu-2'],
            ['/archive'],
            ['/es/archive'],
        ];
    }
}
