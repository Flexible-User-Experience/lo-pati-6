<?php

namespace App\Controller\Backend;

use App\Entity\NewsletterPost;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class NewsletterPostAdminController extends CRUDController
{
    /**
     * @param NewsletterPost $object
     */
    protected function redirectTo(Request $request, object $object): RedirectResponse
    {
        if (null !== $request->get('btn_update_and_list')) {
            return $this->redirectToEditNewsletterResponse($object);
        }
        if (null !== $request->get('btn_create_and_list')) {
            return $this->redirectToEditNewsletterResponse($object);
        }

        if (null !== $request->get('btn_create_and_create')) {
            $params = [];
            if ($this->admin->hasActiveSubClass()) {
                $params['subclass'] = $request->get('subclass');
            }

            return new RedirectResponse($this->admin->generateUrl('create', $params));
        }

        if (null !== $request->get('btn_delete')) {
            return $this->redirectToEditNewsletterResponse($object);
        }

        foreach (['edit', 'show'] as $route) {
            if ($this->admin->hasRoute($route) && $this->admin->hasAccess($route, $object)) {
                $url = $this->admin->generateObjectUrl(
                    $route,
                    $object,
                    $this->getSelectedTab($request)
                );

                return new RedirectResponse($url);
            }
        }

        return $this->redirectToEditNewsletterResponse($object);
    }

    private function redirectToEditNewsletterResponse(RouterInterface $router, NewsletterPost $post): RedirectResponse
    {
        $url = $router->generate('admin_app_newsletter_edit', [
            'id' => $post->getNewsletter()->getId(),
        ]);

        return new RedirectResponse($url);
    }
}
