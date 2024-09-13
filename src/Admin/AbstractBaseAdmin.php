<?php

namespace App\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Route\RouteCollectionInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;

abstract class AbstractBaseAdmin extends AbstractAdmin
{
    protected EntityManagerInterface $em;
    protected Security $ss;

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }

    public function setEntityManager(EntityManagerInterface $em): self
    {
        $this->em = $em;

        return $this;
    }

    public function getSecurityHelper(): Security
    {
        return $this->ss;
    }

    public function setSecurityHelper(Security $ss): self
    {
        $this->ss = $ss;

        return $this;
    }

    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        parent::configureRoutes($collection);
        $collection
            ->remove('show')
            ->remove('delete')
            ->remove('batch')
        ;
    }

    public function getExportFormats(): array
    {
        return [
            'csv',
            'xls',
        ];
    }

    protected function checkUserHasRole(string $role): bool
    {
        try {
            return $this->ss->isGranted($role);
        } catch (AuthenticationCredentialsNotFoundException $e) {
            return false;
        }
    }

    protected function hasLoggedUser(): bool
    {
        return (bool) $this->ss->getUser();
    }

    protected function getDefaultFormBoxArray(string $bootstrapGrid = 'md', string $bootstrapSize = '6', string $boxClass = 'primary'): array
    {
        return [
            'class' => 'col-'.$bootstrapGrid.'-'.$bootstrapSize,
            'box_class' => 'box box-'.$boxClass,
        ];
    }

    protected function getFormMdSuccessBoxArray(int $bootstrapColSize = 6): array
    {
        return $this->getDefaultFormBoxArray('md', (string) $bootstrapColSize, 'success');
    }

    protected function getShowMdInfoBoxArray(int $bootstrapColSize = 6, string $boxClass = 'info'): array
    {
        return [
            'class' => 'col-md-'.$bootstrapColSize,
            'box_class' => 'box box-'.$boxClass,
        ];
    }

    protected function isFormToCreateNewRecord(): bool
    {
        return !$this->id($this->getSubject());
    }

    protected function isChildForm(): bool
    {
        return $this->hasParentFieldDescription();
    }

    /*protected function getQuillOptions(): array
    {
        return [
            QuillGroup::build(
                new BoldField(),
                new ItalicField(),
                new UnderlineField(),
                new StrikeField(),
            ),
            QuillGroup::build(
                new AlignField(
                    AlignField::ALIGN_FIELD_OPTION_LEFT,
                    AlignField::ALIGN_FIELD_OPTION_CENTER,
                    AlignField::ALIGN_FIELD_OPTION_RIGHT,
                    AlignField::ALIGN_FIELD_OPTION_JUSTIFY,
                ),
            ),
            QuillGroup::build(
                new ScriptField(ScriptField::SCRIPT_FIELD_OPTION_SUB),
                new ScriptField(ScriptField::SCRIPT_FIELD_OPTION_SUPER),
            ),
            QuillGroup::build(
                new ListField(ListField::LIST_FIELD_OPTION_BULLET),
                new ListField(ListField::LIST_FIELD_OPTION_ORDERED),
                new IndentField(IndentField::INDENT_FIELD_OPTION_MINUS),
                new IndentField(IndentField::INDENT_FIELD_OPTION_PLUS),
            ),
            QuillGroup::build(
                new LinkField(),
            ),
        ];
    }

    protected function getReducedQuillOptions(): array
    {
        return [
            QuillGroup::build(
                new BoldField(),
                new ItalicField(),
                new UnderlineField(),
                new StrikeField(),
            ),
            QuillGroup::build(
                new LinkField(),
            ),
        ];
    }*/
}
