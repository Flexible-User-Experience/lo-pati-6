<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class TrixFormType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefined(
                [
                    'trix_height',
                ]
            )
            ->setDefaults(
                [
                    'trix_height' => '400px',
                ]
            )
        ;
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        if (array_key_exists('trix_height', $options)) {
            $view->vars['trix_height'] = $options['trix_height'];
        }
    }

    public function getBlockPrefix(): string
    {
        return 'trix_form_type';
    }
}
