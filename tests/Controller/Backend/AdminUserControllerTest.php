<?php

namespace App\Tests\Controller\Backend;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminUserControllerTest extends WebTestCase
{
    public const string ADMIN_FIREWALL_CONTEXT = 'admin';
    private const string ADMIN_USER = 'user1@user.com';

    public static function testHomepage(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail(self::ADMIN_USER);
        $client->request(Request::METHOD_GET, '/admin/login');
        self::assertResponseIsSuccessful();
        $client->loginUser($testUser, self::ADMIN_FIREWALL_CONTEXT);
        foreach (self::provideSuccessfulUrls() as $url) {
            $client->request(Request::METHOD_GET, $url);
            self::assertResponseIsSuccessful();
        }
    }

    public static function provideSuccessfulUrls(): array
    {
        return [
            '/admin/dashboard',
            '/admin/app/menulevel1/list',
            '/admin/app/menulevel1/create',
            '/admin/app/menulevel1/1/edit',
            '/admin/app/menulevel2/list',
            '/admin/app/menulevel2/create',
            '/admin/app/menulevel2/1/edit',
            '/admin/app/slideshowpage/list',
            '/admin/app/slideshowpage/create',
            '/admin/app/slideshowpage/1/edit',
            '/admin/app/slideshowpage/1/delete',
            '/admin/app/page/list',
            '/admin/app/page/create',
            '/admin/app/page/1/edit',
            '/admin/app/page/1/delete',
            '/admin/app/newslettergroup/list',
            '/admin/app/newslettergroup/create',
            '/admin/app/newslettergroup/1/edit',
            '/admin/app/newslettergroup/1/delete',
            '/admin/app/newsletteruser/list',
            '/admin/app/newsletteruser/create',
            '/admin/app/newsletteruser/1/edit',
            '/admin/app/newsletteruser/1/delete',
            '/admin/app/newsletter/list',
            '/admin/app/newsletter/create',
            '/admin/app/newsletter/1/edit',
            '/admin/app/newsletter/1/delete',
            '/admin/app/newsletterpost/list',
            '/admin/app/newsletter/create',
            '/admin/app/newsletterpost/1/edit',
            '/admin/app/newsletterpost/1/delete',
            '/admin/app/artist/list',
            '/admin/app/artist/create',
            '/admin/app/artist/1/edit',
            '/admin/app/artist/1/delete',
            '/admin/app/archive/list',
            '/admin/app/archive/create',
            '/admin/app/archive/1/edit',
            '/admin/app/visitinghours/list',
            '/admin/app/visitinghours/1/edit',
            '/admin/app/configcalendarworkingday/list',
        ];
    }

    public static function testNotFoundPages(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail(self::ADMIN_USER);
        $client->loginUser($testUser, self::ADMIN_FIREWALL_CONTEXT);
        foreach (self::provideNotFoundUrls() as $url) {
            $client->request(Request::METHOD_GET, $url);
            self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        }
    }

    public static function provideNotFoundUrls(): array
    {
        return [
            '/admin/app/menulevel1/9/edit',
            '/admin/app/menulevel1/1/show',
            '/admin/app/menulevel1/1/delete',
            '/admin/app/menulevel2/9/edit',
            '/admin/app/menulevel2/1/show',
            '/admin/app/menulevel2/1/delete',
            '/admin/app/slideshowpage/9/edit',
            '/admin/app/slideshowpage/1/show',
            '/admin/app/page/9/edit',
            '/admin/app/page/1/show',
            '/admin/app/newslettergroup/9/edit',
            '/admin/app/newslettergroup/1/show',
            '/admin/app/newsletteruser/9/edit',
            '/admin/app/newsletteruser/1/show',
            '/admin/app/newsletter/9/edit',
            '/admin/app/newsletter/1/show',
            '/admin/app/newsletterpost/9/edit',
            '/admin/app/newsletterpost/1/show',
            '/admin/app/artist/9/edit',
            '/admin/app/artist/1/show',
            '/admin/app/archive/9/edit',
            '/admin/app/archive/1/show',
            '/admin/app/archive/1/delete',
            '/admin/app/visitinghours/create',
            '/admin/app/visitinghours/9/edit',
            '/admin/app/visitinghours/1/show',
            '/admin/app/visitinghours/1/delete',
            '/admin/app/configcalendarworkingday/create',
            '/admin/app/configcalendarworkingday/9/edit',
            '/admin/app/configcalendarworkingday/1/show',
            '/admin/app/configcalendarworkingday/1/delete',
            '/admin/app/user/9/edit',
            '/admin/app/user/1/show',
            '/admin/app/user/1/delete',
        ];
    }

    public static function testForbiddenPages(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail(self::ADMIN_USER);
        $client->loginUser($testUser, self::ADMIN_FIREWALL_CONTEXT);
        foreach (self::provideForbiddenUrls() as $url) {
            $client->request(Request::METHOD_GET, $url);
            self::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
        }
    }

    public static function provideForbiddenUrls(): array
    {
        return [
            '/admin/app/user/list',
            '/admin/app/user/create',
            '/admin/app/user/1/edit',
        ];
    }
}
