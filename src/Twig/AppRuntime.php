<?php

namespace App\Twig;

use App\Entity\AbstractBase;
use App\Entity\Newsletter;
use App\Entity\NewsletterPost;
use App\Entity\Page;
use App\Entity\User;
use App\Enum\NewsletterStatusEnum;
use App\Enum\NewsletterTypeEnum;
use App\Enum\PageTemplateTypeEnum;
use App\Enum\UserRolesEnum;
use App\Kernel;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\RuntimeExtensionInterface;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

final class AppRuntime implements RuntimeExtensionInterface
{
    private UploaderHelper $vuh;
    private CacheManager $lcm;
    private ParameterBagInterface $pb;
    private TranslatorInterface $ts;

    public function __construct(UploaderHelper $vuh, CacheManager $lcm, ParameterBagInterface $pb, TranslatorInterface $ts)
    {
        $this->vuh = $vuh;
        $this->lcm = $lcm;
        $this->pb = $pb;
        $this->ts = $ts;
    }

    // Tests
    public function isInstanceOf($var, $instance): bool
    {
        return (new \ReflectionClass($instance))->isInstance($var);
    }

    // Functions
    public function hasHighlightedImage(Page $page): bool
    {
        return ($page->getSmallImage1FileName() && '' !== $page->getSmallImage1FileName()) || ($page->getImageFileName() && '' !== $page->getImageFileName());
    }

    public function isHighlightedImageSquared(Page $page): bool
    {
        $fieldName = 'imageFile';
        $isSquared = false;
        if ($page->getSmallImage1FileName()) {
            $fieldName = 'smallImage1File';
        }
        $imageFile = $this->vuh->asset($page, $fieldName, Page::class);
        [$width, $height] = getimagesize($this->getPublicProjectDir().$imageFile);
        if ($width > 0 && $height > 0 && $width === $height) {
            $isSquared = true;
        }

        return $isSquared;
    }

    public function getHighlightedImageFilter(Page $page): string
    {
        $fieldName = 'imageFile';
        $filter = '758x428';
        if ($page->getSmallImage1FileName()) {
            $fieldName = 'smallImage1File';
        }
        $imageFile = $this->vuh->asset($page, $fieldName, Page::class);
        try {
            [$width, $height] = getimagesize($this->getPublicProjectDir().$imageFile);
        } catch (\Exception) {
            dd($page->getId());
        }

        if ($width > 0 && $height > 0 && $width === $height) {
            $filter = '758x758_fixed';
        }

        return $this->lcm->getBrowserPath($imageFile, $filter);
    }

    public function getNewsletterPostHexColorString(NewsletterPost $post): string
    {
        $color = '#59F3C1';
        if (NewsletterTypeEnum::EVENTS === $post->getType()) {
            $color = '#25487D';
        } elseif (NewsletterTypeEnum::EXPOSITIONS === $post->getType()) {
            $color = '#FF004E';
        } elseif (NewsletterTypeEnum::RECOMMENDATIONS === $post->getType()) {
            $color = '#04E1FE';
        }

        return $color;
    }

    // Filters
    public function drawPageTemplateTypeHtmlSpan(Page $page): string
    {
        $class = 'default';
        if (PageTemplateTypeEnum::DEFAULT === $page->getTemplateType()) {
            $class = 'info';
        } elseif (PageTemplateTypeEnum::BLOG === $page->getTemplateType()) {
            $class = 'warning';
        } elseif (PageTemplateTypeEnum::INFO === $page->getTemplateType()) {
            $class = 'success';
        }

        return '<span class="label label-'.$class.'">'.$this->ts->trans($page->getTemplateTypeTransString()).'</span>';
    }

    public function drawNewsletterStatusHtmlSpan(Newsletter $newsletter): string
    {
        $class = 'default';
        $text = AbstractBase::DEFAULT_EMPTY_STRING;
        if (NewsletterStatusEnum::WAITING === $newsletter->getStatus()) {
            $class = 'info';
            $text = '<i class="fa fa-clock-o" style="margin-right:5px"></i>'.$this->ts->trans(NewsletterStatusEnum::getEnumArray()[$newsletter->getStatus()]);
        } elseif (NewsletterStatusEnum::SENDING === $newsletter->getStatus()) {
            $class = 'warning';
            $text = '<i class="fa fa-paper-plane-o" style="margin-right:5px"></i>'.$this->ts->trans(NewsletterStatusEnum::getEnumArray()[$newsletter->getStatus()]);
        } elseif (NewsletterStatusEnum::SENT === $newsletter->getStatus()) {
            $class = 'success';
            $text = '<i class="fa fa-check-square-o" style="margin-right:5px"></i>'.$this->ts->trans(NewsletterStatusEnum::getEnumArray()[$newsletter->getStatus()]);
        }

        return '<span class="label label-'.$class.'">'.$text.'</span>';
    }

    public function drawUserRolesHtmlSpan(User $user): string
    {
        $span = '';
        if (count($user->getRoles()) > 0) {
            $ea = UserRolesEnum::getEnumArray();
            /** @var string $role */
            foreach ($user->getRoles() as $role) {
                if (UserRolesEnum::ROLE_ADMIN === $role) {
                    $span .= '<span class="label label-info" style="margin-right:10px">'.$this->ts->trans($ea[UserRolesEnum::ROLE_ADMIN]).'</span>';
                } elseif (UserRolesEnum::ROLE_SUPER_ADMIN === $role) {
                    $span .= '<span class="label label-warning" style="margin-right:10px">'.$this->ts->trans($ea[UserRolesEnum::ROLE_SUPER_ADMIN]).'</span>';
                }
            }
        } else {
            $span = '<span class="label label-default" style="margin-right:10px">'.AbstractBase::DEFAULT_EMPTY_STRING.'</span>';
        }

        return $span;
    }

    public function integerNumberFormattedString(int $value): string
    {
        return number_format($value, 0, '\'', '.');
    }

    public function floatNumberFormattedString(float $value): string
    {
        return number_format($value, 2, '\'', '.');
    }

    private function getPublicProjectDir(): string
    {
        return sprintf('%s%s%s', $this->pb->get('kernel.project_dir'), DIRECTORY_SEPARATOR, Kernel::PUBLIC_DIR);
    }
}
